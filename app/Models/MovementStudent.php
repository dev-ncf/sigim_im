<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'payment_id',
        'receipt_number',
        'date_receipt',
        'total_amount',
        'status',
        'student_id',
        'month',
        'year',
        'semestre',
        'manager_id'
    ];

    public function payment()
    {
        return $this->belongsTo(FormPayment::class);
    }

    public function items()
    {
        return $this->hasMany(MovementStudentItem::class, 'movement_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
