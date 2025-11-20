<?php

namespace JobMetric\EventSystem\Contracts;

interface DomainEvent
{
    /**
     * Returns the stable key for this domain event.
     */
    public static function key(): string;
}
