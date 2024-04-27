<?php

declare(strict_types=1);

namespace LG\App\Services\Transaction;

use LG\Domain\Transaction\TransactionId;
use LG\Domain\User\UserId;
use LG\Domain\Wallet\WalletId;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;
use LG\Infrastructure\Persistence\User\UserRepository;

final class ReverseTransaction
{

    public static function reverseTransaction(TransactionId $transactionId, TransactionRepository $transactionRepository, UserRepository $userRepository): void
    {
        $transaction = $transactionRepository->findById($transactionId);

        if ($transaction->status()->value() !== 'PENDING') {
            throw new \Exception('This transaction has been already reversed', 401);
        }

        $sender = $userRepository->search(new UserId($transaction->senderId()->value()));
        $receiver = $userRepository->search(new UserId($transaction->receiverId()->value()));

        $amount = $transaction->amount()->value();


        // Reverse the transaction by adding funds back to the sender's wallet and deducting them from the receiver's wallet
        TransactionService::addFundsToWallet(new WalletId($sender['wallet_id']), $amount, $userRepository);
        TransactionService::deductFundsFromWallet(new WalletId($receiver['wallet_id']), $amount, $userRepository);

        $transactionRepository->updateStatus($transactionId, 'UNAUTHORIZED');

        throw new \Exception('Transaction unauthorized and reversed', 400);
    }

}