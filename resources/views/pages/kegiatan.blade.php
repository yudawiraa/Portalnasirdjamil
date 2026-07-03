@extends('layouts.public')

@section('title', 'Kegiatan - Dr. H. M. Nasir Djamil, M.Si')
@section('description', 'Publikasi kegiatan Dr. H. M. Nasir Djamil, M.Si meliputi reses, rapat kerja, dialog konstituen, agenda legislasi, dan video dokumentasi.')
@section('page', 'kegiatan')

@section('content')
<header class="page-hero">
    <div class="page-hero-kop">Agenda &amp; Publikasi</div>
    <h1>Kegiatan <em>Terbaru</em></h1>
    <p>Dokumentasi kegiatan reses, rapat kerja, dialog konstituen, serta agenda legislasi bersama masyarakat dan mitra kerja.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a><span>/</span><span>Kegiatan</span></div>
</header>

<div class="filter-wrap" data-filter-group="kegiatan">
    <button class="filter-btn active" type="button" data-filter="semua">Semua</button>
    <button class="filter-btn" type="button" data-filter="reses">Reses</button>
    <button class="filter-btn" type="button" data-filter="rapat-kerja">Rapat Kerja</button>
    <button class="filter-btn" type="button" data-filter="legislasi">Legislasi</button>
    <button class="filter-btn" type="button" data-filter="aspirasi-masyarakat">Aspirasi Masyarakat</button>
    <button class="filter-btn" type="button" data-filter="video-dokumentasi">Video Dokumentasi</button>
</div>

<section class="section filter-panel" data-filter-panel="kegiatan" data-filter-panel-categories="reses rapat-kerja legislasi aspirasi-masyarakat" data-show-on-all="true">
    <div class="kegiatan-grid">
        @foreach ($activities as $activity)
            <article class="kegiatan-card reveal filterable" data-filterable="kegiatan" data-category="{{ $activity['filter'] }}">
                <a href="{{ route('kegiatan.show', $activity['slug']) }}" class="kegiatan-card-media" aria-label="Lihat detail {{ $activity['title'] }}">
                    @if (! empty($activity['image']))
                        <img src="{{ asset($activity['image']) }}" alt="{{ $activity['title'] }}">
                    @else
                        <div class="kegiatan-placeholder">
                            <span>{{ $activity['category'] }}</span>
                        </div>
                    @endif
                </a>

                <div class="kegiatan-card-body">
                    <span class="badge badge-emas">{{ $activity['category'] }}</span>
                    <h2>{{ $activity['title'] }}</h2>
                    <div class="kegiatan-meta">
                        <span>{{ $activity['location'] }}</span>
                        <span>{{ $activity['date'] }}</span>
                    </div>
                    <p>{{ $activity['summary'] }}</p>
                    <a href="{{ route('kegiatan.show', $activity['slug']) }}" class="btn btn-outline btn-sm">Lihat Detail</a>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="section video-doc-section filter-panel hidden" data-filter-panel="kegiatan" data-filter-panel-categories="video-dokumentasi" data-show-on-all="false">
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
