<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Gender;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

            $students = Student::with('studentEnrollment')->paginate(50);

        return view('web.admin.student.list',compact('students'));
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
        return view('web.admin.student.add');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
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
