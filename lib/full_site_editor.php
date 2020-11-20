<?php

/**
 * ONLY TEST PURPOSE
 *
 * Currently, if block-template / index.html exists, gutenberg will switch to fse mode.
 * @see emulsion_do_fse() in lib/template_tags.php
 */

if ( emulsion_do_fse() ) {

	/**
	 * Adds necessary filters to use 'wp_template' posts instead of theme template files.
	 */
	function emulsion_gutenberg_add_template_loader_filters() {
		if ( ! gutenberg_is_fse_theme() || ! emulsion_the_theme_supports( 'full_site_editor' ) ) {

			return;
		}
		if( ! function_exists('gutenberg_resolve_template') ) {

			return;
		}

		foreach ( get_template_types() as $template_type ) {
			if ( 'embed' === $template_type ) { // Skip 'embed' for now because it is not a regular template type.
				continue;
			}
			add_filter( str_replace( '-', '', $template_type ) . '_template', 'emulsion_gutenberg_override_query_template', 21, 3 );
		}
	}

	add_action( 'wp_loaded', 'emulsion_gutenberg_add_template_loader_filters' );

	function emulsion_gutenberg_override_query_template( $template, $type,
			array $templates = array() ) {

		global $_wp_current_template_content;

		$current_template = gutenberg_resolve_template( $type, $templates );

		if ( $current_template ) {

			$_wp_current_template_content = empty( $current_template->post_content ) ? __( 'Empty template.', 'gutenberg' ) : $current_template->post_content;

			if ( isset( $_GET['_wp-find-template'] ) ) {
				wp_send_json_success( $current_template['template_post'] );
			}
		} else {
			if ( 'index' === $type ) {
				if ( isset( $_GET['_wp-find-template'] ) ) {
					wp_send_json_error( array( 'message' => __( 'No matching template found.', 'emulsion' ) ) );
				}
			} else {
				return false; // So that the template loader keeps looking for templates.
			}
		}

		// Add hooks for template canvas.
		// Add viewport meta tag.
		add_action( 'wp_head', 'gutenberg_viewport_meta_tag', 0 );

		// Render title tag with content, regardless of whether theme has title-tag support.
		remove_action( 'wp_head', '_wp_render_title_tag', 1 ); // Remove conditional title tag rendering...
		add_action( 'wp_head', 'gutenberg_render_title_tag', 1 ); // ...and make it unconditional.
		// This file will be included instead of the theme's template file.
		//return gutenberg_dir_path() . 'lib/template-canvas.php';


		return get_template_directory() . '/index.php';
	}

	add_filter( 'emulsion_element_classes_root', 'emulsion_element_classes_root_filter' );

	function emulsion_element_classes_root_filter( $class ) {

		if ( function_exists( 'gutenberg_is_fse_theme' ) && gutenberg_is_fse_theme() ) {

			$class .= ' emulsion-fse-active';
		}
		return $class;
	}

}

/**
 * Stop Site editor
 */
function emulsion_stop_fse() {

	if ( gutenberg_is_fse_theme() ) {
		add_action( 'admin_menu', 'emulsion_remove_menus' );

		function emulsion_remove_menus() {
			global $menu;

			$gutenberg_edit_site = remove_menu_page( 'gutenberg-edit-site' );
		}

		remove_filter( 'emulsion_element_classes_root', 'emulsion_element_classes_root_filter' );

		$result = '';
		foreach ( get_template_types() as $template_type ) {
			if ( 'embed' === $template_type ) { // Skip 'embed' for now because it is not a regular template type.
				continue;
			}
			$result .= remove_filter( str_replace( '-', '', $template_type ) . '_template', 'gutenberg_override_query_template', 20, 3 ) ? '' : ' '. $template_type;
			$result .= remove_filter( str_replace( '-', '', $template_type ) . '_template', 'emulsion_gutenberg_override_query_template', 21, 3 ) ? '' : ' '. $template_type;
		}

		$result	 .= remove_action( 'wp_loaded', 'emulsion_gutenberg_add_template_loader_filters') ? '':' emulsion_gutenberg_add_template_loader_filters';

		$result	 .= remove_filter( 'block_editor_settings', 'gutenberg_experiments_editor_settings' ) ? '' : ' gutenberg_experiments_editor_settings';
		$result	 .= remove_filter( 'menu_order', 'gutenberg_menu_order' ) ? '' : ' gutenberg_menu_order';
		$result	 .= remove_action( 'admin_menu', 'gutenberg_remove_legacy_pages' ) ? '' : ' gutenberg_remove_legacy_pages';
		$result	 .= remove_action( 'wp_loaded', 'gutenberg_add_template_loader_filters' ) ? '' : ' gutenberg_add_template_loader_filters';
		$result	 .= remove_action( 'init', 'gutenberg_register_template_part_post_type' ) ? '' : ' gutenberg_register_template_part_post_type';
		$result	 .= remove_action( 'admin_menu', 'gutenberg_fix_template_part_admin_menu_entry' ) ? '' : ' gutenberg_fix_template_part_admin_menu_entry';
		$result	 .= remove_action( 'init', 'gutenberg_register_template_post_type' ) ? '' : ' gutenberg_register_template_post_type';
		$result	 .= remove_action( 'admin_menu', 'gutenberg_fix_template_admin_menu_entry' ) ? '' : ' gutenberg_fix_template_admin_menu_entry';
		$result  .= remove_action( 'init', 'gutenberg_register_block_core_post_content', 20 ) ? '': ' gutenberg_register_block_core_post_content';
		$result  .= remove_action( 'admin_notices', 'gutenberg_full_site_editing_notice' ) ? '': ' gutenberg_full_site_editing_notice';
		$result  .= remove_action( 'init', 'gutenberg_experimental_global_styles_register_cpt' ) ? '': ' gutenberg_experimental_global_styles_register_cpt';
		$result  .= remove_action( 'wp_enqueue_scripts', 'gutenberg_experimental_global_styles_enqueue_assets' ) ? '': ' gutenberg_experimental_global_styles_enqueue_assets' ;

		add_action( 'admin_notices', 'emulsion_full_site_editing_notice' );

		add_filter('language_attributes', function( $attribute){

			return $attribute. ' class="emulsion-fse-stopped"';
		} );



		if ( empty( $result ) ) {

			return true;
		} else {

			return 'faild filter:' . $result;
		}
	}
}

