@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Active Class Session" homeText="Home" breadcrumb="Active Class Session" />
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($activeSessions->isEmpty())
                <p>No active sessions found.</p>
            @else
                <form action="{{ route('stop-all-sessions') }}" method="POST" id="stopSessionsForm">
                    @csrf
                    <button type="submit" class="btn btn-danger">End Session / Class</button>
                </form>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Subject</th>
                            <th>QR Code</th>
                            <th>Is Scanned</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activeSessions as $session)
                            <tr>
                                <td>{{ $session->student->name }}</td>
                                <td>{{ $session->subject->subject }}</td>
                                <td><img src="{{ asset($session->qr_code) }}" alt="QR Code" width="100"></td>
                                <td>{{ $session->is_scanned ? 'Yes' : 'No' }}</td>
                                <td>{{ date('F d, Y ', strtotime($session->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
