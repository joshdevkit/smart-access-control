@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Subjects" homeText="Home" breadcrumb="Subjects" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Subjects</h4>
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addSubjectModal">Add New
                Subject</button>
        </div>
        <div class="card-body">
            @if ($subjs->isEmpty())
                <p class="text-center">No subjects found.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjs as $subj)
                            <tr>
                                <td>{{ $subj->id }}</td>
                                <td>{{ $subj->subject }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editSubjectModal" data-id="{{ $subj->id }}"
                                        data-subject="{{ $subj->subject }}">Edit</button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteSubjectModal" data-id="{{ $subj->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Add Subject Modal -->
    <div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="addSubjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubjectModalLabel">Add New Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="subject">Subject Name</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Subject Modal -->
    <div class="modal fade" id="editSubjectModal" tabindex="-1" role="dialog" aria-labelledby="editSubjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editSubjectForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editSubjectId" name="id">
                        <div class="form-group">
                            <label for="editSubjectName">Subject Name</label>
                            <input type="text" class="form-control" id="editSubjectName" name="subject" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Subject Modal -->
    <div class="modal fade" id="deleteSubjectModal" tabindex="-1" role="dialog" aria-labelledby="deleteSubjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSubjectModalLabel">Delete Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteSubjectForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Are you sure you want to delete this subject?</p>
                        <input type="hidden" id="deleteSubjectId" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Handle Edit button click
            $('#editSubjectModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var subject = button.data('subject');
                var modal = $(this);
                modal.find('#editSubjectId').val(id);
                modal.find('#editSubjectName').val(subject);
                var action = "{{ route('subjects.update', ':id') }}";
                action = action.replace(':id', id);
                modal.find('#editSubjectForm').attr('action', action);
            });

            // Handle Delete button click
            $('#deleteSubjectModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                var action = "{{ route('subjects.destroy', ':id') }}";
                action = action.replace(':id', id);
                modal.find('#deleteSubjectForm').attr('action', action);
            });
        });
    </script>
@endsection
