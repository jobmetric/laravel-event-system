<?php

use JobMetric\EventSystem\Facades\EventSystem;
use JobMetric\PackageCore\Output\Response;

if (!function_exists('addEventSystem')) {
    /**
     * Register a new event system entry.
     *
     * This function creates and stores an event-listener mapping in the event system with a given priority and status.
     * It's useful when dynamically registering event handlers, especially in modular or plugin-based systems.
     *
     * @param string $event_name The name/label of the event system entry (used as a unique identifier).
     * @param string $event The fully qualified class name of the event.
     * @param string $listener The fully qualified class name of the listener that handles the event.
     * @param int $priority The execution priority of the listener. Lower values are executed earlier.
     * @param string|null $description Optional description for documentation or management purposes.
     * @param bool $status Indicates whether the event system entry is active or not.
     *
     * @return Response
     * @throws Throwable
     */
    function addEventSystem(string $event_name, string $event, string $listener, int $priority = 0, string $description = null, bool $status = true): Response
    {
        return EventSystem::store([
            'name' => $event_name,
            'description' => $description,
            'event' => $event,
            'listener' => $listener,
            'priority' => $priority,
            'status' => $status,
        ]);
    }
}

if (!function_exists('deleteEventSystem')) {
    /**
     * Delete an event system entry by its name.
     *
     * This function removes an event system record identified by its unique name. Useful for unbinding dynamically added listeners.
     *
     * @param string $event_name The name of the event system entry to be deleted.
     *
     * @return Response
     * @throws Throwable
     */
    function deleteEventSystem(string $event_name): Response
    {
        return EventSystem::delete($event_name);
    }
}
