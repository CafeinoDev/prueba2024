<?php

declare(strict_types=1);

namespace LG\Domain\User;

use LG\Domain\Wallet\WalletBalance;

interface UserRepositoryInterface
{
    public function save(User $user, WalletBalance $balance, string $password): void;

    public function update(User $user): User;

    public function search(UserId $id): ?array;

    public function searchAll(): ?array;

    public function searchByEmail(string $email): ?User;

    public function searchByDocument(string $document): ?User;
}
