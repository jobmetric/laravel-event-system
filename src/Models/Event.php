<?php

namespace JobMetric\EventSystem\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JobMetric\PackageCore\Models\HasBooleanStatus;

/**
 * JobMetric\EventSystem\Models\Event
 *
 * @property int id
 * @property string name
 * @property string description
 * @property string event
 * @property string listener
 * @property bool status
 * @property Carbon created_at
 *
 * @method static find(int $event_system_id)
 */
class Event extends Model
{
    use HasFactory, HasBooleanStatus;

    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'description',
        'event',
        'listener',
        'status',
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'event' => 'string',
        'listener' => 'string',
        'status' => 'boolean',
    ];

    public function getTable()
    {
        return config('event-system.tables.event', parent::getTable());
    }
}
