<?php

declare(strict_types=1);

namespace LG\App\Controllers\Transactions;

use LG\App\Services\Transaction\TransactionService;
use LG\App\Shared\BaseController;
use LG\App\Shared\Validator;
use LG\Domain\Transaction\Event\TransactionCreated;
use LG\Infrastructure\Event\SimpleEventDispatcher;
use LG\Infrastructure\Persistence\Transaction\TransactionMapper;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;
use LG\Infrastructure\Persistence\User\UserRepository;

final class TransactionController extends BaseController implements TransactionControllerInterface
{
    protected readonly TransactionRepository   $transactionRepository;
    protected readonly UserRepository          $userRepository;
    protected readonly TransactionService      $transactionService;
    protected readonly ?array                  $data;
    protected readonly Validator               $validator;
    public ?array                              $params;

    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository();
        $this->data                  = $this->request();
        $this->validator             = new Validator();
        $this->transactionService    = new TransactionService();
        $this->userRepository       = new UserRepository();
    }

    public function create(): void
    {
        try {
            $this->validator->validate(
                $this->data,
                [
                    'senderId'  => ['required', 'isNumeric'],
                    'receiverId'=> ['required', 'isNumeric'],
                    'amount'    => ['required', 'isNumeric', 'minAmount:1']
                ]
            );

            $transaction = $this->transactionService->create(
                TransactionMapper::mapTransaction($this->data),
                $this->transactionRepository,
                $this->userRepository
            );

            $event = new TransactionCreated($transaction);
            SimpleEventDispatcher::getInstance()->dispatch($event);

            $this->jsonResponse([
                "message" => 'Transaction created successfully',
            ]);
        } catch (\Exception $exception) {
            $this->jsonResponse([
                'message' => 'Error during the transaction: ' . $exception->getMessage()
            ], $exception->getCode());
        }
    }
}