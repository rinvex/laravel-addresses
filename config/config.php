<?php

declare(strict_types=1);

use Rinvex\Addressable\Address;

return [

    // Addressable Database Tables
    'tables' => [
        'addresses' => 'addresses',
    ],

    // Addressable Models
    'models' => [
        'address' => Address::class,
    ],

    // Addressable Geocoding Options
    'geocoding' => false,

];
