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

namespace LeoElements\Src;

use Tools;
use LeoElements\Leo_Helper;

final class _LEO_Editors {
	public static $mce_locale;

	private static $mce_settings = array();
	private static $qt_settings  = array();
	private static $plugins      = array();
	private static $qt_buttons   = array();
	private static $ext_plugins;
	private static $baseurl;
	private static $first_init;
	private static $this_tinymce       = false;
	private static $this_quicktags     = false;
	private static $has_tinymce        = false;
	private static $has_quicktags      = false;
	private static $has_medialib       = false;
	private static $editor_buttons_css = true;
	private static $drag_drop_upload   = false;
	private static $translation;
	private static $tinymce_scripts_printed = false;
	private static $link_dialog_printed     = false;

	private function __construct() {}

	/**
	 * Parse default arguments for the editor instance.
	 *
	 * @since 3.3.0
	 *
	 * @param string $editor_id HTML ID for the textarea and TinyMCE and Quicktags instances.
	 *                          Should not contain square brackets.
	 * @param array  $settings {
	 *     Array of editor arguments.
	 *
	 *     @type bool       $wpautop           Whether to use wpautop(). Default true.
	 *     @type bool       $media_buttons     Whether to show the Add Media/other media buttons.
	 *     @type string     $default_editor    When both TinyMCE and Quicktags are used, set which
	 *                                         editor is shown on page load. Default empty.
	 *     @type bool       $drag_drop_upload  Whether to enable drag & drop on the editor uploading. Default false.
	 *                                         Requires the media modal.
	 *     @type string     $textarea_name     Give the textarea a unique name here. Square brackets
	 *                                         can be used here. Default $editor_id.
	 *     @type int        $textarea_rows     Number rows in the editor textarea. Default 20.
	 *     @type string|int $tabindex          Tabindex value to use. Default empty.
	 *     @type string     $tabfocus_elements The previous and next element ID to move the focus to
	 *                                         when pressing the Tab key in TinyMCE. Default ':prev,:next'.
	 *     @type string     $editor_css        Intended for extra styles for both Visual and Text editors.
	 *                                         Should include `<style>` tags, and can use "scoped". Default empty.
	 *     @type string     $editor_class      Extra classes to add to the editor textarea element. Default empty.
	 *     @type bool       $teeny             Whether to output the minimal editor config. Examples include
	 *                                         Press This and the Comment editor. Default false.
	 *     @type bool       $dfw               Deprecated in 4.1. Unused.
	 *     @type bool|array $tinymce           Whether to load TinyMCE. Can be used to pass settings directly to
	 *                                         TinyMCE using an array. Default true.
	 *     @type bool|array $quicktags         Whether to load Quicktags. Can be used to pass settings directly to
	 *                                         Quicktags using an array. Default true.
	 * }
	 * @return array Parsed arguments array.
	 */
	public static function parse_settings( $editor_id, $settings ) {

		/**
		 * Filters the wp_editor() settings.
		 *
		 * @since 4.0.0
		 *
		 * @see _LEO_Editors::parse_settings()
		 *
		 * @param array  $settings  Array of editor arguments.
		 * @param string $editor_id Unique editor identifier, e.g. 'content'. Accepts 'classic-block'
		 *                          when called from block editor's Classic block.
		 */
		$settings = Leo_Helper::apply_filters( 'wp_editor_settings', $settings, $editor_id );

		$set = Leo_Helper::wp_parse_args(
			$settings,
			array(
				// Disable autop if the current post has blocks in it.
				'wpautop'             => false,
				'media_buttons'       => true,
				'default_editor'      => '',
				'drag_drop_upload'    => false,
				'textarea_name'       => $editor_id,
				'textarea_rows'       => 20,
				'tabindex'            => '',
				'tabfocus_elements'   => ':prev,:next',
				'editor_css'          => '',
				'editor_class'        => '',
				'teeny'               => false,
				'_content_editor_dfw' => false,
				'tinymce'             => true,
				'quicktags'           => true,
			)
		);

		self::$this_tinymce = ( $set['tinymce'] && true );

		if ( self::$this_tinymce ) {
			if ( false !== strpos( $editor_id, '[' ) ) {
				self::$this_tinymce = false;
				_deprecated_argument( 'wp_editor()', '3.9.0', 'TinyMCE editor IDs cannot have brackets.' );
			}
		}

		self::$this_quicktags = (bool) $set['quicktags'];

		if ( self::$this_tinymce ) {
			self::$has_tinymce = true;
		}

		if ( self::$this_quicktags ) {
			self::$has_quicktags = true;
		}

		if ( empty( $set['editor_height'] ) ) {
			return $set;
		}

		if ( 'content' === $editor_id && empty( $set['tinymce']['wp_autoresize_on'] ) ) {
			// A cookie (set when a user resizes the editor) overrides the height.
			$cookie = (int) get_user_setting( 'ed_size' );

			if ( $cookie ) {
				$set['editor_height'] = $cookie;
			}
		}

		if ( $set['editor_height'] < 50 ) {
			$set['editor_height'] = 50;
		} elseif ( $set['editor_height'] > 5000 ) {
			$set['editor_height'] = 5000;
		}

		return $set;
	}

	/**
	 * Outputs the HTML for a single instance of the editor.
	 *
	 * @since 3.3.0
	 *
	 * @param string $content   Initial content for the editor.
	 * @param string $editor_id HTML ID for the textarea and TinyMCE and Quicktags instances.
	 *                          Should not contain square brackets.
	 * @param array  $settings  See _LEO_Editors::parse_settings() for description.
	 */
	public static function editor( $content, $editor_id, $settings = array() ) {
		$set            = self::parse_settings( $editor_id, $settings );
		$editor_class   = ' class="' . trim( Leo_Helper::esc_attr( $set['editor_class'] ) . ' wp-editor-area' ) . '"';
		$tabindex       = $set['tabindex'] ? ' tabindex="' . (int) $set['tabindex'] . '"' : '';
		$default_editor = 'html';
		$buttons        = '';
		$autocomplete   = '';
		$editor_id_attr = Leo_Helper::esc_attr( $editor_id );

		if ( ! empty( $set['editor_height'] ) ) {
			$height = ' style="height: ' . (int) $set['editor_height'] . 'px"';
		} else {
			$height = ' rows="' . (int) $set['textarea_rows'] . '"';
		}

		if ( self::$this_tinymce ) {
			$autocomplete = ' autocomplete="off"';

			if ( self::$this_quicktags ) {
				$default_editor = $set['default_editor'] ? $set['default_editor'] : 'tinymce';
				// 'html' is used for the "Text" editor tab.
				if ( 'html' !== $default_editor ) {
					$default_editor = 'tinymce';
				}

				$buttons .= '<button type="button" id="' . $editor_id_attr . '-tmce" class="wp-switch-editor switch-tmce"' .
					' data-wp-editor-id="' . $editor_id_attr . '">' . Leo_Helper::_x( 'Visual', 'Name for the Visual editor tab' ) . "</button>\n";
				$buttons .= '<button type="button" id="' . $editor_id_attr . '-html" class="wp-switch-editor switch-html"' .
					' data-wp-editor-id="' . $editor_id_attr . '">' . Leo_Helper::_x( 'Text', 'Name for the Text editor tab (formerly HTML)' ) . "</button>\n";
			} else {
				$default_editor = 'tinymce';
			}
		}

		$switch_class = 'html' === $default_editor ? 'html-active' : 'tmce-active';
		$wrap_class   = 'wp-core-ui wp-editor-wrap ' . $switch_class;

		if ( $set['_content_editor_dfw'] ) {
			$wrap_class .= ' has-dfw';
		}

		echo '<div id="wp-' . $editor_id_attr . '-wrap" class="' . $wrap_class . '">';

		if ( self::$editor_buttons_css ) {
			self::$editor_buttons_css = false;
		}

		if ( ! empty( $set['editor_css'] ) ) {
			echo $set['editor_css'] . "\n";
		}

		if ( ! empty( $buttons ) || $set['media_buttons'] ) {
			echo '<div id="wp-' . $editor_id_attr . '-editor-tools" class="wp-editor-tools hide-if-no-js">';

			if ( $set['media_buttons'] ) {
				self::$has_medialib = true;

				echo '<div id="wp-' . $editor_id_attr . '-media-buttons" class="wp-media-buttons">';

				/**
				 * Fires after the default media button(s) are displayed.
				 *
				 * @since 1.0.0
				 *
				 * @param string $editor_id Unique editor identifier, e.g. 'content'.
				 */
				Leo_Helper::do_action( 'media_buttons', $editor_id );
				echo "</div>\n";
			}

			echo '<div class="wp-editor-tabs">' . $buttons . "</div>\n";
			echo "</div>\n";
		}

		$quicktags_toolbar = '';

		if ( self::$this_quicktags ) {
			if ( 'content' === $editor_id && ! empty( $GLOBALS['current_screen'] ) && 'post' === $GLOBALS['current_screen']->base ) {
				$toolbar_id = 'ed_toolbar';
			} else {
				$toolbar_id = 'qt_' . $editor_id_attr . '_toolbar';
			}

			$quicktags_toolbar = '<div id="' . $toolbar_id . '" class="quicktags-toolbar"></div>';
		}

		/**
		 * Filters the HTML markup output that displays the editor.
		 *
		 * @since 1.0.0
		 *
		 * @param string $output Editor's HTML markup.
		 */
		$the_editor = Leo_Helper::apply_filters(
			'the_editor',
			'<div id="wp-' . $editor_id_attr . '-editor-container" class="wp-editor-container">' .
			$quicktags_toolbar .
			'<textarea' . $editor_class . $height . $tabindex . $autocomplete . ' cols="40" name="' . Leo_Helper::esc_attr( $set['textarea_name'] ) . '" ' .
			'id="' . $editor_id_attr . '">%s</textarea></div>'
		);

		// Prepare the content for the Visual or Text editor, only when TinyMCE is used (back-compat).
		if ( self::$this_tinymce ) {
			Leo_Helper::add_filter( 'the_editor_content', 'format_for_editor', 10, 2 );
		}

		if ( false !== stripos( $content, 'textarea' ) ) {
			$content = preg_replace( '%</textarea%i', '&lt;/textarea', $content );
		}

		printf( $the_editor, $content );
		echo "\n</div>\n\n";

		self::editor_settings( $editor_id, $set );
	}

