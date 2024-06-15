<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Course;
use App\Models\Gender;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
            $students = $query->with('studentEnrollment')->get();

        return view('web.admin.student.list',compact('students','dadosUsuario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($student_id)
    {
        $dadosUsuario = Manager::find(Auth::id());
        $student = Student::find($student_id);
        return view('web.admin.student.show',compact('dadosUsuario','student'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('web.admin.student.add');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($student_code = null)
    {
         if (isset($student_code) && !empty($student_code)) {
            $student = Student::with('studentEnrollment')->where('code', '=', $student_code)->get();
            $student =  $student[0];
            $courses = Course::paginate();
            $genders = Gender::paginate();

            return view('web.admin.student.edit',compact('student','courses','genders'));
        }else{
            return view('web.admin.student.list');

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
    }
}
