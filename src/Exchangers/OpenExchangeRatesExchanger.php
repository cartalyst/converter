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
 * @version    12.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2025, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Converter\Exchangers;

use Exception;
use JsonException;
use GuzzleHttp\Client;
use UnexpectedValueException;
use Illuminate\Cache\CacheManager;
use GuzzleHttp\Exception\GuzzleException;

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
     * @var array
     */
    protected $rates;

    /**
     * Cache key holding the last successfully fetched rates.
     *
     * @var string
     */
    protected $fallbackKey = 'currencies.fallback';

    /**
     * Holds the OpenExchangeRates.org api url.
     *
     * @var string
     */
    protected $url = 'http://openexchangerates.org/api';

    /**
     * Holds the application id.
     *
     * @var string|null
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
     * @return string|null
     */
    public function getAppId(): ?string
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
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \UnexpectedValueException
     *
     * @return array
     */
    public function getRates()
    {
        $this->setRates();

        return $this->rates;
    }

    /**
     * Downloads the latest exchange rates file from openexchangerates.org.
     *
     * Falls back to the last good rates when the api is unreachable, rate
     * limited or returns an invalid response.
     *
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \UnexpectedValueException
     *
     * @return array
     */
    public function setRates()
    {
        // Cache the currencies
        return $this->rates = $this->cache->remember('currencies', $this->getExpires(), function () {
            if (! $appId = $this->getAppId()) {
                throw new Exception('OpenExchangeRates.org requires an app key.');
            }

            try {
                $rates = $this->fetchRates($appId);
            } catch (GuzzleException|JsonException|UnexpectedValueException $e) {
                // The api is unreachable, rate limited or returned garbage, so
                // serve the last good rates instead. They are cached again for
                // the regular duration, so the api isn't hit on every request.
                if ($fallback = $this->cache->get($this->fallbackKey)) {
                    return $fallback;
                }

                throw $e;
            }

            $this->cache->forever($this->fallbackKey, $rates);

            return $rates;
        });
    }

    /**
     * Fetches the latest exchange rates from openexchangerates.org.
     *
     * @param string $appId
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \UnexpectedValueException
     *
     * @return array
     */
    protected function fetchRates(string $appId): array
    {
        $response = $this->createClient()->get('latest.json', [
            'query' => ['app_id' => $appId],
        ]);

        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        // Empty rates are treated as invalid too, so they never replace
        // the last good rates that are kept as fallback.
        if (empty($data['rates']) || ! is_array($data['rates'])) {
            throw new UnexpectedValueException('OpenExchangeRates.org returned no rates.');
        }

        return $data['rates'];
    }

    /**
     * Creates the http client used to talk to the api.
     *
     * @return \GuzzleHttp\Client
     */
    protected function createClient(): Client
    {
        // A trailing slash is required, otherwise RFC 3986 resolution
        // would drop the last path segment ("/api") of the base uri.
        // Explicit timeouts make a hanging api fail, so the fallback kicks in
        // instead of blocking until the max execution time is reached.
        return new Client([
            'base_uri'        => rtrim($this->getUrl(), '/').'/',
            'connect_timeout' => 5,
            'timeout'         => 10,
        ]);
    }
}
