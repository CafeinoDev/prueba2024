<?php

declare(strict_types=1);

namespace LG\Domain\Transaction;

use LG\Domain\Shared\CreatedAt;
use LG\Domain\Shared\UpdatedAt;
use LG\Domain\User\UserId;
use LG\Shared\Domain\Aggregate\AggregateRoot;

final class Transaction extends AggregateRoot
{
    public function __construct(
        private readonly TransactionId     $id,
        private readonly UserId            $senderId,
        private readonly UserId            $receiverId,
        private readonly TransactionAmount $amount,
        private TransactionStatus          $status,
        private readonly CreatedAt         $createdAt,
        private UpdatedAt                  $updatedAt
    ) {}

    public static function create(
        TransactionId     $id,
        UserId            $senderId,
        UserId            $receiverId,
        TransactionAmount $amount,
        TransactionStatus $status,
        CreatedAt         $createdAt,
        UpdatedAt         $updatedAt
    ): self {
        $transaction = new self(
            $id,
            $senderId,
            $receiverId,
            $amount,
            $status,
            $createdAt,
            $updatedAt
        );

// TODO: Created Domain Event, Dispatch Email
//        $transaction->record();

        return $transaction;
    }



    public function updateStatus(TransactionStatus $newStatus): void
    {
        $this->status = $newStatus;
    }
}