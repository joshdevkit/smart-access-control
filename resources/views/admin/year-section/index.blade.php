@extends('layouts.base-template')

@section('header')
    <x-dashboard-header title="Year and Section" homeText="Home" breadcrumb="Year and Section" />
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createSectionModal">
                        Add Section
                    </button>
                </div>
                <div class="col-md-6 text-md-right mb-2">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createYearModal">
                        Add Year
                    </button>
                </div>
                <div class="col-md-6">
                    <h5>Sections</h5>
                    <ul class="list-group">
                        @foreach ($sections as $section)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $section->section }}</span>
                                <div>
                                    <button class="btn btn-warning btn-sm mr-2 edit-section-btn" data-toggle="modal"
                                        data-target="#editSectionModal" data-id="{{ $section->id }}"
                                        data-section="{{ $section->section }}">Edit</button>
                                    <form action="{{ route('sections.destroy', $section->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Year List -->
                <div class="col-md-6">
                    <h5>Years</h5>
                    <ul class="list-group">
                        @foreach ($year as $year)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $year->year }}</span>
                                <div>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm mr-2 edit-year-btn" data-toggle="modal"
                                        data-target="#editYearModal" data-id="{{ $year->id }}"
                                        data-year="{{ $year->year }}">Edit</button>
                                    <form action="{{ route('years.destroy', $year->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createSectionModal" tabindex="-1" role="dialog" aria-labelledby="createSectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSectionModalLabel">Create Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('year-sections.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="newSectionName">Section</label>
                            <input type="text" class="form-control" id="newSectionName" name="section" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Section</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Year Modal -->
    <div class="modal fade" id="createYearModal" tabindex="-1" role="dialog" aria-labelledby="createYearModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createYearModalLabel">Create Year</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('year.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="newYearName">Year</label>
                            <input type="text" class="form-control" id="newYearName" name="year" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Year</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Section Modal -->
    <div class="modal fade" id="editSectionModal" tabindex="-1" role="dialog" aria-labelledby="editSectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSectionModalLabel">Edit Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editSectionForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="sectionId">
                        <div class="form-group">
                            <label for="sectionName">Section</label>
                            <input type="text" class="form-control" id="sectionName" name="section">
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

    <!-- Edit Year Modal -->
    <div class="modal fade" id="editYearModal" tabindex="-1" role="dialog" aria-labelledby="editYearModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editYearModalLabel">Edit Year</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editYearForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="yearId">
                        <div class="form-group">
                            <label for="yearName">Year</label>
                            <input type="text" class="form-control" id="yearName" name="year">
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
@endsection

@section('script')
    <script>
        document.querySelectorAll('.edit-section-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const section = this.dataset.section;

                const modal = document.querySelector('#editSectionModal');
                modal.querySelector('#sectionId').value = id;
                modal.querySelector('#sectionName').value = section;
                modal.querySelector('form').setAttribute('action', '/sections/' + id);
            });
        });

        document.querySelectorAll('.edit-year-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const year = this.dataset.year;

                const modal = document.querySelector('#editYearModal');
                modal.querySelector('#yearId').value = id;
                modal.querySelector('#yearName').value = year;
                modal.querySelector('form').setAttribute('action', '/years/' + id);
            });
        });
    </script>
@endsection
