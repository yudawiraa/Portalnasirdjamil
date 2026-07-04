<?php

return [
    'private' => [
        'enabled' => env('SITE_PRIVATE', false),
        'user' => env('SITE_PRIVATE_USER', 'review'),
        'password' => env('SITE_PRIVATE_PASSWORD'),
        'realm' => env('SITE_PRIVATE_REALM', 'Portal Nasir Djamil Review'),
    ],
];
