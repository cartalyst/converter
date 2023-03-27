## Integration

Cartalyst packages are framework agnostic and as such can be integrated easily natively or with your favorite framework.

### Laravel 10

The Converter package has optional support for Laravel 10 and it comes bundled with a Service Provider and a Facade for easy integration.

After installing the package, open your Laravel config file located at `config/app.php` and add the following lines.

In the `$providers` array add the following service provider for this package.

```php
'Cartalyst\Converter\Laravel\ConverterServiceProvider',
```

In the `$aliases` array add the following facade for this package.

```php
'Converter' => 'Cartalyst\Converter\Laravel\Facades\Converter',
```

#### Configuration

After installing, you can publish the package configuration file into your application by running the following command on your terminal:

    php artisan vendor:publish

This will publish the config file to `config/cartalyst.converter.php` where you can modify the package configuration.

### Native

Integrating the package outside of a framework is incredible easy, just follow the example below.

```php
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
```

The integration is done and you can now use all the available methods, here's an example:

```php
// Convert meters to centimeters
$value = $converter->from('length.m')->to('length.cm')->convert(200)->format();
```
