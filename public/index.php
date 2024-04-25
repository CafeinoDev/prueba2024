<?php

declare(strict_types=1);

require "../core/helpers.php";
require "../core/Router.php";

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH.'vendor/autoload.php';

spl_autoload_register(function($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    require basePath("{$class}.php");
});

$router = Router::getRouter();
require BASE_PATH . "routes/api.php";

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->route($method, $uri);

exit();
