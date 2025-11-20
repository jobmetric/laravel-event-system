<?php

namespace JobMetric\EventSystem\Events;

use JobMetric\EventSystem\Models\Event;

readonly class EventSystemDeletingEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Event $event,
    ) {
    }
}
