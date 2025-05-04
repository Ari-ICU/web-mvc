<?php
class Router {
    private $routes = [];

    public function add($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match("#^{$route['path']}$#", $uri, $matches)) {
                $controller = new $route['controller'](); // Line 20: This is where the error occurs
                $action = $route['action'];
                array_shift($matches);
                return call_user_func_array([$controller, $action], $matches);
            }
        }
        http_response_code(404);
        echo '404 Not Found';
    }
}
?>