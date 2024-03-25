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
 * @version    9.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2024, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Converter\Exchangers;

interface ExchangerInterface
{
    /**
     * Return the exchange rate for the provided currency code.
     *
     * @param string $code
     *
     * @return float
     */
    public function get(string $code): float;
}
