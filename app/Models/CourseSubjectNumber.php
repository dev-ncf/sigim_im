<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSubjectNumber extends Model
{
    use HasFactory;
    protected $table = 'course_subject_number';
    protected $fillable =[
        'nivel',
        'course_id',
        'sem_1',
        'sem_2',
        'sem_3',
        'sem_4',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
