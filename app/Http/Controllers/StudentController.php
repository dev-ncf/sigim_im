<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Course;
use App\Models\Gender;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(LoginController::logado()){
        $dadosUsuario = Manager::find(Auth::id());
            $query = Student::query();
            if($request->has('student_code') && !empty($request->student_code)){
                $query->where('code','like','%'.$request->student_code.'%');

            }
            if($request->has('student_name')  && !empty($request->student_name)){
                $query->where('first_name','like','%'.$request->student_name.'%')->orWhere('last_name','like','%'.$request->student_name.'%');

            }
            if($request->has('student_email')){
                $query->where('email','like','%'.$request->student_email.'%');

            }
            if($dadosUsuario->nivel!='A'){
                $query->where('extension_id','=',$dadosUsuario->extension_id);
            }
            $students = $query->with('studentEnrollment')->get();

        return view('web.admin.student.list',compact('students','dadosUsuario'));
        }else{
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($student_id)
    {
        if(LoginController::logado()){
        $dadosUsuario = Manager::find(Auth::id());
        $student = Student::find($student_id);
        return view('web.admin.student.show',compact('dadosUsuario','student'));
        }else{
            return redirect()->route('login');
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(LoginController::logado()){
        return view('web.admin.student.add');
        }else{
            return redirect()->route('login');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($student_code = null)
    {
        if(LoginController::logado()){
        $dadosUsuario = Manager::find(Auth::id());
         if (isset($student_code) && !empty($student_code)) {
            $student = Student::with('studentEnrollment')->where('code', '=', $student_code)->first();

            $courses = Course::paginate();
            $genders = Gender::paginate();

            return view('web.admin.student.edit',compact('student','courses','genders','dadosUsuario'));
        }else{
            return view('web.admin.student.list');

        }
        }else{
            return redirect()->route('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            $student->delete();
            DB::commit();
            return redirect()->route('student-list')->with(['success'=>'Estudante excluido com sucesso!']);
        } catch (Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }
    public function activeDeactive(Student $student)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            if( $student->estado=='Activo'){
                $student->update(['estado'=>'Inactivo']);


            }else{

                $student->update(['estado'=>'Activo']);

            }

            DB::commit();
            return back()->with(['success'=>$student->estado=='Activo'?'Estudante '.$student->first_name.' fio activado com sucesso!':'Estudante '.$student->first_name.' foi desactivado com sucesso!']);
        } catch (Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }
    public function delete(Student $student)
    {
        //
    }
    public function updatePassword(Request $request, Student $student)
    {
        //
        // dd($student);
        DB::beginTransaction();
        try {
            //code...
            if($request->password == $request->confir_password){
                $dados['password']=bcrypt($request->password);
                $student->update($request->all());
                DB::commit();
                return back()->with(['success'=>'Senha actualizada com sucesso!']);
            }else{
                return back()->withErrors(['error'=>'Senhas não identicas!']);

            }
        } catch (Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors(['error'=>$th->getMessage()]);
        }
    }
}
