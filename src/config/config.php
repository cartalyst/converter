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

return [
    /*
    |--------------------------------------------------------------------------
    | Measurements
    |--------------------------------------------------------------------------
    |
    | The available measurements to convert and format units.
    |
    */

    'measurements' => [
        /*
        |--------------------------------------------------------------------------
        | Area
        |--------------------------------------------------------------------------
        |
        | The available measurements to convert and format areas.
        |
        */

        'area' => [
            'sqm' => [
                'format' => '1,00.00 sq m',
                'unit'   => 1,
            ],

            'acre' => [
                'format' => '1,00.000 ac',
                'unit'   => 0.000247105,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        |
        | The available measurements to convert and format currencies.
        |
        */

        'currency' => [
            'usd' => [
                'format' => '$1,0.00',
            ],

            'eur' => [
                'format' => '&euro;1,0.00',
            ],

            'gbp' => [
                'format' => '&pound;1,0.00',
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Length
        |--------------------------------------------------------------------------
        |
        | The available measurements to convert and format lengths.
        |
        */

        'length' => [
            'km' => [
                'format' => '1,0.000 km',
                'unit'   => 0.001,
            ],

            'mi' => [
                'format' => '1,0.000 mi.',
                'unit'   => 0.000621371,
            ],

            'm' => [
                'format' => '1,0.000 m',
                'unit'   => 1.00,
            ],

            'cm' => [
                'format' => '1!0 cm',
                'unit'   => 100,
            ],

            'mm' => [
                'format' => '1,0.00 mm',
                'unit'   => 1000,
            ],

            'ft' => [
                'format' => '1,0.00 ft.',
                'unit'   => 3.28084,
            ],

            'in' => [
                'format' => '1,0.00 in.',
                'unit'   => 39.3701,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Weight
        |--------------------------------------------------------------------------
        |
        | The available measurements to convert and format weights.
        |
        */

        'weight' => [
            'kg' => [
                'format' => '1,0.00 kg',
                'unit'   => 1.00,
            ],

            'g' => [
                'format' => '1,0.00 g',
                'unit'   => 1000.00,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Temperature
        |--------------------------------------------------------------------------
        |
        | The available measurements to convert and format temperatures.
        |
        */

        'temperature' => [
            'c' => [
                'format' => '1,0.00 C',
                'unit'   => 1.00,
            ],

            'f' => [
                'format' => '1,0.00 °F',
                'unit'   => 1.80,
                'offset' => 32,
            ],

            'k' => [
                'format' => '1,0.00 K',
                'unit'   => 1.00,
                'offset' => 273.15,
            ],

            'rankine' => [
                'format' => '1,0.00 °R',
                'unit'   => 1.80,
                'offset' => 491.67,
            ],

            'romer' => [
                'format' => '1,0.00 °Rø',
                'unit'   => 0.525,
                'offset' => 7.5,
            ],
        ],
    ],

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

    'exchangers' => [
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

        'openexchangerates' => [
            'app_id' => null,
        ],
    ],
];
