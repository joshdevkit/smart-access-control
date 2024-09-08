@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Class Session Management" homeText="Home" breadcrumb="Class session" />
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h4>
                <a href="{{ url('current-session/' . Auth::user()->id) }}" class="btn btn-primary">Check Current Session</a>
            </h4>

            <form action="{{ route('faculty-session.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="subjectSelect">Select Subject</label>
                        <select name="subjectSelect" id="subjectSelect" class="form-control">
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="yearSelect">Filter Year</label>
                        <select id="yearSelect" class="form-control">
                            <option value="">Filter Year</option>
                            @foreach ($years as $year)
                                <option value="{{ $year->year }}">{{ $year->year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sectionSelect">Filter Section</label>
                        <select id="sectionSelect" class="form-control">
                            <option value="">Filter Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->section }}">{{ $section->section }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px;"></th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="student-item" id="student_{{ $student->id }}"
                            data-year="{{ $student->yearAndSection->year->year }}"
                            data-section="{{ $student->yearAndSection->section->section }}">
                            <td>
                                <input type="checkbox" name="student_id[]" value="{{ $student->id }}">
                            </td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->yearAndSection->year->year }}</td>
                            <td>{{ $student->yearAndSection->section->section }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <button type="submit" class="btn btn-primary mt-3">Add to Class Session</button>
        </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function filterStudents() {
                var selectedYear = $('#yearSelect').val();
                var selectedSection = $('#sectionSelect').val();

                $('.student-item').each(function() {
                    var studentYear = $(this).data('year');
                    var studentSection = $(this).data('section');

                    if (
                        (selectedYear === '' || studentYear === selectedYear) &&
                        (selectedSection === '' || studentSection === selectedSection)) {
                        $(this).removeClass('d-none');
                    } else {
                        $(this).addClass('d-none');
                    }
                });
            }

            $('#yearSelect, #sectionSelect').change(function() {
                filterStudents();
            });

            filterStudents();

            $('form').on('submit', function(e) {
                if ($('input[name="student_id[]"]:checked').length === 0) {
                    alert('Please select at least one student.');
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
