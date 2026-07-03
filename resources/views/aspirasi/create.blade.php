@extends('layouts.public')

@section('title', 'Sampaikan Aspirasi - Dr. H. M. Nasir Djamil, M.Si')
@section('description', 'Kirim aspirasi, keluhan, saran, atau permohonan bantuan melalui layanan aspirasi konstituen Dr. H. M. Nasir Djamil, M.Si.')
@section('page', 'aspirasi')

@section('content')
@php
    $initialStep = 1;

    if ($errors->hasAny(['category_id', 'title', 'body'])) {
        $initialStep = 2;
    } elseif ($errors->hasAny(['attachments', 'attachments.*'])) {
        $initialStep = 3;
    } elseif ($errors->has('agreement')) {
        $initialStep = 4;
    }
@endphp

<header class="page-hero">
    <div class="page-hero-kop">Layanan Konstituen</div>
    <h1>Sampaikan <em>Aspirasi Anda</em></h1>
    <p>Kirimkan keluhan, saran, atau permohonan bantuan. Setelah terkirim, simpan kode aspirasi untuk memantau status penanganan.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a><span>/</span><span>Aspirasi</span></div>
</header>

<section class="section bg-gelap">
    <div class="section-kop reveal">Cara Kerja</div>
    <h2 class="section-judul reveal">Alur <em>Pengelolaan Aspirasi</em></h2>
    <div class="grid-4">
        <div class="card-dark reveal"><h3>1. Kirim</h3><p>Masyarakat mengisi form dan dokumen pendukung jika ada.</p></div>
        <div class="card-dark reveal"><h3>2. Verifikasi</h3><p>Admin memeriksa kelengkapan dan kategori aspirasi.</p></div>
        <div class="card-dark reveal"><h3>3. Telaah</h3><p>Aspirasi ditelaah dan dikoordinasikan secara internal.</p></div>
        <div class="card-dark reveal"><h3>4. Status</h3><p>Status diperbarui dan dapat dipantau dengan kode aspirasi.</p></div>
    </div>
</section>

