<?php

declare(strict_types=1);

namespace LG\Infrastructure\Persistence\Transaction;

use LG\Domain\Transaction\Transaction;
use LG\Domain\Transaction\TransactionId;
use LG\Domain\Transaction\TransactionRepositoryInterface;
use LG\Infrastructure\Persistence\Shared\SqlDatabase;
use LG\Infrastructure\Persistence\Shared\DatabaseInterface;
use LG\Shared\Domain\Utils;

class TransactionRepository implements TransactionRepositoryInterface
{
    private mixed $con;

    public function __construct(DatabaseInterface $database)
    {
        $this->con = $database->getConnection();
    }

    public function save(Transaction $transaction): ?int
    {
        $timestamp = Utils::newDate();

        $stmt = $this->con->prepare('INSERT INTO transactions (sender_id, receiver_id, amount, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');

        try {
            $stmt->execute([$transaction->senderId()->value(), $transaction->receiverId()->value(), $transaction->amount()->value(), $transaction->status()->value(), $timestamp, $timestamp,]);
        } catch (\Exception $exception) {
            throw new \Exception('Error creating the transaction: ' . $exception->getMessage());
        }

        $transactionId = $this->con->lastInsertId();

        return (int)$transactionId;
    }

    public function findById(TransactionId $transactionId): ?Transaction
    {
        $stmt = $this->con->prepare('SELECT * FROM transactions WHERE id = :id');

        try {
            $stmt->execute([
                'id' => $transactionId->value()
            ]);

            $transaction = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception('Error searching: ' . $e->getMessage(), 500);
        }

        return TransactionMapper::mapTransactionDb($transaction) ?? null;
    }

    public function updateStatus(TransactionId $transactionId, string $newStatus): void
    {
        $stmt = $this->con->prepare('UPDATE transactions SET status = ? WHERE id = ?');

        try {
            $stmt->execute([
                $newStatus,
                $transactionId->value()
            ]);
        } catch (\PDOException $e) {
            throw new \Exception('Error updating the status: ' . $e->getMessage(), 500);
        }
    }
}