<?php

declare(strict_types=1);

const BASE_PATH = __DIR__ . '/../';

use LG\Infrastructure\Persistence\Shared\SqlDatabase;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;
use LG\Infrastructure\Persistence\User\UserRepository;
use LG\Interfaces\Api\RoutesController;
use LG\Interfaces\App\Router;

require BASE_PATH.'vendor/autoload.php';

// Dependencies
$database = SqlDatabase::getInstance();
$userRepository = new UserRepository($database);
$transactionRepository = new TransactionRepository($database);

include 'bootstrap.php';

$router = Router::getRouter();

Bootstrap::run($userRepository, $transactionRepository);
RoutesController::registerRoutes($router, $userRepository, $transactionRepository);

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->route($method, $uri);

exit();
