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

	if ( emulsion_do_fse() && 'experimental' == emulsion_get_theme_operation_mode() ) {

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

if ( 'theme' == emulsion_get_theme_operation_mode() ) {

	// todo can't remove. can't hide with CSS because the message doesn't have a special class
	//remove_action( 'admin_notices', 'gutenberg_full_site_editing_notice' );
}


/**
 * Fiters
 */
has_action( 'wp_footer', 'the_block_template_skip_link' ) ? remove_action( 'wp_footer', 'the_block_template_skip_link' ) : '';
has_action( 'wp_footer', 'gutenberg_the_skip_link' ) && 'transitional' == get_theme_mod( 'emulsion_editor_support' ) ? remove_action( 'wp_footer', 'gutenberg_the_skip_link' ) : '';
has_action( 'admin_bar_menu', 'gutenberg_adminbar_items' ) ? remove_action( 'admin_bar_menu', 'gutenberg_adminbar_items', 50 ) : '';
has_action( 'admin_bar_menu', 'modify_admin_bar', 40 ) ? add_action( 'admin_bar_menu', 'modify_admin_bar', 40 ) : '';

if ( emulsion_do_fse() ) {

	/**
	 * Removes the font size and font family settings set in the customizer and restores the browser initial size.
	 */
	/**
	 * remove common font style
	 */
	if ( 'fse' == emulsion_get_theme_operation_mode() ) {

		add_filter( 'emulsion_add_common_font_css_pre', '__return_empty_string' );

		/**
		 * remove headding font style
		 */
		add_filter( 'emulsion_heading_font_css_pre', '__return_empty_string' );

		/**
		 * Reset Background Color
		 * conditional if pure fse
		 */
		add_filter( 'theme_mod_background_color', function ( $color ) {
			return 'ffffff';
		} );

		/**
		 * Remove core custom-background class and relate color class
		 */
		add_filter( 'body_class', 'emulsion_fse_exclude_body_class', 30 );

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

	/**
	 * The following settings are provisional settings for migrating existing themes and FSE themes.
	 * You can display the full site editor by adjusting the filter.
	 *
	 * the headers are duplicates, but you can hide the theme headers etc. from the post or page metabox.
	 */
	// if needs pure fse. comment out below filter
	if ( 'transitional' == emulsion_get_theme_operation_mode() ) {

		add_action( 'wp_loaded', 'emulsion_gutenberg_add_template_loader_filters' );
	}
} else {

	has_filter( 'wp_loaded', 'gutenberg_add_template_loader_filters' ) ? remove_action( 'wp_loaded', 'gutenberg_add_template_loader_filters' ) : '';
	has_filter( 'wp_loaded', '_add_template_loader_filters' ) ? remove_action( 'wp_loaded', '_add_template_loader_filters' ) : '';
}

// current: emulsion_the_theme_supports('full_site_editor') allways true

 ! emulsion_the_theme_supports( 'full_site_editor' ) ? emulsion_stop_fse() : '';

'theme' == emulsion_get_theme_operation_mode() ? emulsion_stop_fse() : '';


function emulsion_html_template_names_callback( $template ) {

	return basename( $template, '.html' );
}

function emulsion_php_custom_template_names_callback( $template ) {

	return array( 'template-page/' . basename( $template ) => $template );
}

/**
 * Removed classes affecting FSE from body classes
 * @param type $classes
 * @return type
 */
function emulsion_fse_exclude_body_class( $classes ) {

	$result = array_diff( $classes, array( 'custom-background', 'is-light', 'is-dark', 'scheme-midnight' ) );

	return $result;
}



/**
 * Stop Site editor
 */
function emulsion_add_template_loader_filters() {
	if ( ! current_theme_supports( 'block-templates' ) ) {
		return;
	}
	$result			 = '';
	$template_types	 = array_keys( get_default_block_template_types() );

	foreach ( $template_types as $template_type ) {
		// Skip 'embed' for now because it is not a regular template type.
		if ( 'embed' === $template_type ) {
			continue;
		}
		$result .= remove_filter( str_replace( '-', '', $template_type ) . '_template', 'locate_block_template', 20, 3 ) ? '' : ' ' . $template_type;
	}

	// Request to resolve a template.
	if ( isset( $_GET['_wp-find-template'] ) ) {
		add_filter( 'pre_get_posts', '_resolve_template_for_new_post' );
	}
}

function emulsion_stop_fse() {

	if ( function_exists( 'gutenberg_is_fse_theme' ) && gutenberg_is_fse_theme() || function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) {

		add_action( 'wp_loaded', 'emulsion_add_template_loader_filters' );

		remove_filter( 'emulsion_element_classes_root', 'emulsion_element_classes_root_filter' );

		$result = '';

		$html_templates = array();

		if ( function_exists( 'get_default_block_template_types' ) ) {

			$html_templates = array_keys( get_default_block_template_types() );

			foreach ( $html_templates as $template_type ) {
				if ( 'embed' === $template_type ) {

					continue;
				}
				if ( has_filter( str_replace( '-', '', $template_type ) . '_template' ) && has_filter( str_replace( '-', '', $template_type ) . '_template', 'gutenberg_override_query_template' ) ) {

					if ( function_exists( 'gutenberg_override_query_template' ) ) {

						$result .= remove_filter( str_replace( '-', '', $template_type ) . '_template', 'gutenberg_override_query_template', 20, 3 ) ? '' : ' ' . $template_type;
					}
					////block-template.php
					if ( function_exists( 'locate_block_template' ) && has_filter( str_replace( '-', '', $template_type ) . '_template', 'locate_block_template' ) ) {

						$result .= remove_filter( str_replace( '-', '', $template_type ) . '_template', 'locate_block_template', 20, 3 ) ? '' : ' ' . $template_type;
					}
				}
			}
		}

		if ( 'theme' == emulsion_get_theme_operation_mode() ) {

			add_action( 'wp_loaded', 'emulsion_gutenberg_add_template_loader_filters' );
		}

		if ( has_filter( 'wp_loaded', 'gutenberg_add_template_loader_filters' ) ) {
			//block-template.php
			$result .= remove_action( 'wp_loaded', 'gutenberg_add_template_loader_filters' ) ? '' : ' gutenberg_add_template_loader_filters';
		}
		if ( has_filter( 'wp_loaded', '_add_template_loader_filters' ) ) {

			$result .= remove_action( 'wp_loaded', '_add_template_loader_filters' ) ? '' : ' _add_template_loader_filters';
		}

		//check
		if ( has_filter( 'init', 'gutenberg_register_block_core_post_content' ) ) {
			$result .= remove_action( 'init', 'gutenberg_register_block_core_post_content', 20 ) ? '' : ' gutenberg_register_block_core_post_content';
		}
		if ( has_filter( 'wp_enqueue_scripts', 'gutenberg_experimental_global_styles_enqueue_assets' ) ) {
			$result .= remove_action( 'wp_enqueue_scripts', 'gutenberg_experimental_global_styles_enqueue_assets' ) ? '' : ' gutenberg_experimental_global_styles_enqueue_assets';
		}

		if ( empty( $result ) ) {

			return true;
		} else {

			return false;
		}
	}
}

/**
 * Using PHP template fse transitional mode
 *
 * @param type $template
 * @return type
 */
if ( ! function_exists( 'emulsion_custom_template_include' ) ) {

	function emulsion_custom_template_include( $template ) {

		$new_template = '';

		if ( 'template-canvas.php' === basename( $template ) ) {

			if ( is_singular() ) {

				$new_template = locate_template( array( 'singular.php' ) );
			} elseif ( is_search() ) {

				$new_template = locate_template( array( 'search.php' ) );
			} elseif ( is_category() ) {

				$new_template = locate_template( array( 'category.php' ) );
			} elseif ( is_tag() ) {

				$new_template = locate_template( array( 'tag.php' ) );
			} elseif ( is_author() ) {

				$new_template = locate_template( array( 'author.php' ) );
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

}

/**
 * Adds necessary filters to use 'wp_template' posts instead of theme template files.
 */
function emulsion_gutenberg_add_template_loader_filters() {

	if ( ! emulsion_do_fse() || ! emulsion_the_theme_supports( 'full_site_editor' ) ) {

		return;
	}

	$html_templates = array();

	if ( function_exists( 'get_default_block_template_types' ) ) {

		$html_templates = array_keys( get_default_block_template_types() );
	}


	foreach ( $html_templates as $template_type ) {
		if ( 'embed' === $template_type ) {

			continue;
		}

		add_filter( str_replace( '-', '', $template_type ) . '_template', 'emulsion_custom_template_include', 21 );
	}
}

add_action( 'admin_bar_menu', 'emulsion_admin_bar_customize_menu', 60 );

function emulsion_get_customize_page_url() {
	global $wp_customize;

	// Don't show for users who can't access the customizer
	if ( ! current_user_can( 'customize' ) ) {
		return false;
	}

	// Don't show if the user cannot edit a given customize_changeset post currently being previewed.
	if ( is_customize_preview() && $wp_customize->changeset_post_id() && ! current_user_can( get_post_type_object( 'customize_changeset' )->cap->edit_post, $wp_customize->changeset_post_id() )
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
	global $wp_customize, $wp_version;

	$customize_url = emulsion_get_customize_page_url();

	if ( empty( $customize_url ) || ! version_compare( $wp_version, '5.9-bata', '>=' ) ) {
		return;
	}
	if ( ! empty( $wp_admin_bar->get_node( 'customize' ) ) ) {
		return;
	}

	$wp_admin_bar->add_menu(
			array(
				'id'	 => 'emulsion_admin_bar_customize_menu',
				'title'	 => __( 'Customize', 'emulsion' ),
				'href'	 => $customize_url,
				'meta'	 => array(
					'class' => 'hide-if-no-customize',
				),
			)
	);
	add_action( 'wp_before_admin_bar_render', 'wp_customize_support_script' );
}

function emulsion_load_block_page_templates( $templates, $theme, $post,
		$post_type ) {
	/**
	 * Todo this filter not work ? javascript filter ?
	 */
	$html_template	 = array();
	$php_template	 = array();

	foreach ( $templates as $key => $val ) {
		if ( false === strstr( $key, '.php' ) ) {

			$html_template[$key] = $val;
		} else {

			$php_template[$key] = $val;
		}
	}

	if ( 'theme' == emulsion_get_theme_operation_mode() ) {

		return $php_template;
	}
	if ( 'fse' == emulsion_get_theme_operation_mode() ) {

		return $html_template;
	}


	return $templates;
}

//add_filter( 'theme_templates', 'emulsion_load_block_page_templates', 20, 4 );

'disable' == get_theme_mod( 'emulsion_custom_css_support' ) ? emulsion_custom_css_support() : '';

function emulsion_custom_css_support() {
	global $wp_customize;

	if ( 'theme' !== emulsion_get_theme_operation_mode() ) {
		remove_action( 'wp_head', 'wp_custom_css_cb', 101 );

		add_action( 'customize_register', function ( $wp_customize ) {
			$wp_customize->remove_section( 'custom_css' );
		} );
	}
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

add_action( 'enqueue_block_editor_assets', function () {

	$post_type	 = filter_input( INPUT_GET, 'postType', FILTER_SANITIZE_SPECIAL_CHARS );
	$post_id	 = filter_input( INPUT_GET, 'postId', FILTER_SANITIZE_SPECIAL_CHARS );
	$page		 = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS );

	If ( empty( $post_type ) && empty( $post_id ) && 'gutenberg-edit-site' == $page ) {

		echo '<div style="position:absolute;height: 20vh;max-width:100%; background: #eee;top: 0;right: 0;bottom: 0;left: 0;margin: auto;width: 720px;">'
		. '<p style="padding:0 24px;">'
		. esc_html__( 'It may take some time for the site editor to appear.', 'emulsion' )
		. '</p>'
		. '<p style="padding:0 24px;">'
		. esc_html__( 'Exception: If you have added a PHP template to your theme, the site editor will not be displayed', 'emulsion' )
		. '</p>'
		. '</div>';
	}
} );
