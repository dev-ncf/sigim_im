<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Faculty;
use App\Models\Manager;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private function dadosUsuario(){
        $dadosUsuario = Manager::find(Auth::id());
        return $dadosUsuario;
    }
    public function index(Request $request)
    {
        //
        if(LoginController::logado()){

        $dadosUsuario = Manager::find(Auth::id());
        $query = Course::query();
        // dd($courses);
        if(isset($request->nome) && !empty($request->nome)){
            $query->where('label','like','%'.$request->nome.'%');
        }
        if(isset($request->faculty_id) && !empty($request->faculty_id)){
            $query->where('faculty_id','=',$request->faculty_id);
        }
        $courses  = $query->get();
        $courses->load('faculty');
        $faculties = Faculty::all();

        return view('web.admin.Course.list',compact(['courses','dadosUsuario','faculties']));
        }else{
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(LoginController::logado()){
        //
         $dadosUsuario = Manager::find(Auth::id());
        $faculties = Faculty::all();
        // dd($courses);
        return view('web.admin.Course.add',compact(['dadosUsuario','faculties']));
        }else{
            return redirect()->route('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            Course::create($request->all());
            DB::commit();
            return back()->with(['success'=>'Curso registado com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
        if(LoginController::logado()){
        $dadosUsuario = $this->dadosUsuario();
         $students = StudentEnrollment::where('course_id','=',$course->id)->where('semestre','=','1')->get();
        //  dd($students);
         return view('web.admin.course.show',compact(['dadosUsuario','course','students']));
         }else{
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
         if(LoginController::logado()){
        $dadosUsuario = Manager::find(Auth::id());
        $faculties = Faculty::all();
        // dd($courses);
        return view('web.admin.Course.edit',compact(['dadosUsuario','faculties','course']));
        }else{
            return redirect()->route('login');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
         DB::beginTransaction();
        try {
            //code...
            $course->update([
                'faculty_id'=>$request->faculty_id,
                'label'=>$request->label
            ]);
            
            dd($request->all());
            DB::commit();
            return back()->with(['success'=>'Curso actualizado com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            $course->delete();
            DB::commit();
            return back()->with(['success'=>'Curso excluido com sucesso!']);
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }
}
