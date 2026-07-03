<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render_successfully(): void
    {
        $this->withoutVite();
        $this->seed();

        foreach (['/', '/profil', '/kegiatan', '/galeri', '/kontak', '/aspirasi', '/cek-aspirasi'] as $uri) {
            $this->get($uri)->assertOk();
        }

        $this->get('/kegiatan/reses-aceh-barat')->assertOk();
        $this->get('/kegiatan/diskusi-dema-fkd-uin-ar-raniry')->assertOk();
        $this->get('/kegiatan/pengukuhan-paralegal-yara')->assertOk();
        $this->get('/kegiatan/kuliah-umum-stai-pante-kulu')->assertOk()->assertSee('Kuliah Umum');
        $this->get('/kegiatan/fgd-bukber-dpd-pks-langsa')->assertOk()->assertSee('FGD');
        $this->get('/kegiatan')
            ->assertOk()
            ->assertSee('Video Dokumentasi')
            ->assertSee('Soft Launching BLKK')
            ->assertSee('DXwIXLjhUN6')
            ->assertSee('data-show-on-all="false"', false)
            ->assertDontSee('Kunjungan Kerja Daerah');
        $this->get('/galeri/pengukuhan-paralegal-yara')->assertOk();
        $this->get('/galeri/agenda-legislasi-hukum')->assertOk();
        $this->get('/galeri/kuliah-umum-stai-pante-kulu')->assertOk()->assertSee('Kuliah Umum');
        $this->get('/galeri/fgd-bukber-dpd-pks-langsa')->assertOk()->assertSee('FGD');
        $this->get('/komisi-iii')->assertRedirect('/#komisi-iii');
    }

    public function test_search_engine_files_are_available(): void
    {
        config(['app.url' => 'https://www.portalnasirdjamil.web.id']);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('User-agent: *')
            ->assertSee('Sitemap: https://www.portalnasirdjamil.web.id/sitemap.xml');

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false)
            ->assertSee('<loc>https://www.portalnasirdjamil.web.id</loc>', false)
            ->assertSee('<loc>https://www.portalnasirdjamil.web.id/profil</loc>', false)
            ->assertSee('<loc>https://www.portalnasirdjamil.web.id/kegiatan/pengukuhan-paralegal-yara</loc>', false)
            ->assertSee('<loc>https://www.portalnasirdjamil.web.id/galeri/fgd-bukber-dpd-pks-langsa</loc>', false)
            ->assertDontSee('/admin')
            ->assertDontSee('/aspirasi/sukses');
    }
}
