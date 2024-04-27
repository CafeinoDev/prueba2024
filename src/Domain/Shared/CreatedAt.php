<?php

declare(strict_types=1);

namespace LG\Domain\Shared;

use LG\Shared\Domain\Utils;
use LG\Shared\Domain\ValueObject\StringValueObject;

final class CreatedAt extends StringValueObject {
    /**
     * Devuelva un DateTime de la fecha de creación
     *
     * @return \DateTimeImmutable
     */
    public function date()
    {
        return Utils::stringToDate($this->value);
    }
}