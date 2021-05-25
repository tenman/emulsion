<?php
/**
 * ONLY TEST PURPOSE
 *
 * Currently, if block-template / index.html exists, gutenberg will switch to fse mode.
 * @see emulsion_do_fse() in lib/template_tags.php
 */
add_action( 'admin_notices', 'emulsion_theme_admin_notice_fse' );

function emulsion_theme_admin_notice_fse() {

	if ( is_readable( get_template_directory() . '/block-templates/index.html' ) ) {

		$message = esc_html__( 'The file has been renamed from experimental-index.html to index.html for an FSE theme experiment ', 'emulsion' );

		if ( ! is_plugin_active( 'gutenberg/gutenberg.php' ) ) {

			$message .= '<br> ' . esc_html__( 'the Gutenberg plugin is not active.', 'emulsion' );

			$message .= '<br> ' . esc_html__( 'Require to activate the Gutenberg plugin for the experiment.', 'emulsion' );
		}

		if ( ! is_plugin_active( 'emulsion-addons/emulsion.php' ) ) {

			$message .= '<br> ' . esc_html__( 'the emulsion-addons plugin is not active.', 'emulsion' );

			$message .= '<br> ' . esc_html__( 'Require to activate the emulsion-addons plugin for the experiment.', 'emulsion' );
		}

		if ( is_plugin_active( 'gutenberg/gutenberg.php' ) && is_plugin_active( 'emulsion-addons/emulsion.php' ) ) {

			$message = esc_html__( "The experiment is ready. when the experiment is finished Don't forget to change 'index.html' to 'experimental-index.html' and deactivate the gutenberg plugin ", 'emulsion' );

			printf( '<div class="notice notice-error is-dismissible emulsion-addon-error"><p><strong>%1$s</strong></p></div>', $message );
		} else {

			$plugin_install_url = esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=all' ) );

			printf( '<div class="notice notice-error is-dismissible emulsion-addon-error"><p><strong>%1$s</strong> '
					. ' <br><a href="%2$s">%3$s</a></p></div>', $message, $plugin_install_url, esc_html__( 'Plugin Activate', 'emulsion' )
			);
		}
	}
}

if ( function_exists( 'gutenberg_is_fse_theme' ) && ! gutenberg_is_fse_theme() ) {
//if ( function_exists( 'gutenberg_supports_block_templates' ) && ! gutenberg_supports_block_templates() ) {
	/**
	 * Gutenberg 10.5.4
	 * Fixed an issue where the theme would load without determining the FSE theme when it had an FSE template part file
	 */
	remove_action( 'wp_loaded', 'gutenberg_add_template_loader_filters' );


}



