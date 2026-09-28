<?php

namespace JobMetric\EventSystem\Support;

/**
 * Immutable definition object that holds metadata for a domain event,
 * including technical key and UI-oriented presentation details.
 */
class DomainEventDefinition
{
    public function __construct(
        public readonly string $key,
        public readonly string $group,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly ?string $icon = null,
        public readonly ?array $tags = null,
    ) {
    }
}
