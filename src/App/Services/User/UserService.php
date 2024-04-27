<?php

declare(strict_types=1);

namespace LG\App\Services\User;

use LG\Domain\User\UserId;
use LG\Domain\Wallet\WalletBalance;
use LG\Domain\User\User;
use LG\Infrastructure\Persistence\User\UserRepository;

final class UserService
{
    /**
     * Busca todos los usuarios
     *
     * @param UserRepository $userRepository
     * @return array|null
     */
    public function searchAll(UserRepository $userRepository): ?array
    {
        return $userRepository->searchAll();
    }

    /**
     * Crea un nuevo usuario
     *
     * @param User $user
     * @param UserRepository $userRepository
     * @param float $balance
     * @param string $password
     * @return void
     * @throws \Exception Si el correo o el documento ya existen
     */
    public function create(User $user, UserRepository $userRepository, float $balance, string $password): void
    {
        if($userRepository->searchByEmail($user->email()->value())) {
            throw new \InvalidArgumentException('The email already exists.', 409);
        }

        if($userRepository->searchByDocument($user->document()->value())) {
            throw new \InvalidArgumentException('The document is already in use.', 409);
        }

        $userRepository->save(
            $user,
            new WalletBalance($balance),
            password_hash($password, PASSWORD_DEFAULT)
        );
    }

    /**
     * Devuelve el detalle de un usuario
     *
     * @param UserId $userId
     * @param UserRepository $userRepository
     * @return array|null
     * @throws \Exception Si no se encuentra el usuario
     */
    public function view(UserId $userId, UserRepository $userRepository): ?array
    {
        return $userRepository->search($userId);
    }
}