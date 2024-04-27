<?php

declare(strict_types=1);

namespace LG\App\Services\Transaction;

use LG\Domain\Transaction\Transaction;
use LG\Domain\Transaction\TransactionId;
use LG\Domain\Transaction\TransactionServiceInterface;
use LG\Domain\Transaction\TransactionStatus;
use LG\Domain\User\UserId;
use LG\Domain\Wallet\WalletId;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;
use LG\Infrastructure\Persistence\User\UserRepository;
use LG\Shared\Domain\Utils;

final class TransactionService implements TransactionServiceInterface
{
    public function create(Transaction $transaction, TransactionRepository $transactionRepository, UserRepository $userRepository): Transaction
    {
        $sender = $userRepository->search(new UserId($transaction->senderId()->value()));
        $receiver = $userRepository->search(new UserId($transaction->receiverId()->value()));

        if ($sender['user_type'] === 'MERCHANT') {
            throw new \Exception('Merchants only can receive transactions');
        }


        $senderWalletId = new WalletId($sender['wallet_id']);
        $receiverWalletId = new WalletId($receiver['wallet_id']);
        $transactionAmount = $transaction->amount()->value();


        $this->deductFundsFromWallet($senderWalletId, $transactionAmount, $userRepository);
        $this->addFundsToWallet($receiverWalletId, $transactionAmount, $userRepository);

        $transactionId = $transactionRepository->save($transaction);

        $transaction->updateId(new TransactionId($transactionId));
        
        $authorization = Utils::sendRequest('https://run.mocky.io/v3/1f94933c-353c-4ad1-a6a5-a1a5ce2a7abe');
        if($authorization['message'] !== 'Autorizado') {
            ReverseTransaction::reverseTransaction($transaction->id(), $transactionRepository, $userRepository);
        }

        $transaction->updateStatus(new TransactionStatus('PENDING_EMAIL'));

        $transactionRepository->updateStatus($transaction->id(), $transaction->status()->value());

        return $transaction;
    }

    public static function deductFundsFromWallet(WalletId $walletId, float $amount, UserRepository $userRepository): void
    {
        $wallet = $userRepository->findWallet($walletId);
        $currentBalance = $wallet['balance'];

        if ($currentBalance < $amount) {
            throw new \Exception('Insufficient funds');
        }

        $newBalance = $currentBalance - $amount;

        $userRepository->updateWalletBalance($walletId, $newBalance);
    }

    public static function addFundsToWallet(WalletId $walletId, float $amount, UserRepository $userRepository): void
    {
        $wallet = $userRepository->findWallet($walletId);
        $currentBalance = $wallet['balance'];

        $newBalance = $currentBalance + $amount;

        $userRepository->updateWalletBalance($walletId, $newBalance);
    }
}