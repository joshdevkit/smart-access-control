<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\ActiveClassSession;
use App\Models\Attendance;
use App\Models\TeacherSubjects;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FacultyClassSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacherId = auth()->user()->id;

        $teacherSubjects = TeacherSubjects::where('teacher_id', $teacherId)
            ->pluck('subject_id');

        $subjects = \App\Models\Subjects::whereIn('id', $teacherSubjects)->get();

        $students = User::role('Student')
            ->whereIn('id', function ($query) use ($teacherSubjects) {
                $query->select('student_id')
                    ->from('student_subjects')
                    ->whereIn('subject_id', $teacherSubjects);
            })
            ->with(['yearAndSection.year', 'yearAndSection.section'])
            ->get();

        $years = \App\Models\Year::all();
        $sections = \App\Models\Section::all();

        return view('faculty-main.class-session', compact('students', 'subjects', 'years', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subjectSelect' => ['required', 'integer'],
            'student_id' => ['required', 'array'],
            'student_id.*' => ['required', 'integer']
        ], [
            'subjectSelect.required' => 'The subject selection is required.',
            'subjectSelect.integer' => 'The subject selection must be an integer.',
            'student_id.required' => 'At least one student ID is required.',
            'student_id.array' => 'Student IDs should be an array.',
            'student_id.*.required' => 'Each student ID is required.',
            'student_id.*.integer' => 'Each student ID must be an integer.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subjectId = $request->input('subjectSelect');
        $lastActiveSession = null;

        foreach ($request->input('student_id') as $studentId) {
            $student = User::find($studentId);
            if ($student) {
                $studentNo = $student->student_no;
                $student_id = $student->id;
            } else {
                return redirect()->back()->with('error', "Student with ID $studentId not found.");
            }

            $qrCodeValue = 'ClassSession-' . uniqid();

            $qrCodeFileName = $qrCodeValue . '.png';
            $qrCodeFilePath = 'qrcodes/' . $qrCodeFileName;

            QrCode::format('png')
                ->size(300)
                ->generate($qrCodeValue, public_path($qrCodeFilePath));

            $lastActiveSession = ActiveClassSession::create([
                'faculty_id' => auth()->id(),
                'subject_id' => $subjectId,
                'student_id' => $student_id,
                'student_no' => $studentNo,
                'qr_code' => $qrCodeFilePath,
                'code' => $qrCodeValue
            ]);
        }

        if ($lastActiveSession) {
            return redirect()->route('current-session', ['id' => Auth::user()->id])
                ->with('success', 'Active session created successfully.');
        }

        return redirect()->back()->with('error', 'Failed to create active session.');
    }



    public function showcurrent($id)
    {
        $activeSessions = ActiveClassSession::where('faculty_id', $id)->with(['student', 'subject'])->get();
        return view('faculty-main.active-session', compact('activeSessions'));
    }

    public function stopAllSessions()
    {
        $sessions = ActiveClassSession::all();

        foreach ($sessions as $session) {
            if (file_exists(public_path($session->qr_code))) {
                unlink(public_path($session->qr_code));
            }

            if ($session->is_scanned === 0) {
                $student = User::where('student_no', $session->student_no)->first();

                if ($student) {
                    Attendance::create([
                        'student_id' => $student->id,
                        'subject_id' => $session->subject_id,
                        'instructor_id' => $session->faculty_id,
                        'attendance_time' => now(),
                        'status' => 'Absent',
                    ]);
                }
            }
        }

        ActiveClassSession::query()->delete();

        return redirect()->route('faculty-session.index')->with('success', 'All active sessions has ended, all student who did not scanned are marked as Absent.');
    }




    public function get_qr_display($studentno)
    {
        $session = ActiveClassSession::where('student_no', $studentno)->with(['student', 'subject'])->first();

        if (!$session) {
            return redirect()->back()->with('error', 'No session found for the provided student ID.');
        }

        return view('student', ['session' => $session, 'studentno' => $studentno]);
    }


    public function attendance(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'studentno' => 'required|string'
        ]);

        $activeSession = ActiveClassSession::where('code', $request->input('code'))->first();

        if ($activeSession) {
            if ($activeSession->is_scanned === 1) {
                return redirect()->back()->with('message', 'QR code has already been scanned.');
            }

            if ($activeSession->student_no === $request->input('studentno')) {
                $student = User::where('student_no', $request->input('studentno'))->first();

                if ($student) {
                    Auth::login($student);

                    Attendance::create([
                        'student_id' => $student->id,
                        'subject_id' => $activeSession->subject_id,
                        'instructor_id' => $activeSession->faculty_id,
                        'attendance_time' => now(),
                        'status' => 'Present',
                    ]);

                    $activeSession->update(['is_scanned' => 1]);

                    return redirect()->route('my-attendance.index');
                } else {
                    return redirect()->back()->with('message', 'Student not found.');
                }
            } else {
                return redirect()->back()->with('message', "The QR Code doesn't belong to you.");
            }
        } else {
            return redirect()->back()->with('message', 'QR Code not found.');
        }
    }
}
