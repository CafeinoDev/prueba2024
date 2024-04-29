<?php

declare(strict_types=1);

namespace LG\Infrastructure\Persistence\Shared;

interface DatabaseInterface
{
    public static function getInstance(): DatabaseInterface;

    public function getConnection(): mixed;
}
