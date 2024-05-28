<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfessionalCareer extends Model
{
    use HasFactory;

    protected $fillable = [
    	"institution",
        "start_year",
        "completion_year",
        "role",
        'student_id'
    ];
}
