<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Manager;
use App\Models\SewingLine;
use App\Models\StudentEnrollment;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if(LoginController::logado()){
        $dadosUsuario = Manager::find(Auth::id());
        $query = Student::query();
        if (!function_exists('truncate_name')) {
            function truncate_name($name)
            {
                $words = explode(' ', $name);
                if (count($words) > 3) {
                    return implode(' ', array_slice($words, 0, 3)) . '...';
                }
                return $name;
            }
        }
        $query->with('studentEnrollment');
        if(isset($request->nome) && !empty($request->nome)){
            $query->where('first_name','like','%'.$request->nome.'%')->orWhere('last_name','like','%'.$request->nome.'%');
        }
        if(isset($request->course_id) && !empty($request->course_id)){
            $query->whereHas('studentEnrollment', function ($q) use ($request) {
             $q->where('course_id', '=', $request->course_id);

            });
        }
        if(isset($request->semestre) && !empty($request->semestre)){
            $query->whereHas('studentEnrollment', function ($q) use ($request) {
             $q->where('semestre', '=', $request->semestre);

            });


        }
        if($dadosUsuario->nivel!='A'){

            $query->where('extension_id','=',$dadosUsuario->extension_id);
        }
       $query->with('studentEnrollment');
       $query->orderBy('id','desc');
        $enrollments = $query->get();
        $students = $query->get();
        $cursos = Course::all();
      return view('web.admin.Enrolment.list', compact('enrollments','dadosUsuario','cursos','students'));
      }else{
            return redirect()->route('login');
        }

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
        // dd($request);
        $student = Student::where('user_id', '=', auth()->user()->id)->first();
        $studentId=$student->id;

        $enrollment = StudentEnrollment::where('student_id', '=', $studentId)->first();

        $lastEnrollment = StudentEnrollment::where('student_id', '=', $studentId)->latest()->first();
        $studentFacultID = $enrollment->faculty_id;
        $studentCourseID = $enrollment->course_id;
        $studentSewingLineID = $enrollment->sewing_line_id;
        $studentExtensionID = $enrollment->extension_id;
        $studentAcademicLevelID = $enrollment->academic_level_id;
        $semestre = ($lastEnrollment->semestre) +1;
        $numeroDisciplinas=$request->number;
        $taxa = $request->taxa;
        $valor =($taxa*$numeroDisciplinas);
        // dd($valor);
        $newEnrollment = StudentEnrollment::create([
                'faculty_id' => $studentFacultID,
                'course_id' => $studentCourseID,
                'sewing_line_id' => $studentSewingLineID,
                'extension_id' => $studentExtensionID,
                'academic_level_id' => $studentAcademicLevelID,
                'student_id'=>$studentId,
                'semestre' => $semestre,
                'numero_disciplinas' => $numeroDisciplinas,
                'valor' => $valor,
                'taxa' => $taxa
            ]);
            // dd($newEnrollment);
         return redirect()->route('home');

    }
     public function matricular(Request $request, StudentEnrollment $enrollment)
    {
        // dd($request->all());

        $validatedDatas=$request->validate([
            'taxa_matricula'=>'required|numeric|min:4850|max:15000',
            'taxa_inscricao_disciplina'=>'required|numeric|min:1000|max:2650',
            'numero_disciplinas'=>'required|numeric|min:5|max:9',
            'primeira_propina_mensal'=>'nullable|numeric|min:8000|max:19000',
            'taxa_servico_semestrais'=>'required|numeric|min:1750|max:4000',
            'incluir_propina'=>'nullable|in:on,off',

        ]);
        $primeiraPropina=0;
        $incluirPropina=0;
        if($request->has('incluir_propina')){

            $incluirPropina= '1';
            $primeiraPropina= $validatedDatas['primeira_propina_mensal']!=null?$validatedDatas['primeira_propina_mensal']:0;
        }

        $semestre = 1;
        $numeroDisciplinas=$validatedDatas['numero_disciplinas'];
        $taxa = $validatedDatas['taxa_inscricao_disciplina'];
        $valor =($validatedDatas['taxa_matricula']+$validatedDatas['taxa_servico_semestrais']+($taxa*$numeroDisciplinas)+$primeiraPropina);
        // dd($valor);
        DB::beginTransaction();
        try {
            //code...
            $enrollmentU = $enrollment->update([
                'semestre' => $semestre,
                'numero_disciplinas' => $numeroDisciplinas,
                'valor' => $valor,
                'taxa' => $taxa,
                'enrollment_status'=>'1',
                'primeira_propina'=>$incluirPropina
            ]);
            // dd($enrollment);
            DB::commit();
         return back()->with(['success'=>'Matricula feita com sucesso!, Por favor baixe o pdf para obter informações para o pagamento!']);
        } catch (\Throwable $th) {
             DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(StudentEnrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentEnrollment $enrollment)
    {
        //
        if(LoginController::logado()){
        $dadosUsuario = Manager::find(Auth::id());
        $faculdades = Faculty::get();
        $linhasPesquisa = SewingLine::get();
        $cursos = Course::get();
        $estudantes = Student::get();
        $student = Student::find($enrollment->student_id);
        return view('web.admin.Enrolment.edit',compact(['student','dadosUsuario','faculdades','linhasPesquisa','cursos','estudantes','enrollment']));
        }else{
            return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentEnrollment $enrollment)
    {
        //
        DB::beginTransaction();
        try {
            $enrollment->update($request->all());
            return redirect()->route('enrollment-list')->with(['success'=>'Inscricao actualizada!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentEnrollment $enrollment)
    {
        //
        DB::beginTransaction();
        try {
            $enrollment->delete();
            DB::commit();
            return redirect()->route('enrollment-list')->with(['success'=>'Inscricao excluida com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }
    public function approve(StudentEnrollment $enrollment)
    {
        //
        // dd($enrollment);
        DB::beginTransaction();
        try {
            $enrollment->update(['enrollment_status'=>'2']);
            DB::commit();
            return redirect()->route('enrollment-list')->with(['success'=>'Inscrição aprovada com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }
}
