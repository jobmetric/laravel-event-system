<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for creating the event listeners table used by the Event System package.
 *
 * This table holds information about dynamically registered event listeners.
 * Each row represents a listener that should respond to a specific event class.
 *
 * Columns:
 * - id: Primary key.
 * - name: Unique, human-readable identifier for the event-listener pair.
 * - description: Optional description for documentation or UI display.
 * - event: Fully qualified class name of the event.
 * - listener: Fully qualified class name of the listener (must be invokable or handle method).
 * - priority: Defines the order of execution when multiple listeners are registered for the same event.
 * - status: If false, the listener is considered disabled and won’t be triggered.
 * - created_at: Timestamp when the listener was created.
 *
 * Indexes:
 * - Unique constraint on (event, listener) to prevent duplicate bindings.
 * - Indexed columns for fast filtering by name, status, and priority.
 *
 * @package JobMetric\EventSystem\Migrations
 */
return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('event-system.tables.event'), function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique()->index();
            $table->text('description')->nullable();

            $table->string('event', 512);
            $table->string('listener', 512);

            $table->integer('priority')->default(0)->index();

            $table->boolean('status')->default(true)->index();

            $table->timestamps();

            $table->unique([
                'event',
                'listener'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('event-system.tables.event'));
    }
};
