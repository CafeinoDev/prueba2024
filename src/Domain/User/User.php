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
        private readonly UserId         $id,
        private readonly UserFullName   $fullName,
        private readonly UserDocumentId $documentId,
        private readonly UserEmail      $email,
        private WalletId                $walletId,
        private UserType                $userType,
        private readonly CreatedAt      $createdAt,
        private UpdatedAt               $updatedAt
    ) {}

    public static function create(
        UserId         $id,
        UserFullName   $fullName,
        UserDocumentId $documentId,
        UserEmail      $email,
        WalletId       $walletId,
        UserType       $userType,
        CreatedAt      $createdAt,
        UpdatedAt      $updatedAt
    ): self {
        return new self(
            $id,
            $fullName,
            $documentId,
            $email,
            $walletId,
            $userType,
            $createdAt,
            $updatedAt
        );
    }

    public function refreshUpdatedAt(UpdatedAt $newUpdatedAt): void
    {
        $this->updatedAt = $newUpdatedAt;
    }
}
