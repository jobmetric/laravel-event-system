<?php

namespace JobMetric\EventSystem\Events;

use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Models\Event;
use JobMetric\EventSystem\Support\DomainEventDefinition;

readonly class EventSystemDeletingEvent implements DomainEvent
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
        return 'event_system.deleting';
    }

    /**
     * Returns the full metadata definition for this domain event.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'event-system::base.events.event_system_deleting.group', 'event-system::base.events.event_system_deleting.title', 'event-system::base.events.event_system_deleting.description', 'fas fa-trash-alt', [
            'event system',
            'storage',
            'management',
        ]);
    }
}
