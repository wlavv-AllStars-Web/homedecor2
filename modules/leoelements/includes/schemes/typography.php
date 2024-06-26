<?php
/**
 * 2007-2022 Leotheme
 *
 * NOTICE OF LICENSE
 *
 * LeoElements is module help you can build content for your shop
 *
 * DISCLAIMER
 *
 *  @author    Leotheme <leotheme@gmail.com>
 *  @copyright 2007-2022 Leotheme
 *  @license   http://leotheme.com - prestashop template provider
 */

namespace LeoElements;

use LeoElements\Leo_Helper; 

if ( ! defined( '_PS_VERSION_' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor typography scheme.
 *
 * Elementor typography scheme class is responsible for initializing a scheme
 * for typography.
 *
 * @since 1.0.0
 */
class Scheme_Typography extends Scheme_Base {

	/**
	 * 1st typography scheme.
	 */
	const TYPOGRAPHY_1 = '1';

	/**
	 * 2nd typography scheme.
	 */
	const TYPOGRAPHY_2 = '2';

	/**
	 * 3rd typography scheme.
	 */
	const TYPOGRAPHY_3 = '3';

	/**
	 * 4th typography scheme.
	 */
	const TYPOGRAPHY_4 = '4';

	/**
	 * Get typography scheme type.
	 *
	 * Retrieve the typography scheme type.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return string Typography scheme type.
	 */
	public static function get_type() {
		return 'typography';
	}

	/**
	 * Get typography scheme title.
	 *
	 * Retrieve the typography scheme title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Typography scheme title.
	 */
	public function get_title() {
		return Leo_Helper::__( 'Typography', 'elementor' );
	}

	/**
	 * Get typography scheme disabled title.
	 *
	 * Retrieve the typography scheme disabled title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Typography scheme disabled title.
	 */
	public function get_disabled_title() {
		return Leo_Helper::__( 'Default Fonts', 'elementor' );
	}

	/**
	 * Get typography scheme titles.
	 *
	 * Retrieve the typography scheme titles.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Typography scheme titles.
	 */
	public function get_scheme_titles() {
		return [
			self::TYPOGRAPHY_1 => Leo_Helper::__( 'Primary Headline', 'elementor' ),
			self::TYPOGRAPHY_2 => Leo_Helper::__( 'Secondary Headline', 'elementor' ),
			self::TYPOGRAPHY_3 => Leo_Helper::__( 'Body Text', 'elementor' ),
			self::TYPOGRAPHY_4 => Leo_Helper::__( 'Accent Text', 'elementor' ),
		];
	}

	/**
	 * Get default typography scheme.
	 *
	 * Retrieve the default typography scheme.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Default typography scheme.
	 */
	public function get_default_scheme() {
		return [
			self::TYPOGRAPHY_1 => [
				'font_family' => '',
				'font_weight' => '',
			],
			self::TYPOGRAPHY_2 => [
				'font_family' => '',
				'font_weight' => '',
			],
			self::TYPOGRAPHY_3 => [
				'font_family' => '',
				'font_weight' => '',
			],
			self::TYPOGRAPHY_4 => [
				'font_family' => '',
				'font_weight' => '',
			],
		];
	}

	/**
	 * Init system typography schemes.
	 *
	 * Initialize the system typography schemes.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array System typography schemes.
	 */
	protected function _init_system_schemes() {
		return [];
	}

	/**
	 * Print typography scheme content template.
	 *
	 * Used to generate the HTML in the editor using Underscore JS template. The
	 * variables for the class are available using `data` JS object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function print_template_content() {
		?>
		<div class="elementor-panel-scheme-items"></div>
		<?php
	}
}
