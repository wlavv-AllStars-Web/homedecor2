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

use LeoElements\Leo_Helper; 

if ( ! defined( '_PS_VERSION_' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * @var array $reports
 */
foreach ( $reports as $report_name => $report ) : ?>
	<div class="elementor-system-info-section elementor-system-info-<?php echo Leo_Helper::esc_attr( $report_name ); ?>">
		<table class="widefat">
			<thead>
			<tr>
				<th><?php echo $report['label']; ?></th>
				<th></th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ( $report['report'] as $field_name => $field ) :
				if ( in_array( $report_name, [ 'plugins', 'network_plugins', 'mu_plugins' ], true ) ) {
					foreach ( $field['value'] as $plugin ) :
						?>
						<tr>
							<td>
								<?php
								if ( $plugin['PluginURI'] ) :
									$plugin_name = "<a href='{$plugin['PluginURI']}'>{$plugin['Name']}</a>";
								else :
									$plugin_name = $plugin['Name'];
								endif;

								if ( $plugin['Version'] ) :
									$plugin_name .= ' - ' . $plugin['Version'];
								endif;

								echo $plugin_name;
								?>
							</td>
							<td>
								<?php
								if ( $plugin['Author'] ) :
									if ( $plugin['AuthorURI'] ) :
										$author = "<a href='{$plugin['AuthorURI']}'>{$plugin['Author']}</a>";
									else :
										$author = $plugin['Author'];
									endif;

									echo "By $author";
								endif;
								?>
							</td>
							<td></td>
						</tr>
						<?php
					endforeach;
				} else {
					$warning_class = ! empty( $field['warning'] ) ? ' class="elementor-warning"' : '';
					$log_label = ! empty( $field['label'] ) ? $field['label'] . ':' : '';
					?>
					<tr<?php echo $warning_class; ?>>
						<td><?php echo $log_label; ?></td>
						<td><?php echo $field['value']; ?></td>
						<td><?php
						if ( ! empty( $field['recommendation'] ) ) :
							echo $field['recommendation'];
						endif;
						?>
						</td>
					</tr>
					<?php
				}
			endforeach;
			?>
			</tbody>
		</table>
	</div>
	<?php
endforeach;
