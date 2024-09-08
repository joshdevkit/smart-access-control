@extends('layouts.app')

@section('content')
    <div class="container-fluid vh-100">

        <div class="row h-100">
            <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: #d3ecff;">
                <div class="w-75">
                    <div class="text-center mb-4">
                        <h1 class="fw-bold" style="font-size: 2.5rem; color: #000;">LIS Laboratory</h1>
                        <p class="mb-4" style="font-size: 1.2rem; color: #000;">Attendance Monitoring System</p>
                    </div>
                    <form method="POST" action="{{ route('student-registration') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-lg-12 mb-3">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" id="student_id" name="student_id"
                                    class="form-control @error('student_id') is-invalid @enderror"
                                    value="{{ old('student_id') }}">
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name') }}">
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-lg-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name') }}">
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="sex" class="form-label">Sex</label>
                            <select id="sex" name="sex"
                                class="form-control form-select @error('sex') is-invalid @enderror">
                                <option value="" disabled selected>Select your sex</option>
                                <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('sex') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('sex')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="course" class="form-label">Course</label>
                            <input disabled type="text" id="course" name="course_display" class="form-control"
                                value="BLIS (Bachelor of Library and Information Science)">
                            <input type="hidden" name="course" value="BLIS (Bachelor of Library and Information Science)">
                        </div>

                        <div class="form-group mb-3">
                            <label for="year" class="form-label">Year</label>
                            <select class="form-control" id="year" name="year" required>
                                <option value="">Select Year</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="section" class="form-label">Section</label>
                            <select class="form-control" id="section" name="section" required>
                                <option value="">Select Section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->section }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="subjects" class="form-label">Subjects</label>
                            <select style="width: 100%" id="subjects" name="subjects[]"
                                class="form-control select2 @error('subjects') is-invalid @enderror" multiple>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ in_array($subject->id, old('subjects', [])) ? 'selected' : '' }}>
                                        {{ $subject->subject }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subjects')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3"
                            style="background-color: #3b5998; border: none;">
                            Signup
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none" style="color: #000;">
                            Login
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-block p-0">
                <img src="{{ asset('image/login.jpg') }}" class="w-100 h-100" style="object-fit: cover;"
                    alt="LIS Laboratory Image">
            </div>
        </div>
    </div>
@endsection
