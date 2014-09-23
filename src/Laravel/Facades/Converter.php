<?php namespace Cartalyst\Converter\Laravel\Facades;
/**
 * Part of the Converter package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Converter
 * @version    1.1.1
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Support\Facades\Facade;

class Converter extends Facade {

	/**
	 * {@inheritDoc}
	 */
	protected static function getFacadeAccessor()
	{
		return 'converter';
	}

}
