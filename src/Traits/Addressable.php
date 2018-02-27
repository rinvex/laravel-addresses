<?php

declare(strict_types=1);

namespace Rinvex\Addresses\Traits;

use Illuminate\Support\Collection;
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
        static::deleted(function (self $model) {
            $model->addresses()->delete();
        });
    }

    /**
     * Get all attached addresses to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(config('rinvex.addresses.models.address'), 'addressable');
    }

    /**
     * Find addressables by distance.
     *
     * @param string $distance
     * @param string $unit
     * @param string $latitude
     * @param string $longitude
     *
     * @return \Illuminate\Support\Collection
     */
    public static function findByDistance($distance, $unit, $latitude, $longitude): Collection
    {
        $addressModel = config('rinvex.addresses.models.address');
        $records = (new $addressModel())->within($distance, $unit, $latitude, $longitude)->get();

        $results = [];
        foreach ($records as $record) {
            $results[] = $record->addressable;
        }

        return new Collection($results);
    }
}
