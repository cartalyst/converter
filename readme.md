# Converter v1.0.0

A framework agnostic measurement conversion and formatting package featuring multiple types of measurements and currency conversion.

The package follows the FIG standard PSR-4 to ensure a high level of interoperability between shared PHP code and is fully unit-tested with 100% code coverage.

Part of the Cartalyst Arsenal & licensed [Cartalyst PSL](license.txt). Code well, rock on.

## Package Story

History and future capabilities.

### Complete

#### 16-Feb-14 - v1.0.0

- ```Converter::getMeasurements()``` User can return all the available measurements.
- ```Converter::setMeasurements($measurements)``` User can set measurements.
- ```Converter::getMeasurement($measurement)``` User can return information about the given measurement.
- ```Converter::from($measurement)``` User can set the measurement he wants to convert from.
- ```Converter::getFrom()``` User can return the measurement he wants to convert from.
- ```Converter::to($measurement)``` User can set the measurement he wants to convert to.
- ```Converter::getTo()``` User can return the measurement he wants to convert to.
- ```Converter::value($value)``` User can set the value he wants to convert.
- ```Converter::getValue()``` User can return the value he wants to convert.
- ```Converter::convert($value|null)``` User can convert the given `$value` or the value that was previously set.
- ```Converter::format($format|null)``` User can format the value using the given `$format` or using the default format.

## Requirements

- PHP >=5.3

## Installation

Converter is installable with Composer. Read further information on how to install.

[Installation Guide](http://cartalyst.com/manual/converter/introduction/installation)

## Documentation

Refer to the following guide on how to use the Converter package.

[Documentation](http://cartalyst.com/manual/converter)

## Versioning

We version under the [Semantic Versioning](http://semver.org/) guidelines as much as possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New additions without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes and misc changes bumps the patch

## Support

Have a bug? Please create an issue here on GitHub that conforms with [necolas's guidelines](https://github.com/necolas/issue-guidelines).

https://github.com/cartalyst/converter/issues

Follow us on Twitter, [@cartalyst](http://twitter.com/cartalyst).

Join us for a chat on IRC.

Server: irc.freenode.net
Channel: #cartalyst
