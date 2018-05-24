<?php

namespace Scrn\Journal\Concerns;

use Illuminate\Database\Eloquent\Model;

trait LogsRelatedActivity
{
    /**
     * Boot the logs activity trait for a model.
     *
     * @return void
     */
    public static function bootLogsRelatedActivity()
    {
        if (!in_array('Fico7489\Laravel\Pivot\Traits\PivotEventTrait', class_uses_recursive(static::class))) {
            return;
        }

        foreach (['pivotAttaching', 'pivotDetaching', 'pivotUpdating'] as $event) {
            static::registerModelEvent($event, function (Model $model, $relation) use ($event) {
                $model->syncOriginalRelation($relation);
            });
        }
    }

    /**
     * Get the attributes for the pivot attached event.
     *
     * @param Model $model
     * @param $relation
     * @return array
     */
    public function getPivotAttachedEventAttributes(Model $model, $relation, $ids): array
    {
        $old = [
            $relation => $this->getOriginalRelation($relation)->pluck('pivot'),
        ];
        $new = [
            $relation => $this->getRelationshipFromMethod($relation)->pluck('pivot'),
        ];

        return [
            $old,
            $new,
        ];
    }

    /**
     * Get the attributes for the pivot detached event.
     *
     * @param Model $model
     * @param $relation
     * @return array
     */
    public function getPivotDetachedEventAttributes(Model $model, $relation, $ids): array
    {
        $old = [
            $relation => $this->getOriginalRelation($relation)->pluck('pivot'),
        ];
        $new = [
            $relation => $this->getRelationshipFromMethod($relation)->pluck('pivot'),
        ];

        return [
            $old,
            $new,
        ];
    }

    /**
     * Get the attributes for the pivot updated event.
     *
     * @param Model $model
     * @param $relation
     * @return array
     */
    public function getPivotUpdatedEventAttributes(Model $model, $relation, $ids): array
    {
        $old = [
            $relation => $this->getOriginalRelation($relation)->pluck('pivot'),
        ];
        $new = [
            $relation => $this->getRelationshipFromMethod($relation)->pluck('pivot'),
        ];

        return [
            $old,
            $new,
        ];
    }
}
