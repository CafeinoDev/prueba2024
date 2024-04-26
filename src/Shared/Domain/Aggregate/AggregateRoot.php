<?php

declare(strict_types=1);

namespace LG\Shared\Domain\Aggregate;

use LG\Domain\Shared\UpdatedAt;
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

    /**
     * @param UpdatedAt $newUpdatedAt
     * @return void
     */
    final public function refreshUpdatedAt(UpdatedAt $newUpdatedAt): void
    {
        $this->updatedAt = $newUpdatedAt;
    }
}