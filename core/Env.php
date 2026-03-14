<?php

/**
 * Env — Simple .env file parser and loader.
 *
 * Reads key=value pairs from a .env file and populates
 * $_ENV, $_SERVER, and putenv() for the current request.
 */
class Env
{
    private static bool $loaded = false;
    private static array $appliedKeys = [];

    /**
     * Load a .env file. Safe to call multiple times — only loads once.
     *
     * @param string $path  Absolute path to the .env file.
     */
    public static function load(string $path): void
    {
        if (self::$loaded) return;

        if (!file_exists($path)) return;

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) continue;

            // Split on first '=' only
            $eqPos = strpos($line, '=');
            if ($eqPos === false) continue;

            $key   = trim(substr($line, 0, $eqPos));
            $value = trim(substr($line, $eqPos + 1));

            // Strip surrounding quotes
            if (
                (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                (str_starts_with($value, "'") && str_ends_with($value, "'"))
            ) {
                $value = substr($value, 1, -1);
            }

            // Resolve boolean-like values
            $lower = strtolower($value);
            if ($lower === 'true')  $value = true;
            elseif ($lower === 'false') $value = false;
            elseif ($lower === 'null')  $value = null;
            elseif (is_numeric($value)) $value = $value + 0; // cast to int/float

            if (!array_key_exists($key, $_ENV) || in_array($key, self::$appliedKeys)) {
                $_ENV[$key]    = $value;
                $_SERVER[$key] = $value;
                if (is_string($value) || is_numeric($value)) {
                    putenv("$key=$value");
                }
                if (!in_array($key, self::$appliedKeys)) {
                    self::$appliedKeys[] = $key;
                }
            }
        }

        self::$loaded = true;
    }

    /**
     * Force a reload of the .env file (useful after writing config during setup).
     *
     * @param string $path  Absolute path to the .env file.
     */
    public static function reload(string $path): void
    {
        self::$loaded = false;
        self::load($path);
    }

    /**
     * Get an environment value, with an optional default.
     *
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }

    /**
     * Write key-value pairs to the .env file.
     * Creates the file if it does not exist.
     *
     * @param string $path        Absolute path to the .env file.
     * @param array  $values      Associative array of key => value.
     */
    public static function write(string $path, array $values): void
    {
        $lines = [];

        // Preserve existing lines with comments
        if (file_exists($path)) {
            $existing = file($path, FILE_IGNORE_NEW_LINES);
            $written  = [];

            foreach ($existing as $line) {
                $trimmed = trim($line);
                if ($trimmed === '' || str_starts_with($trimmed, '#')) {
                    $lines[] = $line;
                    continue;
                }

                $eqPos = strpos($trimmed, '=');
                if ($eqPos === false) { $lines[] = $line; continue; }

                $key = trim(substr($trimmed, 0, $eqPos));
                if (array_key_exists($key, $values)) {
                    $val     = self::formatValue($values[$key]);
                    $lines[] = "$key=$val";
                    $written[$key] = true;
                } else {
                    $lines[] = $line;
                }
            }

            // Append new keys that were not in the existing file
            foreach ($values as $k => $v) {
                if (!isset($written[$k])) {
                    $lines[] = "$k=" . self::formatValue($v);
                }
            }
        } else {
            foreach ($values as $k => $v) {
                $lines[] = "$k=" . self::formatValue($v);
            }
        }

        file_put_contents($path, implode(PHP_EOL, $lines) . PHP_EOL);
        self::reload($path);
    }

    private static function formatValue(mixed $value): string
    {
        if (is_bool($value)) return $value ? 'true' : 'false';
        if (is_null($value)) return 'null';

        $str = (string) $value;
        // Quote if value contains spaces or special chars
        if (preg_match('/\s|[#"\'\\\\]/', $str)) {
            return '"' . addslashes($str) . '"';
        }
        return $str;
    }
}