	/**
	 * @since 3.3.0
	 *
	 * @param string $editor_id Unique editor identifier, e.g. 'content'.
	 * @param array  $set       Array of editor arguments.
	 */
	public static function editor_settings( $editor_id, $set ) {
		if ( empty( self::$first_init ) ) {
			Leo_Helper::add_action( 'admin_print_footer_scripts', array( __CLASS__, 'enqueue_scripts' ), 1 );
		}

		if ( self::$this_quicktags ) {

			$qtInit = array(
				'id'      => $editor_id,
				'buttons' => '',
			);

			if ( is_array( $set['quicktags'] ) ) {
				$qtInit = array_merge( $qtInit, $set['quicktags'] );
			}

			if ( empty( $qtInit['buttons'] ) ) {
				$qtInit['buttons'] = 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close';
			}

			if ( $set['_content_editor_dfw'] ) {
				$qtInit['buttons'] .= ',dfw';
			}

			/**
			 * Filters the Quicktags settings.
			 *
			 * @since 3.3.0
			 *
			 * @param array  $qtInit    Quicktags settings.
			 * @param string $editor_id Unique editor identifier, e.g. 'content'.
			 */
			$qtInit = Leo_Helper::apply_filters( 'quicktags_settings', $qtInit, $editor_id );

			self::$qt_settings[ $editor_id ] = $qtInit;

			self::$qt_buttons = array_merge( self::$qt_buttons, explode( ',', $qtInit['buttons'] ) );
		}

		if ( self::$this_tinymce ) {

			if ( empty( self::$first_init ) ) {
				$baseurl     = self::get_baseurl();
				$mce_locale  = self::get_mce_locale();
				$ext_plugins = '';
				/**
				 * Filters the list of TinyMCE external plugins.
				 *
				 * The filter takes an associative array of external plugins for
				 * TinyMCE in the form 'plugin_name' => 'url'.
				 *
				 * The url should be absolute, and should include the js filename
				 * to be loaded. For example:
				 * 'myplugin' => 'http://mysite.com/wp-content/plugins/myfolder/mce_plugin.js'.
				 *
				 * If the external plugin adds a button, it should be added with
				 * one of the 'mce_buttons' filters.
				 *
				 * @since 1.0.0
				 * @since 5.3.0 The `$editor_id` parameter was added.
				 *
				 * @param array  $external_plugins An array of external TinyMCE plugins.
				 * @param string $editor_id        Unique editor identifier, e.g. 'content'. Accepts 'classic-block'
				 *                                 when called from block editor's Classic block.
				 */
				$mce_external_plugins = Leo_Helper::apply_filters( 'mce_external_plugins', array(), $editor_id );

				$plugins = array(
					'code',
					'charmap',
					'colorpicker',
					'hr',
					'lists',
					'media',
					'paste',
					'tabfocus',
					'textcolor',
					'fullscreen',
					'table',
					'image',
					'link',
				);

				/**
				 * Filters the list of default TinyMCE plugins.
				 *
				 * The filter specifies which of the default plugins included
				 * in WordPress should be added to the TinyMCE instance.
				 *
				 * @since 3.3.0
				 * @since 5.3.0 The `$editor_id` parameter was added.
				 *
				 * @param array  $plugins   An array of default TinyMCE plugins.
				 * @param string $editor_id Unique editor identifier, e.g. 'content'. Accepts 'classic-block'
				 *                          when called from block editor's Classic block.
				 */
				$plugins = array_unique( Leo_Helper::apply_filters( 'tiny_mce_plugins', $plugins, $editor_id ) );

				$key = array_search( 'spellchecker', $plugins, true );
				if ( false !== $key ) {
					// Remove 'spellchecker' from the internal plugins if added with 'tiny_mce_plugins' filter to prevent errors.
					// It can be added with 'mce_external_plugins'.
					unset( $plugins[ $key ] );
				}

				if ( ! empty( $mce_external_plugins ) ) {

					/**
					 * Filters the translations loaded for external TinyMCE 3.x plugins.
					 *
					 * The filter takes an associative array ('plugin_name' => 'path')
					 * where 'path' is the include path to the file.
					 *
					 * The language file should follow the same format as wp_mce_translation(),
					 * and should define a variable ($strings) that holds all translated strings.
					 *
					 * @since 1.0.0
					 * @since 5.3.0 The `$editor_id` parameter was added.
					 *
					 * @param array  $translations Translations for external TinyMCE plugins.
					 * @param string $editor_id    Unique editor identifier, e.g. 'content'.
					 */
					$mce_external_languages = Leo_Helper::apply_filters( 'mce_external_languages', array(), $editor_id );

					$loaded_langs = array();
					$strings      = '';

					if ( ! empty( $mce_external_languages ) ) {
						foreach ( $mce_external_languages as $name => $path ) {
							if ( @is_file( $path ) && @is_readable( $path ) ) {
								include_once $path;
								$ext_plugins   .= $strings . "\n";
								$loaded_langs[] = $name;
							}
						}
					}

					foreach ( $mce_external_plugins as $name => $url ) {
						if ( in_array( $name, $plugins, true ) ) {
							unset( $mce_external_plugins[ $name ] );
							continue;
						}

						$url                           = set_url_scheme( $url );
						$mce_external_plugins[ $name ] = $url;
						$plugurl                       = dirname( $url );
						$strings                       = '';

						$ext_plugins .= 'tinyMCEPreInit.load_ext("' . $plugurl . '", "' . $mce_locale . '");' . "\n";
					}
				}

				self::$plugins     = $plugins;
				self::$ext_plugins = $ext_plugins;

				$settings            = self::default_settings();
				$settings['plugins'] = implode( ',', $plugins );

				if ( ! empty( $mce_external_plugins ) ) {
					$settings['external_plugins'] = json_encode( $mce_external_plugins );
				}

				/** This filter is documented in wp-admin/includes/media.php */
				if ( Leo_Helper::apply_filters( 'disable_captions', '' ) ) {
					$settings['wpeditimage_disable_captions'] = true;
				}

				$mce_css = $settings['content_css'];

				/**
				 * Filters the comma-delimited list of stylesheets to load in TinyMCE.
				 *
				 * @since 1.0.0
				 *
				 * @param string $stylesheets Comma-delimited list of stylesheets.
				 */
				$mce_css = trim( Leo_Helper::apply_filters( 'mce_css', $mce_css ), ' ,' );

				if ( ! empty( $mce_css ) ) {
					$settings['content_css'] = $mce_css;
				} else {
					unset( $settings['content_css'] );
				}

				self::$first_init = $settings;
			}

			$mce_buttons = array(
				'code',
				'colorpicker',
				'bold',
				'italic',
				'bullist',
				'numlist',
				'blockquote',
				'alignleft',
				'aligncenter',
				'alignright',
				'fullscreen'
			);
			$mce_buttons = Leo_Helper::apply_filters( 'mce_buttons', $mce_buttons, $editor_id );

			$mce_buttons_2 = array(
				'strikethrough',
				'hr',
				'removeformat',
				'charmap',
			);
			$mce_buttons_2 = Leo_Helper::apply_filters( 'mce_buttons_2', $mce_buttons_2, $editor_id );
			
			$mce_buttons_3 = array(				
				'outdent',
				'indent',
				'undo',
				'redo',
				'formatselect',
				'table'
			);
			$mce_buttons_3 = Leo_Helper::apply_filters( 'mce_buttons_3', $mce_buttons_3, $editor_id );

			$mce_buttons_4 = array(				
				'link',
				'unlink',
				'image',
				'media',
			);
			$mce_buttons_4 = Leo_Helper::apply_filters( 'mce_buttons_4', $mce_buttons_4, $editor_id );

			$body_class = $editor_id;

			if ( ! empty( $set['tinymce']['body_class'] ) ) {
				$body_class .= ' ' . $set['tinymce']['body_class'];
				unset( $set['tinymce']['body_class'] );
			}

			$mceInit = array(
				'selector'          => "#$editor_id",
				'wpautop'           => (bool) $set['wpautop'],
				'indent'            => ! $set['wpautop'],
				'toolbar1'          => implode( ',', $mce_buttons ),
				'toolbar2'          => implode( ',', $mce_buttons_2 ),
				'toolbar3'          => implode( ',', $mce_buttons_3 ),
				'toolbar4'          => implode( ',', $mce_buttons_4 ),
				'tabfocus_elements' => $set['tabfocus_elements'],
				'body_class'        => $body_class,
			);

			// Merge with the first part of the init array.
			$mceInit = array_merge( self::$first_init, $mceInit );

			if ( is_array( $set['tinymce'] ) ) {
				$mceInit = array_merge( $mceInit, $set['tinymce'] );
			}

			/*
			 * For people who really REALLY know what they're doing with TinyMCE
			 * You can modify $mceInit to add, remove, change elements of the config
			 * before tinyMCE.init. Setting "valid_elements", "invalid_elements"
			 * and "extended_valid_elements" can be done through this filter. Best
			 * is to use the default cleanup by not specifying valid_elements,
			 * as TinyMCE checks against the full set of HTML 5.0 elements and attributes.
			 */
			if ( $set['teeny'] ) {

				/**
				 * Filters the teenyMCE config before init.
				 *
				 * @since 2.7.0
				 * @since 3.3.0 The `$editor_id` parameter was added.
				 *
				 * @param array  $mceInit   An array with teenyMCE config.
				 * @param string $editor_id Unique editor identifier, e.g. 'content'.
				 */
				$mceInit = Leo_Helper::apply_filters( 'teeny_mce_before_init', $mceInit, $editor_id );
			} else {

				/**
				 * Filters the TinyMCE config before init.
				 *
				 * @since 1.0.0
				 * @since 3.3.0 The `$editor_id` parameter was added.
				 *
				 * @param array  $mceInit   An array with TinyMCE config.
				 * @param string $editor_id Unique editor identifier, e.g. 'content'. Accepts 'classic-block'
				 *                          when called from block editor's Classic block.
				 */
				$mceInit = Leo_Helper::apply_filters( 'tiny_mce_before_init', $mceInit, $editor_id );
			}

			if ( empty( $mceInit['toolbar3'] ) && ! empty( $mceInit['toolbar4'] ) ) {
				$mceInit['toolbar3'] = $mceInit['toolbar4'];
				$mceInit['toolbar4'] = '';
			}

			self::$mce_settings[ $editor_id ] = $mceInit;
		} // End if self::$this_tinymce.
	}

