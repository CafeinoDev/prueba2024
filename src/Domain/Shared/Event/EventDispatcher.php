<?php

declare(strict_types=1);

namespace LG\Domain\Shared\Event;

interface EventDispatcher
{
    public function dispatch(DomainEvent $event): void;
}
