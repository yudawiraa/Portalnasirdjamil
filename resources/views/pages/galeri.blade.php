@extends('layouts.public')

@section('title', 'Galeri - Dr. H. M. Nasir Djamil, M.Si')
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
</div>

<section class="section">
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
@endsection
