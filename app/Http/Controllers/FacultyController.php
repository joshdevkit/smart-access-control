<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculty = User::role('Faculty')->get();
        return view('faculty.index', compact('faculty'));
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
        // Validate request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $nameParts = explode(' ', $validated['name']);
        $firstNameInitial = strtoupper(substr($nameParts[0], 0, 1));
        $lastNameInitial = isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) : '';

        $password = $firstNameInitial . $lastNameInitial . '0011';

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($password),
        ]);

        $user->assignRole('Faculty');

        return response()->json([
            'success' => true,
            'message' => 'Faculty member added successfully.',
            'data' => $user
        ], 201);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $facultyMember = User::findOrFail($id);

        // Return the faculty member's details as JSON
        return response()->json([
            'name' => $facultyMember->name,
            'username' => $facultyMember->username,
            'email' => $facultyMember->email,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $facultyMember = User::findOrFail($id);
        return response()->json([
            'name' => $facultyMember->name,
            'username' => $facultyMember->username,
            'email' => $facultyMember->email,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $facultyMember = User::findOrFail($id);
        $facultyMember->update($request->all());
        return redirect()->route('faculty.index')->with('success', 'Faculty updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
