<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjs = Subjects::all();
        return view('admin.subjects.index', compact('subjs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No separate view required since it's handled by the modal
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
        ]);

        Subjects::create([
            'subject' => $request->input('subject'),
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subjects $subjects)
    {
        // Not needed for this CRUD example
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subjects $subjects)
    {
        // No separate view required since it's handled by the modal
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:subjects,id',
            'subject' => 'required|string|max:255',
        ]);

        $subject = Subjects::findOrFail($validated['id']);

        $subject->subject = $validated['subject'];
        $subject->save();

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy($id)
    {
        $subject = Subjects::findOrFail($id);
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
