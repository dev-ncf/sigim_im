<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\AccountVerify;
use App\Models\Faculty;
use App\Models\Course;
use App\Models\Extension;
use App\Models\Province;
use App\Models\DocumentType;
use App\Models\Gender;
use App\Models\CivilStatus;
use App\Models\District;
use App\Models\AcademicLevel;
use App\Models\ScholarshipType;
use App\Models\CourseAnnouncementSource;
use App\Models\FormPayment;
use App\Models\Manager;
use App\Models\MovementStudent;
use App\Models\MovementStudentItem;
use App\Models\Student;
use App\Models\StudentCourseKnowledge;
use App\Models\StudentDocument;
use App\Models\StudentProfessionalCareer;
use App\Models\StudentScholarship;
use App\Models\StudentEnrollment;
use App\Models\EnrollmentPeriod;
use App\Models\StudentAddress;
use App\Models\PreviousSkill;
use App\Models\SewingLine;
use App\Models\Service;
use App\Support\Mail;
use Dompdf\Dompdf;

class WebController extends Controller
{
    private string $student_code;

    public function viewLogin()
    {
    	return view('web.auth.login');
    }

    public function auth(Request $request)
    {
    	$credential = [
    		'email' => $request->email,
    		'password' => $request->password
    	];

        //dd($request);

        //Verificando se E manager ou estudante
        $padrao = "/^[a-z0-9.\-\_]+@sigim.co.mz$/i";

        if (preg_match($padrao, $request->email)) {
            if (Auth::guard('manager')->attempt($credential)) {

                $request->session()->regenerate();
                return redirect()->route('home-manager');
            }else if (Auth::guard('admin')->attempt($credential)) {
                $request->session()->regenerate();
                return redirect()->route('home-admin');
            }

            return back()->withErrors([
                'message' => 'Credencias invalidas tenta novamente!'
            ]);
        } else {
            if (Auth::attempt($credential)) {
                $student = Student::where('user_id', '=', auth()->user()->id)->first();
                $request->session()->regenerate();

                if ($student) {
                    return redirect()->route('home');
                }else{
                    return redirect()->route('registration');
                }
            }

            return back()->withErrors([
                'message' => 'Credencias invalidas tenta novamente!'
            ]);
        }


    }

    public function viewRegister()
    {
    	return view('web.auth.register');
    }

    public function register(Request $request, User $user, AccountVerify $account_verify)
    {
        $result = $this->verifyPassword($request->password, $request->confPassword);

    	//$hash = base64_encode(base64_encode($request->email));
    	//dd($hash, base64_decode(base64_decode($hash)));

    	if($result):
    		$code = $this->generateCodeEmailConfirm();
    		try{
                $new_user = $user->create([
                    'name' => $request->name,
    				'email' => $request->email,
    				'password' => Hash::make($request->password),
    			]);


    			$email = $request->email;

    			$account_verify->create([
    				'code' => $code,
    				'user_id' => $new_user->id
    			]);
                //Enviando um email com o codigo de confirmacao
                $response  = Mail::sendEmailConfirmationCode($new_user->email, $new_user->name, $code);

                //dd($response);

    			if ($response) {
                    return view('web.auth.confirm-email', compact('email'));
                }
    		}catch(\Exception $e){
    			dd($e->getMessage());
    		}
    	else:
    		//dd(false);
    	endif;
    }



    public function verifyPassword(string $password, string $conf_password):bool
    {
    	if ($password === $conf_password):
    		return true;
    	else:
    		return false;
    	endif;
    }


    public function verifyEmail(Request $request)
    {
    	$result_user = User::where('email', '=', $request->email)->first();

    	$result_code_verify = AccountVerify::where('user_id', '=', $result_user->id)->orderBy('id', 'desc')->first();

    	if($result_code_verify->code == $request->code):
    		//2023-04-25 19:29:46
    		$result_user->update([
    			'email_verified_at' => date('Y-m-d h:i:s')
    		]);
    		return response()->json(true);
    	else:
    		return response()->json(false);
    	endif;
    }



    //Gerador de codigo de confirmacao
    public function generateCodeEmailConfirm():int
    {
    	return rand(100000, 999999);
    }



