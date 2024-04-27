<?php

declare(strict_types=1);

namespace LG\App\Shared;

use \InvalidArgumentException;

class Validator
{
    public function validate(array $data, array $rules): void
    {
        foreach ($rules as $field => $rule) {
            foreach ($rule as $params) {
                $param = null;
                $name = $params;
                if(str_contains($params, ':')) {
                    list($name, $param) = explode(':', $name);
                }

                $methodName = $name;

                if (method_exists($this, $methodName)) {
                    call_user_func([$this, $methodName], $field, $data[$field], $param);
                }
            }
        }
    }

    private function required(string $field, $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException("$field is required", 400);
        }
    }

    private function email(string $field, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("$field is not a valid email", 400);
        }
    }

    private function minLength(string $field, $value, int $minLength): void
    {
        if (strlen($value) < $minLength) {
            throw new InvalidArgumentException("$field must be at least $minLength characters long", 400);
        }
    }

    private function maxLength(string $field, $value, int $maxLength): void
    {
        if (strlen($value) > $maxLength) {
            throw new InvalidArgumentException("$field must be no more than $maxLength characters long", 400);
        }
    }

    private function isNumeric(string $field, int $value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException("$field must be a number", 400);
        }
    }

    private function minAmount(string $field, $value, $minValue): void
    {
        if($value < $minValue) {
            throw new InvalidArgumentException("$field must be a minimum of $minValue", 400);
        }
    }
}
