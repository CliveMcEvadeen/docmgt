@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4">Admin Dashboard Overview</h1>
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-success text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-users fa-3x me-3 text-success"></i>
                    <div>
                        <h5 class="card-title">Total Officers</h5>
                        <p class="card-text fs-4">{{ $officers->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-warning text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-tasks fa-3x me-3 text-warning"></i>
                    <div>
                        <h5 class="card-title">Total Assignments</h5>
                        <p class="card-text fs-4">{{ $assignments->count() ?? 'N/A' }}</p>
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
        <div class="col-md-3 mb-3">
            <div class="card border-primary text-dark h-100" style="background-color: white;">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-chart-line fa-3x me-3 text-primary"></i>
                    <div>
                        <h5 class="card-title">Reports</h5>
                        <p class="card-text fs-4">{{ $reports->count() ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-8 mb-3">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-chart-bar me-2"></i> Daily Reports (Last 7 Days)
                </div>
                <div class="card-body">
                    <canvas id="dailyReportsChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <i class="fas fa-chart-pie me-2"></i> Officer vs Assignment Distribution
                </div>
                <div class="card-body">
                    <canvas id="officerAssignmentPieChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.officers') }}" class="btn btn-outline-success w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center">
                <i class="fas fa-user-shield fa-2x mb-2"></i>
                <span>Manage Officers</span>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.documents') }}" class="btn btn-outline-info w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center">
                <i class="fas fa-folder-open fa-2x mb-2"></i>
                <span>Manage Documents</span>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.assignments') }}" class="btn btn-outline-primary w-100 h-100 py-4 d-flex flex-column align-items-center justify-content-center">
                <i class="fas fa-tasks fa-2x mb-2"></i>
                <span>Manage Assignments</span>
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Prepare data for last 7 days
            var reportLabels = [];
            var reportCounts = [];
            @php
                $today = now()->startOfDay();
                $counts = [];
                $labels = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = $today->copy()->subDays($i);
                    $count = $reports->where('created_at', '>=', $date)
                                     ->where('created_at', '<', $date->copy()->addDay())
                                     ->count();
                    $counts[] = $count;
                    $labels[] = $date->format('D');
                }
            @endphp
            reportLabels = @json($labels);
            reportCounts = @json($counts);
            // Daily Reports Bar Chart
            var ctxReports = document.getElementById('dailyReportsChart').getContext('2d');
            new Chart(ctxReports, {
                type: 'bar',
                data: {
                    labels: reportLabels,
                    datasets: [{
                        label: 'Daily Reports',
                        data: reportCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)'
                    }]
                },
                options: {responsive: true, plugins: {legend: {position: 'top'}}}
            });
            // Officer vs Assignment Pie Chart
            var ctxPie = document.getElementById('officerAssignmentPieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Officers', 'Assignments'],
                    datasets: [{
                        data: [{{ $officers->count() }}, {{ $assignments->count() }}],
                        backgroundColor: ['#36A2EB', '#FFCE56']
                    }]
                },
                options: {responsive: true, plugins: {legend: {position: 'bottom'}}}
            });
        });
    </script>
</div>
@endsection
