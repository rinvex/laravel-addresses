<?php

declare(strict_types=1);

namespace Rinvex\Addresses\Models;

use Illuminate\Database\Eloquent\Model;
use Rinvex\Cacheable\CacheableEloquent;
use Illuminate\Database\Eloquent\Builder;
use Jackpopp\GeoDistance\GeoDistanceTrait;
use Rinvex\Support\Traits\ValidatingTrait;
use Rinvex\Addresses\Events\AddressSaved;
use Rinvex\Addresses\Events\AddressDeleted;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Rinvex\Addresses\Models\Address.
 *
 * @property int                                                $id
 * @property int                                                $addressable_id
 * @property string                                             $addressable_type
 * @property string                                             $label
 * @property string                                             $given_name
 * @property string                                             $family_name
 * @property string                                             $full_name
 * @property string                                             $organization
 * @property string                                             $country_code
 * @property string                                             $street
 * @property string                                             $state
 * @property string                                             $city
 * @property string                                             $postal_code
 * @property float                                              $latitude
 * @property float                                              $longitude
 * @property bool                                               $is_primary
 * @property bool                                               $is_billing
 * @property bool                                               $is_shipping
 * @property \Carbon\Carbon|null                                $created_at
 * @property \Carbon\Carbon|null                                $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $addressable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address inCountry($countryCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address inLanguage($languageCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address isBilling()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address isPrimary()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address isShipping()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address outside($distance, $measurement = null, $latitude = null, $longitude = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereAddressableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereAddressableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereFamilyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereGivenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereIsBilling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereIsShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereOrganization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address within($distance, $measurement = null, $latitude = null, $longitude = null)
 * @mixin \Eloquent
 */
class Address extends Model
{
    use ValidatingTrait;
    use GeoDistanceTrait;
    use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'label',
        'given_name',
        'family_name',
        'organization',
        'country_code',
        'street',
        'state',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'is_primary',
        'is_billing',
        'is_shipping',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'addressable_id' => 'integer',
        'addressable_type' => 'string',
        'label' => 'string',
        'given_name' => 'string',
        'family_name' => 'string',
        'organization' => 'string',
        'country_code' => 'string',
        'street' => 'string',
        'state' => 'string',
        'city' => 'string',
        'postal_code' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
        'is_primary' => 'boolean',
        'is_billing' => 'boolean',
        'is_shipping' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => AddressSaved::class,
        'deleted' => AddressDeleted::class,
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'addressable_id' => 'required|integer',
        'addressable_type' => 'required|string|max:150',
        'label' => 'nullable|string|max:150',
        'given_name' => 'required|string|max:150',
        'family_name' => 'nullable|string|max:150',
        'organization' => 'nullable|string|max:150',
        'country_code' => 'nullable|alpha|size:2|country',
        'street' => 'nullable|string|max:150',
        'state' => 'nullable|string|max:150',
        'city' => 'nullable|string|max:150',
        'postal_code' => 'nullable|string|max:150',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'is_primary' => 'sometimes|boolean',
        'is_billing' => 'sometimes|boolean',
        'is_shipping' => 'sometimes|boolean',
    ];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('rinvex.addresses.tables.addresses'));
    }

    /**
     * Get the owner model of the address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo('addressable', 'addressable_type', 'addressable_id');
    }

    /**
     * Scope primary addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsPrimary(Builder $builder): Builder
    {
        return $builder->where('is_primary', true);
    }

    /**
     * Scope billing addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsBilling(Builder $builder): Builder
    {
        return $builder->where('is_billing', true);
    }

    /**
     * Scope shipping addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsShipping(Builder $builder): Builder
    {
        return $builder->where('is_shipping', true);
    }

    /**
     * Scope addresses by the given country.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string                                $countryCode
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInCountry(Builder $builder, string $countryCode): Builder
    {
        return $builder->where('country_code', $countryCode);
    }

    /**
     * Scope addresses by the given language.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string                                $languageCode
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInLanguage(Builder $builder, string $languageCode): Builder
    {
        return $builder->where('language_code', $languageCode);
    }

    /**
     * Get full name attribute.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return implode(' ', [$this->given_name, $this->family_name]);
    }

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $address) {
            if (config('rinvex.addresses.geocoding')) {
                $segments[] = $address->street;
                $segments[] = sprintf('%s, %s %s', $address->city, $address->state, $address->postal_code);
                $segments[] = country($address->country_code)->getName();

                $query = str_replace(' ', '+', implode(', ', $segments));
                $geocode = json_decode(file_get_contents("https://maps.google.com/maps/api/geocode/json?address={$query}&sensor=false"));

                if (count($geocode->results)) {
                    $address->latitude = $geocode->results[0]->geometry->location->lat;
                    $address->longitude = $geocode->results[0]->geometry->location->lng;
                }
            }
        });
    }
}
