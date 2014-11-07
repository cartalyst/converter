## Usage

In this section we'll show you how to use the converter package.

### Measurements

The measurements are the crucial part of the package

#### Get the measurements

This will return an array containing all the available measurements.

```php
$measurements = Converter::getMeasurements();
```

#### Set the measurements

Setting new measurements is simple and easy, you just need to provide a multidimensional array.

You have two ways of setting measurements, `runtime` or through the `config` file.

###### Runtime

```php
Converter::setMeasurements(array(

	'weight' => array(

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
```

###### Config

Open the file located at `app/config/packages/cartalyst/converter/config.php` and add your new measurements.

### Formatting

We have a robust way of formatting measurements, please read along

You can place any currency symbol or text at the beginning or end of the format.

The first character `,` in the case above represents the thousands separator, the second one represents the decimals separator, digits after the second separator represent the number of decimals you want to show.

If you want to have only a decimal separator, you have to override the first separator using an `!`

Ex. a value of `2000.5` with the format `'0!0.00 KG'` would output `2000.50 KG`.


#### Format a unit

```php
$value = Converter::to('weight.lb')->value(200000)->format();

>>> 200,000 lb
```

#### Custom Formatting

```php
$value = Converter::to('weight.lb')->value(200000)->format('1,0.00 Pounds');

>>> 200,000.00 Pounds
```

#### Negative Formats

Negative numbers are formatted according to the regular format by default, if you need to override the format for negative values, just provide a 'negative' property that defines your negative format.

**Example**

```php
'currency' => array(

	'usd' => array(
		'format'   => '$1,0.00',
		'negative' => '($1,0.00)'.
	),

),
```

### Convertions

We have a very simple way of converting a `measurement` to another.

#### Converting from a unit to another

```php
$value = Converter::from('weight.g')->to('weight.lb')->convert(200000)->format();

>>> 441 lb
```

#### Retrieve a converted unit value

```php
$value = Converter::from('weight.g')->to('weight.lb')->convert(200000)->getValue();

>>> 440.924
```