	/**
	 * @since 3.3.0
	 *
	 * @param array $init
	 * @return string
	 */
	private static function _parse_init( $init ) {
		$options = '';

		foreach ( $init as $key => $value ) {
			if ( is_bool( $value ) ) {
				$val      = $value ? 'true' : 'false';
				$options .= $key . ':' . $val . ',';
				continue;
			} elseif ( ! empty( $value ) && is_string( $value ) && (
				( '{' === $value[0] && '}' === $value[ strlen( $value ) - 1 ] ) ||
				( '[' === $value[0] && ']' === $value[ strlen( $value ) - 1 ] ) ||
				preg_match( '/^\(?function ?\(/', $value ) ) ) {

				$options .= $key . ':' . $value . ',';
				continue;
			}
			$options .= $key . ':"' . $value . '",';
		}

		return '{' . trim( $options, ' ,' ) . '}';
	}

	/**
	 * @since 3.3.0
	 *
	 * @param bool $default_scripts Optional. Whether default scripts should be enqueued. Default false.
	 */
	public static function enqueue_scripts( $default_scripts = false ) {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		echo '<script src="' . LEOELEMENTS_ASSETS_URL . 'lib/wp-editor/editor' . $suffix . '.js"></script>' . PHP_EOL;
		echo '<script src="' . LEOELEMENTS_ASSETS_URL . 'lib/wp-editor/utils.min.js"></script>' . PHP_EOL;
		echo '<script src="' . LEOELEMENTS_ASSETS_URL . 'lib/wp-editor/quicktags' . $suffix . '.js"></script>' . PHP_EOL;
		echo '<link rel="stylesheet" href="' . LEOELEMENTS_ASSETS_URL . 'lib/wp-editor/editor' . $suffix . '.css' . '" media="all" />' . PHP_EOL;
		echo '<link rel="stylesheet" href="' . LEOELEMENTS_ASSETS_URL . 'lib/wp-editor/skin.min.css' . '" media="all" />' . PHP_EOL;
	}

