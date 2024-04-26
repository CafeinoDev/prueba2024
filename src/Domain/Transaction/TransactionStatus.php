<?php

declare(strict_types=1);

namespace LG\Domain\Transaction;

use LG\Shared\Domain\ValueObject\StringValueObject;

final class TransactionStatus extends StringValueObject {
    private const VALID_STATUSES = ['PENDING', 'COMPLETED', 'DENIED', 'PENDING_EMAIL'];

    public function __construct(string $value)
    {
        $this->validateStatus($value);
        parent::__construct($value);
    }

    private function validateStatus(string $value): void
    {
        if (!in_array($value, self::VALID_STATUSES)) {
            throw new \InvalidArgumentException('Invalid transaction status');
        }
    }
}