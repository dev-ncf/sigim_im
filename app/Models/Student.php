<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    	'first_name',
        'last_name',
        'province_birth_id',
        'birth_local',
        'gender_id',
        'marital_status_id',
        'birth_date',
        'father_name',
        'father_profession',
        'mother_name',
        'mother_profession',
        'nationality',
        'email',
        'phone',
        'special_educational_need',
        'phone_secondary',
        'family_type',
        'household',
        'user_id',
        'extension_id',
        'certificate_file',
        'military_declaration_file',
        'id_file',
        'nuit_file',
        'manager_response_id',
        'registration_status'
    ];


    public function studentEnrollment(){
        return $this->hasOne(StudentEnrollment::class);
    }

    public function document()
    {
        return $this->hasOne(StudentDocument::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function maritalStatus()
    {
        return $this->belongsTo(CivilStatus::class);
    }

    public function address()
    {
        return $this->hasOne(StudentAddress::class);
    }

    public function movements()
    {
        return $this->hasMany(MovementStudent::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_response_id', 'id');
    }
}
