<?php

namespace JobMetric\EventSystem\Events;

use JobMetric\EventSystem\Models\Event;
use JobMetric\EventSystem\Support\DomainEventDefinition;

readonly class EventSystemDeletingEvent
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
        return new DomainEventDefinition(
            key: self::key(),
            group: trans('event-system::base.events.event_system_deleting.group'),
            title: trans('event-system::base.events.event_system_deleting.title'),
            description: trans('event-system::base.events.event_system_deleting.description'),
            icon: 'fas fa-trash-alt',
            tags: trans('event-system::base.events.event_system_deleting.tags')
        );
    }
}
