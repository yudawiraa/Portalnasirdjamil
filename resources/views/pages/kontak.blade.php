@extends('layouts.public')

@section('title', 'Kontak - Dr. H. M. Nasir Djamil, M.Si')
@section('description', 'Informasi kontak kantor dan kanal layanan aspirasi konstituen Dr. H. M. Nasir Djamil, M.Si.')

@section('content')
<header class="page-hero">
    <div class="page-hero-kop">Kontak</div>
    <h1>Kontak & <em>Lokasi</em></h1>
    <p>Informasi kontak kantor dan kanal layanan aspirasi konstituen.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a><span>/</span><span>Kontak</span></div>
</header>

<section class="section">
    <div class="grid-2">
        <div class="card reveal">
            <h3>Kantor DPR RI</h3>
            <p>Gedung Nusantara I, Jl. Gatot Subroto, Jakarta.</p>
            <p class="muted">Senin-Jumat 08.00-16.00 WIB</p>
        </div>
        <div class="card reveal">
            <h3>Layanan Aspirasi</h3>
            <p>Gunakan form aspirasi agar laporan memiliki kode tracking dan bisa dipantau statusnya.</p>
            <a href="{{ route('aspirasi.create') }}" class="btn btn-merah" style="margin-top:16px">Sampaikan Aspirasi</a>
        </div>
    </div>
</section>
@endsection
