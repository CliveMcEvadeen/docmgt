<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Document Management System</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 56px;
            background-color: #f8f9fa;
        }
        .card-icon {
            font-size: 2.5rem;
            color: #ff2d20;
        }
        .topbar-logout {
            color: white;
            text-decoration: none;
        }
        .topbar-logout:hover {
            color: #ffc1b0;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">File Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopbar" aria-controls="navbarTopbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarTopbar">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link topbar-logout" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mt-4">
        <h1 class="mb-4 text-danger">Dashboard</h1>

        <div class="row g-4">
            <!-- Documents Card -->
            <div class="col-md-3 d-flex">
                <div class="card shadow-sm flex-fill">
                    <div class="card-body d-flex align-items-center h-100">
                        <div class="me-3">
                            <i class="bi bi-folder2-open card-icon"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Documents</h5>
                            <p class="card-text text-muted">1,234 total</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="col-md-3 d-flex">
                <div class="card shadow-sm flex-fill">
                    <div class="card-body d-flex align-items-center h-100">
                        <div class="me-3">
                            <i class="bi bi-people card-icon"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Users</h5>
                            <p class="card-text text-muted">567 active</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div class="col-md-3 d-flex">
                <div class="card shadow-sm flex-fill">
                    <div class="card-body d-flex align-items-center h-100">
                        <div class="me-3">
                            <i class="bi bi-clock-history card-icon"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Recent Activity</h5>
                            <p class="card-text text-muted">Last updated 2 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Storage Usage Card -->
            <div class="col-md-3 d-flex">
                <div class="card shadow-sm flex-fill">
                    <div class="card-body d-flex align-items-center h-100">
                        <div class="me-3">
                            <i class="bi bi-hdd card-icon"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Storage Usage</h5>
                            <p class="card-text text-muted">75% used of 500GB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional dummy features -->
        <div class="row mt-5">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        Notifications
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">New document uploaded by user123</li>
                        <li class="list-group-item">User456 requested access to folder "Projects"</li>
                        <li class="list-group-item">System backup completed successfully</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        Quick Actions
                    </div>
                    <div class="card-body">
                        <button class="btn btn-danger me-2">Upload Document</button>
                        <button class="btn btn-outline-danger">Manage Users</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</body>
</html>
