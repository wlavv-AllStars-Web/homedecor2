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

namespace LeoElements\Core\Settings\General;

use LeoElements\Controls_Manager;
use LeoElements\Core\Settings\Base\Model as BaseModel;
use LeoElements\Leo_Helper; 

if ( ! defined( '_PS_VERSION_' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor global settings model.
 *
 * Elementor global settings model handler class is responsible for registering
 * and managing Elementor global settings models.
 *
 * @since 1.6.0
 */
class Model extends BaseModel {

	/**
	 * Get model name.
	 *
	 * Retrieve global settings model name.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @return string Model name.
	 */
	public function get_name() {
		return 'global-settings';
	}

	/**
	 * Get CSS wrapper selector.
	 *
	 * Retrieve the wrapper selector for the global settings model.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @return string CSS wrapper selector.
	 */

	public function get_css_wrapper_selector() {
		return '';
	}

	/**
	 * Get panel page settings.
	 *
	 * Retrieve the panel setting for the global settings model.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @return array {
	 *    Panel settings.
	 *
	 *    @type string $title The panel title.
	 *    @type array  $menu  The panel menu.
	 * }
	 */
	public function get_panel_page_settings() {
		return [
			'title' => Leo_Helper::__( 'Global Settings', 'elementor' ),
			'menu' => [
				'icon' => 'eicon-cogs',
				'beforeItem' => 'elementor-settings',
			],
		];
	}

	/**
	 * Get controls list.
	 *
	 * Retrieve the global settings model controls list.
	 *
	 * @since 1.6.0
	 * @access public
	 * @static
	 *
	 * @return array Controls list.
	 */
	public static function get_controls_list() {
		return [
			Controls_Manager::TAB_STYLE => [
				'style' => [
					'label' => Leo_Helper::__( 'Style', 'elementor' ),
					'controls' => [
						'elementor_default_generic_fonts' => [
							'label' => Leo_Helper::__( 'Default Generic Fonts', 'elementor' ),
							'type' => Controls_Manager::TEXT,
							'default' => 'Sans-serif',
							'description' => Leo_Helper::__( 'The list of fonts used if the chosen font is not available.', 'elementor' ),
							'label_block' => true,
						],
						'elementor_container_width' => [
							'label' => Leo_Helper::__( 'Content Width', 'elementor' ) . ' (px)',
							'type' => Controls_Manager::NUMBER,
							'min' => 300,
							'description' => Leo_Helper::__( 'Sets the default width of the content area (Default: 1140)', 'elementor' ),
							'selectors' => [
								'.elementor-section.elementor-section-boxed > .elementor-container' => 'max-width: {{VALUE}}px',
							],
						],
						'elementor_space_between_widgets' => [
							'label' => Leo_Helper::__( 'Widgets Space', 'elementor' ) . ' (px)',
							'type' => Controls_Manager::NUMBER,
							'min' => 0,
							'placeholder' => '20',
							'description' => Leo_Helper::__( 'Sets the default space between widgets (Default: 20)', 'elementor' ),
							'selectors' => [
								'.elementor-widget:not(:last-child)' => 'margin-bottom: {{VALUE}}px',
							],
						],
						'elementor_stretched_section_container' => [
							'label' => Leo_Helper::__( 'Stretched Section Fit To', 'elementor' ),
							'type' => Controls_Manager::TEXT,
							'placeholder' => 'body',
							'description' => Leo_Helper::__( 'Enter parent element selector to which stretched sections will fit to (e.g. #primary / .wrapper / main etc). Leave blank to fit to page width.', 'elementor' ),
							'label_block' => true,
							'frontend_available' => true,
						],
						'elementor_page_title_selector' => [
							'label' => Leo_Helper::__( 'Page Title Selector', 'elementor' ),
							'type' => Controls_Manager::TEXT,
							'placeholder' => 'h1.entry-title',
							'description' => Leo_Helper::__( 'LeoElements lets you hide the page title. This works for themes that have "h1.entry-title" selector. If your theme\'s selector is different, please enter it above.', 'elementor' ),
							'label_block' => true,
						],
					],
				],
			],
			Manager::PANEL_TAB_LIGHTBOX => [
				'lightbox' => [
					'label' => Leo_Helper::__( 'Lightbox', 'elementor' ),
					'controls' => [
						'elementor_global_image_lightbox' => [
							'label' => Leo_Helper::__( 'Image Lightbox', 'elementor' ),
							'type' => Controls_Manager::SWITCHER,
							'default' => 'yes',
							'description' => Leo_Helper::__( 'Open all image links in a lightbox popup window. The lightbox will automatically work on any link that leads to an image file.', 'elementor' ),
							'frontend_available' => true,
						],
						'elementor_enable_lightbox_in_editor' => [
							'label' => Leo_Helper::__( 'Enable In Editor', 'elementor' ),
							'type' => Controls_Manager::SWITCHER,
							'default' => 'yes',
							'frontend_available' => true,
						],
						'elementor_lightbox_color' => [
							'label' => Leo_Helper::__( 'Background Color', 'elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'.elementor-lightbox' => 'background-color: {{VALUE}}',
							],
						],
						'elementor_lightbox_ui_color' => [
							'label' => Leo_Helper::__( 'UI Color', 'elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'.elementor-lightbox .dialog-lightbox-close-button, .elementor-lightbox .elementor-swiper-button' => 'color: {{VALUE}}',
							],
						],
						'elementor_lightbox_ui_color_hover' => [
							'label' => Leo_Helper::__( 'UI Hover Color', 'elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'.elementor-lightbox .dialog-lightbox-close-button:hover, .elementor-lightbox .elementor-swiper-button:hover' => 'color: {{VALUE}}',
							],
						],
					],
				],
			],
		];
	}

	/**
	 * Register model controls.
	 *
	 * Used to add new controls to the global settings model.
	 *
	 * @since 1.6.0
	 * @access protected
	 */
	protected function _register_controls() {
		$controls_list = self::get_controls_list();

		foreach ( $controls_list as $tab_name => $sections ) {

			foreach ( $sections as $section_name => $section_data ) {

				$this->start_controls_section(
					$section_name, [
						'label' => $section_data['label'],
						'tab' => $tab_name,
					]
				);

				foreach ( $section_data['controls'] as $control_name => $control_data ) {
					$this->add_control( $control_name, $control_data );
				}

				$this->end_controls_section();
			}
		}
	}
}
