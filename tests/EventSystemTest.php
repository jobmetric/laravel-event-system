<?php

namespace JobMetric\EventSystem\Tests;

use JobMetric\EventSystem\Exceptions\EventSystemByNameNotFoundException;
use JobMetric\EventSystem\Exceptions\EventSystemNotFoundException;
use JobMetric\EventSystem\Facades\EventSystem;
use JobMetric\EventSystem\Http\Resources\EventSystemResource;
use Tests\BaseDatabaseTestCase as BaseTestCase;
use Throwable;

class EventSystemTest extends BaseTestCase
{
    /**
     * @throws Throwable
     */
    public function test_store()
    {
        $eventClass = \JobMetric\EventSystem\Tests\EventExample::class;
        $listenerClass = \JobMetric\EventSystem\Tests\ListenerExample::class;

        // Store an event system
        $storeEventSystem = EventSystem::store([
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass,
            'status' => true,
        ]);

        $this->assertIsArray($storeEventSystem);
        $this->assertEquals($storeEventSystem['message'], trans('event-system::base.messages.created'));
        $this->assertInstanceOf(EventSystemResource::class, $storeEventSystem['data']);
        $this->assertEquals(201, $storeEventSystem['status']);

        $this->assertDatabaseHas('events', [
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass,
            'status' => true,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function test_delete()
    {
        $eventClass = \JobMetric\EventSystem\Tests\EventExample::class;
        $listenerClass = \JobMetric\EventSystem\Tests\ListenerExample::class;

        // Store an event system
        $storeEventSystem = EventSystem::store([
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass,
            'status' => true,
        ]);

        // Delete the event system
        $deleteEventSystem = EventSystem::delete('Event System Name');

        $this->assertIsArray($deleteEventSystem);
        $this->assertEquals($deleteEventSystem['message'], trans('event-system::base.messages.deleted'));
        $this->assertInstanceOf(EventSystemResource::class, $deleteEventSystem['data']);
        $this->assertEquals(200, $deleteEventSystem['status']);

        $this->assertDatabaseMissing('events', [
            'id' => $storeEventSystem['data']->id,
        ]);

        // Delete the event system again
        try {
            $deleteEventSystem = EventSystem::delete('Event System Name');

            $this->assertIsArray($deleteEventSystem);
        } catch (Throwable $e) {
            $this->assertInstanceOf(EventSystemByNameNotFoundException::class, $e);
        }
    }

    /**
     * @throws Throwable
     */
    public function test_toggle_status()
    {
        $eventClass = \JobMetric\EventSystem\Tests\EventExample::class;
        $listenerClass = \JobMetric\EventSystem\Tests\ListenerExample::class;

        // Store an event system
        $storeEventSystem = EventSystem::store([
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass,
            'status' => true,
        ]);

        // Toggle the status of the event system
        $toggleStatusEventSystem = EventSystem::toggleStatus($storeEventSystem['data']->id);

        $this->assertIsArray($toggleStatusEventSystem);
        $this->assertEquals($toggleStatusEventSystem['message'], trans('event-system::base.messages.updated'));
        $this->assertInstanceOf(EventSystemResource::class, $toggleStatusEventSystem['data']);
        $this->assertEquals(200, $toggleStatusEventSystem['status']);

        $this->assertDatabaseHas('events', [
            'id' => $storeEventSystem['data']->id,
            'status' => false,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function test_all()
    {
        $eventClass = \JobMetric\EventSystem\Tests\EventExample::class;
        $listenerClass = \JobMetric\EventSystem\Tests\ListenerExample::class;

        // Store an event system
        EventSystem::store([
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass,
            'status' => true,
        ]);

        // Get the event systems
        $getEventSystems = EventSystem::all();

        $this->assertCount(1, $getEventSystems);

        $getEventSystems->each(function ($eventSystem) {
            $this->assertInstanceOf(EventSystemResource::class, $eventSystem);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_pagination()
    {
        $eventClass = \JobMetric\EventSystem\Tests\EventExample::class;
        $listenerClass = \JobMetric\EventSystem\Tests\ListenerExample::class;

        // Store an event system
        EventSystem::store([
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass,
            'status' => true,
        ]);

        // Paginate the event systems
        $paginateEventSystems = EventSystem::paginate();

        $this->assertCount(1, $paginateEventSystems);

        $paginateEventSystems->each(function ($eventSystem) {
            $this->assertInstanceOf(EventSystemResource::class, $eventSystem);
        });

        $this->assertIsInt($paginateEventSystems->total());
        $this->assertIsInt($paginateEventSystems->perPage());
        $this->assertIsInt($paginateEventSystems->currentPage());
        $this->assertIsInt($paginateEventSystems->lastPage());
        $this->assertIsArray($paginateEventSystems->items());
    }
}
