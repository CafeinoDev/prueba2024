<?php

declare(strict_types=1);

const BASE_PATH = __DIR__ . '/../';

use LG\Interfaces\Api\RoutesController;
use LG\Interfaces\App\Router;

require BASE_PATH.'vendor/autoload.php';

spl_autoload_register(function($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    require \LG\Interfaces\App\Utils::basePath("{$class}.php");
});

include 'bootstrap.php';

$router = Router::getRouter();
RoutesController::registerRoutes($router);

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->route($method, $uri);

exit();
