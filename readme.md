# Converter v1.0.0

[![Build Status](http://ci.cartalyst.com/build-status/svg/4)](http://ci.cartalyst.com/build-status/view/4)

A framework agnostic measurement conversion and formatting package featuring multiple types of measurements and currency conversion.

The package follows the FIG standard PSR-4 to ensure a high level of interoperability between shared PHP code and is fully unit-tested with 100% code coverage.

Part of the Cartalyst Arsenal & licensed [Cartalyst PSL](license.txt). Code well, rock on.

## Package Story

History and future capabilities.

### Complete

#### 09-May-14 - v1.0.0

- ```Converter::getMeasurements()``` Returns all the available measurements.
- ```Converter::setMeasurements($measurements)``` Sets measurements.
- ```Converter::getMeasurement($measurement)``` Returns information about the given measurement.
- ```Converter::from($measurement)``` Sets the measurement he wants to convert from.
- ```Converter::getFrom()``` Returns the measurement he wants to convert from.
- ```Converter::to($measurement)``` Sets the measurement he wants to convert to.
- ```Converter::getTo()``` Returns the measurement he wants to convert to.
- ```Converter::value($value)``` Sets the value he wants to convert.
- ```Converter::getValue()``` Returns the value he wants to convert.
- ```Converter::convert($value|null)``` Convert the given `$value` or the value that was previously set.
- ```Converter::format($format|null)``` Format the value using the given `$format` or using the default format.

## Requirements

- PHP >=5.3

## Installation

Converter is installable with Composer. Read further information on how to install.

[Installation Guide](https://cartalyst.com/manual/converter#installation)

## Documentation

Refer to the following guide on how to use the Converter package.

[Documentation](https://cartalyst.com/manual/converter)

## Versioning

We version under the [Semantic Versioning](http://semver.org/) guidelines as much as possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New additions without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes and misc changes bumps the patch

## Contributing

Please read the [Contributing](contributing.md) guidelines.

## Support

Have a bug? Please create an [issue](https://github.com/cartalyst/converter/issues) here on GitHub that conforms with [necolas's guidelines](https://github.com/necolas/issue-guidelines).

Follow us on Twitter, [@cartalyst](http://twitter.com/cartalyst).

Join us for a chat on IRC.

Server: irc.freenode.net
Channel: #cartalyst

Email: help@cartalyst.com
