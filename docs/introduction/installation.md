# Installation

The best way to install the Converter package is quickly and easily done with [Composer](http://getcomposer.org).

Open your `composer.json` and add the following to the `require` array

	"cartalyst/converter": "1.0.*"

Add the following lines after the `require` array on your `composer.json` file

	"repositories": [
		{
			"type": "composer",
			"url": "http://packages.cartalyst.com"
		}
	]

> **Note:** Make sure your `composer.json` file is in a valid JSON format after the required changes.

### Install the dependencies

Run Composer to install or update the new requirement.

	php composer install

or

	php composer update

Now you are able to require the `vendor/autoload.php` file to PSR-0 autoload the library.

## Example

	// Include the composer autoload file
	require_once 'vendor/autoload.php';

	// Import the necessary classes
	use Cartalyst\Converter\Converter;
	use Cartalyst\Converter\Exchangers\NativeExchanger;

	// Require the converter config file
	$config = require_once 'vendor/cartalyst/converter/src/config/config.php';

	// Instantiate the converter and set the necessary configuration
	$converter = new Converter(new NativeExchanger);
	$converter->setMeasurements($config['measurements']);

	// Convert kilometers to meters
	$meters = $converter->value(200)->from('length.m')->to('length.cm')->convert()->format();

The package also has optional Laravel 4 support. The integration into the framework is done in seconds.

Read more about the [Laravel 4 integration]({url}/introduction/laravel-4).
