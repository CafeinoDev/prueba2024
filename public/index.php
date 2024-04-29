<?php

declare(strict_types=1);

const BASE_PATH = __DIR__ . '/../';

use LG\App\Controllers\Transactions\TransactionController;
use LG\App\Controllers\User\UserController;
use LG\App\Services\Transaction\TransactionService;
use LG\App\Services\User\UserService;
use LG\App\Shared\Validator;
use LG\Infrastructure\Persistence\Shared\SqlDatabase;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;
use LG\Infrastructure\Persistence\User\UserRepository;
use LG\Interfaces\Api\RoutesController;
use LG\Interfaces\App\Router;

require BASE_PATH.'vendor/autoload.php';

// Dependencies
$database = SqlDatabase::getInstance();
$validator = new Validator();

$userRepository = new UserRepository($database);
$transactionRepository = new TransactionRepository($database);

$userService = new UserService();
$transactionService = new TransactionService();

//Controllers
$userController = new UserController($userRepository, $userService, $validator);
$transactionController = new TransactionController($transactionService, $transactionRepository, $userRepository, $validator);

include 'bootstrap.php';

$router = Router::getRouter();

Bootstrap::run($userRepository, $transactionRepository);
RoutesController::registerRoutes($router, $userController, $transactionController);

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->route($method, $uri);

exit();
