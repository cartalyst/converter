<?php
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
		| Weights
		|--------------------------------------------------------------------------
		|
		| The available measurements to convert and format weights.
		|
		*/

		'weights' => array(

			'kg' => array(
				'format' => '1,0.00 KG',
				'unit'   => 1.00,
			),

			'g' => array(
				'format' => '(1,0.00 grams)',
				'unit'   => 1000.00
			),

		),

		/*
		|--------------------------------------------------------------------------
		| Lenghts
		|--------------------------------------------------------------------------
		|
		| The available measurements to convert and format lengths.
		|
		*/

		'lengths' => array(

			'km' => array(
				'format' => '1,00.00 KM',
				'unit'   => 1.00,
			),

			'm' => array(
				'format' => '1,00.00 M',
				'unit'   => 1000
			),

			'cm' => array(
				'format' => '1,00.00 CM',
				'unit'   => 100000
			),

			'mm' => array(
				'format' => '1,00.00 MM',
				'unit'   => 1000000
			),

		),

	),

);
