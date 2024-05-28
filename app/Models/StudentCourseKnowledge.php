<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourseKnowledge extends Model
{
    use HasFactory;

    protected $fillable = [
    	'ad_source',
        'student_id'
    ];
}
