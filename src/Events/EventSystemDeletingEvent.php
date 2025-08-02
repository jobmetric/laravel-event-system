<?php

namespace JobMetric\EventSystem\Events;

use JobMetric\EventSystem\Models\Event;

class EventSystemDeletingEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly Event $event,
    )
    {
    }
}
