<?php

return [

    'csrf_protection' => true,

    'xss_protection' => true,

    'content_security_policy' => "default-src 'self'; script-src 'self'; object-src 'none';",

    'secure_headers' => [

        'X-Content-Type-Options' => 'nosniff',

        'X-Frame-Options' => 'DENY',

        'X-XSS-Protection' => '1; mode=block',

        'Referrer-Policy' => 'no-referrer',

    ],

    'password_hashing' => [

        'driver' => 'bcrypt',

        'cost' => 10,

    ],

    'session_security' => [

        'secure' => env('SESSION_SECURE_COOKIE', true),

        'http_only' => true,

        'same_site' => 'Strict',

    ],

];