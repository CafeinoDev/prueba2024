<?php

declare(strict_types=1);

namespace LG\Domain\Wallet;

use LG\Domain\Shared\CreatedAt;
use LG\Domain\Shared\UpdatedAt;
use LG\Domain\User\UserId;

final class Wallet
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

    public function addFunds(float $amount) {
        $this->balance =  new WalletBalance($this->balance->value() + $amount);
        // TODO: Update with new balance
    }

    public function deductFunds(float $amount) {
        $this->balance =  new WalletBalance($this->balance->value() - $amount);
        // TODO: Update with new balance
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