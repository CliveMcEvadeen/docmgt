@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Super Admin Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-users fa-3x me-3"></i>
                    <div>
                        <h5 class="card-title">Total Admins</h5>
                        <p class="card-text fs-4">{{ $admins->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-folder-open fa-3x me-3"></i>
                    <div>
                        <h5 class="card-title">Total Documents</h5>
                        <p class="card-text fs-4">{{ $documents->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add more cards as needed -->
    </div>

    <section class="mb-5">
        <h2 class="mb-3">Manage Admin Accounts</h2>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->full_name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->mobile_no }}</td>
                            <td>
                                <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-sm btn-primary me-1">Edit</a>
                                <form action="{{ route('admin.delete', $admin->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($admins->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">No admin accounts found.</td>
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
</div>
@endsection
