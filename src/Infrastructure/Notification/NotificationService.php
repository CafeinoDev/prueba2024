<?php

declare(strict_types=1);

namespace LG\Infrastructure\Notification;

use LG\Domain\Notification\NotificationServiceInterface;

class NotificationService implements NotificationServiceInterface
{
    private NotificationServiceInterface $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    final public function sendNotification(string $recipient, string $message): void
    {
        $this->notificationService->sendNotification($recipient, $message);
    }
}