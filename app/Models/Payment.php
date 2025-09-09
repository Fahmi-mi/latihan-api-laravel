<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'student_id',
        'registration_id',
        'amount', 
        'status',
        'paid_at'
    ];
}
