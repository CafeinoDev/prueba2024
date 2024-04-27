<?php

namespace LG\Infrastructure\Persistence\User;

use LG\Domain\Wallet\WalletBalance;
use LG\Domain\Wallet\WalletId;
use LG\Shared\Domain\Utils;
use LG\Domain\User\{User, UserId, UserRepositoryInterface, UserType};

use LG\Infrastructure\Persistence\Shared\Database;

class UserRepository implements UserRepositoryInterface
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    final public function updateWalletBalance(WalletId $id, float $newBalance): void
    {
        $timestamp = Utils::newDate();

        $stmt = $this->pdo->prepare('UPDATE wallets SET balance = ?, updated_at = ? WHERE id = ?');
        $stmt->execute([
            $newBalance,
            $timestamp,
            $id->value()
        ]);
    }

    final public function findWallet(WalletId $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM wallets WHERE id = :id');
        $stmt->execute([
            'id' => $id->value()
        ]);

        $wallet = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $wallet ?? null;
    }

    final public function createWallet(WalletBalance $balance): int
    {
        $timestamp = Utils::newDate();

        $stmt = $this->pdo->prepare('INSERT INTO wallets (balance, created_at, updated_at) VALUES (?, ?, ?)');
        try {
            $stmt->execute([$balance->value(), $timestamp, $timestamp]);

            $walletId = $this->pdo->lastInsertId();

            if (!$walletId) {
                throw new \Exception('Failed to create wallet', 500);
            }

            return $walletId;
        } catch (\PDOException $e) {
            throw new \Exception('Database error: ' . $e->getMessage(), 500);
        }
    }

    final public function save(User $user, WalletBalance $balance, string $password): void
    {
        $timestamp = Utils::newDate();

        $walletId = $this->createWallet($balance);

        $stmt = $this->pdo->prepare('INSERT INTO users (full_name, password, email, document, wallet_id, user_type, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        try{
            $stmt->execute([
                $user->fullName()->value(),
                $password,
                $user->email()->value(),
                $user->document()->value(),
                $walletId,
                $user->userType()->value(),
                $timestamp,
                $timestamp,
            ]);

            $userId = $this->pdo->lastInsertId();

            if (!$userId) {
                throw new \Exception('Failed to create user', 500);
            }
        } catch (\PDOException $e) {
            throw new \Exception('Database error: ' . $e->getMessage(), 500);
        }
    }

    final public function update(User $user): User
    {
        $timestamp = Utils::newDate();

        $stmt = $this->pdo->prepare('UPDATE users SET full_name = ?, email = ?, document = ?, updated_at = ? WHERE id = ?');
        $stmt->execute([
            $user->fullName()->value(),
            $user->email()->value(),
            $user->document()->value(),
            $timestamp,
            $user->id()->value(),
        ]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return UserMapper::mapUser($user);
    }

    final public function search(UserId $userId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, full_name, document, email, user_type, created_at, updated_at FROM users WHERE id = :id');
        $stmt->execute([
            'id' => $userId->value()
        ]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(!$user)
            throw new \Exception('The user doesnt exists');

        return $user ?? null;
    }

    final public function searchAll(): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, full_name, document, email, user_type, created_at, updated_at FROM users');
        $stmt->execute();

        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $users ?? null;
    }


    final public function searchByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare('SELECT id, full_name, document, email, user_type, created_at, updated_at FROM users WHERE email = :email');
        $stmt->execute([
            'email' => $email
        ]);

        $user = $stmt->fetch();


        return $user ? UserMapper::mapUserFromDb($user) : null;
    }

    final public function searchByDocument(string $document): ?User
    {
        $stmt = $this->pdo->prepare('SELECT id, full_name, document, email, user_type, created_at, updated_at FROM users WHERE document = :document');
        $stmt->execute([
            'document' => $document
        ]);

        $user = $stmt->fetch();

        return $user ? UserMapper::mapUserFromDb($user) : null;
    }
}
