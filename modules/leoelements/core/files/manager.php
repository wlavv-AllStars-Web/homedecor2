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

namespace LeoElements\Core\Files;

use LeoElements\Core\Files\CSS\Global_CSS;
use LeoElements\Core\Files\CSS\Post as Post_CSS;
use LeoElements\Core\Files\Svg\Svg_Handler;
use LeoElements\Core\Responsive\Files\Frontend;
use LeoElements\Utils;
use LeoElements\Leo_Helper; 

if ( ! defined( '_PS_VERSION_' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor files manager.
 *
 * Elementor files manager handler class is responsible for creating files.
 *
 * @since 1.2.0
 */
class Manager {

	private $files = [];

	/**
	 * Files manager constructor.
	 *
	 * Initializing the Elementor files manager.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {
		$this->register_actions();
	}

	public function get( $class, $args ) {
		$id = $class . '-' . json_encode( $args );

		if ( ! isset( $this->files[ $id ] ) ) {
			// Create an instance from dynamic args length.
			$reflection_class = new \ReflectionClass( $class );
			$this->files[ $id ] = $reflection_class->newInstanceArgs( $args );
		}

		return $this->files[ $id ];
	}

	/**
	 * On post delete.
	 *
	 * Delete post CSS immediately after a post is deleted from the database.
	 *
	 * Fired by `deleted_post` action.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @param string $post_id Post ID.
	 */
	public function on_delete_post( $post_id ) {
		$langs = \Language::getLanguages( false );
		
		foreach($langs as $lang) {
			Leo_Helper::$id_lang = (int) $lang['id_lang'];
			
			$css_file = Post_CSS::create( $post_id );

			$css_file->delete();
		}		
	}

	/**
	 * On export post meta.
	 *
	 * When exporting data using WXR, skip post CSS file meta key. This way the
	 * export won't contain the post CSS file data used by Elementor.
	 *
	 * Fired by `wxr_export_skip_postmeta` filter.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @param bool   $skip     Whether to skip the current post meta.
	 * @param string $meta_key Current meta key.
	 *
	 * @return bool Whether to skip the post CSS meta.
	 */
	public function on_export_post_meta( $skip, $meta_key ) {
		if ( Post_CSS::META_KEY === $meta_key ) {
			$skip = true;
		}

		return $skip;
	}

	/**
	 * Clear cache.
	 *
	 * Delete all meta containing files data. And delete the actual
	 * files from the upload directory.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function clear_cache() {
		Leo_Helper::delete_post_meta_by_key( Post_CSS::META_KEY );

		Leo_Helper::delete_option( Global_CSS::META_KEY );

		Leo_Helper::delete_option( Frontend::META_KEY );

		// Delete files.
		$path = Base::get_base_uploads_dir() . Base::DEFAULT_FILES_DIR . '*';

		foreach ( glob( $path ) as $file_path ) {
			unlink( $file_path );
		}

		/**
		 * Elementor clear files.
		 *
		 * Fires after Elementor clears files
		 *
		 * @since 1.0.0
		 */
		Leo_Helper::do_action( 'elementor/core/files/clear_cache' );
	}

	/**
	 * Register actions.
	 *
	 * Register filters and actions for the files manager.
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function register_actions() {
		Leo_Helper::add_action( 'deleted_post', [ $this, 'on_delete_post' ] );
		Leo_Helper::add_filter( 'wxr_export_skip_postmeta', [ $this, 'on_export_post_meta' ], 10, 2 );
	}
}
