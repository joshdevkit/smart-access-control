@extends('layouts.base-template')
@section('header')
    <x-dashboard-header title="Dashboard" homeText="Home" breadcrumb="Dashboard" />
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
        </div>
    </div>

    <!-- Info boxes -->
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $faculty }}</h3>
                    <p>Total Employee</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-stalker"></i>
                </div>
                <a href="{{ route('faculty.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $students }}</h3>
                    <p>Total Student</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('user.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $attendance }}</h3>
                    <p>Total Attendance Today</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-time"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        {{-- <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>1</h3>
                    <p>Admins</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div> --}}
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {})
    </script>
@endsection
