@extends('layouts.app')

@section('content')
<style>
  html, body {
    /* overflow: hidden !important; */
    height: 100%;
  }
</style>
<div class="container-fluid mt-4">
    <h1 class="mb-4">Super Admin Dashboard</h1>
    <div class="row mb-4">
        <div class="col-md-8 mb-3">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-chart-bar me-2"></i> User Growth (Admins & Officers)
                </div>
                <div class="card-body">
                    <canvas id="userGrowthChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-bolt me-2"></i> Quick Links
                </div>
                <div class="card-body d-flex flex-column gap-2">
                    <a href="{{ route('super_admin.users') }}" class="btn btn-outline-primary w-100"><i class="fas fa-users me-2"></i>Manage Admins</a>
                    <a href="{{ route('super_admin.dashboard') }}" class="btn btn-outline-success w-100"><i class="fas fa-user-shield me-2"></i>Manage Officers</a>
                    <a href="{{ route('super_admin.documents') }}" class="btn btn-outline-info w-100"><i class="fas fa-folder-open me-2"></i>Manage Documents</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <i class="fas fa-chart-pie me-2"></i> Role Distribution
                </div>
                <div class="card-body">
                    <canvas id="rolePieChart" height="120"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-chart-line me-2"></i> Recent Activity (Last 7 Days)
                </div>
                <div class="card-body">
                    <canvas id="activityLineChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <a href="{{ route('super_admin.users') }}" style="text-decoration:none;">
                <div class="card border-primary text-dark h-100" style="background-color: white;">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-user-shield fa-3x me-3 text-primary"></i>
                        <div>
                            <h5 class="card-title">Total Admins</h5>
                            <p class="card-text fs-4">{{ $admins->count() }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('super_admin.dashboard') }}" style="text-decoration:none;">
                <div class="card border-success text-dark h-100" style="background-color: white;">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-users fa-3x me-3 text-success"></i>
                        <div>
                            <h5 class="card-title">Total Officers</h5>
                            <p class="card-text fs-4">{{ $officers->count() }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('super_admin.documents') }}" style="text-decoration:none;">
                <div class="card border-info text-dark h-100" style="background-color: white;">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-folder-open fa-3x me-3 text-info"></i>
                        <div>
                            <h5 class="card-title">Documents</h5>
                            <p class="card-text fs-4">{{ $documents->count() }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-chart-line fa-3x me-3 text-warning"></i>
                    <div>
                        <h5 class="card-title">Reports</h5>
                        <p class="card-text fs-4">{{ $reports->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="mb-4">
        <h2 class="mb-3">Admins</h2>
        <div class="card">
            <div class="card-body">
                <table id="adminsTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->full_name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                        @if($admins->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center text-muted">No admins available.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="mb-4">
        <h2 class="mb-3">Officers</h2>
        <div class="card">
            <div class="card-body">
                <table id="officersTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($officers as $officer)
                        <tr>
                            <td>{{ $officer->full_name }}</td>
                            <td>{{ $officer->email }}</td>
                            <td>{{ $officer->location->name ?? '-' }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                        @if($officers->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">No officers available.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="mb-4">
        <h2 class="mb-3">Documents</h2>
        <div class="card">
            <div class="card-body">
                <table id="documentsTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Uploaded On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $document)
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
            </div>
        </div>
    </section>
    <section class="mb-4">
        <h2 class="mb-3">All Documents</h2>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered" id="allDocumentsTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Uploaded By</th>
                            <th>Role</th>
                            <th>Uploaded On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $document)
                        <tr>
                            <td>{{ $document->title }}</td>
                            <td>{{ optional($document->user)->full_name ?? '-' }}</td>
                            <td>{{ optional($document->user)->role ?? '-' }}</td>
                            <td>{{ $document->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('documents.show', $document->id) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        @if($documents->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center text-muted">No documents available.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="mb-4">
        <h2 class="mb-3">All Officers</h2>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered" id="allOfficersTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($officers as $officer)
                        <tr>
                            <td>{{ $officer->full_name }}</td>
                            <td>{{ $officer->email }}</td>
                            <td>{{ optional(optional($officer->assignment)->location)->name ?? '-' }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        @if($officers->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">No officers available.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="mb-4">
        <h2 class="mb-3">All Admins</h2>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered" id="allAdminsTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->full_name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        @if($admins->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center text-muted">No admins available.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap5.min.css') }}" />
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#adminsTable').DataTable();
        $('#officersTable').DataTable();
        $('#documentsTable').DataTable();
        $('#allDocumentsTable').DataTable();
        $('#allOfficersTable').DataTable();
        $('#allAdminsTable').DataTable();
    });
    document.addEventListener('DOMContentLoaded', function () {
        // User Growth Chart
        var ctxGrowth = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(ctxGrowth, {
            type: 'bar',
            data: {
                labels: @json($userGrowthLabels ?? ['Jan','Feb','Mar','Apr','May','Jun','Jul']),
                datasets: [
                    {
                        label: 'Admins',
                        data: @json($userGrowthAdmins ?? [2,3,4,5,6,7,8]),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)'
                    },
                    {
                        label: 'Officers',
                        data: @json($userGrowthOfficers ?? [5,6,7,8,9,10,12]),
                        backgroundColor: 'rgba(75, 192, 192, 0.7)'
                    }
                ]
            },
            options: {responsive: true, plugins: {legend: {position: 'top'}}}
        });
        // Role Pie Chart
        var ctxPie = document.getElementById('rolePieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: @json(['Admins', 'Officers']),
                datasets: [{
                    data: @json([$admins->count(), $officers->count()]),
                    backgroundColor: @json(['#36A2EB', '#4BC0C0'])
                }]
            },
            options: {responsive: true, plugins: {legend: {position: 'bottom'}}}
        });
        // Activity Line Chart
        var ctxLine = document.getElementById('activityLineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: @json($activityLabels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']),
                datasets: [
                    {
                        label: 'Logins',
                        data: @json($activityLogins ?? [5,7,6,8,9,4,3]),
                        borderColor: '#36A2EB',
                        backgroundColor: 'rgba(54,162,235,0.2)',
                        fill: true
                    },
                    {
                        label: 'Documents Uploaded',
                        data: @json($activityDocs ?? [1,2,1,3,2,1,0]),
                        borderColor: '#4BC0C0',
                        backgroundColor: 'rgba(75,192,192,0.2)',
                        fill: true
                    }
                ]
            },
            options: {responsive: true, plugins: {legend: {position: 'top'}}}
        });
    });
</script>
@endsection
