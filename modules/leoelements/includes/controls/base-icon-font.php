<?php
/**
 * 2007-2022 Apollotheme
 *
 * NOTICE OF LICENSE
 *
 * LeoElements is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @author    Apollotheme <apollotheme@gmail.com>
 *  @copyright 2007-2022 Apollotheme
 *  @license   http://apollotheme.com - prestashop template provider
 */

namespace LeoElements;

use LeoElements\Leo_Helper; 

if ( ! defined( '_PS_VERSION_' ) ) {
	exit; // Exit if accessed directly.
}

abstract class Base_Icon_Font {

	/**
	 * Get Icon type.
	 *
	 * Retrieve the icon type.
	 *
	 * @access public
	 * @abstract
	 */
	abstract public function get_type();

	/**
	 * Enqueue Icon scripts and styles.
	 *
	 * Used to register and enqueue custom scripts and styles used by the Icon.
	 *
	 * @access public
	 */
	abstract public function enqueue();

	/**
	 * get_css_prefix
	 * @return string
	 */
	abstract public function get_css_prefix();

	abstract public function get_icons();

	public function __construct() {}
}
