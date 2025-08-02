<?php

namespace JobMetric\EventSystem\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \JobMetric\EventSystem\EventSystem
 *
 * @method static \Spatie\QueryBuilder\QueryBuilder query(array $filter = [])
 * @method static \Illuminate\Http\Resources\Json\AnonymousResourceCollection paginate(array $filter = [], int $page_limit = 15)
 * @method static \Illuminate\Http\Resources\Json\AnonymousResourceCollection all(array $filter = [])
 * @method static \JobMetric\PackageCore\Output\Response store(array $data)
 * @method static \JobMetric\PackageCore\Output\Response delete(string $event_name)
 * @method static \JobMetric\PackageCore\Output\Response toggleStatus(int $event_system_id)
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
        return 'EventSystem';
    }
}