    //Funcao para inicio de preinscricao
    public function viewForm()
    {
 		$name = auth()->user()->name;
 		$extensions = Extension::all();
        $provinces = Province::all();
        $document_types = DocumentType::all();
        $genders = Gender::All();
        $civil_statuses = CivilStatus::all();
        $academic_levels = AcademicLevel::all();
        $scholarship_modality = ScholarshipType::all();
        $course_annoucement_sources = CourseAnnouncementSource::all();
        $email = auth()->user()->email;

    	return view('web.student.registration', compact(['name', 'email','extensions', 'provinces', 'document_types', 'genders', 'civil_statuses', 'academic_levels', 'scholarship_modality', 'course_annoucement_sources']));
    }


    //Funcao para listar as faculdades na inscricao
    public function faculties(Request $request, Extension $extension){
    	$extension = $extension->with('faculties')->where('id', '=', $request->extension)->first();
    	return response()->json($extension->faculties);
    }

    //Funcao para listar os curso
    public function courses(Request $request, Course $course){
    	$courses = $course->where('faculty_id', '=', $request->faculty)->get();
    	return response()->json($courses);
    }


    //Buscando distritos do enderecos
    public function districts(Request $request){
        $districts = District::where('province_id', '=', $request->province)->get();
        return response()->json($districts);
    }

    public function sewingLines(Request $request, SewingLine $sewingLine)
    {
        return response()->json($sewingLine->where('course_id', '=', $request->course)->get());
    }


    //Cadastrar um estudante
    public function createStudent(Request $request, Student $student, StudentCourseKnowledge $studentCourseKnowledge, StudentDocument $studentDocument, StudentProfessionalCareer $studentProfessionalCareer, StudentScholarship $studentScholarship, StudentEnrollment $studentEnrollment, StudentAddress $studentAddress, PreviousSkill $previousSkill){

        //dd($request);
        $extension = Extension::find($request->student_enrollments['extension_id']);

        $code = $this->generateCodeStudent($extension->code);

        try{

            DB::beginTransaction();
            //extraindo as necessidades especias educativas
            $special_education_need = '';

            if (array_key_exists('special_education_need', $request->student)) {
                for ($i=0; $i < count($request->student['special_education_need']); $i++) {
                    $special_education_need = $special_education_need. $request->student['special_education_need'][$i];
                    if ($i < count($request->student['special_education_need']) - 1) {
                        $special_education_need = $special_education_need. ', ';
                    }else{
                        $special_education_need = $special_education_need. '.';
                    }
                }
            }

            //Fazendo Upload
            $bi = $request->file('bi')->store('public/bi');
            $nuit = $request->file('nuit')->store('public/nuit');
            $certificate = $request->file('certificate')->store('public/certificate');

            //criar estudante
            $new_student = $student->create([
                'code' => $code,
                'first_name' => $request->student['first_name'],
                'last_name' => $request->student['last_name'],
                'province_birth_id' => $request->student['province_birth_id'],
                'birth_local' => $request->student['birth_local'],
                'gender_id' => $request->student['gender_id'],
                'marital_status_id' => $request->student['marital_status_id'],
                'birth_date' => $request->student['birth_date'],
                'father_name' => $request->student['father_name'],
                'father_profession' => $request->student['father_profession'],
                'mother_name' => $request->student['mother_name'],
                'mother_profession' => $request->student['mother_profession'],
                'nationality' => $request->student['nationality'],
                'email' => $request->student['email'],
                'phone' => $request->student['phone'],
                'special_educational_need' => $special_education_need,
                'phone_secondary' => $request->student['phone_secondary'],
                'family_type' => $request->student['family_type'],
                'household' => $request->student['household'],
                "extension_id" => $request->student_enrollments['extension_id'],
                'user_id' => auth()->user()->id,
                'certificate_file' => str_replace('public/', '', $certificate),
                'id_file' => str_replace('public/', '', $bi),
                'nuit_file' => str_replace('public/', '', $nuit),
                'registration_status' => '1'

            ]);

            $new_student_course_knowledge = $studentCourseKnowledge->create([
                'ad_source' => $request->student_course_knowledge['ad_source'],
                'student_id' => $new_student->id
            ]);

            $new_student_document = $studentDocument->create([
                'document_type_id' => $request->student_documents['document_type_id'],
                'document_number' => $request->student_documents['document_number'],
                'issue_date' => $request->student_documents['issue_date'],
                'expiration_date' => $request->student_documents['expiration_date'],
                'issue_place' => $request->student_documents['issue_place'],
                'student_id' => $new_student->id
            ]);


            $new_student_professional_career = $studentProfessionalCareer->create([
                "institution" => $request->student_professional_careers['institution'],
                "start_year" => $request->student_professional_careers['start_year'],
                "completion_year" => $request->student_professional_careers['completion_year'],
                "role" => $request->student_professional_careers['role'],
                'student_id' => $new_student->id
            ]);

            $new_student_scholarship = $studentScholarship->create([
                "scholarship" => $request->student_scholarship['scholarship'],
                "institution" => $request->student_scholarship['institution'],
                "modality" => $request->student_scholarship['modality'],
                'student_id' => $new_student->id
            ]);


            $new_student_enrollment = $studentEnrollment->create([
                'academic_level_id' => 2,
                "faculty_id" => $request->student_enrollments['faculty_id'],
                "course_id" => $request->student_enrollments['course_id'],
                "extension_id" => $request->student_enrollments['extension_id'],
                "sewing_line_id" => $request->student_enrollments['sewing_line_id'],
                'student_id' => $new_student->id
            ]);

            $new_student_address = $studentAddress->create([
                "province_id" => $request->student_addresses['province_id'],
                "district_id" => $request->student_addresses['district_id'],
                "neighborhood" => $request->student_addresses['neighborhood'],
                "block" => $request->student_addresses['block'],
                "house_number" => $request->student_addresses['house_number'],
                'student_id' => $new_student->id
            ]);

            $new_previous_skill = $previousSkill->create([
                "academic_level_id" => $request->previous_skills['academic_level_id'],
                "local" => $request->previous_skills['local'],
                "institution" => $request->previous_skills['institution'],
                "start_year" => $request->previous_skills['start_year'],
                "completion_year" => $request->previous_skills['completion_year'],
                'student_id' => $new_student->id
            ]);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(false);
        }

        DB::commit();
        return response()->json(true);
    }