<section class="section">
    <div style="max-width:850px;margin:0 auto">
        <div class="section-kop reveal">Form Aspirasi</div>
        <h2 class="section-judul reveal">Isi <em>Data Aspirasi</em></h2>

        <div class="step-bar reveal">
            <div @class(['step', 'active' => $initialStep === 1, 'done' => $initialStep > 1])><div class="step-circle">1</div><span>Data Diri</span></div>
            <div @class(['step', 'active' => $initialStep === 2, 'done' => $initialStep > 2])><div class="step-circle">2</div><span>Isi Aspirasi</span></div>
            <div @class(['step', 'active' => $initialStep === 3, 'done' => $initialStep > 3])><div class="step-circle">3</div><span>Dokumen</span></div>
            <div @class(['step', 'active' => $initialStep === 4])><div class="step-circle">4</div><span>Kirim</span></div>
        </div>

        <form class="form-card reveal" method="POST" action="{{ route('aspirasi.store') }}" enctype="multipart/form-data" data-initial-step="{{ $initialStep }}">
            @csrf

            @if ($errors->any())
                <div class="alert alert-peringatan">Ada data yang belum valid. Periksa kembali field yang ditandai merah.</div>
            @else
                <div class="alert alert-info">Pastikan data yang Anda isi benar. Kode aspirasi akan muncul setelah form berhasil dikirim.</div>
            @endif

            <div class="aspirasi-step" data-step="1" @if($initialStep !== 1) hidden @endif>
                <h3 style="margin-bottom:20px">Langkah 1 - Data Diri</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="wajib">*</span></label>
                        <input id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nik">Nomor KTP / NIK</label>
                        <input id="nik" name="nik" class="form-control" value="{{ old('nik') }}" inputmode="numeric" maxlength="16">
                        @error('nik') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="whatsapp">Nomor WhatsApp <span class="wajib">*</span></label>
                        <input id="whatsapp" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}" placeholder="08xx-xxxx-xxxx" required>
                        @error('whatsapp') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}">
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="city">Kabupaten/Kota <span class="wajib">*</span></label>
                        <select id="city" name="city" class="form-control" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                            @foreach (['Aceh Tengah','Aceh Barat','Aceh Barat Daya','Aceh Selatan','Aceh Singkil','Aceh Tamiang','Aceh Tenggara','Aceh Timur','Aceh Utara','Bener Meriah','Bireuen','Gayo Lues','Nagan Raya','Pidie','Pidie Jaya','Simeulue','Subulussalam','Lhokseumawe','Langsa','Lainnya'] as $city)
                                <option value="{{ $city }}" @selected(old('city') === $city)>{{ $city }}</option>
                            @endforeach
                        </select>
                        @error('city') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="district_village">Kecamatan / Desa</label>
                        <input id="district_village" name="district_village" class="form-control" value="{{ old('district_village') }}">
                        @error('district_village') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button class="btn btn-merah" type="button" data-step-target="2">Lanjut</button>
            </div>

            <div class="aspirasi-step" data-step="2" @if($initialStep !== 2) hidden @endif>
                <h3 style="margin-bottom:20px">Langkah 2 - Isi Aspirasi</h3>
                <div class="form-group">
                    <label for="category_id">Kategori Aspirasi <span class="wajib">*</span></label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="title">Judul / Pokok Masalah <span class="wajib">*</span></label>
                    <input id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="body">Uraian Lengkap Aspirasi <span class="wajib">*</span></label>
                    <textarea id="body" name="body" class="form-control" required>{{ old('body') }}</textarea>
                    <small class="muted" style="display:block;margin-top:6px">Minimal 20 karakter agar admin mendapat konteks masalah yang cukup.</small>
                    @error('body') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="actions">
                    <button class="btn btn-outline" type="button" data-step-target="1">Kembali</button>
                    <button class="btn btn-merah" type="button" data-step-target="3">Lanjut</button>
                </div>
            </div>

            <div class="aspirasi-step" data-step="3" @if($initialStep !== 3) hidden @endif>
                <h3 style="margin-bottom:20px">Langkah 3 - Dokumen Pendukung</h3>
                <div class="alert alert-peringatan">Upload dokumen pendukung jika ada. Maksimal 5 file, tiap file maksimal 5 MB. Format: PDF, JPG, JPEG, PNG.</div>
                <div class="form-group">
                    <label for="attachments">Upload Dokumen</label>
                    <input id="attachments" type="file" name="attachments[]" class="form-control" multiple accept=".pdf,.jpg,.jpeg,.png">
                    @error('attachments') <span class="error">{{ $message }}</span> @enderror
                    @error('attachments.*') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="actions">
                    <button class="btn btn-outline" type="button" data-step-target="2">Kembali</button>
                    <button class="btn btn-merah" type="button" data-step-target="4">Lanjut</button>
                </div>
            </div>

            <div class="aspirasi-step" data-step="4" @if($initialStep !== 4) hidden @endif>
                <h3 style="margin-bottom:20px">Langkah 4 - Pernyataan</h3>
                <div class="form-group">
                    <label style="display:flex;gap:10px;align-items:flex-start;text-transform:none;letter-spacing:0;font-weight:500;line-height:1.6">
                        <input type="checkbox" name="agreement" value="1" @checked(old('agreement')) style="margin-top:4px">
                        Saya menyatakan bahwa informasi yang saya sampaikan benar dan dapat dipertanggungjawabkan. Saya menyetujui penggunaan data ini untuk keperluan penanganan aspirasi.
                    </label>
                    @error('agreement') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="actions">
                    <button class="btn btn-outline" type="button" data-step-target="3">Kembali</button>
                    <button class="btn btn-merah" type="submit">Kirim Aspirasi</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
