<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-hospital me-2 text-primary"></i>
            <strong>FIO</strong> Hospital
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                @if (Auth::guard('web')->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('doctors.index') }}">Doctor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('patients.index') }}">Patient</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.index') }}">Staff</a>
                    </li>
                @elseif(Auth::guard('doctor')->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('doctor.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('doctor.slots.index') }}">Slots</a>
                    </li>
                @elseif(Auth::guard('patient')->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('patient.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('patient.appointments.index') }}">Appointments</a>
                    </li>
                @elseif(Auth::guard('staff')->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.dashboard') }}">Dashboard</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.checkin') }}">Check In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.checkout') }}">Check Out</a>
                    </li> -->
                @endif
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            
                            @if(Auth::guard('doctor')->check())
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::guard('doctor')->user()->full_name }}
                            @elseif(Auth::guard('web')->check())
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            @elseif(Auth::guard('patient')->check())
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::guard('patient')->user()->full_name }}
                            @elseif(Auth::guard('staff')->check())
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::guard('staff')->user()->full_name }}
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            
                            @if(Auth::guard('doctor')->check())
                            <a class="dropdown-item" href="{{ route('doctor.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </a>
                            
                            <form id="logout-form" action="{{ route('doctor.logout') }}" method="POST" class="d-none">
                                @csrf       
                            </form>
                            
                            @elseif(Auth::guard('web')->check())
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf       
                            </form>
                            @elseif(Auth::guard('patient')->check())
                            <a class="dropdown-item" href="{{ route('patient.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </a>
                            
                            <form id="logout-form" action="{{ route('patient.logout') }}" method="POST" class="d-none">
                                @csrf       
                            </form>
                            @elseif(Auth::guard('staff')->check())
                            <a class="dropdown-item" href="{{ route('staff.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </a>
                            
                            <form id="logout-form" action="{{ route('staff.logout') }}" method="POST" class="d-none">
                                @csrf       
                            </form>
                            @endif
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

        <main class="pt-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Your custom scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>