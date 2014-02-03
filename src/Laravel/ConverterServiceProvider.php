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
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Converter\Converter;
use Cartalyst\Converter\Exchangers\NativeExchanger;
use Cartalyst\Converter\Exchangers\OpenExchangeRatesExchanger;
use Illuminate\Support\ServiceProvider;

class ConverterServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		$this->package('cartalyst/converter', 'cartalyst/converter', __DIR__.'/..');
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
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
			$appId = $app['config']->get('cartalyst/converter::exchangers.openexchangerates.app_id');

			$expires = $app['config']->get('cartalyst/converter::expires');

			$exchanger = new OpenExchangeRatesExchanger($app['cache']);
			$exchanger->setAppId($appId);
			$exchanger->setExpires($expires);

			return $exchanger;
		});

		$this->app['converter.exchanger'] = $this->app->share(function($app)
		{
			$default = $app['config']->get('cartalyst/converter::exchangers.default');

			return $app["converter.{$default}.exchanger"];
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
			$measurements = $app['config']->get('cartalyst/converter::measurements');

			$converter = new Converter($app['converter.exchanger']);
			$converter->setMeasurements($measurements);

			return $converter;
		});
	}

}
