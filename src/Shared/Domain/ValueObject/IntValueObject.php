<?php

declare(strict_types=1);

namespace LG\Shared\Domain\ValueObject;

abstract class IntValueObject
{
    public function __construct(protected int $value) {}

    final public function value(): int
    {
        return $this->value;
    }
}
