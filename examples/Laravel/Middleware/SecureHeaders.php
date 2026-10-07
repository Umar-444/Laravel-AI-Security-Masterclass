<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Security Headers Middleware — Laravel 13 / PHP 8.4
 *
 * Implements modern HTTP security headers per OWASP 2025 recommendations.
 * Registration: bootstrap/app.php → withMiddleware()
 *
 * NOTE: X-XSS-Protection has been intentionally REMOVED.
 * It is deprecated and removed in Chrome, Firefox, Edge, and Safari.
 * Use a strict Content-Security-Policy instead.
 */
class SecureHeaders
{
    /**
     * Core security headers applied to every response.
     * X-XSS-Protection is intentionally excluded — it is deprecated.
     */
    private array $headers = [
        // Prevent clickjacking — use CSP frame-ancestors as primary control
        'X-Frame-Options' => 'DENY',

        // Prevent MIME type sniffing attacks
        'X-Content-Type-Options' => 'nosniff',

        // Control referrer information sent cross-origin
        'Referrer-Policy' => 'strict-origin-when-cross-origin',

        // Restrict browser feature/API access
        'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), gyroscope=(), magnetometer=(), payment=(), usb=(), interest-cohort=()',

        // Isolate browsing context (required for SharedArrayBuffer)
        'Cross-Origin-Opener-Policy' => 'same-origin',

        // Require CORP headers on cross-origin resources
        'Cross-Origin-Embedder-Policy' => 'require-corp',

        // Prevent cross-origin resource reads
        'Cross-Origin-Resource-Policy' => 'same-origin',
    ];

    /**
     * Environment-specific CSP overrides.
     * Production uses strict nonce-based CSP; local is relaxed for dev tools.
     */
    private array $cspByEnvironment = [
        'production' => null,   // Nonce-based CSP applied dynamically below
        'staging'    => null,   // Same as production
        'local'      => "default-src 'self' 'unsafe-inline' 'unsafe-eval' localhost:* 127.0.0.1:* ws: wss:; img-src 'self' data: https: localhost:* 127.0.0.1:*; font-src 'self' data: localhost:*; connect-src 'self' localhost:* 127.0.0.1:* ws: wss:",
        'testing'    => "default-src 'self'",
    ];

    /**
     * Handle an incoming request — attach security headers to response.
     */
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        $response = $next($request);

        // Remove server fingerprinting headers
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // Apply core security headers
        foreach ($this->headers as $header => $value) {
            $response->headers->set($header, $value);
        }

        // Apply environment-appropriate CSP
        $this->applyContentSecurityPolicy($request, $response);

        // HSTS — only apply on HTTPS connections, never on HTTP
        if ($request->secure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // CSP Reporting endpoint — modern Reporting-Endpoints header
        $response->headers->set(
            'Reporting-Endpoints',
            'csp-endpoint="' . config('app.url') . '/api/csp-report"'
        );

        // API version header for API routes
        if ($request->is('api/*')) {
            $response->headers->set('X-API-Version', config('app.api_version', '1.0'));
        }

        return $response;
    }

    /**
     * Build and apply the Content Security Policy.
     * Uses nonces in production for inline script/style safety.
     * report-uri is deprecated — uses modern report-to directive.
     */
    private function applyContentSecurityPolicy(Request $request, SymfonyResponse $response): void
    {
        $env = app()->environment();

        // Local/testing: use relaxed CSP
        if (isset($this->cspByEnvironment[$env]) && $this->cspByEnvironment[$env] !== null) {
            $response->headers->set('Content-Security-Policy', $this->cspByEnvironment[$env]);
            return;
        }

        // Production/staging: nonce-based strict CSP
        $nonce = base64_encode(random_bytes(16));

        // Share nonce with views so Blade can use it for inline scripts
        app()->instance('csp-nonce', $nonce);

        $directives = [
            "default-src 'self'",
            "script-src 'self' 'nonce-{$nonce}'",
            "style-src 'self' 'nonce-{$nonce}' https://fonts.googleapis.com",
            "img-src 'self' data: https:",
            "font-src 'self' https://fonts.gstatic.com",
            "connect-src 'self'",
            "media-src 'self'",
            "object-src 'none'",
            "frame-ancestors 'none'",        // Replaces X-Frame-Options
            "form-action 'self'",
            "base-uri 'self'",
            "upgrade-insecure-requests",
            "report-to csp-endpoint",        // Modern reporting — replaces deprecated report-uri
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $directives));
    }

    /**
     * Get current headers configuration (useful for testing).
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
