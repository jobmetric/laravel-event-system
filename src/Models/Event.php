<?php

namespace JobMetric\EventSystem\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JobMetric\PackageCore\Models\HasBooleanStatus;

/**
 * Class Event
 *
 * Represents a dynamically registered event-listener binding in the Event System package.
 * This model is used to store event class names and their associated listeners in the database.
 * The listener can be a class-based handler that responds to the specified event.
 *
 * This model disables `updated_at` timestamps by design and supports dynamic table naming
 * based on the configuration value `event-system.tables.event`.
 *
 * @package JobMetric\EventSystem
 *
 * @property int $id Unique identifier of the event binding.
 * @property string $name A unique, human-readable name for the event-listener pair.
 * @property string|null $description Optional description for UI or documentation purposes.
 * @property string $event Fully qualified class name of the event (e.g., App\Events\UserRegistered).
 * @property string $listener Fully qualified class name of the listener (e.g., App\Listeners\SendWelcomeEmail).
 * @property int $priority Execution order of the listener (higher priority runs later).
 * @property bool $status Whether the listener is active (true) or disabled (false).
 * @property Carbon $created_at Timestamp when this binding was created.
 * @property Carbon $updated_at Timestamp when this binding was last updated.
 *
 * @method static Builder|Event whereName(string $name)
 * @method static Builder|Event whereDescription(string $description)
 * @method static Builder|Event whereEvent(string $event)
 * @method static Builder|Event whereListener(string $listener)
 * @method static Builder|Event wherePriority(int $priority)
 * @method static Builder|Event whereStatus(bool $status)
 */
class Event extends Model
{
    use HasFactory, HasBooleanStatus;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'event',
        'listener',
        'priority',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'event' => 'string',
        'listener' => 'string',
        'priority' => 'integer',
        'status' => 'boolean',
    ];

    /**
     * Override the table name using config.
     *
     * @return string
     */
    public function getTable(): string
    {
        return config('event-system.tables.event', parent::getTable());
    }
}
