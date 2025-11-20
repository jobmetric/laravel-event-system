<?php

namespace JobMetric\EventSystem\Events;

use JobMetric\EventSystem\Models\Event;

readonly class EventSystemStoredEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Event $event,
        public array $data
    ) {
    }
}
