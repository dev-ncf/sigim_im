<?php

namespace App\Http\Controllers;

use App\Models\StudentEnrollment;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $enrollments = Student::with('studentEnrollment')->paginate(50);
      return view('web.admin.Enrolment.list', compact('enrollments'));

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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentEnrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentEnrollment $enrollment)
    {
        //
    }
}
