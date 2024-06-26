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

namespace LeoElements\Core\Common\Modules\Connect;

use LeoElements\Core\Base\Module as BaseModule;
use LeoElements\Core\Common\Modules\Connect\Apps\Base_App;
use LeoElements\Core\Common\Modules\Connect\Apps\Connect;
use LeoElements\Leo_Helper; 

if ( ! defined( '_PS_VERSION_' ) ) {
	exit; // Exit if accessed directly
}

class Module extends BaseModule {

	/**
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name() {
		return 'connect';
	}

	/**
	 * @var array
	 */
	protected $registered_apps = [];

	/**
	 * Apps Instances.
	 *
	 * Holds the list of all the apps instances.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var Base_App[]
	 */
	protected $apps = [];

	/**
	 * Registered apps categories.
	 *
	 * Holds the list of all the registered apps categories.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array
	 */
	protected $categories = [];

	protected $admin_page;

	/**
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->registered_apps = [
			'connect' => Connect::get_class_name(),
		];

		// Note: The priority 11 is for allowing plugins to add their register callback on elementor init.
		Leo_Helper::add_action( 'elementor/init', [ $this, 'init' ], 11 );
	}

	/**
	 * Register default apps.
	 *
	 * Registers the default apps.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		/**
		 * Register Elementor apps.
		 *
		 * Fires after Elementor registers the default apps.
		 *
		 * @since 1.0.0
		 *
		 * @param self $this The apps manager instance.
		 */
		Leo_Helper::do_action( 'elementor/connect/apps/register', $this );

		foreach ( $this->registered_apps as $slug => $class ) {
			$this->apps[ $slug ] = new $class();
		}
	}

	/**
	 * Register app.
	 *
	 * Registers an app.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $slug App slug.
	 * @param string $class App full class name.
	 *
	 * @return self The updated apps manager instance.
	 */
	public function register_app( $slug, $class ) {
		$this->registered_apps[ $slug ] = $class;

		return $this;
	}

	/**
	 * Get app instance.
	 *
	 * Retrieve the app instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param $slug
	 *
	 * @return Base_App|null
	 */
	public function get_app( $slug ) {
		if ( isset( $this->apps[ $slug ] ) ) {
			return $this->apps[ $slug ];
		}

		return null;
	}

	/**
	 * @since 1.0.0
	 * @access public
	 * @return Base_App[]
	 */
	public function get_apps() {
		return $this->apps;
	}

	/**
	 * @since 1.0.0
	 * @access public
	 */
	public function register_category( $slug, $args ) {
		$this->categories[ $slug ] = $args;
		return $this;
	}

	/**
	 * @since 1.0.0
	 * @access public
	 */
	public function get_categories() {
		return $this->categories;
	}

}