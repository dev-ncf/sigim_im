<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAddress extends Model
{
    use HasFactory;

    protected $fillable = [
    	"province_id",
        "district_id",
        "neighborhood",
        "block",
        "house_number",
        'student_id'
    ];

    public function province()
    {
    	return $this->belongsTo(Province::class);
    }

    public function district()
    {
    	return $this->belongsTo(District::class);
    }
}
