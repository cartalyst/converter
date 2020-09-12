### Currency

Currency conversion requires an exchanger to fetch currency rates from a third party.

#### Default Exchangers

By default the native exchanger is used, which will fall back to the regular config values, you can define these units under your config file, if no unit is defined, the exchanger defaults to 1.

We have built-in support for two exchangers out of the box.

##### Native Exchanger

It defaults to user defined measurements configurations

    'measurements' => array(

        'currency' => array(

            'usd' => array(
                'format' => '$1,0.00',
                'unit'   => 1
            ),

            'eur' => array(
                'format' => '&euro;1,0.00',
                'unit'   => 1.2
            ),

        ),
    )

> **Note:** If you're using Laravel 6, define the units on your config file.

##### [OpenExchangeRates.org Exchanger](https://openexchangerates.org)

It utilizes `illuminate/cache` to cache the currency results for a configurable amount of time.

    <?php

    use Cartalyst\Converter\Converter;
    use Cartalyst\Converter\Exchangers\OpenExchangeRatesExchanger;
    use Illuminate\Cache\CacheManager;
    use Illuminate\Filesystem\Filesystem;

    // Setup the Illuminate cache
    $cache = new CacheManager(app());

    // Create the exchanger
    $exchanger = new OpenExchangeRatesExchanger($cache);

    // Set app id
    $exchanger->setAppId('your_app_id');

    // Set cache expiration duration in minutes
    $exchanger->setExpires(60);

    // Create a new converter instance
    $converter = new Converter($exchanger);

    // Convert a currency from USD to EUR
    $value = $converter->from('currency.usd')->to('currency.eur')->convert(200)->format();

> **Note:** If you're using Laravel 6, you only need to modify your config file and set your `app_id` and switch the default exchanger to `openexchangerates` and you're ready to go, just use the facade.

#### Custom Exchangers

You can create your own exchanger by creating a class that implements the `Cartalyst\Converter\Exchangers\ExchangerInterface`.

    <?php

    use Cartalyst\Converter\Exchangers\ExchangerInterface;

    class CustomExchanger implements ExchangerInterface {

        /**
         * Return the exchange rate for the provided currency code.
         *
         * @param  string  $code
         * @return float
         */
        public function get($code)
        {
            // Your logic to retrieve the value based on the currency code
            return 1;
        }

    }

To use your new exchanger simply pass it as a parameter to the Converter instance.

> **Note:** If you're using Laravel 6, you can bind your new exchanger into the container as converter.{exchanger_name}.exchanger and switch the default exchanger on your config file to match your exchanger name, and simply use the facade.
