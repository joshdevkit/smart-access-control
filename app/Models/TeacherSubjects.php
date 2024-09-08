<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubjects extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_id'
    ];


    public function subjectOfFaculty()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }
}
