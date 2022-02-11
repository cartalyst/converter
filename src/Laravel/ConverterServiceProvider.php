<?php

/*
 * Part of the Converter package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Converter
 * @version    7.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2022, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Converter\Laravel;

use Illuminate\Support\Arr;
use Cartalyst\Converter\Converter;
use Illuminate\Support\ServiceProvider;
use Cartalyst\Converter\Exchangers\NativeExchanger;
use Cartalyst\Converter\Exchangers\OpenExchangeRatesExchanger;

class ConverterServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->prepareResources();

        $this->registerExchangers();

        $this->registerConverter();
    }

    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        $config = realpath(__DIR__.'/../config/config.php');

        $this->mergeConfigFrom($config, 'cartalyst.converter');

        $this->publishes([
            $config => config_path('cartalyst.converter.php'),
        ], 'config');
    }

    /**
     * Register all the available exchangers.
     *
     * @return void
     */
    protected function registerExchangers()
    {
        $this->app->singleton('converter.native.exchanger', function () {
            return new NativeExchanger();
        });

        $this->app->singleton('converter.openexchangerates.exchanger', function ($app) {
            $config = $app['config']->get('cartalyst.converter');

            $appId = Arr::get($config, 'exchangers.openexchangerates.app_id');

            $expires = Arr::get($config, 'expires');

            $exchanger = new OpenExchangeRatesExchanger($app['cache']);
            $exchanger->setAppId($appId);
            $exchanger->setExpires($expires);

            return $exchanger;
        });

        $this->app->singleton('converter.exchanger', function ($app) {
            $default = $app['config']->get('cartalyst.converter.exchangers.default');

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
        $this->app->singleton('converter', function ($app) {
            $measurements = $app['config']->get('cartalyst.converter.measurements');

            $converter = new Converter($app['converter.exchanger']);
            $converter->setMeasurements($measurements);

            return $converter;
        });
    }
}
