<?php

declare(strict_types=1);

return [

    // Manage autoload migrations
    'autoload_migrations' => true,

    // Addresses Database Tables
    'tables' => [
        'addresses' => 'addresses',
    ],

    // Addresses Models
    'models' => [
        'address' => \Rinvex\Addresses\Models\Address::class,
    ],

    // Addresses Geocoding Options
    'geocoding' => [
        'enabled' => false,
        'api_key' => env('GOOGLE_APP_KEY'),
    ],

];
