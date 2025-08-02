<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cache Time
    |--------------------------------------------------------------------------
    |
    | Cache time for get data event system
    |
    | - set zero for remove cache
    | - set null for forever
    |
    | - unit: minutes
    */

    "cache_time" => env("EVENT_SYSTEM_CACHE_TIME"),

    /*
    |--------------------------------------------------------------------------
    | Cache Key
    |--------------------------------------------------------------------------
    |
    | Cache key for store event system listeners in cache
    |
    */

    "cache_key" => env("EVENT_SYSTEM_CACHE_KEY", 'event-system:listens:' . env('APP_ENV', 'production')),

    /*
    |--------------------------------------------------------------------------
    | Table Name
    |--------------------------------------------------------------------------
    |
    | Table name in database
    */

    "tables" => [
        'event' => 'events',
    ],

];
