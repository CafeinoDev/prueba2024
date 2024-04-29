<?php

declare(strict_types=1);

namespace LG\Interfaces\Api;

use LG\App\Services\Transaction\TransactionService;
use LG\App\Services\User\UserService;
use LG\App\Shared\Validator;
use LG\Infrastructure\Persistence\Shared\SqlDatabase;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;
use LG\Infrastructure\Persistence\User\UserRepository;
use LG\Interfaces\App\Router;
use \LG\App\Controllers\User\UserController;
use \LG\App\Controllers\Transactions\TransactionController;

final class RoutesController  {
    public const API_PATH = '/api/v1';

    /**
     * Registro de los endpoints
     *
     * @param Router $router
     * @return void
     */
    public static function registerRoutes(Router $router): void
    {
        // Dependencies
        $database = SqlDatabase::getInstance();
        $userRepository = new UserRepository($database);
        $userService = new UserService();
        $transactionRepository = new TransactionRepository($database);
        $transactionService = new TransactionService();
        $validator = new Validator();

        // Initialize controllers
        $userController = new UserController($userRepository, $userService, $validator);
        $transactionController = new TransactionController($transactionService, $transactionRepository, $userRepository, $validator);

        // API Endpoints
        $router->get (self::API_PATH  .  "/users",     [$userController, 'all']);
        $router->post(self::API_PATH  .  "/user",      [$userController, 'create']);
        $router->get (self::API_PATH  .  "/user/{id}", [$userController, 'view']);

        // Transaction Post
        $router->post(self::API_PATH  .  "/transaction", [$transactionController, 'create']);
    }
}
