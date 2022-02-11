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
 * @version    7.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2022, Cartalyst LLC
 * @link       https://cartalyst.com
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
    protected $rates;

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
    protected $appId;

    /**
     * Constructor.
     *
     * @param \Illuminate\Cache\CacheManager $cache
     *
     * @return void
     */
    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get the API Key.
     *
     * @return array
     */
    public function getAppId(): array
    {
        return $this->appId;
    }

    /**
     * Set the app id.
     *
     * @param mixed $appId
     *
     * @return $this
     */
    public function setAppId($appId): self
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * Return the exchange rate for the provided currency code.
     *
     * @param string $code
     *
     * @throws \Exception
     *
     * @return float
     */
    public function get(string $code): float
    {
        $rates = $this->getRates();

        $code = strtoupper($code);

        if (empty($rates[$code])) {
            throw new Exception();
        }

        return $rates[$code];
    }

    /**
     * Return the api url.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set the api url.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Return cache expiration duration.
     *
     * @return int
     */
    public function getExpires(): int
    {
        return $this->expires;
    }

    /**
     * Set cache expiration duration.
     *
     * @param mixed $expires
     *
     * @return $this
     */
    public function setExpires($expires): self
    {
        $this->expires = $expires;

        return $this;
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
     * Downloads the latest exchange rates file from openexchangerates.org.
     *
     * @return object
     */
    public function setRates()
    {
        // Cache the currencies
        return $this->rates = $this->cache->remember('currencies', $this->getExpires(), function () {
            if (! $appId = $this->getAppId()) {
                throw new Exception('OpenExchangeRates.org requires an app key.');
            }

            $client = new Client(['base_url' => $this->getUrl()]);

            $data = $client->get("latest.json?app_id={$appId}")->json();

            return $data['rates'];
        });
    }
}
