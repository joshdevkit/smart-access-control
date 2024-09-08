@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Faculty" homeText="Home" breadcrumb="Faculty" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="mb-2">Faculty</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facultyMembers as $faculty)
                        <tr>
                            <td>{{ $faculty->name }}</td>
                            <td>{{ $faculty->email }}</td>
                            <td>
                                <a href="{{ route('faculty-students.edit', ['faculty_student' => $faculty->id]) }}"
                                    class="btn btn-success">Add Students</a>

                                <a href="{{ route('faculty-students.show', ['faculty_student' => $faculty->id]) }}"
                                    class="btn btn-secondary">View Students</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Add any JavaScript code here if needed
        });
    </script>
@endsection
