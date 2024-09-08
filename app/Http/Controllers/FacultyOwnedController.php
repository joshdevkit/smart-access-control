<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use App\Models\TeacherSubjects;
use App\Models\User;
use Illuminate\Http\Request;

class FacultyOwnedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = TeacherSubjects::with('subjectOfFaculty')->where('teacher_id', auth()->user()->id)->get();
        return view('faculty-main.index', compact('subjects'));
    }


    public function students()
    {
        $teacherId = auth()->user()->id;

        // Get the subject IDs the teacher is responsible for
        $teacherSubjects = TeacherSubjects::where('teacher_id', $teacherId)
            ->pluck('subject_id');

        // Get the subject details
        $subjects = \App\Models\Subjects::whereIn('id', $teacherSubjects)->get();

        // Get the students associated with those subjects
        $students = User::role('Student')
            ->whereIn('id', function ($query) use ($teacherSubjects) {
                $query->select('student_id')
                    ->from('student_subjects')
                    ->whereIn('subject_id', $teacherSubjects);
            })
            ->with(['yearAndSection.year', 'yearAndSection.section']) // Eager load year and section
            ->get();

        return view('faculty-main.students', compact('students', 'subjects'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
