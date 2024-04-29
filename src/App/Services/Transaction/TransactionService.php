<?php

declare(strict_types=1);

namespace LG\App\Services\Transaction;

use LG\Domain\Transaction\Transaction;
use LG\Domain\Transaction\TransactionId;
use LG\Domain\Transaction\TransactionStatus;
use LG\Domain\User\UserId;
use LG\Domain\Wallet\WalletId;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;
use LG\Infrastructure\Persistence\User\UserRepository;
use LG\Shared\Domain\Utils;

/**
 * Esta clase es responsable de gestionar las operaciones relacionadas con las transacciones.
 * Esto incluye la creación de nuevas transacciones y operaciones relacionadas con la gestión de fondos.
 */
final class TransactionService implements TransactionServiceInterface
{
    public function create(Transaction $transaction, TransactionRepository $transactionRepository, UserRepository $userRepository): Transaction
    {
        /**
         * Un usuario no puede hacer una transacción a su misma cuenta
         */
        if($transaction->senderId()->value() == $transaction->receiverId()->value())
            throw new \Exception('Sender and receiver must be two different users', 400);

        $sender = $userRepository->search(new UserId($transaction->senderId()->value()));
        $receiver = $userRepository->search(new UserId($transaction->receiverId()->value()));

        /**
         * Usuarios con rol de comerciante no pueden realizar transacciones
         */
        if ($sender['user_type'] === 'MERCHANT') {
            throw new \Exception('Merchants only can receive transactions');
        }

        $senderWalletId = new WalletId($sender['wallet_id']);
        $receiverWalletId = new WalletId($receiver['wallet_id']);
        $transactionAmount = $transaction->amount()->value();

        /**
         * Realizamos la transacción validando que el sender tenga
         * el monto suficiente.
         */
        self::deductFundsFromWallet($senderWalletId, $transactionAmount, $userRepository);
        self::addFundsToWallet($receiverWalletId, $transactionAmount, $userRepository);

        /**
         * Persistimos la transacción
         */
        $transactionId = $transactionRepository->save($transaction);

        $transaction->updateId(new TransactionId($transactionId));

        /**
         * Validamos la transacción con una aplicación externa.
         */
        $authorization = Utils::sendRequest('https://run.mocky.io/v3/1f94933c-353c-4ad1-a6a5-a1a5ce2a7abe');
        if($authorization['message'] && $authorization['message'] !== 'Autorizado') {
            /**
             * Revertimos la transacción
             */
            ReverseTransaction::reverseTransaction($transaction->id(), $transactionRepository, $userRepository);
        }

        $transaction->updateStatus(new TransactionStatus('PENDING_EMAIL'));

        $transactionRepository->updateStatus($transaction->id(), $transaction->status()->value());

        return $transaction;
    }

    /**
     * Deduce la cantidad enviada de la billetera del usuario
     *
     * @param WalletId $walletId
     * @param float $amount
     * @param UserRepository $userRepository
     * @return void
     * @throws \Exception Si el usuario no tiene fondos suficientes para enviar
     */
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

    /**
     * Añade los fondos a la billetera del usuario
     *
     * @param WalletId $walletId
     * @param float $amount
     * @param UserRepository $userRepository
     * @return void
     */
    public static function addFundsToWallet(WalletId $walletId, float $amount, UserRepository $userRepository): void
    {
        $wallet = $userRepository->findWallet($walletId);
        $currentBalance = $wallet['balance'];

        $newBalance = $currentBalance + $amount;

        $userRepository->updateWalletBalance($walletId, $newBalance);
    }
}