@extends('layouts.public')

@section('title', $album['title'] . ' - Galeri Dr. H. M. Nasir Djamil, M.Si')
@section('page', 'galeri')

@section('content')
<header class="page-hero">
    <div class="page-hero-kop">{{ $album['category'] }}</div>
    <h1>{{ $album['title'] }}</h1>
    <p>{{ $album['summary'] }}</p>
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span>/</span>
        <a href="{{ route('galeri') }}">Galeri</a>
        <span>/</span>
        <span>{{ $album['title'] }}</span>
    </div>
</header>

<section class="section">
    <div class="album-detail-head reveal">
        <div>
            <div class="section-kop">Album Dokumentasi</div>
            <h2 class="section-judul">{{ $album['title'] }}</h2>
        </div>
        <div class="album-detail-meta">
            <span>{{ $album['category'] }}</span>
            <span>{{ $album['date'] }}</span>
            <span>{{ $album['location'] }}</span>
            <span>{{ count($album['photos']) }} Foto</span>
        </div>
    </div>

    <div class="album-photo-grid">
        @foreach ($album['photos'] as $photo)
            <figure class="album-photo-card reveal">
                <img src="{{ asset($photo['src']) }}" alt="{{ $photo['caption'] }}">
                <figcaption>{{ $photo['caption'] }}</figcaption>
            </figure>
        @endforeach
    </div>

    <div class="album-back-action reveal">
        <a href="{{ route('galeri') }}" class="btn btn-outline">Kembali ke Galeri</a>
    </div>
</section>
@endsection
