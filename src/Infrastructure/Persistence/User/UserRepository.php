<?php

namespace LG\Infrastructure\Persistence\User;

use LG\Domain\Wallet\Wallet;
use LG\Domain\Wallet\WalletBalance;
use LG\Shared\Domain\Utils;
use LG\Domain\User\{User, UserDocument, UserEmail, UserFullName, UserId, UserRepositoryInterface, UserType};

use LG\Domain\Shared\{UpdatedAt, CreatedAt};
use LG\Domain\Wallet\WalletId;

use LG\Infrastructure\Persistence\Shared\Database;

class UserRepository implements UserRepositoryInterface
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
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

    final public function save(User $user, WalletBalance $balance, string $password): int
    {
        $timestamp = Utils::newDate();

        $walletId = $this->createWallet($balance);

        $stmt = $this->pdo->prepare('INSERT INTO users (full_name, password, email, document, wallet_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)');
        try{
            $stmt->execute([
                $user->fullName()->value(),
                $password,
                $user->email()->value(),
                $user->document()->value(),
                $walletId,
                $timestamp,
                $timestamp,
            ]);

            $userId = $this->pdo->lastInsertId();

            if (!$userId) {
                throw new \Exception('Failed to create user', 500);
            }

            return $userId;
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

    final public function search(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute([
            'id' => $id
        ]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user ?? null;
    }


    final public function searchByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([
            'email' => $email
        ]);

        $user = $stmt->fetch();

        return $user ? UserMapper::mapUser($user) : null;
    }

    final public function searchByDocument(string $document): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE document = :document');
        $stmt->execute([
            'document' => $document
        ]);

        $user = $stmt->fetch();

        return $user ? UserMapper::mapUser($user) : null;
    }
}
