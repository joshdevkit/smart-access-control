<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentYearAndSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'year_id',
        'section_id'
    ];



    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    // Define the relationship with the Section model
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Define the relationship with the Student model
    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
