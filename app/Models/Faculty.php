<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    protected $fillable = [
        'label',
        'extension_id'
    ];

    public function extensao(){
        return $this->belongsTo(Extension::class,'extension_id');
    }
}
