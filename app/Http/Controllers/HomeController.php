<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $mytime = Carbon::now();
        $checkdate = $mytime->toDateString();
        $students = User::role('Student')->count();
        $faculty = User::role('Faculty')->count();
        $attendance = Attendance::whereDate('created_at', $checkdate)->count();
        return view('home', compact('students', 'faculty', 'attendance'));
    }
}
