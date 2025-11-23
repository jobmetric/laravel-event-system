<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base Event System Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during Event System for
    | various messages that we need to display to the user.
    |
    */

    "validation" => [
        "class_exist" => "The class ':class' does not exist.",
    ],

    "messages" => [
        "created" => "Event System created successfully.",
        "deleted" => "Event System deleted successfully.",
        "change_status" => "Event System status changed successfully.",
    ],

    "exceptions" => [
        "event_system_by_name_not_found" => "Event System with name :name not found.",
        "event_system_not_found" => "Event System with number :number not found.",
    ],

    "fields" => [
        "name" => "Name",
        "description" => "Description",
        "event" => "Event",
        "listener" => "Listener",
        "priority" => "Priority",
        "status" => "Status",
    ],

    'events' => [
        'event_system_deleted' => [
            'group' => 'Event System',
            'title' => 'Event System Deleted',
            'description' => 'This event is triggered when an Event System is deleted.',
        ],

        'event_system_deleting' => [
            'group' => 'Event System',
            'title' => 'Event System Deleting',
            'description' => 'This event is triggered when an Event System is being deleted.',
        ],

        'event_system_stored' => [
            'group' => 'Event System',
            'title' => 'Event System Stored',
            'description' => 'This event is triggered when an Event System is stored.',
        ],
    ],

];
