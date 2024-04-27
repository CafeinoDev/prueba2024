<?php

declare(strict_types=1);

namespace LG\Infrastructure\Persistence\Transaction;

use LG\Domain\Transaction\Transaction;
use LG\Domain\Transaction\TransactionId;
use LG\Domain\Transaction\TransactionRepositoryInterface;
use LG\Infrastructure\Persistence\Shared\Database;
use LG\Shared\Domain\Utils;

class TransactionRepository implements TransactionRepositoryInterface
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function save(Transaction $transaction): ?int
    {
        $timestamp = Utils::newDate();

        $stmt = $this->pdo->prepare('INSERT INTO transactions (sender_id, receiver_id, amount, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');
        try {
            $stmt->execute([$transaction->senderId()->value(), $transaction->receiverId()->value(), $transaction->amount()->value(), $transaction->status()->value(), $timestamp, $timestamp,]);
        }catch (\Exception $exception) {
            throw new \Exception('Error creating the transaction. ' . $exception->getMessage());
        }

        $transactionId = $this->pdo->lastInsertId();

        return (int)$transactionId;
    }

    public function findById(TransactionId $transactionId): ?Transaction
    {
        $stmt = $this->pdo->prepare('SELECT * FROM transactions WHERE id = :id');

        $stmt->execute([
            'id' => $transactionId->value()
        ]);

        $transaction = $stmt->fetch(\PDO::FETCH_ASSOC);

        return TransactionMapper::mapTransactionDb($transaction) ?? null;
    }

    public function updateStatus(TransactionId $transactionId, string $newStatus): void
    {
        $stmt = $this->pdo->prepare('UPDATE transactions SET status = ? WHERE id = ?');

        $stmt->execute([
            $newStatus,
            $transactionId->value()
        ]);
    }

    public function cancelTransaction(Transaction $transaction, string $status): void
    {
        // TODO: Implement cancelTransaction() method.
    }
}