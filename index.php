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

//tasks routes
$router->add('GET', '/tasks', 'TaskController', 'index');
$router->add('GET', '/tasks/(\d+)', 'TaskController', 'show');
$router->add('GET', '/tasks/create', 'TaskController', 'create');
$router->add('POST', '/tasks/create', 'TaskController', 'create');
$router->add('GET', '/tasks/(\d+)/edit', 'TaskController', 'update');
$router->add('POST', '/tasks/(\d+)/edit', 'TaskController', 'update');
$router->add('POST', '/tasks/(\d+)/delete', 'TaskController', 'delete');

//tags route
$router->add('GET', '/tags', 'TagController', 'index');
$router->add('GET', '/tags/(\d+)', 'TagController', 'show');
$router->add('GET', '/tags/create', 'TagController', 'create');
$router->add('POST', '/tags/create', 'TagController', 'create');
$router->add('GET', '/tags/(\d+)/edit', 'TagController', 'update');
$router->add('POST', '/tags/(\d+)/edit', 'TagController', 'update');
$router->add('POST', '/tags/(\d+)/delete', 'TagController', 'delete');

// Users Routes
$router->add('GET', '/users', 'UserController', 'index');
$router->add('GET', '/users/(\d+)', 'UserController', 'show');
$router->add('GET', '/users/create', 'UserController', 'create');
$router->add('POST', '/users', 'UserController', 'create');
$router->add('GET', '/users/(\d+)/edit', 'UserController', 'update');
$router->add('POST', '/users/(\d+)/edit', 'UserController', 'update');
$router->add('POST', '/users/(\d+)/delete', 'UserController', 'delete');

// Dispatch request
$router->dispatch();
?>