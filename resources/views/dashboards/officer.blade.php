@extends('layouts.app')

@section('content')
<style>
  html, body {
    /* overflow: hidden !important; */
    height: 100%;
  }
</style>
<div class="container-fluid mt-4">
    <h1 class="mb-4">Officer Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-primary text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-file-alt fa-3x me-3 text-primary"></i>
                    <div>
                        <h5 class="card-title">Daily Reports Submitted</h5>
                        <p class="card-text fs-4">{{ $dailyReports->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-users fa-3x me-3 text-success"></i>
                    <div>
                        <h5 class="card-title">Assigned Locations</h5>
                        <p class="card-text fs-4">{{ $locations->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-folder-open fa-3x me-3 text-info"></i>
                    <div>
                        <h5 class="card-title">Documents Available</h5>
                        <p class="card-text fs-4">{{ $documents->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-chart-line fa-3x me-3 text-warning"></i>
                    <div>
                        <h5 class="card-title">Reports This Month</h5>
                        <p class="card-text fs-4">{{ $dailyReports->where('report_date', '>=', now()->startOfMonth()->toDateString())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="mb-4">
        <h2 class="mb-3">Top Documents</h2>
        <div class="card">
            <div class="card-body">
                <table id="topDocumentsTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Uploaded On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents->take(5) as $document)
                        <tr>
                            <td>{{ $document->title }}</td>
                            <td>{{ $document->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('documents.show', $document->id) }}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                        @if($documents->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center text-muted">No documents available.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <a href="{{ route('officer.documents') }}" class="btn btn-secondary mt-3">View More</a>
            </div>
        </div>
    </section>
</div>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap5.min.css') }}" />
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#topDocumentsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });
    });
</script>
@endsection
