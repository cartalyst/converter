<h2>Introduction</h2>

<p>A framework agnostic measurement conversion and formatting package featuring multiple types of measurements and currency conversion.</p>

<p>The package requires PHP 5.3+ and comes bundled with a Laravel 4 and Laravel 5 Facade and a Service Provider to simplify the optional framework integration and follows the FIG standard PSR-4 to ensure a high level of interoperability between shared PHP code and is fully unit-tested.</p>

<p>Have a <a href="#installation">read through the Installation Guide</a> and on how to <a href="#laravel-4">Integrate it with Laravel 4</a> or <a href="#laravel-5">Integrate it with Laravel 5</a>.</p>

<h6>Convert and Format meters to centimeters</h6>

<pre class="prettyprint lang-php"><code>$value = Converter::from('length.m')-&gt;to('length.cm')-&gt;convert(200)-&gt;format();

&gt;&gt;&gt; 20000 centimeters
</code></pre><h3>Upgrade Guide</h3>

<p>Please refer to the following guides to update your Converter installation to the 1.1 version.</p>

<h4>Upgrading To 1.1 From 1.0</h4>

<p>The main and only required change is on the configuration file where we:</p>

<ul>
<li>Changed the base lenghts to use meters instead of kilometers</li>
<li>Added some more common units like <code>mile</code>, <code>feet</code> and <code>inch</code>.</li>
<li>Updated some units use abbreviations so it's more consistent with the International System of Units.</li>
</ul>

<p>To update just you just need to run <code>php artisan config:publish cartalyst/converter</code>.</p>

<blockquote>
<p><strong>Note:</strong> If you have custom units, please create a backup of the <code>app/config/packages/cartalyst/converter/config.php</code> file before executing the command above.</p>
</blockquote><h3>Installation</h3>

<p>The best and easiest way to install the Converter package is with <a href="http://getcomposer.org">Composer</a>.</p>

<h4>Preparation</h4>

<p>Open your <code>composer.json</code> and add the following to the <code>require</code> array:</p>

<pre><code>"cartalyst/converter": "1.1.*"
</code></pre>

<p>Add the following lines after the <code>require</code> array on your <code>composer.json</code> file:</p>

<pre><code>"repositories": [
    {
        "type": "composer",
        "url": "https://packages.cartalyst.com"
    }
]
</code></pre>

<blockquote>
<p><strong>Note:</strong> Make sure that after the required changes your <code>composer.json</code> file is valid by running <code>composer validate</code>.</p>
</blockquote>

<h4>Install the dependencies</h4>

<p>Run Composer to install or update the new requirement.</p>

<pre><code>php composer install
</code></pre>

<p>or</p>

<pre><code>php composer update
</code></pre>

<p>Now you are able to require the <code>vendor/autoload.php</code> file to autoload the package.</p><h2>Integration</h2>

<p>Cartalyst packages are framework agnostic and as such can be integrated easily natively or with your favorite framework.</p>

<h3>Laravel 4</h3>

<p>The Converter package has optional support for Laravel 4 and it comes bundled with a Service Provider and a Facade for easy integration.</p>

<p>After installing the package, open your Laravel config file located at <code>app/config/app.php</code> and add the following lines.</p>

<p>In the <code>$providers</code> array add the following service provider for this package.</p>

<pre class="prettyprint lang-php"><code>'Cartalyst\Converter\Laravel\ConverterServiceProvider',
</code></pre>

<p>In the <code>$aliases</code> array add the following facade for this package.</p>

<pre class="prettyprint lang-php"><code>'Converter' =&gt; 'Cartalyst\Converter\Laravel\Facades\Converter',
</code></pre>

<h4>Configuration</h4>

<p>After installing, you can publish the package configuration file into your application by running the following command on your terminal:</p>

<pre><code>php artisan config:publish cartalyst/converter
</code></pre>

<p>This will publish the config file to <code>app/config/packages/cartalyst/converter/config.php</code> where you can modify the package configuration.</p>

<h3>Laravel 5</h3>

<p>The Converter package has optional support for Laravel 5 and it comes bundled with a Service Provider and a Facade for easy integration.</p>

