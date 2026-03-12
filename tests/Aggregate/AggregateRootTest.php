<?php

namespace Cohete\DDD\Tests\Aggregate;

use Cohete\DDD\Aggregate\AggregateRoot;
use Cohete\DDD\Event\DomainEvent;
use PHPUnit\Framework\TestCase;

class StubEvent implements DomainEvent
{
    public function __construct(private readonly string $name, private readonly array $data = [])
    {
    }

    public function eventName(): string
    {
        return $this->name;
    }

    public function payload(): array
    {
        return $this->data;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}

class StubAggregate extends AggregateRoot
{
    public static function create(string $name): self
    {
        $aggregate = new self();
        $aggregate->record(new StubEvent('aggregate.created', ['name' => $name]));
        return $aggregate;
    }

    public function rename(string $newName): void
    {
        $this->record(new StubEvent('aggregate.renamed', ['name' => $newName]));
    }
}

class AggregateRootTest extends TestCase
{
    public function testRecordAndPullEvents(): void
    {
        $aggregate = StubAggregate::create('test');
        $events = $aggregate->pullDomainEvents();

        $this->assertCount(1, $events);
        $this->assertEquals('aggregate.created', $events[0]->eventName());
        $this->assertEquals(['name' => 'test'], $events[0]->payload());
    }

    public function testPullClearsEvents(): void
    {
        $aggregate = StubAggregate::create('test');
        $aggregate->pullDomainEvents();

        $this->assertCount(0, $aggregate->pullDomainEvents());
    }

    public function testMultipleEventsRecorded(): void
    {
        $aggregate = StubAggregate::create('test');
        $aggregate->rename('renamed');
        $events = $aggregate->pullDomainEvents();

        $this->assertCount(2, $events);
        $this->assertEquals('aggregate.created', $events[0]->eventName());
        $this->assertEquals('aggregate.renamed', $events[1]->eventName());
    }

    public function testNoEventsInitially(): void
    {
        $aggregate = new class extends AggregateRoot {};
        $this->assertCount(0, $aggregate->pullDomainEvents());
    }
}
