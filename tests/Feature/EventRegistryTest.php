<?php

namespace JobMetric\EventSystem\Tests\Feature;

use InvalidArgumentException;
use JobMetric\EventSystem\Support\DomainEventDefinition;
use JobMetric\EventSystem\Support\EventRegistry;
use JobMetric\EventSystem\Tests\Stubs;
use JobMetric\EventSystem\Tests\TestCase as BaseTestCase;

class EventRegistryTest extends BaseTestCase
{
    public function test_register_and_resolve_keys(): void
    {
        $registry = new EventRegistry();
        $registry->register(Stubs\Events\DomainEventExample::key(), Stubs\Events\DomainEventExample::class);

        $this->assertSame(Stubs\Events\DomainEventExample::class, $registry->forKey(Stubs\Events\DomainEventExample::key()));

        $this->assertSame(Stubs\Events\DomainEventExample::key(), $registry->keyFor(Stubs\Events\DomainEventExample::class));

        $instance = new Stubs\Events\DomainEventExample('name', ['foo' => 'bar']);
        
        $this->assertSame(Stubs\Events\DomainEventExample::key(), $registry->keyFor($instance));
    }

    public function test_register_stores_definition_and_allows_lookup(): void
    {
        $registry = new EventRegistry();
        $registry->register(Stubs\Events\DomainEventExample::key(), Stubs\Events\DomainEventExample::class);

        $definition = $registry->definitionForKey(Stubs\Events\DomainEventExample::key());

        $this->assertInstanceOf(DomainEventDefinition::class, $definition);
        $this->assertSame(Stubs\Events\DomainEventExample::key(), $definition->key);
        $this->assertSame('tests', $definition->group);
        $this->assertSame('Domain Event Example', $definition->title);
        $this->assertSame('Example domain event for tests', $definition->description);
        $this->assertSame('fa fa-test', $definition->icon);
        $this->assertSame(['tests', 'event'], $definition->tags);

        $definitions = $registry->allDefinitions();
        $this->assertArrayHasKey(Stubs\Events\DomainEventExample::key(), $definitions);
        $this->assertSame($definition, $definitions[Stubs\Events\DomainEventExample::key()]);
    }

    public function test_register_throws_for_invalid_class(): void
    {
        $registry = new EventRegistry();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('[JobMetric\\EventSystem\\Tests\\Stubs\\Events\\PlainEvent] must implement JobMetric\\EventSystem\\Contracts\\DomainEvent.');

        $registry->register('invalid-event', Stubs\Events\PlainEvent::class);
    }

    public function test_returns_null_for_unregistered_keys_or_events(): void
    {
        $registry = new EventRegistry();

        $this->assertNull($registry->forKey('missing.key'));
        $this->assertNull($registry->keyFor(Stubs\Events\PlainEvent::class));
        $this->assertNull($registry->definitionForKey('missing.key'));
    }
}
