<?php

declare(strict_types=1);

namespace LG\Domain\User;

use LG\Domain\Wallet\WalletBalance;

interface UserRepositoryInterface
{
    public function save(User $user, WalletBalance $balance, string $password): int;

    public function update(User $user): User;

    public function search(int $id): ?array;

    public function searchByEmail(string $email): ?User;

    public function searchByDocument(string $document): ?User;
}
