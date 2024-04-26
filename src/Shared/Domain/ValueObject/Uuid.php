<?php

declare(strict_types=1);

namespace LG\Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Stringable;

abstract class Uuid implements Stringable
{
    /**
     * @param string $value
     */
    final public function __construct(protected string $value)
    {
        $this->ensureIsValidUuid($value);
    }

    /**
     * @return self
     */
    final public static function random(): self
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    /**
     * @return string
     */
    final public function value(): string
    {
        return $this->value;
    }

    /**
     * @param Uuid $other
     * @return bool
     */
    final public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @param string $id
     * @return void
     */
    private function ensureIsValidUuid(string $id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new \InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', self::class, $id));
        }
    }
}