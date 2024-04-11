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

namespace LeoElements\TemplateLibrary;

use LeoElements\Core\Base\Document;
use LeoElements\Core\Editor\Editor;
use LeoElements\DB;
use LeoElements\Core\Settings\Manager as SettingsManager;
use LeoElements\Core\Settings\Page\Model;
use LeoElements\Modules\Library\Documents\Library_Document;
use LeoElements\Plugin;
use LeoElements\Utils;
use LeoElements\Leo_Helper; 

if ( ! defined( '_PS_VERSION_' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor template library local source.
 *
 * Elementor template library local source handler class is responsible for
 * handling local Elementor templates saved by the user locally on his site.
 *
 * @since 1.0.0
 */
class Source_Local extends Source_Base {

	/**
	 * Elementor template-library post-type slug.
	 */
	const CPT = 'elementor_library';

	/**
	 * Elementor template-library taxonomy slug.
	 */
	const TAXONOMY_TYPE_SLUG = 'elementor_library_type';

	/**
	 * Elementor template-library category slug.
	 */
	const TAXONOMY_CATEGORY_SLUG = 'elementor_library_category';

	/**
	 * Elementor template-library meta key.
	 * @deprecated 2.3.0 Use \Elementor\Core\Base\Document::TYPE_META_KEY instead
	 */
	const TYPE_META_KEY = '_elementor_template_type';

	/**
	 * Elementor template-library temporary files folder.
	 */
	const TEMP_FILES_DIR = 'elementor/tmp';

	/**
	 * Elementor template-library bulk export action name.
	 */
	const BULK_EXPORT_ACTION = 'elementor_export_multiple_templates';

	const ADMIN_MENU_SLUG = 'edit.php?post_type=elementor_library';

	const ADMIN_SCREEN_ID = 'edit-elementor_library';

	/**
	 * Template types.
	 *
	 * Holds the list of supported template types that can be displayed.
	 *
	 * @access private
	 * @static
	 *
	 * @var array
	 */
	private static $template_types = [];

	/**
	 * Post type object.
	 *
	 * Holds the post type object of the current post.
	 *
	 * @access private
	 *
	 * @var \WP_Post_Type
	 */
	private $post_type_object;

	/**
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return array
	 */
	public static function get_template_types() {
		return self::$template_types;
	}

	/**
	 * Get local template type.
	 *
	 * Retrieve the template type from the post meta.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return mixed The value of meta data field.
	 */
	public static function get_template_type( $template_id ) {
		return get_post_meta( $template_id, Document::TYPE_META_KEY, true );
	}

	/**
	 * Is base templates screen.
	 *
	 * Whether the current screen base is edit and the post type is template.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return bool True on base templates screen, False otherwise.
	 */
	public static function is_base_templates_screen() {
                $current_screen = &$GLOBALS['current_screen'];

		if ( ! $current_screen ) {
			return false;
		}

		return 'edit' === $current_screen->base && self::CPT === $current_screen->post_type;
	}

	/**
	 * Add template type.
	 *
	 * Register new template type to the list of supported local template types.
	 *
	 * @since 1.0.3
	 * @access public
	 * @static
	 *
	 * @param string $type Template type.
	 */
	public static function add_template_type( $type ) {
		self::$template_types[ $type ] = $type;
	}

	/**
	 * Remove template type.
	 *
	 * Remove existing template type from the list of supported local template
	 * types.
	 *
	 * @since 1.8.0
	 * @access public
	 * @static
	 *
	 * @param string $type Template type.
	 */
	public static function remove_template_type( $type ) {
		if ( isset( self::$template_types[ $type ] ) ) {
			unset( self::$template_types[ $type ] );
		}
	}

	public static function get_admin_url( $relative = false ) {
		$base_url = self::ADMIN_MENU_SLUG;
		if ( ! $relative ) {
			$base_url = Leo_Helper::admin_url( $base_url );
		}

		return add_query_arg( 'tabs_group', 'library', $base_url );
	}

	/**
	 * Get local template ID.
	 *
	 * Retrieve the local template ID.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string The local template ID.
	 */
	public function get_id() {
		return 'local';
	}

	/**
	 * Get local template title.
	 *
	 * Retrieve the local template title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string The local template title.
	 */
	public function get_title() {
		return Leo_Helper::__( 'Local', 'elementor' );
	}

	/**
	 * Register local template data.
	 *
	 * Used to register custom template data like a post type, a taxonomy or any
	 * other data.
	 *
	 * The local template class registers a new `elementor_library` post type
	 * and an `elementor_library_type` taxonomy. They are used to store data for
	 * local templates saved by the user on his site.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_data() {
		$labels = [
			'name' => Leo_Helper::_x( 'My Templates', 'Template Library', 'elementor' ),
			'singular_name' => Leo_Helper::_x( 'Template', 'Template Library', 'elementor' ),
			'add_new' => Leo_Helper::_x( 'Add New', 'Template Library', 'elementor' ),
			'add_new_item' => Leo_Helper::_x( 'Add New Template', 'Template Library', 'elementor' ),
			'edit_item' => Leo_Helper::_x( 'Edit Template', 'Template Library', 'elementor' ),
			'new_item' => Leo_Helper::_x( 'New Template', 'Template Library', 'elementor' ),
			'all_items' => Leo_Helper::_x( 'All Templates', 'Template Library', 'elementor' ),
			'view_item' => Leo_Helper::_x( 'View Template', 'Template Library', 'elementor' ),
			'search_items' => Leo_Helper::_x( 'Search Template', 'Template Library', 'elementor' ),
			'not_found' => Leo_Helper::_x( 'No Templates found', 'Template Library', 'elementor' ),
			'not_found_in_trash' => Leo_Helper::_x( 'No Templates found in Trash', 'Template Library', 'elementor' ),
			'parent_item_colon' => '',
			'menu_name' => Leo_Helper::_x( 'Templates', 'Template Library', 'elementor' ),
		];

		$args = [
			'labels' => $labels,
			'public' => true,
			'rewrite' => false,
			'menu_icon' => 'dashicons-admin-page',
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => false,
			'exclude_from_search' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => [ 'title', 'thumbnail', 'author', 'elementor' ],
		];

		/**
		 * Register template library post type args.
		 *
		 * Filters the post type arguments when registering elementor template library post type.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Arguments for registering a post type.
		 */
		$args = Leo_Helper::apply_filters( 'elementor/template_library/sources/local/register_post_type_args', $args );

		$this->post_type_object = self::CPT;

		$args = [
			'hierarchical' => false,
			'show_ui' => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var' => Leo_Helper::is_admin(),
			'rewrite' => false,
			'public' => false,
			'label' => Leo_Helper::_x( 'Type', 'Template Library', 'elementor' ),
		];

		/**
		 * Register template library taxonomy args.
		 *
		 * Filters the taxonomy arguments when registering elementor template library taxonomy.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Arguments for registering a taxonomy.
		 */
		$args = Leo_Helper::apply_filters( 'elementor/template_library/sources/local/register_taxonomy_args', $args );

		/**
		 * Categories
		 */
		$args = [
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var' => Leo_Helper::is_admin(),
			'rewrite' => false,
			'public' => false,
			'labels' => [
				'name' => Leo_Helper::_x( 'Categories', 'Template Library', 'elementor' ),
				'singular_name' => Leo_Helper::_x( 'Category', 'Template Library', 'elementor' ),
				'all_items' => Leo_Helper::_x( 'All Categories', 'Template Library', 'elementor' ),
			],
		];

		/**
		 * Register template library category args.
		 *
		 * Filters the category arguments when registering elementor template library category.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Arguments for registering a category.
		 */
		$args = Leo_Helper::apply_filters( 'elementor/template_library/sources/local/register_category_args', $args );
	}

	/**
	 * Remove Add New item from admin menu.
	 *
	 * Fired by `admin_menu` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_menu_reorder() {
                $submenu = &$GLOBALS['submenu'];

		if ( ! isset( $submenu[ self::ADMIN_MENU_SLUG ] ) ) {
			return;
		}
		$library_submenu = &$submenu[ self::ADMIN_MENU_SLUG ];

		// Remove 'All Templates' menu.
		unset( $library_submenu[5] );

		// If current use can 'Add New' - move the menu to end, and add the '#add_new' anchor.
		if ( isset( $library_submenu[10][2] ) ) {
			$library_submenu[700] = $library_submenu[10];
			unset( $library_submenu[10] );
			$library_submenu[700][2] = Leo_Helper::admin_url( self::ADMIN_MENU_SLUG . '#add_new' );
		}

		// Move the 'Categories' menu to end.
		if ( isset( $library_submenu[15] ) ) {
			$library_submenu[800] = $library_submenu[15];
			unset( $library_submenu[15] );
		}

		if ( $this->is_current_screen() ) {
			$library_title = $this->get_library_title();

			foreach ( $library_submenu as &$item ) {
				if ( $library_title === $item[0] ) {
					if ( ! isset( $item[4] ) ) {
						$item[4] = '';
					}
					$item[4] .= ' current';
				}
			}
		}
	}

	public function admin_menu() {
		add_submenu_page( self::ADMIN_MENU_SLUG, '', Leo_Helper::__( 'Saved Templates', 'elementor' ), Editor::EDITING_CAPABILITY, self::get_admin_url( true ) );
	}

	public function admin_title( $admin_title, $title ) {
		$library_title = $this->get_library_title();

		if ( $library_title ) {
			$admin_title = str_replace( $title, $library_title, $admin_title );
		}

		return $admin_title;
	}

	public function replace_admin_heading() {
		$library_title = $this->get_library_title();

		if ( $library_title ) {
                        $post_type_object = &$GLOBALS['post_type_object'];

			$post_type_object->labels->name = $library_title;
		}
	}

	/**
	 * Get local templates.
	 *
	 * Retrieve local templates saved by the user on his site.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args Optional. Filter templates based on a set of
	 *                    arguments. Default is an empty array.
	 *
	 * @return array Local templates.
	 */
	public function get_items( $args = [] ) {
		$templates_local = Leo_Helper::getTemplatesLocal();
		
		$templates = [];
				
		foreach ( $templates_local as $post ) {
			$templates[] = $this->get_item( $post['id_leoelements_template'] );
		}

		return $templates;
	}

	/**
	 * Save local template.
	 *
	 * Save new or update existing template on the database.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $template_data Local template data.
	 *
	 * @return \WP_Error|int The ID of the saved/updated template, `WP_Error` otherwise.
	 */
	public function save_item( $template_data ) {
		$context = \Context::getContext();
		
		$defaults = [
			'title' => Leo_Helper::__( '(no title)', 'elementor' ),
			'page_settings' => [],
			'status' => 'publish',
		];
		
		$template_data = Leo_Helper::wp_parse_args( $template_data, $defaults );

		$template = new \LeoElementsTemplate();
		
		$template->id_employee = Leo_Helper::get_current_user_id();
		$template->title = $template_data['title'];
		$template->type = $template_data['type'];
		$template->thumbnail = false;
		$template->content = json_encode( $template_data['content'] );
		$template->page_settings = json_encode( $template_data['page_settings'] );
		$template->save();
		
		$template_id = $template->id;

		/**
		 * After template library save.
		 *
		 * Fires after Elementor template library was saved.
		 *
		 * @since 1.0.1
		 *
		 * @param int   $template_id   The ID of the template.
		 * @param array $template_data The template data.
		 */
		Leo_Helper::do_action( 'elementor/template-library/after_save_template', $template_id, $template_data );

		/**
		 * After template library update.
		 *
		 * Fires after Elementor template library was updated.
		 *
		 * @since 1.0.1
		 *
		 * @param int   $template_id   The ID of the template.
		 * @param array $template_data The template data.
		 */
		Leo_Helper::do_action( 'elementor/template-library/after_update_template', $template_id, $template_data );

		return $template_id;
	}

	/**
	 * Update local template.
	 *
	 * Update template on the database.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_data New template data.
	 *
	 * @return \WP_Error|true True if template updated, `WP_Error` otherwise.
	 */
	public function update_item( $new_data ) {
		if ( ! current_user_can( $this->post_type_object->cap->edit_post, $new_data['id'] ) ) {
			return new \WP_Error( 'save_error', __( 'Access denied.', 'elementor' ) );
		}

		$document = Plugin::$instance->documents->get( $new_data['id'] );

		if ( ! $document ) {
			return new \WP_Error( 'save_error', Leo_Helper::__( 'Template not exist.', 'elementor' ) );
		}

		$document->save( [
			'elements' => $new_data['content'],
		] );

		/**
		 * After template library update.
		 *
		 * Fires after Elementor template library was updated.
		 *
		 * @since 1.0.0
		 *
		 * @param int   $new_data_id The ID of the new template.
		 * @param array $new_data    The new template data.
		 */
		Leo_Helper::do_action( 'elementor/template-library/after_update_template', $new_data['id'], $new_data );

		return true;
	}

	/**
	 * Get local template.
	 *
	 * Retrieve a single local template saved by the user on his site.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return array Local template.
	 */
	public function get_item( $template_id ) {
		$post = new \LeoElementsTemplate( $template_id );

		$user = new \Employee( $post->id_employee );
		
		$data = [
			'template_id' => $post->id,
			'source' => $this->get_id(),
			'type' => $post->type,
			'title' => $post->title,
			'thumbnail' => false,
			'date' => $post->date_add,
			'human_date' => $post->date_add,
			'author' => $user->firstname,
			'hasPageSettings' => ! empty( $post->settings ),
			'tags' => [],
			'export_link' => $this->get_export_link( $template_id ),
			'url' => Leo_Helper::get_permalink_template( $post->id ),
		];

		/**
		 * Get template library template.
		 *
		 * Filters the template data when retrieving a single template from the
		 * template library.
		 *
		 * @since 1.0.0
		 *
		 * @param array $data Template data.
		 */
		$data = Leo_Helper::apply_filters( 'elementor/template-library/get_template', $data );

		return $data;
	}

	/**
	 * Get template data.
	 *
	 * Retrieve the data of a single local template saved by the user on his site.
	 *
	 * @since 1.5.0
	 * @access public
	 *
	 * @param array $args Custom template arguments.
	 *
	 * @return array Local template data.
	 */
	public function get_data( array $args ) {

		$template_id = $args['template_id'];

		$template = new \LeoElementsTemplate( $template_id );
		
		$data = [
			'content' => json_decode( $template->content, true ),
            'page_settings' => json_decode( $template->page_settings, true )
		];

        $data['content'] = $this->replace_elements_ids( $data['content'] );
        
		return $data;
	}

	/**
	 * Delete local template.
	 *
	 * Delete template from the database.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return \WP_Post|\WP_Error|false|null Post data on success, false or null
	 *                                       or 'WP_Error' on failure.
	 */
	public function delete_template( $template_id ) {
		$template = new \LeoElementsTemplate( $template_id );

		return $template->delete();
	}

	/**
	 * Export local template.
	 *
	 * Export template to a file.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return \WP_Error WordPress error if template export failed.
	 */
	public function export_template( $template_id ) {
		$file_data = $this->prepare_template_export( $template_id );

		if ( Leo_Helper::is_wp_error( $file_data ) ) {
			return $file_data;
		}

		$this->send_file_headers( $file_data['name'], strlen( $file_data['content'] ) );

		// Clear buffering just in case.
		@ob_end_clean();

		flush();

		// Output file contents.
		echo $file_data['content'];

		die;
	}

	/**
	 * Export multiple local templates.
	 *
	 * Export multiple template to a ZIP file.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @param array $template_ids An array of template IDs.
	 *
	 * @return \WP_Error WordPress error if export failed.
	 */
	public function export_multiple_templates( array $template_ids ) {
		$files = [];

		$wp_upload_dir = wp_upload_dir();

		$temp_path = $wp_upload_dir['basedir'] . '/' . self::TEMP_FILES_DIR;

		// Create temp path if it doesn't exist
		wp_mkdir_p( $temp_path );

		// Create all json files
		foreach ( $template_ids as $template_id ) {
			$file_data = $this->prepare_template_export( $template_id );

			if ( Leo_Helper::is_wp_error( $file_data ) ) {
				continue;
			}

			$complete_path = $temp_path . '/' . $file_data['name'];

			$put_contents = file_put_contents( $complete_path, $file_data['content'] );

			if ( ! $put_contents ) {
				return new \WP_Error( '404', sprintf( 'Cannot create file "%s".', $file_data['name'] ) );
			}

			$files[] = [
				'path' => $complete_path,
				'name' => $file_data['name'],
			];
		}

		if ( ! $files ) {
			return new \WP_Error( 'empty_files', 'There is no files to export (probably all the requested templates are empty).' );
		}

		// Create temporary .zip file
		$zip_archive_filename = 'elementor-templates-' . date( 'Y-m-d' ) . '.zip';

		$zip_archive = new \ZipArchive();

		$zip_complete_path = $temp_path . '/' . $zip_archive_filename;

		$zip_archive->open( $zip_complete_path, \ZipArchive::CREATE );

		foreach ( $files as $file ) {
			$zip_archive->addFile( $file['path'], $file['name'] );
		}

		$zip_archive->close();

		foreach ( $files as $file ) {
			unlink( $file['path'] );
		}

		$this->send_file_headers( $zip_archive_filename, filesize( $zip_complete_path ) );

		@ob_end_flush();

		@readfile( $zip_complete_path );

		unlink( $zip_complete_path );

		die;
	}

	/**
	 * Import local template.
	 *
	 * Import template from a file.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $name - The file name
	 * @param string $path - The file path
	 *
	 * @return \WP_Error|array An array of items on success, 'WP_Error' on failure.
	 */
	public function import_template( $name, $path ) {
		if ( empty( $path ) ) {
			return new \WP_Error( 'file_error', 'Please upload a file to import' );
		}

		$items = [];

		$import_result = $this->import_single_template( $path );

		if ( Leo_Helper::is_wp_error( $import_result ) ) {
			return $import_result;
		}

		$items[] = $import_result;

		return $items;
	}

	/**
	 * Post row actions.
	 *
	 * Add an export link to the template library action links table list.
	 *
	 * Fired by `post_row_actions` filter.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array    $actions An array of row action links.
	 * @param \WP_Post $post    The post object.
	 *
	 * @return array An updated array of row action links.
	 */
	public function post_row_actions( $actions, \WP_Post $post ) {
		if ( self::is_base_templates_screen() ) {
			if ( $this->is_template_supports_export( $post->ID ) ) {
				$actions['export-template'] = sprintf( '<a href="%1$s">%2$s</a>', $this->get_export_link( $post->ID ), Leo_Helper::__( 'Export Template', 'elementor' ) );
			}
		}

		return $actions;
	}

	/**
	 * Admin import template form.
	 *
	 * The import form displayed in "My Library" screen in WordPress dashboard.
	 *
	 * The form allows the user to import template in json/zip format to the site.
	 *
	 * Fired by `admin_footer` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_import_template_form() {
		if ( ! self::is_base_templates_screen() ) {
			return;
		}

		/** @var \Elementor\Core\Common\Modules\Ajax\Module $ajax */
		$ajax = Plugin::$instance->common->get_component( 'ajax' );
		?>
		<div id="elementor-hidden-area">
			<a id="elementor-import-template-trigger" class="page-title-action"><?php echo Leo_Helper::__( 'Import Templates', 'elementor' ); ?></a>
			<div id="elementor-import-template-area">
				<div id="elementor-import-template-title"><?php echo Leo_Helper::__( 'Choose an Elementor template JSON file or a .zip archive of Elementor templates, and add them to the list of templates available in your library.', 'elementor' ); ?></div>
				<form id="elementor-import-template-form" method="post" action="<?php echo Leo_Helper::admin_url( 'admin-ajax.php' ); ?>" enctype="multipart/form-data">
					<input type="hidden" name="action" value="elementor_library_direct_actions">
					<input type="hidden" name="library_action" value="direct_import_template">
					<input type="hidden" name="_nonce" value="<?php echo $ajax->create_nonce(); ?>">
					<fieldset id="elementor-import-template-form-inputs">
						<input type="file" name="file" accept=".json,application/json,.zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed" required>
						<input type="submit" class="button" value="<?php echo Leo_Helper::esc_attr__( 'Import Now', 'elementor' ); ?>">
					</fieldset>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * Block template frontend
	 *
	 * Don't display the single view of the template library post type in the
	 * frontend, for users that don't have the proper permissions.
	 *
	 * Fired by `template_redirect` action.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function block_template_frontend() {
		if ( Leo_Helper::is_singular( self::CPT ) && ! current_user_can( Editor::EDITING_CAPABILITY ) ) {
			wp_safe_redirect( site_url(), 301 );
			die;
		}
	}

	/**
	 * Is template library supports export.
	 *
	 * whether the template library supports export.
	 *
	 * Template saved by the user locally on his site, support export by default
	 * but this can be changed using a filter.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return bool Whether the template library supports export.
	 */
	public function is_template_supports_export( $template_id ) {
		$export_support = true;

		/**
		 * Is template library supports export.
		 *
		 * Filters whether the template library supports export.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $export_support Whether the template library supports export.
		 *                             Default is true.
		 * @param int  $template_id    Post ID.
		 */
		$export_support = Leo_Helper::apply_filters( 'elementor/template_library/is_template_supports_export', $export_support, $template_id );

		return $export_support;
	}

	/**
	 * Remove Elementor post state.
	 *
	 * Remove the 'elementor' post state from the display states of the post.
	 *
	 * Used to remove the 'elementor' post state from the template library items.
	 *
	 * Fired by `display_post_states` filter.
	 *
	 * @since 1.8.0
	 * @access public
	 *
	 * @param array    $post_states An array of post display states.
	 * @param \WP_Post $post        The current post object.
	 *
	 * @return array Updated array of post display states.
	 */
	public function remove_elementor_post_state_from_library( $post_states, $post ) {
		if ( self::CPT === $post->post_type && isset( $post_states['elementor'] ) ) {
			unset( $post_states['elementor'] );
		}
		return $post_states;
	}

	/**
	 * Get template export link.
	 *
	 * Retrieve the link used to export a single template based on the template
	 * ID.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return string Template export URL.
	 */
	private function get_export_link( $template_id ) {
		// TODO: BC since 2.3.0 - Use `$ajax->create_nonce()`
		/** @var \Elementor\Core\Common\Modules\Ajax\Module $ajax */
		// $ajax = Plugin::$instance->common->get_component( 'ajax' );

		$params = [
			'action' => 'elementor_library_direct_actions',
			'library_action' => 'export_template',
			'source' => $this->get_id(),
			'_nonce' => '',
			'template_id' => $template_id,
		];
		
		return Leo_Helper::get_ajax_editor( $params );
	}

	/**
	 * On template save.
	 *
	 * Run this method when template is being saved.
	 *
	 * Fired by `save_post` action.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    The current post object.
	 */
	public function on_save_post( $post_id, \WP_Post $post ) {
		if ( self::CPT !== $post->post_type ) {
			return;
		}

		if ( self::get_template_type( $post_id ) ) { // It's already with a type
			return;
		}

		// Don't save type on import, the importer will do it.
		if ( did_action( 'import_start' ) ) {
			return;
		}

		$this->save_item_type( $post_id, 'page' );
	}

	/**
	 * Save item type.
	 *
	 * When saving/updating templates, this method is used to update the post
	 * meta data and the taxonomy.
	 *
	 * @since 1.0.1
	 * @access private
	 *
	 * @param int    $post_id Post ID.
	 * @param string $type    Item type.
	 */
	private function save_item_type( $post_id, $type ) {
		Leo_Helper::update_post_meta( $post_id, Document::TYPE_META_KEY, $type );

		wp_set_object_terms( $post_id, $type, self::TAXONOMY_TYPE_SLUG );
	}

	/**
	 * Bulk export action.
	 *
	 * Adds an 'Export' action to the Bulk Actions drop-down in the template
	 * library.
	 *
	 * Fired by `bulk_actions-edit-elementor_library` filter.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @param array $actions An array of the available bulk actions.
	 *
	 * @return array An array of the available bulk actions.
	 */
	public function admin_add_bulk_export_action( $actions ) {
		$actions[ self::BULK_EXPORT_ACTION ] = Leo_Helper::__( 'Export', 'elementor' );

		return $actions;
	}

	/**
	 * Add bulk export action.
	 *
	 * Handles the template library bulk export action.
	 *
	 * Fired by `handle_bulk_actions-edit-elementor_library` filter.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @param string $redirect_to The redirect URL.
	 * @param string $action      The action being taken.
	 * @param array  $post_ids    The items to take the action on.
	 */
	public function admin_export_multiple_templates( $redirect_to, $action, $post_ids ) {
		if ( self::BULK_EXPORT_ACTION === $action ) {
			$result = $this->export_multiple_templates( $post_ids );

			// If you reach this line, the export failed
			wp_die( $result->get_error_message() );
		}
	}

	/**
	 * Print admin tabs.
	 *
	 * Used to output the template library tabs with their labels.
	 *
	 * Fired by `views_edit-elementor_library` filter.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param array $views An array of available list table views.
	 *
	 * @return array An updated array of available list table views.
	 */
	public function admin_print_tabs( $views ) {
		$current_type = '';
		$active_class = ' nav-tab-active';
		$current_tabs_group = $this->get_current_tab_group();

		if ( ! empty( $_REQUEST[ self::TAXONOMY_TYPE_SLUG ] ) ) {
			$current_type = $_REQUEST[ self::TAXONOMY_TYPE_SLUG ];
			$active_class = '';
		}

		$url_args = [
			'post_type' => self::CPT,
			'tabs_group' => $current_tabs_group,
		];

		$baseurl = add_query_arg( $url_args, Leo_Helper::admin_url( 'edit.php' ) );

		$filter = [
			'admin_tab_group' => $current_tabs_group,
		];
		$operator = 'and';

		if ( empty( $current_tabs_group ) ) {
			// Don't include 'not-supported' or other templates that don't set their `admin_tab_group`.
			$operator = 'NOT';
		}

		$doc_types = Plugin::$instance->documents->get_document_types( $filter, $operator );

		if ( 1 >= count( $doc_types ) ) {
			return $views;
		}

		?>
		<div id="elementor-template-library-tabs-wrapper" class="nav-tab-wrapper">
			<a class="nav-tab<?php echo $active_class; ?>" href="<?php echo $baseurl; ?>">
				<?php
				$all_title = $this->get_library_title();
				if ( ! $all_title ) {
					$all_title = Leo_Helper::__( 'All', 'elementor' );
				}
				echo $all_title; ?>
			</a>
			<?php
			foreach ( $doc_types as $type => $class_name ) :
				$active_class = '';

				if ( $current_type === $type ) {
					$active_class = ' nav-tab-active';
				}

				$type_url = add_query_arg( self::TAXONOMY_TYPE_SLUG, $type, $baseurl );
				$type_label = $this->get_template_label_by_type( $type );

				echo "<a class='nav-tab{$active_class}' href='{$type_url}'>{$type_label}</a>";
			endforeach;
			?>
		</div>
		<?php
		return $views;
	}

	/**
	 * Maybe render blank state.
	 *
	 * When the template library has no saved templates, display a blank admin page offering
	 * to create the very first template.
	 *
	 * Fired by `manage_posts_extra_tablenav` action.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $which The location of the extra table nav markup: 'top' or 'bottom'.
	 */
	public function maybe_render_blank_state( $which ) {
                $post_type = &$GLOBALS['post_type'];

		if ( self::CPT !== $post_type || 'bottom' !== $which ) {
			return;
		}

                $wp_list_table = &$GLOBALS['wp_list_table'];

		$total_items = $wp_list_table->get_pagination_arg( 'total_items' );

		if ( ! empty( $total_items ) || ! empty( $_REQUEST['s'] ) ) {
			return;
		}

		$inline_style = '#posts-filter .wp-list-table, #posts-filter .tablenav.top, .tablenav.bottom .actions, .wrap .subsubsub { display:none;}';

		$current_type = get_query_var( 'elementor_library_type' );

		$document_types = Plugin::instance()->documents->get_document_types();

		if ( empty( $document_types[ $current_type ] ) ) {
			return;
		}

		// TODO: Better way to exclude widget type.
		if ( 'widget' === $current_type ) {
			return;
		}

		if ( empty( $current_type ) ) {
			$counts = (array) wp_count_posts( self::CPT );
			unset( $counts['auto-draft'] );
			$count  = array_sum( $counts );

			if ( 0 < $count ) {
				return;
			}

			$current_type = 'template';

			$inline_style .= '#elementor-template-library-tabs-wrapper {display: none;}';
		}

		$current_type_label = $this->get_template_label_by_type( $current_type );
		?>
		<style type="text/css"><?php echo $inline_style; ?></style>
		<div class="elementor-template_library-blank_state">
			<div class="elementor-blank_state">
				<i class="eicon-folder"></i>
				<h2>
					<?php
					/* translators: %s: Template type label. */
					printf( Leo_Helper::__( 'Create Your First %s', 'elementor' ), $current_type_label );
					?>
				</h2>
				<p><?php echo Leo_Helper::__( 'Add templates and reuse them across your website. Easily export and import them to any other project, for an optimized workflow.', 'elementor' ); ?></p>
				<a id="elementor-template-library-add-new" class="elementor-button elementor-button-success" href="<?php esc_url( Utils::get_pro_link( 'https://elementor.com/pro/?utm_source=wp-custom-fonts&utm_campaign=gopro&utm_medium=wp-dash' ) ); ?>">
					<?php
					/* translators: %s: Template type label. */
					printf( Leo_Helper::__( 'Add New %s', 'elementor' ), $current_type_label );
					?>
				</a>
			</div>
		</div>
		<?php
	}

	public function add_filter_by_category( $post_type ) {
		if ( self::CPT !== $post_type ) {
			return;
		}

		$all_items = get_taxonomy( self::TAXONOMY_CATEGORY_SLUG )->labels->all_items;

		$dropdown_options = array(
			'show_option_all' => $all_items,
			'show_option_none' => $all_items,
			'hide_empty' => 0,
			'hierarchical' => 1,
			'show_count' => 0,
			'orderby' => 'name',
			'value_field' => 'slug',
			'taxonomy' => self::TAXONOMY_CATEGORY_SLUG,
			'name' => self::TAXONOMY_CATEGORY_SLUG,
			'selected' => empty( Tools::getValue(self::TAXONOMY_CATEGORY_SLU) ) ? '' : Tools::getValue(self::TAXONOMY_CATEGORY_SLUG),
		);

		echo '<label class="screen-reader-text" for="cat">' . Leo_Helper::_x( 'Filter by category', 'Template Library', 'elementor' ) . '</label>';
		wp_dropdown_categories( $dropdown_options );
	}

	/**
	 * Import single template.
	 *
	 * Import template from a file to the database.
	 *
	 * @since 1.6.0
	 * @access private
	 *
	 * @param string $file_name File name.
	 *
	 * @return \WP_Error|int|array Local template array, or template ID, or
	 *                             `WP_Error`.
	 */
	private function import_single_template( $file_name ) {
		$data = json_decode( \Tools::file_get_contents( $file_name ), true );

		if ( empty( $data ) ) {
			return new \WP_Error( 'file_error', 'Invalid File' );
		}

		$content = $data['content'];

		if ( ! is_array( $content ) ) {
			return new \WP_Error( 'file_error', 'Invalid File' );
		}

		$content = $this->process_export_import_content( $content, 'on_import' );

		$page_settings = [];

		if ( ! empty( $data['page_settings'] ) ) {
			$page = new Model( [
				'id' => 0,
				'settings' => $data['page_settings'],
			] );

			$page_settings_data = $this->process_element_export_import_content( $page, 'on_import' );

			if ( ! empty( $page_settings_data['settings'] ) ) {
				$page_settings = $page_settings_data['settings'];
			}
		}

		$template_id = $this->save_item( [
			'content' => $content,
			'title' => $data['title'],
			'type' => $data['type'],
			'page_settings' => $page_settings,
		] );

		if ( Leo_Helper::is_wp_error( $template_id ) ) {
			return $template_id;
		}

		return $this->get_item( $template_id );
	}

	/**
	 * Prepare template to export.
	 *
	 * Retrieve the relevant template data and return them as an array.
	 *
	 * @since 1.6.0
	 * @access private
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return \WP_Error|array Exported template data.
	 */
	private function prepare_template_export( $template_id ) {
		$template_data = $this->get_data( [
			'template_id' => $template_id,
		] );

		if ( empty( $template_data['content'] ) ) {
			return new \WP_Error( 'empty_template', 'The template is empty' );
		}
		$template_data['content'] = $this->process_export_import_content( $template_data['content'], 'on_export' );
		
		$template = new \LeoElementsTemplate( $template_id );

		$export_data = [
			'version' => LEOELEMENTS_VERSION,
			'title' => $template->title,
			'type' => $template->type,
		];

		$export_data += $template_data;

		return [
			'name' => 'leoelements-' . $template_id . '-' . date( 'Y-m-d' ) . '.json',
			'content' => json_encode( $export_data ),
		];
	}

	/**
	 * Send file headers.
	 *
	 * Set the file header when export template data to a file.
	 *
	 * @since 1.6.0
	 * @access private
	 *
	 * @param string $file_name File name.
	 * @param int    $file_size File size.
	 */
	private function send_file_headers( $file_name, $file_size ) {
		header( 'Content-Type: application/octet-stream' );
		header( 'Content-Disposition: attachment; filename=' . $file_name );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . $file_size );
	}

	/**
	 * Get template label by type.
	 *
	 * Retrieve the template label for any given template type.
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @param string $template_type Template type.
	 *
	 * @return string Template label.
	 */
	private function get_template_label_by_type( $template_type ) {
		$document_types = Plugin::instance()->documents->get_document_types();

		if ( isset( $document_types[ $template_type ] ) ) {
			$template_label = call_user_func( [ $document_types[ $template_type ], 'get_title' ] );
		} else {
			$template_label = ucwords( str_replace( [ '_', '-' ], ' ', $template_type ) );
		}

		/**
		 * Template label by template type.
		 *
		 * Filters the template label by template type in the template library .
		 *
		 * @since 2.0.0
		 *
		 * @param string $template_label Template label.
		 * @param string $template_type  Template type.
		 */
		$template_label = Leo_Helper::apply_filters( 'elementor/template-library/get_template_label_by_type', $template_label, $template_type );

		return $template_label;
	}

	/**
	 * Filter template types in admin query.
	 *
	 * Update the template types in the main admin query.
	 *
	 * Fired by `parse_query` action.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param \WP_Query $query The `WP_Query` instance.
	 */
	public function admin_query_filter_types( \WP_Query $query ) {
		if ( ! $this->is_current_screen() || ! empty( $query->query_vars['meta_key'] ) ) {
			return;
		}

		$current_tabs_group = $this->get_current_tab_group();

		if ( isset( $query->query_vars[ self::TAXONOMY_CATEGORY_SLUG ] ) && '-1' === $query->query_vars[ self::TAXONOMY_CATEGORY_SLUG ] ) {
			unset( $query->query_vars[ self::TAXONOMY_CATEGORY_SLUG ] );
		}

		if ( empty( $current_tabs_group ) ) {
			return;
		}

		$doc_types = Plugin::$instance->documents->get_document_types( [
			'admin_tab_group' => $current_tabs_group,
		] );

		$query->query_vars['meta_key'] = Document::TYPE_META_KEY;
		$query->query_vars['meta_value'] = array_keys( $doc_types );
	}

	/**
	 * Add template library actions.
	 *
	 * Register filters and actions for the template library.
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function add_actions() {
		Leo_Helper::add_action( 'template_redirect', [ $this, 'block_template_frontend' ] );
	}

	/**
	 * @since 2.0.6
	 * @access public
	 */
	public function admin_columns_content( $column_name, $post_id ) {
		if ( 'elementor_library_type' === $column_name ) {
			/** @var Document $document */
			$document = Plugin::$instance->documents->get( $post_id );

			if ( $document && $document instanceof Library_Document ) {
				$document->print_admin_column_type();
			}
		}
	}

	/**
	 * @since 2.0.6
	 * @access public
	 */
	public function admin_columns_headers( $posts_columns ) {
		// Replace original column that bind to the taxonomy - with another column.
		unset( $posts_columns['taxonomy-elementor_library_type'] );

		$offset = 2;

		$posts_columns = array_slice( $posts_columns, 0, $offset, true ) + [
			'elementor_library_type' => Leo_Helper::__( 'Type', 'elementor' ),
		] + array_slice( $posts_columns, $offset, null, true );

		return $posts_columns;
	}

	private function get_current_tab_group( $default = '' ) {
		$current_tabs_group = $default;

		if ( ! empty( $_REQUEST[ self::TAXONOMY_TYPE_SLUG ] ) ) {
			$doc_type = Plugin::$instance->documents->get_document_type( $_REQUEST[ self::TAXONOMY_TYPE_SLUG ], '' );
			if ( $doc_type ) {
				$current_tabs_group = $doc_type::get_property( 'admin_tab_group' );
			}
		} elseif ( ! empty( $_REQUEST['tabs_group'] ) ) {
			$current_tabs_group = $_REQUEST['tabs_group'];
		}

		return $current_tabs_group;
	}

	private function get_library_title() {
		$title = '';

		if ( $this->is_current_screen() ) {
			$current_tab_group = $this->get_current_tab_group();

			if ( $current_tab_group ) {
				$titles = [
					'library' => Leo_Helper::__( 'Saved Templates', 'elementor' ),
					'theme' => Leo_Helper::__( 'Theme Builder', 'elementor' ),
					'popup' => Leo_Helper::__( 'Popups', 'elementor' ),
				];

				if ( ! empty( $titles[ $current_tab_group ] ) ) {
					$title = $titles[ $current_tab_group ];
				}
			}
		}

		return $title;
	}

	private function is_current_screen() {
                $pagenow = &$GLOBALS['pagenow'];
                $typenow = &$GLOBALS['typenow'];

		return 'edit.php' === $pagenow && self::CPT === $typenow;
	}

	/**
	 * Template library local source constructor.
	 *
	 * Initializing the template library local source base by registering custom
	 * template data and running custom actions.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		parent::__construct();

		$this->add_actions();
	}
}
