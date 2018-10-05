# Rinvex Addresses Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](CONTRIBUTING.md).


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

[v1.0.0]: https://github.com/rinvex/laravel-addresses/compare/v0.0.4...v1.0.0
[v0.0.4]: https://github.com/rinvex/laravel-addresses/compare/v0.0.3...v0.0.4
[v0.0.3]: https://github.com/rinvex/laravel-addresses/compare/v0.0.2...v0.0.3
[v0.0.2]: https://github.com/rinvex/laravel-addresses/compare/v0.0.1...v0.0.2
