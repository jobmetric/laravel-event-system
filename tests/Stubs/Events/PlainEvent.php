<?php

namespace JobMetric\EventSystem\Tests\Stubs\Events;

class PlainEvent
{
    public string $payload;

    public function __construct(string $payload)
    {
        $this->payload = $payload;
    }
}
