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
use Cartalyst\Converter\Exchangers\NativeExchanger;
use Cartalyst\Converter\Exchangers\OpenExchangeRatesExchanger;
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

		$this->registerExchangers();

		$this->registerConverter();
	}

	/**
	 * Register all the available exchangers.
	 *
	 * @return void
	 */
	protected function registerExchangers()
	{
		$this->app['converter.native.exchanger'] = $this->app->share(function($app)
		{
			return new NativeExchanger;
		});

		$this->app['converter.openexchangerates.exchanger'] = $this->app->share(function($app)
		{
			$config = $app['config']->get('converter::config');

			$exchanger = new OpenExchangeRatesExchanger($app['cache']);
			$exchanger->setAppId($config['exchangers.openexchangerates.app_id']);
			$exchanger->setExpires($config['expires']);

			return $exchanger;
		});

		$this->app['converter.exchanger'] = $this->app->share(function($app)
		{
			$config = $app['config']->get('converter::config');

			return $app["converter.{$config['exchangers.default']}.exchanger"]
		});
	}

	/**
	 * Register the Converter.
	 *
	 * @return void
	 */
	protected function registerConverter()
	{
		$this->app['converter'] = $this->app->share(function($app)
		{
			$measurements = $app['config']->get('converter::measurements');

			$converter = new Converter($app['converter.exchanger']);
			$converter->setMeasurements($measurements);

			return $converter;
		});
	}

}