	/**
	 * Print (output) all editor scripts and default settings.
	 * For use when the editor is going to be initialized after page load.
	 *
	 * @since 4.8.0
	 */
	public static function print_default_editor_scripts() {
		$user_can_richedit = true;

		if ( $user_can_richedit ) {
			$settings = self::default_settings();

			$settings['toolbar1']    = 'bold,italic,bullist,numlist,link';
			$settings['wpautop']     = false;
			$settings['indent']      = true;
			$settings['elementpath'] = false;

			if ( Leo_Helper::is_rtl() ) {
				$settings['directionality'] = 'rtl';
			}

			/*
			 * In production all plugins are loaded (they are in wp-editor.js.gz).
			 * The 'wpview', 'wpdialogs', and 'media' TinyMCE plugins are not initialized by default.
			 * Can be added from js by using the 'wp-before-tinymce-init' event.
			 */
			$settings['plugins'] = implode(
				',',
				array(
					'charmap',
					'colorpicker',
					'hr',
					'lists',
					'paste',
					'tabfocus',
					'textcolor',
					'fullscreen',
				)
			);

			$settings = self::_parse_init( $settings );
		} else {
			$settings = '{}';
		}

		?>
		<script type="text/javascript">
		window.wp = window.wp || {};
		window.wp.editor = window.wp.editor || {};
		window.wp.editor.getDefaultSettings = function() {
			return {
				tinymce: <?php echo $settings; ?>,
				quicktags: {
					buttons: 'strong,em,ul,ol,li,code'
				}
			};
		};

		<?php

		if ( $user_can_richedit ) {
			$suffix  = '.min';
			$baseurl = self::get_baseurl();

			?>
			var tinyMCEPreInit = {
				baseURL: "<?php echo $baseurl; ?>",
				suffix: "<?php echo $suffix; ?>",
				mceInit: {},
				qtInit: {},
				load_ext: function(url,lang){var sl=tinymce.ScriptLoader;sl.markDone(url+'/langs/'+lang+'.js');sl.markDone(url+'/langs/'+lang+'_dlg.js');}
			};
			<?php
		}
		?>
		</script>
		<?php

		if ( $user_can_richedit ) {
			self::print_tinymce_scripts();
		}

		/**
		 * Fires when the editor scripts are loaded for later initialization,
		 * after all scripts and settings are printed.
		 *
		 * @since 4.8.0
		 */
		Leo_Helper::do_action( 'print_default_editor_scripts' );
	}

	/**
	 * Returns the TinyMCE locale.
	 *
	 * @since 4.8.0
	 *
	 * @return string
	 */
	public static function get_mce_locale() {
		if ( empty( self::$mce_locale ) ) {
			$mce_locale       = \Context::getContext()->language->iso_code;
			self::$mce_locale = empty( $mce_locale ) ? 'en' : strtolower( substr( $mce_locale, 0, 2 ) ); // ISO 639-1.
		}

		return self::$mce_locale;
	}

	/**
	 * Returns the TinyMCE base URL.
	 *
	 * @since 4.8.0
	 *
	 * @return string
	 */
	public static function get_baseurl() {
		if ( empty( self::$baseurl ) ) {
			self::$baseurl = _PS_JS_DIR_ . 'tiny_mce';
		}

		return self::$baseurl;
	}

	/**
	 * Returns the default TinyMCE settings.
	 * Doesn't include plugins, buttons, editor selector.
	 *
	 * @since 4.8.0
	 *
	 * @global string $tinymce_version
	 *
	 * @return array
	 */
	private static function default_settings() {
		$tinymce_version = '4.0.16';

		$shortcut_labels = array();

		foreach ( self::get_translation() as $name => $value ) {
			if ( is_array( $value ) ) {
				$shortcut_labels[ $name ] = $value[1];
			}
		}

		$settings = array(
			'theme'                        => 'modern',
			'skin'                         => 'prestashop',
			'language'                     => self::get_mce_locale(),
			'formats'                      => '{' .
				'alignleft: [' .
					'{selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"left"}},' .
					'{selector: "img,table,dl.wp-caption", classes: "alignleft"}' .
				'],' .
				'aligncenter: [' .
					'{selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"center"}},' .
					'{selector: "img,table,dl.wp-caption", classes: "aligncenter"}' .
				'],' .
				'alignright: [' .
					'{selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li", styles: {textAlign:"right"}},' .
					'{selector: "img,table,dl.wp-caption", classes: "alignright"}' .
				'],' .
				'strikethrough: {inline: "del"}' .
			'}',
			'relative_urls'                => false,
			'remove_script_host'           => false,
			'convert_urls'                 => false,
			'browser_spellcheck'           => true,
			'fix_list_elements'            => true,
			'entities'                     => '38,amp,60,lt,62,gt',
			'entity_encoding'              => 'raw',
			'keep_styles'                  => false,
			'cache_suffix'                 => 'wp-mce-' . $tinymce_version,
			'resize'                       => 'vertical',
			'menubar'                      => false,
			'branding'                     => false,

			// Limit the preview styles in the menu/toolbar.
			'preview_styles'               => 'font-family font-size font-weight font-style text-decoration text-transform',

			'end_container_on_empty_block' => true,
			'wpeditimage_html5_captions'   => true,
			'wp_lang_attr'                 => \Context::getContext()->language->iso_code,
			'wp_keep_scroll_position'      => false,
			'wp_shortcut_labels'           => json_encode( $shortcut_labels ),
						
			'filemanager_title'	       => Leo_Helper::__( 'File manager' ),
			'external_plugins'	       => '{"filemanager":"' . Leo_Helper::get_base_admin_dir() . 'filemanager/plugin.min.js"}',
			'external_filemanager_path'    => Leo_Helper::get_base_admin_dir() ."filemanager/",
		);

		$suffix  = '.min';
		$version = 'ver=' . $tinymce_version;

		// Default stylesheets.
		$settings['content_css'] = '';

		return $settings;
	}

