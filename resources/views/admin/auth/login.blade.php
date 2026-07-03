<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin Aspirasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page">
    <div class="login-card reveal in">
        <div class="nav-brand" style="margin-bottom:26px">
            <span class="nav-logo">NJ</span>
            <span class="nav-title">
                <strong style="color:var(--teks)">Admin Aspirasi</strong>
                <span>Dr. H. M. Nasir Djamil, M.Si</span>
            </span>
        </div>
        <div class="section-kop">Area Admin</div>
        <h1 style="font-family:'Playfair Display',serif;font-size:2rem;margin-bottom:18px">Masuk Dashboard</h1>
        <p class="muted" style="margin-bottom:24px">Akses ini hanya untuk admin pengelola aspirasi.</p>

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" required>
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label style="display:flex;gap:9px;align-items:center;text-transform:none;letter-spacing:0;font-weight:600">
                    <input type="checkbox" name="remember" value="1">
                    Ingat sesi login
                </label>
            </div>
            <button type="submit" class="btn btn-merah" style="width:100%">Login</button>
        </form>
        <a href="{{ route('home') }}" class="btn btn-outline" style="width:100%;margin-top:12px">Kembali ke Situs</a>
    </div>
</body>
</html>
