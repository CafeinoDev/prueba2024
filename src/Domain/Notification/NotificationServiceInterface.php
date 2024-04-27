<?php

namespace LG\Domain\Notification;

interface NotificationServiceInterface
{
    public function sendNotification(string $recipient, string $message): void;
}