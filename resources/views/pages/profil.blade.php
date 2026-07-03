@extends('layouts.public')

@section('title', 'Profil - Dr. H. M. Nasir Djamil, M.Si')
@section('page', 'profil')

@section('content')
<header class="page-hero">
    <div class="page-hero-kop">Tentang Beliau</div>
    <h1>Profil <em>Lengkap</em></h1>
    <p>Biodata, riwayat pendidikan, riwayat jabatan, dan rekam jejak organisasi.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Beranda</a><span>/</span><span>Profil</span></div>
</header>

<section class="section profile-section">
    <div class="profile-layout">
        <aside class="profile-sidebar reveal">
            <div class="profile-card-head">
                <div class="profile-avatar">
                    <img src="{{ asset('images/foto nasir djamil.jpg') }}" alt="Dr. H. M. Nasir Djamil, M.Si">
                </div>
                <h2>Dr. H. M. Nasir Djamil, M.Si</h2>
                <p>S.Ag., M.Si.</p>
            </div>

            <div class="profile-side-list">
                <div class="profile-side-item">
                    <span>Tempat, Tanggal Lahir</span>
                    <strong>Medan, 22 Januari 1970</strong>
                </div>
                <div class="profile-side-item">
                    <span>Partai</span>
                    <strong>Partai Keadilan Sejahtera (PKS)</strong>
                </div>
                <div class="profile-side-item">
                    <span>Fraksi</span>
                    <strong>Fraksi PKS DPR RI</strong>
                </div>
                <div class="profile-side-item">
                    <span>Daerah Pemilihan</span>
                    <strong>Aceh II - Provinsi Aceh</strong>
                </div>
                <div class="profile-side-item">
                    <span>Komisi</span>
                    <strong>Komisi III - Penegakan Hukum</strong>
                </div>
                <div class="profile-side-item">
                    <span>Periode</span>
                    <strong>2024 - 2029 (Periode ke-5)</strong>
                </div>
            </div>

            <a href="{{ route('aspirasi.create') }}" class="btn btn-merah profile-side-cta">Sampaikan Aspirasi</a>
        </aside>

        <article class="profile-main">
            <section class="profile-block reveal">
                <div class="section-kop">Biografi</div>
                <h2 class="profile-heading">Mengenal <em>Nasir Djamil</em></h2>

                <p class="profile-lead">
                    Dr. H. M. Nasir Djamil, M.Si adalah politisi senior Indonesia yang telah mengabdikan diri dalam dunia legislatif selama lebih dari 25 tahun. Lahir di Medan pada 22 Januari 1970, beliau memulai perjalanan politiknya dari kursi DPRD Nanggroe Aceh Darussalam pada tahun 1999 dan sejak saat itu menjadi salah satu suara paling konsisten bagi masyarakat Aceh di tingkat nasional.
                </p>

                <blockquote class="profile-quote reveal">
                    <p>"Penegakan hukum adalah jantung negara. Kalau jantung ini rusak maka negara ini bisa rusak. Karena itu, saya selalu mendorong agar RUU yang terkait penegakan hukum menjadi prioritas."</p>
                    <cite>- Dr. H. M. Nasir Djamil, M.Si</cite>
                </blockquote>

                <p class="profile-lead">
                    Sebagai anggota Komisi III DPR RI yang saat ini membidangi penegakan hukum, beliau secara konsisten mendorong reformasi substansial dalam sistem hukum Indonesia. Beliau aktif terlibat dalam pembahasan agenda legislasi hukum serta pengawasan terhadap Polri, Kejaksaan, KPK, BNN, PPATK, dan lembaga peradilan.
                </p>

                <p class="profile-lead">
                    Tak hanya di Senayan, Nasir Djamil juga turun langsung ke lapangan hampir dua kali sebulan untuk mendengar aspirasi konstituen, membuktikan bahwa baginya, komunikasi dengan rakyat adalah kunci kinerja seorang wakil rakyat yang sejati.
                </p>
            </section>

            <section class="profile-block reveal">
                <div class="section-kop">Karier Legislatif</div>
                <h2 class="profile-heading">Riwayat <em>Jabatan</em></h2>

                <div class="profile-timeline">
                    <div class="profile-timeline-item reveal">
                        <span class="profile-year">2024 - 2029</span>
                        <h3>Anggota DPR RI - Komisi III <span class="current-badge">Saat Ini</span></h3>
                        <p>Periode kelima. Melanjutkan perjuangan penguatan penegakan hukum, reformasi peradilan, dan akses keadilan. Fraksi PKS, Dapil Aceh II.</p>
                    </div>
                    <div class="profile-timeline-item reveal">
                        <span class="profile-year">2019 - 2024</span>
                        <h3>Anggota DPR RI - Komisi III</h3>
                        <p>Periode keempat. Menjabat sebagai Ketua Pokja Pertanahan DPR RI. Anggota Grup Kerja Sama Bilateral DPR RI - Parlemen Korea Selatan.</p>
                    </div>
                    <div class="profile-timeline-item reveal">
                        <span class="profile-year">2014 - 2019</span>
                        <h3>Anggota DPR RI - Komisi III</h3>
                        <p>Periode ketiga. Aktif dalam pembahasan RKUHP dan mendorong reformasi sistem kodifikasi hukum pidana nasional.</p>
                    </div>
                    <div class="profile-timeline-item reveal">
                        <span class="profile-year">2009 - 2014</span>
                        <h3>Anggota DPR RI - Komisi III</h3>
                        <p>Periode kedua. Menjabat sebagai Tim Pemantau DPR RI terhadap implementasi MoU Helsinki antara Pemerintah RI dan GAM.</p>
                    </div>
                    <div class="profile-timeline-item reveal">
                        <span class="profile-year">2004 - 2009</span>
                        <h3>Anggota DPR RI - Fraksi PKS</h3>
                        <p>Periode pertama di DPR RI dari Dapil Aceh. Tim Pengawas DPR RI terhadap rehabilitasi dan rekonstruksi Aceh-Nias pasca bencana tsunami 2004.</p>
                    </div>
                    <div class="profile-timeline-item reveal">
                        <span class="profile-year">1999 - 2004</span>
                        <h3>Anggota DPRD Nanggroe Aceh Darussalam</h3>
                        <p>Memulai karier legislatif di tingkat provinsi. Dikenal menolak dana pesangon dan dana LPJ Gubernur NAD sebagai bentuk integritas dalam berpolitik.</p>
                    </div>
                </div>
            </section>

            <section class="profile-block reveal">
                <div class="section-kop">Akademik</div>
                <h2 class="profile-heading">Riwayat <em>Pendidikan</em></h2>

                <div class="profile-timeline profile-timeline-compact">
                    <div class="profile-timeline-item reveal">
                        <span class="profile-year">S3 - Doktor</span>
                        <h3>Program Doktoral Ilmu Politik</h3>
                        <p>Meraih gelar Doktor yang memperkuat kapasitas akademik dalam bidang ilmu politik, hukum, dan tata kelola pemerintahan.</p>
                    </div>
                    <div class="profile-timeline-item reveal">
                        <span class="profile-year">S2 - Magister (M.Si.)</span>
                        <h3>Program Pascasarjana Ilmu Politik</h3>
                        <p>Memperdalam kajian ilmu politik, kebijakan publik, dan pemerintahan untuk menguatkan landasan akademis pengabdiannya.</p>
                    </div>
                    <div class="profile-timeline-item reveal">
                        <span class="profile-year">S1 - Sarjana (S.Ag.)</span>
                        <h3>IAIN Ar-Raniri Banda Aceh</h3>
                        <p>Lulus dari Institut Agama Islam Negeri Ar-Raniri, membangun fondasi nilai, etika, dan integritas yang menjadi pegangan dalam berkarier di dunia publik.</p>
                    </div>
                </div>
            </section>

            <section class="profile-block reveal">
                <div class="section-kop">Rekam Jejak</div>
                <h2 class="profile-heading">Riwayat <em>Organisasi &amp; Penugasan</em></h2>

                <ul class="profile-org-list">
                    <li class="reveal">Ketua Pokja Pertanahan DPR RI</li>
                    <li class="reveal">Anggota Grup Kerja Sama Bilateral DPR RI - Parlemen Korea Selatan</li>
                    <li class="reveal">Tim Pengawas DPR RI - Rehabilitasi &amp; Rekonstruksi Aceh-Nias</li>
                    <li class="reveal">Tim Pemantau DPR RI - Implementasi MoU Helsinki (Pemerintah RI - GAM)</li>
                    <li class="reveal">Kader aktif Partai Keadilan Sejahtera (PKS) sejak masa awal reformasi</li>
                    <li class="reveal">Aktif dalam berbagai forum legislasi, seminar hukum, dan dialog publik nasional</li>
                </ul>
            </section>
        </article>
    </div>
</section>
@endsection
