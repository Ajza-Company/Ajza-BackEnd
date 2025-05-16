<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthCors
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log the request details for debugging
        Log::info('Auth CORS Request', [
            'origin' => $request->header('Origin'),
            'method' => $request->method(),
            'path' => $request->path(),
        ]);

        $response = $next($request);

        // Ensure proper CORS headers for auth endpoints
        $origin = $request->header('Origin');
        if ($origin) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With, Accept');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
            $response->headers->set('Access-Control-Max-Age', '86400');

            // Log the response headers for debugging
            Log::info('Auth CORS Response Headers', [
                'headers' => [
                    'Access-Control-Allow-Origin' => $response->headers->get('Access-Control-Allow-Origin'),
                    'Access-Control-Allow-Methods' => $response->headers->get('Access-Control-Allow-Methods'),
                    'Access-Control-Allow-Headers' => $response->headers->get('Access-Control-Allow-Headers'),
                    'Access-Control-Allow-Credentials' => $response->headers->get('Access-Control-Allow-Credentials'),
                ],
            ]);
        }

        return $response;
    }
}
