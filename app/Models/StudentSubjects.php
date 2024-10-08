<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubjects extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
    ];
}
