<?php

/**
 * Router — Lightweight request router.
 *
 * Supports GET and POST methods with dynamic route parameters.
 * Dynamic segments use {name} syntax, e.g. /users/{id}.
 */
class Router
{
    private array $routes = [];

    /** Register a GET route. */
    public function get(string $path, callable|array $handler): void
    {
        $this->routes['GET'][] = ['path' => $path, 'handler' => $handler];
    }

    /** Register a POST route. */
    public function post(string $path, callable|array $handler): void
    {
        $this->routes['POST'][] = ['path' => $path, 'handler' => $handler];
    }

    /** Register a route for any HTTP method. */
    public function any(string $path, callable|array $handler): void
    {
        foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method) {
            $this->routes[$method][] = ['path' => $path, 'handler' => $handler];
        }
    }

    /** Register a middleware that runs before every dispatch. */
    private array $middlewares = [];

    public function use(callable $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Dispatch the current request to a matching route handler.
     *
     * @param string $method  HTTP method (GET, POST, …)
     * @param string $uri     Request URI path (without query string)
     */
    public function dispatch(string $method, string $uri): void
    {
        // Run global middlewares first
        foreach ($this->middlewares as $mw) {
            $result = $mw($method, $uri);
            if ($result === false) return; // middleware halted the request
        }

        $method = strtoupper($method);

        if (!isset($this->routes[$method])) {
            http_response_code(405);
            echo 'Method Not Allowed';
            return;
        }

        foreach ($this->routes[$method] as $route) {
            // Convert {param} → named regex group
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                // Collect only named captures
                $params = array_filter($matches, fn($k) => !is_int($k), ARRAY_FILTER_USE_KEY);
                
                $handler = $route['handler'];
                
                try {
                    if (is_array($handler) && is_string($handler[0])) {
                        $handler[0] = new $handler[0]();
                    }
                    call_user_func($handler, $params);
                } catch (\Throwable $e) {
                    http_response_code(500);
                    View::render('errors/500', ['error' => $e->getMessage()], 'main');
                }

                return;
            }
        }

        http_response_code(404);
        View::render('errors/404', [], 'main');
    }
}
