<?php

declare(strict_types=1);

namespace LG\Domain\Wallet;

interface WalletRepositoryInterface
{
    public function save(Wallet $wallet): WalletId;

    public function update(Wallet $wallet): void;
}