<?php

declare(strict_types=1);

namespace LG\Infrastructure\Notification;

use LG\Domain\Notification\NotificationServiceInterface;
use LG\Shared\Domain\Utils;

class EmailNotificationService implements NotificationServiceInterface
{
    private $type = 'email';

    /**
     * Servicio para enviar notificaciòn por email.
     * Consulta una url externa (simulando el servicio).
     *
     * @param string $recipient
     * @param string $message
     * @return void
     * @throws \Exception
     */
    final public function sendNotification(string $recipient, string $message): void
    {
        // Enviar la notificación por medio de email
        $authorization = Utils::sendRequest('https://run.mocky.io/v3/6839223e-cd6c-4615-817a-60e06d2b9c82');

        if (!$authorization) {
            throw new \Exception('Email Service unavailable');
        }
    }
}
