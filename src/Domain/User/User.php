<?php

declare(strict_types=1);

namespace LG\Domain\User;

use LG\Domain\Shared\CreatedAt;
use LG\Domain\Shared\UpdatedAt;
use LG\Domain\Wallet\WalletId;

final class User
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
        $user = new self(
            $id,
            $fullName,
            $document,
            $email,
            $walletId,
            $userType,
            $createdAt,
            $updatedAt
        );

        return $user;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function fullName(): UserFullName
    {
        return $this->fullName;
    }

    public function document(): UserDocument
    {
        return $this->document;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function walletId(): WalletId
    {
        return $this->walletId;
    }

    public function userType(): UserType
    {
        return $this->userType;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }
}
