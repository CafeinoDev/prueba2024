<?php

declare(strict_types=1);

namespace LG\Domain\User;

use LG\Domain\Shared\CreatedAt;
use LG\Domain\Shared\UpdatedAt;
use LG\Domain\Wallet\WalletId;
use LG\Shared\Domain\Aggregate\AggregateRoot;

final class User extends AggregateRoot
{
    public function __construct(
        private readonly UserId       $id,
        private readonly UserFullName $fullName,
        private readonly UserDocument $document,
        private readonly UserEmail    $email,
        private readonly WalletId     $walletId,
        private readonly UserType     $userType,
        private readonly CreatedAt    $createdAt,
        private UpdatedAt             $updatedAt
    ) {}

    public static function create(
        UserId       $id,
        UserFullName $fullName,
        UserDocument $document,
        UserEmail    $email,
        WalletId     $walletId,
        UserType     $userType,
        CreatedAt    $createdAt,
        UpdatedAt    $updatedAt
    ): self {
        return new self(
            $id,
            $fullName,
            $document,
            $email,
            $walletId,
            $userType,
            $createdAt,
            $updatedAt
        );
    }
}
