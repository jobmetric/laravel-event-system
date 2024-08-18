<?php

namespace JobMetric\EventSystem;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;
use JobMetric\EventSystem\Models\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens(): array
    {
        if (Schema::hasTable(config('event-system.tables.event'))) {
            return cache()->remember('events', config('event-system.cache_time'), function () {
                $events = Event::active()->get();

                $data = [];
                foreach ($events as $event) {
                    if (class_exists($event->event) && class_exists($event->listener)) {
                        $data[$event->event][] = $event->listener;
                    }
                }

                return $data;
            });
        }

        return [];
    }
}
