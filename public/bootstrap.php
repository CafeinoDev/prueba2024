<?php

use LG\App\Event\TransactionCreatedSubscriber;
use LG\Infrastructure\Event\SimpleEventDispatcher;
use LG\Infrastructure\Notification\NotificationService;
use LG\Infrastructure\Persistence\User\UserRepository;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;
use LG\Infrastructure\Notification\EmailNotificationService;

class Bootstrap
{
    public static function run(): void
    {
        $notificationService = new NotificationService(new EmailNotificationService());

        $transactionCreatedSubscriber = new TransactionCreatedSubscriber(
            $notificationService,
            new UserRepository(),
            new TransactionRepository()
        );

        SimpleEventDispatcher::getInstance()->addSubscriber($transactionCreatedSubscriber);
    }
}

Bootstrap::run();
