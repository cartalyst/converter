<?php namespace Cartalyst\Measures;
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

use Exception;

class Measure {

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
	 * The available measures to convert and format the measurement.
	 *
	 * @var array
	 */
	protected $measures = array();

	/**
	 * Set the measure we want to convert from.
	 *
	 * @param  string  $value
	 * @return \Cartalyst\Measures\Measure
	 */
	public function from($value)
	{
		$this->from = $value;

		return $this;
	}

	/**
	 * Return the measure we want to convert from.
	 *
	 * @return string
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * Set the measure we want to convert to.
	 *
	 * @param  string  $value
	 * @return \Cartalyst\Measures\Measure
	 */
	public function to($value)
	{
		$this->to = $value;

		return $this;
	}

	/**
	 * Return the measure we want to convert to.
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
	 * @return \Cartalyst\Measures\Measure
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
	 * @return \Cartalyst\Measures\Measure
	 */
	public function convert($value = null)
	{
		if ($value)
		{
			$this->setValue($value);
		}

		$rateTo = $this->getMeasure($this->getTo() . '.unit') * (1 / $this->getMeasure($this->getFrom() . '.unit'));

		$this->value = $this->getValue() * $rateTo;

		return $this;
	}

	/**
	 * Format the value into the desired measurement.
	 *
	 * @param  string  $measure
	 * @return string
	 */
	public function format($measure = null)
	{
		// Get the value
		$value = $this->getValue();

		// Get the measurement format
		$measure = $measure ?: $this->getMeasure($this->to . '.format');

		// Value Regex
		$valRegex = '/([0-9].*|)[0-9]/';

		// Match decimal and thousand separators
		preg_match_all('/[,.!]/', $measure, $separators);

		$thousand = isset( $separators[0][0] ) ? $separators[0][0] !== '!' ? $separators[0][0] : '' : '';
		$decimal = isset( $separators[0][1] ) ? $separators[0][1] :'';

		// Match format for decimals count
		preg_match($valRegex, $measure, $valFormat);

		$valFormat = isset($valFormat[0]) ? $valFormat[0] : 0;

		// Count decimals length
		$decimals = $decimal ? strlen(substr(strrchr($valFormat, $decimal), 1)) : 0;

		// Format the value
		$value = number_format($value, $decimals, $decimal, $thousand);

		// Return the formatted measure
		return preg_replace($valRegex, $value, $measure);
	}

	/**
	 * Return the list of available measurements.
	 *
	 * @return array
	 */
	public function getMeasures()
	{
		return $this->measures;
	}

	/**
	 * Set measurements.
	 *
	 * By default it will merge the new measures with the current
	 * measures, you can change this behavior by setting false
	 * as the second parameter.
	 *
	 * @param  array  $measures
	 * @param  bool   $merge
	 * @return array
	 */
	public function setMeasures($measures = array(), $merge = true)
	{
		$measures = (array) $measures;

		$currentMeasures = $merge ? $this->getMeasures() : array();

		return $this->measures = array_merge($currentMeasures, $measures);
	}

	/**
	 * Return information about the provided measure.
	 *
	 * @param  string  $measure
	 * @return array
	 */
	public function getMeasure($measure)
	{
		$measures = $this->getMeasures();

		if (!$measurement = array_get($measures, $measure))
		{
			throw new Exception("Measure [{$measure}] was not found.");
		}

		return $measurement;
	}

}
