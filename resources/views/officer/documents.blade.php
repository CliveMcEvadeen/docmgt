@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">All Uploaded Documents</h1>
    <div class="card">
        <div class="card-body">
            <table id="allDocumentsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Uploaded On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                    <tr>
                        <td>{{ $document->title }}</td>
                        <td>{{ $document->description ?? 'N/A' }}</td>
                        <td>{{ $document->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('documents.show', $document->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
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
</div>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap5.min.css') }}" />
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#allDocumentsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });
    });
</script>
@endsection
