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
 * Elementor social icons widget.
 *
 * Elementor widget that displays icons to social pages like Facebook and Twitter.
 *
 * @since 1.0.0
 */
class Widget_Social_Icons extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve social icons widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'social-icons';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve social icons widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return Leo_Helper::__( 'Social Icons', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve social icons widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-social-icons';
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
		return [ 'social', 'icon', 'link' ];
	}

	/**
	 * Register social icons widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_social_icon',
			[
				'label' => Leo_Helper::__( 'Social Icons', 'elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'social_icon',
			[
				'label' => Leo_Helper::__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'label_block' => true,
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'recommended' => [
					'fa-brands' => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'elementor',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'google-plus',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'stumbleupon',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'tumblr',
						'twitch',
						'twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'yelp',
						'youtube',
						'500px',
					],
					'fa-solid' => [
						'envelope',
						'link',
						'rss',
					],
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => Leo_Helper::__( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'autocomplete' => false,
				'label_block' => true,
				'default' => [
					'is_external' => 'true',
				],
				'placeholder' => Leo_Helper::__( 'https://your-link.com', 'elementor' ),
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label' => Leo_Helper::__( 'Color', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => Leo_Helper::__( 'Official Color', 'elementor' ),
					'custom' => Leo_Helper::__( 'Custom', 'elementor' ),
				],
			]
		);

		$repeater->add_control(
			'item_icon_primary_color',
			[
				'label' => Leo_Helper::__( 'Primary Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'item_icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'item_icon_secondary_color',
			[
				'label' => Leo_Helper::__( 'Secondary Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'item_icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icon_list',
			[
				'label' => Leo_Helper::__( 'Social Icons', 'elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'social_icon' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon' => [
							'value' => 'fab fa-google-plus',
							'library' => 'fa-brands',
						],
					],
				],
				'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => Leo_Helper::__( 'Shape', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded',
				'options' => [
					'rounded' => Leo_Helper::__( 'Rounded', 'elementor' ),
					'square' => Leo_Helper::__( 'Square', 'elementor' ),
					'circle' => Leo_Helper::__( 'Circle', 'elementor' ),
				],
				'prefix_class' => 'elementor-shape-',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => Leo_Helper::__( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
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

		$this->start_controls_section(
			'section_social_style',
			[
				'label' => Leo_Helper::__( 'Icon', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => Leo_Helper::__( 'Color', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => Leo_Helper::__( 'Official Color', 'elementor' ),
					'custom' => Leo_Helper::__( 'Custom', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'icon_primary_color',
			[
				'label' => Leo_Helper::__( 'Primary Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_secondary_color',
			[
				'label' => Leo_Helper::__( 'Secondary Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-social-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => Leo_Helper::__( 'Size', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => Leo_Helper::__( 'Padding', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'unit' => 'em',
				],
				'tablet_default' => [
					'unit' => 'em',
				],
				'mobile_default' => [
					'unit' => 'em',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
			]
		);

		$icon_spacing = Leo_Helper::is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};';

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => Leo_Helper::__( 'Spacing', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:not(:last-child)' => $icon_spacing,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border', // We know this mistake - TODO: 'icon_border' (for hover control condition also)
				'selector' => '{{WRAPPER}} .elementor-social-icon',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => Leo_Helper::__( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_social_hover',
			[
				'label' => Leo_Helper::__( 'Icon Hover', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => Leo_Helper::__( 'Primary Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => Leo_Helper::__( 'Secondary Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-social-icon:hover svg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_border_color',
			[
				'label' => Leo_Helper::__( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'image_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => Leo_Helper::__( 'Hover Animation', 'elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render social icons widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$fallback_defaults = [
			'fa fa-facebook',
			'fa fa-twitter',
			'fa fa-google-plus',
		];

		$class_animation = '';

		if ( ! empty( $settings['hover_animation'] ) ) {
			$class_animation = ' elementor-animation-' . $settings['hover_animation'];
		}

		$migration_allowed = Icons_Manager::is_migration_allowed();

		?>
		<div class="elementor-social-icons-wrapper">
			<?php
			foreach ( $settings['social_icon_list'] as $index => $item ) {
				$migrated = isset( $item['__fa4_migrated']['social_icon'] );
				$is_new = empty( $item['social'] ) && $migration_allowed;
				$social = '';

				// add old default
				if ( empty( $item['social'] ) && ! $migration_allowed ) {
					$item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
				}

				if ( ! empty( $item['social'] ) ) {
					$social = str_replace( 'fa fa-', '', $item['social'] );
				}

				if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon']['library'] ) {
					$social = explode( ' ', $item['social_icon']['value'], 2 );
					if ( empty( $social[1] ) ) {
						$social = '';
					} else {
						$social = str_replace( 'fa-', '', $social[1] );
					}
				}
				if ( 'svg' === $item['social_icon']['library'] ) {
					$social = '';
				}

				$link_key = 'link_' . $index;

				$this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

				$this->add_render_attribute( $link_key, 'class', [
					'elementor-icon',
					'elementor-social-icon',
					'elementor-social-icon-' . $social . $class_animation,
					'elementor-repeater-item-' . $item['_id'],
				] );

				if ( $item['link']['is_external'] ) {
					$this->add_render_attribute( $link_key, 'target', '_blank' );
				}

				if ( $item['link']['nofollow'] ) {
					$this->add_render_attribute( $link_key, 'rel', 'nofollow' );
				}

				?>
				<a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
					<span class="elementor-screen-only"><?php echo ucwords( $social ); ?></span>
					<?php
					if ( $is_new || $migrated ) {
						Icons_Manager::render_icon( $item['social_icon'] );
					} else { ?>
						<i class="<?php echo Leo_Helper::esc_attr( $item['social'] ); ?>"></i>
					<?php } ?>
				</a>
			<?php } ?>
		</div>
		<?php
	}

	/**
	 * Render social icons widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<# var iconsHTML = {}; #>
		<div class="elementor-social-icons-wrapper">
			<# _.each( settings.social_icon_list, function( item, index ) {
				var link = item.link ? item.link.url : '',
					migrated = elementor.helpers.isIconMigrated( item, 'social_icon' );
					social = elementor.helpers.getSocialNetworkNameFromIcon( item.social_icon, item.social, false, migrated );
				#>
				<a class="elementor-icon elementor-social-icon elementor-social-icon-{{ social }} elementor-animation-{{ settings.hover_animation }} elementor-repeater-item-{{item._id}}" href="{{ link }}">
					<span class="elementor-screen-only">{{{ social }}}</span>
					<#
						iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.social_icon, {}, 'i', 'object' );
						if ( ( ! item.social || migrated ) && iconsHTML[ index ] && iconsHTML[ index ].rendered ) { #>
							{{{ iconsHTML[ index ].value }}}
						<# } else { #>
							<i class="{{ item.social }}"></i>
						<# }
					#>
				</a>
			<# } ); #>
		</div>
		<?php
	}
}