	/**
	 * @since 4.7.0
	 *
	 * @return array
	 */
	private static function get_translation() {
		if ( empty( self::$translation ) ) {
			self::$translation = array(
				// Default TinyMCE strings.
				'New document'                         => Leo_Helper::__( 'New document' ),
				'Formats'                              => Leo_Helper::_x( 'Formats', 'TinyMCE' ),

				'Headings'                             => Leo_Helper::_x( 'Headings', 'TinyMCE' ),
				'Heading 1'                            => array( Leo_Helper::__( 'Heading 1' ), 'access1' ),
				'Heading 2'                            => array( Leo_Helper::__( 'Heading 2' ), 'access2' ),
				'Heading 3'                            => array( Leo_Helper::__( 'Heading 3' ), 'access3' ),
				'Heading 4'                            => array( Leo_Helper::__( 'Heading 4' ), 'access4' ),
				'Heading 5'                            => array( Leo_Helper::__( 'Heading 5' ), 'access5' ),
				'Heading 6'                            => array( Leo_Helper::__( 'Heading 6' ), 'access6' ),

				/* translators: Block tags. */
				'Blocks'                               => Leo_Helper::_x( 'Blocks', 'TinyMCE' ),
				'Paragraph'                            => array( Leo_Helper::__( 'Paragraph' ), 'access7' ),
				'Blockquote'                           => array( Leo_Helper::__( 'Blockquote' ), 'accessQ' ),
				'Div'                                  => Leo_Helper::_x( 'Div', 'HTML tag' ),
				'Pre'                                  => Leo_Helper::_x( 'Pre', 'HTML tag' ),
				'Preformatted'                         => Leo_Helper::_x( 'Preformatted', 'HTML tag' ),
				'Address'                              => Leo_Helper::_x( 'Address', 'HTML tag' ),

				'Inline'                               => Leo_Helper::_x( 'Inline', 'HTML elements' ),
				'Underline'                            => array( Leo_Helper::__( 'Underline' ), 'metaU' ),
				'Strikethrough'                        => array( Leo_Helper::__( 'Strikethrough' ), 'accessD' ),
				'Subscript'                            => Leo_Helper::__( 'Subscript' ),
				'Superscript'                          => Leo_Helper::__( 'Superscript' ),
				'Clear formatting'                     => Leo_Helper::__( 'Clear formatting' ),
				'Bold'                                 => array( Leo_Helper::__( 'Bold' ), 'metaB' ),
				'Italic'                               => array( Leo_Helper::__( 'Italic' ), 'metaI' ),
				'Code'                                 => array( Leo_Helper::__( 'Code' ), 'accessX' ),
				'Source code'                          => Leo_Helper::__( 'Source code' ),
				'Font Family'                          => Leo_Helper::__( 'Font Family' ),
				'Font Sizes'                           => Leo_Helper::__( 'Font Sizes' ),

				'Align center'                         => array( Leo_Helper::__( 'Align center' ), 'accessC' ),
				'Align right'                          => array( Leo_Helper::__( 'Align right' ), 'accessR' ),
				'Align left'                           => array( Leo_Helper::__( 'Align left' ), 'accessL' ),
				'Justify'                              => array( Leo_Helper::__( 'Justify' ), 'accessJ' ),
				'Increase indent'                      => Leo_Helper::__( 'Increase indent' ),
				'Decrease indent'                      => Leo_Helper::__( 'Decrease indent' ),

				'Cut'                                  => array( Leo_Helper::__( 'Cut' ), 'metaX' ),
				'Copy'                                 => array( Leo_Helper::__( 'Copy' ), 'metaC' ),
				'Paste'                                => array( Leo_Helper::__( 'Paste' ), 'metaV' ),
				'Select all'                           => array( Leo_Helper::__( 'Select all' ), 'metaA' ),
				'Undo'                                 => array( Leo_Helper::__( 'Undo' ), 'metaZ' ),
				'Redo'                                 => array( Leo_Helper::__( 'Redo' ), 'metaY' ),

				'Ok'                                   => Leo_Helper::__( 'OK' ),
				'Cancel'                               => Leo_Helper::__( 'Cancel' ),
				'Close'                                => Leo_Helper::__( 'Close' ),
				'Visual aids'                          => Leo_Helper::__( 'Visual aids' ),

				'Bullet list'                          => array( Leo_Helper::__( 'Bulleted list' ), 'accessU' ),
				'Numbered list'                        => array( Leo_Helper::__( 'Numbered list' ), 'accessO' ),
				'Square'                               => Leo_Helper::_x( 'Square', 'list style' ),
				'Default'                              => Leo_Helper::_x( 'Default', 'list style' ),
				'Circle'                               => Leo_Helper::_x( 'Circle', 'list style' ),
				'Disc'                                 => Leo_Helper::_x( 'Disc', 'list style' ),
				'Lower Greek'                          => Leo_Helper::_x( 'Lower Greek', 'list style' ),
				'Lower Alpha'                          => Leo_Helper::_x( 'Lower Alpha', 'list style' ),
				'Upper Alpha'                          => Leo_Helper::_x( 'Upper Alpha', 'list style' ),
				'Upper Roman'                          => Leo_Helper::_x( 'Upper Roman', 'list style' ),
				'Lower Roman'                          => Leo_Helper::_x( 'Lower Roman', 'list style' ),

				// Anchor plugin.
				'Name'                                 => Leo_Helper::_x( 'Name', 'Name of link anchor (TinyMCE)' ),
				'Anchor'                               => Leo_Helper::_x( 'Anchor', 'Link anchor (TinyMCE)' ),
				'Anchors'                              => Leo_Helper::_x( 'Anchors', 'Link anchors (TinyMCE)' ),
				'Id should start with a letter, followed only by letters, numbers, dashes, dots, colons or underscores.' =>
					Leo_Helper::__( 'Id should start with a letter, followed only by letters, numbers, dashes, dots, colons or underscores.' ),
				'Id'                                   => Leo_Helper::_x( 'Id', 'Id for link anchor (TinyMCE)' ),

				// Fullpage plugin.
				'Document properties'                  => Leo_Helper::__( 'Document properties' ),
				'Robots'                               => Leo_Helper::__( 'Robots' ),
				'Title'                                => Leo_Helper::__( 'Title' ),
				'Keywords'                             => Leo_Helper::__( 'Keywords' ),
				'Encoding'                             => Leo_Helper::__( 'Encoding' ),
				'Description'                          => Leo_Helper::__( 'Description' ),
				'Author'                               => Leo_Helper::__( 'Author' ),

				// Media, image plugins.
				'Image'                                => Leo_Helper::__( 'Image' ),
				'Insert/edit image'                    => array( Leo_Helper::__( 'Insert/edit image' ), 'accessM' ),
				'General'                              => Leo_Helper::__( 'General' ),
				'Advanced'                             => Leo_Helper::__( 'Advanced' ),
				'Source'                               => Leo_Helper::__( 'Source' ),
				'Border'                               => Leo_Helper::__( 'Border' ),
				'Constrain proportions'                => Leo_Helper::__( 'Constrain proportions' ),
				'Vertical space'                       => Leo_Helper::__( 'Vertical space' ),
				'Image description'                    => Leo_Helper::__( 'Image description' ),
				'Style'                                => Leo_Helper::__( 'Style' ),
				'Dimensions'                           => Leo_Helper::__( 'Dimensions' ),
				'Insert image'                         => Leo_Helper::__( 'Insert image' ),
				'Date/time'                            => Leo_Helper::__( 'Date/time' ),
				'Insert date/time'                     => Leo_Helper::__( 'Insert date/time' ),
				'Table of Contents'                    => Leo_Helper::__( 'Table of Contents' ),
				'Insert/Edit code sample'              => Leo_Helper::__( 'Insert/edit code sample' ),
				'Language'                             => Leo_Helper::__( 'Language' ),
				'Media'                                => Leo_Helper::__( 'Media' ),
				'Insert/edit media'                    => Leo_Helper::__( 'Insert/edit media' ),
				'Poster'                               => Leo_Helper::__( 'Poster' ),
				'Alternative source'                   => Leo_Helper::__( 'Alternative source' ),
				'Paste your embed code below:'         => Leo_Helper::__( 'Paste your embed code below:' ),
				'Insert video'                         => Leo_Helper::__( 'Insert video' ),
				'Embed'                                => Leo_Helper::__( 'Embed' ),

				// Each of these have a corresponding plugin.
				'Special character'                    => Leo_Helper::__( 'Special character' ),
				'Right to left'                        => Leo_Helper::_x( 'Right to left', 'editor button' ),
				'Left to right'                        => Leo_Helper::_x( 'Left to right', 'editor button' ),
				'Emoticons'                            => Leo_Helper::__( 'Emoticons' ),
				'Nonbreaking space'                    => Leo_Helper::__( 'Nonbreaking space' ),
				'Page break'                           => Leo_Helper::__( 'Page break' ),
				'Paste as text'                        => Leo_Helper::__( 'Paste as text' ),
				'Preview'                              => Leo_Helper::__( 'Preview' ),
				'Print'                                => Leo_Helper::__( 'Print' ),
				'Save'                                 => Leo_Helper::__( 'Save' ),
				'Fullscreen'                           => Leo_Helper::__( 'Fullscreen' ),
				'Horizontal line'                      => Leo_Helper::__( 'Horizontal line' ),
				'Horizontal space'                     => Leo_Helper::__( 'Horizontal space' ),
				'Restore last draft'                   => Leo_Helper::__( 'Restore last draft' ),
				'Insert/edit link'                     => array( Leo_Helper::__( 'Insert/edit link' ), 'metaK' ),
				'Remove link'                          => array( Leo_Helper::__( 'Remove link' ), 'accessS' ),

				// Link plugin
				'Link'                                 => Leo_Helper::__( 'Link' ),
				'Insert link'                          => Leo_Helper::__( 'Insert link' ),
				'Target'                               => Leo_Helper::__( 'Target' ),
				'New window'                           => Leo_Helper::__( 'New window' ),
				'Text to display'                      => Leo_Helper::__( 'Text to display' ),
				'Url'                                  => Leo_Helper::__( 'URL' ),
				'The URL you entered seems to be an email address. Do you want to add the required mailto: prefix?' =>
					Leo_Helper::__( 'The URL you entered seems to be an email address. Do you want to add the required mailto: prefix?' ),
				'The URL you entered seems to be an external link. Do you want to add the required http:// prefix?' =>
					Leo_Helper::__( 'The URL you entered seems to be an external link. Do you want to add the required http:// prefix?' ),

				'Color'                                => Leo_Helper::__( 'Color' ),
				'Custom color'                         => Leo_Helper::__( 'Custom color' ),
				'Custom...'                            => Leo_Helper::_x( 'Custom...', 'label for custom color' ), // No ellipsis.
				'No color'                             => Leo_Helper::__( 'No color' ),
				'R'                                    => Leo_Helper::_x( 'R', 'Short for red in RGB' ),
				'G'                                    => Leo_Helper::_x( 'G', 'Short for green in RGB' ),
				'B'                                    => Leo_Helper::_x( 'B', 'Short for blue in RGB' ),

				// Spelling, search/replace plugins.
				'Could not find the specified string.' => Leo_Helper::__( 'Could not find the specified string.' ),
				'Replace'                              => Leo_Helper::_x( 'Replace', 'find/replace' ),
				'Next'                                 => Leo_Helper::_x( 'Next', 'find/replace' ),
				/* translators: Previous. */
				'Prev'                                 => Leo_Helper::_x( 'Prev', 'find/replace' ),
				'Whole words'                          => Leo_Helper::_x( 'Whole words', 'find/replace' ),
				'Find and replace'                     => Leo_Helper::__( 'Find and replace' ),
				'Replace with'                         => Leo_Helper::_x( 'Replace with', 'find/replace' ),
				'Find'                                 => Leo_Helper::_x( 'Find', 'find/replace' ),
				'Replace all'                          => Leo_Helper::_x( 'Replace all', 'find/replace' ),
				'Match case'                           => Leo_Helper::__( 'Match case' ),
				'Spellcheck'                           => Leo_Helper::__( 'Check Spelling' ),
				'Finish'                               => Leo_Helper::_x( 'Finish', 'spellcheck' ),
				'Ignore all'                           => Leo_Helper::_x( 'Ignore all', 'spellcheck' ),
				'Ignore'                               => Leo_Helper::_x( 'Ignore', 'spellcheck' ),
				'Add to Dictionary'                    => Leo_Helper::__( 'Add to Dictionary' ),

				// TinyMCE tables
				'Insert table'                         => Leo_Helper::__( 'Insert table' ),
				'Delete table'                         => Leo_Helper::__( 'Delete table' ),
				'Table properties'                     => Leo_Helper::__( 'Table properties' ),
				'Row properties'                       => Leo_Helper::__( 'Table row properties' ),
				'Cell properties'                      => Leo_Helper::__( 'Table cell properties' ),
				'Border color'                         => Leo_Helper::__( 'Border color' ),

				'Row'                                  => Leo_Helper::__( 'Row' ),
				'Rows'                                 => Leo_Helper::__( 'Rows' ),
				'Column'                               => Leo_Helper::__( 'Column' ),
				'Cols'                                 => Leo_Helper::__( 'Columns' ),
				'Cell'                                 => Leo_Helper::_x( 'Cell', 'table cell' ),
				'Header cell'                          => Leo_Helper::__( 'Header cell' ),
				'Header'                               => Leo_Helper::_x( 'Header', 'table header' ),
				'Body'                                 => Leo_Helper::_x( 'Body', 'table body' ),
				'Footer'                               => Leo_Helper::_x( 'Footer', 'table footer' ),

				'Insert row before'                    => Leo_Helper::__( 'Insert row before' ),
				'Insert row after'                     => Leo_Helper::__( 'Insert row after' ),
				'Insert column before'                 => Leo_Helper::__( 'Insert column before' ),
				'Insert column after'                  => Leo_Helper::__( 'Insert column after' ),
				'Paste row before'                     => Leo_Helper::__( 'Paste table row before' ),
				'Paste row after'                      => Leo_Helper::__( 'Paste table row after' ),
				'Delete row'                           => Leo_Helper::__( 'Delete row' ),
				'Delete column'                        => Leo_Helper::__( 'Delete column' ),
				'Cut row'                              => Leo_Helper::__( 'Cut table row' ),
				'Copy row'                             => Leo_Helper::__( 'Copy table row' ),
				'Merge cells'                          => Leo_Helper::__( 'Merge table cells' ),
				'Split cell'                           => Leo_Helper::__( 'Split table cell' ),

				'Height'                               => Leo_Helper::__( 'Height' ),
				'Width'                                => Leo_Helper::__( 'Width' ),
				'Caption'                              => Leo_Helper::__( 'Caption' ),
				'Alignment'                            => Leo_Helper::__( 'Alignment' ),
				'H Align'                              => Leo_Helper::_x( 'H Align', 'horizontal table cell alignment' ),
				'Left'                                 => Leo_Helper::__( 'Left' ),
				'Center'                               => Leo_Helper::__( 'Center' ),
				'Right'                                => Leo_Helper::__( 'Right' ),
				'None'                                 => Leo_Helper::_x( 'None', 'table cell alignment attribute' ),
				'V Align'                              => Leo_Helper::_x( 'V Align', 'vertical table cell alignment' ),
				'Top'                                  => Leo_Helper::__( 'Top' ),
				'Middle'                               => Leo_Helper::__( 'Middle' ),
				'Bottom'                               => Leo_Helper::__( 'Bottom' ),

				'Row group'                            => Leo_Helper::__( 'Row group' ),
				'Column group'                         => Leo_Helper::__( 'Column group' ),
				'Row type'                             => Leo_Helper::__( 'Row type' ),
				'Cell type'                            => Leo_Helper::__( 'Cell type' ),
				'Cell padding'                         => Leo_Helper::__( 'Cell padding' ),
				'Cell spacing'                         => Leo_Helper::__( 'Cell spacing' ),
				'Scope'                                => Leo_Helper::_x( 'Scope', 'table cell scope attribute' ),

				'Insert template'                      => Leo_Helper::_x( 'Insert template', 'TinyMCE' ),
				'Templates'                            => Leo_Helper::_x( 'Templates', 'TinyMCE' ),

				'Background color'                     => Leo_Helper::__( 'Background color' ),
				'Text color'                           => Leo_Helper::__( 'Text color' ),
				'Show blocks'                          => Leo_Helper::_x( 'Show blocks', 'editor button' ),
				'Show invisible characters'            => Leo_Helper::__( 'Show invisible characters' ),

				/* translators: Word count. */
				'Words: {0}'                           => sprintf( Leo_Helper::__( 'Words: %s' ), '{0}' ),
				'Paste is now in plain text mode. Contents will now be pasted as plain text until you toggle this option off.' =>
					Leo_Helper::__( 'Paste is now in plain text mode. Contents will now be pasted as plain text until you toggle this option off.' ) . "\n\n" .
					Leo_Helper::__( 'If you&#8217;re looking to paste rich content from Microsoft Word, try turning this option off. The editor will clean up text pasted from Word automatically.' ),
				'Rich Text Area. Press ALT-F9 for menu. Press ALT-F10 for toolbar. Press ALT-0 for help' =>
					Leo_Helper::__( 'Rich Text Area. Press Alt-Shift-H for help.' ),
				'Rich Text Area. Press Control-Option-H for help.' => Leo_Helper::__( 'Rich Text Area. Press Control-Option-H for help.' ),
				'You have unsaved changes are you sure you want to navigate away?' =>
					Leo_Helper::__( 'The changes you made will be lost if you navigate away from this page.' ),
				'Your browser doesn\'t support direct access to the clipboard. Please use the Ctrl+X/C/V keyboard shortcuts instead.' =>
					Leo_Helper::__( 'Your browser does not support direct access to the clipboard. Please use keyboard shortcuts or your browser&#8217;s edit menu instead.' ),

				// TinyMCE menus.
				'Insert'                               => Leo_Helper::_x( 'Insert', 'TinyMCE menu' ),
				'File'                                 => Leo_Helper::_x( 'File', 'TinyMCE menu' ),
				'Edit'                                 => Leo_Helper::_x( 'Edit', 'TinyMCE menu' ),
				'Tools'                                => Leo_Helper::_x( 'Tools', 'TinyMCE menu' ),
				'View'                                 => Leo_Helper::_x( 'View', 'TinyMCE menu' ),
				'Table'                                => Leo_Helper::_x( 'Table', 'TinyMCE menu' ),
				'Format'                               => Leo_Helper::_x( 'Format', 'TinyMCE menu' ),

				// WordPress strings.
				'Toolbar Toggle'                       => array( Leo_Helper::__( 'Toolbar Toggle' ), 'accessZ' ),
				'Insert Read More tag'                 => array( Leo_Helper::__( 'Insert Read More tag' ), 'accessT' ),
				'Insert Page Break tag'                => array( Leo_Helper::__( 'Insert Page Break tag' ), 'accessP' ),
				'Read more...'                         => Leo_Helper::__( 'Read more...' ), // Title on the placeholder inside the editor (no ellipsis).
				'Distraction-free writing mode'        => array( Leo_Helper::__( 'Distraction-free writing mode' ), 'accessW' ),
				'No alignment'                         => Leo_Helper::__( 'No alignment' ), // Tooltip for the 'alignnone' button in the image toolbar.
				'Remove'                               => Leo_Helper::__( 'Remove' ),       // Tooltip for the 'remove' button in the image toolbar.
				'Edit|button'                          => Leo_Helper::__( 'Edit' ),         // Tooltip for the 'edit' button in the image toolbar.
				'Paste URL or type to search'          => Leo_Helper::__( 'Paste URL or type to search' ), // Placeholder for the inline link dialog.
				'Apply'                                => Leo_Helper::__( 'Apply' ),        // Tooltip for the 'apply' button in the inline link dialog.
				'Link options'                         => Leo_Helper::__( 'Link options' ), // Tooltip for the 'link options' button in the inline link dialog.
				'Visual'                               => Leo_Helper::_x( 'Visual', 'Name for the Visual editor tab' ),             // Editor switch tab label.
				'Text'                                 => Leo_Helper::_x( 'Text', 'Name for the Text editor tab (formerly HTML)' ), // Editor switch tab label.
				'Add Media'                            => array( Leo_Helper::__( 'Add Media' ), 'accessM' ), // Tooltip for the 'Add Media' button in the block editor Classic block.

				// Shortcuts help modal.
				'Keyboard Shortcuts'                   => array( Leo_Helper::__( 'Keyboard Shortcuts' ), 'accessH' ),
				'Classic Block Keyboard Shortcuts'     => Leo_Helper::__( 'Classic Block Keyboard Shortcuts' ),
				'Default shortcuts,'                   => Leo_Helper::__( 'Default shortcuts,' ),
				'Additional shortcuts,'                => Leo_Helper::__( 'Additional shortcuts,' ),
				'Focus shortcuts:'                     => Leo_Helper::__( 'Focus shortcuts:' ),
				'Inline toolbar (when an image, link or preview is selected)' => Leo_Helper::__( 'Inline toolbar (when an image, link or preview is selected)' ),
				'Editor menu (when enabled)'           => Leo_Helper::__( 'Editor menu (when enabled)' ),
				'Editor toolbar'                       => Leo_Helper::__( 'Editor toolbar' ),
				'Elements path'                        => Leo_Helper::__( 'Elements path' ),
				'Ctrl + Alt + letter:'                 => Leo_Helper::__( 'Ctrl + Alt + letter:' ),
				'Shift + Alt + letter:'                => Leo_Helper::__( 'Shift + Alt + letter:' ),
				'Cmd + letter:'                        => Leo_Helper::__( 'Cmd + letter:' ),
				'Ctrl + letter:'                       => Leo_Helper::__( 'Ctrl + letter:' ),
				'Letter'                               => Leo_Helper::__( 'Letter' ),
				'Action'                               => Leo_Helper::__( 'Action' ),
				'Warning: the link has been inserted but may have errors. Please test it.' => Leo_Helper::__( 'Warning: the link has been inserted but may have errors. Please test it.' ),
				'To move focus to other buttons use Tab or the arrow keys. To return focus to the editor press Escape or use one of the buttons.' =>
					Leo_Helper::__( 'To move focus to other buttons use Tab or the arrow keys. To return focus to the editor press Escape or use one of the buttons.' ),
				'When starting a new paragraph with one of these formatting shortcuts followed by a space, the formatting will be applied automatically. Press Backspace or Escape to undo.' =>
					Leo_Helper::__( 'When starting a new paragraph with one of these formatting shortcuts followed by a space, the formatting will be applied automatically. Press Backspace or Escape to undo.' ),
				'The following formatting shortcuts are replaced when pressing Enter. Press Escape or the Undo button to undo.' =>
					Leo_Helper::__( 'The following formatting shortcuts are replaced when pressing Enter. Press Escape or the Undo button to undo.' ),
				'The next group of formatting shortcuts are applied as you type or when you insert them around plain text in the same paragraph. Press Escape or the Undo button to undo.' =>
					Leo_Helper::__( 'The next group of formatting shortcuts are applied as you type or when you insert them around plain text in the same paragraph. Press Escape or the Undo button to undo.' ),
			);
		}

		/*
		Imagetools plugin (not included):
			'Edit image' => __( 'Edit image' ),
			'Image options' => __( 'Image options' ),
			'Back' => __( 'Back' ),
			'Invert' => __( 'Invert' ),
			'Flip horizontally' => __( 'Flip horizontal' ),
			'Flip vertically' => __( 'Flip vertical' ),
			'Crop' => __( 'Crop' ),
			'Orientation' => __( 'Orientation' ),
			'Resize' => __( 'Resize' ),
			'Rotate clockwise' => __( 'Rotate right' ),
			'Rotate counterclockwise' => __( 'Rotate left' ),
			'Sharpen' => __( 'Sharpen' ),
			'Brightness' => __( 'Brightness' ),
			'Color levels' => __( 'Color levels' ),
			'Contrast' => __( 'Contrast' ),
			'Gamma' => __( 'Gamma' ),
			'Zoom in' => __( 'Zoom in' ),
			'Zoom out' => __( 'Zoom out' ),
		*/

		return self::$translation;
	}

