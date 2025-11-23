<?php

namespace JobMetric\EventSystem\Contracts;

use JobMetric\EventSystem\Support\DomainEventDefinition;

interface DomainEvent
{
    /**
     * Returns the stable technical key for the domain event.
     *
     * @return string
     */
    public static function key(): string;

    /**
     * Returns the full metadata definition for this domain event.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition;
}
