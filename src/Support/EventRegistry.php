<?php

namespace JobMetric\EventSystem\Support;

use InvalidArgumentException;
use JobMetric\EventSystem\Contracts\DomainEvent;

/**
 * Registry responsible for managing domain events and their metadata definitions.
 *
 * It keeps a mapping between stable event keys and their corresponding event classes,
 * as well as full DomainEventDefinition instances for use in UI, automation and logging.
 */
class EventRegistry
{
    /**
     * Holds registered domain event classes mapped by their stable keys.
     *
     * @var array<string, class-string<DomainEvent>>
     */
    protected array $map = [];

    /**
     * Holds rich metadata definitions for registered domain events keyed by their stable keys.
     *
     * @var array<string, DomainEventDefinition>
     */
    protected array $definitions = [];

    /**
     * Register a domain event with a given key and event class.
     *
     * The key is resolved from the DomainEvent implementation itself via its static key() method.
     * During registration, both the class mapping and the DomainEventDefinition are stored for later lookup
     * by key or for listing in user interfaces.
     *
     * @param class-string<DomainEvent> $eventClass The concrete domain event class to register.
     *
     * @return void
     */
    public function register(string $eventClass): void
    {
        if (! is_subclass_of($eventClass, DomainEvent::class)) {
            throw new InvalidArgumentException("[$eventClass] must implement " . DomainEvent::class . '.');
        }

        $resolvedKey = $eventClass::key();

        $this->map[$resolvedKey] = $eventClass;
        $this->definitions[$resolvedKey] = $eventClass::definition();
    }

    /**
     * Get the event class for the given key.
     *
     * This method is typically used by low-level infrastructure such as the EventBus
     * when it needs to resolve a key into a concrete event class to dispatch.
     *
     * @param string $key The stable event key to look up.
     *
     * @return class-string<DomainEvent>|null
     */
    public function forKey(string $key): ?string
    {
        return $this->map[$key] ?? null;
    }

    /**
     * Get the metadata definition for a given key.
     *
     * This is useful for building UIs, documentation or configuration screens where
     * human-readable information (title, description, icon, group, tags) is required.
     *
     * @param string $key The stable event key to look up.
     *
     * @return DomainEventDefinition|null
     */
    public function definitionForKey(string $key): ?DomainEventDefinition
    {
        return $this->definitions[$key] ?? null;
    }

    /**
     * Get all registered metadata definitions keyed by their event keys.
     *
     * This is typically used when rendering a complete list of available events
     * to the user so they can choose from them in an automation or rule builder.
     *
     * @return array<string, DomainEventDefinition>
     */
    public function allDefinitions(): array
    {
        return $this->definitions;
    }

    /**
     * Determine whether an event with the given key is registered.
     *
     * @param string $key The stable event key to check existence for.
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->map);
    }

    /**
     * Get the stable key for the given event instance or event class.
     *
     * This method is useful for logging or building audit trails where you want to store
     * the stable event key instead of the raw PHP class name.
     *
     * @param object|string $event The event instance or event class name to resolve a key for.
     *
     * @return string|null
     */
    public function keyFor(object|string $event): ?string
    {
        $class = is_object($event) ? $event::class : $event;

        foreach ($this->map as $key => $mappedClass) {
            if ($mappedClass === $class) {
                return $key;
            }
        }

        return null;
    }
}
