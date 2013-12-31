<?php namespace Cartalyst\Converter\Laravel;
/**
 * Part of the Converter package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Converter
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Converter\Converter;
use Cartalyst\Converter\Exchange\OpenExchangeRatesExchange;
use Illuminate\Support\ServiceProvider;

class ConverterServiceProvider extends ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cartalyst/converter', 'cartalyst/converter');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['config']->package('cartalyst/converter', __DIR__.'/../../config');

		$this->app['converter'] = $this->app->share(function($app)
		{
			$formats = $app['config']->get('converter::measurements');

			if ($secret = $app['config']->get('converter::measurements.exchangers.openexchangerates.app_id'))
			{
				$expires = $app['config']->get('converter::measurements.expires');

				$exchange = new OpenExchangeRatesExchange($app['cache']);
				$exchange->setSecret($secret);
				$exchange->setExpires($expires);

				foreach ($formats['currency'] as $key => $value)
				{
					$formats['currency'][$key]['unit'] = $exchange->get($key);
				}
			}

			$converter = $secret ? new Converter($exchange) : new Converter;
			$converter->setMeasurements($formats);

			return $converter;
		});
	}

}
