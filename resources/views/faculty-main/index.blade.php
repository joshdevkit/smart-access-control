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

    <div class="card">
        <div class="card-header">
            Subject Details
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>SUBJECT</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @forelse ($subjects as $subj)
                        <tr>

                            <td>{{ $i++ }}</td>
                            <td>{{ $subj->subjectOfFaculty->subject }}</td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="2" class="text-center">No Subject found</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
