@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Class Attendance" homeText="Home" breadcrumb="Class Attendance" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Attendance Records</h4>
            <div class="row">
                <div class="col-md-4">
                    <input type="date" id="filter-date" class="form-control" placeholder="Filter by Date">
                </div>
                <div class="col-md-4">
                    <select id="filter-status" class="form-control">
                        <option value="">Filter by Status</option>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button id="apply-filters" class="btn btn-primary">Apply Filters</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($attendances->isEmpty())
                <p class="text-center">No attendance records found.</p>
            @else
                <table id="dataTable_1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Subject</th>
                            <th>Attendance Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->student->name }}</td>
                                <td>{{ $attendance->subject->subject }}</td>
                                <td>{{ $attendance->attendance_time }}</td>
                                <td>{{ $attendance->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#apply-filters').click(function() {
                var selectedDate = $('#filter-date').val();
                var selectedStatus = $('#filter-status').val();

                $('#dataTable_1 tbody tr').filter(function() {
                    var rowDate = $(this).find('td:nth-child(3)').text().split(' ')[
                        0];
                    var rowStatus = $(this).find('td:nth-child(4)')
                        .text();

                    var matchDate = selectedDate === '' || rowDate === selectedDate;
                    var matchStatus = selectedStatus === '' || rowStatus === selectedStatus;

                    return matchDate && matchStatus;
                }).show();

                $('#dataTable_1 tbody tr').filter(function() {
                    var rowDate = $(this).find('td:nth-child(3)').text().split(' ')[0];
                    var rowStatus = $(this).find('td:nth-child(4)').text();

                    var matchDate = selectedDate === '' || rowDate === selectedDate;
                    var matchStatus = selectedStatus === '' || rowStatus === selectedStatus;

                    return !(matchDate && matchStatus);
                }).hide();
            });
        });
    </script>
@endsection
