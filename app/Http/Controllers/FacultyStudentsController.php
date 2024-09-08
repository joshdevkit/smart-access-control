<?php

namespace App\Http\Controllers;

use App\Models\TeacherSubjects;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacultyStudentsController extends Controller
{
    public function index()
    {
        $facultyMembers = User::role('Faculty')->get();
        return view('admin.students', compact('facultyMembers'));
    }


    public function create()
    {
        return view('admin.create');
    }


    public function edit($facultyId)
    {
        $facultySubjectIds = DB::table('teacher_subjects')
            ->where('teacher_id', $facultyId)
            ->pluck('subject_id')
            ->toArray();

        $facultyStudentIds = DB::table('student_subjects')
            ->whereIn('subject_id', $facultySubjectIds)
            ->pluck('student_id')
            ->toArray();

        $students = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'Student')
            ->select('users.id', 'users.name')
            ->get();

        return view('admin.edit-students', compact('students', 'facultyStudentIds', 'facultyId'));
    }
}
