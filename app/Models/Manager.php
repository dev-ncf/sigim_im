<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Manager extends Authenticatable
{
    use HasFactory, Notifiable;
    

    protected $guard = 'manager';

    protected $fillable = [
        'first_name',
        'last_name',
        'document_type_id',
        'document_number',
        'phone',
        'phone_secondary',
        'password'
    ];


}
