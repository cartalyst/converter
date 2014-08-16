<?php namespace Cartalyst\Converter\Tests;
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

use Cartalyst\Converter\Converter;
use Cartalyst\Converter\Exchangers\NativeExchanger;
use Mockery as m;
use PHPUnit_Framework_TestCase;

class ConverterTest extends PHPUnit_Framework_TestCase {

	/**
	 * Holds the converter instance.
	 *
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
		$this->converter = new Converter(new NativeExchanger);

		$this->converter->setMeasurements(array(

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

			'currency' => array(

				'usd' => array(
					'format'   => '$1,0.00',
					'negative' => '($1,0.00)',
					'unit'     => 1,
				),

				'eur' => array(
					'format' => '&euro;1,0.00',
					'unit'   => 0.727204,
				),

				'gbp' => array(
					'format' => '&pound;1,0.00',
				),

			),

			'length' => array(

				'km' => array(
					'format' => '1,0.000 KM',
					'unit'   => 0.001,
				),

				'mile' => array(
					'format' => '1,0.000 Miles',
					'unit'   => 0.000621371,
				),

				'meter' => array(
					'format' => '1,0.000',
					'unit' => 1.00,
				),

				'cm' => array(
					'format' => '1!0 centimeters',
					'unit'   => 100
				),

				'mm' => array(
					'format' => '1,0.00 millimeters',
					'unit'   => 1000
				),

				'ft' => array(
					'format' => '1,0.00 feet',
					'unit'   => 3.28084
				),

				'in' => array(
					'format' => '1,0.00 inches',
					'unit'   => 39.3701
				),

			),

			'weight' => array(

				'kg' => array(
					'format' => '1.0,00 KG',
					'unit'   => 1.00,
				),

				'g' => array(
					'format' => '(1,0.00 grams)',
					'unit'   => 1000.00,
				),

				'lb' => array(
					'format' => '1 lb',
					'unit'   => 2.20462,
				),

			),

		));
	}

	/**
	 * @test
	 */
	public function converter_can_be_instantiated()
	{
		new Converter(new NativeExchanger);
	}

