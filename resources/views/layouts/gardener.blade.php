<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gardener Dashboard') - Plant Disease Detection</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f9f4;
        }

        .sidebar {
            position: fixed;
            min-height: 100vh;
            background: #356859;
            color: #fff;
        }

        .sidebar h5 {
            font-weight: bold;
            padding: 1rem;
        }

        .sidebar .nav-link {
            color: #d1fae5;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            transition: all 0.2s ease-in-out;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #37966f;
            color: #fff;
            border-left: 5px solid #f4a261;
        }

        .main-content {
            background-color: #f4f9f4;
            min-height: 100vh;
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-radius: 0.5rem;
        }

        .navbar-top {
            background-color: #356859;
            padding: 0.75rem 1rem;
            color: #fff;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-4">
                    <div class="text-center mb-4">
                        <h5>🌿 Gardener Panel</h5>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('gardener.dashboard') ? 'active' : '' }}" 
                               href="{{ route('gardener.dashboard') }}">
                                <i class="fas fa-seedling me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('gardener.treatments*') ? 'active' : '' }}" 
                               href="{{ route('gardener.treatments.index') }}">
                                <i class="fas fa-syringe me-2"></i> Manage Treatments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <div class="navbar-top rounded mb-4">
                    Welcome, Gardener! 🌱
                </div>

                <div class="mb-3">
                    <h2 class="fw-bold text-success">@yield('page-title', 'Dashboard')</h2>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
