<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousSkill extends Model
{
    use HasFactory;

    protected $fillable = [
    	"academic_level_id",
        "local",
        "institution",
        "start_year",
        "completion_year",
        'student_id'
    ];
}
