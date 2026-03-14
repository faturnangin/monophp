<?php

/**
 * View — Renders pages with layout support and HTMX partial detection.
 */
class View
{
    public static function render(string $page, array $data = [], string $layout = 'main'): void
    {
        extract($data);

        $pageFile   = __DIR__ . '/../app/pages/' . $page . '.php';
        $layoutFile = __DIR__ . '/../app/layouts/' . $layout . '.php';

        if (!file_exists($pageFile)) {
            http_response_code(404);
            echo '<h1>Page not found: ' . htmlspecialchars($page) . '</h1>';
            return;
        }

        ob_start();
        require $pageFile;
        $content = ob_get_clean();

        $content = ComponentParser::parse($content);

        // Detect HTMX partial request or missing layout
        if (isset($_SERVER['HTTP_HX_REQUEST']) || !file_exists($layoutFile)) {
            echo $content;
        } else {
            require $layoutFile;
        }
    }
}