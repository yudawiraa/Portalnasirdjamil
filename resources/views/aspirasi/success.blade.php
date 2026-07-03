@extends('layouts.public')

@section('title', 'Aspirasi Berhasil Terkirim')
@section('robots', 'noindex, nofollow')

@section('content')
<header class="page-hero">
    <div class="page-hero-kop">Berhasil</div>
    <h1>Aspirasi <em>Terkirim</em></h1>
    <p>Simpan kode aspirasi berikut untuk memantau perkembangan penanganan.</p>
</header>

<section class="section">
    <div class="form-card reveal" style="max-width:680px;margin:0 auto;text-align:center">
        <div class="alert alert-sukses">Aspirasi berhasil disimpan ke sistem.</div>
        <p class="muted">Kode Aspirasi</p>
        <div style="font-family:'Playfair Display',serif;font-size:2.4rem;color:var(--merah);font-weight:800;letter-spacing:.08em;margin:12px 0">{{ $aspirasi->code }}</div>
        <p class="muted">Tim akan memverifikasi aspirasi Anda. Gunakan kode ini bersama nomor WhatsApp untuk cek status.</p>
        <div class="actions" style="justify-content:center;margin-top:24px">
            <a href="{{ route('aspirasi.track.form') }}" class="btn btn-merah">Cek Status Aspirasi</a>
            <a href="{{ route('home') }}" class="btn btn-outline">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection
