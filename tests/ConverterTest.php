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
 * @version    4.0.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Converter\Tests;

use Exception;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Cartalyst\Converter\Converter;
use Cartalyst\Converter\Exchangers\NativeExchanger;

class ConverterTest extends TestCase
{
    /**
     * Holds the Converter instance.
     *
     * @var \Cartalyst\Converter\Converter
     */
    protected $converter;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->converter = new Converter(new NativeExchanger());

        $this->converter->setMeasurements([
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

            'currency' => [
                'usd' => [
                    'format'   => '$1,0.00',
                    'negative' => '($1,0.00)',
                    'unit'     => 1,
                ],

                'eur' => [
                    'format' => '&euro;1,0.00',
                    'unit'   => 0.727204,
                ],

                'gbp' => [
                    'format' => '&pound;1,0.00',
                ],
            ],

            'length' => [
                'km' => [
                    'format' => '1,0.000 km',
                    'unit'   => 0.001,
                ],

                'mi' => [
                    'format' => '1,0.000 mi',
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
                    'format' => '1,0.00 in',
                    'unit'   => 39.3701,
                ],
            ],

            'weight' => [
                'kg' => [
                    'format' => '1.0,00 KG',
                    'unit'   => 1.00,
                ],

                'g' => [
                    'format' => '(1,0.00 grams)',
                    'unit'   => 1000.00,
                ],

                'lb' => [
                    'format' => '1 lb',
                    'unit'   => 2.20462,
                ],
            ],

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
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function converter_can_be_instantiated()
    {
        $converter = new Converter(new NativeExchanger());

        $this->assertInstanceOf(Converter::class, $converter);
    }

    /** @test */
    public function it_can_set_and_get_measurements()
    {
        $converter = new Converter(new NativeExchanger());

        $converter->setMeasurements([
            'currency' => [
                'usd' => [
                    'format'   => '$1,0.00',
                    'negative' => '($1,0.00)',
                    'unit'     => 1,
                ],

                'eur' => [
                    'format' => '&euro;1,0.00',
                    'unit'   => 0.727204,
                ],

                'gbp' => [
                    'format' => '&pound;1,0.00',
                ],
            ],
        ]);

        $this->assertCount(1, $converter->getMeasurements());

        $this->assertCount(3, $converter->getMeasurement('currency'));

        $this->assertSame($converter->getMeasurement('currency.eur.format'), '&euro;1,0.00');
    }

    /** @test */
    public function it_throws_an_exception_when_a_measurement_is_not_found()
    {
        $this->expectException(Exception::class);

        $this->converter->getMeasurement('foo');
    }

    /** @test */
    public function it_can_have_custom_formatting()
    {
        $eurUsd = $this->converter->to('currency.eur')->value(25.50);

        $this->assertSame($eurUsd->format('eur 1,0.00'), 'eur 25.50');

        $this->assertSame(round($eurUsd->getValue(), 3), 25.500);

        $eurUsd = $this->converter->from('currency.usd')->to('currency.eur')->convert(25.50);

        $this->assertSame($eurUsd->format('eur 1,0.00'), 'eur 18.54');

        $this->assertSame(round($eurUsd->getValue(), 3), 18.544);
    }

    /** @test */
    public function it_can_convert_areas()
    {
        // SQM to Acres
        $sqmAcres = $this->converter->from('area.sqm')->to('area.acre')->convert(43200);

        $this->assertSame($sqmAcres->format(), '10.675 ac');

        $this->assertSame(round($sqmAcres->getValue(), 3), 10.675);
    }

    /** @test */
    public function it_can_convert_currencies()
    {
        // EUR to USD
        $eurUsd = $this->converter->from('currency.eur')->to('currency.usd')->convert(25.50);

        $this->assertSame($eurUsd->format(), '$35.07');

        $this->assertSame(round($eurUsd->getValue(), 3), 35.066);

        // USD to EUR
        $usdEur = $this->converter->from('currency.usd')->to('currency.eur')->convert(56.73);

        $this->assertSame($usdEur->format(), '&euro;41.25');

        $this->assertSame(round($usdEur->getValue(), 3), 41.254);

        // EUR to GBP
        $eurGbp = $this->converter->from('currency.eur')->to('currency.gbp')->convert(43.22);

        $this->assertSame($eurGbp->format(), '&pound;59.43');

        $this->assertSame(round($eurGbp->getValue(), 3), 59.433);

        // Negative EUR to USD (negative defined)
        $eurUsdNegative = $this->converter->from('currency.eur')->to('currency.usd')->convert(-25.50);

        $this->assertSame($eurUsdNegative->format(), '($35.07)');

        $this->assertSame(round($eurUsdNegative->getValue(), 3), -35.066);

        // Negative USD to EUR (negative undefined)
        $usdEurNegative = $this->converter->from('currency.usd')->to('currency.eur')->convert(-25.50);

        $this->assertSame($usdEurNegative->format(), '-&euro;18.54');

        $this->assertSame(round($usdEurNegative->getValue(), 3), -18.544);

        // Zero value USD to EUR
        $usdEurZero = $this->converter->from('currency.usd')->to('currency.eur')->convert(0);

        $this->assertSame($usdEurZero->format(), '&euro;0.00');

        $this->assertSame(round($usdEurZero->getValue(), 3), 0.00);
    }

    /** @test */
    public function it_can_convert_lengths()
    {
        // Millimeters to kilometers
        $mmKm = $this->converter->from('length.mm')->to('length.km')->convert(2000000);

        $this->assertSame($mmKm->format(), '2.000 km');

        $this->assertSame(round($mmKm->getValue(), 3), 2.000);

        // Miles to kilometers
        $mileKm = $this->converter->from('length.mi')->to('length.km')->convert(200);

        $this->assertSame($mileKm->format(), '321.869 km');

        $this->assertSame(round($mileKm->getValue(), 3), 321.869);

        // Kilometers to miles
        $kmMile = $this->converter->from('length.km')->to('length.mi')->convert(200);

        $this->assertSame($kmMile->format(), '124.274 mi');

        $this->assertSame(round($kmMile->getValue(), 3), 124.274);

        // Foot to centimeters
        $ftCm = $this->converter->from('length.ft')->to('length.cm')->convert(200);

        $this->assertSame($ftCm->format(), '6096 cm');

        $this->assertSame(round($ftCm->getValue(), 3), 6096.0);

        // Meter to Feet
        $meterFt = $this->converter->from('length.m')->to('length.ft')->convert(200);

        $this->assertSame($meterFt->format(), '656.17 ft.');

        $this->assertSame(round($meterFt->getValue(), 3), 656.168);

        // Feet to meter
        $feetM = $this->converter->from('length.ft')->to('length.m')->convert(200);

        $this->assertSame($feetM->format(), '60.960 m');

        $this->assertSame(round($feetM->getValue(), 3), 60.960);

        // Meter to inches
        $meterIn = $this->converter->from('length.m')->to('length.in')->convert(200);

        $this->assertSame($meterIn->format(), '7,874.02 in');

        $this->assertSame(round($meterIn->getValue(), 3), 7874.02);

        // Inches to meter
        $inchM = $this->converter->from('length.in')->to('length.m')->convert(200);

        $this->assertSame($inchM->format(), '5.080 m');

        $this->assertSame(round($inchM->getValue(), 3), 5.080);
    }

    /** @test */
    public function it_can_convert_weights()
    {
        // Grams to pounds
        $gLb = $this->converter->from('weight.g')->to('weight.lb')->convert(200000);

        $this->assertSame($gLb->format(), '441 lb');

        $this->assertSame($gLb->getValue(), 440.924);

        // Pounds to kilograms
        $lbKg = $this->converter->from('weight.lb')->to('weight.kg')->convert(4440.924);

        $this->assertSame($lbKg->format(), '2.014,37 KG');

        $this->assertSame(round($lbKg->getValue(), 2), 2014.37);
    }

    /**
     * @test
     * @dataProvider data_provider_for_temperatures
     *
     * @param mixed $from
     * @param mixed $to
     * @param mixed $fromVal
     * @param mixed $toVal
     * @param mixed $toFormatted
     */
    public function it_can_convert_temperatures($from, $to, $fromVal, $toVal, $toFormatted)
    {
        $fk = $this->converter->from('temperature.'.$from)->to('temperature.'.$to)->convert($fromVal);

        $this->assertSame($fk->format(), $toFormatted);

        $this->assertSame(round($fk->getValue(), 2), $toVal);
    }

    public function data_provider_for_temperatures()
    {
        return [
            ['c', 'f',   26,   78.80, '78.80 °F'],
            ['f', 'c',  900,  482.22, '482.22 C'],
            ['c', 'k',  500,  773.15, '773.15 K'],
            ['k', 'c',  100, -173.15, '-173.15 C'],
            ['k', 'f', 1000, 1340.33, '1,340.33 °F'],
            ['f', 'k',   60,  288.71, '288.71 K'],

            ['c', 'rankine', 123,  713.07, '713.07 °R'],
            ['k', 'rankine', 920, 1656.0,  '1,656.00 °R'],
            ['rankine', 'k', 900, 500.0,   '500.00 K'],

            ['c', 'romer',  44,  30.6, '30.60 °Rø'],
            ['romer', 'c',  58,  96.19, '96.19 C'],
            ['romer', 'f', 133, 462.29, '462.29 °F'],

            ['rankine', 'romer', 220, -71.74, '-71.74 °Rø'],
        ];
    }
}
