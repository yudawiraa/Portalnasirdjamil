# PRD Konversi Website Nasir Djamil ke Laravel + MySQL

Status: Draft untuk approval  
Tanggal: 2026-06-24  
Project sumber: website static HTML/CSS/JS Dr. H. M. Nasir Djamil  
Catatan: Dokumen ini hanya PRD. Implementasi Laravel, database, admin panel, dan testing belum dijalankan.

## 1. Ringkasan

Project saat ini berupa website static yang terdiri dari halaman `index.html`, `profil.html`, `kegiatan.html`, `galeri.html`, `halaman komisi III.html`, `aspirasi.html`, `cek-aspirasi.html`, `style.css`, `shared.js`, dan beberapa aset gambar.

Permintaan produk adalah mengubah project ini menjadi aplikasi Laravel penuh dengan frontend Blade, backend Laravel, database MySQL, form aspirasi yang tersimpan ke database, fitur cek status aspirasi, serta halaman admin untuk manajemen aspirasi. Sistem login hanya memiliki satu role, yaitu admin.

## 2. Masalah Saat Ini

- Website masih static sehingga data aspirasi tidak tersimpan di server.
- Form aspirasi hanya membuat kode dummy di browser menggunakan JavaScript.
- Halaman cek status hanya validasi demo berdasarkan kode yang diawali `ASP-`.
- Belum ada database, autentikasi admin, manajemen status, riwayat perubahan, atau penyimpanan dokumen pendukung.
- Navigasi dan footer diinjeksi melalui `shared.js`, belum memakai layout server-side.
- Ada link `kontak.html` di footer, tetapi file tersebut tidak ditemukan di project.
- Beberapa halaman memiliki CSS/JS inline yang besar dan perlu dirapikan saat dikonversi ke Blade.
- `kegiatan.html` memuat artefak teks generator di awal file (`bash` dan `cat > ...`) yang perlu dibersihkan saat migrasi.
- Encoding teks perlu dinormalisasi ke UTF-8 agar karakter Indonesia, ikon, dan tanda baca tampil benar.

## 3. Tujuan

1. Mengonversi website static menjadi aplikasi Laravel MVC.
2. Menjaga tampilan visual dan struktur konten utama dari project existing.
3. Menghubungkan frontend publik dengan backend Laravel dan database MySQL.
4. Membuat form aspirasi yang menyimpan data nyata ke database.
5. Membuat kode aspirasi unik untuk tracking publik.
6. Membuat halaman cek status aspirasi berdasarkan kode aspirasi dan nomor WhatsApp.
7. Membuat halaman admin dengan login satu role admin.
8. Membuat fitur admin untuk melihat, mencari, memfilter, membuka detail, mengubah status, dan memberi catatan pada aspirasi.
9. Mengamankan dokumen pendukung aspirasi agar hanya admin yang dapat mengakses file asli.
10. Menyiapkan test otomatis dan checklist manual untuk memastikan backend dan frontend berjalan.

## 4. Non-Tujuan

- Tidak membuat multi-role seperti super admin, operator, editor, atau user publik.
- Tidak membuat registrasi publik.
- Tidak membuat CMS penuh untuk semua halaman profil, kegiatan, dan galeri pada fase ini.
- Tidak membuat integrasi WhatsApp gateway, email notification, atau SMS pada fase pertama.
- Tidak membuat aplikasi mobile.
- Tidak mengubah konten politik/profil kecuali diperlukan untuk migrasi teknis dan perbaikan link rusak.

## 5. Pengguna

### 5.1 Masyarakat / Konstituen

Kebutuhan:

- Membaca informasi profil, kegiatan, galeri, dan komisi.
- Mengirim aspirasi melalui form publik.
- Mengunggah dokumen pendukung jika ada.
- Mendapat kode aspirasi setelah submit.
- Mengecek status aspirasi dengan kode dan nomor WhatsApp.

### 5.2 Admin

Kebutuhan:

- Login ke dashboard admin.
- Melihat daftar aspirasi masuk.
- Mencari dan memfilter aspirasi.
- Membaca detail aspirasi dan dokumen pendukung.
- Mengubah status penanganan aspirasi.
- Menambahkan catatan internal dan respons publik.
- Melihat riwayat perubahan status.
- Logout dari sistem.

## 6. Scope Halaman

### 6.1 Halaman Publik yang Dimigrasikan

