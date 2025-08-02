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
            $cacheKey = config('event-system.cache_key', 'event-system:listens:' . app()->environment());

            return cache()->remember($cacheKey, config('event-system.cache_time'), function () {
                $events = Event::active()->orderBy('priority')->get();

                $data = [];
                foreach ($events as $event) {
                    if (!class_exists($event->event)) {
                        logger()->warning("Event class '{$event->event}' does not exist.");
                        continue;
                    }

                    if (!class_exists($event->listener)) {
                        logger()->warning("Listener class '{$event->listener}' does not exist.");
                        continue;
                    }

                    $data[$event->event][] = $event->listener;
                }

                return $data;
            });
        }

        return [];
    }
}