    //gerando & verificando codigos
    private function generateCodeStudent(string $code_extension): string
    {
        $code = rand(1000, 9999);

        $new_code =  'M'.$code_extension. '.'. $code - date('s'). '.'. date('Y');

        return $new_code;
    }


    //Home de inscricao completa
    public function home(){
        $student = Student::with('studentEnrollment')->where('user_id', '=', auth()->user()->id)->first();
        $lastEnrollmentPeriod=EnrollmentPeriod::latest('end')->first();
        $lastEnrollment = StudentEnrollment::where('student_id','=',$student->studentEnrollment->student_id)->latest()->first();
        $movements = MovementStudent::where('student_id','=',$student->studentEnrollment->student_id,'and','semestre','=',$lastEnrollment->semestre)->latest()->get();
        // dd($movements->count());
        $enrollments = StudentEnrollment::where('student_id', '=', $student->studentEnrollment->student_id)->get();
        return view('web.student.home', compact('student','enrollments','lastEnrollment','lastEnrollmentPeriod','movements'));
    }

    //Exibir perfil
    public function perfil(){
        $student = Student::with(['studentEnrollment', 'document', 'gender', 'maritalStatus', 'address'])->where('user_id', '=', auth()->user()->id)->first();

        //dd($student->document->documentType);
        return view('web.student.perfil', compact('student'));
    }


    public function passwordUpdate(Request $request, User $user){
        if ($request->new_password === $request->conf_password):
            $check_password =  Hash::check($request->password, auth()->user()->password);

            if ($check_password):
                $user = $user->find(auth()->user()->id);
                try{
                    $user->update([
                        'password' => Hash::make($request->new_password)
                    ]);
                }catch(\Exception $e){
                    //dd($e->getMessage());
                }
                return response()->json([
                    'update' => true,
                    'message' => 'Senha Alterada com sucesso!'
                ]);
            else:
                return response()->json([
                    'update' => false,
                    'message' => 'A senha digitada nao corresponde a conta!'
                ]);
            endif;
            //dd($check_password);
        else:
            return response()->json([
                'update' => false,
                'message' => 'As Senhas digitadas nao correspondem!'
            ]);
        endif;
    }


    public function contactUpdate(Request $request, Student $student)
    {
        $student = $student->where('user_id', '=', auth()->user()->id)->first();
        try{
            $student->update([
                'phone' => $request->primary_phone,
                'phone_secondary' => $request->secondary_phone
            ]);
            return response()->json([
                'update' => true,
                'message' => 'Contactos atualizados com sucesso!'
            ]);
        }catch(\Exception $e){
            //dd($e->getMessage);
            return response()->json([
                'update' => false,
                'message' => 'Falha ao atualizar os contactos tenta mais tarde!'
            ]);
        }
    }