<p>After installing the package, open your Laravel config file located at <code>config/app.php</code> and add the following lines.</p>

<p>In the <code>$providers</code> array add the following service provider for this package.</p>

<pre class="prettyprint lang-php"><code>'Cartalyst\Converter\Laravel\ConverterServiceProvider',
</code></pre>

<p>In the <code>$aliases</code> array add the following facade for this package.</p>

<pre class="prettyprint lang-php"><code>'Converter' =&gt; 'Cartalyst\Converter\Laravel\Facades\Converter',
</code></pre>

<h4>Configuration</h4>

<p>After installing, you can publish the package configuration file into your application by running the following command on your terminal:</p>

<pre><code>php artisan publish:config cartalyst/converter
</code></pre>

<p>This will publish the config file to <code>config/packages/cartalyst/converter/config.php</code> where you can modify the package configuration.</p>

<h3>Native</h3>

<p>Integrating the package outside of a framework is incredible easy, just follow the example below.</p>

<pre class="prettyprint lang-php"><code>// Include the composer autoload file
require_once 'vendor/autoload.php';

// Import the necessary classes
use Cartalyst\Converter\Converter;
use Cartalyst\Converter\Exchangers\NativeExchanger;

// Require the converter config file
$config = require_once 'vendor/cartalyst/converter/src/config/config.php';

// Instantiate the converter and set the necessary configuration
$converter = new Converter(new NativeExchanger);
$converter-&gt;setMeasurements($config['measurements']);
</code></pre>

<p>The integration is done and you can now use all the available methods, here's an example:</p>

<pre class="prettyprint lang-php"><code>// Convert meters to centimeters
$value = $converter-&gt;from('length.m')-&gt;to('length.cm')-&gt;convert(200)-&gt;format();
</code></pre><h2>Usage</h2>

<p>In this section we'll show you how to use the converter package.</p>

<h3>Measurements</h3>

<p>The measurements are the crucial part of the package</p>

<h4>Get the measurements</h4>

<p>This will return an array containing all the available measurements.</p>

<pre class="prettyprint lang-php"><code>$measurements = Converter::getMeasurements();
</code></pre>

<h4>Set the measurements</h4>

<p>Setting new measurements is simple and easy, you just need to provide a multidimensional array.</p>

<p>You have two ways of setting measurements, <code>runtime</code> or through the <code>config</code> file.</p>

<h6>Runtime</h6>

<pre class="prettyprint lang-php"><code>Converter::setMeasurements(array(

    'weight' =&gt; array(

        'kg' =&gt; array(
            'format' =&gt; '1,0.00 KG',
            'unit'   =&gt; '1.00',
        ),

        'g' =&gt; array(
            'format' =&gt; '(1,0.00 grams)',
            'unit'   =&gt; 1000.00,
        ),

        'lb' =&gt; array(
            'format' =&gt; '1,0.00 lb',
            'unit'   =&gt; 2.20462,
        ),

    ),

));
</code></pre>

<h6>Config</h6>

<p>Open the file located at <code>app/config/packages/cartalyst/converter/config.php</code> and add your new measurements.</p>

<h3>Formatting</h3>

<p>We have a robust way of formatting measurements, please read along</p>

<p>You can place any currency symbol or text at the beginning or end of the format.</p>

<p>The first character <code>,</code> in the case above represents the thousands separator, the second one represents the decimals separator, digits after the second separator represent the number of decimals you want to show.</p>

<p>If you want to have only a decimal separator, you have to override the first separator using an <code>!</code></p>

<p>Ex. a value of <code>2000.5</code> with the format <code>'0!0.00 KG'</code> would output <code>2000.50 KG</code>.</p>

<h4>Format a unit</h4>

<pre class="prettyprint lang-php"><code>$value = Converter::to('weight.lb')-&gt;value(200000)-&gt;format();

&gt;&gt;&gt; 200,000 lb
</code></pre>

<h4>Custom Formatting</h4>

<pre class="prettyprint lang-php"><code>$value = Converter::to('weight.lb')-&gt;value(200000)-&gt;format('1,0.00 Pounds');

&gt;&gt;&gt; 200,000.00 Pounds
</code></pre>

