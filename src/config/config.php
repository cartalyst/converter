<?php
/**
 * Part of the Converter package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Converter
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
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
				'format' => '1,00.00 SQM',
				'unit'   => 1,
			),

			'acre' => array(
				'format' => '1,00.000 Acres',
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
				'format' => '1,0.00 KM',
				'unit'   => 0.001,
			),

			'm' => array(
				'format' => '1,0.00 M',
				'unit'   => 1.00,
			),

			'cm' => array(
				'format' => '1,0.00 CM',
				'unit'   => 100,
			),

			'mm' => array(
				'format' => '1,0.00 MM',
				'unit'   => 1000,
			),
			
			'in' => array(
				'format' => '1,0.00 IN',
				'unit'   => 39.3701,
			),
			
			'ft' => array(
				'format' => '1,0.00 FT',
				'unit'   => 3.28084
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
				'format' => '1,0.00 KG',
				'unit'   => 0.001,
			),

			'g' => array(
				'format' => '1,0.00 G',
				'unit'   => 1.00,
			),

			'lb' => array(
				'format' => '1 lb',
				'unit'   => 0.00220462,
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