	/**
	 * Translates the default TinyMCE strings and returns them as JSON encoded object ready to be loaded with tinymce.addI18n(),
	 * or as JS snippet that should run after tinymce.js is loaded.
	 *
	 * @since 3.9.0
	 *
	 * @param string $mce_locale The locale used for the editor.
	 * @param bool   $json_only  Optional. Whether to include the JavaScript calls to tinymce.addI18n() and
	 *                           tinymce.ScriptLoader.markDone().
	 * @return string Translation object, JSON encoded.
	 */
	public static function wp_mce_translation( $mce_locale = '', $json_only = false ) {
		if ( ! $mce_locale ) {
			$mce_locale = self::get_mce_locale();
		}

		$mce_translation = self::get_translation();

		foreach ( $mce_translation as $name => $value ) {
			if ( is_array( $value ) ) {
				$mce_translation[ $name ] = $value[0];
			}
		}

		/**
		 * Filters translated strings prepared for TinyMCE.
		 *
		 * @since 3.9.0
		 *
		 * @param array  $mce_translation Key/value pairs of strings.
		 * @param string $mce_locale      Locale.
		 */
		$mce_translation = Leo_Helper::apply_filters( 'wp_mce_translation', $mce_translation, $mce_locale );

		foreach ( $mce_translation as $key => $value ) {
			// Remove strings that are not translated.
			if ( $key === $value ) {
				unset( $mce_translation[ $key ] );
				continue;
			}

			if ( false !== strpos( $value, '&' ) ) {
				$mce_translation[ $key ] = html_entity_decode( $value, ENT_QUOTES, 'UTF-8' );
			}
		}

		// Set direction.
		if ( Leo_Helper::is_rtl() ) {
			$mce_translation['_dir'] = 'rtl';
		}

		if ( $json_only ) {
			return json_encode( $mce_translation );
		}

		$baseurl = self::get_baseurl();

		return "tinymce.addI18n( '$mce_locale', " . json_encode( $mce_translation ) . ");\n" .
			"tinymce.ScriptLoader.markDone( '$baseurl/langs/$mce_locale.js' );\n";
	}