	/**
	 * @test
	 */
	public function it_can_set_and_get_measurements()
	{
		$converter = new Converter(new NativeExchanger);

		$converter->setMeasurements(array(

			'currency' => array(

				'usd' => array(
					'format'   => '$1,0.00',
					'negative' => '($1,0.00)',
					'unit'     => 1,
				),

				'eur' => array(
					'format' => '&euro;1,0.00',
					'unit'   => 0.727204,
				),

				'gbp' => array(
					'format' => '&pound;1,0.00',
				),

			),

		));

		$this->assertEquals(count($converter->getMeasurements()), 1);

		$this->assertEquals(count($converter->getMeasurement('currency')), 3);

		$this->assertEquals($converter->getMeasurement('currency.eur.format'), '&euro;1,0.00');
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function it_throws_exception_when_a_measurement_is_not_found()
	{
		$mesasurement = $this->converter->getMeasurement('foo');
	}

	/**
	 * @test
	 */
	public function it_can_have_custom_formatting()
	{
		$eurUsd = $this->converter->to('currency.eur')->value(25.50);

		$this->assertEquals($eurUsd->format('eur 1,0.00'), 'eur 25.50');

		$this->assertEquals(round($eurUsd->getValue(), 3), 25.500);


		$eurUsd = $this->converter->from('currency.usd')->to('currency.eur')->convert(25.50);

		$this->assertEquals($eurUsd->format('eur 1,0.00'), 'eur 18.54');

		$this->assertEquals(round($eurUsd->getValue(), 3), 18.544);
	}

	/**
	 * @test
	 */
	public function it_can_convert_areas()
	{
		// SQM to Acres
		$sqmAcres = $this->converter->from('area.sqm')->to('area.acre')->convert(43200);

		$this->assertEquals($sqmAcres->format(), '10.675 Acres');

		$this->assertEquals(round($sqmAcres->getValue(), 3), 10.675);
	}

	/**
	 * @test
	 */
	public function it_can_convert_currencies()
	{
		// EUR to USD
		$eurUsd = $this->converter->from('currency.eur')->to('currency.usd')->convert(25.50);

		$this->assertEquals($eurUsd->format(), '$35.07');

		$this->assertEquals(round($eurUsd->getValue(), 3), 35.066);


		// USD to EUR
		$usdEur = $this->converter->from('currency.usd')->to('currency.eur')->convert(56.73);

		$this->assertEquals($usdEur->format(), '&euro;41.25');

		$this->assertEquals(round($usdEur->getValue(), 3), 41.254);


		// EUR to GBP
		$eurGbp = $this->converter->from('currency.eur')->to('currency.gbp')->convert(43.22);

		$this->assertEquals($eurGbp->format(), '&pound;59.43');

		$this->assertEquals(round($eurGbp->getValue(), 3), 59.433);


		// Negative EUR to USD (negative defined)
		$eurUsdNegative = $this->converter->from('currency.eur')->to('currency.usd')->convert(-25.50);

		$this->assertEquals($eurUsdNegative->format(), '($35.07)');

		$this->assertEquals(round($eurUsdNegative->getValue(), 3), -35.066);


		// Negative USD to EUR (negative undefined)
		$usdEurNegative = $this->converter->from('currency.usd')->to('currency.eur')->convert(-25.50);

		$this->assertEquals($usdEurNegative->format(), '-&euro;18.54');

		$this->assertEquals(round($usdEurNegative->getValue(), 3), -18.544);
	}

	/**
	 * @test
	 */
	public function it_can_convert_lengths()
	{
		// Millimeters to kilometers
		$mmKm = $this->converter->from('length.mm')->to('length.km')->convert(2000000);

		$this->assertEquals($mmKm->format(), '2.000 KM');

		$this->assertEquals(round($mmKm->getValue(), 3), 2.000);


		// Miles to kilometers
		$mileKm = $this->converter->from('length.mile')->to('length.km')->convert(200);

		$this->assertEquals($mileKm->format(), '321.869 KM');

		$this->assertEquals(round($mileKm->getValue(), 3), 321.869);


		// Kilometers to miles
		$kmMile = $this->converter->from('length.km')->to('length.mile')->convert(200);

		$this->assertEquals($kmMile->format(), '124.274 Miles');

		$this->assertEquals(round($kmMile->getValue(), 3), 124.274);


		// Foot to centimeters
		$ftCm = $this->converter->from('length.ft')->to('length.cm')->convert(200);

		$this->assertEquals($ftCm->format(), '6096 centimeters');

		$this->assertEquals(round($ftCm->getValue(), 3), 6096);

		// Meter to Feet
		$meterFt = $this->converter->from('length.meter')->to('length.ft')->convert(200);

		$this->assertEquals($meterFt->format(), '656.17 feet');

		$this->assertEquals(round($meterFt->getValue(), 3), 656.168);

		// Meter to inches
		$meterIn = $this->converter->from('length.meter')->to('length.in')->convert(200);

		$this->assertEquals($meterIn->format(), '7,874.02 inches');

		$this->assertEquals(round($meterIn->getValue(), 3), 7874.02);
	}

	/**
	 * @test
	 */
	public function it_can_convert_weights()
	{
		// Grams to pounds
		$gLb = $this->converter->from('weight.g')->to('weight.lb')->convert(200000);

		$this->assertEquals($gLb->format(), '441 lb');

		$this->assertEquals($gLb->getValue(), 440.924);


		// Pounds to kilograms
		$lbKg = $this->converter->from('weight.lb')->to('weight.kg')->convert(4440.924);

		$this->assertEquals($lbKg->format(), '2.014,37 KG');

		$this->assertEquals(round($lbKg->getValue(), 2), 2014.37);
	}

}
