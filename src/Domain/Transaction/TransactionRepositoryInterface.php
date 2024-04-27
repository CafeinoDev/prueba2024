<?php

declare(strict_types=1);

namespace LG\Domain\Transaction;

interface TransactionRepositoryInterface
{
    public function save(Transaction $transaction): ?int;

    public function updateStatus(TransactionId $transaction, string $status): void;

    public function cancelTransaction(Transaction $transaction, string $status): void;
}