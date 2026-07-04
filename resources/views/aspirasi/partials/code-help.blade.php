@php
    $whatsappNumber = preg_replace('/\D+/', '', (string) ($adminWhatsapp ?? '')) ?: '';

    if (str_starts_with($whatsappNumber, '0')) {
        $whatsappNumber = '62'.substr($whatsappNumber, 1);
    }

    $whatsappUrl = $whatsappNumber
        ? 'https://wa.me/'.$whatsappNumber.'?text='.rawurlencode('Assalamualaikum Admin Aspirasi, saya ingin bertanya tentang kode aspirasi. Nama: ... Nomor WhatsApp pengirim: ... Judul aspirasi: ...')
        : null;
@endphp

<div class="code-help reveal">
    <div>
        <div class="section-kop">Pengingat Kode</div>
        <h3>Catat kode aspirasi setelah formulir terkirim.</h3>
        <p>Kode aspirasi bukan OTP WhatsApp dan tidak otomatis dikirim ke WA. Simpan dengan cara disalin, dicatat, atau screenshot halaman berhasil agar status bisa dicek kembali.</p>
    </div>
    <div class="code-help-actions">
        @if ($whatsappUrl)
            <a class="btn btn-merah" href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer">Hubungi Admin WA</a>
        @else
            <a class="btn btn-outline" href="{{ route('kontak') }}">Kontak Admin</a>
        @endif
        <a class="btn btn-outline" href="{{ route('aspirasi.track.form') }}">Cek Status</a>
    </div>
</div>
