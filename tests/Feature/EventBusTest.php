<?php

namespace JobMetric\EventSystem\Tests\Feature;

use Illuminate\Support\Facades\Event;
use JobMetric\EventSystem\Support\EventBus;
use JobMetric\EventSystem\Support\EventRegistry;
use JobMetric\EventSystem\Tests\Stubs;
use JobMetric\EventSystem\Tests\TestCase as BaseTestCase;

class EventBusTest extends BaseTestCase
{
    public function test_dispatch_by_key_dispatches_registered_event(): void
    {
        Event::fake();

        $registry = new EventRegistry();
        $registry->register(Stubs\Events\DomainEventExample::class);

        $this->app->instance(EventRegistry::class, $registry);

        $bus = $this->app->make(EventBus::class);
        $bus->dispatchByKey(Stubs\Events\DomainEventExample::key(), 'Sample Event', ['type' => 'demo']);

        Event::assertDispatched(Stubs\Events\DomainEventExample::class, function (Stubs\Events\DomainEventExample $event
        ) {
            return $event->name === 'Sample Event' && $event->payload === ['type' => 'demo'];
        });
    }

    public function test_dispatch_by_key_is_ignored_when_key_is_not_registered(): void
    {
        Event::fake();

        $bus = $this->app->make(EventBus::class);
        $bus->dispatchByKey('event-system.unknown', 'ignored');

        Event::assertNothingDispatched();
    }

    public function test_dispatch_dispatches_plain_event_instance(): void
    {
        Event::fake();

        $event = new Stubs\Events\PlainEvent('payload');

        $bus = $this->app->make(EventBus::class);
        $bus->dispatch($event);

        Event::assertDispatched(Stubs\Events\PlainEvent::class, function (Stubs\Events\PlainEvent $dispatched) use (
            $event
        ) {
            return $dispatched === $event && $dispatched->payload === 'payload';
        });
    }

    public function test_registry_key_for_returns_key_for_class_and_instance(): void
    {
        $registry = new EventRegistry();
        $registry->register(Stubs\Events\DomainEventExample::class);

        $this->assertSame(Stubs\Events\DomainEventExample::key(), $registry->keyFor(Stubs\Events\DomainEventExample::class));

        $instance = new Stubs\Events\DomainEventExample('Name', ['foo' => 'bar']);

        $this->assertSame(Stubs\Events\DomainEventExample::key(), $registry->keyFor($instance));
    }

    public function test_registry_key_for_returns_null_when_not_registered(): void
    {
        $registry = new EventRegistry();

        $this->assertNull($registry->keyFor(Stubs\Events\PlainEvent::class));
    }
}
