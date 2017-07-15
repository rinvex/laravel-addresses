<?php

declare(strict_types=1);

namespace Rinvex\Addressable;

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
     * @param  string $related
     * @param  string $name
     * @param  string $type
     * @param  string $id
     * @param  string $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);

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
     * Boot the addressable trait for a model.
     *
     * @return void
     */
    public static function bootAddressable()
    {
        static::deleted(function (Model $addressableModel) {
            $addressableModel->addresses()->detach();
        });
    }

    /**
     * Create the given address and attach to the addressable model.
     *
     * @param array $attributes
     *
     * @return void
     */
    public function addAddress(array $attributes)
    {
        $addressModel = config('rinvex.addressable.models.address');
        $addressInstance = (new $addressModel())->firstOrCreate($attributes);
        $this->addresses()->syncWithoutDetaching($addressInstance);
    }

    /**
     * Update the given address and attach to the addressable model.
     *
     * @param \Illuminate\Database\Eloquent\Model $address
     * @param array                               $attributes
     *
     * @return void
     */
    public function updateAddress(Model $address, array $attributes)
    {
        $address->fill($attributes)->save();
        $this->addresses()->syncWithoutDetaching($address);
    }

    /**
     * Attach the given address(s) to the addressable model.
     *
     * @param mixed $addresses
     *
     * @return void
     */
    public function attachAddresses($addresses)
    {
        $this->addresses()->syncWithoutDetaching($addresses);
    }

    /**
     * Remove the given address(s) from the addressable model.
     *
     * @param mixed $addresses
     *
     * @return void
     */
    public function detachAddresses($addresses = null)
    {
        $this->addresses()->detach($addresses);
    }

    /**
     * Remove the given address(s) from the addressable model.
     *
     * @param mixed $addresses
     *
     * @return void
     */
    public function removeAddresses($addresses = null)
    {
        $this->detachAddress($addresses);
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
        $records = (new $addressModel)->within($distance, $unit, $lat, $lng)->get();

        $results = [];
        foreach ($records as $record) {
            $results[] = $record->addressable;
        }

        return new Collection($results);
    }
}
