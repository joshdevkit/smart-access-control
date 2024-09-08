@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Students Information" homeText="Home" breadcrumb="Students Information" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="mb-2">Students with Related Subjects</h6>

            <div class="mb-3">
                <strong>Students related to: </strong>
                @foreach ($subjects as $subject)
                    <span class="badge badge-primary">{{ $subject->subject }}</span>
                @endforeach
            </div>
        </div>
        <div class="card-body">
            <table id="dataTable_1" class="table table-striped">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr data-subjects="{{ $student->subjects->pluck('id')->implode(',') }}">
                            <td>{{ $student->student_no }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->yearAndSection->year->year ?? 'N/A' }}</td>
                            <td>{{ $student->yearAndSection->section->section ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
