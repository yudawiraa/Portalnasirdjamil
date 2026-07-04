@extends('layouts.public')

@section('title', 'Cek Status Aspirasi')
@section('description', 'Cek status aspirasi konstituen menggunakan kode aspirasi dan nomor WhatsApp yang dipakai saat pengiriman.')

@section('content')
<header class="page-hero">
    <div class="page-hero-kop">Tracking</div>
    <h1>Cek Status <em>Aspirasi</em></h1>
    <p>Masukkan kode aspirasi dan nomor WhatsApp yang digunakan saat mengirim aspirasi.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a><span>/</span><a href="{{ route('aspirasi.create') }}">Aspirasi</a><span>/</span><span>Cek Status</span></div>
</header>

<section class="section">
    <div class="form-card reveal" style="max-width:640px;margin:0 auto">
        <div class="section-kop">Tracking Aspirasi</div>
        <h2 class="section-judul" style="font-size:1.7rem;margin-bottom:22px">Masukkan <em>Kode Aspirasi</em></h2>
        <div class="alert alert-info">Kode aspirasi didapat setelah form berhasil dikirim. Kode ini bukan OTP WhatsApp, jadi perlu dicatat atau disalin oleh pengirim.</div>
        <form method="POST" action="{{ route('aspirasi.track.lookup') }}">
            @csrf
            <div class="form-group">
                <label for="code">Kode Aspirasi <span class="wajib">*</span></label>
                <input id="code" name="code" class="form-control" value="{{ old('code') }}" placeholder="ASP-2026-12345" data-uppercase required>
                @error('code') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="whatsapp">Nomor WhatsApp <span class="wajib">*</span></label>
                <input id="whatsapp" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}" required>
                @error('whatsapp') <span class="error">{{ $message }}</span> @enderror
            </div>
            <button class="btn btn-merah" type="submit" style="width:100%">Cek Status</button>
        </form>

        @if ($notFound)
            <div class="alert alert-peringatan" style="margin-top:24px">Kode aspirasi tidak ditemukan atau nomor WhatsApp tidak sesuai. Jika lupa kode, hubungi admin dengan menyebutkan nama lengkap, nomor WhatsApp, kabupaten/kota, dan judul aspirasi.</div>
        @endif

        @if ($aspirasi)
            @php
                $steps = \App\Models\Aspirasi::publicSteps();
                $currentIndex = array_search($aspirasi->status, $steps, true);
                $currentIndex = $currentIndex === false ? 2 : $currentIndex;
            @endphp
            <div style="margin-top:30px">
                <div class="alert alert-sukses">Aspirasi ditemukan. Berikut status terkini penanganan Anda.</div>
                <div class="card" style="box-shadow:none;margin-bottom:22px">
                    <div class="kv"><span>Kode Aspirasi</span><strong style="font-family:monospace;font-size:1.25rem">{{ $aspirasi->code }}</strong></div>
                    <div class="kv"><span>Judul</span><strong>{{ $aspirasi->title }}</strong></div>
                    <span class="badge badge-emas">{{ $aspirasi->category->name }}</span>
                    <span class="badge badge-merah">{{ $aspirasi->statusLabelText() }}</span>
                </div>
                <div class="timeline">
                    @foreach ($steps as $index => $status)
                        @php $meta = \App\Models\Aspirasi::statuses()[$status]; @endphp
                        <div @class(['timeline-item', 'done' => $index < $currentIndex, 'active' => $index === $currentIndex])>
                            <div class="timeline-dot">{{ $index + 1 }}</div>
                            <div>
                                <strong>{{ $meta['label'] }}</strong>
                                <p class="muted">{{ $meta['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($aspirasi->public_response)
                    <div class="alert alert-info" style="margin-top:22px">
                        <strong>Respons Tim:</strong><br>
                        {{ $aspirasi->public_response }}
                    </div>
                @endif
                @if (in_array($aspirasi->status, [\App\Models\Aspirasi::STATUS_NEED_DATA, \App\Models\Aspirasi::STATUS_REJECTED], true))
                    <div class="alert alert-peringatan" style="margin-top:22px">{{ \App\Models\Aspirasi::statuses()[$aspirasi->status]['description'] }}</div>
                @endif
            </div>
        @endif
    </div>

    <div style="text-align:center;margin-top:30px" class="reveal">
        <p class="muted">Belum punya kode aspirasi?</p>
        <a href="{{ route('aspirasi.create') }}" class="btn btn-merah" style="margin-top:12px">Kirim Aspirasi Baru</a>
    </div>

    <div style="max-width:640px;margin:28px auto 0">
        @include('aspirasi.partials.code-help', ['adminWhatsapp' => $adminWhatsapp])
    </div>
</section>
@endsection
