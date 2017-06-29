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
 * @version    2.0.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
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
           
            try {
                $data = $client->get("latest.json?app_id={$appId}")->json();
            } catch(Exception $e) {
                
                // Use backup cached currencies when the cache has expired, and the API is down
                if( $fallback_rates = $this->cache->get('fallback_currencies', null) ) {
                    $data['rates'] = $fallback_rates;
                }
                // If the API is down and the fallback cache is empty, default to 'something' so that the api isnt contantly called on each
                $data['rates'] = ['USD' => 1, 'EUR' => 1, 'GBP' => 1];
            }
            // Create fallback cache with a slightly longer expiry
            $fallback_rates = $this->cache->put('fallback_currencies',  $data['rates'], $this->getExpires() + 5);

            return $data['rates'];
        });
    }
}
