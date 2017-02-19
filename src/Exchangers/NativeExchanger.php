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

class NativeExchanger implements ExchangerInterface
{
    /**
     * Return the exchange rate for the provided currency code.
     *
     * @param  string  $code
     * @return float
     */
    public function get($code)
    {
        return 1;
    }
}
