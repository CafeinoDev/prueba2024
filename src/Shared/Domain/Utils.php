<?php

declare(strict_types=1);

namespace LG\Shared\Domain;

use DateTimeInterface;
use DateTimeImmutable;

class Utils
{
    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }

    public static function newDate(): string
    {
        return self::dateToString(new \DateTimeImmutable());
    }

    public static function stringToDate(string $date): DateTimeImmutable
    {
        return new DateTimeImmutable($date);
    }

    public static function sendRequest(string $url, string $method = 'GET', array $headers = []): array
    {
        $curl = curl_init();

        // Set common options for the request
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
        ];

        curl_setopt_array($curl, $options);

        $responseJson = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new \Exception('cURL error: ' . curl_error($curl));
        }

        curl_close($curl);

        return json_decode($responseJson, true);
    }
}