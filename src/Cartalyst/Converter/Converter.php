<?php namespace Cartalyst\Converter;
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

use Cartalyst\Converter\Exchangers\ExchangerInterface;
use Exception;

class Converter {

	/**
	 * Exchanger driver.
	 *
	 * @var \Cartalyst\Converter\Exchangers\ExchangerInterface
	 */
	protected $exchanger = null;

	/**
	 * Measurement we are converting from.
	 *
	 * @var string
	 */
	protected $from = null;

	/**
	 * Measurement we are going to convert to.
	 *
	 * @var string
	 */
	protected $to = null;

	/**
	 * Measurement value.
	 *
	 * @var float
	 */
	protected $value = null;

	/**
	 * The available measurements to convert and format the measurement.
	 *
	 * @var array
	 */
	protected $measurements = array();

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Converter\Exchangers\ExchangerInterface  $exchanger
	 * @return void
	 */
	public function __construct(ExchangerInterface $exchanger)
	{
		$this->exchanger = $exchanger;
	}

	/**
	 * Set the measurement we want to convert from.
	 *
	 * @param  string  $value
	 * @return \Cartalyst\Converter\Converter
	 */
	public function from($value)
	{
		$this->from = $value;

		return $this;
	}

	/**
	 * Return the measurement we want to convert from.
	 *
	 * @return string
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * Set the measurement we want to convert to.
	 *
	 * @param  string  $value
	 * @return \Cartalyst\Converter\Converter
	 */
	public function to($value)
	{
		$this->to = $value;

		return $this;
	}

	/**
	 * Return the measurement we want to convert to.
	 *
	 * @return string
	 */
	public function getTo()
	{
		return $this->to;
	}

	/**
	 * Set the value we want to convert.
	 *
	 * @param  float  $value
	 * @return \Cartalyst\Converter\Converter
	 */
	public function value($value)
	{
		$this->value = $value;

		return $this;
	}

	/**
	 * Return the value.
	 *
	 * @return float
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * Convert the specified value.
	 *
	 * @param  float  $value
	 * @return \Cartalyst\Converter\Converter
	 */
	public function convert($value = null)
	{
		if ($value)
		{
			$this->value($value);
		}

		$to = $this->getTo();

		$from = $this->getFrom();

		$value = $this->getValue();

		$this->value = $value * $this->getMeasurement("{$to}.unit") * (1 / $this->getMeasurement("{$from}.unit"));

		return $this;
	}

	/**
	 * Format the value into the desired measurement.
	 *
	 * @param  string  $measurement
	 * @return string
	 */
	public function format($measurement = null)
	{
		// Get the value
		$value = $this->getValue();

		// Get the measurement format
		$measurement = $measurement ?: $this->getMeasurement("{$this->to}.format");

		// Value Regex
		$valRegex = '/([0-9].*|)[0-9]/';

		// Match decimal and thousand separators
		preg_match_all('/[,.!]/', $measurement, $separators);

		if ($thousand = array_get($separators, '0.0', null))
		{
			if ($thousand == '!') $thousand = '';
		}

		$decimal = array_get($separators, '0.1', null);

		// Match format for decimals count
		preg_match($valRegex, $measurement, $valFormat);

		$valFormat = array_get($valFormat, 0, 0);

		// Count decimals length
		$decimals = $decimal ? strlen(substr(strrchr($valFormat, $decimal), 1)) : 0;

		// Format the value
		$value = number_format($value, $decimals, $decimal, $thousand);

		// Return the formatted measure
		return preg_replace($valRegex, $value, $measurement);
	}

	/**
	 * Return the list of available measurements.
	 *
	 * @return array
	 */
	public function getMeasurements()
	{
		return $this->measurements;
	}

	/**
	 * Set measurements.
	 *
	 * By default it will merge the new measurements with the current
	 * measurements, you can change this behavior by setting false
	 * as the second parameter.
	 *
	 * @param  array  $measurements
	 * @param  bool   $merge
	 * @return array
	 */
	public function setMeasurements($measurements = array(), $merge = true)
	{
		$measurements = (array) $measurements;

		$currentMeasurements = $merge ? $this->getMeasurements() : array();

		return $this->measurements = array_merge($currentMeasurements, $measurements);
	}

	/**
	 * Return information about the provided measure.
	 *
	 * @param  string  $measurement
	 * @return mixed
	 * @throws \Exception
	 */
	public function getMeasurement($measurement)
	{
		$measurements = $this->getMeasurements();

		if ( ! $measure = array_get($measurements, $measurement))
		{
			if (str_contains($measurement, 'currency'))
			{
				$currency = explode('.', $measurement);

				return $this->exchanger->get($currency[0]);
			}

			throw new Exception("Measurement [{$measurement}] was not found.");
		}

		return $measure;
	}

}
