<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject'
    ];


    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_subjects', 'subject_id', 'teacher_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'teacher_subjects', 'subject_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'subject_id');
    }
}
