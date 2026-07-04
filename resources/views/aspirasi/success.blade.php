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
        <div class="success-code">{{ $aspirasi->code }}</div>
        <div class="code-save-box">
            <strong>Simpan kode ini sekarang.</strong>
            <p>Kode aspirasi bukan OTP WhatsApp, jadi tidak dikirim otomatis ke WA. Salin, catat, atau screenshot halaman ini agar status bisa dicek kembali.</p>
        </div>
        <button class="btn btn-outline" type="button" data-copy="{{ $aspirasi->code }}" data-copy-label="Salin Kode Aspirasi" data-copy-success="Kode Tersalin">Salin Kode Aspirasi</button>
        <p class="muted" style="margin-top:18px">Tim akan memverifikasi aspirasi Anda. Gunakan kode ini bersama nomor WhatsApp untuk cek status.</p>
        <div class="actions" style="justify-content:center;margin-top:24px">
            <a href="{{ route('aspirasi.track.form') }}" class="btn btn-merah">Cek Status Aspirasi</a>
            <a href="{{ route('home') }}" class="btn btn-outline">Kembali ke Beranda</a>
        </div>
    </div>

    <div style="max-width:680px;margin:24px auto 0">
        @include('aspirasi.partials.code-help', ['adminWhatsapp' => $adminWhatsapp])
    </div>
</section>
@endsection
