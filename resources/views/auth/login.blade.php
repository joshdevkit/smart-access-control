@extends('layouts.app')

@section('content')
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <div class="col-md-6 d-none d-md-block p-0">
                <img src="{{ asset('image/login.jpg') }}" class="w-100 h-100" style="object-fit: cover;"
                    alt="LIS Laboratory Image">
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: #d3ecff;">
                <div class="w-75">
                    <div class="text-center mb-4">
                        <h1 class="fw-bold" style="font-size: 2.5rem; color: #000;">LIS Laboratory</h1>
                        <p class="mb-4" style="font-size: 1.2rem; color: #000;">Attendance Monitoring System</p>
                    </div>
                    <form method="POST" action="{{ route('user-login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="text" class="form-label" style="font-size: 1rem; color: #000;">User ID</label>
                            <input id="text" type="text"
                                class="form-control py-3 @error('login') is-invalid @enderror" name="login"
                                value="{{ old('login') }}" autocomplete="login" autofocus
                                placeholder="Enter your ID number">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label" style="font-size: 1rem; color: #000;">Password</label>
                            <input id="password" type="password"
                                class="form-control py-3 @error('password') is-invalid @enderror" name="password"
                                autocomplete="current-password" placeholder="Enter your password">
                        </div>
                        <div class="d-flex justify-content-end align-items-center mb-4">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}" style="color: #000;">
                                    Forgot your password?
                                </a>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3"
                            style="background-color: #3b5998; border: none;">
                            Log In
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('student-registration') }}" class="text-decoration-none" style="color: #000;">
                            No Account? Sign Up Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
