<?php

/**
 * Middleware — Collection of built-in middleware callables.
 *
 * Each middleware receives ($method, $uri) and should return true to
 * continue, or false to halt the request pipeline.
 */
class Middleware
{
    /**
     * Setup Guard — Redirects all requests to /setup/* if APP_SETUP != 'complete'.
     *
     * @param string $envPath  Absolute path to the .env file.
     */
    public static function setupGuard(string $envPath): callable
    {
        return function (string $method, string $uri) use ($envPath): bool {
            $isSetupRoute = str_starts_with($uri, '/setup');
            $isSetupDone  = file_exists($envPath) && Env::get('APP_SETUP') === 'complete';

            if (!$isSetupDone && !$isSetupRoute) {
                header('Location: /setup');
                exit;
            }

            if ($isSetupDone && $isSetupRoute && $uri !== '/setup/complete') {
                header('Location: /');
                exit;
            }

            return true;
        };
    }

    /**
     * CSRF Protection — Validates _csrf_token on POST requests.
     * Token is stored in session and rotated each request.
     */
    public static function csrfProtection(): callable
    {
        return function (string $method, string $uri): bool {
            if (session_status() === PHP_SESSION_NONE) session_start();

            if ($method === 'POST') {
                $token    = $_POST['_csrf_token'] ?? '';
                $expected = $_SESSION['_csrf_token'] ?? null;

                if (!$expected || !hash_equals($expected, $token)) {
                    http_response_code(403);
                    http_response_code(403);
                    View::render('errors/403', [], 'main');
                    return false;
                }
            }

            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
            return true;
        };
    }

    /**
     * Auth Guard — Redirects unauthenticated visitors to /login.
     * Apply to protected routes only.
     */
    public static function auth(): callable
    {
        return function (string $method, string $uri): bool {
            if (!Auth::check()) {
                header('Location: /login');
                exit;
            }
            return true;
        };
    }

    /**
     * Guest Guard — Redirects already-authenticated users to /.
     * Apply to login / register pages.
     */
    public static function guest(): callable
    {
        return function (string $method, string $uri): bool {
            if (Auth::check()) {
                header('Location: /dashboard');
                exit;
            }
            return true;
        };
    }
}
