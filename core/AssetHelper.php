<?php

/**
 * AssetHelper — Generate versioned URLs for static assets.
 *
 * Appends a short file-hash query string to asset URLs so browsers
 * automatically bust their cache when the file content changes.
 *
 * Usage:
 *   echo AssetHelper::url('css/app.css');
 *   echo AssetHelper::css('css/app.css');
 *   echo AssetHelper::js('js/app.js');
 */
class AssetHelper
{
    /** Absolute path to the public/assets directory. */
    private static string $assetDir = '';

    /** Base URL for assets (APP_URL + /assets). Uses Env if available. */
    private static string $baseUrl = '';

    public static function init(): void
    {
        self::$assetDir = realpath(__DIR__ . '/../public/assets') ?: (__DIR__ . '/../public/assets');
        
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $basePath  = $scriptDir === '/' ? '' : $scriptDir;
        
        self::$baseUrl = rtrim(Env::get('APP_URL', $basePath), '/') . '/assets';
    }

    /**
     * Return the versioned URL for an asset relative to public/assets/.
     * e.g.  AssetHelper::url('css/app.css') → /assets/css/app.css?v=a3f1b2c4
     */
    public static function url(string $path): string
    {
        if (self::$assetDir === '') self::init();

        $path    = ltrim($path, '/');
        $absPath = self::$assetDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path);
        $version = file_exists($absPath) ? '?v=' . substr(md5_file($absPath), 0, 8) : '';

        return self::$baseUrl . '/' . $path . $version;
    }

    /**
     * Emit a <link rel="stylesheet"> tag.
     */
    public static function css(string $path, array $attrs = []): string
    {
        $url   = self::url($path);
        $extra = self::buildAttrs($attrs);
        return "<link rel=\"stylesheet\" href=\"{$url}\"{$extra}>";
    }

    /**
     * Emit a <script src="..."> tag.
     * Pass ['defer' => true] or ['type' => 'module'] via $attrs.
     */
    public static function js(string $path, array $attrs = []): string
    {
        $url   = self::url($path);
        $extra = self::buildAttrs($attrs);
        return "<script src=\"{$url}\"{$extra}></script>";
    }

    // ─── Private helpers ─────────────────────────────────────────────────────

    private static function buildAttrs(array $attrs): string
    {
        $parts = [];
        foreach ($attrs as $k => $v) {
            if (is_bool($v) && $v)      $parts[] = $k;               // defer, async, …
            elseif (!is_bool($v))       $parts[] = $k . '="' . htmlspecialchars($v) . '"';
        }
        return $parts ? ' ' . implode(' ', $parts) : '';
    }
}
