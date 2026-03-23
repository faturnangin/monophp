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
    private static array $instances = [];

    /** Return the shared PDO connection, creating it on first call. */
    public static function connection(string $name = 'default'): PDO
    {
        if (isset(self::$instances[$name])) {
            return self::$instances[$name];
        }

        $prefix = $name === 'default' ? 'DB_' : 'DB_' . strtoupper($name) . '_';

        $host = Env::get($prefix . 'HOST', '127.0.0.1');
        $port = Env::get($prefix . 'PORT', 3306);
        $db   = Env::get($prefix . 'DATABASE', '');
        $user = Env::get($prefix . 'USERNAME', 'root');
        $pass = Env::get($prefix . 'PASSWORD', '');

        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

        self::$instances[$name] = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);

        return self::$instances[$name];
    }

    /** Run a query and return all matching rows. */
    public static function query(string $sql, array $bindings = [], string $conn = 'default'): array
    {
        $stmt = self::connection($conn)->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->fetchAll();
    }

    /** Run a query and return the first matching row (or null). */
    public static function first(string $sql, array $bindings = [], string $conn = 'default'): ?array
    {
        $stmt = self::connection($conn)->prepare($sql);
        $stmt->execute($bindings);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    /** Execute a statement (UPDATE / DELETE) and return success boolean. */
    public static function execute(string $sql, array $bindings = [], string $conn = 'default'): bool
    {
        $stmt = self::connection($conn)->prepare($sql);
        return $stmt->execute($bindings);
    }

    /** Execute an INSERT statement and return the last insert ID. */
    public static function insert(string $sql, array $bindings = [], string $conn = 'default'): string|false
    {
        $stmt = self::connection($conn)->prepare($sql);
        $stmt->execute($bindings);
        return self::connection($conn)->lastInsertId();
    }

    /** Begin a new database transaction. */
    public static function beginTransaction(string $conn = 'default'): bool
    {
        return self::connection($conn)->beginTransaction();
    }

    /** Commit the active database transaction. */
    public static function commit(string $conn = 'default'): bool
    {
        return self::connection($conn)->commit();
    }

    /** Rollback the active database transaction. */
    public static function rollback(string $conn = 'default'): bool
    {
        return self::connection($conn)->rollBack();
    }

    /** Execute a raw statement (CREATE TABLE, ALTER, etc.). */
    public static function statement(string $sql, string $conn = 'default'): bool
    {
        return self::connection($conn)->exec($sql) !== false;
    }

    /** Disconnect (useful for testing). */
    public static function disconnect(?string $name = null): void
    {
        if ($name === null) {
            self::$instances = [];
        } else {
            unset(self::$instances[$name]);
        }
    }
}
