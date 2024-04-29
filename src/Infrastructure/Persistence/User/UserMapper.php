<?php

namespace LG\Infrastructure\Persistence\User;

use LG\Domain\Shared\{CreatedAt, UpdatedAt};
use LG\Domain\Wallet\Wallet;
use LG\Domain\Wallet\WalletBalance;
use LG\Shared\Domain\Utils;
use LG\Domain\User\{User, UserDocument, UserEmail, UserFullName, UserId, UserType};

use LG\Domain\Wallet\WalletId;

class UserMapper
{
    public static function mapUserFromDb(array $userData): User
    {
        return new User(
            new UserId($userData['id']),
            new UserFullName($userData['full_name']),
            new UserDocument($userData['document']),
            new UserEmail($userData['email']),
            new WalletId($userData['wallet_id']),
            new UserType($userData['user_type']),
            new CreatedAt($userData['created_at']),
            new UpdatedAt($userData['updated_at'])
        );
    }

    public static function mapUser(array $userData): User
    {
        $timestamp = Utils::newDate();

        return new User(
            null,
            new UserFullName($userData['full_name']),
            new UserDocument($userData['document']),
            new UserEmail($userData['email']),
            null,
            new UserType($userData['user_type']),
            new CreatedAt($timestamp),
            new UpdatedAt($timestamp)
        );
    }

    public static function mapWallet(array $wallet): Wallet
    {
        return new Wallet(
            new WalletId($wallet['id']),
            new WalletBalance($wallet['balance']),
            new CreatedAt($wallet['created_at']),
            new UpdatedAt($wallet['updated_at']),
        );
    }
}
