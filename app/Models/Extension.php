<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    use HasFactory;


    public function faculties(){
    	//return $this->belongsToMany(Faculty::class, 'extension_faculties');
    	return $this->hasMany(Faculty::class);
    }

}
