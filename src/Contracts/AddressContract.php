<?php

declare(strict_types=1);

namespace Rinvex\Addresses\Contracts;

/**
 * Rinvex\Addresses\Contracts\AddressContract.
 *
 * @property int                                                $id
 * @property int                                                $addressable_id
 * @property string                                             $addressable_type
 * @property string                                             $label
 * @property string                                             $name_prefix
 * @property string                                             $first_name
 * @property string                                             $middle_name
 * @property string                                             $last_name
 * @property string                                             $name_suffix
 * @property string                                             $organization
 * @property string                                             $country_code
 * @property string                                             $street
 * @property string                                             $state
 * @property string                                             $city
 * @property string                                             $postal_code
 * @property float                                              $lat
 * @property float                                              $lng
 * @property bool                                               $is_primary
 * @property bool                                               $is_billing
 * @property bool                                               $is_shipping
 * @property \Carbon\Carbon                                     $created_at
 * @property \Carbon\Carbon                                     $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $addressable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address inCountry($countryCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address inLanguage($languageCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address isBilling()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address isPrimary()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address isShipping()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address outside($distance, $measurement = null, $lat = null, $lng = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereAddressableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereAddressableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereIsBilling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereIsShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereNamePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereNameSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereOrganization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Addresses\Models\Address within($distance, $measurement = null, $lat = null, $lng = null)
 * @mixin \Eloquent
 */
interface AddressContract
{
    //
}
