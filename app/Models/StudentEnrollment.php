<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEnrollment extends Model
{
    use HasFactory;
    protected $fillable = [
    	'academic_level_id',
    	"faculty_id",
        "course_id",
        "extension_id",
        'sewing_line_id',
        'student_id',
        'semestre',
        'enrollment_status',
        'numero_disciplinas',
        'taxa',
        'valor'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    public function extension()
    {
        return $this->belongsTo(Extension::class);
    }

    public function sewingLine()
    {
        return $this->belongsTo(SewingLine::class);
    }
}
