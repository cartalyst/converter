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
	 * The available formats to format the measurement.
	 *
	 * @var array
	 */
	protected $formats = array();

/**
	 * Set the format we want to convert from.
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
	 * Return the format we want to convert the measure from.
	 *
	 * @return string
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * Set the format we want to convert the measure to.
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
	 * Return the format we want to convert the measure to.
	 *
	 * @return string
	 */
	public function getTo()
	{
		return $this->to;
	}

	/**
	 * Set the value to be converted to.
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

		$this->value = $this->exchange->convert($this->getValue(), $this->getFrom(), $this->getTo());

		return $this;
	}

	/**
	 * Format the value into the desired measure.
	 *
	 * @param  string  $format
	 * @return string
	 */
	public function format($format = null)
	{
		// Get the value
		$value = $this->getValue();

		// Get the format we want to format the value to
		$format = $format ?: $this->getFormat($this->to);

		// Value Regex
		$valRegex = '/([0-9].*|)[0-9]/';

		// Match decimal and thousand separators
		preg_match_all('/[,.!]/', $format, $separators);

		$thousand = isset( $separators[0][0] ) ? $separators[0][0] !== '!' ? $separators[0][0] : '' : '';
		$decimal = isset( $separators[0][1] ) ? $separators[0][1] :'';

		// Match format for decimals count
		preg_match($valRegex, $format, $valFormat);

		$valFormat = isset($valFormat[0]) ? $valFormat[0] : 0;

		// Count decimals length
		$decimals = $decimal ? strlen(substr(strrchr($valFormat, $decimal), 1)) : 0;

		// Format the value
		$value = number_format($value, $decimals, $decimal, $thousand);

		// Return the formatted measure
		return preg_replace($valRegex, $value, $format);
	}

/**
	 * Return the list of available measurements formats.
	 *
	 * @return array
	 */
	public function getFormats()
	{
		return $this->formats;
	}

	/**
	 * Set measurements formats.
	 *
	 * By default it will merge the new formats with the current
	 * formats, you can change this behavior by setting false
	 * as the second parameter.
	 *
	 * @param  array  $formats
	 * @param  bool   $merge
	 * @return array
	 */
	public function setFormats($formats = array(), $merge = true)
	{
		$formats = (array) $formats;

		$currentFormats = $merge ? $this->getFormats() : array();

		return $this->formats = array_merge($currentFormats, $formats);
	}

	/**
	 * Return information about the provided format.
	 *
	 * @param  string  $format
	 * @return array
	 */
	public function getFormat($format)
	{
		$formats = $this->getFormats();

		$format = strtolower($format);

		if ( ! array_key_exists($format, $formats))
		{
			throw new Exception("Format [{$format}] was not found.");
		}

		return $formats[$format];
	}

}
