<?php

use LG\App\Event\TransactionCreatedSubscriber;
use LG\Infrastructure\Event\SimpleEventDispatcher;
use LG\Infrastructure\Notification\NotificationService;
use LG\Infrastructure\Persistence\User\UserRepository;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;
use LG\Infrastructure\Notification\EmailNotificationService;
use LG\Infrastructure\Persistence\Shared\SqlDatabase;

/**
 * Bootstrap de la aplicación.
 */
class Bootstrap
{
    public static function run(): void
    {
        $database = SqlDatabase::getInstance();
        $userRepository = new UserRepository($database);
        $transactionRepository = new TransactionRepository($database);
        $notificationService = new NotificationService(new EmailNotificationService());

        $transactionCreatedSubscriber = new TransactionCreatedSubscriber(
            $notificationService,
            $userRepository,
            $transactionRepository
        );

        SimpleEventDispatcher::getInstance()->addSubscriber($transactionCreatedSubscriber);
    }
}

Bootstrap::run();
