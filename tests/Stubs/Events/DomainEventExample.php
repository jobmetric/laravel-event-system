<?php

namespace JobMetric\EventSystem\Tests\Stubs\Events;

use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Support\DomainEventDefinition;

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

    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(
            key: self::key(),
            group: 'tests',
            title: 'Domain Event Example',
            description: 'Example domain event for tests',
            icon: 'fa fa-test',
            tags: ['tests', 'event'],
        );
    }
}
