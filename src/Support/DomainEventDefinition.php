<?php

namespace JobMetric\EventSystem\Support;

/**
 * Immutable definition object that holds metadata for a domain event,
 * including technical key and UI-oriented presentation details.
 */
readonly class DomainEventDefinition
{
    public function __construct(
        public string $key,
        public string $group,
        public string $title,
        public ?string $description = null,
        public ?string $icon = null,
        public ?array $tags = null,
    ) {
    }
}