function emulsion_full_site_editing_notice() {
	?>
	<div class="notice notice-warning">
		<p><?php _e( 'You\'re using an experimental Full Site Editing theme. The function is temporarily stopped, but please use it only for experiments.', 'gutenberg' ); ?></p>
	</div>
	<?php
}

/**
 * Temporary changes to move pagenation
 * @param type $attributes
 * @param type $content
 * @param type $block
 * @return type
 */
function emulsion_gutenberg_render_block_core_query_loop( $attributes, $content, $block ) {
	$page_key = isset( $block->context['queryId'] ) ? 'query-' . $block->context['queryId'] . '-page' : 'query-page';
	$page     = empty( $_GET[ $page_key ] ) ? 1 : filter_var( $_GET[ $page_key ], FILTER_VALIDATE_INT );

	$query = array(
		'post_type'    => 'post',
		'offset'       => 0,
		'order'        => 'DESC',
		'orderby'      => 'date',
		'post__not_in' => array(),
	);

	if ( isset( $block->context['query'] ) ) {
		if ( isset( $block->context['query']['postType'] ) ) {
			$query['post_type'] = $block->context['query']['postType'];
		}
		if ( isset( $block->context['query']['sticky'] ) && ! empty( $block->context['query']['sticky'] ) ) {
			$sticky = get_option( 'sticky_posts' );
			if ( 'only' === $block->context['query']['sticky'] ) {
				$query['post__in'] = $sticky;
			} else {
				$query['post__not_in'] = array_merge( $query['post__not_in'], $sticky );
			}
		}
		if ( isset( $block->context['query']['exclude'] ) ) {
			$query['post__not_in'] = array_merge( $query['post__not_in'], $block->context['query']['exclude'] );
		}
		if ( isset( $block->context['query']['perPage'] ) ) {
			$query['offset'] = ( $block->context['query']['perPage'] * ( $page - 1 ) ) + $block->context['query']['offset'];
		}
		if ( isset( $block->context['query']['categoryIds'] ) ) {
			$query['category__in'] = $block->context['query']['categoryIds'];
		} else {
			// Add
			if( is_category() ) {
				$query['category__in'] = get_queried_object_id();
			}
		}
		if ( isset( $block->context['query']['tagIds'] ) ) {
			$query['tag__in'] = $block->context['query']['tagIds'];
		}
		if ( isset( $block->context['query']['order'] ) ) {
			$query['order'] = strtoupper( $block->context['query']['order'] );
		}
		if ( isset( $block->context['query']['orderBy'] ) ) {
			$query['orderby'] = $block->context['query']['orderBy'];
		}
		if ( isset( $block->context['query']['perPage'] ) ) {
			$query['posts_per_page'] = $block->context['query']['perPage'];
		}
		if ( isset( $block->context['query']['author'] ) ) {
			$query['author'] = $block->context['query']['author'];
		}
		if ( isset( $block->context['query']['search'] ) ) {
			$query['s'] = $block->context['query']['search'];
		} else {
			if( is_search() ) {
				$query['s'] = get_search_query();
			}
		}
	}

	$posts = get_posts( $query );

	$content = '';
	foreach ( $posts as $post ) {
		$content .= (
			new WP_Block(
				$block->parsed_block,
				array(
					'postType' => $post->post_type,
					'postId'   => $post->ID,
				)
			)
		)->render( array( 'dynamic' => false ) );
	}
	return $content;
}

/**
 * Registers the `core/query-loop` block on the server.
 */
function emulsion_gutenberg_register_block_core_query_loop() {
	register_block_type_from_metadata(
		__DIR__ . '/query-loop',
		array(
			'render_callback'   => 'emulsion_gutenberg_render_block_core_query_loop',
			'skip_inner_blocks' => true,
		)
	);
}
remove_action( 'init', 'gutenberg_register_block_core_query_loop', 20 );
add_action( 'init', 'emulsion_gutenberg_register_block_core_query_loop', 20 );




if( 'off' == filter_input( INPUT_GET, 'fse' ) && gutenberg_is_fse_theme() ) {

	emulsion_stop_fse();
}