<h4>Negative Formats</h4>

<p>Negative numbers are formatted according to the regular format by default, if you need to override the format for negative values, just provide a 'negative' property that defines your negative format.</p>

<p><strong>Example</strong></p>

<pre class="prettyprint lang-php"><code>'currency' =&gt; array(

    'usd' =&gt; array(
        'format'   =&gt; '$1,0.00',
        'negative' =&gt; '($1,0.00)'.
    ),

),
</code></pre>

<h3>Convertions</h3>

<p>We have a very simple way of converting a <code>measurement</code> to another.</p>

<h4>Converting from a unit to another</h4>

<pre class="prettyprint lang-php"><code>$value = Converter::from('weight.g')-&gt;to('weight.lb')-&gt;convert(200000)-&gt;format();

&gt;&gt;&gt; 441 lb
</code></pre>

<h4>Retrieve a converted unit value</h4>

<pre class="prettyprint lang-php"><code>$value = Converter::from('weight.g')-&gt;to('weight.lb')-&gt;convert(200000)-&gt;getValue();

&gt;&gt;&gt; 440.924
</code></pre><h3>Currency</h3>

<p>Currency conversion requires an exchanger to fetch currency rates from a third party.</p>

<h4>Default Exchangers</h4>

<p>By default the native exchanger is used, which will fall back to the regular config values, you can define these units under your config file, if no unit is defined, the exchanger defaults to 1.</p>

<p>We have built-in support for two exchangers out of the box.</p>

<h5>Native Exchanger</h5>

<p>It defaults to user defined measurements configurations</p>

<pre><code>'measurements' =&gt; array(

    'currency' =&gt; array(

        'usd' =&gt; array(
            'format' =&gt; '$1,0.00',
            'unit'   =&gt; 1
        ),

        'eur' =&gt; array(
            'format' =&gt; '&euro;1,0.00',
            'unit'   =&gt; 1.2
        ),

    ),
)
</code></pre>

<blockquote>
<p><strong>Note:</strong> If you're using Laravel 4, define the units on your config file.</p>
</blockquote>

<h5><a href="https://openexchangerates.org">OpenExchangeRates.org Exchanger</a></h5>

<p>It utilizes <code>illuminate/cache</code> to cache the currency results for a configurable amount of time.</p>

<pre><code>&lt;?php

use Cartalyst\Converter\Converter;
use Cartalyst\Converter\Exchangers\OpenExchangeRatesExchanger;
use Illuminate\Cache\CacheManager;
use Illuminate\Filesystem\Filesystem;

// Setup the Illuminate cache
$cache = new CacheManager(array(

    'config' =&gt; array(
        'cache.driver' =&gt; 'file',
        'cache.path'   =&gt; __DIR__.'/cache',
    ),

    'files' =&gt; new Filesystem(),

));

// Create the exchanger
$exchanger = new OpenExchangeRatesExchanger($cache);

// Set app id
$exchanger-&gt;setAppId('your_app_id');

// Set cache expiration duration in minutes
$exchanger-&gt;setExpires(60);

// Create a new converter instance
$converter = new Converter($exchanger);

// Convert a currency from USD to EUR
$value = $converter-&gt;from('currency.usd')-&gt;to('currency.eur')-&gt;convert(200)-&gt;format();
</code></pre>

<blockquote>
<p><strong>Note:</strong> If you're using Laravel 4, you only need to modify your config file and set your <code>app_id</code> and switch the default exchanger to <code>openexchangerates</code> and you're ready to go, just use the facade.</p>
</blockquote>

<h4>Custom Exchangers</h4>

<p>You can create your own exchanger by creating a class that implements the <code>Cartalyst\Converter\Exchangers\ExchangerInterface</code>.</p>

<pre><code>&lt;?php

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
</code></pre>

<p>To use your new exchanger simply pass it as a parameter to the Converter instance.</p>

<blockquote>
<p><strong>Note:</strong> If you're using Laravel 4, you can bind your new exchanger into the container as converter.{exchanger_name}.exchanger and switch the default exchanger on your config file to match your exchanger name, and simply use the facade.</p>
</blockquote>