    /* Trabalhando com Setor do Registo Academico */
    public function homeManager($student_code = null)
    {
        if (isset($_GET['student_code']) && !empty($_GET['student_code'])) {
            $student = Student::where('code','=',$_GET['student_code'])->where('extension_id', '=', auth()->user()->extension_id)->first();
          
             $studentEnrollment = StudentEnrollment::with(['student'])->where('student_id','=',$student->id)->latest()->paginate(10);
            // dd($students);
        }else{
            $studentEnrollment = StudentEnrollment::with(['student'])->where('extension_id', '=', auth()->user()->extension_id)->latest()->paginate(10);
        }
        //  dd($studentEnrollment);

        return view('web.manager.home', compact('studentEnrollment'));
    }
    public function homeAdmin()
    {
        $students = Student::all();
        $managers  = Manager::all();
    //     $studentsByYear = Student::select(DB::raw('YEAR(updated_at) as ano'), 'gender_id', DB::raw('count(*) as total'))
    // ->groupBy('ano', 'gender_id')
    // ->get();


$studentsByYear = Student::select(DB::raw('YEAR(updated_at) as ano'), 'gender_id', DB::raw('count(*) as total'))
    ->groupBy('ano', 'gender_id')
    ->get();


        return view('web.admin.dashboard', compact('students','managers','studentsByYear'));
    }
    public function managerDashboard()
    {

        return view('web.admin.manager'/* , compact('students')*/);
    }
    public function studentDashboard()
    {

        return view('web.admin.student'/* , compact('students')*/);
    }

    public function perfilManager()
    {
        $manager = auth()->user();
        //dd($manager);
        return view('web.manager.perfil', compact('manager'));
    }

    //Atualizacao de Senha para os Manager
    public function passwordUpdateManager(Request $request, Manager $manager){
        if ($request->new_password === $request->conf_password):
            if (true):
                $user = $manager->find(auth()->user()->id);

                try{
                    $user->update([
                        'password' => Hash::make($request->new_password)
                    ]);
                }catch(\Exception $e){
                    //dd($e->getMessage());
                }
                return response()->json([
                    'update' => true,
                    'message' => 'Senha Alterada com sucesso!'
                ]);
            else:
                return response()->json([
                    'update' => false,
                    'message' => 'A senha digitada nao corresponde a conta!'
                ]);
            endif;
            //dd($check_password);
        else:
            return response()->json([
                'update' => false,
                'message' => 'As Senhas digitadas nao correspondem!'
            ]);
        endif;
    }

    //Metodo de renderizacao do estudante
    public function studentManager($code)
    {
        $student = Student::with(['studentEnrollment', 'movements'])->where('code', '=', $code)->first();
        $services = Service::get();
        $form_payments = FormPayment::get();
        $lastEnrollment  = StudentEnrollment::where('student_id','=',$student->id)->latest()->first();
        return view('web.manager.student', compact(['student', 'services', 'form_payments','lastEnrollment']));
    }


    //Movimento do estudante
    public function studentMovement(Request $request, MovementStudent $movementStudent, MovementStudentItem $movementStudentItem)
    {
        DB::beginTransaction();

        try {
            $total = 0;

            foreach ($request->items as $item) {
                $total = $total + $item['amount'];
            }

            $movement = $movementStudent->create([
                'code' => date('dmYHis'),
                'payment_id' => $request->payment_id,
                'receipt_number' => $request->receipt_number,
                'date_receipt' => $request->date_receipt,
                'total_amount' => $total,
                'student_id' => $request->student_id,
                'month' => $request->month,
                'year' => $request->year,
                'semestre' => $request->semestre,
                'status' => '2',
                'manager_id' => auth()->user()->id,
            ]);

            foreach ($request->items as $item) {
                $movementStudentItem->create([
                    'description' => $item['description'],
                    'amount' => $item['amount'],
                    'movement_id' => $movement->id
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['created' => false]);
        }
        DB::commit();
        return response()->json(['created' => true]);

    }

    //Aprovando o estudante
    public function studentAprovated(Request $request, StudentEnrollment $enrollment)
    {
       try {

            $enrollment->find($request->enrollment_id)->update([
                'enrollment_status' => '2'
            ]);
            return response()->json([
                'updated' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'updated' => false
            ]);
        }
    }
}
