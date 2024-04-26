<?php

declare(strict_types=1);

namespace LG\Domain\Wallet;

use LG\Domain\Shared\CreatedAt;
use LG\Domain\Shared\UpdatedAt;
use LG\Domain\User\UserId;
use LG\Shared\Domain\Aggregate\AggregateRoot;

final class Wallet extends AggregateRoot
{
    public function __construct(
        private readonly WalletId   $id,
        private WalletBalance       $balance,
        private readonly CreatedAt  $createdAt,
        private UpdatedAt           $updatedAt
    ) {}

    public static function create(
        WalletId      $walletId,
        WalletBalance $walletBalance,
        CreatedAt     $createdAt,
        UpdatedAt     $updatedAt
    ): self {
        $wallet = new Wallet(
            $walletId,
            $walletBalance,
            $createdAt,
            $updatedAt
        );

        return $wallet;
    }

    public function id(): WalletId
    {
        return $this->id;
    }

    public function balance(): WalletBalance
    {
        return $this->balance;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }
}