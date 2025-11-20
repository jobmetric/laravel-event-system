<?php

namespace JobMetric\EventSystem\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \JobMetric\EventSystem\Support\EventBus
 *
 * @method static void dispatchByKey(string $key, mixed ...$payload)
 * @method static void dispatch(object $event)
 */
class EventBus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'EventBus';
    }
}