	/**
	 * Print (output) the main TinyMCE scripts.
	 *
	 * @since 4.8.0
	 *
	 * @global bool $concatenate_scripts
	 */
	public static function print_tinymce_scripts() {

		if ( self::$tinymce_scripts_printed ) {
			return;
		}

		self::$tinymce_scripts_printed = true;
		
		$quicktagsL10n = array(
			'closeAllOpenTags'      => Leo_Helper::__( 'Close all open tags' ),
			'closeTags'             => Leo_Helper::__( 'close tags' ),
			'enterURL'              => Leo_Helper::__( 'Enter the URL' ),
			'enterImageURL'         => Leo_Helper::__( 'Enter the URL of the image' ),
			'enterImageDescription' => Leo_Helper::__( 'Enter a description of the image' ),
			'textdirection'         => Leo_Helper::__( 'text direction' ),
			'toggleTextdirection'   => Leo_Helper::__( 'Toggle Editor Text Direction' ),
			'dfw'                   => Leo_Helper::__( 'Distraction-free writing mode' ),
			'strong'                => Leo_Helper::__( 'Bold' ),
			'strongClose'           => Leo_Helper::__( 'Close bold tag' ),
			'em'                    => Leo_Helper::__( 'Italic' ),
			'emClose'               => Leo_Helper::__( 'Close italic tag' ),
			'link'                  => Leo_Helper::__( 'Insert link' ),
			'blockquote'            => Leo_Helper::__( 'Blockquote' ),
			'blockquoteClose'       => Leo_Helper::__( 'Close blockquote tag' ),
			'del'                   => Leo_Helper::__( 'Deleted text (strikethrough)' ),
			'delClose'              => Leo_Helper::__( 'Close deleted text tag' ),
			'ins'                   => Leo_Helper::__( 'Inserted text' ),
			'insClose'              => Leo_Helper::__( 'Close inserted text tag' ),
			'image'                 => Leo_Helper::__( 'Insert image' ),
			'ul'                    => Leo_Helper::__( 'Bulleted list' ),
			'ulClose'               => Leo_Helper::__( 'Close bulleted list tag' ),
			'ol'                    => Leo_Helper::__( 'Numbered list' ),
			'olClose'               => Leo_Helper::__( 'Close numbered list tag' ),
			'li'                    => Leo_Helper::__( 'List item' ),
			'liClose'               => Leo_Helper::__( 'Close list item tag' ),
			'code'                  => Leo_Helper::__( 'Code' ),
			'codeClose'             => Leo_Helper::__( 'Close code tag' ),
			'more'                  => Leo_Helper::__( 'Insert Read More tag' ),
		);
								
		echo "<script type='text/javascript' src='" . self::get_baseurl() . "/tinymce.min.js'></script>\n";
		echo "<script type='text/javascript'>\n" . self::wp_mce_translation() . "</script>\n";
		echo "<script type='text/javascript'>var quicktagsL10n='" . json_encode( $quicktagsL10n ) . "'</script>\n";
	}

