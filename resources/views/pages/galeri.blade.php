@extends('layouts.public')

@section('title', 'Galeri - Dr. H. M. Nasir Djamil, M.Si')
@section('description', 'Galeri dokumentasi kegiatan Dr. H. M. Nasir Djamil, M.Si, termasuk dialog konstituen, reses, rapat kerja, agenda kelembagaan, dan video dokumentasi.')
@section('page', 'galeri')

@section('content')
<header class="page-hero">
    <div class="page-hero-kop">Dokumentasi</div>
    <h1>Galeri <em>Kegiatan</em></h1>
    <p>Dokumentasi visual kegiatan publik, dialog konstituen, kunjungan kerja, rapat kerja, dan agenda kelembagaan.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a><span>/</span><span>Galeri</span></div>
</header>

<div class="filter-wrap" data-filter-group="galeri">
    <button class="filter-btn active" type="button" data-filter="semua">Semua</button>
    <button class="filter-btn" type="button" data-filter="reses">Reses</button>
    <button class="filter-btn" type="button" data-filter="rapat-kerja">Rapat Kerja</button>
    <button class="filter-btn" type="button" data-filter="kunjungan-kerja">Kunjungan Kerja</button>
    <button class="filter-btn" type="button" data-filter="legislasi">Legislasi</button>
    <button class="filter-btn" type="button" data-filter="dialog-konstituen">Dialog Konstituen</button>
    <button class="filter-btn" type="button" data-filter="video-dokumentasi">Video Dokumentasi</button>
</div>

<section class="section filter-panel" data-filter-panel="galeri" data-filter-panel-categories="reses rapat-kerja kunjungan-kerja legislasi dialog-konstituen" data-show-on-all="true">
    <div class="gallery-album-grid">
        @foreach ($albums as $album)
            <article class="gallery-album-card reveal filterable" data-filterable="galeri" data-category="{{ $album['filter'] }}">
                <a class="gallery-album-cover" href="{{ route('galeri.show', $album['slug']) }}" aria-label="Buka galeri {{ $album['title'] }}">
                    <img src="{{ asset($album['cover']) }}" alt="{{ $album['title'] }}">
                    <span class="gallery-folder-tab" aria-hidden="true"></span>
                    <span class="gallery-count">{{ count($album['photos']) }} Foto</span>
                </a>

                <div class="gallery-album-body">
                    <span class="badge badge-emas">{{ $album['category'] }}</span>
                    <h2>{{ $album['title'] }}</h2>
                    <div class="gallery-album-meta">
                        <span>{{ $album['date'] }}</span>
                        <span>{{ $album['location'] }}</span>
                    </div>
                    <p>{{ $album['summary'] }}</p>
                    <a href="{{ route('galeri.show', $album['slug']) }}" class="btn btn-outline btn-sm">Buka Galeri</a>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="section video-doc-section filter-panel hidden" data-filter-panel="galeri" data-filter-panel-categories="video-dokumentasi" data-show-on-all="false">
    <div class="video-doc-header reveal">
        <span class="video-doc-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24">
                <path d="M5 7h2.6l1.3-2h6.2l1.3 2H19a2 2 0 0 1 2 2v8.5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z"></path>
                <circle cx="12" cy="13" r="3.4"></circle>
            </svg>
        </span>
        <div>
            <h2>Video Dokumentasi</h2>
            <p>Cuplikan kegiatan dari Instagram tim media Dr. H. M. Nasir Djamil.</p>
        </div>
    </div>

    <div class="video-doc-grid">
        @foreach ($videos as $video)
            <article class="video-doc-card reveal">
                <a class="video-doc-thumb" href="{{ $video['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Buka video {{ $video['title'] }} di Instagram">
                    <img src="{{ asset($video['thumbnail']) }}" alt="{{ $video['title'] }}">
                    <span class="video-doc-label" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 7h16v10H4z"></path>
                            <path d="m10 10 4 2-4 2z"></path>
                        </svg>
                        Reel
                    </span>
                    <span class="video-doc-play" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"></path>
                        </svg>
                    </span>
                </a>

                <div class="video-doc-info">
                    <h3>{{ $video['title'] }}</h3>
                    <p>{{ $video['location'] }} | {{ $video['date'] }}</p>
                </div>
            </article>
        @endforeach

        <a class="video-doc-instagram reveal" href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer">
            <span class="video-doc-instagram-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                    <circle cx="12" cy="12" r="4"></circle>
                    <circle cx="17.5" cy="6.5" r="1.2"></circle>
                </svg>
            </span>
            <strong>Lihat semua di Instagram</strong>
        </a>
    </div>
</section>
@endsection
