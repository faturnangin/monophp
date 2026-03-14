<?php

/**
 * Database — PDO singleton wrapper.
 *
 * Configuration is read from environment variables loaded by Env::load().
 * Usage:
 *   $pdo = Database::connection();
 *   $row = Database::first("SELECT * FROM users WHERE id = ?", [1]);
 */
class Database
{
    private static ?PDO $instance = null;

    /** Return the shared PDO connection, creating it on first call. */
    public static function connection(): PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $host = Env::get('DB_HOST', '127.0.0.1');
        $port = Env::get('DB_PORT', 3306);
        $db   = Env::get('DB_DATABASE', '');
        $user = Env::get('DB_USERNAME', 'root');
        $pass = Env::get('DB_PASSWORD', '');

        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

        self::$instance = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);

        return self::$instance;
    }

    /** Run a query and return all matching rows. */
    public static function query(string $sql, array $bindings = []): array
    {
        $stmt = self::connection()->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->fetchAll();
    }

    /** Run a query and return the first matching row (or null). */
    public static function first(string $sql, array $bindings = []): ?array
    {
        $stmt = self::connection()->prepare($sql);
        $stmt->execute($bindings);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    /** Execute a statement (UPDATE / DELETE) and return success boolean. */
    public static function execute(string $sql, array $bindings = []): bool
    {
        $stmt = self::connection()->prepare($sql);
        return $stmt->execute($bindings);
    }

    /** Execute an INSERT statement and return the last insert ID. */
    public static function insert(string $sql, array $bindings = []): string|false
    {
        $stmt = self::connection()->prepare($sql);
        $stmt->execute($bindings);
        return self::connection()->lastInsertId();
    }

    /** Begin a new database transaction. */
    public static function beginTransaction(): bool
    {
        return self::connection()->beginTransaction();
    }

    /** Commit the active database transaction. */
    public static function commit(): bool
    {
        return self::connection()->commit();
    }

    /** Rollback the active database transaction. */
    public static function rollback(): bool
    {
        return self::connection()->rollBack();
    }

    /** Execute a raw statement (CREATE TABLE, ALTER, etc.). */
    public static function statement(string $sql): bool
    {
        return self::connection()->exec($sql) !== false;
    }

    /** Disconnect (useful for testing). */
    public static function disconnect(): void
    {
        self::$instance = null;
    }
}
