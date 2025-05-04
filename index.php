<?php
// index.php - Updated autoloader
define('BASE_PATH', __DIR__);

// Autoloader for classes with and without namespaces
spl_autoload_register(function ($class) {
    // Convert class name to file path
    // Handle namespaced classes (e.g., Lib\Request)
    $file = BASE_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }

    // Handle non-namespaced classes (e.g., controllers, models)
    $paths = [
        BASE_PATH . '/controllers/' . $class . '.php',
        BASE_PATH . '/models/' . $class . '.php',
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Include Router
require_once BASE_PATH . '/Router.php';

// Routes configuration
$router = new Router();
//todos routes
$router->add('GET', '/todos', 'TodoController', 'index');
$router->add('GET', '/todos/(\d+)', 'TodoController', 'show');
$router->add('GET', '/todos/create', 'TodoController', 'create');
$router->add('POST', '/todos/create', 'TodoController', 'create');
$router->add('GET', '/todos/(\d+)/edit', 'TodoController', 'update');
$router->add('POST', '/todos/(\d+)/edit', 'TodoController', 'update');
$router->add('POST', '/todos/(\d+)/delete', 'TodoController', 'delete');

// Dispatch request
$router->dispatch();
?>