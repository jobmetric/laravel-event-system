<?php

namespace JobMetric\EventSystem\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class EventSystemResource
 *
 * Transforms an Event model into a JSON-serializable array suitable for API responses.
 * Used within the Event System package to return event-listener bindings in a consistent format.
 *
 * This resource ensures that all relevant fields from the model are exposed in the API,
 * including formatted timestamps and key configuration values such as event class, listener class,
 * priority, and activation status.
 *
 * #### Expected Model Properties:
 * @property int $id                        Unique identifier of the event-listener entry.
 * @property string $name                   Human-readable unique name.
 * @property string|null $description       Optional description for the entry.
 * @property string $event                  Fully qualified class name of the event.
 * @property string $listener               Fully qualified class name of the listener.
 * @property int $priority                  Listener execution priority.
 * @property bool $status                   Whether the listener is active or disabled.
 * @property Carbon $created_at             Timestamp of when the record was created.
 * @property Carbon $updated_at             Timestamp of when the record was last updated.
 *
 * @package JobMetric\EventSystem
 */
class EventSystemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'event' => $this->event,
            'listener' => $this->listener,
            'priority' => $this->priority,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
