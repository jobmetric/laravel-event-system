<?php

namespace JobMetric\EventSystem;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JobMetric\EventSystem\Events\EventSystemDeleteEvent;
use JobMetric\EventSystem\Events\EventSystemStoreEvent;
use JobMetric\EventSystem\Exceptions\EventSystemNotFoundException;
use JobMetric\EventSystem\Http\Requests\StoreEventSystemRequest;
use JobMetric\EventSystem\Http\Resources\EventSystemResource;
use JobMetric\EventSystem\Models\Event;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class EventSystem
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Create a new Translation instance.
     *
     * @param Application $app
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get the specified event system.
     *
     * @param array $filter
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
            'status',
            'created_at'
        ];

        return QueryBuilder::for(Event::class)
            ->allowedFields($fields)
            ->allowedSorts($fields)
            ->allowedFilters($fields)
            ->defaultSort('-id')
            ->where($filter);
    }

    /**
     * Paginate the specified event system.
     *
     * @param array $filter
     * @param int $page_limit
     *
     * @return AnonymousResourceCollection
     */
    public function paginate(array $filter = [], int $page_limit = 15): AnonymousResourceCollection
    {
        return EventSystemResource::collection(
            $this->query($filter)->paginate($page_limit)
        );
    }

    /**
     * Get all event systems.
     *
     * @param array $filter
     *
     * @return AnonymousResourceCollection
     */
    public function all(array $filter = []): AnonymousResourceCollection
    {
        return EventSystemResource::collection(
            $this->query($filter)->get()
        );
    }

    /**
     * Store the specified event system.
     *
     * @param array $data
     *
     * @return array
     * @throws Throwable
     */
    public function store(array $data): array
    {
        $validator = Validator::make($data, (new StoreEventSystemRequest)->rules());
        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return [
                'ok' => false,
                'message' => trans('event-system::base.validation.errors'),
                'errors' => $errors,
                'status' => 422
            ];
        } else {
            $data = $validator->validated();
        }

        return DB::transaction(function () use ($data) {
            $event = new Event;
            $event->name = $data['name'];
            $event->description = $data['description'] ?? null;
            $event->event = $data['event'];
            $event->listener = $data['listener'];
            $event->status = $data['status'] ?? true;
            $event->save();

            event(new EventSystemStoreEvent($event, $data));

            return [
                'ok' => true,
                'message' => trans('event-system::base.messages.created'),
                'data' => EventSystemResource::make($event),
                'status' => 201
            ];
        });
    }

    /**
     * Delete the specified event system.
     *
     * @param int $event_system_id
     *
     * @return array
     * @throws Throwable
     */
    public function delete(int $event_system_id): array
    {
        return DB::transaction(function () use ($event_system_id) {
            /**
             * @var Event $event
             */
            $event = Event::find($event_system_id);

            if (!$event) {
                throw new EventSystemNotFoundException($event_system_id);
            }

            event(new EventSystemDeleteEvent($event));

            $data = EventSystemResource::make($event);

            $event->delete();

            return [
                'ok' => true,
                'data' => $data,
                'message' => trans('event-system::base.messages.deleted'),
                'status' => 200
            ];
        });
    }
}
