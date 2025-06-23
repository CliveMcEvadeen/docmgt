@extends('layouts.app')

@section('content')
<style>
  html, body {
    /* overflow: hidden !important; */
    height: 100%;
  }
</style>
<div class="container-fluid mt-4">
    <h1 class="mb-4">Admin Dashboard</h1>
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-primary text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-user-shield fa-3x me-3 text-primary"></i>
                    <div>
                        <h5 class="card-title">Total Officers</h5>
                        <p class="card-text fs-4">{{ $officers->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-map-marker-alt fa-3x me-3 text-success"></i>
                    <div>
                        <h5 class="card-title">Total Locations</h5>
                        <p class="card-text fs-4">{{ $locations->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-tasks fa-3x me-3 text-warning"></i>
                    <div>
                        <h5 class="card-title">Assignments</h5>
                        <p class="card-text fs-4">{{ $assignments->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-folder-open fa-3x me-3 text-info"></i>
                    <div>
                        <h5 class="card-title">Documents</h5>
                        <p class="card-text fs-4">{{ $documents->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="mb-4">
        <h2 class="mb-3">Assign Officers to Locations</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.assign_officer') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label for="officer" class="form-label">Select Officer</label>
                        <select id="officer" name="officer_id" class="form-select" required>
                            <option value="">-- Select Officer --</option>
                            @foreach($officers as $officer)
                            <option value="{{ $officer->id }}">{{ $officer->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Select Location</label>
                        <select id="location" name="location_id" class="form-select" required>
                            <option value="">-- Select Location --</option>
                            @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Assign Officer</button>
                </form>
                <h3 class="mb-3">Current Officer Assignments</h3>
                <table id="assignmentsTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Officer Name</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->officer->full_name }}</td>
                            <td>{{ $assignment->location->name }}</td>
                            <td>
                                <form action="{{ route('admin.remove_assignment', $assignment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this assignment?')">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($assignments->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center text-muted">No assignments found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section>
        <h2 class="mb-3">Documents and Files</h2>
        <div class="card">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($documents as $document)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('documents.show', $document->id) }}" class="text-decoration-none">{{ $document->title }}</a>
                        <small class="text-muted">Uploaded on {{ $document->created_at->format('M d, Y') }}</small>
                    </li>
                    @endforeach
                    @if($documents->isEmpty())
                    <li class="list-group-item text-muted">No documents available.</li>
                    @endif
                </ul>
            </div>
        </div>
    </section>
    <section>
        <h2 class="mb-3">Documents Uploaded by Assigned Officers</h2>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered" id="officerDocumentsTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Officer</th>
                            <th>Uploaded On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $document)
                            @if($officers->pluck('id')->contains($document->user_id))
                            <tr>
                                <td>{{ $document->title }}</td>
                                <td>{{ optional($officers->where('id', $document->user_id)->first())->full_name }}</td>
                                <td>{{ $document->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('documents.show', $document->id) }}" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        @if($documents->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">No documents available.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Create Officer Modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createOfficerModal">
        <i class="fas fa-user-plus"></i> Create Officer
    </button>
    <div class="modal fade" id="createOfficerModal" tabindex="-1" aria-labelledby="createOfficerModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createOfficerModalLabel">Create New Officer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="createOfficerForm" method="POST" action="{{ route('admin.create_officer') }}">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label for="officerFirstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="officerFirstname" name="firstname" required>
              </div>
              <div class="mb-3">
                <label for="officerLastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="officerLastname" name="lastname" required>
              </div>
              <div class="mb-3">
                <label for="officerEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="officerEmail" name="email" required>
              </div>
              <div class="mb-3">
                <label for="officerPassword" class="form-label">Password</label>
                <input type="text" class="form-control" id="officerPassword" name="password" required>
              </div>
              <div class="mb-3">
                <label for="officerLocation" class="form-label">Assign Location</label>
                <select class="form-select" id="officerLocation" name="location_id" required>
                  <option value="">-- Select Location --</option>
                  @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Create Officer</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <livewire:admin-officer-management />
</div>
<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap5.min.css') }}" />
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#assignmentsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });
        $('#officerDocumentsTable').DataTable();
    });
    $(function() {
      $('#createOfficerForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
          url: form.attr('action'),
          method: 'POST',
          data: form.serialize(),
          success: function(response) {
            location.reload(); // Reload to update tables
          },
          error: function(xhr) {
            alert('Error: ' + (xhr.responseJSON?.message || 'Could not create officer.'));
          }
        });
      });
    });
</script>
@endsection
