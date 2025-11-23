<?php

namespace JobMetric\EventSystem\Events;

use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Models\Event;
use JobMetric\EventSystem\Support\DomainEventDefinition;

readonly class EventSystemDeletedEvent implements DomainEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Event $event,
    ) {
    }

    /**
     * Returns the stable technical key for the domain event.
     *
     * @return string
     */
    public static function key(): string
    {
        return 'event_system.deleted';
    }

    /**
     * Returns the full metadata definition for this domain event.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'event-system::base.events.event_system_deleted.group', 'event-system::base.events.event_system_deleted.title', 'event-system::base.events.event_system_deleted.description', 'fas fa-trash-alt', [
            'event system',
            'storage',
            'management',
        ]);
    }
}
