<?php namespace Cartalyst\Converter\Exchange;
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

interface ExchangeInterface {

	/**
	 * Return the exchange rate for the provided currency code.
	 *
	 * @param  string  $code
	 * @return float
	 */
	public function get($code);

	/**
	 * Return the api url.
	 *
	 * @return string
	 */
	public function getUrl();

	/**
	 * Set the api url.
	 *
	 * @param  string  $url
	 * @return void
	 */
	public function setUrl($url);

	/**
	 * Return the api secret key.
	 *
	 * @return string
	 */
	public function getSecret();

	/**
	 * Set the api secret key.
	 *
	 * @param  string  $secret
	 * @return void
	 */
	public function setSecret($secret);

}
