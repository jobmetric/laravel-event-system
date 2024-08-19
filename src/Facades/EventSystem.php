<?php

namespace JobMetric\EventSystem\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Spatie\QueryBuilder\QueryBuilder query(array $filter = [])
 * @method static \Illuminate\Http\Resources\Json\AnonymousResourceCollection paginate(array $filter = [], int $page_limit = 15)
 * @method static \Illuminate\Http\Resources\Json\AnonymousResourceCollection all(array $filter = [])
 * @method static array store(array $data)
 * @method static array delete(string $event_name)
 * @method static array toggleStatus(int $event_system_id)
 *
 * @see \JobMetric\EventSystem\EventSystem
 */
class EventSystem extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \JobMetric\EventSystem\EventSystem::class;
    }
}
