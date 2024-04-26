<?php

declare(strict_types=1);

namespace LG\App\Services\User;

use LG\App\Shared\BaseController;
use LG\Domain\User\User;
use LG\Domain\User\UserEmail;
use LG\Domain\Wallet\WalletBalance;
use LG\Infrastructure\Persistence\User\UserMapper;
use LG\Infrastructure\Persistence\User\UserRepository;

final class UserService
{

    public function create(array $data, UserRepository $userRepository): string
    {
        if($userRepository->searchByEmail($data['email'])) {
            throw new \InvalidArgumentException('The email already exists.', 409);
        }

        if($userRepository->searchByDocument($data['document'])) {
            throw new \InvalidArgumentException('The document is already in use.', 409);
        }

        $user = $userRepository->save(
            UserMapper::mapUserWithoutId($data),
            new WalletBalance($data['balance']),
            password_hash($data['password'], PASSWORD_DEFAULT)
        );

        return 'Registrar';
    }

    public function view(int $id, UserRepository $userRepository): ?array
    {
        return $userRepository->search($id);
    }
}