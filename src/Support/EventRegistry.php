<?php

namespace JobMetric\EventSystem\Support;

use InvalidArgumentException;
use JobMetric\EventSystem\Contracts\DomainEvent;

class EventRegistry
{
    /**
     * @var array<string, class-string<DomainEvent>>
     */
    protected array $map = [];

    /**
     * Register a domain event with a given key.
     *
     * @param string $key
     * @param class-string<DomainEvent> $eventClass
     */
    public function register(string $key, string $eventClass): void
    {
        if (! is_subclass_of($eventClass, DomainEvent::class)) {
            throw new InvalidArgumentException("[$eventClass] must implement DomainEvent interface.");
        }

        $this->map[$key] = $eventClass;
    }

    /**
     * Get event class by key.
     */
    public function forKey(string $key): ?string
    {
        return $this->map[$key] ?? null;
    }

    /**
     * Get key by event instance/class.
     *
     * @param object|string $event
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