if ( emulsion_do_fse() ) {
	/**
	 * The following settings are provisional settings for migrating existing themes and FSE themes.
	 * You can display the full site editor by adjusting the filter.
	 *
	 * the headers are duplicates, but you can hide the theme headers etc. from the post or page metabox.
	 */
	// if needs pure fse. comment out below filter
	if ( 'transitional' == filter_input( INPUT_GET, 'fse' ) ) {
		add_action( 'wp_loaded', 'emulsion_gutenberg_add_template_loader_filters' );
	}

	/**
	 * Adds necessary filters to use 'wp_template' posts instead of theme template files.
	 */
	function emulsion_gutenberg_add_template_loader_filters() {
		if ( ! gutenberg_is_fse_theme() || ! emulsion_the_theme_supports( 'full_site_editor' ) ) {
		//if ( ! gutenberg_supports_block_templates() || ! emulsion_the_theme_supports( 'full_site_editor' ) ) {
			return;
		}
		if ( ! function_exists( 'gutenberg_resolve_template' ) ) {

			return;
		}

		foreach ( gutenberg_get_template_type_slugs() as $template_type ) {
			if ( 'embed' === $template_type ) { // Skip 'embed' for now because it is not a regular template type.
				continue;
			}
			add_filter( str_replace( '-', '', $template_type ) . '_template', 'emulsion_gutenberg_override_query_template', 21, 3 );
		}
	}

	function emulsion_gutenberg_override_query_template( $template, $type,
			array $templates = array() ) {

		global $_wp_current_template_content;

		$current_template = gutenberg_resolve_template( $type, $templates );

		// Allow falling back to a PHP template if it has a higher priority than the block template.
		$current_template_slug = str_replace(
				array( trailingslashit( get_stylesheet_directory() ), trailingslashit( get_template_directory() ), '.php' ), '', $template
		);

		$current_block_template_slug = is_object( $current_template ) ? $current_template->slug : false;

		foreach ( $templates as $template_item ) {
			$template_item_slug = gutenberg_strip_php_suffix( $template_item );

			// Break the loop if the block-template matches the template slug.
			if ( $current_block_template_slug === $template_item_slug ) {

				// if the theme is a child theme we want to check if a php template exists.
				if ( is_child_theme() ) {

					$has_php_template	 = file_exists( get_stylesheet_directory() . '/' . $current_template_slug . '.php' );
					$block_template		 = _gutenberg_get_template_file( 'wp_template', $current_block_template_slug );
					$has_block_template	 = false;

					if ( null !== $block_template && wp_get_theme()->get_stylesheet() === $block_template['theme'] ) {
						$has_block_template = true;
					}
					// and that a corresponding block template from the theme and not the parent doesn't exist.
					if ( $has_php_template && ! $has_block_template ) {
						return $template;
					}
				}

				break;
			}

			// Is this a custom template?
			// This check should be removed when merged in core.
			// Instead, wp_templates should be considered valid in locate_template.
			$is_custom_template = 0 === strpos( $current_block_template_slug, 'wp-custom-template-' );

			// Don't override the template if we find a template matching the slug we look for
			// and which does not match a block template slug.
			if (
					! $is_custom_template &&
					$current_template_slug !== $current_block_template_slug &&
					$current_template_slug === $template_item_slug
			) {
				return $template;
			}
		}

		if ( $current_template ) {

			//$_wp_current_template_content = empty( $current_template->post_content ) ? esc_html__( 'Empty template.', 'emulsion' ) : $current_template->post_content;

			if ( isset( $_GET['_wp-find-template'] ) ) {
				wp_send_json_success( $current_template['template_post'] );
			}
		} else {
			if ( 'index' === $type ) {
				if ( isset( $_GET['_wp-find-template'] ) ) {
					wp_send_json_error( array( 'message' => esc_html__( 'No matching template found.', 'emulsion' ) ) );
				}
			} else {
				return false; // So that the template loader keeps looking for templates.
			}
		}

		// Add hooks for template canvas.
		// Add viewport meta tag.
		//add_action( 'wp_head', 'gutenberg_viewport_meta_tag', 0 );
		// Render title tag with content, regardless of whether theme has title-tag support.
		//remove_action( 'wp_head', '_wp_render_title_tag', 1 ); // Remove conditional title tag rendering...
		//add_action( 'wp_head', 'gutenberg_render_title_tag', 1 ); // ...and make it unconditional.
		// This file will be included instead of the theme's template file.
		//return gutenberg_dir_path() . 'lib/template-canvas.php';


		return get_template_directory() . '/index.php';
	}

	add_filter( 'emulsion_element_classes_root', 'emulsion_element_classes_root_filter' );

	function emulsion_element_classes_root_filter( $class ) {

		if ( function_exists( 'gutenberg_is_fse_theme' ) && gutenberg_is_fse_theme() ) {
		//if ( function_exists( 'gutenberg_supports_block_templates' ) && gutenberg_supports_block_templates() ) {
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
	//if ( gutenberg_supports_block_templates() ) {
		add_action( 'admin_menu', 'emulsion_remove_menus' );

		function emulsion_remove_menus() {
			global $menu;

			$gutenberg_edit_site = remove_menu_page( 'gutenberg-edit-site' );
		}

		remove_filter( 'emulsion_element_classes_root', 'emulsion_element_classes_root_filter' );

		$result = '';
		foreach ( gutenberg_get_template_type_slugs() as $template_type ) {
			if ( 'embed' === $template_type ) { // Skip 'embed' for now because it is not a regular template type.
				continue;
			}
			$result	 .= remove_filter( str_replace( '-', '', $template_type ) . '_template', 'gutenberg_override_query_template', 20, 3 ) ? '' : ' ' . $template_type;
			$result	 .= remove_filter( str_replace( '-', '', $template_type ) . '_template', 'emulsion_gutenberg_override_query_template', 21, 3 ) ? '' : ' ' . $template_type;
		}

		$result .= remove_action( 'wp_loaded', 'emulsion_gutenberg_add_template_loader_filters' ) ? '' : ' emulsion_gutenberg_add_template_loader_filters';

		$result	 .= remove_filter( 'block_editor_settings', 'gutenberg_experiments_editor_settings' ) ? '' : ' gutenberg_experiments_editor_settings';
		$result	 .= remove_filter( 'menu_order', 'gutenberg_menu_order' ) ? '' : ' gutenberg_menu_order';
		$result	 .= remove_action( 'admin_menu', 'gutenberg_remove_legacy_pages' ) ? '' : ' gutenberg_remove_legacy_pages';
		$result	 .= remove_action( 'wp_loaded', 'gutenberg_add_template_loader_filters' ) ? '' : ' gutenberg_add_template_loader_filters';
		$result	 .= remove_action( 'init', 'gutenberg_register_template_part_post_type' ) ? '' : ' gutenberg_register_template_part_post_type';
		$result	 .= remove_action( 'admin_menu', 'gutenberg_fix_template_part_admin_menu_entry' ) ? '' : ' gutenberg_fix_template_part_admin_menu_entry';
		$result	 .= remove_action( 'init', 'gutenberg_register_template_post_type' ) ? '' : ' gutenberg_register_template_post_type';
		$result	 .= remove_action( 'admin_menu', 'gutenberg_fix_template_admin_menu_entry' ) ? '' : ' gutenberg_fix_template_admin_menu_entry';
		$result	 .= remove_action( 'init', 'gutenberg_register_block_core_post_content', 20 ) ? '' : ' gutenberg_register_block_core_post_content';
		$result	 .= remove_action( 'admin_notices', 'gutenberg_full_site_editing_notice' ) ? '' : ' gutenberg_full_site_editing_notice';
		$result	 .= remove_action( 'init', 'gutenberg_experimental_global_styles_register_cpt' ) ? '' : ' gutenberg_experimental_global_styles_register_cpt';
		$result	 .= remove_action( 'wp_enqueue_scripts', 'gutenberg_experimental_global_styles_enqueue_assets' ) ? '' : ' gutenberg_experimental_global_styles_enqueue_assets';

		add_action( 'admin_notices', 'emulsion_full_site_editing_notice' );

		add_filter( 'language_attributes', function( $attribute) {

			return $attribute . ' class="emulsion-fse-stopped"';
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
		<p><?php esc_html_e( 'You\'re using an experimental Full Site Editing theme. The function is temporarily stopped, but please use it only for experiments.', 'emulsion' ); ?></p>
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
function emulsion_gutenberg_render_block_core_query_loop( $attributes, $content,
		$block ) {
	$page_key	 = isset( $block->context['queryId'] ) ? 'query-' . $block->context['queryId'] . '-page' : 'query-page';
	$page		 = empty( $_GET[$page_key] ) ? 1 : filter_var( $_GET[$page_key], FILTER_VALIDATE_INT );

	$query = array(
		'post_type'		 => 'post',
		'offset'		 => 0,
		'order'			 => 'DESC',
		'orderby'		 => 'date',
		'post__not_in'	 => array(),
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
			if ( is_category() ) {
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
			if ( is_search() ) {
				$query['s'] = get_search_query();
			}
		}
	}

	$posts = get_posts( $query );

	$content = '';
	foreach ( $posts as $post ) {
		$content .= (
				new WP_Block(
				$block->parsed_block, array(
			'postType'	 => $post->post_type,
			'postId'	 => $post->ID,
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
			__DIR__ . '/query-loop', array(
		'render_callback'	 => 'emulsion_gutenberg_render_block_core_query_loop',
		'skip_inner_blocks'	 => true,
			)
	);
}

remove_action( 'init', 'gutenberg_register_block_core_query_loop', 20 );
add_action( 'init', 'emulsion_gutenberg_register_block_core_query_loop', 20 );




if ( 'off' == filter_input( INPUT_GET, 'fse' ) && gutenberg_is_fse_theme() ) {
//if ( 'off' == filter_input( INPUT_GET, 'fse' ) && gutenberg_supports_block_templates() ) {
	emulsion_stop_fse();
}

