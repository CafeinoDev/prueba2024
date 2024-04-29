<?php

declare(strict_types=1);

namespace LG\App\Shared;

use \InvalidArgumentException;

/**
 * Clase encargada de validar datos de acuerdo a reglas específicas.
 */
class Validator
{
    /**
     * Valida las reglas definidas contra el arreglo enviado en la petición
     *
     * @param array $data
     * @param array $rules
     * @return void
     */
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

    /**
     * El campo es requerido
     *
     * @param string $field
     * @param $value
     * @return void
     */
    private function required(string $field, $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException("$field is required", 400);
        }
    }

    /**
     * El valor debe ser un correo
     *
     * @param string $field
     * @param $value
     * @return void
     */
    private function email(string $field, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("$field is not a valid email", 400);
        }
    }

    /**
     * Debe tener un mínimo de caracteres
     *
     * @param string $field
     * @param $value
     * @param int $minLength
     * @return void
     */
    private function minLength(string $field, $value, int $minLength): void
    {
        if (strlen($value) < $minLength) {
            throw new InvalidArgumentException("$field must be at least $minLength characters long", 400);
        }
    }

    /**
     * Debe tener un máximo de caracteres
     *
     * @param string $field
     * @param $value
     * @param int $maxLength
     * @return void
     */
    private function maxLength(string $field, $value, int $maxLength): void
    {
        if (strlen($value) > $maxLength) {
            throw new InvalidArgumentException("$field must be no more than $maxLength characters long", 400);
        }
    }

    /**
     * Debe ser un valor numérico
     *
     * @param string $field
     * @param $value
     * @return void
     */
    private function isNumeric(string $field, $value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException("$field must be a number", 400);
        }
    }

    /**
     * Debe tener un monto mínimo
     *
     * @param string $field
     * @param $value
     * @param $minValue
     * @return void
     */
    private function minAmount(string $field, $value, $minValue): void
    {
        if($value < $minValue) {
            throw new InvalidArgumentException("$field must be a minimum of $minValue", 400);
        }
    }

    /**
     * Debe tener un monto máximo
     *
     * @param string $field
     * @param $value
     * @param $minValue
     * @return void
     */
    private function maxAmount(string $field, $value, $minValue): void
    {
        if($value > $minValue) {
            throw new InvalidArgumentException("$field must be a maximum of $minValue", 400);
        }
    }
}
