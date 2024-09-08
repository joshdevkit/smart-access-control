@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="My Attendance" homeText="Home" breadcrumb="My Attendance" />
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-light shadow-lg text-white">
            User Details
        </div>
        <div class="card-body bg-info">
            <p><strong>Access Level: </strong> {{ Auth::user()->getRoleNames()->first() }}</p>
            <p><strong>Name: </strong> {{ Auth::user()->name }}</p>
            <p><strong>Email: </strong> {{ Auth::user()->email }}</p>
            <p><strong>Course: </strong> {{ Auth::user()->course_year_section }}</p>
            <p><strong>Year: </strong> {{ $year->year }}</p>
            <p><strong>Section: </strong> {{ $section->section }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-2">Attendance Record</h6>
        </div>
        <div class="card-body">
            <form id="filter-form">
                <div class="row mb-3">
                    <div class="col-md-0 d-flex align-items-center">
                        <label for="month" class="mb-0">Month:</label>
                    </div>
                    <div class="col-md-2">
                        <select id="month" name="month" class="form-select form-control" required>
                            <option value="" {{ request('month') === null ? 'selected' : '' }}>All</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>SUBJECT</th>
                        <th>INSTRUCTOR</th>
                        <th>PRESENT</th>
                        <th>ABSENT</th>
                    </tr>
                </thead>
                <tbody id="data">
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            function loadAttendance(month) {
                $.ajax({
                    url: '{{ route('attendance.get') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        month: month
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#data').empty();
                        response.attendances.forEach(function(attendance) {
                            $('#data').append(
                                `<tr>
                                    <td>${attendance.subject.subject}</td>
                                    <td>${attendance.instructor.name}</td>
                                    <td>${attendance.present_count}</td>
                                    <td>${attendance.absent_count}</td>
                                </tr>`
                            );
                        });
                        $('#present_count').text(response.presentCount);
                        $('#absent_count').text(response.absentCount);
                    },
                });
            }

            loadAttendance($('#month').val());

            $('#month').on('change', function() {
                loadAttendance($(this).val());
            });
        });
    </script>
@endsection