- Beranda: dari `index.html`.
- Profil: dari `profil.html`.
- Kegiatan: dari `kegiatan.html`.
- Galeri: dari `galeri.html`.
- Komisi III: dari `halaman komisi III.html`.
- Aspirasi: dari `aspirasi.html`, diubah menjadi form Laravel.
- Cek Status Aspirasi: dari `cek-aspirasi.html`, diubah menjadi query database.

### 6.2 Halaman Baru / Perbaikan

- Login admin: `/admin/login`.
- Dashboard admin: `/admin`.
- Daftar aspirasi admin: `/admin/aspirasi`.
- Detail aspirasi admin: `/admin/aspirasi/{id}`.
- Download dokumen admin: `/admin/aspirasi/{aspirasi}/attachments/{attachment}`.
- Route kontak perlu diputuskan: buat halaman kontak sederhana atau hilangkan link agar tidak 404.

## 7. Arsitektur Teknis

### 7.1 Stack

- Backend: Laravel MVC.
- Frontend: Laravel Blade templates.
- Asset pipeline: Vite.
- Database: MySQL atau MariaDB compatible.
- Auth: session-based Laravel authentication.
- Storage file: Laravel filesystem storage.
- Testing: Laravel Feature Test, Unit Test, dan manual browser test.

Versi Laravel ditentukan saat implementasi berdasarkan PHP dan Composer yang tersedia di mesin, dengan target versi stabil aktif yang kompatibel.

### 7.2 Struktur Laravel yang Ditargetkan

```text
app/
  Http/Controllers/
    PageController.php
    AspirasiController.php
    TrackingAspirasiController.php
    Admin/AuthController.php
    Admin/AspirasiAdminController.php
  Models/
    User.php
    Aspirasi.php
    AspirasiCategory.php
    AspirasiAttachment.php
    AspirasiStatusHistory.php
database/
  migrations/
  seeders/
resources/
  views/
    layouts/app.blade.php
    partials/nav.blade.php
    partials/footer.blade.php
    pages/home.blade.php
    pages/profil.blade.php
    pages/kegiatan.blade.php
    pages/galeri.blade.php
    pages/komisi-iii.blade.php
    aspirasi/create.blade.php
    aspirasi/success.blade.php
    aspirasi/track.blade.php
    admin/auth/login.blade.php
    admin/dashboard.blade.php
    admin/aspirasi/index.blade.php
    admin/aspirasi/show.blade.php
  css/app.css
  js/app.js
public/
  images/
routes/
  web.php
```

### 7.3 Strategi Migrasi Frontend

- Pindahkan layout umum dari `shared.js` ke Blade partial `nav` dan `footer`.
- Pindahkan CSS global dari `style.css` ke `resources/css/app.css` atau tetap di `public/css` jika ingin migrasi cepat.
- Pindahkan JavaScript interaksi umum ke `resources/js/app.js`.
- Pindahkan aset gambar ke `public/images`.
- Ubah semua link `.html` menjadi named routes Laravel.
- Pertahankan warna, font, layout, dan komponen visual utama.
- Bersihkan artefak generator dan normalisasi encoding ke UTF-8.
- Pastikan halaman responsive tetap berjalan.

## 8. Database Design

### 8.1 Tabel `users`

Untuk login admin.

| Field | Tipe | Keterangan |
| --- | --- | --- |
| id | bigint | Primary key |
| name | varchar | Nama admin |
| email | varchar unique | Email login |
| password | varchar | Hash password |
| role | varchar | Nilai tetap `admin` |
| remember_token | varchar nullable | Remember me |
| timestamps | timestamp | Created/updated |

Ketentuan:

- Hanya satu role: `admin`.
- Registrasi publik dinonaktifkan.
- Admin awal dibuat melalui seeder.
- Kredensial admin tidak ditulis hardcoded di kode; gunakan `.env` atau prompt seeder.

### 8.2 Tabel `aspirasi_categories`

Kategori aspirasi.

| Field | Tipe | Keterangan |
| --- | --- | --- |
| id | bigint | Primary key |
| name | varchar | Nama kategori |
| slug | varchar unique | Slug |
| is_active | boolean | Status aktif |
| timestamps | timestamp | Created/updated |

Seed awal:

