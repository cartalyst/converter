<?php namespace Cartalyst\Converter\Tests;
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
use Mockery as m;
use PHPUnit_Framework_TestCase;

class ConverterTest extends PHPUnit_Framework_TestCase {

	/**
	 * Holds the converter instance.
	 * @var \Cartalyst\Converter\Converter
	 */
	protected $converter;

	/**
	 * Close mockery.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		m::close();
	}

	/**
	 * Setup resources and dependencies
	 */
	public function setUp()
	{
		$this->converter = new Converter;

		$this->converter->setMeasurements(array(

			'weights' => array(
				'kg' => array(
					'format' => '1.0,00 KG',
					'unit' => '1.00',
				),
				'g' => array(
					'format' => '(1,0.00 grams)',
					'unit' => 1000.00
				),
				'lb' => array(
					'format' => '1 lb',
					'unit' => 2.20462
				),
			),

			'lengths' => array(
				'km' => array(
					'format' => '1,0.000 KM',
					'unit' => '1.00',
				),
				'mile' => array(
					'format' => '1,0.000 Miles',
					'unit' => 0.621371,
				),
				'cm' => array(
					'format' => '1!0 centimeters',
					'unit' => 100000
				),
				'mm' => array(
					'format' => '1,0.00 millimeters',
					'unit' => 1000000
				),
				'ft' => array(
					'format' => '1,0.00 feet',
					'unit' => 3280.84
				),
			),

			'area' => array(
				'sqm' => array(
					'format' => '1,00.00 SQM',
					'unit' => 1,
				),
				'acre' => array(
					'format' => '1,00.000 Acres',
					'unit' => 0.000247105,
				),
			),

		));

	}

	public function testMeasureCanBeInstantiated()
	{
		$this->converter = new Converter;
	}

	public function testConvertWeights()
	{
		// Grams to pounds
		$gLb = $this->converter->value(200000)->from('weights.g')->to('weights.lb')->convert();
		$this->assertEquals($gLb->format(), '441 lb');
		$this->assertEquals($gLb->getValue(), 440.924);

		// Pounds to kilograms
		$lbKg = $this->converter->value(4440.924)->from('weights.lb')->to('weights.kg')->convert();
		$this->assertEquals($lbKg->format(), '2.014,37 KG');
		$this->assertEquals(round($lbKg->getValue(), 2), 2014.37);
	}

	public function testConvertLenghts()
	{
		// Millimeters to kilometers
		$mmKm = $this->converter->value(2000000)->from('lengths.mm')->to('lengths.km')->convert();
		$this->assertEquals($mmKm->format(), '2.000 KM');
		$this->assertEquals(round($mmKm->getValue(), 3), 2.000);

		// Miles to kilometers
		$mileKm = $this->converter->value(200)->from('lengths.mile')->to('lengths.km')->convert();
		$this->assertEquals($mileKm->format(), '321.869 KM');
		$this->assertEquals(round($mileKm->getValue(), 3), 321.869);

		// Kilometers to miles
		$kmMile = $this->converter->value(200)->from('lengths.km')->to('lengths.mile')->convert();
		$this->assertEquals($kmMile->format(), '124.274 Miles');
		$this->assertEquals(round($kmMile->getValue(), 3), 124.274);

		// Foot to centimeters
		$ftCm = $this->converter->value(200)->from('lengths.ft')->to('lengths.cm')->convert();
		$this->assertEquals($ftCm->format(), '6096 centimeters');
		$this->assertEquals(round($ftCm->getValue(), 3), 6096);
	}

	public function testConvertAreas()
	{
		// SQM to Acres
		$sqmAcres = $this->converter->value(43200)->from('area.sqm')->to('area.acre')->convert();
		$this->assertEquals($sqmAcres->format(), '10.675 Acres');
		$this->assertEquals(round($sqmAcres->getValue(), 3), 10.675);
	}

}
