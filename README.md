# Rinvex Addresses

**Rinvex Addresses** is a polymorphic Laravel package, for addressbook management. You can add addresses to any eloquent model with ease.

[![Packagist](https://img.shields.io/packagist/v/rinvex/laravel-addresses.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/rinvex/laravel-addresses)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/rinvex/laravel-addresses.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/rinvex/laravel-addresses/)
[![Travis](https://img.shields.io/travis/rinvex/laravel-addresses.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/rinvex/laravel-addresses)
[![StyleCI](https://styleci.io/repos/87485079/shield)](https://styleci.io/repos/87485079)
[![License](https://img.shields.io/packagist/l/rinvex/laravel-addresses.svg?label=License&style=flat-square)](https://github.com/rinvex/laravel-addresses/blob/develop/LICENSE)


## Installation

1. Install the package via composer:
    ```shell
    composer require rinvex/laravel-addresses
    ```

2. Publish resources (migrations and config files):
    ```shell
    php artisan rinvex:publish:addresses
    ```

3. Execute migrations via the following command:
    ```shell
    php artisan rinvex:migrate:addresses
    ```

4. Done!


## Usage

To add addresses support to your eloquent models simply use `\Rinvex\Addresses\Traits\Addressable` trait.

### Manage your addresses

```php
// Get instance of your model
$user = new \App\Models\User::find(1);

// Create a new address
$user->addresses()->create([
    'label' => 'Default Address',
    'given_name' => 'Abdelrahman',
    'family_name' => 'Omran',
    'organization' => 'Rinvex',
    'country_code' => 'eg',
    'street' => '56 john doe st.',
    'state' => 'Alexandria',
    'city' => 'Alexandria',
    'postal_code' => '21614',
    'latitude' => '31.2467601',
    'longitude' => '29.9020376',
    'is_primary' => true,
    'is_billing' => true,
    'is_shipping' => true,
]);

// Create multiple new addresses
$user->addresses()->createMany([
    [...],
    [...],
    [...],
]);

// Find an existing address
$address = app('rinvex.addresses.address')->find(1);

// Update an existing address
$address->update([
    'label' => 'Default Work Address',
]);

// Delete address
$address->delete();

// Alternative way of address deletion
$user->addresses()->where('id', 123)->first()->delete();
```

### Manage your addressable model

The API is intuitive and very straight forward, so let's give it a quick look:

```php
// Get instance of your model
$user = new \App\Models\User::find(1);

// Get attached addresses collection
$user->addresses;

// Get attached addresses query builder
$user->addresses();

// Scope Primary Addresses
$primaryAddresses = app('rinvex.addresses.address')->isPrimary()->get();

// Scope Billing Addresses
$billingAddresses = app('rinvex.addresses.address')->isBilling()->get();

// Scope Shipping Addresses
$shippingAddresses = app('rinvex.addresses.address')->isShipping()->get();

// Scope Addresses in the given country
$egyptianAddresses = app('rinvex.addresses.address')->InCountry('eg')->get();

// Find all users within 5 kilometers radius from the latitude/longitude 31.2467601/29.9020376
$fiveKmAddresses = \App\Models\User::findByDistance(5, 'kilometers', '31.2467601', '29.9020376')->get();

// Alternative method to find users within certain radius
$user = new \App\Models\User();
$users = $user->lat('31.2467601')->lng('29.9020376')->within(5, 'kilometers')->get();
```


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Chat on Slack](https://bit.ly/rinvex-slack)
- [Help on Email](mailto:help@rinvex.com)
- [Follow on Twitter](https://twitter.com/rinvex)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)


## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to [help@rinvex.com](help@rinvex.com). All security vulnerabilities will be promptly addressed.


## About Rinvex

Rinvex is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Alexandria, Egypt since June 2016. We believe that our drive The Value, The Reach, and The Impact is what differentiates us and unleash the endless possibilities of our philosophy through the power of software. We like to call it Innovation At The Speed Of Life. That’s how we do our share of advancing humanity.


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2016-2021 Rinvex LLC, Some rights reserved.
