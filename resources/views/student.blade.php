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
                    @if (session('message'))
                        <div class="alert alert-danger text-center">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="text-center mb-4">
                        <h1 class="fw-bold" style="font-size: 2.5rem; color: #000;">LIS Laboratory</h1>
                        <p class="mb-4" style="font-size: 1.2rem; color: #000;">Attendance Monitoring System</p>
                    </div>
                    @if ($session)
                        <div class="card justify-content-center align-items-center mb-5">
                            <h4 class="text-center text-danger mt-2 py-3">Please scan the qr code.</h4>
                            <img src="{{ asset($session->qr_code) }}" class="w-50 mb-5" alt="QR Code">
                            {{-- <div class="card-body text-center">
                                <h4 class="card-title">Student : <strong>{{ $session->student->name }}</strong></h4>
                                <h4 class="card-text">Subject : <strong>{{ $session->subject->subject }}</strong></h4>
                            </div> --}}
                        </div>
                        <form action="{{ route('submit-attendance') }}" method="POST">
                            @csrf
                            <div class="form-group mt-5">
                                <label for="">Please Enter the Qr Code Value here...</label>
                                <input type="text" name="code" class="form-control">
                                <input type="hidden" name="studentno" value="{{ $studentno }}">
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                        </form>
                    @else
                        <p class="text-center">No QR codes available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
