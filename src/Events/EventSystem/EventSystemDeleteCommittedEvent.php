<?php

namespace JobMetric\EventSystem\Events\EventSystem;

use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Support\DomainEventDefinition;

/**
 * Describe a committed EventSystem deleted outcome using allowlisted identifiers.
 */
readonly class EventSystemDeleteCommittedEvent implements DomainEvent
{
    /**
     * Capture identifiers without models, input values or credentials.
     *
     * @param int|string $id
     *
     * @return void
     */
    public function __construct(
        public int|string $id
    ) {
    }

    /**
     * Return the stable key used by automation consumers.
     *
     * @return string
     */
    public static function key(): string
    {
        return 'event-system.event_system.deleted.committed';
    }

    /**
     * Describe the outcome for translated discovery interfaces.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'event-system::automation.event_system_deleted.group', 'event-system::automation.event_system_deleted.title', 'event-system::automation.event_system_deleted.description', 'fas fa-bolt', ['automation', 'committed', 'event-system']);
    }
}
