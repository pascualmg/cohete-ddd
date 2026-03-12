<?php

namespace Cohete\DDD\Event;

interface DomainEvent
{
    public function eventName(): string;

    /** @return array<string, mixed> */
    public function payload(): array;

    public function occurredOn(): \DateTimeImmutable;
}
