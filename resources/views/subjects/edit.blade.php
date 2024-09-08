@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Edit Faculty Subjects" homeText="Faculty Management" breadcrumb="Edit Faculty Subjects" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('faculty-subject.index') }}" class="btn btn-secondary float-right">
                Back to Faculty Subjects
            </a>
        </div>
        <div class="card-body">
            <h4>Edit Subjects for {{ $faculty->name }}</h4>

            <form action="{{ route('faculty-subject.update', $faculty->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="edit-subject-select">Select Subjects</label>
                    <select id="edit-subject-select" class="select2" name="subject_ids[]" multiple="multiple"
                        data-placeholder="Select Subjects" style="width: 100%;">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @if ($faculty->subjects->contains($subject->id)) selected @endif>
                                {{ $subject->subject }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Subjects</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <!-- Include any necessary scripts here, such as for Select2 -->
@endsection
