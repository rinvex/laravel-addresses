<?php

declare(strict_types=1);

namespace Rinvex\Addressable;

use Illuminate\Database\Eloquent\Model;
use Rinvex\Cacheable\CacheableEloquent;
use Illuminate\Database\Eloquent\Builder;
use Jackpopp\GeoDistance\GeoDistanceTrait;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Rinvex\Addressable\Address
 *
 * @property int                          $id
 * @property string                       $label
 * @property string                       $name_prefix
 * @property string                       $first_name
 * @property string                       $middle_name
 * @property string                       $last_name
 * @property string                       $name_suffix
 * @property string                       $organization
 * @property string                       $country_code
 * @property string                       $street
 * @property string                       $state
 * @property string                       $city
 * @property string                       $postal_code
 * @property float                        $lat
 * @property float                        $lng
 * @property bool                         $is_primary
 * @property bool                         $is_billing
 * @property bool                         $is_shipping
 * @property \Carbon\Carbon               $created_at
 * @property \Carbon\Carbon               $updated_at
 * @property string                       $deleted_at
 * @property-read \Rinvex\Country\Country $country
 *
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address inCountry($countryCode = null)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address isBilling()
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address isPrimary()
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereIsBilling($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereIsPrimary($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereIsShipping($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereLng($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereMiddleName($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereNamePrefix($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereNameSuffix($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereOrganization($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address wherePostalCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\Rinvex\Addressable\Address whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        'organization',
        'country_code',
        'street',
        'state',
        'city',
        'postal_code',
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
     * Scope addresses by the given country.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null                           $countryCode
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInCountry(Builder $query, string $countryCode = null): Builder
    {
        return $countryCode ? $query->where('country_code', $countryCode) : $query;
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
                $segments[] = country($address->country_code)->getName();

                $query = str_replace(' ', '+', implode(', ', $segments));
                $geocode = json_decode(file_get_contents("https://maps.google.com/maps/api/geocode/json?address={$query}&sensor=false"));

                if (count($geocode->results)) {
                    $address->lat = $geocode->results[0]->geometry->location->lat;
                    $address->lng = $geocode->results[0]->geometry->location->lng;
                }
            }
        });
    }

    /**
     * Get the address' country.
     *
     * @return \Rinvex\Country\Country
     */
    public function getCountryAttribute()
    {
        return country($this->country_code);
    }
}
