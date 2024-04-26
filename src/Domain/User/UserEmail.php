<?php

declare(strict_types=1);

namespace LG\Domain\User;

use LG\Shared\Domain\ValueObject\StringValueObject;

final class UserEmail extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->validateEmailFormat($value);
        parent::__construct($value);
    }

    private function validateEmailFormat(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format');
        }
    }
}