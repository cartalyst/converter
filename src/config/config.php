<?php

/**
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
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return array(

    /*
    |--------------------------------------------------------------------------
    | Measurements
    |--------------------------------------------------------------------------
    |
    | The available measurements to convert and format units.
    |
    */

    'measurements' => array(

        /*
        |--------------------------------------------------------------------------
        | Area
        |--------------------------------------------------------------------------
        |
        | The available measurements to convert and format areas.
        |
        */

        'area' => array(

            'sqm' => array(
                'format' => '1,00.00 sq m',
                'unit'   => 1,
            ),

            'acre' => array(
                'format' => '1,00.000 ac',
                'unit'   => 0.000247105,
            ),

        ),

        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        |
        | The available measurements to convert and format currencies.
        |
        */

        'currency' => array(

            'usd' => array(
                'format' => '$1,0.00',
            ),

            'eur' => array(
                'format' => '&euro;1,0.00',
            ),

            'gbp' => array(
                'format' => '&pound;1,0.00',
            ),

        ),

        /*
        |--------------------------------------------------------------------------
        | Length
        |--------------------------------------------------------------------------
        |
        | The available measurements to convert and format lengths.
        |
        */

        'length' => array(

            'km' => array(
                'format' => '1,0.000 km',
                'unit'   => 0.001,
            ),

            'mi' => array(
                'format' => '1,0.000 mi.',
                'unit'   => 0.000621371,
            ),

            'm' => array(
                'format' => '1,0.000 m',
                'unit'   => 1.00,
            ),

            'cm' => array(
                'format' => '1!0 cm',
                'unit'   => 100,
            ),

            'mm' => array(
                'format' => '1,0.00 mm',
                'unit'   => 1000,
            ),

            'ft' => array(
                'format' => '1,0.00 ft.',
                'unit'   => 3.28084,
            ),

            'in' => array(
                'format' => '1,0.00 in.',
                'unit'   => 39.3701,
            ),

        ),

        /*
        |--------------------------------------------------------------------------
        | Weight
        |--------------------------------------------------------------------------
        |
        | The available measurements to convert and format weights.
        |
        */

        'weight' => array(

            'kg' => array(
                'format' => '1,0.00 kg',
                'unit'   => 1.00,
            ),

            'g' => array(
                'format' => '1,0.00 g',
                'unit'   => 1000.00,
            ),

        ),

    ),

    /*
    |--------------------------------------------------------------------------
    | Currency Cache Expiration Duration
    |--------------------------------------------------------------------------
    |
    | The duration currency rates are cached in minutes.
    |
    */

    'expires' => 60,

    /*
    |--------------------------------------------------------------------------
    | Currency Service Exchangers
    |--------------------------------------------------------------------------
    |
    | Here, you may specify any number of service exchangers configurations
    | your application requires.
    |
    */

    'exchangers' => array(

        /*
        |--------------------------------------------------------------------------
        | Default Exchanger
        |--------------------------------------------------------------------------
        |
        | Define here the default exchanger.
        |
        */

        'default' => 'native',

        /*
        |--------------------------------------------------------------------------
        | OpenExchangeRates.org
        |--------------------------------------------------------------------------
        |
        | Define here the OpenExchangeRates.org app id.
        |
        */

        'openexchangerates' => array(

            'app_id' => null,

        ),

    ),

);
