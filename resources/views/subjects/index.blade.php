@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Faculty Subjects" homeText="Faculty Management" breadcrumb="Faculty Subjects" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#createSubjectModal">
                Create Subject
            </button>
        </div>
        <div class="card-body">

            <div class="row mt-4">
                @foreach ($faculty as $member)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5>
                                    {{ $member->name }}
                                    <a href="{{ route('faculty-subject.edit', $member->id) }}"
                                        class="btn btn-secondary btn-sm float-right">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </h5>
                            </div>
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Username: {{ $member->username }}</h6>
                                <h6 class="card-subtitle mb-2 text-muted">Email: {{ $member->email }}</h6>

                                <hr>
                                <h6 class="card-subtitle mb-2">Subjects:

                                </h6>
                                <ul class="list-group list-group-flush">
                                    @forelse ($member->subjects as $subject)
                                        <li class="list-group-item mb-2 d-flex justify-content-between align-items-center">
                                            {{ $subject->subject }}
                                            <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                data-id="{{ $subject->id }}" data-name="{{ $subject->subject }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </li>
                                    @empty
                                        <li class="list-group-item">No subjects assigned</li>
                                    @endforelse
                                </ul>

                                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="deleteForm" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    Are you sure you want to remove the subject "<span
                                                        id="subjectName"></span>"?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="modal fade" id="createSubjectModal" tabindex="-1" role="dialog"
                aria-labelledby="createSubjectModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createSubjectModalLabel">Add Subject to Faculty</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('faculty-subject.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="faculty-select">Select Faculty Members</label>
                                    <select class="select2" name="faculty_ids[]" multiple="multiple"
                                        data-placeholder="Select Faculty" style="width: 100%;">
                                        @foreach ($allFaculties as $faculty)
                                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="subject-select">Select Subjects</label>
                                    <select class="select2" name="subject_ids[]" multiple="multiple"
                                        data-placeholder="Select Subjects" style="width: 100%;">
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Subject</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var subjectId = $(this).data('id');
                var subjectName = $(this).data('name');
                $('#deleteForm').attr('action', '/faculty-subject/' + subjectId);
                $('#subjectName').text(subjectName);
                $('#confirmDeleteModal').modal('show');
            });
        });
    </script>
@endsection