- Hukum & Peradilan
- Hak Warga dalam Proses Hukum
- Kepolisian & Ketertiban Umum
- Pertanahan & Agraria
- Pelayanan Publik
- Pembangunan Daerah Aceh
- Korupsi & Penegakan Hukum
- Perlindungan Saksi/Korban
- Narkoba & BNN
- Lainnya

### 8.3 Tabel `aspirations`

Data utama aspirasi.

| Field | Tipe | Keterangan |
| --- | --- | --- |
| id | bigint | Primary key |
| code | varchar unique | Kode publik, contoh `ASP-2026-12345` |
| name | varchar | Nama lengkap pengirim |
| nik | varchar nullable | NIK, disimpan sebagai string |
| whatsapp | varchar | Nomor WhatsApp |
| email | varchar nullable | Email pengirim |
| city | varchar | Kabupaten/Kota |
| district_village | varchar nullable | Kecamatan/desa |
| category_id | bigint | Relasi kategori |
| title | varchar | Judul aspirasi |
| body | text | Isi aspirasi |
| status | varchar | Status saat ini |
| public_response | text nullable | Respons yang boleh tampil di tracking publik |
| internal_note | text nullable | Catatan internal admin |
| submitted_at | timestamp | Waktu submit |
| verified_at | timestamp nullable | Waktu verifikasi |
| completed_at | timestamp nullable | Waktu selesai |
| timestamps | timestamp | Created/updated |

### 8.4 Tabel `aspiration_attachments`

Dokumen pendukung aspirasi.

| Field | Tipe | Keterangan |
| --- | --- | --- |
| id | bigint | Primary key |
| aspiration_id | bigint | Relasi aspirasi |
| original_name | varchar | Nama file asli |
| path | varchar | Path storage internal |
| mime_type | varchar | MIME type |
| size_bytes | integer | Ukuran file |
| timestamps | timestamp | Created/updated |

Ketentuan:

- File tidak disimpan di folder publik terbuka.
- File hanya bisa diunduh admin setelah login.
- Format file: PDF, JPG, JPEG, PNG.
- Maksimal 5 MB per file.
- Batas jumlah file: 5 file per aspirasi.

### 8.5 Tabel `aspiration_status_histories`

Riwayat perubahan status.

| Field | Tipe | Keterangan |
| --- | --- | --- |
| id | bigint | Primary key |
| aspiration_id | bigint | Relasi aspirasi |
| from_status | varchar nullable | Status sebelumnya |
| to_status | varchar | Status baru |
| note | text nullable | Catatan perubahan |
| changed_by | bigint nullable | Admin yang mengubah |
| created_at | timestamp | Waktu perubahan |

## 9. Status Aspirasi

Status sistem:

| Status internal | Label publik | Keterangan |
| --- | --- | --- |
| received | Diterima | Aspirasi masuk dan menunggu verifikasi |
| verified | Verifikasi & Klasifikasi | Admin sudah memverifikasi dan mengklasifikasi |
| in_review | Telaah Internal | Aspirasi sedang ditelaah |
| follow_up | Tindak Lanjut | Sedang dikoordinasikan atau ditindaklanjuti |
| completed | Selesai | Penanganan selesai |
| need_data | Butuh Data Tambahan | Admin membutuhkan data tambahan |
| rejected | Ditolak | Aspirasi tidak dapat diproses |

Tracking publik menampilkan status, timeline, judul, kategori, tanggal masuk, dan respons publik. Data sensitif seperti NIK, email, catatan internal, dan dokumen tidak ditampilkan ke publik.

## 10. Functional Requirements

### F-001 Konversi Halaman Publik ke Laravel

- Semua halaman static existing berubah menjadi Blade.
- Navigasi aktif mengikuti route saat ini.
- Footer tampil konsisten di semua halaman.
- Link internal tidak lagi memakai `.html`.
- Tidak ada broken link internal.

Acceptance criteria:

- `/`, `/profil`, `/kegiatan`, `/galeri`, `/komisi-iii`, `/aspirasi`, dan `/cek-aspirasi` mengembalikan HTTP 200.
- Tampilan desktop dan mobile tetap rapi.
- Asset gambar existing tampil.

### F-002 Submit Aspirasi

