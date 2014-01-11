# Introduction

A framework agnostic measurement conversion and formatting package featuring multiple types of measurements and currency conversion.

The package follows the FIG standard PSR-0 to ensure a high level of
interoperability between shared PHP code and is fully unit-tested.

## Getting started

The package requires at least PHP version 5.3 and comes with a Laravel 4 Facade
and a Service Provider to simplify the optional framework integration.

Have a [read through the Installation Guide]({url}/introduction/installation) and
on how to [Integrate it with Laravel 4]({url}/introduction/laravel-4).

## Quick Example

	// Convert meters to centimeters
	Converter::value(200)->from('length.m')->to('length.cm')->convert()->format();
