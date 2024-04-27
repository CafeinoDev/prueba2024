<?php

declare(strict_types=1);

namespace LG\Interfaces\Api;

use LG\Interfaces\App\Router;

final class RoutesController  {
    public const API_PATH = '/api/v1';

    /**
     * Register the endpoints
     *
     * @param Router $router
     * @return void
     */
    public static function registerRoutes(Router $router): void
    {
        $router->get("/", [\LG\Ping::class, 'ping']);

        // API Endpoints
        $router->get (self::API_PATH  .  "/users",     [\LG\App\Controllers\User\UserController::class, 'all']);
        $router->post(self::API_PATH  .  "/user",      [\LG\App\Controllers\User\UserController::class, 'create']);
        $router->get (self::API_PATH  .  "/user/{id}", [\LG\App\Controllers\User\UserController::class, 'view']);

        // Transaction Post
        $router->post(self::API_PATH  .  "/transaction", [\LG\App\Controllers\Transactions\TransactionController::class, 'create']);
    }
}
