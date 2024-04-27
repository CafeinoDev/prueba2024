<?php

declare(strict_types=1);

namespace LG\App\Services\Transaction;

use Exception;
use LG\Domain\Transaction\TransactionId;
use LG\Domain\User\UserId;
use LG\Domain\Wallet\WalletId;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;
use LG\Infrastructure\Persistence\User\UserRepository;

/**
 * Esta clase maneja la reversión de una transacción.
 * Esto implica revertir los fondos de las cuentas
 * y cambiar el estado de la transacción.
 */
final class ReverseTransaction
{
    /**
     * @param TransactionId $transactionId
     * @param TransactionRepository $transactionRepository
     * @param UserRepository $userRepository
     * @return void
     * @throws Exception Si la transacción ya ha sida revertida
     */
    public static function reverseTransaction(TransactionId $transactionId, TransactionRepository $transactionRepository, UserRepository $userRepository): void
    {
        $transaction = $transactionRepository->findById($transactionId);

        if ($transaction->status()->value() === 'REFUNDED') {
            throw new Exception('This transaction has been already reversed', 401);
        }

        $sender = $userRepository->search(new UserId($transaction->senderId()->value()));
        $receiver = $userRepository->search(new UserId($transaction->receiverId()->value()));

        $amount = $transaction->amount()->value();

        TransactionService::addFundsToWallet(new WalletId($sender['wallet_id']), $amount, $userRepository);
        TransactionService::deductFundsFromWallet(new WalletId($receiver['wallet_id']), $amount, $userRepository);

        $transactionRepository->updateStatus($transactionId, 'REFUNDED');

        throw new Exception('Transaction unauthorized and reversed', 400);
    }
}