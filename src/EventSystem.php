<?php

namespace JobMetric\EventSystem;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JobMetric\EventSystem\Events\EventSystemDeletedEvent;
use JobMetric\EventSystem\Events\EventSystemDeletingEvent;
use JobMetric\EventSystem\Events\EventSystemStoredEvent;
use JobMetric\EventSystem\Exceptions\EventSystemByNameNotFoundException;
use JobMetric\EventSystem\Exceptions\EventSystemNotFoundException;
use JobMetric\EventSystem\Http\Requests\StoreEventSystemRequest;
use JobMetric\EventSystem\Http\Resources\EventSystemResource;
use JobMetric\EventSystem\Models\Event;
use JobMetric\PackageCore\Output\Response;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

/**
 * Class EventSystem
 *
 * Service class responsible for managing dynamic event-listener registrations.
 * This class handles core CRUD operations, event dispatching, caching, query filtering,
 * validation, pagination, and toggling status logic for the event system module.
 *
 * Key Features:
 * - Registering new event system entries with validation
 * - Filtering, sorting, and paginating event records via Spatie\QueryBuilder
 * - Status toggling for activation/deactivation
 * - Custom exceptions for accurate error reporting
 * - Resource-based JSON API responses
 * - Event dispatching for extensibility
 *
 * @package JobMetric\EventSystem
 */
class EventSystem
{
    /**
     * Build a query builder instance with filtering, sorting, and selected fields.
     *
     * @param array $filter Associative array of column filters to apply (e.g., ['status' => true]).
     *
     * @return QueryBuilder
     */
    public function query(array $filter = []): QueryBuilder
    {
        $fields = [
            'id',
            'name',
            'description',
            'event',
            'listener',
            'priority',
            'status',
            'created_at',
            'updated_at',
        ];

        return QueryBuilder::for(Event::class)
            ->allowedFields($fields)
            ->allowedSorts($fields)
            ->allowedFilters($fields)
            ->defaultSort('-id')
            ->where($filter);
    }

    /**
     * Return a paginated collection of event system records as JSON resources.
     *
     * @param array $filter Optional filters to apply (e.g., ['status' => true]).
     * @param int $page_limit Number of records per page (default is 15).
     *
     * @return LengthAwarePaginator
     */
    public function paginate(array $filter = [], int $page_limit = 15): LengthAwarePaginator
    {
        return $this->query($filter)->paginate($page_limit);
    }

    /**
     * Return all event system records without pagination as a JSON resource collection.
     *
     * @param array $filter Optional filters to apply.
     *
     * @return Collection
     */
    public function all(array $filter = []): Collection
    {
        return $this->query($filter)->get();
    }

    /**
     * Validate and store a new event system entry in the database.
     *
     * Dispatches EventSystemStoredEvent on success.
     *
     * @param array $input Input data to validate and persist.
     *
     * @return Response
     * @throws Throwable
     */
    public function store(array $input): Response
    {
        $validated = dto($input, StoreEventSystemRequest::class);

        return DB::transaction(function () use ($validated) {
            $event = Event::create($validated);

            $this->forgetCache();

            event(new EventSystemStoredEvent($event, $validated));

            return Response::make(true, trans('event-system::base.messages.created'), EventSystemResource::make($event), 201);
        });
    }

    /**
     * Delete an event system record by its unique name.
     *
     * Dispatches EventSystemDeletingEvent before deletion and EventSystemDeletedEvent after.
     *
     * @param string $name The unique name of the event system record.
     *
     * @return Response
     * @throws Throwable
     */
    public function delete(string $name): Response
    {
        return DB::transaction(function () use ($name) {
            $event = $this->findByNameOrFail($name);

            event(new EventSystemDeletingEvent($event));

            $data = EventSystemResource::make($event);

            $event->delete();

            event(new EventSystemDeletedEvent($event));

            $this->forgetCache();

            return Response::make(true, trans('event-system::base.messages.deleted'), $data);
        });
    }

    /**
     * Toggle the boolean 'status' field of a given event system record.
     *
     * @param int $event_system_id The ID of the event system to toggle.
     *
     * @return Response
     * @throws Throwable
     */
    public function toggleStatus(int $event_system_id): Response
    {
        return DB::transaction(function () use ($event_system_id) {
            $event = $this->findByIdOrFail($event_system_id);

            $event->status = !$event->status;
            $event->save();

            $this->forgetCache();

            return Response::make(true, trans('event-system::base.messages.change_status'), EventSystemResource::make($event));
        });
    }

    /**
     * Find an event system record by its ID or throw an exception.
     *
     * @param int $event_system_id The ID of the event system.
     *
     * @return Event
     * @throws Throwable
     */
    protected function findByIdOrFail(int $event_system_id): Event
    {
        return Event::find($event_system_id) ?? throw new EventSystemNotFoundException($event_system_id);
    }

    /**
     * Find an event system record by its unique name or throw an exception.
     *
     * @param string $name The unique name of the event system.
     *
     * @return Event
     * @throws Throwable
     */
    protected function findByNameOrFail(string $name): Event
    {
        return Event::whereName($name)->firstOr(fn() => throw new EventSystemByNameNotFoundException($name));
    }

    /**
     * Clear the cached event system data (used after create, update, delete).
     *
     * @return void
     */
    private function forgetCache(): void
    {
        cache()->forget('events');
    }
}
