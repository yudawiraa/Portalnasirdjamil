@extends('layouts.public')

@section('title', 'FAQ - Portal Nasir Djamil')
@section('description', 'Pertanyaan yang sering diajukan tentang Portal Nasir Djamil, layanan aspirasi, kode aspirasi, cek status, kegiatan, galeri, dan kontak admin.')
@section('page', 'faq')

@section('content')
@php
    $schemaContext = '@'.'context';
    $schemaType = '@'.'type';

    $faqSchemaItems = collect($faqSections)
        ->flatMap(fn ($section) => $section['items'])
        ->map(fn ($item) => [
            $schemaType => 'Question',
            'name' => $item['question'],
            'acceptedAnswer' => [
                $schemaType => 'Answer',
                'text' => $item['answer'],
            ],
        ])
        ->values();
@endphp

<header class="page-hero">
    <div class="page-hero-kop">Bantuan</div>
    <h1>Pertanyaan <em>Umum</em></h1>
    <p>Ringkasan pertanyaan penting tentang portal, layanan aspirasi, kode tracking, dokumentasi kegiatan, dan kontak admin.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a><span>/</span><span>FAQ</span></div>
</header>

<section class="section">
    <div class="grid-3">
        <div class="card reveal">
            <h3>Aspirasi Lebih Tertib</h3>
            <p>FAQ ini membantu masyarakat memahami cara mengirim aspirasi, menyimpan kode, dan mengecek status tanpa bingung dengan OTP WhatsApp.</p>
        </div>
        <div class="card reveal">
            <h3>Dokumentasi Kegiatan</h3>
            <p>Pengunjung dapat membedakan halaman kegiatan, galeri album, dan video dokumentasi sebagai arsip visual agenda publik.</p>
        </div>
        <div class="card reveal">
            <h3>Bantuan Admin</h3>
            <p>Jika kode aspirasi lupa atau data perlu diperbaiki, FAQ menjelaskan informasi apa yang perlu disiapkan sebelum menghubungi admin.</p>
        </div>
    </div>
</section>

<section class="section bg-gelap">
    <div class="section-kop reveal">FAQ</div>
    <h2 class="section-judul reveal">Yang Sering <em>Ditanyakan</em></h2>

    <div class="grid-2">
        @foreach ($faqSections as $section)
            <div class="card-dark reveal">
                <h3>{{ $section['title'] }}</h3>
                <div class="faq-list" style="margin-top:18px">
                    @foreach ($section['items'] as $item)
                        <details class="faq-item">
                            <summary>{{ $item['question'] }}</summary>
                            <p>{{ $item['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="section">
    <div class="grid-2">
        <div class="card reveal">
            <div class="section-kop">Layanan Konstituen</div>
            <h2 class="section-judul" style="font-size:1.7rem;margin-bottom:16px">Siap menyampaikan aspirasi?</h2>
            <p class="muted">Gunakan form aspirasi agar laporan memiliki kode tracking dan bisa dipantau statusnya.</p>
            <a href="{{ route('aspirasi.create') }}" class="btn btn-merah" style="margin-top:18px">Sampaikan Aspirasi</a>
        </div>
        <div class="card reveal">
            <div class="section-kop">Tracking</div>
            <h2 class="section-judul" style="font-size:1.7rem;margin-bottom:16px">Sudah punya kode?</h2>
            <p class="muted">Masukkan kode aspirasi dan nomor WhatsApp yang dipakai saat mengirim untuk melihat status terbaru.</p>
            <a href="{{ route('aspirasi.track.form') }}" class="btn btn-outline" style="margin-top:18px">Cek Status Aspirasi</a>
        </div>
    </div>
</section>

<script type="application/ld+json">
    {!! json_encode([
        $schemaContext => 'https://schema.org',
        $schemaType => 'FAQPage',
        'mainEntity' => $faqSchemaItems,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection
