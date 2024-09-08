<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_no',
        'name',
        'username',
        'email',
        'password',
        'sex',
        'course_year_section'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, 'teacher_subjects', 'teacher_id', 'subject_id');
    }


    public function studentSubjects()
    {
        return $this->hasMany(StudentSubjects::class, 'student_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'instructor_id');
    }


    public function yearAndSection()
    {
        return $this->hasOne(StudentYearAndSection::class, 'student_id');
    }
}
