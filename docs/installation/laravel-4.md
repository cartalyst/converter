## Install & Configure in Laravel 4

> **Note:** To use Cartalyst's Measures package you need to have a valid Cartalyst.com subscription.
Click [here](https://www.cartalyst.com/pricing) to obtain your subscription.

### 1. Composer {#composer}

----

Open your `composer.json` file and add the following lines:

	{
		"repositories": [
			{
				"type": "composer",
				"url": "http://packages.cartalyst.com"
			}
		],
		"require": {
			"cartalyst/measures": "1.0.*",
		},
	}

Run composer update from the command line

	composer update


### 2. Migrations {#migrations}

----

In order to run the migration successfully, you need to have a default database connection setup on your Laravel 4 application, once you have that setup, you can run the following command:

	php artisan migrate --package=cartalyst/measures
