<?php

namespace JobMetric\EventSystem\Support;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Central event bus responsible for dispatching domain events either by class
 * instance or by a stable registry key, decoupling callers from concrete event classes.
 */
class EventBus
{
    /**
     * Underlying Laravel event dispatcher used to fire events.
     *
     * @var Dispatcher
     */
    protected Dispatcher $dispatcher;

    /**
     * Registry that resolves event keys to their corresponding event classes.
     *
     * @var EventRegistry
     */
    protected EventRegistry $registry;

    /**
     * Creates a new EventBus instance with the given dispatcher and registry dependencies.
     *
     * @param Dispatcher $dispatcher  The Laravel event dispatcher used to fire events.
     * @param EventRegistry $registry The registry used to resolve event keys to event classes.
     */
    public function __construct(
        Dispatcher $dispatcher,
        EventRegistry $registry
    ) {
        $this->dispatcher = $dispatcher;
        $this->registry = $registry;
    }

    /**
     * Dispatches an event by its stable key using the registry to resolve the event class,
     * constructing a new event instance from the provided payload.
     *
     * If the key is not registered in the registry, the call is silently ignored.
     *
     * @param string $key       The stable event key used to look up the event class in the registry.
     * @param mixed ...$payload The payload passed as constructor arguments to the event class.
     *
     * @return void
     */
    public function dispatchByKey(string $key, mixed ...$payload): void
    {
        $eventClass = $this->registry->forKey($key);

        if (! $eventClass) {
            return;
        }

        $event = new $eventClass(...$payload);
        $this->dispatcher->dispatch($event);
    }

    /**
     * Dispatches a concrete event instance using the underlying Laravel dispatcher,
     * allowing callers to work directly with event objects when the class is known.
     *
     * @param object $event The event instance to be dispatched.
     *
     * @return void
     */
    public function dispatch(object $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
