<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'student_id',
        'course_id', 
        'semester',
        'status'
    ];
}
