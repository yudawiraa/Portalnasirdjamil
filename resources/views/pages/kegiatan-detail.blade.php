@extends('layouts.public')

@section('title', $activity['title'] . ' - Dr. H. M. Nasir Djamil, M.Si')
@section('description', $activity['summary'])
@section('image', asset($activity['image']))
@section('page', 'kegiatan')

@section('content')
<header class="page-hero">
    <div class="page-hero-kop">{{ $activity['category'] }}</div>
    <h1>{{ $activity['title'] }}</h1>
    <p>{{ $activity['summary'] }}</p>
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span>/</span>
        <a href="{{ route('kegiatan') }}">Kegiatan</a>
        <span>/</span>
        <span>{{ $activity['title'] }}</span>
    </div>
</header>

<section class="section">
    <div class="kegiatan-detail-layout">
        <article class="kegiatan-detail-main reveal">
            <div class="kegiatan-detail-media">
                <img src="{{ asset($activity['image']) }}" alt="{{ $activity['title'] }}">
            </div>

            <div class="section-kop">Detail Kegiatan</div>
            <h2 class="section-judul">{{ $activity['title'] }}</h2>

            @foreach ($activity['body'] as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach

            @if (! empty($activity['videos']))
                <section class="activity-video-section reveal">
                    <div class="section-kop">Video Dokumentasi</div>
                    <h2 class="activity-video-title">Video Dokumentasi</h2>
                    <p class="activity-video-lead">Dokumentasi video dari Instagram dapat diputar langsung di halaman ini. Gunakan tombol putar untuk membuka embed resmi Instagram tanpa meninggalkan website.</p>

                    <div class="activity-video-grid">
                        @foreach ($activity['videos'] as $video)
                            @php($videoId = 'video-'.$activity['slug'].'-'.$loop->index)
                            <article class="activity-video-card" data-video-card>
                                <button class="activity-video-thumb" type="button" data-video-toggle aria-controls="{{ $videoId }}" aria-expanded="false">
                                    <img src="{{ asset($video['thumbnail']) }}" alt="{{ $video['title'] }}">
                                    <span class="activity-video-play" aria-hidden="true">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"></path>
                                        </svg>
                                    </span>
                                    <span class="activity-video-source">{{ $video['source'] }}</span>
                                </button>

                                <div class="activity-video-body">
                                    <h3>{{ $video['title'] }}</h3>
                                    <p>{{ $video['summary'] }}</p>
                                    <div class="activity-video-actions">
                                        <button class="btn btn-merah btn-sm" type="button" data-video-toggle aria-controls="{{ $videoId }}" aria-expanded="false">Putar Embed</button>
                                        <a class="btn btn-outline btn-sm" href="{{ $video['url'] }}" target="_blank" rel="noopener noreferrer">Buka Instagram</a>
                                    </div>
                                </div>

                                <div class="activity-video-embed" id="{{ $videoId }}" data-video-embed hidden>
                                    <blockquote class="instagram-media" data-instgrm-permalink="{{ $video['url'] }}" data-instgrm-version="14">
                                        <a href="{{ $video['url'] }}" target="_blank" rel="noopener noreferrer">Lihat Reel Instagram</a>
                                    </blockquote>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <script async src="https://www.instagram.com/embed.js"></script>
            @endif
        </article>

        <aside class="kegiatan-detail-side reveal">
            <div class="card">
                <span class="badge badge-emas">{{ $activity['category'] }}</span>
                <div class="detail-info-list">
                    <div>
                        <span>Tanggal Kegiatan</span>
                        <strong>{{ $activity['date'] }}</strong>
                    </div>
                    <div>
                        <span>Lokasi</span>
                        <strong>{{ $activity['location'] }}</strong>
                    </div>
                    <div>
                        <span>Agenda</span>
                        <strong>{{ $activity['title'] }}</strong>
                    </div>
                </div>
            </div>

            <div class="kegiatan-aspirasi-box">
                <h3>Punya masukan terkait kegiatan ini?</h3>
                <p>Sampaikan melalui halaman aspirasi agar dapat tercatat dan ditindaklanjuti secara tertib.</p>
                <a href="{{ route('aspirasi.create') }}" class="btn btn-merah">Kirim Aspirasi</a>
            </div>
        </aside>
    </div>
</section>
@endsection
