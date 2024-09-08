<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveClassSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'subject_id',
        'student_id',
        'student_no',
        'qr_code',
        'code',
        'is_scanned'
    ];


    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }


    public function subject()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }
}
