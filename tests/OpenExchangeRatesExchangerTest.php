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
 * @version    12.1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2025, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Converter\Tests;

use Exception;
use ArrayObject;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Illuminate\Cache\CacheManager;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Cartalyst\Converter\Exchangers\OpenExchangeRatesExchanger;

class OpenExchangeRatesExchangerTest extends TestCase
{
    /**
     * The cache manager, backed by an in-memory array store.
     *
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cache;

    /**
     * The queue of mocked api responses.
     *
     * @var \GuzzleHttp\Handler\MockHandler
     */
    protected $mock;

    /**
     * The requests sent to the api.
     *
     * @var array
     */
    protected $history = [];

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $app = new class () extends ArrayObject {
            public function bound($key): bool
            {
                return isset($this[$key]);
            }
        };

        $app['config'] = [
            'cache.default'      => 'array',
            'cache.stores.array' => ['driver' => 'array'],
        ];

        $this->cache = new CacheManager($app);

        $this->mock = new MockHandler();
    }

    /** @test */
    public function it_fetches_the_rates_and_remembers_them_as_fallback()
    {
        $this->mock->append($this->rates(['EUR' => 0.92]));

        $exchanger = $this->exchanger();

        $this->assertSame(0.92, $exchanger->get('eur'));
        $this->assertSame(['EUR' => 0.92], $this->cache->get('currencies.fallback'));

        $uri = (string) $this->history[0]['request']->getUri();

        $this->assertSame('https://openexchangerates.org/api/latest.json?app_id=secret', $uri);
    }

    /** @test */
    public function it_falls_back_to_the_last_good_rates_when_rate_limited()
    {
        $this->mock->append(
            $this->rates(['EUR' => 0.92]),
            new Response(429, [], '{"error":true,"status":429}')
        );

        $exchanger = $this->exchanger();
        $exchanger->get('eur');

        $this->expireRates();

        $this->assertSame(0.92, $exchanger->get('eur'));
        $this->assertCount(2, $this->history);
    }

    /** @test */
    public function it_falls_back_to_the_last_good_rates_on_network_errors()
    {
        $this->mock->append(
            $this->rates(['EUR' => 0.92]),
            new ConnectException('Connection refused', new Request('GET', 'latest.json'))
        );

        $exchanger = $this->exchanger();
        $exchanger->get('eur');

        $this->expireRates();

        $this->assertSame(0.92, $exchanger->get('eur'));
    }

    /** @test */
    public function it_falls_back_to_the_last_good_rates_on_invalid_responses()
    {
        $this->mock->append(
            $this->rates(['EUR' => 0.92]),
            new Response(200, [], 'Service Unavailable'),
            new Response(200, [], '{"disclaimer":"no rates here"}')
        );

        $exchanger = $this->exchanger();
        $exchanger->get('eur');

        $this->expireRates();
        $this->assertSame(0.92, $exchanger->get('eur'));

        $this->expireRates();
        $this->assertSame(0.92, $exchanger->get('eur'));
    }

    /** @test */
    public function it_caches_the_fallback_so_the_api_is_not_hit_on_every_request()
    {
        $this->mock->append(
            $this->rates(['EUR' => 0.92]),
            new Response(429)
        );

        $exchanger = $this->exchanger();
        $exchanger->get('eur');

        $this->expireRates();

        $exchanger->get('eur');
        $exchanger->get('eur');

        $this->assertCount(2, $this->history);
    }

    /** @test */
    public function it_keeps_the_fallback_when_the_api_returns_empty_rates()
    {
        $this->mock->append(
            $this->rates(['EUR' => 0.92]),
            $this->rates([])
        );

        $exchanger = $this->exchanger();
        $exchanger->get('eur');

        $this->expireRates();

        $this->assertSame(0.92, $exchanger->get('eur'));
        $this->assertSame(['EUR' => 0.92], $this->cache->get('currencies.fallback'));
    }

    /** @test */
    public function it_keeps_the_api_path_when_the_url_has_a_trailing_slash()
    {
        $this->mock->append($this->rates(['EUR' => 0.92]));

        $this->exchanger()->setUrl('https://example.test/api/')->get('eur');

        $uri = (string) $this->history[0]['request']->getUri();

        $this->assertSame('https://example.test/api/latest.json?app_id=secret', $uri);
    }

    /** @test */
    public function it_sets_timeouts_so_a_hanging_api_triggers_the_fallback()
    {
        $this->mock->append($this->rates(['EUR' => 0.92]));

        $this->exchanger()->get('eur');

        $options = $this->history[0]['options'];

        $this->assertSame(5, $options['connect_timeout']);
        $this->assertSame(10, $options['timeout']);
    }

    /** @test */
    public function it_rethrows_api_errors_when_there_is_no_fallback()
    {
        $this->expectException(ClientException::class);

        $this->mock->append(new Response(429));

        $this->exchanger()->get('eur');
    }

    /** @test */
    public function it_does_not_fall_back_when_the_app_key_is_invalid()
    {
        $this->assertRejectedAppKeyIsNotHidden(401);
    }

    /** @test */
    public function it_does_not_fall_back_when_the_app_key_is_restricted()
    {
        $this->assertRejectedAppKeyIsNotHidden(403);
    }

    /** @test */
    public function it_does_not_fall_back_when_the_app_key_is_missing()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('OpenExchangeRates.org requires an app key.');

        $this->cache->forever('currencies.fallback', ['EUR' => 0.92]);

        $this->exchanger()->setAppId(null)->get('eur');
    }

    /**
     * Creates an exchanger whose http client uses the mocked responses.
     *
     * @return \Cartalyst\Converter\Exchangers\OpenExchangeRatesExchanger
     */
    protected function exchanger(): OpenExchangeRatesExchanger
    {
        $stack = HandlerStack::create($this->mock);
        $stack->push(Middleware::history($this->history));

        $exchanger = new class ($this->cache) extends OpenExchangeRatesExchanger {
            public $stack;

            protected function createClient(): Client
            {
                // Reuse the real client configuration, only swap the handler
                $config = parent::createClient()->getConfig();

                return new Client(['handler' => $this->stack] + $config);
            }
        };

        $exchanger->stack = $stack;

        return $exchanger->setAppId('secret')->setExpires(60);
    }

    /**
     * Asserts that a rejected app key throws, even if fallback rates exist.
     *
     * @param int $status
     *
     * @return void
     */
    protected function assertRejectedAppKeyIsNotHidden(int $status): void
    {
        $this->mock->append(
            $this->rates(['EUR' => 0.92]),
            new Response($status, [], '{"error":true,"status":'.$status.'}')
        );

        $exchanger = $this->exchanger();
        $exchanger->get('eur');

        $this->expireRates();

        try {
            $exchanger->get('eur');

            $this->fail("A {$status} response must not fall back to the last good rates.");
        } catch (ClientException $e) {
            $this->assertSame($status, $e->getResponse()->getStatusCode());
        }
    }

    /**
     * Simulates the expiration of the cached rates.
     *
     * @return void
     */
    protected function expireRates(): void
    {
        $this->cache->forget('currencies');
    }

    /**
     * Creates a successful api response.
     *
     * @param array $rates
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function rates(array $rates): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'base'  => 'USD',
            'rates' => $rates,
        ]));
    }
}
