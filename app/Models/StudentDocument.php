<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
    	'document_type_id',
		'document_number',
		'issue_date',
		'expiration_date',
		'issue_place',
		'student_id'
    ];


    public function documentType()
    {
    	return $this->belongsTo(DocumentType::class, 'document_type_id', 'id');
    }
}
