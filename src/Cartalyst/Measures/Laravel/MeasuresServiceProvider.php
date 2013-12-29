<?php namespace Cartalyst\Measures\Laravel;
/**
 * Part of the Measures package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Measures
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Measures\Measure;
use Illuminate\Support\ServiceProvider;

class MeasuresServiceProvider extends ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cartalyst/measures', 'cartalyst/measures');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['config']->package('cartalyst/measures', __DIR__.'/../../config');

		$this->app['measure'] = $this->app->share(function($app)
		{
			$formats = $app['config']->get('measures::measures');

			$measure = new Measure;
			$measure->setMeasures($formats);

			return $measure;
		});
	}

}
