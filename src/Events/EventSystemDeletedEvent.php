<?php

namespace JobMetric\EventSystem\Events;

use JobMetric\EventSystem\Models\Event;

readonly class EventSystemDeletedEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Event $event,
    ) {
    }
}
