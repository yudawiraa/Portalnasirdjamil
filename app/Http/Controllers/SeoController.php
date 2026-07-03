<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SeoController extends Controller
{
    private const PUBLIC_URL = 'https://www.portalnasirdjamil.web.id';

    private const ACTIVITY_SLUGS = [
        'reses-aceh-barat',
        'rapat-kerja-komisi-iii',
        'fgd-bukber-dpd-pks-langsa',
        'agenda-legislasi-hukum',
        'pengukuhan-paralegal-yara',
        'diskusi-dema-fkd-uin-ar-raniry',
        'kuliah-umum-stai-pante-kulu',
        'aspirasi-masyarakat-aceh-ii',
        'rapat-dengar-pendapat',
    ];

    private const GALLERY_SLUGS = [
        'pengukuhan-paralegal-yara',
        'agenda-legislasi-hukum',
        'diskusi-dema-fkd-uin-ar-raniry',
        'kuliah-umum-stai-pante-kulu',
        'reses-dan-dialog-masyarakat',
        'agenda-rapat-kerja-komisi-iii',
        'fgd-bukber-dpd-pks-langsa',
    ];

    public function sitemap(): Response
    {
        $urls = [
            $this->entry('/', 'weekly', '1.0'),
            $this->entry('/profil', 'monthly', '0.8'),
            $this->entry('/kegiatan', 'weekly', '0.9'),
            $this->entry('/galeri', 'weekly', '0.8'),
            $this->entry('/aspirasi', 'monthly', '0.7'),
            $this->entry('/cek-aspirasi', 'monthly', '0.5'),
            $this->entry('/kontak', 'monthly', '0.5'),
        ];

        foreach (self::ACTIVITY_SLUGS as $slug) {
            $urls[] = $this->entry("/kegiatan/{$slug}", 'monthly', '0.7');
        }

        foreach (self::GALLERY_SLUGS as $slug) {
            $urls[] = $this->entry("/galeri/{$slug}", 'monthly', '0.6');
        }

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        return response(
            "User-agent: *\nAllow: /\n\nSitemap: ".self::PUBLIC_URL."/sitemap.xml\n",
            200,
            ['Content-Type' => 'text/plain; charset=UTF-8']
        );
    }

    private function entry(string $path, string $changefreq, string $priority): array
    {
        return [
            'loc' => $this->publicUrl($path),
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }

    private function publicUrl(string $path): string
    {
        $baseUrl = rtrim((string) config('app.url', self::PUBLIC_URL), '/');
        $host = parse_url($baseUrl, PHP_URL_HOST);

        if ($host !== 'www.portalnasirdjamil.web.id') {
            $baseUrl = self::PUBLIC_URL;
        }

        if ($path === '/') {
            return $baseUrl;
        }

        return $baseUrl.'/'.ltrim($path, '/');
    }
}
