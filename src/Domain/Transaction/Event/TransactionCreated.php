<?php

declare(strict_types=1);

namespace LG\Domain\Transaction\Event;

use LG\Domain\Shared\Event\DomainEvent;
use LG\Domain\Transaction\Transaction;
use LG\Shared\Domain\Utils;

/**
 * Evento que representa la creación de una transacción.
 */
class TransactionCreated implements DomainEvent
{
    private Transaction        $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;

    }

    public function eventId(): string
    {
        return (string)$this->transaction->id()->value();
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return Utils::stringToDate($this->transaction->createdAt()->value());
    }

    public function eventName(): string
    {
        return 'TransactionCreated';
    }

    public function eventData(): array
    {
        return [
            'transaction_id' => $this->eventId(),
            'amount' => $this->transaction->amount()->value(),
            'timestamp' => $this->occurredOn(),
            'receiver_id' => $this->transaction->receiverId()
        ];
    }
}
