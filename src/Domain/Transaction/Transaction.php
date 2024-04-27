<?php

declare(strict_types=1);

namespace LG\Domain\Transaction;

use LG\Domain\Shared\CreatedAt;
use LG\Domain\Shared\UpdatedAt;
use LG\Domain\User\UserId;

/**
 * Entidad de una transacción
 */
final class Transaction
{
    public function __construct(
        private TransactionId $id,
        private readonly UserId $senderId,
        private readonly UserId $receiverId,
        private readonly TransactionAmount $amount,
        private TransactionStatus $status,
        private readonly CreatedAt $createdAt,
        private UpdatedAt $updatedAt
    ) {}

    public static function create(
        TransactionId $id,
        UserId $senderId,
        UserId $receiverId,
        TransactionAmount $amount,
        TransactionStatus $status,
        CreatedAt $createdAt,
        UpdatedAt $updatedAt
    ): self {
        $transaction = new self($id, $senderId, $receiverId, $amount, $status, $createdAt, $updatedAt);

        return $transaction;
    }

    public function id(): TransactionId
    {
        return $this->id;
    }

    public function senderId(): UserId
    {
        return $this->senderId;
    }

    public function receiverId(): UserId
    {
        return $this->receiverId;
    }

    public function amount(): TransactionAmount
    {
        return $this->amount;
    }

    public function status(): TransactionStatus
    {
        return $this->status;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function updateId(TransactionId $newId): void
    {
        $this->id = $newId;
    }

    public function updateStatus(TransactionStatus $newStatus): void
    {
        $this->status = $newStatus;
    }
}