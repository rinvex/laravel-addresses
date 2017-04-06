<?php

declare(strict_types = 1);

namespace Rinvex\Addressable;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Addressable
{
    /**
     * Register a created model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    abstract public static function created($callback);

    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    abstract public static function deleted($callback);

    /**
     * Define a polymorphic many-to-many relationship.
     *
     * @param string      $related
     * @param string      $name
     * @param string|null $table
     * @param string|null $foreignKey
     * @param string|null $otherKey
     * @param bool        $inverse
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    abstract public function morphToMany($related, $name, $table = null, $foreignKey = null, $otherKey = null, $inverse = false);

    /**
     * Get address class name.
     *
     * @return string
     */
    public static function getAddressClassName(): string
    {
        return Address::class;
    }

    /**
     * Get all attached addresses to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function addresses(): MorphToMany
    {
        return $this->morphToMany(static::getAddressClassName(), 'addressable', config('rinvex.addressable.tables.addressables'), 'addressable_id', 'address_id')->withTimestamps();
    }

    /**
     * Boot Addressable trait.
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
     * Create the given address and attach to the addressable model.
     *
     * @param array $attributes
     *
     * @return void
     */
    public function addAddress(array $attributes)
    {
        $addressModel = static::getAddressClassName();
        $addressInstance = (new $addressModel)->firstOrCreate($attributes);
        $this->addresses()->syncWithoutDetaching($addressInstance);
    }

    /**
     * Update the given address and attach to the addressable model.
     *
     * @param int|\Illuminate\Database\Eloquent\Model $address
     * @param array                                   $attributes
     *
     * @return void
     */
    public function updateAddress($address, array $attributes)
    {
        $addressModel = static::getAddressClassName();
        $addressInstance = $address instanceof Model ? $address : (new $addressModel)->findOrFail($address);
        $addressInstance->update($attributes);
        $this->addresses()->syncWithoutDetaching($addressInstance);
    }

    /**
     * Attach the given address(es) to the addressable model.
     *
     * @param mixed $address
     *
     * @return void
     */
    public function attachAddress($addresses)
    {
        $this->addresses()->syncWithoutDetaching($addresses);
    }

    /**
     * Remove the given address from the addressable model.
     *
     * @param mixed $address
     *
     * @return void
     */
    public function detachAddress($address)
    {
        $this->addresses()->detach($address);
    }

    /**
     * Remove the given address from the addressable model.
     *
     * @param mixed $address
     *
     * @return void
     */
    public function removeAddress($address)
    {
        $this->detachAddress($address);
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
        $records = Address::within($distance, $unit, $lat, $lng)->get();

        $results = [];
        foreach ($records as $record) {
            $results[] = $record->addressable;
        }

        return new Collection($results);
    }
}