	/**
	 * Print (output) the TinyMCE configuration and initialization scripts.
	 *
	 * @since 3.3.0
	 *
	 * @global string $tinymce_version
	 */
	public static function editor_js() {
		$tinymce_version = '4.0.16';

		$tmce_on = ! empty( self::$mce_settings );
		$mceInit = '';
		$qtInit  = '';

		if ( $tmce_on ) {
			foreach ( self::$mce_settings as $editor_id => $init ) {
				$options  = self::_parse_init( $init );
				$mceInit .= "'$editor_id':{$options},";
			}
			$mceInit = '{' . trim( $mceInit, ',' ) . '}';
		} else {
			$mceInit = '{}';
		}

		if ( ! empty( self::$qt_settings ) ) {
			foreach ( self::$qt_settings as $editor_id => $init ) {
				$options = self::_parse_init( $init );
				$qtInit .= "'$editor_id':{$options},";
			}
			$qtInit = '{' . trim( $qtInit, ',' ) . '}';
		} else {
			$qtInit = '{}';
		}

		$ref = array(
			'plugins'  => implode( ',', self::$plugins ),
			'theme'    => 'modern',
			'language' => self::$mce_locale,
		);

		$suffix  = '.min';
		$baseurl = self::get_baseurl();
		$version = 'ver=' . $tinymce_version;

		/**
		 * Fires immediately before the TinyMCE settings are printed.
		 *
		 * @since 3.2.0
		 *
		 * @param array $mce_settings TinyMCE settings array.
		 */
		Leo_Helper::do_action( 'before_wp_tiny_mce', self::$mce_settings );
		?>

		<script type="text/javascript">
		tinyMCEPreInit = {
			baseURL: "<?php echo $baseurl; ?>",
			suffix: "<?php echo $suffix; ?>",
			mceInit: <?php echo $mceInit; ?>,
			qtInit: <?php echo $qtInit; ?>,
			ref: <?php echo self::_parse_init( $ref ); ?>,
			load_ext: function(url,lang){var sl=tinymce.ScriptLoader;sl.markDone(url+'/langs/'+lang+'.js');sl.markDone(url+'/langs/'+lang+'_dlg.js');}
		};
		</script>
		<?php

		if ( $tmce_on ) {
			self::print_tinymce_scripts();

			if ( self::$ext_plugins ) {
				// Load the old-format English strings to prevent unsightly labels in old style popups.
				echo "<script type='text/javascript' src='{$baseurl}/langs/en.js?$version'></script>\n";
			}
		}

		/**
		 * Fires after tinymce.js is loaded, but before any TinyMCE editor
		 * instances are created.
		 *
		 * @since 3.9.0
		 *
		 * @param array $mce_settings TinyMCE settings array.
		 */
		Leo_Helper::do_action( 'wp_tiny_mce_init', self::$mce_settings );

		?>
		<script type="text/javascript">
		<?php

		if ( self::$ext_plugins ) {
			echo self::$ext_plugins . "\n";
		}

		if ( ! Leo_Helper::is_admin() ) {
			echo 'var ajaxurl = "' . Leo_Helper::get_ajax_editor() . '";';
		}

		?>

		( function($) {
			var init, id, $wrap;

			if ( typeof tinymce !== 'undefined' ) {
				if ( tinymce.Env.ie && tinymce.Env.ie < 11 ) {
					$( '.wp-editor-wrap ' ).removeClass( 'tmce-active' ).addClass( 'html-active' );
					return;
				}

				for ( id in tinyMCEPreInit.mceInit ) {
					init = tinyMCEPreInit.mceInit[id];
					$wrap = $( '#wp-' + id + '-wrap' );

					if ( ( $wrap.hasClass( 'tmce-active' ) || ! tinyMCEPreInit.qtInit.hasOwnProperty( id ) ) && ! init.wp_skip_init ) {
						tinymce.init( init );

						if ( ! window.wpActiveEditor ) {
							window.wpActiveEditor = id;
						}
					}
				}
			}

			if ( typeof quicktags !== 'undefined' ) {
				for ( id in tinyMCEPreInit.qtInit ) {
					quicktags( tinyMCEPreInit.qtInit[id] );

					if ( ! window.wpActiveEditor ) {
						window.wpActiveEditor = id;
					}
				}
			}
		}(jQuery));
		</script>
		<?php

		/**
		 * Fires after any core TinyMCE editor instances are created.
		 *
		 * @since 3.2.0
		 *
		 * @param array $mce_settings TinyMCE settings array.
		 */
		Leo_Helper::do_action( 'after_wp_tiny_mce', self::$mce_settings );
	}
}