- User dapat mengisi multi-step form aspirasi.
- Field wajib: nama, WhatsApp, kota, kategori, judul, isi aspirasi, persetujuan.
- Field opsional: NIK, email, kecamatan/desa, dokumen.
- Setelah submit berhasil, sistem menyimpan data ke MySQL.
- Sistem membuat kode aspirasi unik.
- User diarahkan ke halaman sukses dan melihat kode aspirasi.

Acceptance criteria:

- Data valid tersimpan ke tabel `aspirations`.
- Kode aspirasi unik dan tidak dibuat di browser.
- Data invalid menampilkan error validasi.
- Upload file valid tersimpan sebagai attachment.
- File invalid ditolak.

### F-003 Cek Status Aspirasi

- User memasukkan kode aspirasi dan nomor WhatsApp.
- Sistem mencari data berdasarkan kombinasi kode dan WhatsApp.
- Jika cocok, sistem menampilkan status dan timeline.
- Jika tidak cocok, tampilkan pesan tidak ditemukan.

Acceptance criteria:

- Kode valid + WhatsApp valid menampilkan data yang benar.
- Kode valid + WhatsApp salah tidak membuka data.
- Data sensitif tidak tampil di halaman publik.

### F-004 Admin Login

- Admin dapat login melalui `/admin/login`.
- Hanya user role `admin` yang bisa mengakses `/admin/*`.
- Setelah login, admin diarahkan ke dashboard.
- Admin dapat logout.

Acceptance criteria:

- Route admin redirect ke login jika belum login.
- Login gagal menampilkan pesan error.
- Password disimpan dalam bentuk hash.
- Registrasi publik tidak tersedia.

### F-005 Dashboard Admin

- Dashboard menampilkan ringkasan jumlah aspirasi:
  - total aspirasi
  - diterima
  - sedang diproses
  - selesai
  - butuh data/ditolak
- Dashboard menampilkan daftar aspirasi terbaru.

Acceptance criteria:

- Angka ringkasan sesuai database.
- Daftar terbaru terurut dari submit terbaru.

### F-006 Manajemen Aspirasi Admin

- Admin dapat melihat daftar aspirasi dengan pagination.
- Admin dapat mencari berdasarkan kode, nama, WhatsApp, judul, atau kota.
- Admin dapat filter berdasarkan status, kategori, kota, dan rentang tanggal.
- Admin dapat membuka detail aspirasi.
- Admin dapat mengubah status aspirasi.
- Admin dapat mengubah kategori jika diperlukan.
- Admin dapat menambahkan catatan internal.
- Admin dapat menambahkan respons publik.
- Admin dapat mengunduh dokumen pendukung.

Acceptance criteria:

- Perubahan status tersimpan.
- Riwayat status bertambah setiap status berubah.
- Catatan internal tidak tampil di tracking publik.
- Respons publik tampil di tracking publik jika diisi.
- Dokumen hanya bisa dibuka oleh admin login.

### F-007 Audit dan Riwayat

- Setiap perubahan status dicatat di `aspiration_status_histories`.
- Detail admin menampilkan timeline riwayat perubahan.

Acceptance criteria:

- Submit aspirasi membuat riwayat awal `received`.
- Update status membuat riwayat baru.
- Riwayat mencatat admin yang mengubah.

### F-008 Seed Data

- Seeder membuat satu admin awal.
- Seeder membuat kategori aspirasi awal.

Acceptance criteria:

- Setelah `php artisan migrate --seed`, admin bisa login.
- Kategori tampil di form aspirasi.

## 11. Validation Rules

### Form Aspirasi

- `name`: required, string, max 150.
- `nik`: nullable, numeric string, length 16 jika diisi.
- `whatsapp`: required, string, max 30, format nomor Indonesia dasar.
- `email`: nullable, email, max 150.
- `city`: required, string, max 100.
- `district_village`: nullable, string, max 150.
- `category_id`: required, exists active category.
- `title`: required, string, max 200.
- `body`: required, string, min 20.
- `agreement`: accepted.
- `attachments.*`: nullable, file, mimes pdf/jpg/jpeg/png, max 5120 KB.
- jumlah attachment maksimal 5.

### Form Admin Update

- `status`: required, valid status.
- `category_id`: required, exists category.
- `public_response`: nullable, string.
- `internal_note`: nullable, string.
- `history_note`: nullable, string, max 2000.

## 12. Security Requirements

