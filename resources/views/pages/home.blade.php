@extends('layouts.public')

@section('title', 'Beranda - Dr. H. M. Nasir Djamil, M.Si')
@section('page', 'home')

@section('content')
<section class="hero hero-home">
    <div class="aceh-motif" aria-hidden="true"></div>

    <div class="hero-content reveal">
        <div class="kop">Anggota DPR RI - Dapil Aceh II</div>
        <h1 class="hero-name">Dr. H. M.<br><em>Nasir Djamil, M.Si</em></h1>
        <div class="hero-role">
            <span>Anggota Komisi III DPR RI</span>
            <span>Bidang Penegakan Hukum</span>
            <span>Fraksi Partai Keadilan Sejahtera (PKS)</span>
        </div>
        <div class="hero-badge hero-badge-pks"><span></span> Fraksi PKS - Dapil Aceh II</div>
        <div class="hero-actions">
            <a href="{{ route('aspirasi.create') }}" class="btn btn-merah">Sampaikan Aspirasi</a>
            <a href="{{ route('profil') }}" class="btn btn-outline">Lihat Profil</a>
        </div>
    </div>

    <div class="hero-media reveal">
        <div class="photo-frame photo-frame-home">
            <div class="frame-corner tl"></div>
            <div class="frame-corner tr"></div>
            <div class="frame-corner bl"></div>
            <div class="frame-corner br"></div>
            <div class="slide active">
                <img src="{{ asset('images/untuk profil.png') }}" alt="Dr. H. M. Nasir Djamil, M.Si">
                <div class="photo-caption">Dr. H. M. Nasir Djamil, M.Si</div>
            </div>
            <div class="slide">
                <img src="{{ asset('images/foto pak nasir.jpeg') }}" alt="Reses dan aspirasi masyarakat Aceh">
                <div class="photo-caption">Reses dan Aspirasi Masyarakat Aceh</div>
            </div>
            <div class="slide">
                <img src="{{ asset('images/foto pak nasir ngopi.jpeg') }}" alt="Kegiatan daerah pemilihan Aceh II">
                <div class="photo-caption">Kegiatan Dapil Aceh II</div>
            </div>
            <div class="slider-dots">
                <button class="slider-dot active" type="button" aria-label="Slide 1"></button>
                <button class="slider-dot" type="button" aria-label="Slide 2"></button>
                <button class="slider-dot" type="button" aria-label="Slide 3"></button>
            </div>
        </div>
    </div>

    <div class="hero-stats reveal">
        <div class="stat">
            <div class="stat-n">5x</div>
            <div class="stat-l">Periode Legislatif</div>
        </div>
        <div class="stat">
            <div class="stat-n">25+</div>
            <div class="stat-l">Tahun Pengabdian</div>
        </div>
        <div class="stat">
            <div class="stat-n">III</div>
            <div class="stat-l">Komisi DPR RI</div>
        </div>
        <div class="stat">
            <div class="stat-n">Aceh</div>
            <div class="stat-l">Daerah Pemilihan</div>
        </div>
    </div>
</section>

