<?php

namespace Alphavel\Framework;

class Router
{
    private array $routes = [];
    private array $staticRoutes = [];
    private array $dynamicRoutes = [];
    private array $rawRoutes = [];

    public function get(string $path, string|array|\Closure $handler): Route
    {
        return $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, string|array|\Closure $handler): Route
    {
        return $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, string|array|\Closure $handler): Route
    {
        return $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, string|array|\Closure $handler): Route
    {
        return $this->addRoute('DELETE', $path, $handler);
    }

    public function patch(string $path, string|array|\Closure $handler): Route
    {
        return $this->addRoute('PATCH', $path, $handler);
    }

    public function any(string $path, string|array|\Closure $handler): Route
    {
        return $this->addRoute('*', $path, $handler);
    }

    /**
     * Register a raw route with zero overhead (bypasses framework stack)
     * 
     * Perfect for:
     * - Health checks
     * - Static responses
     * - High-performance endpoints
     * - Metrics/monitoring
     * 
     * @param string $path Static path only (no parameters)
     * @param string|array|\Closure $handler Response handler
     * @param string $contentType Content-Type header
     * @param string $method HTTP method (default: GET)
     * @return void
     */
    public function raw(
        string $path,
        string|array|\Closure $handler,
        string $contentType = 'text/plain',
        string $method = 'GET'
    ): void {
        $this->rawRoutes[$method][$path] = [
            'handler' => $handler,
            'content_type' => $contentType,
        ];
    }

    private function addRoute(string $method, string $path, string|array|\Closure $handler): Route
    {
        $route = new Route($method, $path, $handler);
        $this->routes[] = $route;

        // Optimization: Separate static and dynamic routes
        if (strpos($path, '{') === false) {
            $this->staticRoutes[$method][$path] = $route;
        } else {
            $this->dynamicRoutes[$method][] = $route;
        }

        return $route;
    }

    public function dispatch(string $uri, string $method): ?array
    {
        // 0. Ultra-fast path for raw routes (returns special marker)
        if (isset($this->rawRoutes[$method][$uri])) {
            return [
                'handler' => '__RAW__',
                'params' => [],
                'raw_config' => $this->rawRoutes[$method][$uri]
            ];
        }

        // 1. Fast lookup for static routes (O(1))
        if (isset($this->staticRoutes[$method][$uri])) {
            return $this->staticRoutes[$method][$uri]->matches($uri, $method);
        }

        // 2. Regex lookup for dynamic routes
        foreach ($this->dynamicRoutes[$method] ?? [] as $route) {
            if ($match = $route->matches($uri, $method)) {
                return $match;
            }
        }

        return null;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getStaticRoutes(): array
    {
        return $this->staticRoutes;
    }

    public function getDynamicRoutes(): array
    {
        return $this->dynamicRoutes;
    }

    public function loadCachedRoutes(array $routes): void
    {
        $this->staticRoutes = $routes['static'] ?? [];
        $this->dynamicRoutes = $routes['dynamic'] ?? [];
        $this->rawRoutes = $routes['raw'] ?? [];
        $this->routes = []; // Clear raw routes to save memory
    }

    public function getRawRoutes(): array
    {
        return $this->rawRoutes;
    }
}
