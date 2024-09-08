<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use App\Models\User;
use Illuminate\Http\Request;

class FacultySubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculty = User::role('Faculty')->with('subjects')->get();
        $allFaculties = User::role('Faculty')->get();
        $subjects = Subjects::all();
        return view('subjects.index', compact('faculty', 'allFaculties', 'subjects'));
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
        $validatedData = $request->validate([
            'faculty_ids' => 'required|array',
            'faculty_ids.*' => 'exists:users,id',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $facultyIds = $validatedData['faculty_ids'];
        $subjectIds = $validatedData['subject_ids'];

        $subjects = Subjects::whereIn('id', $subjectIds)->get();

        foreach ($facultyIds as $facultyId) {
            $faculty = User::find($facultyId);

            if ($faculty) {
                $faculty->subjects()->syncWithoutDetaching($subjects->pluck('id'));
            }
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Subjects updated successfully!');
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
    public function edit(string $facultyId)
    {
        $faculty = User::findOrFail($facultyId);
        $subjects = Subjects::all();
        return view('subjects.edit', compact('faculty', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $facultyId)
    {
        $faculty = User::findOrFail($facultyId);
        $subjectIds = $request->input('subject_ids', []);
        $faculty->subjects()->sync($subjectIds);

        return redirect()->route('faculty-subject.index')->with('success', 'Subjects updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($subjectId)
    {
        $subject = Subjects::find($subjectId);

        if ($subject) {
            $subject->users()->detach();

            $subject->delete();

            return redirect()->back()->with('success', 'Subject removed successfully!');
        }

        return redirect()->back()->with('error', 'Subject not found.');
    }
}
