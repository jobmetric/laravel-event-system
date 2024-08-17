<?php

namespace JobMetric\EventSystem\Exceptions;

use Exception;
use Throwable;

class EventSystemNotFoundException extends Exception
{
    public function __construct(int $number, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct(trans('unit::base.exceptions.event_system_not_found', [
            'number' => $number,
        ]), $code, $previous);
    }
}
