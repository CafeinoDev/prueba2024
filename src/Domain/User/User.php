<?php

declare(strict_types=1);

namespace LG\Domain\User;

use LG\Domain\Shared\CreatedAt;
use LG\Domain\Shared\UpdatedAt;
use LG\Shared\Domain\Aggregate\AggregateRoot;

final class User extends AggregateRoot
{
    public function __construct(
        private readonly UserId         $id,
        private readonly UserFullName   $fullName,
        private readonly UserDocumentId $documentId,
        private readonly UserEmail      $email,
        private UserBalance             $balance,
        private readonly CreatedAt      $createdAt,
        private UpdatedAt               $updatedAt,
    ) {}

    public static function create(
        UserId         $id,
        UserFullName   $fullName,
        UserDocumentId $documentId,
        UserEmail      $email,
        UserBalance    $balance,
        CreatedAt      $createdAt,
        UpdatedAt      $updatedAt,
    ): self {
        return new self(
            $id,
            $fullName,
            $documentId,
            $email,
            $balance,
            $createdAt,
            $updatedAt
        );
    }

    public function updateBalance(UserBalance $newBalance): void
    {
        $this->balance = $newBalance;
    }

    public function refreshUpdatedAt(UpdatedAt $newUpdatedAt): void
    {
        $this->updatedAt = $newUpdatedAt;
    }
}
