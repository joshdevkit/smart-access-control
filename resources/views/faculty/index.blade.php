@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Faculty" homeText="Faculty Management" breadcrumb="Faculty" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addFacultyModal">
                Add Faculty Member
            </button>
            <h6>Faculty</h6>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($faculty as $member)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->username }}</td>
                            <td>{{ $member->email }}</td>
                            <td>
                                <button class="btn btn-info btn-sm view-btn" data-id="{{ $member->id }}"
                                    data-toggle="modal" data-target="#viewModal">View</button>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $member->id }}"
                                    data-toggle="modal" data-target="#editModal">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $member->id }}"
                                    data-toggle="modal" data-target="#deleteModal">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addFacultyModal" tabindex="-1" role="dialog" aria-labelledby="addFacultyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFacultyModalLabel">Add Faculty Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addFacultyForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <span class="text-danger error-text name-error"></span>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                            <span class="text-danger error-text username-error"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <span class="text-danger error-text email-error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Faculty</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">View Faculty</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="view-name"></span></p>
                    <p><strong>Username:</strong> <span id="view-username"></span></p>
                    <p><strong>Email:</strong> <span id="view-email"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Faculty</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="edit-username">Username</label>
                            <input type="text" class="form-control" id="edit-username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="delete-name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="delete-form" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.view-btn').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route('faculty.show', '') }}/' + id,
                    method: 'GET',
                    success: function(data) {
                        $('#view-name').text(data.name);
                        $('#view-username').text(data.username);
                        $('#view-email').text(data.email);
                    }
                });
            });

            // Edit button
            $('.edit-btn').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: `faculty/${id}/edit`,
                    method: 'GET',
                    success: function(data) {
                        console.log(data)
                        $('#edit-form').attr('action', '{{ route('faculty.update', '') }}/' +
                            id);
                        $('#edit-name').val(data.name);
                        $('#edit-username').val(data.username);
                        $('#edit-email').val(data.email);
                    }
                });
            });

            // Delete button
            $('.delete-btn').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).closest('tr').find('td:eq(1)').text();
                $('#delete-form').attr('action', '{{ route('faculty.destroy', '') }}/' + id);
                $('#delete-name').text(name);
            });
            $('#name').on('input', function() {
                var name = $(this).val();
                var nameParts = name.split(' ');

                if (nameParts.length > 1) {
                    var firstNameInitial = nameParts[0].charAt(0).toUpperCase();
                    var lastNameInitial = nameParts[1].charAt(0).toUpperCase();
                    var username = firstNameInitial + lastNameInitial + '0011';

                    $('#username').val(username);
                } else {
                    $('#username').val('');
                }
            });
            $('#addFacultyForm').submit(function(e) {
                e.preventDefault();

                // Clear previous error messages
                $('.error-text').text('');

                $.ajax({
                    url: '{{ route('faculty.store') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;

                        $.each(errors, function(key, value) {
                            var inputField = $('#' + key);
                            var errorContainer = $('.' + key + '-error');
                            errorContainer.text(value[0]);
                            inputField.addClass('is-invalid');
                        });
                    }
                });
            });


        });
    </script>
@endsection
