<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IoT Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 1rem 0;
        }

        .page-title::after {
            content: '';
            display: block;
            width: 40px;
            height: 3px;
            background: #0d6efd;
            margin-top: 0.3rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">IoT Dashboard</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('/') ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('sensor.*') ? 'active' : '' }}"
                        href="{{ route('sensor.index') }}">Sensor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('device.*') ? 'active' : '' }}"
                        href="{{ route('device.index') }}">Device</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>