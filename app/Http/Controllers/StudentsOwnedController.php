<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentsOwnedController extends Controller
{
    public function index()
    {
        $studentId = auth()->user()->id;

        $presentCount = Attendance::where('student_id', $studentId)
            ->where('status', 'Present')
            ->count();

        $absentCount = Attendance::where('student_id', $studentId)
            ->where('status', 'Absent')
            ->count();

        $attendances = Attendance::with(['subject', 'instructor'])
            ->where('student_id', $studentId)
            ->get();

        $student = User::find(Auth::user()->id);
        $year = $student->yearAndSection->year;
        $section = $student->yearAndSection->section;
        return view('students.index', compact('attendances', 'presentCount', 'absentCount', 'year', 'section'));
    }


    public function json_data(Request $request)
    {
        $studentId = auth()->user()->id;
        $month = $request->input('month');

        $query = Attendance::where('student_id', $studentId);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        $attendances = $query->with(['subject', 'instructor'])
            ->select(
                'subject_id',
                'instructor_id',
                DB::raw('SUM(CASE WHEN status = "Present" THEN 1 ELSE 0 END) as present_count'),
                DB::raw('SUM(CASE WHEN status = "Absent" THEN 1 ELSE 0 END) as absent_count')
            )
            ->groupBy('subject_id', 'instructor_id')
            ->get();

        return response()->json([
            'attendances' => $attendances,
            'presentCount' => $attendances->sum('present_count'),
            'absentCount' => $attendances->sum('absent_count')
        ]);
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
