<?php

namespace JobMetric\EventSystem\Exceptions;

use Exception;
use Throwable;

class ClassNotFoundException extends Exception
{
    public function __construct(string $class, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct(trans('unit::base.exceptions.class_not_found', [
            'class' => $class,
        ]), $code, $previous);
    }
}
