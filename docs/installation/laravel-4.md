# Install & Configure in Laravel 4

> **Note:** To use Cartalyst's Converter package you need to have a valid Cartalyst.com subscription.
Click [here](https://www.cartalyst.com/pricing) to obtain your subscription.

## Composer {#composer}

Open your `composer.json` file and add the following lines

	{
		"require": {
			"cartalyst/converter": "1.0.*",
		},
		"repositories": [
			{
				"type": "composer",
				"url": "http://packages.cartalyst.com"
			}
		],
		"minimum-stability": "dev"
	}

> **Note:** The minimum-stability key must be set to dev so that you can use the package (which isn't marked as stable, yet).

Run composer update from the command line

	composer update

## Service Provider {#service-provider}

Add the following to the list of service providers in `app/config/app.php`.

	'Cartalyst\Converter\Laravel\ConverterServiceProvider',

## Alias {#alias}

	'Converter' => 'Cartalyst\Converter\Laravel\Facades\Converter',

## Configuration {#configuration}

After installing, you can publish the package's configuration file into your application, by running the following command:

	php artisan config:publish cartalyst/converter

This will publish the config file to `app/config/packages/cartalyst/converter/config.php` where you can modify the package configuration.
