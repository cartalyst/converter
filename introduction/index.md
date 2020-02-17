## Introduction

A framework agnostic measurement conversion and formatting package featuring multiple types of measurements and currency conversion.

The package requires PHP 7.2.5+ and comes bundled with a Laravel 7 Facade and a Service Provider to simplify the optional framework integration and follows the FIG standard PSR-4 to ensure a high level of interoperability between shared PHP code and is fully unit-tested.

Have a [read through the Installation Guide](#installation) and on how to [Integrate it with Laravel 7](#laravel-7).

###### Convert and Format meters to centimeters

```php
$value = Converter::from('length.m')->to('length.cm')->convert(200)->format();

>>> 20000 centimeters
```
