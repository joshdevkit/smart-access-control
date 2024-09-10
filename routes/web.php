<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\FacultyAttendanceMonitoring;
use App\Http\Controllers\FacultyClassSessionController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\FacultyOwnedController;
use App\Http\Controllers\FacultyStudentsController;
use App\Http\Controllers\FacultySubjectsController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\StudentsOwnedController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\YearSectionController;

Auth::routes();

Route::middleware(['auth'])->group(function () {


    //Admin Routes
    Route::middleware(['role:Administrator'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
        Route::resource('attendance', AttendanceController::class);
        Route::resource('user', UsersController::class);
        Route::resource('logs', LogsController::class);
        Route::resource('faculty', FacultyController::class);
        Route::resource('faculty-subject', FacultySubjectsController::class);
        Route::resource('faculty-students', FacultyStudentsController::class);
        Route::resource('subjects', SubjectsController::class);
        Route::put('/faculty-subject/update/{faculty_subject}', [FacultySubjectsController::class, 'update'])->name('faculty-subject.update');

        Route::resource('year-sections', YearSectionController::class);



        Route::put('/sections/{id}', [YearSectionController::class, 'update'])->name('sections.update');
        Route::delete('/sections/{id}', [YearSectionController::class, 'destroy'])->name('sections.destroy');

        Route::put('/years/{id}', [YearSectionController::class, 'update_year'])->name('years.update');
        Route::delete('/years/{id}', [YearSectionController::class, 'destroy_year'])->name('years.destroy');
        Route::post('/year/create', [YearSectionController::class, 'create_year'])->name('year.create');
    });


    //Faculty Routes
    Route::middleware(['role:Faculty'])->group(function () {
        Route::resource('faculty-management', FacultyOwnedController::class);
        Route::resource('attendance', FacultyAttendanceMonitoring::class);

        Route::get('student-informations', [FacultyOwnedController::class, 'students'])->name('students');
        Route::resource('faculty-session', FacultyClassSessionController::class);
        Route::get('/current-session/{id}', [FacultyClassSessionController::class, 'showcurrent'])->name('current-session');
        Route::post('/stop-all-sessions', [FacultyClassSessionController::class, 'stopAllSessions'])->name('stop-all-sessions');
    });

    // Student Routes
    Route::middleware(['role:Student'])->group(function () {
        Route::resource('my-attendance', StudentsOwnedController::class);
        Route::post('my-attendance/get', [StudentsOwnedController::class, 'json_data'])->name('attendance.get');
    });
});


Route::get('/', [CustomLoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [CustomLoginController::class, 'login'])->name('user-login');

Route::get('/create-account', [CustomLoginController::class, 'register'])->name('student-registration');
Route::post('/create-account', [CustomLoginController::class, 'store_account'])->name('student-registration');

Route::get('/student/{studentno}', [FacultyClassSessionController::class, 'get_qr_display'])->name('student.qr');

Route::post('/student', [FacultyClassSessionController::class, 'attendance'])->name('submit-attendance');
