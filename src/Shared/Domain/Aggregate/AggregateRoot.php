<?php

declare(strict_types=1);

namespace LG\Shared\Domain\Aggregate;

use LG\Shared\Domain\Event\DomainEvent;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    /**
     * @return array
     */
    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    /**
     * @param DomainEvent $domainEvent
     * @return void
     */
    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}