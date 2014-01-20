# Overview

## Getting Measurements {#retrieve-measurements}

This returns all the available measurements.

	$measurements = Converter::getMeasurements();

## Setting Measurements {#set-measurements}

	Converter::setMeasurements(array(

		'weights' => array(

			'kg' => array(
				'format' => '1,0.00 KG',
				'unit'   => '1.00',
			),

			'g' => array(
				'format' => '(1,0.00 grams)',
				'unit'   => 1000.00,
			),

			'lb' => array(
				'format' => '1,0.00 lb',
				'unit'   => 2.20462,
			),

		),

	));

You can set your measurements at runtime as shown above or you can add your
required measurements directly on the `app/config/packages/cartalyst/converter/config.php`

> **Note**: Passing a boolean of `false` as the second parameter will not merge
the current measurements with the given measurements.

### How the format works

You can place any currency symbol or text at the beginning or end of the format.

The first character `,` in the case above represents the thousands separator, the
second one represents the decimals separator, digits after the second separator
represent the number of decimals you want to show.

If you want to have only a decimal separator, you have to override the first separator using an `!`

Ex. a value of 2000.5 with the format '0!0.00 KG' would output 2000.50 KG.

### Negative Formats {#negative-formats}

Negative numbers are formatted according to the regular format by default, if you need to override the format for negative values, just provide a 'negative' property that defines your negative format.

Example

	'currency' => array(

		'usd' => array(
			'format'   => '$1,0.00',
			'negative' => '($1,0.00)'.
		),

	),

## Formatting from a unit to another {#format-units}

	Converter::value(200000)->from('weights.g')->to('weights.lb')->format();

## Custom Formatting {#custom-formatting}

	Converter::value(200000)->from('weights.g')->to('weights.lb')->convert()->format('1,0.00 Pounds');

## Converting from a unit to another {#convert-units}

	Converter::value(200000)->from('weights.g')->to('weights.lb')->convert()->format();

## Retrieve a converted value {#retrieve-value}

	Converter::value(200000)->from('weights.g')->to('weights.lb')->convert()->getValue();
