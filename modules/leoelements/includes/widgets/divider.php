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
 * Elementor divider widget.
 *
 * Elementor widget that displays a line that divides different elements in the
 * page.
 *
 * @since 1.0.0
 */
class Widget_Divider extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve divider widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'divider';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve divider widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return Leo_Helper::__( 'Divider', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve divider widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-divider';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the divider widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'divider', 'hr', 'line', 'border' ];
	}

	/**
	 * Register divider widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_divider',
			[
				'label' => Leo_Helper::__( 'Divider', 'elementor' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label' => Leo_Helper::__( 'Style', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => Leo_Helper::__( 'Solid', 'elementor' ),
					'double' => Leo_Helper::__( 'Double', 'elementor' ),
					'dotted' => Leo_Helper::__( 'Dotted', 'elementor' ),
					'dashed' => Leo_Helper::__( 'Dashed', 'elementor' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'border-top-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'weight',
			[
				'label' => Leo_Helper::__( 'Weight', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'color',
			[
				'label' => Leo_Helper::__( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => Leo_Helper::__( 'Width', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'max' => 1000,
					],
				],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => Leo_Helper::__( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => Leo_Helper::__( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => Leo_Helper::__( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => Leo_Helper::__( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-divider' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label' => Leo_Helper::__( 'Gap', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-divider' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => Leo_Helper::__( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render divider widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		?>
		<div class="elementor-divider">
			<span class="elementor-divider-separator"></span>
		</div>
		<?php
	}

	/**
	 * Render divider widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<div class="elementor-divider">
			<span class="elementor-divider-separator"></span>
		</div>
		<?php
	}
}
