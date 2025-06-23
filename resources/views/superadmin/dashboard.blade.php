@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4">Super Admin Dashboard Overview</h1>
    @include('superadmin.partials.overview')

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark">
                <i class="fas fa-chart-pie me-2"></i> Role Distribution
            </div>
            <div class="card-body">
                <canvas id="rolePieChart" height="80"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card h-100">
            <div class="card-header bg-info text-white">
                <i class="fas fa-bolt me-2"></i> Quick Links
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('superadmin.admins') }}" class="btn btn-outline-primary w-100"><i class="fas fa-users me-2"></i>Manage Admins</a>
                <a href="{{ route('superadmin.officers') }}" class="btn btn-outline-success w-100"><i class="fas fa-user-shield me-2"></i>Manage Officers</a>
                <a href="{{ route('superadmin.documents') }}" class="btn btn-outline-info w-100"><i class="fas fa-folder-open me-2"></i>Manage Documents</a>
            </div>
        </div>
    </div>
    <div class="col-md-7 mb-3">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-chart-bar me-2"></i> Daily Reports (Last 7 Days)
            </div>
            <div class="card-body">
                <canvas id="dailyReportsChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Daily Reports Bar Chart
            var ctxReports = document.getElementById('dailyReportsChart').getContext('2d');
            new Chart(ctxReports, {
                type: 'bar',
                data: {
                    labels: @json($reportLabels),
                    datasets: [{
                        label: 'Daily Reports',
                        data: @json($reportCounts),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)'
                    }]
                },
                options: {responsive: true, plugins: {legend: {position: 'top'}}}
            });
            // Role Pie Chart
            var ctxPie = document.getElementById('rolePieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Admins', 'Officers'],
                    datasets: [{
                        data: [{{ $admins->count() }}, {{ $officers->count() }}],
                        backgroundColor: ['#36A2EB', '#4BC0C0']
                    }]
                },
                options: {responsive: true, plugins: {legend: {position: 'bottom'}}}
            });
        });
    </script>
@endsection
