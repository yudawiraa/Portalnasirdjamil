# Website Laravel Aspirasi Nasir Djamil, M.Si

Aplikasi ini adalah hasil konversi website static Dr. H. M. Nasir Djamil, M.Si menjadi Laravel + MySQL. Frontend publik memakai Blade, backend memakai Laravel MVC, dan admin panel memiliki satu role: `admin`.

## Fitur Utama

- Halaman publik: beranda, profil, kegiatan, galeri, kontak, aspirasi, dan cek status.
- Form aspirasi publik dengan validasi server-side.
- Upload dokumen pendukung PDF/JPG/PNG maksimal 5 MB per file.
- Kode tracking aspirasi otomatis dengan format `ASP-YYYY-XXXXX`.
- Halaman cek status berdasarkan kode aspirasi dan nomor WhatsApp.
- Login admin satu role.
- Dashboard admin, filter daftar aspirasi, detail aspirasi, update status, respons publik, catatan internal, riwayat status.
- Dokumen pendukung hanya dapat diunduh oleh admin login.

## Setup Lokal

1. Pastikan PHP 8.2+, Composer, dan MySQL/MariaDB aktif.
2. Buat database:

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS nasir_djamil_aspirasi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

3. Salin environment jika belum ada:

```bash
cp .env.example .env
```

4. Sesuaikan kredensial database dan admin di `.env`.
5. Install dependency PHP:

```bash
composer install
php artisan key:generate
```

6. Jalankan migration dan seeder:

```bash
php artisan migrate:fresh --seed
```

7. Install dan build asset:

```bash
pnpm install
pnpm build
```

8. Jalankan server:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

URL lokal:

- Publik: `http://127.0.0.1:8000`
- Admin: `http://127.0.0.1:8000/admin/login`

Default admin lokal dari `.env.example`:

- Email: `admin@nasirdjamil.local`
- Password: `password`

Ganti password sebelum deploy.

## Testing

```bash
composer test
php artisan test
pnpm build
php artisan route:list
```

Test otomatis mencakup halaman publik, submit aspirasi, tracking, login admin, update status, dan proteksi attachment.

## Catatan Project

- File static lama disimpan di folder `legacy-static` sebagai referensi migrasi.
- File upload aspirasi disimpan di disk `local` Laravel (`storage/app/private`) dan tidak dibuka sebagai URL publik langsung.
- Warning PHP tentang `oci8_19` berasal dari konfigurasi PHP/XAMPP lokal dan tidak dipakai oleh aplikasi ini.
