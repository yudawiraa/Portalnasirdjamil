<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home');
    }

    public function profil(): View
    {
        return view('pages.profil');
    }

    public function kegiatan(): View
    {
        return view('pages.kegiatan', [
            'activities' => $this->kegiatanData(),
            'videos' => $this->videoDokumentasiData(),
            'instagramUrl' => 'https://www.instagram.com/nasirdjamil.update?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==',
        ]);
    }

    public function kegiatanDetail(string $slug): View
    {
        $activity = collect($this->kegiatanData())->firstWhere('slug', $slug);

        abort_if($activity === null, 404);

        return view('pages.kegiatan-detail', [
            'activity' => $activity,
        ]);
    }

    public function galeri(): View
    {
        return view('pages.galeri', [
            'albums' => $this->galeriAlbums(),
        ]);
    }

    public function galeriDetail(string $slug): View
    {
        $album = collect($this->galeriAlbums())->firstWhere('slug', $slug);

        abort_if($album === null, 404);

        return view('pages.galeri-detail', [
            'album' => $album,
        ]);
    }

    public function kontak(): View
    {
        return view('pages.kontak');
    }

    private function kegiatanData(): array
    {
        return [
            [
                'slug' => 'reses-aceh-barat',
                'filter' => 'reses',
                'category' => 'Reses',
                'title' => 'Reses Aceh Barat',
                'date' => '12 Juni 2026',
                'location' => 'Aceh Barat',
                'summary' => 'Dialog bersama masyarakat terkait pelayanan publik, akses keadilan, dan kebutuhan daerah.',
                'image' => 'images/foto pak nasir ngopi.jpeg',
                'body' => [
                    'Kegiatan reses menjadi ruang utama untuk mendengar langsung kebutuhan masyarakat di daerah pemilihan. Dalam forum ini, isu pelayanan publik, akses keadilan, serta kebutuhan pembangunan daerah dihimpun sebagai bahan pengawasan dan kerja legislasi.',
                    'Masukan masyarakat dari kegiatan ini menjadi catatan untuk ditindaklanjuti melalui fungsi pengawasan, koordinasi dengan mitra kerja, serta kanal aspirasi resmi.',
                ],
            ],
            [
                'slug' => 'rapat-kerja-komisi-iii',
                'filter' => 'rapat-kerja',
                'category' => 'Rapat Kerja',
                'title' => 'Rapat Kerja Komisi III',
                'date' => 'Juni 2026',
                'location' => 'Jakarta - DPR RI',
                'summary' => 'Pembahasan isu penegakan hukum, peradilan, korupsi, narkotika, dan pengawasan bersama mitra kerja Komisi III.',
                'image' => 'images/untuk profil.png',
                'body' => [
                    'Rapat kerja Komisi III DPR RI membahas agenda pengawasan dan evaluasi kebijakan bersama mitra kerja di bidang penegakan hukum.',
                    'Forum ini menjadi bagian dari fungsi DPR RI dalam memastikan kebijakan penegakan hukum, pemberantasan korupsi dan narkotika, serta layanan peradilan berjalan akuntabel, profesional, dan berpihak pada kepentingan masyarakat.',
                ],
            ],
            [
                'slug' => 'fgd-bukber-dpd-pks-langsa',
                'filter' => 'aspirasi-masyarakat',
                'category' => 'Aspirasi Masyarakat',
                'title' => 'FGD dan Buka Puasa Bersama DPD PKS Kota Langsa',
                'date' => '6 Maret 2026',
                'location' => 'Aula B Vitra Convention Hall, Kota Langsa',
                'summary' => 'Focus Group Discussion dan buka puasa bersama keluarga besar DPD PKS Kota Langsa sebagai ruang silaturahmi, konsolidasi, dan dialog konstituen.',
                'image' => 'images/kegiatan/fgd-bukber-dpd-pks-langsa-diskusi-2.jpeg',
                'body' => [
                    'Langsa, 6 Maret 2026 - Dr. H. M. Nasir Djamil, M.Si menghadiri kegiatan Focus Group Discussion (FGD) dan buka puasa bersama keluarga besar DPD PKS Kota Langsa di Aula B Vitra Convention Hall, Kota Langsa.',
                    'Kegiatan yang berlangsung pada momentum Ramadhan ini menjadi ruang silaturahmi sekaligus forum diskusi untuk menyerap pandangan, memperkuat komunikasi politik, dan menjaga kedekatan dengan struktur serta masyarakat di daerah.',
                    'Melalui forum FGD, berbagai gagasan dan masukan dari peserta dapat menjadi catatan penting dalam kerja representasi, pelayanan konstituen, serta penguatan agenda kebangsaan dari daerah pemilihan Aceh II.',
                ],
            ],
            [
                'slug' => 'agenda-legislasi-hukum',
                'filter' => 'legislasi',
                'category' => 'Legislasi',
                'title' => 'Agenda Legislasi Hukum',
                'date' => '2026',
                'location' => 'Komisi III DPR RI',
                'summary' => 'Pembahasan regulasi untuk memperkuat sistem penegakan hukum, kepastian hukum, dan keadilan publik.',
                'image' => 'images/kegiatan/agenda-legislasi-hukum-1.jpeg',
                'body' => [
                    'Agenda legislasi berfokus pada pembahasan regulasi yang berkaitan dengan penguatan sistem hukum nasional, kepastian hukum, serta akses keadilan bagi masyarakat.',
                    'Setiap pembahasan legislasi perlu mendengar masukan publik agar substansi kebijakan dapat menjawab kebutuhan riil masyarakat.',
                ],
            ],
            [
                'slug' => 'pengukuhan-paralegal-yara',
                'filter' => 'legislasi',
                'category' => 'Legislasi',
                'title' => 'Pengukuhan Paralegal Yayasan Advokasi Rakyat Aceh',
                'date' => '20 Juni 2026',
                'location' => 'Hermes Palace Hotel, Banda Aceh',
                'summary' => 'Pengukuhan paralegal Yayasan Advokasi Rakyat Aceh (YARA) sebagai bagian dari penguatan literasi hukum, akses bantuan hukum masyarakat, serta peran paralegal dalam mendampingi warga menghadapi persoalan hukum di daerah.',
                'image' => 'images/kegiatan/pengukuhan-paralegal-yara-sambutan.jpeg',
                'body' => [
                    'Pengukuhan Paralegal Yayasan Advokasi Rakyat Aceh (YARA) dilaksanakan di Hermes Palace Hotel Banda Aceh pada 20 Juni 2026. Kegiatan ini dikukuhkan oleh Dr. H. M. Nasir Djamil, M.Si sebagai Anggota Komisi III DPR RI.',
                    'Agenda ini menjadi bagian dari upaya memperkuat literasi hukum dan akses bantuan hukum bagi masyarakat Aceh. Paralegal memiliki peran penting sebagai jembatan awal antara warga, komunitas, dan mekanisme bantuan hukum yang tersedia.',
                    'Melalui kegiatan ini, penguatan kapasitas paralegal diharapkan dapat membantu masyarakat memahami hak-haknya, mengenali jalur penyelesaian persoalan hukum, dan memperluas pelayanan keadilan di tingkat akar rumput.',
                ],
            ],
            [
                'slug' => 'diskusi-dema-fkd-uin-ar-raniry',
                'filter' => 'aspirasi-masyarakat',
                'category' => 'Aspirasi Masyarakat',
                'title' => 'Silaturahmi dan Diskusi DEMA FKD UIN Ar-Raniry',
                'date' => '2026',
                'location' => 'Banda Aceh - UIN Ar-Raniry',
                'summary' => 'Silaturahmi bersama mahasiswa DEMA FKD UIN Ar-Raniry di Banda Aceh untuk mendengar pandangan generasi muda tentang pendidikan, ruang partisipasi publik, pelayanan masyarakat, dan isu hukum yang dekat dengan kehidupan kampus.',
                'image' => 'images/kegiatan/diskusi-mahasiswa-dema-fkd-uin-ar-raniry-1.jpeg',
                'body' => [
                    'Silaturahmi dan diskusi bersama mahasiswa DEMA FKD UIN Ar-Raniry menjadi ruang dialog informal antara Dr. H. M. Nasir Djamil, M.Si dan kalangan mahasiswa di Banda Aceh.',
                    'Dalam pertemuan ini, mahasiswa menyampaikan pandangan terkait pendidikan, ruang partisipasi publik, pelayanan masyarakat, serta berbagai isu hukum dan kebijakan yang dekat dengan kehidupan kampus.',
                    'Kegiatan seperti ini penting untuk menjaga komunikasi dengan generasi muda agar aspirasi mahasiswa dapat menjadi bahan pertimbangan dalam kerja pengawasan, legislasi, dan pelayanan konstituen.',
                ],
            ],
            [
                'slug' => 'kuliah-umum-stai-pante-kulu',
                'filter' => 'aspirasi-masyarakat',
                'category' => 'Aspirasi Masyarakat',
                'title' => 'Kuliah Umum Bersama Dr. H. M. Nasir Djamil, M.Si',
                'date' => '17 April 2026',
                'location' => 'Mushalla STAI Tgk. Chik Pante Kulu',
                'summary' => 'Kuliah umum bersama Dr. H. M. Nasir Djamil, M.Si berlangsung penuh wawasan dan inspirasi di Mushalla STAI Tgk. Chik Pante Kulu.',
                'image' => 'images/kegiatan/kuliah-umum-stai-pante-kulu-isi-materi.jpeg',
                'body' => [
                    'Banda Aceh, 17 April 2026 - Dr. H. M. Nasir Djamil, M.Si hadir sebagai narasumber dalam kuliah umum yang digelar di Mushalla STAI Tgk. Chik Pante Kulu. Kegiatan ini menjadi ruang akademik untuk memperluas wawasan mahasiswa sekaligus memperkuat dialog antara dunia pendidikan dan kerja-kerja kebangsaan.',
                    'Dalam forum tersebut, Nasir Djamil menyampaikan materi yang menekankan pentingnya ilmu, integritas, kepedulian sosial, serta peran generasi muda dalam menjaga arah pembangunan bangsa. Suasana kegiatan berlangsung hangat dengan partisipasi peserta yang mengikuti jalannya kuliah umum hingga sesi penutup.',
                    'Agenda ini juga ditandai dengan penyerahan sertifikat dan foto bersama sebagai dokumentasi kegiatan. Kehadiran kuliah umum semacam ini diharapkan dapat memberi inspirasi bagi mahasiswa untuk terus mengembangkan kapasitas diri dan terlibat aktif dalam kehidupan publik.',
                ],
            ],
            [
                'slug' => 'aspirasi-masyarakat-aceh-ii',
                'filter' => 'aspirasi-masyarakat',
                'category' => 'Aspirasi Masyarakat',
                'title' => 'Dialog Aspirasi Masyarakat Aceh II',
                'date' => '2026',
                'location' => 'Dapil Aceh II',
                'summary' => 'Penyerapan aspirasi warga terkait penegakan hukum, akses keadilan, layanan publik, dan kebutuhan daerah.',
                'image' => 'images/foto pak nasir ngopi.jpeg',
                'body' => [
                    'Dialog aspirasi masyarakat dilakukan untuk menjaga komunikasi intensif antara wakil rakyat dan konstituen di daerah pemilihan.',
                    'Aspirasi yang masuk dipilah berdasarkan isu, urgensi, dan ruang tindak lanjut agar dapat diarahkan melalui kanal kerja yang tepat.',
                ],
            ],
            [
                'slug' => 'rapat-dengar-pendapat',
                'filter' => 'rapat-kerja',
                'category' => 'Rapat Kerja',
                'title' => 'Rapat Dengar Pendapat',
                'date' => '2026',
                'location' => 'Jakarta - DPR RI',
                'summary' => 'Pendalaman isu aktual bersama lembaga terkait dalam lingkup kerja Komisi III DPR RI.',
                'image' => 'images/untuk profil.png',
                'body' => [
                    'Rapat dengar pendapat menjadi forum pendalaman terhadap isu aktual yang berkaitan dengan mitra kerja Komisi III DPR RI.',
                    'Hasil pembahasan menjadi dasar penguatan pengawasan, rekomendasi kebijakan, dan tindak lanjut kelembagaan.',
                ],
            ],
        ];
    }

    private function videoDokumentasiData(): array
    {
        return [
            [
                'title' => 'Bungong Jaroe untuk Porter Bandara SIM',
                'date' => '24 Februari 2026',
                'location' => 'Bandara Internasional Sultan Iskandar Muda, Aceh Besar',
                'url' => 'https://www.instagram.com/reel/DVK0r2iAWg8/',
                'thumbnail' => 'images/kegiatan/video-bungong-jaroe-porter-bandara-sim.jpg',
                'summary' => 'Penyerahan paket sembako Ramadhan kepada porter Bandara Sultan Iskandar Muda sebagai bentuk kepedulian terhadap pekerja layanan publik.',
            ],
            [
                'title' => 'RUU Pemerintahan Aceh dan Dana Otsus',
                'date' => '14 Januari 2026',
                'location' => 'Baleg DPR RI',
                'url' => 'https://www.instagram.com/reel/DTfpuRdj6M_/',
                'thumbnail' => 'images/kegiatan/video-ruu-pemerintahan-aceh-dana-otsus.jpg',
                'summary' => 'Pembahasan RUU Pemerintahan Aceh terkait keberlanjutan dana khusus Aceh sebesar 2,5 persen dari Dana Alokasi Umum.',
            ],
            [
                'title' => 'Soft Launching BLKK Yayasan Masyarakat Madani Aceh',
                'date' => '30 April 2026',
                'location' => 'Aceh',
                'url' => 'https://www.instagram.com/reel/DXwIXLjhUN6/',
                'thumbnail' => 'images/kegiatan/video-soft-launching-blkk-yayasan-masyarakat-madani-aceh.jpg',
                'summary' => 'Dokumentasi soft launching Balai Latihan Kerja Komunitas Yayasan Masyarakat Madani Aceh sebagai ruang penguatan keterampilan masyarakat.',
            ],
            [
                'title' => 'Pengawasan Hukum Kayu Gelondongan Pasca Banjir Aceh',
                'date' => '20 Januari 2026',
                'location' => 'Aceh dan Sumatera',
                'url' => 'https://www.instagram.com/reel/DTvJ3BhgULK/',
                'thumbnail' => 'images/kegiatan/video-pengawasan-kayu-gelondongan-banjir-aceh.jpg',
                'summary' => 'Dorongan pengusutan rantai kepemilikan kayu gelondongan yang ditemukan pasca banjir bandang di Sumatera, terutama Aceh.',
            ],
        ];
    }

    private function galeriAlbums(): array
    {
        return [
            [
                'slug' => 'pengukuhan-paralegal-yara',
                'filter' => 'legislasi',
                'category' => 'Legislasi',
                'title' => 'Pengukuhan Paralegal Yayasan Advokasi Rakyat Aceh',
                'date' => '20 Juni 2026',
                'location' => 'Hermes Palace Hotel, Banda Aceh',
                'summary' => 'Dokumentasi kegiatan pengukuhan paralegal sebagai bagian dari penguatan literasi hukum dan akses bantuan hukum masyarakat.',
                'cover' => 'images/kegiatan/pengukuhan-paralegal-yara-sambutan.jpeg',
                'photos' => [
                    ['src' => 'images/kegiatan/pengukuhan-paralegal-yara-sambutan.jpeg', 'caption' => 'Sambutan pada pengukuhan paralegal YARA'],
                    ['src' => 'images/kegiatan/pengukuhan-paralegal-yara-sertifikat.jpeg', 'caption' => 'Penyerahan sertifikat paralegal'],
                    ['src' => 'images/kegiatan/pengukuhan-paralegal-yara-foto-bersama.jpeg', 'caption' => 'Foto bersama peserta dan undangan'],
                    ['src' => 'images/kegiatan/pengukuhan-paralegal-yara-kegiatan.jpeg', 'caption' => 'Suasana agenda pengukuhan paralegal'],
                ],
            ],
            [
                'slug' => 'agenda-legislasi-hukum',
                'filter' => 'legislasi',
                'category' => 'Legislasi',
                'title' => 'Agenda Legislasi Hukum',
                'date' => '2026',
                'location' => 'Komisi III DPR RI',
                'summary' => 'Dokumentasi agenda legislasi hukum terkait pembahasan regulasi, penguatan sistem penegakan hukum, kepastian hukum, dan keadilan publik.',
                'cover' => 'images/kegiatan/agenda-legislasi-hukum-1.jpeg',
                'photos' => [
                    ['src' => 'images/kegiatan/agenda-legislasi-hukum-1.jpeg', 'caption' => 'Penyampaian pandangan dalam agenda legislasi hukum'],
                    ['src' => 'images/kegiatan/agenda-legislasi-hukum-2.jpeg', 'caption' => 'Diskusi pembahasan isu hukum dan regulasi'],
                ],
            ],
            [
                'slug' => 'diskusi-dema-fkd-uin-ar-raniry',
                'filter' => 'dialog-konstituen',
                'category' => 'Dialog Konstituen',
                'title' => 'Silaturahmi dan Diskusi DEMA FKD UIN Ar-Raniry',
                'date' => '2026',
                'location' => 'Banda Aceh - UIN Ar-Raniry',
                'summary' => 'Dokumentasi dialog bersama mahasiswa DEMA FKD UIN Ar-Raniry tentang pendidikan, partisipasi publik, pelayanan masyarakat, dan isu hukum.',
                'cover' => 'images/kegiatan/diskusi-mahasiswa-dema-fkd-uin-ar-raniry-1.jpeg',
                'photos' => [
                    ['src' => 'images/kegiatan/diskusi-mahasiswa-dema-fkd-uin-ar-raniry-1.jpeg', 'caption' => 'Diskusi bersama mahasiswa DEMA FKD UIN Ar-Raniry'],
                    ['src' => 'images/kegiatan/diskusi-mahasiswa-dema-fkd-uin-ar-raniry-2.jpeg', 'caption' => 'Dialog mahasiswa di Banda Aceh'],
                    ['src' => 'images/kegiatan/diskusi-mahasiswa-dema-fkd-uin-ar-raniry-3.jpeg', 'caption' => 'Suasana silaturahmi bersama mahasiswa'],
                ],
            ],
            [
                'slug' => 'kuliah-umum-stai-pante-kulu',
                'filter' => 'dialog-konstituen',
                'category' => 'Dialog Konstituen',
                'title' => 'Kuliah Umum STAI Tgk. Chik Pante Kulu',
                'date' => '17 April 2026',
                'location' => 'Mushalla STAI Tgk. Chik Pante Kulu',
                'summary' => 'Dokumentasi kuliah umum bersama Dr. H. M. Nasir Djamil, M.Si yang berlangsung penuh wawasan dan inspirasi bersama civitas akademika STAI Tgk. Chik Pante Kulu.',
                'cover' => 'images/kegiatan/kuliah-umum-stai-pante-kulu-isi-materi.jpeg',
                'photos' => [
                    ['src' => 'images/kegiatan/kuliah-umum-stai-pante-kulu-isi-materi.jpeg', 'caption' => 'Penyampaian materi kuliah umum di Mushalla STAI Tgk. Chik Pante Kulu'],
                    ['src' => 'images/kegiatan/kuliah-umum-stai-pante-kulu-penyerahan-sertifikat.jpeg', 'caption' => 'Penyerahan sertifikat setelah sesi kuliah umum'],
                    ['src' => 'images/kegiatan/kuliah-umum-stai-pante-kulu-foto-bersama.jpeg', 'caption' => 'Foto bersama narasumber dan panitia kegiatan'],
                ],
            ],
            [
                'slug' => 'reses-dan-dialog-masyarakat',
                'filter' => 'reses',
                'category' => 'Reses',
                'title' => 'Reses dan Dialog Masyarakat',
                'date' => '2026',
                'location' => 'Dapil Aceh II',
                'summary' => 'Dokumentasi kegiatan reses dan dialog konstituen untuk menghimpun aspirasi terkait pelayanan publik, akses keadilan, dan kebutuhan daerah.',
                'cover' => 'images/foto pak nasir.jpeg',
                'photos' => [
                    ['src' => 'images/foto pak nasir.jpeg', 'caption' => 'Dokumentasi kegiatan reses dan dialog masyarakat'],
                ],
            ],
            [
                'slug' => 'agenda-rapat-kerja-komisi-iii',
                'filter' => 'rapat-kerja',
                'category' => 'Rapat Kerja',
                'title' => 'Agenda Rapat Kerja Komisi III',
                'date' => '2026',
                'location' => 'DPR RI, Jakarta',
                'summary' => 'Dokumentasi agenda kelembagaan dan rapat kerja Komisi III DPR RI bersama mitra kerja bidang penegakan hukum.',
                'cover' => 'images/untuk profil.png',
                'photos' => [
                    ['src' => 'images/untuk profil.png', 'caption' => 'Agenda kelembagaan DPR RI'],
                ],
            ],
            [
                'slug' => 'fgd-bukber-dpd-pks-langsa',
                'filter' => 'dialog-konstituen',
                'category' => 'Dialog Konstituen',
                'title' => 'FGD dan Buka Puasa Bersama DPD PKS Kota Langsa',
                'date' => '6 Maret 2026',
                'location' => 'Aula B Vitra Convention Hall, Kota Langsa',
                'summary' => 'Dokumentasi Focus Group Discussion dan buka puasa bersama keluarga besar DPD PKS Kota Langsa sebagai ruang silaturahmi dan dialog konstituen.',
                'cover' => 'images/kegiatan/fgd-bukber-dpd-pks-langsa-diskusi-2.jpeg',
                'photos' => [
                    ['src' => 'images/kegiatan/fgd-bukber-dpd-pks-langsa-diskusi-2.jpeg', 'caption' => 'Suasana FGD dan buka puasa bersama DPD PKS Kota Langsa'],
                    ['src' => 'images/kegiatan/fgd-bukber-dpd-pks-langsa-diskusi-1.jpeg', 'caption' => 'Diskusi bersama peserta FGD di Aula B Vitra Convention Hall'],
                    ['src' => 'images/kegiatan/fgd-bukber-dpd-pks-langsa-foto-bersama.jpeg', 'caption' => 'Foto bersama keluarga besar DPD PKS Kota Langsa'],
                ],
            ],
        ];
    }
}
