<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Aspirasi')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell">
    <nav class="admin-nav">
        <a class="nav-brand" href="{{ route('admin.dashboard') }}">
            <span class="nav-logo">NJ</span>
            <span class="nav-title">
                <strong>Admin Aspirasi</strong>
                <span>Dr. H. M. Nasir Djamil, M.Si</span>
            </span>
        </a>
        <div class="admin-links">
            <a href="{{ route('home') }}" target="_blank">Lihat Situs</a>
            <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>Dashboard</a>
            <a href="{{ route('admin.aspirasi.index') }}" @class(['active' => request()->routeIs('admin.aspirasi.*')])>Aspirasi</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <main class="admin-main">
        @yield('content')
    </main>
</body>
</html>
