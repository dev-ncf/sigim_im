<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentScholarship extends Model
{
    use HasFactory;

    protected $fillable = [
    	"scholarship",
        "institution",
        "modality",
        'student_id'
    ];
}
