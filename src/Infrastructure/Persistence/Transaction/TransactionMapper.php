<?php

namespace LG\Infrastructure\Persistence\Transaction;

use LG\Domain\Shared\{CreatedAt, UpdatedAt};
use LG\Domain\Transaction\Transaction;
use LG\Domain\Transaction\TransactionAmount;
use LG\Domain\Transaction\TransactionId;
use LG\Domain\Transaction\TransactionStatus;
use LG\Shared\Domain\Utils;
use LG\Domain\User\{User, UserDocument, UserEmail, UserFullName, UserId, UserType};

use LG\Domain\Wallet\WalletId;

class TransactionMapper
{
    public static function mapTransaction(array $transactionData): Transaction
    {
        return new Transaction(
            new TransactionId(1),
            new UserId($transactionData['senderId']),
            new UserId($transactionData['receiverId']),
            new TransactionAmount($transactionData['amount']),
            new TransactionStatus('PENDING'),
            new CreatedAt(Utils::newDate()),
            new UpdatedAt(Utils::newDate())
        );
    }

    public static function mapTransactionDb(array $transactionData): Transaction
    {
        return new Transaction(
            new TransactionId(1),
            new UserId($transactionData['sender_id']),
            new UserId($transactionData['receiver_id']),
            new TransactionAmount($transactionData['amount']),
            new TransactionStatus($transactionData['status']),
            new CreatedAt($transactionData['updated_at']),
            new UpdatedAt($transactionData['created_at'])
        );
    }
}