<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(Rinvex\Addresses\Models\Address::class, function (Faker $faker) {
    return [
        'addressable_type' => $faker->randomElement(['App\Models\Company', 'App\Models\Product', 'App\Models\User']),
        'addressable_id' => $faker->randomNumber(),
        'label' => $faker->title,
        'given_name' => $faker->firstName,
        'family_name' => $faker->lastName,
        'organization' => $faker->company,
        'country_code' => $faker->countryCode,
        'street' => $faker->address,
        'state' => $faker->city,
        'city' => $faker->city,
        'postal_code' => $faker->postcode,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'is_primary' => $faker->boolean,
        'is_billing' => $faker->boolean,
        'is_shipping' => $faker->boolean,
    ];
});
