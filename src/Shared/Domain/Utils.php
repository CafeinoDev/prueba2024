<?php

declare(strict_types=1);

namespace LG\Shared\Domain;

use DateTimeInterface;
use DateTimeImmutable;

class Utils
{
    /**
     * @param DateTimeInterface $date
     * @return string
     */
    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }

    /**
     * @param string $date
     * @return \DateTimeImmutable
     * @throws \Exception
     */
    public static function stringToDate(string $date): DateTimeImmutable
    {
        return new DateTimeImmutable($date);
    }

    /**
     * @param array $values
     * @return string
     * @throws \JsonException
     */
    public static function jsonEncode(array $values): string
    {
        return json_encode($values, JSON_THROW_ON_ERROR);
    }

    /**
     * @param string $json
     * @return array
     * @throws \JsonException
     */
    public static function jsonDecode(string $json): array
    {
        return json_decode($json, true, flags: JSON_THROW_ON_ERROR);
    }
}