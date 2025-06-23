<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Document Management System</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    @livewireStyles
    <style>
        /* Advanced top navbar styling */
        nav.navbar {
            background: linear-gradient(90deg, #a3b8c3 0%, #d1d9de 100%);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1030;
        }
        nav.navbar .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #182848 !important;
        }
        nav.navbar .navbar-brand i {
            margin-right: 0.5rem;
            color: #4b6cb7;
            transition: transform 0.3s ease;
        }
        nav.navbar .navbar-brand:hover i {
            transform: rotate(20deg) scale(1.2);
        }
        nav.navbar .btn-outline-danger {
            border-color: #4b6cb7;
            color: #4b6cb7;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        nav.navbar .btn-outline-danger:hover {
            background-color: #4b6cb7;
            color: #fff;
        }
        nav.navbar .btn-outline-primary {
            border-color: #4b6cb7;
            color: #4b6cb7;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        nav.navbar .btn-outline-primary:hover {
            background-color: #4b6cb7;
            color: #fff;
        }
        nav.navbar .btn-primary {
            background-color: #4b6cb7;
            border-color: #4b6cb7;
            color: #fff;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        nav.navbar .btn-primary:hover {
            background-color: #3a5490;
            border-color: #3a5490;
            color: #fff;
        }
        nav.navbar .d-flex.align-items-center span {
            color: #182848;
            font-weight: 600;
        }
        body {
            /* Remove or reduce padding-top to fix white space */
            padding-top: 0 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <i class="fas fa-shield-alt"></i>
                <span>DMIS</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-flex align-items-center ms-auto">
                @auth
                <span class="me-3">Hello, {{ Auth::user()->firstname }}</span>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">Logout</a>
                @endauth
                @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                @endguest
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @include('components.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle CDN (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
