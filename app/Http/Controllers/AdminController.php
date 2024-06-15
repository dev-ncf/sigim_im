<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\CivilStatus;
use App\Models\Course;
use App\Models\District;
use App\Models\DocumentType;
use App\Models\Extension;
use App\Models\Faculty;
use App\Models\Manager;
use App\Models\MovementStudent;
use App\Models\MovementStudentItem;
use App\Models\Province;
use App\Models\SewingLine;
use App\Models\Student;
use App\Models\StudentAddress;
use App\Models\StudentDocument;
use App\Models\StudentEnrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\Builder\Stub;
use Throwable;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $manager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $manager)
    {
        //
    }
    public function adminEstudanteAdicionar()
    {
        $dadosUsuario = Manager::find(Auth::id());
        $provincias = Province::get();
        $distritos = District::get();
        $gestores = Manager::get();
        $extensoes = Extension::get();
        $estadosCivil = CivilStatus::get();
        $documentTypes = DocumentType::get();

        return view('web.admin.student.add',compact('provincias','distritos','gestores','extensoes','dadosUsuario','estadosCivil','documentTypes'));
    }
    public function adminEstudanteStore(Request $request)
    {
        DB::beginTransaction();
        $extension = Extension::find($request->extension_id);
        $code = $this->generateCodeStudent($extension->code);
        $findCode = Student::where('code','=',$code)->first();
        while ($findCode){
            $code = $this->generateCodeStudent($extension->code);
        }
        $foto = 'foto/';
        $bi = 'bi/';
        $nuit = 'nuit/';
        $certificate = 'certificate/';
        $dados = $request->all();
        $dados['password']=bcrypt('12345678');
        $dados['name']=$request->first_name.' '.$request->last_name;
        $dados['code']=$code;
        $dados['registration_status']='2';
        $dados['foto']=$foto;
        $dados['id_file']=$bi;
        $dados['nuit_file']=$nuit;
        $dados['certificate_file']=$certificate;
        // dd($dados);
        $estudante = Student::where('first_name','=',$request->first_name)->where('last_name','=',$request->last_name)->first();
        if($estudante){
            return redirect()->back()->withErrors(['error'=>'Estudante já Cadastrado!']);
        }

    try {
        $user = User::create($dados);
        $dados['user_id']=$user->id;

            if($request->has('foto') && !empty($request->foto)){

                $foto = $request->file('foto')->store('public/foto');
                $dados['foto']=$foto;
            }
            if($request->has('bi') && !empty($request->bi)){

                $bi = $request->file('bi')->store('public/bi');
                $dados['id_file']=$bi;
            }
            if($request->has('nuit') && !empty($request->nuit)){

                $nuit = $request->file('nuit')->store('public/nuit');
                $dados['nuit_file']=$nuit;

            }

            if($request->has('certificado') && !empty($request->certificado)){

                $certificate = $request->file('certificate')->store('public/certificate');
                $dados['certificate_file']=$certificate;
            }

            $estudante = Student::create($dados);
            if($estudante){
                $dados['student_id']=$estudante->id;
                StudentAddress::create($dados);
                StudentDocument::create($dados);
                DB::commit();
                return redirect()->route('student-list')->with(['success'=>'Estudante '.$estudante->first_name.', cadastrado(a) com sucesso e com Código = '.$estudante->code]);
            }

    } catch (Throwable $th) {
        DB::rollBack();
        // return redirect()->back()->withErrors(['error' => 'Algo deu errado na criação do usuario. Tente usar um email diferente']);
        return redirect()->back()->withErrors(['error' => $th->getMessage()]);
    }


    }
    private function generateCodeStudent(string $code_extension): string
    {
        $code = rand(1000, 9999);

        $new_code =  'M'.$code_extension. '.'. $code - date('s'). '.'. date('Y');

        return $new_code;
    }
    public function adminInscricaoAdicionar()
    {
        $dadosUsuario = Manager::find(Auth::id());
        $faculdades = Faculty::get();
        $linhasPesquisa = SewingLine::get();
        $cursos = Course::get();
        $estudantes = Student::get();
        return view('web.admin.Enrolment.add',compact('faculdades','linhasPesquisa','cursos','dadosUsuario','estudantes'));
    }

    public function adminInscricaoStore(Request $request)
    {
        $dados = $request->all();
        $estudante = Student::find($request->student_id);
        // dd($estudante);
        $enrollment = StudentEnrollment::where('student_id','=',$request->student_id)->where('semestre','=',$request->semestre)->first();
        if($enrollment){
            return redirect()->back()->withErrors(['error'=>'Estudante já inscrito nesse semestre!']);
        }
        $dados['academic_level_id']='2';
        $dados['enrollment_status']='2';
        $dados['extension_id']=$estudante->extension_id;
        $dados['valor']=$request->taxa*$request->numero_disciplinas;
        if($request->semestre==1){
            $dados['valor']=$request->taxa*$request->numero_disciplinas+1750;

        }
        DB::beginTransaction();

        try {

            $newEnrollment = StudentEnrollment::create($dados);
            if($newEnrollment){
                DB::commit();
                return redirect()->route('enrollment-list');
            }


        } catch (Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error'=>$th->getMessage()]);

        }
    }
    public function AdminGestorAdicionar()
    {
        $dadosUsuario = Manager::find(Auth::id());
        $faculdades = Faculty::get();
        $extensions = Extension::get();
        $cursos = Course::get();
        $documentTypes = DocumentType::get();
        return view('web.admin.manager.add',compact('documentTypes','extensions','dadosUsuario'));
    }

    public function AdminGestorStore(Request $request)
    {
        $dados = $request->all();
        $dados['password']=bcrypt('12345678');
        $dados['phone_secondary']='+258 '.$request->phone_secondary;
        // dd($dados);
        $gestor = Manager::where('first_name','like','%'.$request->first_name.'%')->Where('last_name','like','%'.$request->last_name.'%')->orWhere('email','like','%'.$request->email.'%')->first();
        if($gestor){
            return redirect()->back()->withErrors(['error'=>'Gestor já registado']);
        }

        DB::beginTransaction();

        try {

            $newManager = Manager::create($dados);
            if($newManager){
                DB::commit();
                return redirect()->route('manager-list');
            }


        } catch (Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error'=>$th->getMessage()]);

        }
    }
    public function AdminPropinaAdicionar($student_id)
    {
        $dadosUsuario = Manager::find(Auth::id());
        $estudante = Student::find($student_id);
        $extensions = Extension::get();
        $cursos = Course::get();
        $documentTypes = DocumentType::get();
        $servicos = MovementStudentItem::get();
        return view('web.admin.Movement.add',compact('estudante','dadosUsuario','servicos'));
    }
    public function AdminPropinaStore(Request $request)
    {
        $dados = $request->all();
        $dados['code']=date('dmYHms');
        $dados['payment_id']='1';
        $dados['status']='2';
        $dados['manager_id']=Auth::id();
        // dd($dados);
        $dadosUsuario = Manager::find(Auth::id());
        DB::beginTransaction();
        try {
            $mov = MovementStudent::create($dados);
            if($mov){
                DB::commit();
                return redirect()->back()->with(['success'=>'Propina adicionada com sucesso!']);
            }
        } catch (Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error'=>$th->getMessage()]);
            }
        }


}
