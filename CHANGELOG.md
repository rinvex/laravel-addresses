# Rinvex Addresses Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](CONTRIBUTING.md).


## [v6.1.0] - 2022-02-14
- Update composer dependencies to Laravel v9
- Fix `findByDistance` method compatibility
- Override latitude & longitude column names (fix #22)

## [v6.0.0] - 2021-08-22
- Drop PHP v7 support, and upgrade rinvex package dependencies to next major version
- Update composer dependencies
- Merge rules instead of resetting, to allow adequate model override
- Fix constructor initialization order (fill attributes should come next after merging fillables & rules)
- Set validation rules in constructor for consistency & flexibility
- Upgrade to GitHub-native Dependabot
- Enabled use of Google api key
- Utilize SoftDeletes
- Define morphMany parameters explicitly
- Simplify service provider model registration into IoC
- Enable StyleCI risky mode

## [v5.0.1] - 2020-12-25
- Add support for PHP v8

## [v5.0.0] - 2020-12-22
- Upgrade to Laravel v8
- Move custom eloquent model events to module layer from core package layer
- Refactor and tweak Eloquent Events

## [v4.1.0] - 2020-06-15
- Fix for Events namespace
- Drop using rinvex/laravel-cacheable from core packages for more flexibility
  - Caching should be handled on the application layer, not enforced from the core packages
- Drop PHP 7.2 & 7.3 support from travis

## [v4.0.6] - 2020-05-30
- Remove default indent size config
- Add strip_tags validation rule to string fields
- Specify events queue
- Explicitly specify relationship attributes
- Add strip_tags validation rule
- Explicitly define relationship name

## [v4.0.5] - 2020-04-12
- Fix ServiceProvider registerCommands method compatibility

## [v4.0.4] - 2020-04-09
- Tweak artisan command registration
- Reverse commit "Convert database int fields into bigInteger"
- Refactor publish command and allow multiple resource values

## [v4.0.3] - 2020-04-04
- Fix namespace issue

## [v4.0.2] - 2020-04-04
- Enforce consistent artisan command tag namespacing
- Enforce consistent package namespace
- Drop laravel/helpers usage as it's no longer used

## [v4.0.1] - 2020-03-20
- Convert into bigInteger database fields
- Add shortcut -f (force) for artisan publish commands
- Fix migrations path

## [v4.0.0] - 2020-03-15
- Upgrade to Laravel v7.1.x & PHP v7.4.x

## [v3.0.2] - 2020-03-13
- Tweak TravisCI config
- Add migrations autoload option to the package
- Tweak service provider `publishesResources`
- Update StyleCI config

## [v3.0.1] - 2019-12-18
- Fix `migrate:reset` args as it doesn't accept --step
- Create event classes and map them in the model

## [v3.0.0] - 2019-09-23
- Upgrade to Laravel v6 and update dependencies

## [v2.1.1] - 2019-06-03
- Enforce latest composer package versions

## [v2.1.0] - 2019-06-02
- Update composer deps
- Drop PHP 7.1 travis test
- Refactor migrations and artisan commands, and tweak service provider publishes functionality

## [v2.0.0] - 2019-03-03
- Rename environment variable QUEUE_DRIVER to QUEUE_CONNECTION
- Require PHP 7.2 & Laravel 5.8
- Apply PHPUnit 8 updates

## [v1.0.2] - 2018-12-22
- Update composer dependencies
- Add PHP 7.3 support to travis

## [v1.0.1] - 2018-10-05
- Fix wrong composer package version constraints

## [v1.0.0] - 2018-10-01
- Enforce Consistency
- Support Laravel 5.7+
- Rename package to rinvex/laravel-addresses

## [v0.0.4] - 2018-09-22
- Update travis php versions
- Define polymorphic relationship parameters explicitly
- Rename lat/lng to latitude/longitude and change database column type to decimal
- Require composer package rinvex/countries and tweak country validation rule
- Simplify address fields
- Require full name address field
- Enforce consistency
- Add soft deletes
- Drop StyleCI multi-language support (paid feature now!)
- Update composer dependencies
- Split full_name into given_name and family_name fields
- Prepare and tweak testing configuration
- Update StyleCI options
- Update PHPUnit options
- Add address model factory
- Update PHPUnit options

## [v0.0.3] - 2018-02-18
- Update supplementary files
- Update composer dependencies
- Add PublishCommand to artisan
- Add Rollback Console Command
- Add PHPUnitPrettyResultPrinter
- Require PHP v7.1.3
- Typehint method returns
- Drop useless model contracts (models already swappable through IoC)
- Add Laravel v5.6 support
- Simplify IoC binding
- Add force option to artisan commands
- Drop Laravel 5.5 support

## [v0.0.2] - 2017-09-08
- Fix many issues and apply many enhancements
- Rename package rinvex/laravel-addresses from rinvex/addressable

## v0.0.1 - 2017-04-07
- Tag first release

[v6.1.0]: https://github.com/rinvex/laravel-addresses/compare/v6.0.0...v6.1.0
[v6.0.0]: https://github.com/rinvex/laravel-addresses/compare/v5.0.1...v6.0.0
[v5.0.1]: https://github.com/rinvex/laravel-addresses/compare/v5.0.0...v5.0.1
[v5.0.0]: https://github.com/rinvex/laravel-addresses/compare/v4.1.0...v5.0.0
[v4.1.0]: https://github.com/rinvex/laravel-addresses/compare/v4.0.6...v4.1.0
[v4.0.5]: https://github.com/rinvex/laravel-addresses/compare/v4.0.4...v4.0.5
[v4.0.4]: https://github.com/rinvex/laravel-addresses/compare/v4.0.3...v4.0.4
[v4.0.3]: https://github.com/rinvex/laravel-addresses/compare/v4.0.2...v4.0.3
[v4.0.2]: https://github.com/rinvex/laravel-addresses/compare/v4.0.1...v4.0.2
[v4.0.1]: https://github.com/rinvex/laravel-addresses/compare/v4.0.0...v4.0.1
[v4.0.0]: https://github.com/rinvex/laravel-addresses/compare/v3.0.2...v4.0.0
[v3.0.2]: https://github.com/rinvex/laravel-addresses/compare/v3.0.1...v3.0.2
[v3.0.1]: https://github.com/rinvex/laravel-addresses/compare/v3.0.0...v3.0.1
[v3.0.0]: https://github.com/rinvex/laravel-addresses/compare/v2.1.1...v3.0.0
[v2.1.1]: https://github.com/rinvex/laravel-addresses/compare/v2.1.0...v2.1.1
[v2.1.0]: https://github.com/rinvex/laravel-addresses/compare/v2.0.0...v2.1.0
[v2.0.0]: https://github.com/rinvex/laravel-addresses/compare/v1.0.2...v2.0.0
[v1.0.2]: https://github.com/rinvex/laravel-addresses/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/rinvex/laravel-addresses/compare/v1.0.0...v1.0.1
[v1.0.0]: https://github.com/rinvex/laravel-addresses/compare/v0.0.4...v1.0.0
[v0.0.4]: https://github.com/rinvex/laravel-addresses/compare/v0.0.3...v0.0.4
[v0.0.3]: https://github.com/rinvex/laravel-addresses/compare/v0.0.2...v0.0.3
[v0.0.2]: https://github.com/rinvex/laravel-addresses/compare/v0.0.1...v0.0.2
