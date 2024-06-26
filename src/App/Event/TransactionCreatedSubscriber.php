<?php

namespace LG\App\Event;

use Exception;
use LG\Domain\Transaction\Event\TransactionCreated;
use LG\Domain\Notification\NotificationServiceInterface;
use LG\Domain\Transaction\TransactionId;
use LG\Domain\Transaction\TransactionRepositoryInterface;
use LG\Domain\User\UserRepositoryInterface;
use LG\Infrastructure\Persistence\Transaction\TransactionRepository;

/**
 * Clase que suscribe eventos de transacciones creadas y gestiona el envío de notificaciones.
 */
class TransactionCreatedSubscriber
{
    private NotificationServiceInterface $notificationService;
    private UserRepositoryInterface      $userRepository;
    private TransactionRepository        $transactionRepository;

    public function __construct(
        NotificationServiceInterface $notificationService,
        UserRepositoryInterface $userRepository,
        TransactionRepositoryInterface $transactionRepository
    )
    {
        $this->notificationService = $notificationService;
        $this->userRepository = $userRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Maneja el evento de transacción creada, envía notificaciones al destinatario
     * y actualiza el estado de la transacción en la base de datos.
     * En caso de error, el estado de la transacción cambia a FAILED_EMAIL
     * para su manejo futuro.
     *
     * @param TransactionCreated $event
     * @return void
     * @throws Exception Si el usuario no existe
     */
    final public function handleTransactionCreated(TransactionCreated $event): void
    {
        $data = $event->eventData();
        $amount = $data['amount'];
        $receiverId = $data['receiver_id'];

        $receiver = $this->userRepository->search($receiverId);

        if ($receiver === null) {
            throw new Exception('Receiver of the transaction not found', 400);
        }

        $date = $data['timestamp']->format('d-m-Y H:i');

        $message = "Ha recibido un pago por el monto de $amount en la fecha $date";

        try {
            $this->notificationService->sendNotification($receiver['email'], $message);
            $this->transactionRepository->updateStatus(new TransactionId($data['transaction_id']), 'COMPLETED');
        } catch (Exception $exception) {
            $this->transactionRepository->updateStatus(new TransactionId($data['transaction_id']), 'FAILED_EMAIL');
            throw new Exception($exception->getMessage(), '503');
        }
    }
}