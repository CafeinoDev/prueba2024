<?php

declare(strict_types=1);

namespace LG\App\Services\User;

use LG\Domain\User\UserId;
use LG\Domain\Wallet\WalletBalance;
use LG\Domain\User\User;
use LG\Infrastructure\Persistence\User\UserRepository;

final class UserService
{
    public function searchAll(UserRepository $userRepository): ?array
    {
        return $userRepository->searchAll();
    }

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

    public function view(UserId $userId, UserRepository $userRepository): ?array
    {
        return $userRepository->search($userId);
    }
}