<?php

namespace JobMetric\EventSystem\Tests\Feature;

use JobMetric\EventSystem\Exceptions\EventSystemByNameNotFoundException;
use JobMetric\EventSystem\Facades\EventSystem;
use JobMetric\EventSystem\Http\Resources\EventSystemResource;
use JobMetric\EventSystem\Models\Event;
use JobMetric\EventSystem\Tests\Stubs;
use JobMetric\EventSystem\Tests\TestCase as BaseTestCase;
use JobMetric\PackageCore\Output\Response;
use Throwable;

class EventSystemTest extends BaseTestCase
{
    /**
     * @throws Throwable
     */
    public function test_store()
    {
        $eventClass = Stubs\Events\EventExample::class;
        $listenerClass = Stubs\Listeners\ListenerExample::class;

        // Store an event system
        $storeEventSystem = EventSystem::store([
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass
        ]);

        $this->assertInstanceOf(Response::class, $storeEventSystem);
        $this->assertTrue($storeEventSystem->ok);
        $this->assertEquals($storeEventSystem->message, trans('event-system::base.messages.created'));
        $this->assertInstanceOf(EventSystemResource::class, $storeEventSystem->data);
        $this->assertEquals(201, $storeEventSystem->status);

        $this->assertDatabaseHas('events', [
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass,
            'priority' => 0,
            'status' => true
        ]);

        // Store the same event system again
        try {
            $storeEventSystem = EventSystem::store([
                'name' => 'Event System Name Duplicate',
                'description' => 'The event system is a system that allows you to create events and listeners.',
                'event' => $eventClass,
                'listener' => $listenerClass,
            ]);
        } catch (Throwable $e) {
            $this->assertInstanceOf(\Illuminate\Database\UniqueConstraintViolationException::class, $e);
        }
    }

    /**
     * @throws Throwable
     */
    public function test_delete()
    {
        $eventClass = Stubs\Events\EventExample::class;
        $listenerClass = Stubs\Listeners\ListenerExample::class;

        // Store an event system
        $storeEventSystem = EventSystem::store([
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass
        ]);

        // Delete the event system
        $deleteEventSystem = EventSystem::delete('Event System Name');

        $this->assertInstanceOf(Response::class, $deleteEventSystem);
        $this->assertTrue($deleteEventSystem->ok);
        $this->assertEquals($deleteEventSystem->message, trans('event-system::base.messages.deleted'));
        $this->assertInstanceOf(EventSystemResource::class, $deleteEventSystem->data);
        $this->assertEquals(200, $deleteEventSystem->status);

        $this->assertDatabaseMissing('events', [
            'id' => $storeEventSystem->data->id,
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
        $eventClass = Stubs\Events\EventExample::class;
        $listenerClass = Stubs\Listeners\ListenerExample::class;

        // Store an event system
        $storeEventSystem = EventSystem::store([
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass
        ]);

        // Toggle the status of the event system
        $toggleStatusEventSystem = EventSystem::toggleStatus($storeEventSystem->data->id);

        $this->assertInstanceOf(Response::class, $toggleStatusEventSystem);
        $this->assertTrue($toggleStatusEventSystem->ok);
        $this->assertEquals($toggleStatusEventSystem->message, trans('event-system::base.messages.change_status'));
        $this->assertInstanceOf(EventSystemResource::class, $toggleStatusEventSystem->data);
        $this->assertEquals(200, $toggleStatusEventSystem->status);

        $this->assertDatabaseHas('events', [
            'id' => $storeEventSystem->data->id,
            'status' => false,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function test_all()
    {
        $eventClass = Stubs\Events\EventExample::class;
        $listenerClass = Stubs\Listeners\ListenerExample::class;

        // Store an event system
        EventSystem::store([
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass
        ]);

        // Get the event systems
        $getEventSystems = EventSystem::all();

        $this->assertCount(1, $getEventSystems);

        $getEventSystems->each(function ($eventSystem) {
            $this->assertInstanceOf(Event::class, $eventSystem);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_pagination()
    {
        $eventClass = Stubs\Events\EventExample::class;
        $listenerClass = Stubs\Listeners\ListenerExample::class;

        // Store an event system
        EventSystem::store([
            'name' => 'Event System Name',
            'description' => 'The event system is a system that allows you to create events and listeners.',
            'event' => $eventClass,
            'listener' => $listenerClass
        ]);

        // Paginate the event systems
        $paginateEventSystems = EventSystem::paginate();

        $this->assertCount(1, $paginateEventSystems);

        $paginateEventSystems->each(function ($eventSystem) {
            $this->assertInstanceOf(Event::class, $eventSystem);
        });

        $this->assertIsInt($paginateEventSystems->total());
        $this->assertIsInt($paginateEventSystems->perPage());
        $this->assertIsInt($paginateEventSystems->currentPage());
        $this->assertIsInt($paginateEventSystems->lastPage());
        $this->assertIsArray($paginateEventSystems->items());
    }
}
