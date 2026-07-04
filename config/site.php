<?php

return [
    'private' => [
        'enabled' => env('SITE_PRIVATE', env('APP_ENV', 'production') === 'production'),
        'user' => env('SITE_PRIVATE_USER', 'review'),
        'password' => env('SITE_PRIVATE_PASSWORD', env('ADMIN_PASSWORD', 'PortalNasirReview2026')),
        'realm' => env('SITE_PRIVATE_REALM', 'Portal Nasir Djamil Review'),
    ],
];
