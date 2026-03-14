<?php

/**
 * Auth — Session-based authentication with Remember Me support.
 *
 * Works with a `users` table and a `remember_tokens` table.
 */
class Auth
{
    private const SESSION_KEY    = '_auth_user';
    private const COOKIE_NAME    = 'remember_token';
    private const COOKIE_DAYS    = 30;

    // ─── Core ────────────────────────────────────────────────────────────────

    /**
     * Attempt to authenticate with email + password.
     *
     * @param string $email
     * @param string $password
     * @param bool   $remember  Issue a long-lived remember-me cookie.
     * @return bool
     */
    public static function attempt(string $email, string $password, bool $remember = false): bool
    {
        self::startSession();

        $user = Database::first('SELECT * FROM users WHERE email = ?', [$email]);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        // Strip password from session-stored data
        unset($user['password']);
        $_SESSION[self::SESSION_KEY] = $user;
        session_regenerate_id(true);

        if ($remember) {
            self::issueRememberCookie((int) $user['id']);
        }

        return true;
    }

    /** Check whether the current visitor is authenticated. */
    public static function check(): bool
    {
        self::startSession();

        if (isset($_SESSION[self::SESSION_KEY])) {
            return true;
        }

        // Try remember-me cookie
        $resolved = self::resolveRememberCookie();
        if ($resolved) {
            $_SESSION[self::SESSION_KEY] = $resolved;
            return true;
        }

        return false;
    }

    /** Return the authenticated user array, or null. */
    public static function user(): ?array
    {
        self::startSession();
        return $_SESSION[self::SESSION_KEY] ?? null;
    }

    /** Return the authenticated user's ID, or null. */
    public static function id(): ?int
    {
        return self::user() ? (int) self::user()['id'] : null;
    }

    /**
     * Log the current user out.
     * Destroys the session and invalidates the remember-me cookie/token.
     */
    public static function logout(): void
    {
        self::startSession();

        // Revoke remember token from DB
        if (isset($_COOKIE[self::COOKIE_NAME])) {
            $token = $_COOKIE[self::COOKIE_NAME];
            Database::execute('DELETE FROM remember_tokens WHERE token = ?', [$token]);
            setcookie(self::COOKIE_NAME, '', time() - 3600, '/', '', false, true);
        }

        unset($_SESSION[self::SESSION_KEY]);
        session_destroy();
    }

    // ─── Remember Me ──────────────────────────────────────────────────────────

    private static function issueRememberCookie(int $userId): void
    {
        $token   = bin2hex(random_bytes(40));
        $expires = date('Y-m-d H:i:s', time() + self::COOKIE_DAYS * 86400);

        // Remove any old tokens for this user to prevent unbounded growth
        Database::execute('DELETE FROM remember_tokens WHERE user_id = ?', [$userId]);

        Database::insert(
            'INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, ?)',
            [$userId, $token, $expires]
        );

        setcookie(
            self::COOKIE_NAME,
            $token,
            [
                'expires'  => time() + self::COOKIE_DAYS * 86400,
                'path'     => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
    }

    private static function resolveRememberCookie(): ?array
    {
        if (!isset($_COOKIE[self::COOKIE_NAME])) {
            return null;
        }

        $token = $_COOKIE[self::COOKIE_NAME];

        $row = Database::first(
            'SELECT u.* FROM users u
             JOIN remember_tokens rt ON rt.user_id = u.id
             WHERE rt.token = ? AND rt.expires_at > NOW()',
            [$token]
        );

        if (!$row) {
            // Invalid / expired — clean up cookie
            setcookie(self::COOKIE_NAME, '', time() - 3600, '/', '', false, true);
            return null;
        }

        unset($row['password']);
        return $row;
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
