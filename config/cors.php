<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    // Enable CORS for all API routes and authentication endpoints
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Allow common HTTP methods (GET, POST, PUT, PATCH, DELETE, OPTIONS)
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    // Specify the origins that are allowed to access your API
    // Include both your frontend domain and any development domains
    'allowed_origins' => ['*'],

    // You can use patterns if you have multiple subdomains
    'allowed_origins_patterns' => [
        // Uncomment if you have multiple subdomains
        // '#^https://(.+\.)?ajza\.net$#',
    ],

    // Allow common headers that are typically sent in API requests
    'allowed_headers' => [
        'Accept',
        'Content-Type',
        'X-Requested-With',
        'X-CSRF-TOKEN',
        'Authorization',
        'X-XSRF-TOKEN',
    ],

    // Headers that you want to expose to the client
    'exposed_headers' => [],

    // Cache preflight requests (in seconds, 0 = disabled)
    'max_age' => 86400, // 24 hours

    // Enable cookies and authentication headers (important for auth endpoints)
    'supports_credentials' => true,
];
