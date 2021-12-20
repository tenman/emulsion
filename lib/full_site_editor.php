<?php
/**
 *
 * Switch PHP template mode FSE HTML template mode, and Transitional mode
 * In Transitional mode, insert wp-site-blocks directly under the main element of PHP template
 *
 * @see emulsion_do_fse() in lib/template_tags.php
 */

add_action( 'admin_notices', 'emulsion_theme_admin_notice_fse' );

function emulsion_theme_admin_notice_fse() {

	if ( emulsion_do_fse() && 'experimental' == get_theme_mod( 'emulsion_editor_support' ) ) {

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

if ( 'theme' == get_theme_mod( 'emulsion_editor_support' ) ) {

	// todo can't remove. can't hide with CSS because the message doesn't have a special class
	//remove_action( 'admin_notices', 'gutenberg_full_site_editing_notice' );
}

function emulsion_full_site_editing_notice() {
	?>
	<div class="notice notice-warning">
		<p><?php esc_html_e( 'You\'re using an experimental Full Site Editing theme. The function is temporarily stopped, but please use it only for experiments.', 'emulsion' ); ?></p>
	</div>
	<?php
}

/**
 * Fiters
 */

if ( ! emulsion_do_fse() ) {

	remove_action( 'wp_loaded', 'gutenberg_add_template_loader_filters' );
}

function_exists( 'the_block_template_skip_link' ) ? remove_action( 'wp_footer', 'the_block_template_skip_link' ) : '';

if('transitional' == get_theme_mod('emulsion_editor_support') ){

	function_exists( 'gutenberg_the_skip_link' ) ? remove_action( 'wp_footer', 'gutenberg_the_skip_link' ) : '';
}

// adminbar: show customize menu when fse mode
function_exists( 'gutenberg_adminbar_items' ) ? remove_action( 'admin_bar_menu', 'gutenberg_adminbar_items', 50 ) : '';

//add widget fse widget
function_exists( 'modify_admin_bar' ) ? add_action( 'admin_bar_menu', 'modify_admin_bar', 40 ) : '';




if ( emulsion_do_fse() ) {

	/**
	 * Removes the font size and font family settings set in the customizer and restores the browser initial size.
	 */

	/**
	 * remove common font style
	 */

	if ( 'fse' == emulsion_get_fse_experimental() ) {

		add_filter( 'emulsion_add_common_font_css_pre', '__return_empty_string' );

		/**
		 * remove headding font style
		 */

		add_filter( 'emulsion_heading_font_css_pre', '__return_empty_string' );

		/**
		 * Reset Background Color
		 * conditional if pure fse
		 */

		add_filter( 'theme_mod_background_color', function( $color ) {
			return 'ffffff';
		} );

		/**
		 * Remove core custom-background class and relate color class
		 */

		add_filter( 'body_class', 'emulsion_remove_body_classes', 30 );

		/**
		 * Classic Sidebar Class Remove
		 */

		add_filter( 'emulsion_the_theme_supports', function ( $support, $name ) {

			$remove_supports = array( 'sidebar', 'sidebar-page', 'title_in_page_header' );
			$theme_mode		 = get_theme_mod( 'emulsion_editor_support', false );

			if ( in_array( $name, $remove_supports ) && 'fse' == $theme_mode ) {

				return false;
			}

			return $support;
		}, 10, 2 );

		/**
		 * For meta information related font sizes, if necessary
		 */

		//add_filter( 'emulsion_widget_meta_font_css_pre', '__return_empty_string');
	}
}

/**
 * Removed classes affecting FSE from body classes
 * @param type $classes
 * @return type
 */
function emulsion_remove_body_classes( $classes ) {

	$result = array_diff( $classes, array( 'custom-background', 'is-light', 'is-dark', 'scheme-midnight' ) );

	return $result;
}

if ( emulsion_do_fse() ) {
	/**
	 * The following settings are provisional settings for migrating existing themes and FSE themes.
	 * You can display the full site editor by adjusting the filter.
	 *
	 * the headers are duplicates, but you can hide the theme headers etc. from the post or page metabox.
	 */
	// if needs pure fse. comment out below filter
	if ( 'transitional' == get_theme_mod( 'emulsion_editor_support' ) ) {

		add_action( 'wp_loaded', 'emulsion_gutenberg_add_template_loader_filters' );
	}
	/*
	if ( 'transitional' == filter_input( INPUT_GET, 'fse' ) ) {

		add_action( 'wp_loaded', 'emulsion_gutenberg_add_template_loader_filters' );
	}*/
}

/*
if ( 'off' == filter_input( INPUT_GET, 'fse' ) && gutenberg_is_fse_theme() ) {

	emulsion_stop_fse();

}*/

if ( ! emulsion_the_theme_supports( 'full_site_editor' ) ) {
	// current: emulsion_the_theme_supports('full_site_editor') allways true
	emulsion_stop_fse();
}


if ( 'theme' == get_theme_mod( 'emulsion_editor_support' ) ) {

	emulsion_stop_fse();
}

function emulsion_html_template_names_callback( $test ) {

	return basename( $test, '.html' );
}

function emulsion_php_custom_template_names_callback( $test ) {

	return array('template-page/' . basename( $test ) => $test );
}

/**
 * Stop Site editor
 */
function emulsion_add_template_loader_filters() {
	if ( ! current_theme_supports( 'block-templates' ) ) {
		return;
	}
$result = '';
	$template_types = array_keys( get_default_block_template_types() );
	foreach ( $template_types as $template_type ) {
		// Skip 'embed' for now because it is not a regular template type.
		if ( 'embed' === $template_type ) {
			continue;
		}
		$result .= remove_filter( str_replace( '-', '', $template_type ) . '_template', 'locate_block_template', 20, 3 ) ? '':' '.$template_type;
	}

	// Request to resolve a template.
	if ( isset( $_GET['_wp-find-template'] ) ) {
		add_filter( 'pre_get_posts', '_resolve_template_for_new_post' );
	}
}
function emulsion_stop_fse() {

	if ( gutenberg_is_fse_theme() ) {



		add_action( 'wp_loaded', 'emulsion_add_template_loader_filters' );

		remove_filter( 'emulsion_element_classes_root', 'emulsion_element_classes_root_filter' );

		$result = '';

		if ( function_exists( 'get_default_block_template_types' ) ) {

			$html_templates = array_keys( get_default_block_template_types() );
		} else {

			$html_templates = gutenberg_get_template_type_slugs();
		}

		foreach ( $html_templates as $template_type ) {
			if ( 'embed' === $template_type ) {

				continue;
			}
			if ( has_filter( str_replace( '-', '', $template_type ) . '_template' ) ) {

				$result .= remove_filter( str_replace( '-', '', $template_type ) . '_template', 'gutenberg_override_query_template', 20, 3 ) ? '' : ' ' . $template_type;
			}
		}

		if ( 'theme' == get_theme_mod( 'emulsion_editor_support' ) ) {

			add_action( 'wp_loaded', 'emulsion_gutenberg_add_template_loader_filters' );
		}
		/*if ( 'theme' == filter_input( INPUT_GET, 'fse' ) ) {

			add_action( 'wp_loaded', 'emulsion_gutenberg_add_template_loader_filters' );
		}*/

		//$result	 .= remove_action( 'admin_bar_menu', 'gutenberg_adminbar_items', 50 ) ? '' : ' gutenberg_adminbar_items';

		//$result	 .= remove_filter( 'menu_order', 'gutenberg_menu_order' ) ? '' : ' gutenberg_menu_order';
		//$result	 .= remove_action( 'admin_menu', 'gutenberg_remove_legacy_pages' ) ? '' : ' gutenberg_remove_legacy_pages';
		$result	 .= remove_action( 'wp_loaded', 'gutenberg_add_template_loader_filters' ) ? '' : ' gutenberg_add_template_loader_filters';
		if( function_exists( '_add_template_loader_filters') ) {
			$result .= add_action( 'wp_loaded', '_add_template_loader_filters' ) ? '': ' _add_template_loader_filters';
		}
		//$result .= remove_action( 'admin_menu', 'gutenberg_fix_template_part_admin_menu_entry' ) ? '' : ' gutenberg_fix_template_part_admin_menu_entry';
		//$result	 .= remove_action( 'admin_menu', 'gutenberg_fix_template_admin_menu_entry' ) ? '' : ' gutenberg_fix_template_admin_menu_entry';
		//check
		$result	 .= remove_action( 'init', 'gutenberg_register_block_core_post_content', 20 ) ? '' : ' gutenberg_register_block_core_post_content';
		$result	 .= remove_action( 'wp_enqueue_scripts', 'gutenberg_experimental_global_styles_enqueue_assets' ) ? '' : ' gutenberg_experimental_global_styles_enqueue_assets';

		add_action( 'admin_notices', 'emulsion_full_site_editing_notice' );

		if ( empty( $result ) ) {

			return true;
		} else {

			return 'faild filter:' . $result;
		}
	}
}

/**
 *
 * @return boolean
 */
function emulsion_get_fse_experimental() {

	/*$query_vals = array( 'transitional', 'theme', 'fse' );

	if ( 'experimental' == get_theme_mod( 'emulsion_editor_support' ) && current_user_can( 'manage_options' ) ) {

		$query = filter_input( INPUT_GET, 'fse' );

		$result = empty( $query ) ? 'fse' : $query;

		//varidation
		if ( in_array( $result, $query_vals ) ) {

			return $result;
		}
	}*/

	return get_theme_mod( 'emulsion_editor_support' );
}

/**
 * Using PHP template fse transitional mode
 *
 * @param type $template
 * @return type
 */
function emulsion_custom_template_include( $template ) {

	$new_template = '';

	if ( 'template-canvas.php' === basename( $template ) ) {

		if ( is_singular() ) {

			$new_template = locate_template( array( 'singular.php' ) );
		} elseif ( is_search() ) {

			$new_template = locate_template( array( 'search.php' ) );
		} else {

			$new_template = locate_template( array( 'index.php' ) );
		}

		if ( '' !== $new_template ) {

			return $new_template;
		} else {

			return locate_template( array( 'index.php' ) );
		}
	}

	return $template;
}

/**
 * Adds necessary filters to use 'wp_template' posts instead of theme template files.
 */
function emulsion_gutenberg_add_template_loader_filters() {

	if ( ! gutenberg_is_fse_theme() || ! emulsion_the_theme_supports( 'full_site_editor' ) ) {

		return;
	}

	$html_templates = gutenberg_get_template_type_slugs();

	foreach ( $html_templates as $template_type ) {
		if ( 'embed' === $template_type ) {

			continue;
		}

		add_filter( str_replace( '-', '', $template_type ) . '_template', 'emulsion_custom_template_include', 21 );
	}
}
add_action( 'admin_bar_menu', 'emulsion_admin_bar_customize_menu',40);

function emulsion_get_customize_page_url(){
		global $wp_customize;

	// Don't show for users who can't access the customizer
	if ( ! current_user_can( 'customize' ) ) {
		return false;
	}

	// Don't show if the user cannot edit a given customize_changeset post currently being previewed.
	if ( is_customize_preview() && $wp_customize->changeset_post_id()
		&& ! current_user_can( get_post_type_object( 'customize_changeset' )->cap->edit_post, $wp_customize->changeset_post_id() )
	) {
		return false;
	}

	$current_url = esc_url( ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
	if ( is_customize_preview() && $wp_customize->changeset_uuid() ) {
		$current_url = remove_query_arg( 'customize_changeset_uuid', $current_url );
	}

	$customize_url = esc_url( add_query_arg( 'url', urlencode( $current_url ), wp_customize_url() ) );
	if ( is_customize_preview() ) {
		$customize_url = esc_url( add_query_arg( array( 'changeset_uuid' => $wp_customize->changeset_uuid() ), $customize_url ) );
	}

	return $customize_url;

}

function emulsion_admin_bar_customize_menu( $wp_admin_bar ) {
	global $wp_customize,$wp_version;

	$customize_url = emulsion_get_customize_page_url();

	if( empty( $customize_url ) || ! version_compare( $wp_version, '5.9-bata', '>=' ) ) {
		return;
	}

	$wp_admin_bar->add_menu(
		array(
			'id'    => 'emulsion_admin_bar_customize_menu',
			'title' => __( 'Customize', 'emulsion' ),
			'href'  => $customize_url,
			'meta'  => array(
				'class' => 'hide-if-no-customize',
			),
		)
	);
	add_action( 'wp_before_admin_bar_render', 'wp_customize_support_script' );
}



// Experimental purpose

/**
 * Change widget to old type
 */

function emulsion_revert_widgets_area() {

	current_theme_supports( 'widgets-block-editor' ) ? remove_theme_support( 'widgets-block-editor' ) : '';

	add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );

	add_filter( 'use_widgets_block_editor', '__return_false' );
}

//add_action( 'after_setup_theme', 'emulsion_revert_widgets_area' );