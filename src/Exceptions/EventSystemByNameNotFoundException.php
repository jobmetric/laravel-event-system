<?php

namespace JobMetric\EventSystem\Exceptions;

use Exception;
use Throwable;

class EventSystemByNameNotFoundException extends Exception
{
    public function __construct(string $name, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct(trans('unit::base.exceptions.event_system_by_name_not_found', [
            'name' => $name,
        ]), $code, $previous);
    }
}
