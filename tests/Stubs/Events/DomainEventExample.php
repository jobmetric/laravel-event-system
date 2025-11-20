<?php

namespace JobMetric\EventSystem\Tests\Stubs\Events;

use JobMetric\EventSystem\Contracts\DomainEvent;

class DomainEventExample implements DomainEvent
{
    public string $name;

    public array $payload;

    public function __construct(string $name, array $payload = [])
    {
        $this->name = $name;
        $this->payload = $payload;
    }

    public static function key(): string
    {
        return 'tests.event.bus.domain';
    }
}
