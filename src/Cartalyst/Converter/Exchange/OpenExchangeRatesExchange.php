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

use Exception;
use Illuminate\Cache\CacheManager;
use Requests;

class OpenExchangeRatesExchange implements ExchangeInterface {

	/**
	 * Cache manager.
	 *
	 * @var \Illuminate\Cache\CacheManager
	 */
	protected $cache;

	/**
	 * Cache expiration duration.
	 *
	 * @var int
	 */
	protected $expires;

	/**
	 * Holds the currency rates.
	 *
	 * @var object
	 */
	protected $rates = null;

	/**
	 * Holds the OpenExchangeRates.org api url.
	 *
	 * @var string
	 */
	protected $url = 'http://openexchangerates.org/api/latest.json';

	/**
	 * Holds the secret key to connect to the api.
	 *
	 * @var string
	 */
	protected $secret;

	/**
	 * Constructor.
	 *
	 * @param  \Illuminate\Cache\CacheManager  $cache
	 * @return void
	 */
	public function __construct(CacheManager $cache)
	{
		$this->cache = $cache;
	}

	/**
	 * Get the api key.
	 *
	 * @return string
	 */
	public function getAppId()
	{
		$secret = $this->getSecret();

		return $secret;
	}

	/**
	 * Return the api secret key.
	 *
	 * @return string
	 */
	public function getSecret()
	{
		return $this->secret;
	}

	/**
	 * Set the api secret key.
	 *
	 * @param  string  $secret
	 * @return void
	 */
	public function setSecret($secret)
	{
		$this->secret = $secret;
	}

	/**
	 * Return the exchange rate for the provided currency code.
	 *
	 * @param  string  $code
	 * @return float
	 */
	public function get($code)
	{
		$rates = $this->getRates();

		$code = strtoupper($code);

		if(empty($rates->{$code}))
		{
			throw new \Exception;
		}

		return $rates->{$code};
	}

	/**
	 * Return the api url.
	 *
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Set the api url.
	 *
	 * @param  string  $url
	 * @return void
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}

	/**
	 * Return cache expiration duration.
	 *
	 * @return int
	 */
	public function getExpires()
	{
		return $this->expires;
	}

	/**
	 * Set cache expiration duration.
	 *
	 * @return void
	 */
	public function setExpires($expires)
	{
		$this->expires = $expires;
	}

	/**
	 * Return the currencies rates.
	 *
	 * @return object
	 */
	public function getRates()
	{
		$this->setRates();

		return $this->rates;
	}

	/**
	 * Downloads the latest exchange rates file from openexchangerates.org
	 *
	 * @return object
	 */
	public function setRates()
	{
		// Avoid instance issues
		$self = $this;

		// Cache the currencies
		return $this->rates = $this->cache->remember('currencies', $this->getExpires(), function() use ($self)
		{
			$appId = $self->getAppId();

			if (is_null($appId))
			{
				throw new Exception('OpenExchangeRates.org requires an app key.');
			}

			$url = "{$self->getUrl()}?app_id={$appId}";

			$response = Requests::get($url);

			$data = json_decode($response->body);

			return $data->rates;
		});
	}

}
