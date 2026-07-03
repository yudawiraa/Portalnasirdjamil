<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dr. H. M. Nasir Djamil, M.Si')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body data-page="@yield('page', '')">
    @include('partials.nav')

    <main class="page-wrap">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
