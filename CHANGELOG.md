# Converter Change Log

This project follows [Semantic Versioning](CONTRIBUTING.md).

## Proposals

We do not give estimated times for completion on `Accepted` Proposals.

- [Accepted](https://github.com/cartalyst/converter/labels/Accepted)
- [Rejected](https://github.com/cartalyst/converter/labels/Rejected)

---

#### v2.0.3 - 2015-12-18

`FIXED`

- Issue when passing values as 0 (zero) it was not being properly evaluated.

#### v2.0.2 - 2015-04-17

`UPDATED`

- Updated to Guzzle 5 to remove deprecated warnings during installation through Composer.

#### v2.0.1 - 2015-04-15

`FIXED`

- Fix typo on Service Provider.

#### v2.0.0 - 2015-03-06

`ADDED`

- Laravel 5 support.

`REMOVED`

- Laravel 4 support.

#### v1.1.3 - 2015-04-17

`UPDATED`

- Updated to Guzzle 5 to remove deprecated warnings during installation through Composer.

#### v1.1.2 - 2015-03-06

`REVISED`

- Updated coding standards to `PSR-2`.
- Bumped PHPUnit version to `~4.5`.

`REMOVED`

- Remove Laravel 5 requirement, support for Laravel 5 will come from on the `2.0` release version.

#### v1.1.1 - 2014-09-23

`REVISED`

- Loosen requirements to allow the usage on Laravel 5.0.

#### v1.1.0 - 2014-08-16

`UPDATED`

- Base lengths are using `meters` instead of `kilometers`.
 Added some more common units `mile`, `feet` and `inch`.
- Some unit formats updated in the config to use abbreviations so it's more consistent with the International System of Units.

#### v1.0.3 - 2015-04-17

`UPDATED`

- Updated to Guzzle 5 to remove deprecated warnings during installation through Composer.

#### v1.0.2 - 2015-03-06

`REVISED`

- Updated coding standards to `PSR-2`.
- Bumped PHPUnit version to `~4.5`.

`REMOVED`

- Remove Laravel 5 requirement, support for Laravel 5 will come from on the `2.0` release version.

#### v1.0.1 - 2014-09-23

`REVISED`

- Loosen requirements to allow the usage on Laravel 5.0.

#### v1.0.0 - 2014-05-09

`INIT`

- Can return all the available measurements.
- Can set new measurements.
- Can return information about a given measurement.
- Can set the measurement to be converted from.
- Can return the measurement to be converted from.
- Can set the measurement to convert to.
- Can return the measurement to convert to.
- Can set the value to be converted.
- Can return the value to be converted.
- Can convert a given value or a value that was previously set.
- Can format the value using a given format or by using a default format.
