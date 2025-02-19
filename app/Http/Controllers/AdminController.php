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
        if(LoginController::logado()){


        $dadosUsuario = Manager::find(Auth::id());
        $provincias = Province::get();
        $distritos = District::get();
        $gestores = Manager::get();
        $extensoes = Extension::get();
        $estadosCivil = CivilStatus::get();
        $documentTypes = DocumentType::get();

        return view('web.admin.student.add',compact('provincias','distritos','gestores','extensoes','dadosUsuario','estadosCivil','documentTypes'));
        }else{
            return redirect()->route('login');
        }
    }
    public function adminEstudanteStore(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|unique:users,email',

            ],
             [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este email já está em uso, escolha outro.',
            ]
        );
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

            if($request->hasFile('foto') && !empty($request->foto)){

                $foto = $request->file('foto')->store('public/foto');
                $dados['foto']=$foto;
            }
            if($request->hasFile('bi') && !empty($request->bi)){

                $bi = $request->file('bi')->store('public/bi');
                $dados['id_file']=$bi;
            }
            if($request->hasFile('nuit') && !empty($request->nuit)){

                $nuit = $request->file('nuit')->store('public/nuit');
                $dados['nuit_file']=$nuit;

            }

            if($request->hasFile('certificado') && !empty($request->certificado)){

                $certificate = $request->file('certificado')->store('public/certificate');
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
        if(LoginController::logado()){
        $dadosUsuario = Manager::find(Auth::id());
        $faculdades = Faculty::get();
        $linhasPesquisa = SewingLine::get();
        $cursos = Course::get();
        $estudantes = Student::get();
        return view('web.admin.Enrolment.add',compact('faculdades','linhasPesquisa','cursos','dadosUsuario','estudantes'));
        }else{
            return redirect()->route('login');
        }
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
        if(LoginController::logado()){
        $dadosUsuario = Manager::find(Auth::id());
        $faculdades = Faculty::get();
        $extensions = Extension::get();
        $cursos = Course::get();
        $documentTypes = DocumentType::get();
        return view('web.admin.manager.add',compact('documentTypes','extensions','dadosUsuario'));
        }else{
            return redirect()->route('login');
        }
    }

    public function AdminGestorStore(Request $request)
    {
       $request->validate([
    'first_name' => [
        'required',
        'string',
        'min:3',
        'max:255',
        'regex:/^[\pL\s\-]+$/u' // Permite letras e hífens
    ],
    'last_name' => [
        'required',
        'string',
        'min:3',
        'max:255',
        'regex:/^[A-Za-z]+$/' // Permite apenas letras, sem espaços
    ],
    'extension_id' => [
        'required',
        'integer',
        'exists:extensions,id' // Verifica se o ID existe na tabela 'extensions'
    ],
    'document_type_id' => [
        'required',
        'integer',
        'exists:document_types,id' // Verifica se o ID existe na tabela 'document_types'
    ],
    'document_number' => [
        'required',
        'string',
        'max:20',
        'regex:/^[A-Z0-9\-]+$/', // Permite letras maiúsculas, números e hífens
        'unique:student_documents,document_number' // Garante que o número do documento seja único
    ],
    'issue_place' => [
        'required',
        'string',
        'max:255'
    ],
    'issue_date' => [
        'required',
        'date',
        'before_or_equal:expiration_date' // A data de emissão deve ser anterior ou igual à data de expiração
    ],
    'expiration_date' => [
        'required',
        'date',
        'after_or_equal:issue_date' // A data de expiração deve ser posterior ou igual à data de emissão
    ],
    'phone' => [
        'required',
        'numeric',
        'regex:/^8\d{8}$/' // Deve começar com 8 e ter exatamente 9 dígitos
    ],
    'phone_secondary' => [
        'nullable',
        'numeric',
        'regex:/^8\d{8}$/' // Deve começar com 8 e ter exatamente 9 dígitos (opcional)
    ],
    'email' => [
        'required',
        'string',
        'email',
        'max:255',
        'unique:managers,email' // Garante que o e-mail seja único na tabela 'managers'
    ],
    'foto' => [
        'nullable',
        'image', // Garante que o arquivo seja uma imagem
        'mimes:jpeg,png,jpg,gif', // Tipos de imagem permitidos
        'max:5120' // Tamanho máximo da imagem em kilobytes (5 MB)
    ]
    ],
[
    'first_name.required' => 'O nome é obrigatório.',
    'first_name.string' => 'O nome deve ser uma string.',
    'first_name.min' => 'O nome não pode ter menos de 3 caracteres.',
    'first_name.max' => 'O nome não pode ter mais de 255 caracteres.',
    'first_name.regex' => 'O nome deve conter apenas letras e hífens.',

    'last_name.required' => 'O sobrenome é obrigatório.',
    'last_name.string' => 'O sobrenome deve ser uma string.',
    'last_name.min' => 'O nome não pode ter menos de 3 caracteres.',
    'last_name.max' => 'O sobrenome não pode ter mais de 255 caracteres.',
    'last_name.regex' => 'O sobrenome deve conter apenas letras, sem espaços, ou seja, único nome.',

    'extension_id.required' => 'O ID da extensão é obrigatório.',
    'extension_id.integer' => 'O ID da extensão deve ser um número inteiro.',
    'extension_id.exists' => 'O ID da extensão deve existir na tabela de extensões.',

    'document_type_id.required' => 'O ID do tipo de documento é obrigatório.',
    'document_type_id.integer' => 'O ID do tipo de documento deve ser um número inteiro.',
    'document_type_id.exists' => 'O ID do tipo de documento deve existir na tabela de tipos de documentos.',

    'document_number.required' => 'O número do documento é obrigatório.',
    'document_number.string' => 'O número do documento deve ser uma string.',
    'document_number.max' => 'O número do documento não pode ter mais de 20 caracteres.',
    'document_number.regex' => 'O número do documento deve conter apenas letras maiúsculas, números e hífens.',
    'document_number.unique' => 'O número do documento deve ser único.',

    'issue_place.required' => 'O local de emissão é obrigatório.',
    'issue_place.string' => 'O local de emissão deve ser uma string.',
    'issue_place.max' => 'O local de emissão não pode ter mais de 255 caracteres.',

    'issue_date.required' => 'A data de emissão é obrigatória.',
    'issue_date.date' => 'A data de emissão deve ser uma data válida.',
    'issue_date.before_or_equal' => 'A data de emissão deve ser anterior ou igual à data de expiração.',

    'expiration_date.required' => 'A data de expiração é obrigatória.',
    'expiration_date.date' => 'A data de expiração deve ser uma data válida.',
    'expiration_date.after_or_equal' => 'A data de expiração deve ser posterior ou igual à data de emissão.',

    'phone.required' => 'O número de telefone é obrigatório.',
    'phone.numeric' => 'O número de telefone deve ser um conjunto de só números.',
    'phone.regex' => 'O número de telefone deve começar com 8 e ter exatamente 9 dígitos.',

    'phone_secondary.nullable' => 'O número de telefone secundário é opcional.',
    'phone_secondary.numeric' => 'O número de telefone secundário deve ser um conjunto de só números..',
    'phone_secondary.regex' => 'Se fornecido, o número de telefone secundário deve começar com 8 e ter exatamente 9 dígitos.',

    'email.required' => 'O e-mail é obrigatório.',
    'email.string' => 'O e-mail deve ser uma string.',
    'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
    'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
    'email.unique' => 'O e-mail deve ser único.',

    'foto.nullable' => 'A foto é opcional.',
    'foto.image' => 'O arquivo deve ser uma imagem.',
    'foto.mimes' => 'A imagem deve ser nos formatos JPEG, PNG, JPG ou GIF.',
    'foto.max' => 'A imagem não pode ter mais de 5 MB.'
]);
        $dados = $request->all();
        $dados['password']=bcrypt('12345678');
        $dados['phone_secondary']='+258 '.$request->phone_secondary;
        // dd($dados);
        $gestor = Manager::where('first_name','like','%'.$request->first_name.'%')->Where('last_name','like','%'.$request->last_name.'%')->orWhere('email','like','%'.$request->email.'%')->first();
        if($gestor){
            return back()->withErrors(['error'=>'Gestor já registado']);
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
        if(LoginController::logado()){
        $dadosUsuario = Manager::find(Auth::id());
        $estudante = Student::find($student_id);
        $enrollment = StudentEnrollment::where('student_id','=',$student_id)->first();
        $extensions = Extension::get();
        $cursos = Course::get();
        $documentTypes = DocumentType::get();
        $servicos = MovementStudentItem::get();
        return view('web.admin.Movement.add',compact(['estudante','dadosUsuario','servicos','enrollment']));
        }else{
            return redirect()->route('login');
        }
    }
    public function AdminPropinaStore(Request $request)
    {
        $dados = $request->all();

        $dados['code']=date('dmYHms');
        $dados['payment_id']='1';
        $dados['status']='2';
        $dados['manager_id']=Auth::id();
        // dd($dados);
        $valor = null;
        $dadosUsuario = Manager::find(Auth::id());
        DB::beginTransaction();
        try {
             $mov = MovementStudent::create($dados);

                if($dados['taxa_matricula']==!null){
                    $valor =($dados['taxa_matricula']);
                    MovementStudentItem::create([
                        'description'=>'Taxa de Matrícula',
                        'amount'=>$valor,
                        'movement_id'=>$mov->id
                    ]);
                }
                if($dados['taxa_inscricao_disciplina']==!null){
                    $valor = ($dados['taxa_inscricao_disciplina']*$dados['numero_disciplinas']);
                    MovementStudentItem::create([
                        'description'=>'Taxa de Inscricao por disciplina',
                        'amount'=>$valor,
                        'movement_id'=>$mov->id
                    ]);
                }
                if($dados['propina_mensal']==!null){
                      $valor = ($dados['propina_mensal']);

                    MovementStudentItem::create([
                        'description'=>'Propina Mensal',
                        'amount'=>$valor,
                        'movement_id'=>$mov->id
                    ]);
                }
                if($dados['taxa_servicos_semestrais']==!null){
                    $valor = ($dados['taxa_servicos_semestrais']);
                    MovementStudentItem::create([
                        'description'=>'Taxa de Servicos Semestrais',
                        'amount'=>$valor,
                        'movement_id'=>$mov->id
                    ]);
                }



                DB::commit();
                return redirect()->back()->with(['success'=>'Movimento registado com sucesso!']);

        } catch (Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error'=>$th->getMessage()]);
            }
        }


}
