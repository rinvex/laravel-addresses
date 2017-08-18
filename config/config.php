<?php

declare(strict_types=1);

return [

    // Addressable Database Tables
    'tables' => [
        'addresses' => 'addresses',
    ],

    // Addressable Models
    'models' => [
        'address' => \Rinvex\Addressable\Models\Address::class,
    ],

    // Addressable Geocoding Options
    'geocoding' => false,

];
