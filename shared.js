// shared.js — inject nav + footer + reveal observer

const NAV_HTML = `
<nav class="topnav">
  <a class="nav-brand" href="index.html">
    <div class="nav-logo">NJ</div>
    <div class="nav-title">
      <strong>Dr. H. M. Nasir Djamil,M.Si</strong>
      <span>Anggota DPR RI · Komisi III · Fraksi PKS</span>
    </div>
  </a>
  <div class="nav-links">
    <a href="index.html" data-page="index">Beranda</a>
    <a href="profil.html" data-page="profil">Profil</a>
    <a href="kegiatan.html" data-page="kegiatan">Kegiatan</a>
    <a href="galeri.html" data-page="galeri">Galeri</a>
    <a href="aspirasi.html" data-page="aspirasi" class="nav-cta">Aspirasi</a>
  </div>
</nav>`;

const FOOTER_HTML = `
<footer class="site-footer">
  <div class="footer-grid">
    <div>
      <div class="footer-brand-name">Dr. H. M. Nasir Djamil</div>
      <p class="footer-desc">Anggota DPR RI Komisi III Fraksi PKS, mewakili Daerah Pemilihan Aceh II. Berkomitmen mengawal penegakan hukum dan akses keadilan untuk seluruh rakyat Indonesia.</p>
      <div class="footer-sosmed">
        <a href="https://www.facebook.com/mnasirdjamil" target="_blank" class="s-fb">Facebook</a>
        <a href="https://www.instagram.com/m.nasirdjamil" target="_blank" class="s-ig">Instagram</a>
        <a href="#" class="s-yt">YouTube</a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Navigasi</h4>
      <a href="index.html">Beranda</a>
      <a href="profil.html">Profil</a>
      <a href="kegiatan.html">Kegiatan</a>
      <a href="galeri.html">Galeri</a>
    </div>
    <div class="footer-col">
      <h4>Layanan</h4>
      <a href="aspirasi.html">Sampaikan Aspirasi</a>
      <a href="cek-aspirasi.html">Cek Status Aspirasi</a>
      <a href="kontak.html">Kontak &amp; Lokasi</a>
    </div>
    <div class="footer-col">
      <h4>Kantor</h4>
      <a href="#">Gedung Nusantara I, DPR RI</a>
      <a href="#">Jl. Gatot Subroto, Jakarta</a>
      <a href="#">Senin–Jumat 08.00–16.00</a>
      <a href="#">nasirdjamil@dpr.go.id</a>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2025 Dr. H. M. Nasir Djamil — Anggota DPR RI Dapil Aceh II</p>
    <p class="sistem">Sistem Informasi Aspirasi dan Publikasi Kegiatan Konstituen</p>
  </div>
</footer>`;

document.addEventListener('DOMContentLoaded', () => {
  // Inject nav
  const navEl = document.createElement('div');
  navEl.innerHTML = NAV_HTML;
  document.body.prepend(navEl.firstElementChild);

  // Inject footer
  const footEl = document.createElement('div');
  footEl.innerHTML = FOOTER_HTML;
  document.body.appendChild(footEl.firstElementChild);

  // Active nav link
  const page = document.body.dataset.page || '';
  document.querySelectorAll('.nav-links a[data-page]').forEach(a => {
    if (a.dataset.page === page) a.classList.add('active');
  });

  // Reveal on scroll
  const revealObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); revealObs.unobserve(e.target); } });
  }, { threshold: 0.1 });
  document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));
});
