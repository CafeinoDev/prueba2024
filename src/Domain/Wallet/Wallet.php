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
        private readonly WalletId   $walletId,
        private WalletBalance       $walletBalance,
        private readonly UserId     $userId,
        private readonly CreatedAt  $createdAt,
        private UpdatedAt           $updatedAt
    ) {}

    public static function create(
        WalletId      $walletId,
        WalletBalance $walletBalance,
        UserId        $userId,
        CreatedAt     $createdAt,
        UpdatedAt     $updatedAt
    ): self {
        $wallet = new Wallet(
            $walletId,
            $walletBalance,
            $userId,
            $createdAt,
            $updatedAt
        );

        return $wallet;
    }
}