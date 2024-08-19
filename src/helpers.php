<?php

use JobMetric\EventSystem\Exceptions\ClassNotFoundException;
use JobMetric\EventSystem\Facades\EventSystem;

if (!function_exists('addEventSystem')) {
    /**
     * Add the event system
     *
     * @param string $name
     * @param string $event
     * @param string $listener
     * @param string|null $description
     *
     * @return array
     * @throws Throwable
     */
    function addEventSystem(string $name, string $event, string $listener, string $description = null): array
    {
        if (!class_exists($event)) {
            throw new ClassNotFoundException($event);
        }

        if (!class_exists($listener)) {
            throw new ClassNotFoundException($listener);
        }

        return EventSystem::store([
            'name' => $name,
            'event' => $event,
            'listener' => $listener,
            'description' => $description
        ]);
    }
}

if (!function_exists('deleteEventSystem')) {
    /**
     * Delete the event system
     *
     * @param string $event_name
     *
     * @return array
     * @throws Throwable
     */
    function deleteEventSystem(string $event_name): array
    {
        return EventSystem::delete($event_name);
    }
}
