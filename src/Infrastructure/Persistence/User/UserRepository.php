<?php

namespace LG\Infrastructure\Persistence\User;

use LG\Domain\Wallet\WalletBalance;
use LG\Domain\Wallet\WalletId;
use LG\Infrastructure\Persistence\Shared\DatabaseInterface;
use LG\Shared\Domain\Utils;
use LG\Domain\User\{User, UserId, UserRepositoryInterface, UserType};

use LG\Infrastructure\Persistence\Shared\SqlDatabase;

class UserRepository implements UserRepositoryInterface
{
    private mixed $con;

    public function __construct(DatabaseInterface $database)
    {
        $this->con = $database->getConnection();
    }

    final public function updateWalletBalance(WalletId $id, float $newBalance): void
    {
        $timestamp = Utils::newDate();

        $stmt = $this->con->prepare('UPDATE wallets SET balance = ?, updated_at = ? WHERE id = ?');

        try {
            $stmt->execute([
                $newBalance,
                $timestamp,
                $id->value()
            ]);
        } catch (\PDOException $e) {
            throw new \Exception('Database error: ' . $e->getMessage(), 500);
        }
    }

    final public function findWallet(WalletId $id): ?array
    {
        $stmt = $this->con->prepare('SELECT * FROM wallets WHERE id = :id');

        try {
            $stmt->execute([
                'id' => $id->value()
            ]);

            $wallet = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception('Database error: ' . $e->getMessage(), 500);
        }

        return $wallet ?? null;
    }

    final public function createWallet(WalletBalance $balance): int
    {
        $timestamp = Utils::newDate();

        $stmt = $this->con->prepare('INSERT INTO wallets (balance, created_at, updated_at) VALUES (?, ?, ?)');

        try {
            $stmt->execute([$balance->value(), $timestamp, $timestamp]);

            $walletId = $this->con->lastInsertId();

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

        $stmt = $this->con->prepare('INSERT INTO users (full_name, password, email, document, wallet_id, user_type, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        try {
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

            $userId = $this->con->lastInsertId();

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

        $stmt = $this->con->prepare('UPDATE users SET full_name = ?, email = ?, document = ?, updated_at = ? WHERE id = ?');

        try {
            $stmt->execute([
                $user->fullName()->value(),
                $user->email()->value(),
                $user->document()->value(),
                $timestamp,
                $user->id()->value(),
            ]);

            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception('Database error: ' . $e->getMessage(), 500);
        }

        return UserMapper::mapUser($user);
    }

    final public function search(UserId $userId): ?array
    {
        $stmt = $this->con->prepare('SELECT id, full_name, document, email, user_type, created_at, updated_at, wallet_id FROM users WHERE id = :id');

        try {
            $stmt->execute([
                'id' => $userId->value()
            ]);

            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception('Database error: ' . $e->getMessage(), 500);
        }

        if(!$user)
            throw new \Exception('The user doesnt exists');

        return $user ?? null;
    }

    final public function searchAll(): ?array
    {
        $stmt = $this->con->prepare('SELECT id, full_name, document, email, user_type, created_at, updated_at, wallet_id FROM users');

        try {
            $stmt->execute();

            $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception('Database error: ' . $e->getMessage(), 500);
        }

        return $users ?? null;
    }


    final public function searchByEmail(string $email): ?User
    {
        $stmt = $this->con->prepare('SELECT id, full_name, document, email, user_type, created_at, updated_at, wallet_id FROM users WHERE email = :email');

        try {
            $stmt->execute([
                'email' => $email
            ]);

            $user = $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \Exception('Database error: ' . $e->getMessage(), 500);
        }

        return $user ? UserMapper::mapUserFromDb($user) : null;
    }

    final public function searchByDocument(string $document): ?User
    {
        $stmt = $this->con->prepare('SELECT id, full_name, document, email, user_type, created_at, updated_at, wallet_id FROM users WHERE document = :document');

        try {
            $stmt->execute([
                'document' => $document
            ]);

            $user = $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \Exception('Database error: ' . $e->getMessage(), 500);
        }

        return $user ? UserMapper::mapUserFromDb($user) : null;
    }
}