- Gunakan CSRF protection untuk semua form.
- Gunakan session authentication Laravel.
- Password admin di-hash.
- Route admin dilindungi middleware auth dan role admin.
- Upload file divalidasi berdasarkan MIME dan ekstensi.
- Dokumen pendukung tidak boleh tersedia sebagai URL publik langsung.
- Tracking publik wajib memakai kode aspirasi + WhatsApp agar data tidak mudah ditebak.
- Terapkan rate limiting untuk submit aspirasi dan cek status.
- Jangan menampilkan NIK, email, dokumen, atau catatan internal ke publik.
- Escape semua output Blade untuk mencegah XSS.
- Gunakan konfigurasi `.env` untuk database dan kredensial awal.

## 13. Non-Functional Requirements

- Responsive minimal untuk mobile, tablet, dan desktop.
- Halaman publik utama harus tetap cepat dimuat.
- Form harus tetap usable tanpa reload antar-step di sisi frontend, tetapi submit akhir harus ke server.
- Error validasi harus jelas dan dekat dengan field terkait.
- Aplikasi harus berjalan di environment lokal dengan MySQL.
- Build asset harus berhasil tanpa error.
- Test otomatis harus bisa dijalankan ulang.

## 14. Route Plan

| Method | Route | Nama | Fungsi |
| --- | --- | --- | --- |
| GET | `/` | `home` | Beranda |
| GET | `/profil` | `profil` | Profil |
| GET | `/kegiatan` | `kegiatan` | Kegiatan |
| GET | `/galeri` | `galeri` | Galeri |
| GET | `/komisi-iii` | `komisi-iii` | Komisi III |
| GET | `/aspirasi` | `aspirasi.create` | Form aspirasi |
| POST | `/aspirasi` | `aspirasi.store` | Simpan aspirasi |
| GET | `/aspirasi/sukses/{code}` | `aspirasi.success` | Sukses submit |
| GET | `/cek-aspirasi` | `aspirasi.track.form` | Form tracking |
| POST | `/cek-aspirasi` | `aspirasi.track.lookup` | Cari status |
| GET | `/admin/login` | `admin.login` | Form login |
| POST | `/admin/login` | `admin.login.submit` | Proses login |
| POST | `/admin/logout` | `admin.logout` | Logout |
| GET | `/admin` | `admin.dashboard` | Dashboard |
| GET | `/admin/aspirasi` | `admin.aspirasi.index` | Daftar aspirasi |
| GET | `/admin/aspirasi/{aspirasi}` | `admin.aspirasi.show` | Detail aspirasi |
| PATCH | `/admin/aspirasi/{aspirasi}` | `admin.aspirasi.update` | Update aspirasi |
| GET | `/admin/aspirasi/{aspirasi}/attachments/{attachment}` | `admin.aspirasi.attachments.show` | Download dokumen |

## 15. Admin UI Requirements

### 15.1 Login

- Tampilan mengikuti tema website: merah, emas, gelap.
- Field email dan password.
- Remember me opsional.
- Error login jelas.

### 15.2 Dashboard

- Ringkasan statistik dalam kartu.
- Tabel aspirasi terbaru.
- Link cepat ke daftar aspirasi.

### 15.3 Daftar Aspirasi

Kolom minimal:

- Kode
- Tanggal masuk
- Nama
- WhatsApp
- Kota
- Kategori
- Judul
- Status
- Aksi detail

Filter:

- Search keyword
- Status
- Kategori
- Kota
- Tanggal dari/sampai

### 15.4 Detail Aspirasi

Bagian minimal:

- Identitas pengirim
- Detail lokasi
- Kategori dan judul
- Isi aspirasi
- Dokumen pendukung
- Status saat ini
- Form update status
- Catatan internal
- Respons publik
- Riwayat status

## 16. Testing Plan

Testing dilakukan setelah implementasi, bukan pada fase PRD ini.

### 16.1 Automated Feature Tests

- Public pages return HTTP 200.
- Form aspirasi berhasil menyimpan data valid.
- Form aspirasi menolak field wajib yang kosong.
- Form aspirasi menolak NIK tidak valid.
- Form aspirasi menolak file selain PDF/JPG/PNG.
- Form aspirasi menolak file lebih dari 5 MB.
- Kode aspirasi unik dibuat oleh backend.
- Submit aspirasi membuat history awal `received`.
- Cek status berhasil dengan kode dan WhatsApp benar.
- Cek status gagal dengan WhatsApp salah.
- Data sensitif tidak tampil di response publik.
- Admin login berhasil dengan kredensial benar.
- Admin login gagal dengan kredensial salah.
- Route admin tidak bisa diakses tanpa login.
- Daftar aspirasi admin tampil setelah login.
- Filter/search daftar aspirasi bekerja.
- Update status aspirasi berhasil.
- Update status membuat history baru.
- Attachment hanya bisa diakses admin login.

