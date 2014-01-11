# Laravel 4 Integration

The Converter package has optional support for Laravel 4 and it comes bundled with a
Service Provider and a Facade for easier integration.

After you have installed the package correctly, just follow the instructions.

Open your Laravel config file `app/config/app.php` and add the following lines.

In the `$providers` array add the following service provider for this package.

	'Cartalyst\Converter\Laravel\ConverterServiceProvider',

In the `$aliases` array add the following facade for this package.

	'Converter' => 'Cartalyst\Converter\Laravel\Facades\Converter',

## Configuration {#configuration}

After installing, you can publish the package's configuration file into your
application by running the following command:

	php artisan config:publish cartalyst/converter

This will publish the config file to `app/config/packages/cartalyst/converter/config.php`
where you can modify the package configuration.
