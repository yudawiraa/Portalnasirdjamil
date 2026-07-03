<nav class="topnav" data-site-nav>
    <a class="nav-brand" href="{{ route('home') }}">
        <span class="nav-logo">NJ</span>
        <span class="nav-title">
            <strong>Portal Nasir Djamil</strong>
            <span>Komisi III DPR RI &middot; Dapil Aceh II</span>
        </span>
    </a>
    <button class="nav-toggle" type="button" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="primary-navigation" data-nav-toggle>
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div class="nav-links" id="primary-navigation" data-nav-menu>
        <a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>Beranda</a>
        <a href="{{ route('profil') }}" @class(['active' => request()->routeIs('profil')])>Profil</a>
        <a href="{{ route('kegiatan') }}" @class(['active' => request()->routeIs('kegiatan*')])>Kegiatan</a>
        <a href="{{ route('galeri') }}" @class(['active' => request()->routeIs('galeri*')])>Galeri</a>
        <a href="{{ route('aspirasi.create') }}" @class(['nav-cta', 'active' => request()->routeIs('aspirasi.create')])>Aspirasi</a>
    </div>
</nav>