### 16.2 Unit Tests

- Generator kode aspirasi menghasilkan format `ASP-YYYY-XXXXX`.
- Generator kode menangani potensi collision.
- Mapping status internal ke label publik benar.
- Normalisasi nomor WhatsApp konsisten.

### 16.3 Browser / Manual Tests

- Beranda, profil, kegiatan, galeri, komisi, aspirasi, cek status tampil baik di desktop.
- Halaman publik tampil baik di mobile.
- Multi-step form aspirasi bisa lanjut, kembali, validasi, dan submit.
- Halaman sukses menampilkan kode aspirasi.
- Kode tersebut bisa dipakai untuk cek status.
- Admin bisa login, melihat daftar, buka detail, update status, dan logout.
- Dokumen pendukung bisa diunduh admin.
- Link internal tidak 404.

### 16.4 Command Verifikasi

Command target setelah implementasi:

```bash
composer test
php artisan test
npm run build
php artisan route:list
php artisan migrate:fresh --seed
```

Jika environment memakai Windows PowerShell, command dijalankan dengan penyesuaian shell lokal.

## 17. Definition of Done

Implementasi dianggap selesai jika:

- Project sudah berjalan sebagai aplikasi Laravel.
- Semua halaman publik utama tersedia sebagai route Laravel.
- Database MySQL bisa dimigrasikan dan di-seed.
- Admin awal bisa login.
- Aspirasi publik tersimpan ke database.
- Kode aspirasi bisa dipakai untuk cek status.
- Admin bisa memproses aspirasi dan mengubah status.
- Attachment aman dan hanya bisa dibuka admin.
- Test otomatis utama lulus.
- Build asset lulus.
- Tidak ada broken link internal utama.
- Dokumentasi setup lokal tersedia di README atau file instruksi terpisah.

## 18. Risiko dan Mitigasi

| Risiko | Dampak | Mitigasi |
| --- | --- | --- |
| Tidak ada Git repo | Sulit rollback | Buat salinan aman sebelum migrasi atau inisialisasi Git sebelum implementasi |
| Laravel scaffold bentrok dengan file static root | File lama bisa tertimpa | Migrasi bertahap dan simpan file lama sebagai referensi |
| MySQL lokal belum tersedia | Backend tidak bisa diuji penuh | Validasi environment sebelum implementasi |
| Encoding file existing tidak konsisten | Teks/ikon rusak | Normalisasi ke UTF-8 saat migrasi |
| Upload file tidak diamankan | Risiko akses data sensitif | Simpan di storage non-public dan layani via controller admin |
| Scope melebar ke CMS kegiatan/galeri | Waktu implementasi membengkak | Fase pertama hanya admin aspirasi |

## 19. Keputusan yang Perlu Disetujui Sebelum Implementasi

1. Admin awal dibuat via `.env` dengan `ADMIN_EMAIL` dan `ADMIN_PASSWORD`, atau ditentukan manual saat implementasi.
2. Link `kontak.html` akan dibuat sebagai halaman kontak sederhana atau dihapus dari footer.
3. Halaman kegiatan dan galeri pada fase pertama tetap static Blade, belum menjadi CMS.
4. Nama database MySQL lokal yang akan dipakai.
5. Apakah file project static lama disimpan dalam folder backup internal sebelum Laravel scaffold dibuat.

## 20. Rekomendasi Implementasi Setelah PRD Disetujui

Urutan kerja yang disarankan:

1. Validasi environment PHP, Composer, Node, dan MySQL.
2. Buat backup/salinan referensi file static.
3. Scaffold Laravel.
4. Konfigurasi `.env` database MySQL.
5. Buat migration, model, seeder, dan auth admin.
6. Migrasi halaman public ke Blade layout.
7. Implementasi form aspirasi dan tracking.
8. Implementasi admin dashboard dan manajemen aspirasi.
9. Tambahkan automated tests.
10. Jalankan migration, seed, test, build, dan browser smoke test.
