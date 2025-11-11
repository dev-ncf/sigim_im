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
use App\Models\Admin;
use App\Models\ScholarshipType;
use App\Models\CourseAnnouncementSource;
use App\Models\CourseSubjectNumber;
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
use Illuminate\Support\Facades\Session;

class WebController extends Controller
{
    private string $student_code;

    public function viewLogin()
    {
        if(LoginController::logado()){

            auth()->logout();
            request()->session()->invalidate();
        }

    	return view('web.auth.login');
    }
    public function passForm()
    {

    	return view('web.auth.senha');
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
                $user = Manager::find(Auth::guard('manager')->id());
                // dd($user->funcao);
                if($user->nivel=='A'){

                    return redirect()->route('home-admin');
                }
                return redirect()->route('home-admin');
            }else{
                 return back()->withErrors([
                'message' => 'Credencias invalidas tenta novamente!'
            ]);

            }
            // else if (Auth::guard('admin')->attempt($credential)) {
            //     $request->session()->regenerate();
            //     return redirect()->route('home-admin');
            // }


        } else {
            if (Auth::attempt($credential)) {
                $student = Student::where('user_id', '=', auth()->user()->id)->first();
                $request->session()->regenerate();

                if ($student) {

                        if($student->estado=='Activo'){

                            return redirect()->route('home');
                        }else{
                            return back()->withErrors([
                        'message' => 'O estudante está Inactivo!'
                    ]);

                        }


                }else{
                    return redirect()->route('registration');
                }
            }else{

                return back()->withErrors([
                    'message' => 'Credencias invalidas tenta novamente!'
                ]);
            }

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
 		// $name = auth()->user()->name;
 		$extensions = Extension::all();
 		$faculties = Faculty::all();
 		$courses = Course::all();
 		$sewinglines = SewingLine::all();
 		$districts = District::all();
        $provinces = Province::all();
        $document_types = DocumentType::all();
        $genders = Gender::All();
        $civil_statuses = CivilStatus::all();
        $academic_levels = AcademicLevel::all();
        $scholarship_modality = ScholarshipType::all();
        $course_annoucement_sources = CourseAnnouncementSource::all();
        // $email = auth()->user()->email;

    	return view('web.student.registration', compact(['extensions','faculties','districts','courses','sewinglines', 'provinces', 'document_types', 'genders', 'civil_statuses', 'academic_levels', 'scholarship_modality', 'course_annoucement_sources']));
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
        $validatedDatas = $request->validate([
    'name' => 'required|string|max:255',
    'extension_id' => 'required|integer|exists:extensions,id',
    'faculty_id' => 'required|integer|exists:faculties,id',
    'course_id' => 'required|integer|exists:courses,id',
    'last_name' => 'required|string|max:255',
    'first_name' => 'required|string|max:255',
    'father_name' => 'required|string|max:255',
    'mother_name' => 'required|string|max:255',
    'birth_date' => 'required|date|before:today',
    'province_birth_id' => 'required|integer|exists:provinces,id',
    'birth_local' => 'required|string|max:255',
    'nationality' => 'required|string|max:255',
    'document_type_id' => 'required|integer|exists:document_types,id',
    'document_number' => 'required|string|max:20|unique:student_documents,document_number',
    'place_issue' => 'required|string|max:255',
    'issue_date' => 'required|date',
    'expiration_date' => 'required|date|after:place_issue',
    'gender_id' => 'required|integer|in:1,2',
    'marital_status_id' => 'required|integer|in:1,2,3,4,5',
    'special_need' => 'required|integer',
    'special' => 'nullable|string|max:255',
    'province_id' => 'required|integer|exists:provinces,id',
    'district_id' => 'required|integer|exists:districts,id',
    'neighborhood' => 'required|string|max:255',
    'house_number' => 'nullable|string|max:10',
    'phone' => 'required|string|regex:/^8[2-9][0-9]{7}$/',
    'phone_secondary' => 'nullable|string|regex:/^8[2-9][0-9]{7}$/',
    'email' => 'required|email|max:255|unique:users,email',
    'senha' => 'required|string|min:8|max:16',
    'confir_senha' => 'required|string|min:8|max:16|same:senha',
    'academic_level_id' => 'required|integer|exists:academic_levels,id',
    'local' => 'required|string|max:255',
    'institution' => 'required|string|max:255',
    'start_year' => 'required|integer|min:1900|max:' . date('Y'),
    'end_year' => 'required|integer|min:1900|max:' . date('Y') . '|after_or_equal:start_year',
    'career_institution' => 'nullable|string|max:255',
    'career_start_year' => 'nullable|integer|min:1900|max:' . date('Y'),
    'completion_year' => 'nullable|integer|min:1900|max:' . date('Y').'|after_or_equal:career_start_year',
    'role' => 'nullable|string|max:255',
    'father_profession' => 'nullable|string|max:255',
    'mother_profession' => 'nullable|string|max:255',
    'family_type' => 'required|string|max:255',
    'household' => 'required|string|max:255',
    'block' => 'nullable|integer|min:1',
    'scholarship' => 'required|integer',
    'modality' => 'nullable|string|max:255',
    'modality_type' => 'nullable|string|max:255',
    'scholarship_institution' => 'nullable|string|max:255',
    'means_knowledge' => 'required|integer|in:1,2,3,4,5,6,7,8',
    'foto' => 'required|file|mimes:png,jpg,jpeg,JPG|max:2048',
    'cv' => 'required|file|mimes:pdf|max:2048',
    'declaracao_compromisso' => 'required|file|mimes:pdf|max:2048',
    'bi' => 'required|file|mimes:pdf|max:2048',
    'nuit' => 'required|file|mimes:pdf|max:2048',
    'certificate' => 'required|file|mimes:pdf|max:2048',
]);
    // dd($validatedDatas);

        $extension = Extension::find($validatedDatas['extension_id']);

        $code = $this->generateCodeStudent($extension->code);

        DB::beginTransaction();
        try{

            //extraindo as necessidades especias educativas
            // $special_education_need = '';

            // if (array_key_exists('special_education_need', $request->student)) {
            //     $special_education_need= $request->student['special_education_need'];
            //     return response()->json(['sms'=>$request->student['special_education_need']]);
            //     for ($i=0; $i < count($request->student['special_education_need']); $i++) {
            //         $special_education_need = $special_education_need. $request->student['special_education_need'][$i];
            //         if ($i < count($request->student['special_education_need']) - 1) {
            //             $special_education_need = $special_education_need. ', ';
            //         }else{
            //             $special_education_need = $special_education_need. '.';
            //         }
            //     }
            // }
            $special_education_need=null;

            if($validatedDatas['special_need']==1){
                $special_education_need = $validatedDatas['special'];

            }

            //Fazendo Upload
            $bi = $request->file('bi')->store('public/bi');
            $nuit = $request->file('nuit')->store('public/nuit');
            $certificate = $request->file('certificate')->store('public/certificate');
            $foto = $request->file('foto')->store('public/foto');
            $cv = $request->file('cv')->store('public/cv');
            $declaracao = $request->file('declaracao_compromisso')->store('public/declaracao');


            //criar usuario
            $new_user = User::create([
                'name'=>$validatedDatas['name'],
                'email'=>$validatedDatas['email'],
                'password'=>bcrypt($validatedDatas['senha']),
            ]);

            $manager = Manager::where('extension_id','=',$validatedDatas['extension_id'])->first();
            //criar estudante
            $new_student = $student->create([
                'code' => $code,
                'first_name' => $validatedDatas['first_name'],
                'last_name' => $validatedDatas['last_name'],
                'province_birth_id' => $validatedDatas['province_birth_id'],
                'birth_local' => $validatedDatas['birth_local'],
                'gender_id' => $validatedDatas['gender_id'],
                'marital_status_id' => $validatedDatas['marital_status_id'],
                'birth_date' => $validatedDatas['birth_date'],
                'father_name' => $validatedDatas['father_name'],
                'father_profession' => $validatedDatas['father_profession'],
                'mother_name' => $validatedDatas['mother_name'],
                'mother_profession' => $validatedDatas['mother_profession'],
                'nationality' => $validatedDatas['nationality'],
                'email' => $validatedDatas['email'],
                'phone' => $validatedDatas['phone'],
                'special_educational_need' => $special_education_need,
                'phone_secondary' => $validatedDatas['phone_secondary'],
                'family_type' => $validatedDatas['family_type'],
                'household' => $validatedDatas['household'],
                "extension_id" => $validatedDatas['extension_id'],
                'manager_response_id'=>$manager->id,
                'user_id' => $new_user->id,
                'certificate_file' => str_replace('public/', '', $certificate),
                'cv_file' => str_replace('public/', '', $cv),
                'foto_file' => str_replace('public/', '', $foto),
                'declaracao_file' => str_replace('public/', '', $declaracao),
                'id_file' => str_replace('public/', '', $bi),
                'nuit_file' => str_replace('public/', '', $nuit),
                'registration_status' => '2'

            ]);
            // dd($request->all());
            $new_student_course_knowledge = $studentCourseKnowledge->create([
                'ad_source' => $validatedDatas['means_knowledge'],
                'student_id' => $new_student->id
            ]);

            $new_student_document = $studentDocument->create([
                'document_type_id' => $validatedDatas['document_type_id'],
                'document_number' => $validatedDatas['document_number'],
                'issue_date' => $validatedDatas['issue_date'],
                'expiration_date' => $validatedDatas['expiration_date'],
                'issue_place' => $validatedDatas['place_issue'],
                'student_id' => $new_student->id
            ]);


            $new_student_professional_career = $studentProfessionalCareer->create([
                "institution" => $validatedDatas['career_institution'],
                "start_year" => $validatedDatas['career_start_year'],
                "completion_year" => $validatedDatas['completion_year'],
                "role" => $validatedDatas['role'],
                'student_id' => $new_student->id
            ]);

            $new_student_scholarship = $studentScholarship->create([
                "scholarship" => $validatedDatas['scholarship'],
                "institution" => $validatedDatas['scholarship_institution'],
                "modality" => $validatedDatas['modality'],
                'student_id' => $new_student->id
            ]);


            $new_student_enrollment = $studentEnrollment->create([
                'academic_level_id' => $validatedDatas['academic_level_id']+1,
                "faculty_id" => $validatedDatas['faculty_id'],
                "course_id" => $validatedDatas['course_id'],
                "extension_id" => $validatedDatas['extension_id'],
                // "sewing_line_id" => $validatedDatas['sewing_line_id'],
                'student_id' => $new_student->id,
                'enrollment_status'=>'0'
            ]);

            $new_student_address = $studentAddress->create([
                "province_id" => $validatedDatas['province_id'],
                "district_id" => $validatedDatas['district_id'],
                "neighborhood" => $validatedDatas['neighborhood'],
                "block" => $validatedDatas['block'],
                "house_number" => $validatedDatas['house_number'],
                'student_id' => $new_student->id
            ]);

            $new_previous_skill = $previousSkill->create([
                "academic_level_id" => $validatedDatas['academic_level_id'],
                "local" => $validatedDatas['local'],
                "institution" => $validatedDatas['institution'],
                "start_year" => $validatedDatas['start_year'],
                "completion_year" => $validatedDatas['end_year'],
                'student_id' => $new_student->id
            ]);
            DB::commit();
        return redirect()->route('login')->with(['success'=>'O seu cadastrado foi realizadocom sucesso! Por favor inicie sessão para prosseguir com a matricula!' ]);

        }catch(\Exception $e){
            DB::rollBack();
            return back()->withErrors(['error'=>$e->getMessage()]);
        }


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
        if(LoginController::logado()){
        $student = Student::with(['studentEnrollment','studentPreviousSkills'])->where('user_id', '=', auth()->user()->id)->first();
        $lastEnrollmentPeriod=EnrollmentPeriod::latest('end')->first();
        $lastEnrollment = StudentEnrollment::where('student_id','=',$student->id)->latest()->first();
        $courseSubjects = CourseSubjectNumber::all();

         $movements =null;
        if($lastEnrollment){

            $movements = MovementStudent::where('student_id','=',$student->id,'and','semestre','=',$lastEnrollment->semestre)->latest()->get();
        }
        // dd($lastEnrollment->id);
        $enrollments = StudentEnrollment::where('student_id', '=', $student->id)->get();
        return view('web.student.home', compact('student','enrollments','lastEnrollment','lastEnrollmentPeriod','movements','courseSubjects'));
        }else{
            return redirect()->route('login');
        }
    }

    //Exibir perfil
    public function perfil(){
         if(LoginController::logado()){
        $student = Student::with(['studentEnrollment', 'document', 'gender', 'maritalStatus', 'address'])->where('user_id', '=', auth()->user()->id)->first();

        //dd($student->document->documentType);
        return view('web.student.perfil', compact('student'));
         }else{
            return redirect()->route('login');
        }
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
        if(LoginController::logado()){
        if (isset($_GET['student_code']) && !empty($_GET['student_code'])) {
            $student = Student::where('code','=',$_GET['student_code'])->where('extension_id', '=', auth()->user()->extension_id)->first();
            if($student){

                $studentEnrollment = StudentEnrollment::with(['student'])->where('student_id','=',$student->id)->latest()->paginate(10);
            }else{
                $studentEnrollment = StudentEnrollment::with(['student'])->where('student_id','=','0')->latest()->paginate(10);
            }
            // dd($students);
        }else{
            $studentEnrollment = StudentEnrollment::with(['student'])->where('extension_id', '=', auth()->user()->extension_id)->latest()->paginate(10);
        }
        //  dd($studentEnrollment);

        return view('web.manager.home', compact('studentEnrollment'));
         }else{
            return redirect()->route('login');
        }
    }
    public function homeAdmin()
    {
        if(LoginController::logado()){
        $students = Student::all();
        $managers  = Manager::all();
        $faculties = Faculty::all();
        $courses = Course::all();
    $dadosUsuario = Manager::find(Auth::id());
    // dd($dadosUsuario);


$studentsByYear = Student::select(DB::raw('YEAR(updated_at) as ano'), 'gender_id', DB::raw('count(*) as total'))
    ->groupBy('ano', 'gender_id')
    ->get();


        return view('web.admin.dashboard', compact('students','managers','studentsByYear','dadosUsuario','courses','faculties'));
         }else{
            return redirect()->route('login');
        }
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
    public function logout()
{
    // Limpar os dados da middleware
    Session::flush();

    // Redirecionar para a rota de login
    return redirect()->route('login');
}
}
