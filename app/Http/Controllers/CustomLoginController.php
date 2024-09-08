<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\StudentSubjects;
use App\Models\StudentYearAndSection;
use App\Models\Subjects;
use App\Models\User;
use App\Models\Year;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginField => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            /**
             * @var App\Models\User
             */
            $user = Auth::user();
            if ($user->hasRole('Student')) {
                return redirect()->intended(route('my-attendance.index'));
            } elseif ($user->hasRole('Faculty')) {
                return redirect()->intended(route('faculty-management.index'));
            } else {
                return redirect()->intended('dashboard');
            }
        }

        throw ValidationException::withMessages([
            'login' => __('The provided credentials do not match our records.'),
        ]);
    }


    public function register()
    {
        $subjects = Subjects::all();
        $years = Year::all();
        $sections = Section::all();
        return view('auth.register', compact('subjects', 'years', 'sections'));
    }

    public function store_account(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'sex' => 'required|string',
            'year' => 'required',
            'section' => 'required',
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $firstInitial = strtoupper(substr($validated['first_name'], 0, 1));
        $lastInitial = strtoupper(substr($validated['last_name'], 0, 1));
        $studentCount = User::role('Student')->count();
        $username = 'C' . $firstInitial . $lastInitial . str_pad($studentCount + 1, 3, '0', STR_PAD_LEFT);
        $user = User::create([
            'student_no' => $validated['student_id'],
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'username' => $username,
            'email' => $validated['email'],
            'sex' => $validated['sex'],
            'course_year_section' => $request->input('course'),
            'password' => Hash::make($validated['password']),
        ]);

        StudentYearAndSection::create([
            'student_id' => $user->id,
            'year_id' => $validated['year'],
            'section_id' => $validated['section'],
        ]);

        $user->assignRole('Student');

        if (isset($validated['subjects'])) {
            foreach ($validated['subjects'] as $subjectId) {
                StudentSubjects::create([
                    'student_id' => $user->id,
                    'subject_id' => $subjectId,
                ]);
            }
        }

        Auth::login($user);

        return redirect()->route('my-attendance.index');
    }
}