<section class="section section-dark-red" id="komisi-iii">
    <div class="section-kop reveal">Komisi III DPR RI</div>
    <h2 class="section-judul reveal">Tugas, Fungsi & <em>Mitra Kerja</em></h2>
    <p class="section-lead reveal">
        Komisi III DPR RI saat ini membidangi <strong>penegakan hukum</strong>.
        Komisi ini menjalankan fungsi legislasi, pengawasan, dan anggaran terhadap lembaga penegak hukum,
        pemberantasan korupsi, tindak pidana narkotika, transaksi keuangan mencurigakan, serta sistem peradilan.
    </p>

    <div class="tf-tabs reveal">
        <button class="tf-tab active" type="button" data-tf-tab="tugas">Tugas & Fungsi</button>
        <button class="tf-tab" type="button" data-tf-tab="mitra">Mitra Kerja Resmi</button>
    </div>

    <div class="tf-panel active" data-tf-panel="tugas">
        <div class="tugas-grid">
            @foreach ([
                ['Legislasi Hukum', 'Membahas dan menyusun RUU di bidang hukum, termasuk KUHP, KUHAP, dan undang-undang terkait penegakan hukum serta reformasi sistem peradilan pidana nasional.'],
                ['Pengawasan Lembaga Penegak Hukum', 'Mengawasi kinerja Polri, Kejaksaan Agung, KPK, BNN, PPATK, serta lembaga peradilan agar berjalan akuntabel, profesional, dan transparan.'],
                ['Anggaran', 'Membahas dan menyetujui alokasi anggaran bagi lembaga mitra kerja Komisi III agar penggunaan dana negara tepat sasaran dan efisien.'],
                ['Reformasi Sistem Peradilan', 'Mendorong perbaikan sistem peradilan pidana, kepastian hukum, akses keadilan, dan kualitas layanan lembaga penegak hukum.'],
                ['Pemberantasan Kejahatan Khusus', 'Mengawal isu pemberantasan korupsi, narkotika, pencucian uang, dan tindak pidana lain yang menjadi perhatian publik.'],
                ['Aspirasi Konstituen', 'Menerima, menampung, dan menindaklanjuti pengaduan masyarakat terkait penegakan hukum, peradilan, kepolisian, kejaksaan, korupsi, dan narkotika.'],
            ] as [$title, $desc])
                <article class="tugas-card reveal">
                    <h3>{{ $title }}</h3>
                    <p>{{ $desc }}</p>
                </article>
            @endforeach
        </div>
    </div>

    <div class="tf-panel" data-tf-panel="mitra">
        <div class="mitra-grid">
            @foreach ([
                ['Kejaksaan Agung', 'Kejagung'],
                ['Kepolisian Negara Republik Indonesia', 'Polri'],
                ['Komisi Pemberantasan Korupsi', 'KPK'],
                ['Sekretariat Jenderal Mahkamah Agung', 'Setjen MA'],
                ['Sekretariat Jenderal Mahkamah Konstitusi', 'Setjen MK'],
                ['Sekretariat Jenderal Komisi Yudisial', 'Setjen KY'],
                ['Pusat Pelaporan dan Analisis Transaksi Keuangan', 'PPATK'],
                ['Badan Narkotika Nasional', 'BNN'],
            ] as [$name, $short])
                <article class="mitra-card reveal">
                    <span>{{ $short }}</span>
                    <strong>{{ $name }}</strong>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section bg-abu">
    <div class="section-kop reveal">Prioritas Kerja</div>
    <h2 class="section-judul reveal">Mengawal <em>Penegakan Hukum</em></h2>
    <div class="grid-3">
        <article class="card reveal">
            <span class="badge badge-merah">Hukum</span>
            <h3>Pengawasan Penegakan Hukum</h3>
            <p>Mendorong aparat penegak hukum bekerja profesional, transparan, dan akuntabel.</p>
        </article>
        <article class="card reveal">
            <span class="badge badge-emas">Peradilan</span>
            <h3>Akses Keadilan</h3>
            <p>Mengawal aspirasi masyarakat yang berkaitan dengan proses hukum dan layanan peradilan.</p>
        </article>
        <article class="card reveal">
            <span class="badge badge-hijau">Aspirasi</span>
            <h3>Layanan Konstituen</h3>
            <p>Menerima, memverifikasi, dan menindaklanjuti aspirasi masyarakat melalui sistem tracking.</p>
        </article>
    </div>
</section>

<section class="quote-band">
    <blockquote>
        "Tanpa komunikasi intensif dengan rakyat, khususnya dari daerah pemilihan, tidak mungkin kinerja anggota dewan berjalan maksimal."
    </blockquote>
    <cite>- Dr. H. M. Nasir Djamil, M.Si, Anggota DPR RI Komisi III</cite>
</section>

<section class="section bg-gelap" style="text-align:center">
    <div class="section-kop reveal">Layanan Konstituen</div>
    <h2 class="section-judul reveal">Sampaikan Aspirasi <em>Anda</em></h2>
    <p class="section-lead reveal" style="margin-left:auto;margin-right:auto">
        Ada permasalahan terkait penegakan hukum, peradilan, kepolisian, kejaksaan, korupsi, narkotika, atau layanan hukum yang perlu perhatian?
        Gunakan sistem aspirasi agar laporan memiliki kode tracking dan dapat dipantau.
    </p>
    <div class="actions reveal" style="justify-content:center;margin-top:28px">
        <a href="{{ route('aspirasi.create') }}" class="btn btn-merah">Kirim Aspirasi Sekarang</a>
        <a href="{{ route('aspirasi.track.form') }}" class="btn btn-outline">Cek Status Aspirasi</a>
    </div>
</section>
@endsection
