<?php

declare(strict_types=1);

namespace Rinvex\Addressable\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Addressable
{
    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    abstract public static function deleted($callback);

    /**
     * Define a polymorphic one-to-many relationship.
     *
     * @param string $related
     * @param string $name
     * @param string $type
     * @param string $id
     * @param string $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);

    /**
     * Boot the addressable trait for the model.
     *
     * @return void
     */
    public static function bootAddressable()
    {
        static::deleted(function (Model $addressableModel) {
            $addressableModel->addresses()->delete();
        });
    }

    /**
     * Get all attached addresses to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(config('rinvex.addressable.models.address'), 'addressable');
    }

    /**
     * Find addressables by distance.
     *
     * @param string $distance
     * @param string $unit
     * @param string $lat
     * @param string $lng
     *
     * @return \Illuminate\Support\Collection
     */
    public static function findByDistance($distance, $unit, $lat, $lng): Collection
    {
        $addressModel = config('rinvex.addressable.models.address');
        $records = (new $addressModel())->within($distance, $unit, $lat, $lng)->get();

        $results = [];
        foreach ($records as $record) {
            $results[] = $record->addressable;
        }

        return new Collection($results);
    }
}
