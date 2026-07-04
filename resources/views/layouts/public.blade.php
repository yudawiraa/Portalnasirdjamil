<!DOCTYPE html>
<html lang="id">
<head>
    @php
        $publicUrl = rtrim((string) config('app.url', 'https://www.portalnasirdjamil.web.id'), '/');
        $publicHost = parse_url($publicUrl, PHP_URL_HOST);

        if ($publicHost !== 'www.portalnasirdjamil.web.id') {
            $publicUrl = 'https://www.portalnasirdjamil.web.id';
        }

        $currentPath = request()->path() === '/' ? '' : '/'.request()->path();
        $pageTitle = trim($__env->yieldContent('title', 'Dr. H. M. Nasir Djamil, M.Si'));
        $metaDescription = trim($__env->yieldContent('description', 'Portal resmi Dr. H. M. Nasir Djamil, M.Si, Anggota Komisi III DPR RI Fraksi PKS dari Daerah Pemilihan Aceh II.'));
        $robotsContent = config('site.private.enabled')
            ? 'noindex, nofollow, noarchive'
            : trim($__env->yieldContent('robots', 'index, follow'));
        $canonicalUrl = trim($__env->yieldContent('canonical', $publicUrl.$currentPath));
        $metaImage = trim($__env->yieldContent('image', $publicUrl.'/images/untuk profil.png'));
        $schemaContext = '@'.'context';
        $schemaGraph = '@'.'graph';
        $schemaType = '@'.'type';
        $schemaId = '@'.'id';
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="aN_mqOqnWonhJKz1OFRPxAibHrDCS3cAbMqyhFgciDE" />
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="{{ $robotsContent }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Portal Nasir Djamil">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    <script type="application/ld+json">
        {!! json_encode([
            $schemaContext => 'https://schema.org',
            $schemaGraph => [
                [
                    $schemaType => 'Person',
                    $schemaId => $publicUrl.'/#person',
                    'name' => 'Dr. H. M. Nasir Djamil, M.Si',
                    'jobTitle' => 'Anggota DPR RI Komisi III',
                    'url' => $publicUrl,
                    'sameAs' => [
                        'https://www.instagram.com/m.nasirdjamil',
                    ],
                ],
                [
                    $schemaType => 'WebSite',
                    $schemaId => $publicUrl.'/#website',
                    'name' => 'Portal Nasir Djamil',
                    'url' => $publicUrl,
                    'inLanguage' => 'id-ID',
                    'publisher' => [
                        $schemaId => $publicUrl.'/#person',
                    ],
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body data-page="@yield('page', '')">
    @include('partials.nav')

    <main class="page-wrap">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
