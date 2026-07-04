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

    public function test_homepage_includes_search_metadata(): void
    {
        $this->withoutVite();

        $this->get('/')
            ->assertOk()
            ->assertSee('<meta name="description"', false)
            ->assertSee('<meta name="robots" content="index, follow">', false)
            ->assertSee('favicon-48x48.png')
            ->assertSee('apple-touch-icon.png')
            ->assertSee('site.webmanifest')
            ->assertSee('<link rel="canonical" href="https://www.portalnasirdjamil.web.id">', false)
            ->assertSee('"@context": "https://schema.org"', false)
            ->assertDontSee('__contextArgs');
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

    public function test_site_icons_are_available(): void
    {
        $this->assertFileExists(public_path('favicon.ico'));
        $this->assertFileExists(public_path('favicon-48x48.png'));
        $this->assertFileExists(public_path('apple-touch-icon.png'));
        $this->assertFileExists(public_path('site.webmanifest'));
        $this->assertStringContainsString('Portal NJ', file_get_contents(public_path('site.webmanifest')));
    }

    public function test_private_site_mode_requires_basic_auth_and_blocks_indexing(): void
    {
        $this->withoutVite();

        config([
            'site.private.enabled' => true,
            'site.private.user' => 'review',
            'site.private.password' => 'secret-review',
        ]);

        $this->get('/')
            ->assertUnauthorized()
            ->assertHeader('WWW-Authenticate', 'Basic realm="Portal Nasir Djamil Review"')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');

        $this->withBasicAuth('review', 'secret-review')
            ->get('/')
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive')
            ->assertSee('<meta name="robots" content="noindex, nofollow, noarchive">', false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee("User-agent: *\nDisallow: /");

        $this->get('/admin/login')->assertOk();
    }

    public function test_private_site_mode_accepts_default_review_credentials(): void
    {
        $this->withoutVite();

        config([
            'site.private.enabled' => true,
            'site.private.user' => 'review',
            'site.private.password' => 'PortalNasirReview2026',
        ]);

        $this->get('/')
            ->assertUnauthorized()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');

        $this->withBasicAuth('review', 'PortalNasirReview2026')
            ->get('/')
            ->assertOk();
    }
}
