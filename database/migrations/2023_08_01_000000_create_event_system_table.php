<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $table->string('event');
            $table->string('listener');

            $table->boolean('status')->default(true)->index();

            $table->dateTime('created_at')->useCurrent();
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
