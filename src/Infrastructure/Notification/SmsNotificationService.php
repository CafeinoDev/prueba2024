<?php

declare(strict_types=1);

namespace LG\Infrastructure\Notification;

use LG\Domain\Notification\NotificationServiceInterface;

class SmsNotificationService implements NotificationServiceInterface
{
    private $type = 'sms';

    final public function sendNotification(string $recipient, string $message): void
    {
        // Enviar la notificación por medio de SMS
    }
}
