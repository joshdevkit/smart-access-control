@extends('layouts.base-template')
@section('header')
    <x-dashboard-header title="Students" homeText="User Management" breadcrumb="Students" />
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <table id="dataTable_1" class="table table-striped">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Year</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->student_no }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->username }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->yearAndSection->year->year ?? 'N/A' }}</td>
                            <td>{{ $student->yearAndSection->section->section ?? 'N/A' }}</td>
                            {{-- <td>
                                <i class="fas fa-trash"></i>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {})
    </script>
@endsection
