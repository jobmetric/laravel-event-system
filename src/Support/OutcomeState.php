<?php

namespace JobMetric\EventSystem\Support;

use Illuminate\Database\Eloquent\Model;

/**
 * Compare persisted aggregate state without passing that state to event listeners.
 */
class OutcomeState
{
    /**
     * Capture database attributes and explicitly selected relationships for no-op detection.
     *
     * @param Model $model
     * @param array<int, string> $relations
     *
     * @return array<string, mixed>
     */
    public static function capture(Model $model, array $relations = []): array
    {
        $record = $model->exists ? $model->fresh($relations) : null;
        if (! $record) {
            return [];
        }

        $state = self::attributes($record);
        foreach ($relations as $relation) {
            $value = $record->getRelation($relation);
            if ($value instanceof Model) {
                $state['relations'][$relation] = self::attributes($value);
            } elseif ($value !== null) {
                $rows = $value->map(static fn (Model $row): array => self::attributes($row))->all();
                usort($rows, static fn (array $left, array $right): int => serialize($left) <=> serialize($right));
                $state['relations'][$relation] = $rows;
            }
        }

        return $state;
    }

    /**
     * Retain business attributes while ignoring generated row identifiers and timestamps.
     *
     * @param Model $model
     *
     * @return array<string, mixed>
     */
    private static function attributes(Model $model): array
    {
        $attributes = $model->getAttributes();
        unset($attributes[$model->getKeyName()], $attributes[$model->getCreatedAtColumn()], $attributes[$model->getUpdatedAtColumn()]);
        if ($model->relationLoaded('pivot') && $model->getRelation('pivot') instanceof Model) {
            $attributes['pivot'] = self::attributes($model->getRelation('pivot'));
        }
        ksort($attributes);

        return $attributes;
    }
}
