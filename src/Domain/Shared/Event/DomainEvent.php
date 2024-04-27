<?php

declare(strict_types=1);

namespace LG\Domain\Shared\Event;

interface DomainEvent {
    public function eventId(): string;

    public function occurredOn(): \DateTimeImmutable;

    public function eventName(): string;

    public function eventData(): array;
}