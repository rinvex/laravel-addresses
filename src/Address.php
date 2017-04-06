<?php

declare(strict_types = 1);

namespace Rinvex\Addressable;

use Rinvex\Cacheable\CacheableEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Jackpopp\GeoDistance\GeoDistanceTrait;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Address extends Model
{
    use GeoDistanceTrait;
    use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'label',
        'name_prefix',
        'first_name',
        'middle_name',
        'last_name',
        'name_suffix',
        'country',
        'organization',
        'street',
        'state',
        'city',
        'postal_code',
        'phone',
        'lat',
        'lng',
        'is_primary',
        'is_billing',
        'is_shipping',
    ];

    /**
     * Get all attached models of the given class to the address.
     *
     * @param string $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function entries(string $class): MorphToMany
    {
        return $this->morphedByMany($class, 'addressable', config('rinvex.addressable.tables.addressables'), 'address_id', 'addressable_id');
    }

    /**
     * Scope primary addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsPrimary(Builder $query): Builder
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope billing addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsBilling(Builder $query): Builder
    {
        return $query->where('is_billing', true);
    }

    /**
     * Scope shipping addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function createAddress(Builder $query): Builder
    {
        return $query->where('is_shipping', true);
    }

    /**
     * Scope addresses by given country.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null                           $country
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInCountry(Builder $query, string $country = null): Builder
    {
        return $country ? $query->where('country', $country) : $query;
    }

    /**
     * {@inheritdoc}
     */
    public static function boot(): void
    {
        parent::boot();

        static::saving(function (self $address) {
            if (config('rinvex.addressable.geocoding')) {
                $segments[] = $address->street;
                $segments[] = sprintf('%s, %s %s', $address->city, $address->state, $address->postal_code);
                $segments[] = country($address->country)->getName();

                $query = str_replace(' ', '+', implode(', ', $segments));
                $geocode = json_decode(file_get_contents("https://maps.google.com/maps/api/geocode/json?address={$query}&sensor=false"));

                if (count($geocode->results)) {
                    $address->lat = $geocode->results[0]->geometry->location->lat;
                    $address->lng = $geocode->results[0]->geometry->location->lng;
                }
            }
        });
    }
}
