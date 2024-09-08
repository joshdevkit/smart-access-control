@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Add/Edit Existing Students" homeText="Home" breadcrumb="Add/Edit Existing Students" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="mb-2">Edit Students for Faculty Member</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('faculty-students.update', $facultyId) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="students">Select Students:</label>
                    <div class="checkbox-group">
                        @foreach ($students as $student)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="students[]"
                                    value="{{ $student->id }}" id="student_{{ $student->id }}"
                                    @if (in_array($student->id, $facultyStudentIds)) checked @endif>
                                <label class="form-check-label" for="student_{{ $student->id }}">
                                    {{ $student->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
@endsection
