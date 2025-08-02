<?php

namespace JobMetric\EventSystem\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JobMetric\EventSystem\Models\Event;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'event' => null,
            'listener' => null,
            'priority' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->boolean,
        ];
    }

    /**
     * set name
     *
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => $name
        ]);
    }

    /**
     * set description
     *
     * @param string $description
     *
     * @return static
     */
    public function setDescription(string $description): static
    {
        return $this->state(fn(array $attributes) => [
            'description' => $description
        ]);
    }

    /**
     * set event
     *
     * @param string $event
     *
     * @return static
     */
    public function setEvent(string $event): static
    {
        return $this->state(fn(array $attributes) => [
            'event' => $event
        ]);
    }

    /**
     * set listener
     *
     * @param string $listener
     *
     * @return static
     */
    public function setListener(string $listener): static
    {
        return $this->state(fn(array $attributes) => [
            'listener' => $listener
        ]);
    }

    /**
     * set priority
     *
     * @param int $priority
     *
     * @return static
     */
    public function setPriority(int $priority): static
    {
        return $this->state(fn(array $attributes) => [
            'priority' => $priority
        ]);
    }

    /**
     * set status
     *
     * @param bool $status
     *
     * @return static
     */
    public function setStatus(bool $status): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => $status
        ]);
    }
}
