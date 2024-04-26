<?php

declare(strict_types=1);

namespace LG\Domain\User;

use LG\Shared\Domain\ValueObject\StringValueObject;

final class UserType extends StringValueObject {
    private const VALID_TYPES = ['REGULAR', 'MERCHANT'];

    public function __construct(string $value = 'REGULAR')
    {
        $this->validateStatus($value);
        parent::__construct($value);
    }

    private function validateStatus(string $value): void
    {
        if (!in_array($value, self::VALID_TYPES)) {
            throw new \InvalidArgumentException('Invalid user type');
        }
    }
}