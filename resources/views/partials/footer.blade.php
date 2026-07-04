<footer class="site-footer">
    <div class="footer-grid">
        <div>
            <div class="footer-brand-name">Dr. H. M. Nasir Djamil, M.Si</div>
            <p class="footer-desc">Anggota DPR RI Komisi III Fraksi PKS, mewakili Daerah Pemilihan Aceh II. Website ini memuat profil, kegiatan, galeri, dan layanan aspirasi konstituen.</p>
            <div class="footer-social">
                <a
                    href="https://www.instagram.com/m.nasirdjamil?utm_source=ig_web_button_share_sheet&amp;igsh=ZDNlZDc0MzIxNw=="
                    class="footer-social-link"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Instagram Dr. H. M. Nasir Djamil, M.Si"
                >
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                        <circle cx="12" cy="12" r="4"></circle>
                        <circle cx="17.5" cy="6.5" r="1.2"></circle>
                    </svg>
                    <span>Instagram</span>
                </a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Navigasi</h4>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('profil') }}">Profil</a>
            <a href="{{ route('kegiatan') }}">Kegiatan</a>
            <a href="{{ route('galeri') }}">Galeri</a>
        </div>
        <div class="footer-col">
            <h4>Layanan</h4>
            <a href="{{ route('aspirasi.create') }}">Sampaikan Aspirasi</a>
            <a href="{{ route('aspirasi.track.form') }}">Cek Status Aspirasi</a>
            <a href="{{ route('faq') }}">FAQ</a>
            <a href="{{ route('kontak') }}">Kontak & Lokasi</a>
        </div>
        <div class="footer-col">
            <h4>Kantor</h4>
            <span class="footer-text">Gedung Nusantara I, DPR RI</span>
            <span class="footer-text">Jl. Gatot Subroto, Jakarta</span>
            <span class="footer-text">Senin-Jumat 08.00-16.00</span>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Dr. H. M. Nasir Djamil, M.Si</p>
        <p>Sistem Informasi Aspirasi dan Publikasi Kegiatan Konstituen</p>
    </div>
</footer>
