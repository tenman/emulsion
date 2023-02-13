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
if ( 'fse' !== get_theme_mod( 'emulsion_editor_support' ) ) {
	has_action( 'wp_footer', 'the_block_template_skip_link' ) ? remove_action( 'wp_footer', 'the_block_template_skip_link' ) : '';
	has_action( 'wp_footer', 'gutenberg_the_skip_link' ) && 'transitional' == get_theme_mod( 'emulsion_editor_support' ) ? remove_action( 'wp_footer', 'gutenberg_the_skip_link' ) : '';
}

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
		/**
		 * front-page.php and home.php cannot be created.
		 * If necessary, set the page from the customizer's front page settings and apply the template to that page.
		 *
		 */
		$new_template = '';

		if ( 'template-canvas.php' === basename( $template ) ) {

			if ( is_single() ) {

				$new_template = emulsion_get_single_template();
			}
			if ( is_page() ) {

				$new_template = emulsion_get_page_template();

			}

			if ( is_singular() && empty( $new_template ) ) {

				$new_template = locate_template( array( 'fse-compatible-classic-template/singular.php' ) );
			}

			if ( is_privacy_policy() ) {

				$new_template = locate_template( array( 'fse-compatible-classic-template/privacy-policy.php' ) );
			}
			if ( is_search() ) {

				$new_template = emulsion_get_search_template();
			}

			if ( is_post_type_archive() ) {

				$new_template = emulsion_get_post_type_archive_template();

				if ( empty( $new_template ) ) {
					$new_template = emulsion_get_archive_template();
				}
			}
			if ( is_tax() ) {

				$new_template = emulsion_get_taxonomy_template();
				if ( empty( $new_template ) ) {

					$new_template = emulsion_get_archive_template();
				}
			}
			if ( is_embed() ) {

				$new_template = locate_template( array( emulsion_get_embed_template() ) );
			}
			if ( is_attachment() ) {

				$new_template = locate_template( array( emulsion_get_attachment_template() ) );
			}
			if ( is_category() ) {

				$new_template = emulsion_get_category_template();

				if ( empty( $new_template ) ) {

					$new_template = emulsion_get_archive_template();
				}

			}

			if ( is_tag() ) {

				$new_template = emulsion_get_tag_template();

				if ( empty( $new_template ) ) {

					$new_template = emulsion_get_archive_template();
				}

			}
			if ( is_author() ) {

				$new_template = emulsion_get_author_template();
				if ( empty( $new_template ) ) {

					$new_template = emulsion_get_archive_template();
				}

			}
			if ( is_404() ) {

				$new_template = locate_template( array( 'fse-compatible-classic-template/404.php' ) );

			}
			if ( is_date() ) {
				$new_template = locate_template( array( 'fse-compatible-classic-template/date.php' ) );
				if ( empty( $new_template ) ) {
				$new_template = emulsion_get_archive_template();
				}

			}

			if ( '' !== $new_template ) {
				return $new_template;
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

add_action( 'init', function () {
	'enable' !== get_theme_mod( 'emulsion_core_block_patterns_support' ) ? remove_theme_support( 'core-block-patterns' ) : add_theme_support( 'core-block-patterns' );
}, 9 );

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

if ( ! function_exists( 'emulsion_get_category_template' ) ) {

	function emulsion_get_category_template() {
		$category = get_queried_object();

		$templates = array();

		if ( ! empty( $category->slug ) ) {

			$slug_decoded = urldecode( $category->slug );
			if ( $slug_decoded !== $category->slug ) {
				$templates[] = "fse-compatible-classic-template/category-{$slug_decoded}.php";
			}

			$templates[] = "fse-compatible-classic-template/category-{$category->slug}.php";
			$templates[] = "fse-compatible-classic-template/category-{$category->term_id}.php";
		}
		$templates[] = 'fse-compatible-classic-template/category.php';

		return get_query_template( 'category', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_tag_template' ) ) {

	function emulsion_get_tag_template() {
		$tag = get_queried_object();

		$templates = array();

		if ( ! empty( $tag->slug ) ) {

			$slug_decoded = urldecode( $tag->slug );
			if ( $slug_decoded !== $tag->slug ) {
				$templates[] = "fse-compatible-classic-template/tag-{$slug_decoded}.php";
			}

			$templates[] = "fse-compatible-classic-template/tag-{$tag->slug}.php";
			$templates[] = "fse-compatible-classic-template/tag-{$tag->term_id}.php";
		}
		$templates[] = 'fse-compatible-classic-template/tag.php';

		return get_query_template( 'tag', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_author_template' ) ) {

	function emulsion_get_author_template() {

		$author = get_queried_object();

		$templates = array();

		if ( $author instanceof WP_User ) {
			$templates[] = "fse-compatible-classic-template/author-{$author->user_nicename}.php";
			$templates[] = "fse-compatible-classic-template/author-{$author->ID}.php";
		}
		$templates[] = 'fse-compatible-classic-template/author.php';

		return get_query_template( 'author', $templates );
	}

}

function emulsion_get_search_template() {
	$templates = array( 'fse-compatible-classic-template/search.php' );
	return get_query_template( 'search', $templates );
}

function emulsion_get_single_template() {

	$object = get_queried_object();

	$templates = array();

	if ( ! empty( $object->post_type ) ) {
		$template = get_page_template_slug( $object );
		if ( $template && 0 === validate_file( $template ) ) {
			$templates[] = "fse-compatible-classic-template/{$template}";
		}

		$name_decoded = urldecode( $object->post_name );
		if ( $name_decoded !== $object->post_name ) {
			$templates[] = "fse-compatible-classic-template/single-{$object->post_type}-{$name_decoded}.php";
		}

		$templates[] = "fse-compatible-classic-template/single-{$object->post_type}-{$object->post_name}.php";
		$templates[] = "fse-compatible-classic-template/single-{$object->post_type}.php";
	}

	$templates[] = 'fse-compatible-classic-template/single.php';

	return get_query_template( 'single', $templates );
}

function emulsion_get_page_template() {
	$id			 = get_queried_object_id();
	$template	 = get_page_template_slug();
	$pagename	 = get_query_var( 'pagename' );

	if ( ! $pagename && $id ) {
		// If a static page is set as the front page, $pagename will not be set.
		// Retrieve it from the queried object.
		$post = get_queried_object();
		if ( $post ) {
			$pagename = $post->post_name;
		}
	}

	$templates = array();
	if ( $template && 0 === validate_file( $template ) ) {
		$templates[] = $template;
	}
	if ( $pagename ) {
		$pagename_decoded = urldecode( $pagename );
		if ( $pagename_decoded !== $pagename ) {
			$templates[] = "fse-compatible-classic-template/page-{$pagename_decoded}.php";
		}
		$templates[] = "fse-compatible-classic-template/page-{$pagename}.php";
	}
	if ( $id ) {
		$templates[] = "fse-compatible-classic-template/page-{$id}.php";
	}
	$templates[] = 'fse-compatible-classic-template/page.php';

	return get_query_template( 'page', $templates );
}

function emulsion_get_home_template() {
	$templates = array( 'fse-compatible-classic-template/home.php' );

	return get_query_template( 'home', $templates );
}

function emulsion_get_front_page_template() {

	$templates = array( 'fse-compatible-classic-template/front-page.php' );

	return get_query_template( 'frontpage', $templates );
}

function emulsion_get_privacy_policy_template() {

	$templates = array( 'fse-compatible-classic-template/privacy-policy.php' );

	return get_query_template( 'privacypolicy', $templates );
}

function emulsion_get_404_template() {
	$templates = array( 'fse-compatible-classic-template/404.php' );
	return get_query_template( '404', $template );
}

function emulsion_get_archive_template() {
	$post_types = array_filter( (array) get_query_var( 'post_type' ) );

	$templates = array();

	if ( count( $post_types ) == 1 ) {
		$post_type	 = reset( $post_types );
		$templates[] = "fse-compatible-classic-template/archive-{$post_type}.php";
	}
	$templates[] = 'fse-compatible-classic-template/archive.php';

	return get_query_template( 'archive', $templates );
}

function emulsion_get_post_type_archive_template() {
	$post_type = get_query_var( 'post_type' );
	if ( is_array( $post_type ) ) {
		$post_type = reset( $post_type );
	}

	$obj = get_post_type_object( $post_type );
	if ( ! ( $obj instanceof WP_Post_Type ) || ! $obj->has_archive ) {
		return '';
	}

	return emulsion_get_archive_template();
}

function emulsion_get_taxonomy_template() {
	$term = get_queried_object();

	$templates = array();

	if ( ! empty( $term->slug ) ) {
		$taxonomy = $term->taxonomy;

		$slug_decoded = urldecode( $term->slug );
		if ( $slug_decoded !== $term->slug ) {
			$templates[] = "fse-compatible-classic-template/taxonomy-$taxonomy-{$slug_decoded}.php";
		}

		$templates[] = "fse-compatible-classic-template/taxonomy-$taxonomy-{$term->slug}.php";
		$templates[] = "fse-compatible-classic-template/taxonomy-$taxonomy.php";
	}
	$templates[] = 'fse-compatible-classic-template/taxonomy.php';

	return get_query_template( 'taxonomy', $templates );
}

function emulsion_get_embed_template() {
	$object = get_queried_object();

	$templates = array();

	if ( ! empty( $object->post_type ) ) {
		$post_format = get_post_format( $object );
		if ( $post_format ) {
			$templates[] = "fse-compatible-classic-template/embed-{$object->post_type}-{$post_format}.php";
		}
		$templates[] = "fse-compatible-classic-template/embed-{$object->post_type}.php";
	}

	$templates[] = 'fse-compatible-classic-template/embed.php';

	return get_query_template( 'embed', $templates );
}

function emulsion_get_attachment_template() {
	$attachment = get_queried_object();

	$templates = array();

	if ( $attachment ) {
		if ( false !== strpos( $attachment->post_mime_type, '/' ) ) {
			list( $type, $subtype ) = explode( '/', $attachment->post_mime_type );
		} else {
			list( $type, $subtype ) = array( $attachment->post_mime_type, '' );
		}

		if ( ! empty( $subtype ) ) {
			$templates[] = "fse-compatible-classic-template/{$type}-{$subtype}.php";
			$templates[] = "fse-compatible-classic-template/{$subtype}.php";
		}
		$templates[] = "fse-compatible-classic-template/{$type}.php";
	}
	$templates[] = 'fse-compatible-classic-template/attachment.php';

	return get_query_template( 'attachment', $templates );
}
