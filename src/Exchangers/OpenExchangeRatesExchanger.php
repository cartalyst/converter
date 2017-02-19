<?php

/**
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
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Converter\Exchangers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Cache\CacheManager;

class OpenExchangeRatesExchanger implements ExchangerInterface
{
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
    protected $url = 'http://openexchangerates.org/api';

    /**
     * Holds the application id.
     *
     * @var array
     */
    protected $appId = null;

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
        return $this->appId;
    }

    /**
     * Set the app id.
     *
     * @return void
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    /**
     * Return the exchange rate for the provided currency code.
     *
     * @param  string  $code
     * @return float
     * @throws \Exception
     */
    public function get($code)
    {
        $rates = $this->getRates();

        $code = strtoupper($code);

        if (empty($rates[$code])) {
            throw new Exception;
        }

        return $rates[$code];
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
        return $this->rates = $this->cache->remember('currencies', $this->getExpires(), function () use ($self) {
            if (! $appId = $self->getAppId()) {
                throw new Exception('OpenExchangeRates.org requires an app key.');
            }

            $client = new Client([ 'base_url' => $self->getUrl() ]);

            $data = $client->get("latest.json?app_id={$appId}")->json();

            return $data['rates'];
        });
    }
}
