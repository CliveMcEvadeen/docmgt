<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-secondary sidebar collapse" style="min-height: 100vh; transition: all 0.3s ease;">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            @auth
                {{-- Debug output for user role --}}
                @if(Auth::user()->role === 'super_admin')
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('superadmin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-3 fa-lg icon-advanced"></i> Dashboard Overview
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('superadmin.admins') }}">
                            <i class="fas fa-users me-3 fa-lg icon-advanced"></i> Admin Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('superadmin.officers') }}">
                            <i class="fas fa-user-shield me-3 fa-lg icon-advanced"></i> Officer Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('superadmin.documents') }}">
                            <i class="fas fa-folder-open me-3 fa-lg icon-advanced"></i> Document Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('superadmin.locations') }}">
                            <i class="fas fa-map-marker-alt me-3 fa-lg icon-advanced"></i> Location Management
                        </a>
                    </li>
                @elseif(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-3 fa-lg icon-advanced"></i> Dashboard Overview
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('admin.officers') }}">
                            <i class="fas fa-user-shield me-3 fa-lg icon-advanced"></i> Officer Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('admin.assignments') }}">
                            <i class="fas fa-tasks me-3 fa-lg icon-advanced"></i> Assignments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('admin.documents') }}">
                            <i class="fas fa-folder-open me-3 fa-lg icon-advanced"></i> Documents
                        </a>
                    </li>
                @elseif(Auth::user()->role === 'officer')
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('officer.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-3 fa-lg icon-advanced"></i> Officer Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('officer.report_form') }}">
                            <i class="fas fa-file-alt me-3 fa-lg icon-advanced"></i> Submit Report
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-effect" href="{{ route('officer.documents') }}">
                            <i class="fas fa-folder-open me-3 fa-lg icon-advanced"></i> Documents
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
</nav>

<style>
    .hover-effect:hover {
        background-color: rgba(255, 255, 255, 0.2);
        color: #fff !important;
        text-decoration: none;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    .icon-advanced {
        transition: transform 0.3s ease;
    }
    .hover-effect:hover .icon-advanced {
        transform: scale(1.2) rotate(10deg);
        color: #ffd700 !important;
    }
</style>
