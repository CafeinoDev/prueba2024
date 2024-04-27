<?php

declare(strict_types=1);

namespace LG\Domain\Shared;

use LG\Shared\Domain\Utils;
use LG\Shared\Domain\ValueObject\StringValueObject;

final class CreatedAt extends StringValueObject {
    public function date()
    {
        return Utils::stringToDate($this->value);
    }
}