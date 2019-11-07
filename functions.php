<?php

/**
 * Theme emulsion
 * Settings and functions
 */

include_once( get_theme_file_path( 'lib/varidate.php' ) );
include_once( get_theme_file_path( 'lib/theme-supports-functions.php' ) );
include_once( get_theme_file_path( 'lib/theme-supports.php' ) );
include_once( get_theme_file_path( 'lib/color-functions.php' ) );
include_once( get_theme_file_path( 'lib/conf.php' ) );
include_once( get_theme_file_path( 'lib/hooks.php' ) );
include_once( get_theme_file_path( 'lib/snippets.php' ) );
include_once( get_theme_file_path( 'lib/template-tags.php' ) );
include_once( get_theme_file_path( 'lib/color.php' ) );
include_once( get_theme_file_path( 'lib/plugin-helper.php' ) );
include_once( get_theme_file_path( 'lib/navigation-pagination.php' ) );
include_once( get_theme_file_path( 'lib/keyword-highlight.php' ) );
include_once( get_theme_file_path( 'lib/relate-posts.php' ) );
include_once( get_theme_file_path( 'lib/customize.php' ) );
include_once( get_theme_file_path( 'lib/icon.php' ) );
include_once( get_theme_file_path( 'lib/metabox.php' ) );

if ( is_admin() && current_user_can( 'edit_theme_options' ) ) {

	/**
	 * Theme option page
	 */
	include_once( get_theme_file_path( 'documents/documents.php' ) );

	/**
	 * TGMPA
	 */
	if ( emulsion_get_supports( 'TGMPA' ) ) {
		include_once( get_theme_file_path( 'lib/tgm-config.php', 'path' ) );
		include_once( get_template_directory() . '/lib/class-tgm-plugin-activation.php' );
		! class_exists( 'WP_List_Table' ) ? require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' ) : '';
		require_once ( get_template_directory() . '/lib/class-tgm-plugin-activation.php' );
	}
}

/**
 * Theme Supports
 */
add_action( 'after_setup_theme', 'emulsion_setup' );

if ( ! function_exists( 'emulsion_setup' ) ) {

	function emulsion_setup() {

		do_action( 'emulsion_setup_pre' );

		load_theme_textdomain( 'emulsion', get_template_directory() . '/languages' );

		emulsion_customizer_add_supports_layout();
		emulsion_customizer_add_supports_footer();

		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );

		$emulsion_logo_defaults = emulsion_get_supports( 'custom-logo' )[0]['default'];

		if ( $emulsion_logo_defaults ) {

			add_theme_support( 'custom-logo', $emulsion_logo_defaults );
		}

		$emulsion_custom_background_defaults = emulsion_get_supports( 'background' )[0]['default'];

		if ( $emulsion_custom_background_defaults ) {

			add_theme_support( 'custom-background', $emulsion_custom_background_defaults );
		}

		add_theme_support( 'editor-font-sizes', array(
			array(
				'name'		 => esc_html__( 'extra small', 'emulsion' ),
				'shortName'	 => esc_html__( 'XS', 'emulsion' ),
				'size'		 => 10,
				'slug'		 => sanitize_title( 'extra-small' )
			),
			array(
				'name'		 => esc_html__( 'small', 'emulsion' ),
				'shortName'	 => esc_html__( 'S', 'emulsion' ),
				'size'		 => 13,
				'slug'		 => sanitize_title( 'small' )
			),
			array(
				'name'		 => esc_html__( 'regular', 'emulsion' ),
				'shortName'	 => esc_html__( 'M', 'emulsion' ),
				'size'		 => 16,
				'slug'		 => sanitize_title( 'regular' )
			),
			array(
				'name'		 => esc_html__( 'large', 'emulsion' ),
				'shortName'	 => esc_html__( 'L', 'emulsion' ),
				'size'		 => 24,
				'slug'		 => sanitize_title( 'large' )
			),
			array(
				'name'		 => esc_html__( 'extra large', 'emulsion' ),
				'shortName'	 => esc_html__( 'XL', 'emulsion' ),
				'size'		 => 32,
				'slug'		 => sanitize_title( 'extra-large' )
			),
		) );

		$emulsion_favorite_color_palette = get_theme_mod( 'emulsion_favorite_color_palette', emulsion_get_var( 'emulsion_favorite_color_palette' ) );

		add_theme_support(
				'editor-color-palette', array(
			array(
				'name'	 => esc_html__( 'Black', 'emulsion' ),
				'slug'	 => sanitize_title( 'black' ),
				'color'	 => '#333333',
			),
			array(
				'name'	 => esc_html__( 'Gray', 'emulsion' ),
				'slug'	 => sanitize_title( 'gray' ),
				'color'	 => '#727477',
			),
			array(
				'name'	 => esc_html__( 'White', 'emulsion' ),
				'slug'	 => sanitize_title( 'white' ),
				'color'	 => '#ffffff',
			),
			array(
				'name'	 => esc_html__( 'Alert', 'emulsion' ),
				'slug'	 => sanitize_title( 'alert' ),
				'color'	 => 'rgba(231, 76, 60,.4)',
			),
			array(
				'name'	 => esc_html__( 'Notice', 'emulsion' ),
				'slug'	 => sanitize_title( 'notice' ),
				'color'	 => 'rgba(163, 140, 8,.4)',
			),
			array(
				'name'	 => esc_html__( 'Info', 'emulsion' ),
				'slug'	 => sanitize_title( 'info' ),
				'color'	 => 'rgba(22, 160, 133,.4)',
			),
			array(
				'name'	 => esc_html__( 'Cool', 'emulsion' ),
				'slug'	 => sanitize_title( 'cool' ),
				'color'	 => 'rgba(52, 152, 219,.4)',
			),
			array(
				'name'	 => esc_html__( 'My Color', 'emulsion' ),
				'slug'	 => sanitize_title( 'my-color' ),
				'color'	 => $emulsion_favorite_color_palette,
			),
		) );

		/**
		 * Nav menu
		 */
		register_nav_menus( array(
			'primary'	 => esc_html__( 'Primary Menu', 'emulsion' ),
			'header'	 => esc_html__( 'Header Menu', 'emulsion' ),
				)
		);

		/**
		 * register scss variables for wp-scss plugin
		 */
		if ( function_exists( 'wp_scss_compile' ) ) {

			add_filter( 'wp_scss_variables', 'emulsion_wp_scss_set_variables' );
		}

		/**
		 * Gutenberg
		 *
		 */
		if ( is_page() && false == emulsion_metabox_display_control( 'page_style' ) ) {

			add_theme_support( 'wp-block-styles' );
		}
		if ( is_single() && false == emulsion_metabox_display_control( 'style' ) ) {

			add_theme_support( 'wp-block-styles' );
		}
		if ( ! emulsion_get_supports( 'enqueue' ) ) {

			add_theme_support( 'wp-block-styles' );
		}
		if ( 'enable' == get_theme_mod( 'emulsion_alignfull', emulsion_get_var( 'emulsion_alignfull' ) ) ) {

			add_theme_support( 'align-wide' );
		}

		add_action( 'enqueue_block_editor_assets', 'emulsion_block_editor_styles' ); //back end
		add_editor_style( 'css/tinymce-style.css' );
		add_editor_style( add_query_arg( 'action', 'emulsion_tiny_mce_css_variables', admin_url( 'admin-ajax.php' ) ) );

		/**
		 * Default Image Size
		 */
		update_option( 'image_default_align', 'center' );
		update_option( 'image_default_size', 'medium_large' );
		set_user_setting( 'align', 'center' );
		set_user_setting( 'imgsize', 'medium_large' );

		/**
		 * Reset Theme mods
		 * set default
		 */
		$reset_val = get_theme_mod( 'emulsion_reset_theme_settings' );

		if ( 'reset' == $reset_val ) {
			emulsion_reset_customizer_settings();
		}
		
		/**
		 * woocommerce
		 */
		add_theme_support( 'woocommerce', array(
			'thumbnail_image_width'	 => 150,
			'single_image_width'	 => 300,
			'product_grid' => array(
				'default_rows'		 => 3,
				'min_rows'			 => 2,
				'max_rows'			 => 8,
				'default_columns'	 => 4,
				'min_columns'		 => 2,
				'max_columns'		 => 5,
			),
		) );
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10); 
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

		/**
		 * Custom Header media
		 */
		$emulsion_custom_header_defaults = emulsion_get_supports( 'header' )[0]['default'];

		if ( function_exists( 'has_header_video' ) && $emulsion_custom_header_defaults ) {

			$emulsion_custom_header_defaults['video'] = true;

			add_filter( 'header_video_settings', 'emulsion_video_controls' );
		}
		add_theme_support( 'custom-header', apply_filters( 'emulsion_custom_header_defaults', $emulsion_custom_header_defaults ) );

		$emulsion_description_for_translation = esc_html__( 'block editor, classic editor both supports. Conventional, Image Media New Block Type Image Both media can be displayed correctly. Theme can stop at each theme style page for page builder users. Customizer can easily view changes with automatic preview redirection.Theme is designed with the goal of minimizing user frustration.', 'emulsion' );

		do_action( 'emulsion_setup_after' );
	}
}

/**
 * Style and Scripts
 */
add_action( 'wp_enqueue_scripts', 'emulsion_add_stylesheet' );

function emulsion_add_stylesheet() {
	global $wp_scripts;

	/**
	 * jQuery in Footer when user not logged in.
	 */
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

	$emulsion_current_data_version = null;

	if ( is_user_logged_in() ) {

		$emulsion_current_data_version = emulsion_theme_info( 'Version', false );
	}

	wp_register_style( 'emulsion', get_theme_file_uri( 'style.css' ), array(), $emulsion_current_data_version, 'all' );
	wp_enqueue_style( 'emulsion' );

	$inline_style_pre = apply_filters( 'emulsion_inline_style_pre', '@charset "UTF-8";' );

	/**
	 * style and script version query only when logged in.
	 * In an environment where you do not log in, it will be cached successfully.
	 */
	if ( is_page() && false == emulsion_metabox_display_control( 'page_style' ) ) {

		wp_add_inline_style( 'emulsion', $inline_style_pre );

		return;
	}
	if ( is_single() && false == emulsion_metabox_display_control( 'style' ) ) {

		wp_add_inline_style( 'emulsion', $inline_style_pre );
		return;
	}
	if ( ! emulsion_get_supports( 'enqueue' ) ) {

		return;
	}

	$http_user_agent		 = filter_input( INPUT_ENV, 'HTTP_USER_AGENT' );
	$emulsion_get_browser	 = preg_match( '!Trident/.*rv:([0-9]{1,}\.[\.0-9]{0,})!', $http_user_agent, $regs ) ? sanitize_html_class( 'ie' . (int) $regs[1] ) : '';
	$emulsion_get_browser	 = preg_match( "|(MSIE )([0-9]{1,2})(\.)|si", $http_user_agent, $regs ) ? sanitize_html_class( 'ie' . $regs[2] ) : $emulsion_get_browser;

	if ( 'ie11' == $emulsion_get_browser ) {

		wp_register_style( 'emulsion-backward-compatible', get_template_directory_uri() . '/css/backward-compatible.css', array(), $emulsion_current_data_version, 'all' );
		wp_enqueue_style( 'emulsion-backward-compatible' );

		/**
		 * if child theme has parent name.js( js/emulsion.js ) Read the file of the child theme ( for replace script )
		 */
		wp_register_script( 'emulsion-backward-compatible-js', get_theme_file_uri( 'js/backward-compatible.js' ), array( 'jquery', 'jquery-migrate' ), $emulsion_current_data_version, true );
		wp_enqueue_script( 'emulsion-backward-compatible-js' );

		return;
	}

	if ( is_user_logged_in() || is_admin() ) {
		/**
		 * If user is not logged in, load as inline style
		 * @see emulsion_plugins_style_change_inline()
		 */
		wp_register_style( 'emulsion-completion', get_template_directory_uri() . '/css/common.css', array(), $emulsion_current_data_version, 'all' );
		wp_enqueue_style( 'emulsion-completion' );
	}

	/**
	 * Google fonts
	 */
	$emulsion_common_google_font_url = esc_url( get_theme_mod( 'emulsion_common_google_font_url', emulsion_get_var( 'emulsion_common_google_font_url' ) ) );

	if ( ! empty( $emulsion_common_google_font_url ) ) {

		wp_register_style( 'emulsion-common-google-font', $emulsion_common_google_font_url, array( 'emulsion' ), null, 'all' );
		wp_enqueue_style( 'emulsion-common-google-font' );
	}

	$emulsion_heading_google_font_url = esc_url( get_theme_mod( 'emulsion_heading_google_font_url', emulsion_get_var( 'emulsion_heading_google_font_url' ) ) );

	if ( ! empty( $emulsion_heading_google_font_url ) ) {

		wp_register_style( 'emulsion-heading-google-font', $emulsion_heading_google_font_url, array( 'emulsion' ), null, 'all' );
		wp_enqueue_style( 'emulsion-heading-google-font' );
	}
	$emulsion_widget_meta_google_font_url = esc_url( get_theme_mod( 'emulsion_widget_meta_google_font_url', emulsion_get_var( 'emulsion_widget_meta_google_font_url' ) ) );

	if ( ! empty( $emulsion_widget_meta_google_font_url ) ) {

		wp_register_style( 'emulsion-widget-meta-google-font', $emulsion_widget_meta_google_font_url, array( 'emulsion' ), null, 'all' );
		wp_enqueue_style( 'emulsion-widget-meta-google-font' );
	}
	if ( ! empty( $inline_style_pre ) ) {

		$inline_style = apply_filters( 'emulsion_inline_style', $inline_style_pre );
	} else {

		$inline_style = apply_filters( 'emulsion_inline_style', '' );
	}

	$inline_style = emulsion_remove_spaces_from_css( $inline_style );
	wp_add_inline_style( 'emulsion', $inline_style );

	/**
	 * Child Theme
	 */
	if ( is_child_theme() ) {

		$emulsion_child_theme_slug = emulsion_theme_info( 'Slug', false );

		/**
		 * Child theme style
		 */
		wp_register_style( $emulsion_child_theme_slug, get_stylesheet_directory_uri() . '/style.css', array(), $emulsion_current_data_version, 'all' );
		wp_enqueue_style( $emulsion_child_theme_slug );

		$inline_style	 = apply_filters( $emulsion_child_theme_slug . '_inline_style', "/* emulsion " . $emulsion_current_data_version . "*/" );
		$inline_style	 = emulsion_remove_spaces_from_css( $inline_style );

		wp_add_inline_style( $emulsion_child_theme_slug, $inline_style );

		/**
		 * Child theme style
		 */
		if ( file_exists( get_stylesheet_directory() . '/js/' . $emulsion_child_theme_slug . '.js' ) ) {
			/**
			 * if child theme has parent name.js( js/child-theme-slug.js ) add the file of the child theme ( for add script )
			 */
			wp_register_script( $emulsion_child_theme_slug . '-js', get_stylesheet_directory_uri() . '/js/' . $emulsion_child_theme_slug . '.js', array( 'jquery', 'jquery-migrate' ), $emulsion_current_data_version, true );

			wp_enqueue_script( $emulsion_child_theme_slug . '-js' );

			$inline_script = apply_filters( $emulsion_child_theme_slug . '_inline_script', "" );
			wp_add_inline_script( $emulsion_child_theme_slug . '-js', $inline_script );
		}
	}

	/**
	 * if child theme has parent name.js( js/emulsion.js ) Read the file of the child theme ( for replace script )
	 */
	if ( true == WP_DEBUG ) {

		wp_register_script( 'emulsion-js', get_theme_file_uri( 'js/emulsion.js' ), array( 'jquery', 'jquery-migrate' ), $emulsion_current_data_version, true );
	} else {

		wp_register_script( 'emulsion-js', get_theme_file_uri( 'js/emulsion.min.js' ), array( 'jquery', 'jquery-migrate' ), $emulsion_current_data_version, true );
	}
	wp_enqueue_script( 'emulsion-js' );

	$inline_script = apply_filters( 'emulsion_inline_script', "" );
	wp_add_inline_script( 'emulsion-js', $inline_script );

	/**
	 * Lazyload
	 */
	$support = emulsion_get_supports( 'lazyload' );

	if ( $support ) {

		wp_register_script( 'emulsion-lazyload-js', get_theme_file_uri( 'js/lazyload.min.js' ), array( 'jquery', 'jquery-migrate' ), $emulsion_current_data_version, true );
		wp_enqueue_script( 'emulsion-lazyload-js' );
		$inline_script = apply_filters( 'emulsion_lazyload_script', "" );
		wp_add_inline_script( 'emulsion-lazyload-js', $inline_script );
	}

	/**
	 * Instantclick
	 */
	$support = emulsion_get_supports( 'instantclick' );

	if ( $support && 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_admin() ) {

		wp_register_script( 'emulsion-instantclick-js', get_theme_file_uri( 'js/instantclick.js' ), array( 'emulsion-js' ), $emulsion_current_data_version, true );
		wp_enqueue_script( 'emulsion-instantclick-js' );

		$inline_script = apply_filters( 'emulsion_instantclick_script', "" );
		wp_add_inline_script( 'emulsion-instantclick-js', $inline_script );
	}

	/**
	 * Table of contents
	 */
	$support = emulsion_get_supports( 'toc' );

	if ( $support ) {

		wp_register_script( 'emulsion-toc-js', get_theme_file_uri( 'js/toc.js' ), array( 'emulsion-js' ), $emulsion_current_data_version, true );
		wp_enqueue_script( 'emulsion-toc-js' );

		$inline_script = apply_filters( 'emulsion_toc_script', "" );
		wp_add_inline_script( 'emulsion-toc-js', $inline_script );
	}

	if ( is_singular() ) {

		wp_enqueue_script( "comment-reply" );
	}

	/**
	 * Tooltip
	 */
	$support = emulsion_get_supports( 'tooltip' );

	if ( $support && ! is_customize_preview() ) {

		wp_enqueue_script( 'jquery-ui-tooltip' );
		$js = "jQuery(function() {
							jQuery( document ).tooltip({position: {
								my: 'center', at: 'top-30', collision: 'none'
							}});
							jQuery('.primary-menu-wrapper').tooltip({position:{
								my: 'center', at: 'bottom+30', collision: 'none'
							}});
							jQuery('.primary-menu-wrapper').tooltip('option', 'tooltipClass','bottom-tooltip' );

						});";

		wp_add_inline_script( 'jquery-ui-tooltip', $js );
	}

	/**
	 * Localize Script
	 */
	$wp_scss_status_relate_setting	 = 'deactive' == get_theme_mod( 'emulsion_wp_scss_status' ) ? emulsion_get_css_variables_values( 'sidebar_position' ) : '';
	$emulsion_background_color		 = emulsion_get_background_color();

	wp_localize_script( 'emulsion-js', 'emulsion_script_vars', array(
		'locale'					 => get_locale(),
		'end_point'					 => esc_url( rest_url() ),
		'allowed_query'				 => array( 'posts', 'page', 'categories', 'tag' ),
		'rest_query'				 => 'wp/v2/posts?page=',
		'permalink'					 => esc_url( get_permalink() ),
		'home_url'					 => home_url(),
		'i18n_blank_entry_title'	 => esc_html__( 'No Title', 'emulsion' ),
		'sidebar_bg_dark'			 => emulsion_accent_color( '', 5, 5, 20, 15 ),
		'sidebar_bg_light'			 => emulsion_accent_color( '', 5, 5, 20, 90 ),
		'sidebar_position'			 => $wp_scss_status_relate_setting, // left right none
		'sidebar_width'				 => get_theme_mod( 'emulsion_sidebar_width', emulsion_get_var( 'emulsion_sidebar_width' ) ),
		'block_sectionize'			 => emulsion_get_supports( 'block_sectionize' ),
		'header_bg_color'			 => get_theme_mod( 'emulsion_header_background_color', emulsion_get_var( 'emulsion_header_background_color' ) ),
		'sticky_sidebar'			 => get_theme_mod( 'emulsion_sticky_sidebar', emulsion_get_var( 'emulsion_sticky_sidebar' ) ),
		'align_offset'				 => emulsion_get_css_variables_values( 'align_offset' ),
		'content_width'				 => get_theme_mod( 'emulsion_content_width', emulsion_get_var( 'emulsion_content_width' ) ),
		'content_gap'				 => absint( emulsion_get_css_variables_values( 'content_gap' ) ),
		'background_color'			 => emulsion_the_hex2rgb( $emulsion_background_color ),
		'force_contrast'			 => true,
		'block_columns_class'		 => emulsion_sectionized_class( 'columns' ),
		'block_media_text_class'	 => emulsion_sectionized_class( 'media_text' ),
		'block_gallery_class'		 => emulsion_sectionized_class( 'gallery' ),
		'meta_description'			 => emulsion_meta_description(),
		'is_customize_preview'		 => is_customize_preview() ? 'is_preview' : '',
		'post_id'					 => get_the_Id(),
		'header_default_text_color'	 => get_theme_support( 'custom-header', 'default-text-color' ),
		'prefers_color_scheme'       => false,
	) );
}

if ( ! function_exists( 'emulsion_body_class' ) ) {

	function emulsion_body_class( $classes ) {
		global $_wp_theme_features;

		$metabox_flag = false;

		if ( is_page() && false == emulsion_metabox_display_control( 'page_style' ) ) {

			$classes[]		 = 'metabox-removed-emulsion-presentation';
			$metabox_flag	 = true;
			return $classes;
		}
		if ( is_single() && false == emulsion_metabox_display_control( 'style' ) ) {

			$classes[]		 = 'metabox-removed-emulsion-presentation';
			$metabox_flag	 = true;
			return $classes;
		}
		if ( ! emulsion_get_supports( 'enqueue' ) ) {

			$classes[]		 = 'removed-emulsion-presentation';
			$metabox_flag	 = true;
			return $classes;
		}

		$classes[] = 'noscript';

		if ( is_singular() ) {

			$post_id = get_the_ID();

			if ( 'no_bg' == get_post_meta( $post_id, 'emulsion_page_theme_style_script', true ) ) {

				$classes[] = 'metabox-reset-page-presentation';
			}

			if ( 'no_bg' == get_post_meta( $post_id, 'emulsion_post_theme_style_script', true ) ) {

				$classes[] = 'metabox-reset-post-presentation';
			}

			if ( 'no_menu' == get_post_meta( $post_id, 'emulsion_post_primary_menu', true ) ) {

				$classes[] = 'metabox-removed-post-menu';
			}
			if ( 'no_menu' == get_post_meta( $post_id, 'emulsion_page_primary_menu', true ) ) {

				$classes[] = 'metabox-removed-page-menu';
			}

			$classes[] = 'is-singular';
		} else {
			
			switch( false ) {
				case is_404():
					$classes[] = 'is-loop';
				break;			
			}
		}

		if ( is_page() ) {

			unset( $classes['emulsion-no-sidebar'] );
			unset( $classes['emulsion-has-sidebar'] );

			$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_page_sidebar', emulsion_get_var( 'emulsion_condition_display_page_sidebar' ) );
			$logged_in				 = 'logged_in_user' == $sidebar_condition && ! is_user_logged_in() ? false : true;
			$metabox_page_control	 = emulsion_metabox_display_control( 'page_sidebar' );

			if ( is_active_sidebar( 'sidebar-3' ) && emulsion_get_supports( 'sidebar_page' ) && $logged_in && $metabox_page_control ) {

				$classes[] = 'emulsion-has-sidebar';
			} else {

				$classes[] = 'emulsion-no-sidebar';
			}
		} else {

			unset( $classes['emulsion-no-sidebar'] );
			unset( $classes['emulsion-has-sidebar'] );

			$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_posts_sidebar', emulsion_get_var( 'emulsion_condition_display_posts_sidebar' ) );
			$logged_in				 = 'logged_in_user' == $sidebar_condition && ! is_user_logged_in() ? false : true;
			$metabox_post_control	 = emulsion_metabox_display_control( 'sidebar' );

			if ( is_active_sidebar( 'sidebar-1' ) && emulsion_get_supports( 'sidebar' ) && $logged_in && $metabox_post_control ) {

				$classes[] = 'emulsion-has-sidebar';
			} else {

				$classes[] = 'emulsion-no-sidebar';
			}
		}

		/**
		 * full width image
		 */
		if ( true == emulsion_get_supports( 'alignfull' ) ) {

			$classes[] = 'enable-alignfull';
		} else {

			$classes[] = 'disable-alignfull';
		}

		/**
		 * Custom background image
		 */
		$page_bg_image_url = get_background_image();

		if ( ! empty( $page_bg_image_url ) ) {

			$classes[] = 'emulsion-has-custom-background-image';
		}

		/**
		 * Current Page layout type
		 */
		if ( is_customize_preview() ) {

			$layout_type = emulsion_customizer_have_posts_class_helper();
			//$layout_type = emulsion_content_type();
			$classes[]	 = 'layout-' . sanitize_html_class( $layout_type );
		} else {

			$layout_type = emulsion_current_layout_type();
			$classes[]	 = 'layout-' . sanitize_html_class( $layout_type );
		}
		/**
		 * Content type
		 */
		$content_type		 = emulsion_content_type();
		$classes[]			 = sanitize_html_class( $content_type );
		/**
		 * Font family class
		 */
		$heading_font_family = get_theme_mod( 'emulsion_heading_font_family', emulsion_get_var( 'emulsion_heading_font_family' ) );
		$classes[]			 = sanitize_html_class( 'font-heading-' . $heading_font_family );

		$common_font_family	 = emulsion_get_css_variables_values( 'common_font_family' );
		$classes[]			 = sanitize_html_class( 'font-common-' . $common_font_family );

		/**
		 * Category Colors
		 */
		if ( 'enable' == get_theme_mod( 'emulsion_category_colors', emulsion_get_var( 'emulsion_category_colors' ) ) ) {

			$classes[] = 'has-category-colors';
		} else {

			$classes[] = 'disable-category-colors';
		}
		if ( emulsion_get_supports( 'background_css_pattern' ) ) {

			$background_css_pattern_class = get_theme_mod( 'emulsion_background_css_pattern', emulsion_get_var( 'emulsion_background_css_pattern' ) );

			if ( 'none' !== $background_css_pattern_class ) {
				$class_name	 = 'background-css-pattern-' . $background_css_pattern_class;
				$classes[]	 = $class_name;
			}
		}

		return $classes;
	}

}
if ( ! function_exists( 'emulsion_sectionized_class' ) ) {
	/**
	 * wp-block-gallery, wp-block-columns, wp-block-media-text
	 * Customizer You can set the background color from the post settings. 
	 * Add a class that determines the tendency of this background color 
	 */

	function emulsion_sectionized_class( $block = '' ) {

		if ( 'columns' == $block ) {
			$background_default	 = emulsion_get_background_color();
			$background			 = get_theme_mod( 'emulsion_block_columns_section_bg', $background_default );

			if ( $background_default == $background ) {
				return 'is-default';
			}
			if ( ! empty( $background ) ) {

				$text_color = emulsion_contrast_color( $background );

				if ( '#ffffff' == $text_color ) {

					$emulsion_brightnes = 'is-dark';
				}
				if ( '#333333' == $text_color ) {

					$emulsion_brightnes = 'is-light';
				}

				return $emulsion_brightnes;
			}
		}
		if ( 'media_text' == $block ) {

			$background_default	 = emulsion_get_background_color();
			$background			 = get_theme_mod( 'emulsion_block_media_text_section_bg', $background_default );

			if ( $background_default == $background ) {
				return 'is-default';
			}
			if ( ! empty( $background ) ) {

				$text_color = emulsion_contrast_color( $background );

				if ( '#ffffff' == $text_color ) {

					$emulsion_brightnes = 'is-dark';
				}
				if ( '#333333' == $text_color ) {

					$emulsion_brightnes = 'is-light';
				}

				return $emulsion_brightnes;
			}
		}
		if ( 'gallery' == $block ) {

			$background_default	 = emulsion_get_background_color();
			$background			 = get_theme_mod( 'emulsion_block_gallery_section_bg', $background_default );

			if ( $background_default == $background ) {
				return 'is-default';
			}
			if ( ! empty( $background ) ) {

				$text_color = emulsion_contrast_color( $background );

				if ( '#ffffff' == $text_color ) {

					$emulsion_brightnes = 'is-dark';
				}
				if ( '#333333' == $text_color ) {

					$emulsion_brightnes = 'is-light';
				}

				return $emulsion_brightnes;
			}
		}
		return false;
	}

}

if ( ! function_exists( 'emulsion_remove_spaces_from_css' ) ) {

	/**
	 * Remove spaces from stylesheet
	 */
	function emulsion_remove_spaces_from_css( $css = '' ) {

		if ( ! is_user_logged_in() ) {

			$css = str_replace( array( "\n", "\r", "\t", '&quot;', '\"' ), array( "", "", "", '"', '"' ), $css );
		} else {

			$css = str_replace( array( '&quot;', '\"' ), array( '"', '"' ), $css );
		}

		return $css;
	}

}

if ( ! function_exists( 'emulsion_oembed_object_wrapper' ) ) {
	
	/**
	 * Not Block editor embed media wrapper
	 */

	function emulsion_oembed_object_wrapper( $html, $url, $type = '' ) {

		/**
		 * Reason not to divert Gutenberg's class
		 * Because the structure of html is different
		 */
		$element					 = 'div';
		$not_exists_gutenberg_class	 = 'wp-block-embed__wrapper';
		if ( empty( $type ) ) {

			$not_exists_gutenberg_class	 .= ' ';
			$not_exists_gutenberg_class	 .= sanitize_html_class( $type );
		}
		$repair_style = '';

		/**
		 * https://www.instagram.com/
		 */
		if ( preg_match( '!(instagram.com)!', $url ) ) {
			return sprintf( '<div class="emulsion-instagram clearfix">%1$s</div>', $html );
		}

		/**
		 * https://www.reverbnation.com/
		 */
		if ( preg_match( '!(reverbnation.com)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-reverbnation clearfix"><div>%1$s</div></%2$s>', $html, $element );
		}

		/*
		 * https://speakerd.s3.amazonaws.com/presentations/50021f75cf1db900020005e7/slide_0.jpg?1362165300
		 */

		if ( preg_match( '!(speakerdeck.com|speakerd)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-ratio-075 emulsion-speakerdeck clearfix"><div>%1$s</div></%2$s>', $html, $element );
		}

		/*
		 * https://www.slideshare.net/slideshow/embed_code/7306301
		 */

		if ( preg_match( '!(slideshare.net)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-slideshare clearfix %3$s" %4$s><div>%1$s</div></%2$s>', $html, $element, $not_exists_gutenberg_class, $repair_style );
		}

		/*
		 * https://www.mixcloud.com/
		 */

		if ( preg_match( '!(mixcloud.com)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-mixcloud clearfix %3$s" %4$s><div>%1$s</div></%2$s>', $html, $element, $not_exists_gutenberg_class, $repair_style );
		}

		/**
		 * https://www.reddit.com/
		 */
		if ( preg_match( '!(reddit.com)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-reddit clearfix"><div>%1$s</div></%2$s>', $html, $element );
		}

		/**
		 * https://www.screencast.com/
		 * @since 1.480
		 */
		if ( preg_match( '!(screencast.com)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-screencast clearfix"><div>%1$s</div></%2$s>', $html, $element );
		}

		/**
		 * note: 4:3 ratio can use .emulsion-ratio-075
		 */
		if ( ! preg_match( '!(twitter.com|tumblr.com|speakerdeck)!', $url ) && ! preg_match( '!(wp-embedded-content)!', $html ) ) {
			return sprintf( '<%2$s class="clearfix %3$s" %4$s>%1$s</%2$s>', $html, $element, $not_exists_gutenberg_class, $repair_style );

		}

		return $html;
	}

}

if ( ! function_exists( 'emulsion_theme_info' ) ) {
	
	/**
	 * Get theme infomation.
	 */

	function emulsion_theme_info( $info, $echo = true ) {

		$emulsion_current_data = wp_get_theme();

		if ( strcasecmp( $info, 'ThemeURI' ) == 0 ) {

			$emulsion_current_data_theme_uri = apply_filters( 'emulsion_theme_url', $emulsion_current_data->get( 'ThemeURI' ) );

			if ( $echo == true ) {

				echo esc_url( $emulsion_current_data_theme_uri );
			} else {

				return esc_url( $emulsion_current_data_theme_uri );
			}
		}
		if ( strcasecmp( $info, 'AuthorURI' ) == 0 ) {

			$emulsion_current_data_author_uri = apply_filters( 'emulsion_author_url', $emulsion_current_data->get( 'AuthorURI' ) );

			if ( $echo == true ) {
				echo esc_url( $emulsion_current_data_author_uri );
			} else {
				return esc_url( $emulsion_current_data_author_uri );
			}
		}
		if ( strcasecmp( $info, 'Version' ) == 0 ) {

			$emulsion_current_data_version = $emulsion_current_data->get( 'Version' );

			if ( is_child_theme() ) {

				/**
				 * If you are using child theme, version queries may remain unchanged
				 * when parent themes are updated, sometimes cached
				 */
				$emulsion_this_parent_theme		 = wp_get_theme( get_template() );
				$emulsion_current_data_version	 = $emulsion_this_parent_theme->get( 'Version' ) .
						'-' . $emulsion_current_data_version;
			}

			if ( $echo == true ) {

				echo esc_html( $emulsion_current_data_version );
			} else {

				return $emulsion_current_data_version;
			}
		}
		if ( strcasecmp( $info, 'Name' ) == 0 ) {

			$emulsion_current_theme_name = $emulsion_current_data->get( 'Name' );

			if ( $echo == true ) {
				echo esc_html( $emulsion_current_theme_name );
			} else {
				return $emulsion_current_theme_name;
			}
		}
		if ( strcasecmp( $info, 'Slug' ) == 0 ) {

			$emulsion_current_theme_name = $emulsion_current_data->get( 'Name' );
			$emulsion_current_theme_slug = str_replace( ' ', '-', $emulsion_current_theme_name );
			$emulsion_current_theme_slug = mb_strtolower( $emulsion_current_theme_slug );
			$emulsion_current_theme_slug = sanitize_html_class( $emulsion_current_theme_slug );

			if ( $echo == true ) {
				echo esc_html( $emulsion_current_theme_slug );
			} else {
				return $emulsion_current_theme_slug;
			}
		}
		if ( strcasecmp( $info, 'TextDomain' ) == 0 ) {

			$emulsion_text_domain	 = $emulsion_current_data->get( 'TextDomain' );
			$result					 = $emulsion_text_domain;
			if ( $echo == true ) {
				echo esc_html( $emulsion_text_domain );
			} else {
				return $emulsion_text_domain;
			}
		}

		if ( is_child_theme() ) {

			$emulsion_parent_data = wp_get_theme( get_template() );

			if ( strcasecmp( $info, 'parentName' ) == 0 ) {

				$emulsion_parent_theme_name = $emulsion_parent_data->get( 'Name' );

				if ( $echo == true ) {
					echo esc_html( $emulsion_parent_theme_name );
				} else {
					return $emulsion_parent_theme_name;
				}
			}
			if ( strcasecmp( $info, 'parentSlug' ) == 0 ) {

				$emulsion_parent_theme_name	 = $emulsion_parent_data->get( 'Name' );
				$emulsion_parent_theme_name	 = str_replace( ' ', '-', $emulsion_parent_theme_name );
				$emulsion_parent_theme_name	 = mb_strtolower( $emulsion_parent_theme_name );
				$emulsion_parent_theme_name	 = sanitize_html_class( $emulsion_parent_theme_name );

				if ( $echo == true ) {
					echo esc_html( $emulsion_parent_theme_name );
				} else {
					return $emulsion_parent_theme_name;
				}
			}
		}

		return false;
	}

}

if ( ! function_exists( 'emulsion_class_name_sanitize' ) ) {

	/**
	 * Normally use sanitize_html_class.
	 * 
	 * Useful for multi-classes such as space delimiters and class arrays.
	 * 
	 */
	function emulsion_class_name_sanitize( $class = '' ) {

		$class_name	 = '';
		$result		 = '';

		if ( is_string( $class ) && mb_stristr( $class, ' ' ) === false ) {

			return sanitize_html_class( $class );
		} elseif ( is_string( $class ) ) {

			$extend_class	 = mb_convert_kana( $class, 's' );
			$extend_classes	 = explode( ' ', $extend_class );

			foreach ( $extend_classes as $class_name ) {

				$result .= ' ' . sanitize_html_class( $class_name );
			}
			return trim( $result );
		}

		if ( is_array( $class ) ) {

			foreach ( $class as $class_name ) {

				$result .= ' ' . sanitize_html_class( $class_name );
			}
			return trim( $result );
		}

		return;
	}
}

if ( ! function_exists( 'emulsion_layout_controller' ) ) {

	/**
	 * Add html element for grid display and stream display.
	 * Using the filter, you can return the page displayed in grid format to normal display.
	 * @param type $position
	 * @param type $type
	 * @return type
	 */
	function emulsion_layout_controller( $position = 'before', $type = '' ) {

		/**
		 * Filter Example
		 *
		 * All archive pages are displayed in list format
		 * add_filter('emulsion_layout_controller','__return_false');
		 * change stream to grid
		 * add_filter('emulsion_layout_controller', function($html){ return is'grid'; } );
		 */
		if ( is_single() ) {
			return;
		}
		$type	 = apply_filters( 'emulsion_layout_controller', $type );
		$type	 = sanitize_html_class( $type );

		if ( post_type_exists( $type ) && 'post' !== $type && 'page' !== $type ) {

			$type .= ' custom-post-type';
		}

		$position = $position == ('before' || 'after') ? $position : '';

		if ( ! empty( $type ) && ! empty( $position ) ) {

			if ( 'before' == $position ) {

				$result = '<div class="' . $type . '">';
			}

			if ( 'after' == $position ) {

				$result = '</div>';
			}

			// check lost element
			$emulsion_place = basename( __FILE__ ) . ' line:' . __LINE__ . ' ' . __FUNCTION__ . '()';
			true === WP_DEBUG ? emulsion_elements_assert_equal( $result, wp_kses_post( $result ), $emulsion_place ) : '';

			echo wp_kses_post( $result );
		}
	}

}

if ( ! function_exists( 'emulsion_search_drawer' ) ) {

	/**
	 * Add Search Page if enable
	 */
	function emulsion_search_drawer() {

		if ( emulsion_get_supports( 'search_drawer' ) ) {

			get_template_part( 'template-parts/search', 'drawer' );
		}
	}

}
if ( ! function_exists( 'emulsion_block_editor_styles' ) ) {

	/**
	 * Gutenberg stylesheet for backend editor
	 */
	function emulsion_block_editor_styles() {

		$emulsion_current_data_version = emulsion_theme_info( 'Version', false );

		if ( WP_DEBUG ) {
			$emulsion_current_data_version = time();
		}
		if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
			wp_enqueue_style(
					'emulsion-block-editor-styles', get_theme_file_uri( '/css/style-editor.css' ), array(), $emulsion_current_data_version, 'all'
			);

			$wp_scss_status = get_theme_mod( 'emulsion_wp_scss_status' );

			if ( 'active' !== $wp_scss_status ) {

				$dinamic_css = emulsion__css_variables();

				wp_add_inline_style( 'emulsion-block-editor-styles', $dinamic_css );
			}
		}
	}

}

if ( ! function_exists( 'emulsion_svg_icon' ) ) {

	function emulsion_svg_icon( $args = array() ) {

		$result		 = '';
		$unique_id	 = uniqid();

		if ( ! is_array( $args ) ) {

			return false;
		}

		$defaults = array(
			'icon'		 => 'default',
			'title'		 => '',
			'desc'		 => '',
			'fallback'	 => false,
			'echo'		 => false,
			'width'		 => emulsion_get_var( 'emulsion_common_font_size' ),
			'height'	 => emulsion_get_var( 'emulsion_common_font_size' ),
		);

		$args = wp_parse_args( $args, $defaults );

		$start_element		 = '<svg class="emulsion-icon icon-%1$s" %2$s>';
		$title_element		 = '<title id="title-%1$s">%2$s</title>';
		$desc_element		 = '<desc id="desc-%1$s">%2$s</desc>';
		$use_element		 = '<use href="#%1$s" xlink:href="#%1$s"></use>';
		$fallback_element	 = '';
		$close_element		 = '</svg>';
		$svg_attribute		 = 'role="img"';
		$svg_attribute		 .= ' width="' . $args['width'] . '"';
		$svg_attribute		 .= ' height="' . $args['width'] . '"';

		if ( ! empty( $args['title'] ) && ! empty( $args['desc'] ) ) {

			$svg_attribute = 'role="presentation"';
			$svg_attribute .= ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
		} elseif ( ! empty( $args['title'] ) && empty( $args['desc'] ) ) {

			$svg_attribute .= ' aria-labelledby="title-' . $unique_id . '"';
		} elseif ( empty( $args['title'] ) && ! empty( $args['desc'] ) ) {

			$svg_attribute .= ' aria-labelledby="desc-' . $unique_id . '"';
		} else {

			$svg_attribute .= ' aria-hidden="true"';
		}

		$result .= sprintf( $start_element, esc_attr( $args['icon'] ), $svg_attribute );

		if ( ! empty( $args['title'] ) ) {

			$result .= sprintf( $title_element, $unique_id, esc_html( $args['title'] ) );
		}
		if ( ! empty( $args['desc'] ) ) {

			$result .= sprintf( $desc_element, $unique_id, esc_html( $args['desc'] ) );
		}

		$result .= sprintf( $use_element, esc_html( $args['icon'] ) );

		if ( ! empty( $args['fallback'] ) ) {

			$result .= $args['fallback'];
		}

		$result .= $close_element;

		// check lost element
		$emulsion_place = basename( __FILE__ ) . ' line:' . __LINE__ . ' ' . __FUNCTION__ . '()';
		true === WP_DEBUG ? emulsion_elements_assert_equal( $result, wp_kses( $result, EMULSION_ICON_SVG_SYMBOLS_ALLOWED_ELEMENTS ), $emulsion_place ) : '';

		if ( true == $args['fallback'] ) {

			echo wp_kses( $result, EMULSION_ICON_SVG_SYMBOLS_ALLOWED_ELEMENTS );
		}
		if ( false == $args['fallback'] ) {

			return wp_kses( $result, EMULSION_ICON_SVG_SYMBOLS_ALLOWED_ELEMENTS );
		}
	}

}
if ( ! function_exists( 'emulsion_template_identification_class' ) ) {
	/**
	 * the class name associated with the included template
	 *
	 * @global type $template
	 * @param type $file
	 * @param type $echo
	 * @return boolean
	 */
	function emulsion_template_identification_class( $file = '', $echo = true ) {

		global $template;

		if ( empty( $file ) ) {

			return false;
		}

		if ( $template == $file ) {

			$current_template	 = basename( $template, '.php' );
			$current_template	 = sprintf( 'template-%1$s', $current_template );
		} else {

			$current_template	 = basename( $file, '.php' );
			$current_template	 = sprintf( 'template-part-%1$s', $current_template );
		}

		if ( $echo ) {

			echo ' ' . sanitize_html_class( $current_template );
		} else {

			return ' ' . sanitize_html_class( $current_template );
		}
	}

}
if ( ! function_exists( 'emulsion_video_controls' ) ) {

	/**
	 * header video control button
	 * @param type $settings
	 * @return string
	 */
	function emulsion_video_controls( $settings ) {

		$settings['l10n']['play']	 = '<span class="screen-reader-text">' . __( 'Play header video', 'emulsion' ) . '</span>' . emulsion_svg_icon( array( 'icon' => 'play' ) );
		$settings['l10n']['pause']	 = '<span class="screen-reader-text">' . __( 'Pause header video', 'emulsion' ) . '</span>' . emulsion_svg_icon( array( 'icon' => 'pause' ) );

		return $settings;
	}

}
if ( ! function_exists( 'emulsion_request_url' ) ) {

	/**
	 * Returns the requested URL.
	 *
	 * @global type $wp
	 * @return type
	 */
	function emulsion_request_url() {
		global $wp;
		return home_url( $wp->request );
	}

}
if ( ! function_exists( 'emulsion_link_url_text_decode' ) ) {

	/**
	 * Decode URL-encoded link text
	 *
	 * @param type $matches
	 * @return type
	 */
	function emulsion_link_url_text_decode( $matches ) {

		if ( isset( $matches[1] ) && preg_match( '!%[0-9A-Z][0-9A-Z]+!', $matches[1] ) ) {

			$replace = urldecode( $matches[1] );
			$replace = esc_html( $replace );

			return preg_replace( "|>" . $matches[1] . "</a>|", ">{$replace}</a>", $matches[0] );
		}
		return $matches[0];
	}

}

if ( ! function_exists( 'emulsion_remove_url_from_text' ) ) {

	/**
	 * Remove the URL string from the text
	 * @param type $plain_text
	 * @return type
	 */
	function emulsion_remove_url_from_text( $plain_text = '' ) {

		return preg_replace( "/(https?:\/\/)([-_.!*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/iu", '', $plain_text );
	}

}
if ( ! function_exists( 'emulsion_get_footer_cols' ) ) {

	/**
	 * Get number of columns in footer widget area
	 * @return boolean
	 */
	function emulsion_get_footer_cols() {

		$footer_col = emulsion_get_supports( 'footer' );

		if ( is_array( $footer_col ) ) {

			foreach ( $footer_col[0] as $key => $value ) {
				if ( 'cols' == $key ) {
					return $value;
				}
			}
		}
		return false;
	}

}
if ( ! function_exists( 'emulsion_get_footer_cols_css' ) ) {

	/**
	 * Get number of columns in footer widget area in% width
	 * @return number
	 * unit % is added CSS calc()
	 */
	function emulsion_get_footer_cols_css() {

		$cols = emulsion_get_footer_cols();

		$cols_percent = 100 / $cols;

		$cols_percent = floor( $cols_percent ) - 3;

		return $cols_percent;
	}

}
if ( ! function_exists( 'emulsion_strip_tags_content' ) ) {

	/**
	 * html Deletes a specific element from the text.
	 * About difference with strip_tags () function
	 * strip_tags () can $allowable_tags can be set,but $disallowable_tags cannot be set.
	 * This function enables $disallowable_tags.
	 * @param type $text
	 * @param type $tags
	 * @param type $invert
	 * @return text
	 */
	function emulsion_strip_tags_content( $text, $tags = '', $invert = FALSE ) {

		preg_match_all( '/<(.+?)[\s]*\/?[\s]*>/si', trim( $tags ), $tags );
		$tags = array_unique( $tags[1] );

		if ( is_array( $tags ) AND count( $tags ) > 0 ) {
			if ( $invert == FALSE ) {
				return preg_replace( '@<(?!(?:' . implode( '|', $tags ) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text );
			} else {
				return preg_replace( '@<(' . implode( '|', $tags ) . ')\b.*?>.*?</\1>@si', '', $text );
			}
		} elseif ( $invert == FALSE ) {
			return preg_replace( '@<(\w+)\b.*?>.*?</\1>@si', '', $text );
		}
		return $text;
	}

}
if ( ! function_exists( 'emulsion_current_layout_type' ) ) {

	/**
	 * Determine whether the current page is a grid layout or a stream layout
	 * @return string
	 */
	function emulsion_current_layout_type() {

		$supports_stream = emulsion_get_supports( 'stream' );
		$supports_grid	 = emulsion_get_supports( 'grid' );
		$stream			 = emulsion_has_archive_format( $supports_stream );
		$grid			 = emulsion_has_archive_format( $supports_grid );

		if ( ! empty( $grid ) && empty( $stream ) ) {
			return 'grid';
		}
		if ( ! empty( $stream ) && empty( $grid ) ) {
			return 'stream';
		}
		if ( empty( $stream ) && empty( $grid ) ) {
			return 'list';
		}
	}

}
if ( ! function_exists( 'emulsion_reset_customizer_settings' ) ) {

	/**
	 * Reset customizer settings with Server Side
	 * @global type $emulsion_customize_args
	 */
	function emulsion_reset_customizer_settings() {
		global $emulsion_customize_args;

		$header_html			 = get_theme_mod( 'emulsion_header_html', emulsion_get_var( 'emulsion_header_html' ) );
		$footer_credit			 = get_theme_mod( 'emulsion_footer_credit', emulsion_get_var( 'emulsion_footer_credit' ) );
		$favorite_color_palette	 = get_theme_mod( 'emulsion_favorite_color_palette', emulsion_get_var( 'emulsion_favorite_color_palette' ) );

		/**
		 * layout grid steam is dinamicaly set emulsion_add_supports()
		 * need to add the default settings separately.
		 */
		$emulsion_layout_homepage			 = emulsion_get_var( 'emulsion_layout_homepage', 'default' );
		$emulsion_layout_posts_page			 = emulsion_get_var( 'emulsion_layout_posts_page', 'default' );
		$emulsion_layout_date_archives		 = emulsion_get_var( 'emulsion_layout_date_archives', 'default' );
		$emulsion_layout_category_archives	 = emulsion_get_var( 'emulsion_layout_category_archives', 'default' );
		$emulsion_layout_tag_archives		 = emulsion_get_var( 'emulsion_layout_tag_archives', 'default' );
		$emulsion_layout_author_archives	 = emulsion_get_var( 'emulsion_layout_author_archives', 'default' );

		foreach ( $emulsion_customize_args as $name => $val ) {

			remove_theme_mod( $name );
		}

		remove_theme_mod( 'background_color' );
		remove_theme_mod( 'header_textcolor' );

		/**
		 * keep user setting
		 */
		set_theme_mod( 'emulsion_favorite_color_palette', $favorite_color_palette );
		set_theme_mod( 'emulsion_footer_credit', $footer_credit );
		set_theme_mod( 'emulsion_header_html', $header_html );
		set_theme_mod( 'emulsion_reset_theme_settings', 'continue' );

		/**
		 * needs default setting
		 */
		set_theme_mod( 'emulsion_layout_homepage', $emulsion_layout_homepage );
		set_theme_mod( 'emulsion_layout_posts_page', $emulsion_layout_posts_page );
		set_theme_mod( 'emulsion_layout_date_archives', $emulsion_layout_date_archives );
		set_theme_mod( 'emulsion_layout_category_archives', $emulsion_layout_category_archives );
		set_theme_mod( 'emulsion_layout_tag_archives', $emulsion_layout_tag_archives );
		set_theme_mod( 'emulsion_layout_author_archives', $emulsion_layout_author_archives );
	}

}

if ( ! function_exists( 'emulsion_header_layout' ) ) {

	/**
	 * Get the type of the header.element
	 * @return type
	 */
	function emulsion_header_layout() {

		return wp_kses( get_theme_mod( 'emulsion_header_layout', 'custom' ), array() );
	}

}
if ( ! function_exists( 'emulsion_sanitize_css' ) ) {
	
	/**
	 * CSS sanitize
	 */
	function emulsion_sanitize_css( $css ) {

		/**
		 *
		 * Please add filter style sanitize code. if need
		 *
		 */
		return wp_strip_all_tags( $css );
	}

}
if ( ! function_exists( 'emulsion_get_google_font_family_from_url' ) ) {

	/**
	 * Parsing the google fonts URL and getting the font name
	 * @param type $url
	 * @param type $fallback
	 * @return type
	 */
	function emulsion_get_google_font_family_from_url( $url = '',
			$fallback = 'sans-serif' ) {

		$query = parse_url( $url, PHP_URL_QUERY );

		if ( is_null( $query ) ) {
			return;
		}

		$query	 = htmlspecialchars_decode( $query );
		$result	 = '';

		parse_str( $query, $param );

		if ( false !== strstr( $param['family'], '|' ) ) {

			$fonts = explode( '|', $param['family'] );

			foreach ( $fonts as $font ) {

				if ( false !== $position = strpos( $font, ':' ) ) {

					$result .= ' "' . substr( $font, 0, $position ) . '",';
				} else {
					$result .= ' "' . $font . '",';
				}
			}
		} else {

			if ( false !== $position = strpos( $param['family'], ':' ) ) {

				$result .= ' "' . substr( $param['family'], 0, $position ) . '",';
			} else {
				$result .= ' "' . $param['family'] . '",';
			}
		}
		$result = str_replace( '+', ' ', $result );
		$result = addslashes( $result . $fallback );

		return trim( $result, ',' );
	}
}

if ( ! function_exists( 'emulsion_elements_assert_equal' ) ) {

	/**
	 * In debug mode, the theme compares HTML before sanitization and after sanitization, and if there are deleted elements, logs them to debug.log
	 *
	 */
	function emulsion_elements_assert_equal( $value_raw = '', $value_validate = '',
			$message = '' ) {
		global $template, $post;

		$emulsion_template	 = ! empty( $template ) ? basename( $template ) : 'not found';
		$add_info			 = '';

		if ( is_singular() ) {
			if ( empty( $post ) ) {

				$add_info = 'post_id: not exists';
			} else {

				$add_info = 'post_id: ' . absint( $post->ID );
			}
		}
		if ( is_archive() ) {

			$paged		 = absint( get_query_var( 'paged', 1 ) );
			$add_info	 = 'archive: ' . esc_html( wp_strip_all_tags( get_the_archive_title(), true ) ) . ' page:' . $paged;
		}

		if ( is_404() ) {

			$add_info = 'post_id: http 404 not found';
		}

		if ( true === WP_DEBUG && 0 !== strcmp( trim( $value_raw ), trim( $value_validate ) ) ) {

			$message	 = sprintf( '[ Emulsion custom info ] The output html may be limited. %1$s %2$s template: %3$s', $message, $add_info, $emulsion_template );
			$log		 = sprintf( '[ %1$s ]%2$s' . PHP_EOL, date_i18n( 'Y-m-d H:i:s' ), $message );
			$save_file	 = WP_CONTENT_DIR . '/debug.log';

			if ( file_exists( $save_file ) ) {
				error_log( $log, 3, $save_file );
			}
		}
	}

}

if ( ! function_exists( 'emulsion_write_log' ) ) {
	
	/**
	 * Add logs at debug time if necessary
	 * @param type $log
	 */

	function emulsion_write_log( $log ) {
		if ( true === WP_DEBUG ) {

			$save_file = WP_CONTENT_DIR . '/debug.log';

			if ( is_array( $log ) || is_object( $log ) ) {

				error_log( print_r( $log, 3, $save_file ) ) . "\n";
			} else {

				error_log( $log, 3, $save_file ) . "\n";
			}
		}
	}

}

if ( ! function_exists( 'emulsion_php_version_notice' ) ) {
	
	/**
	 * PHP version notice when theme activate
	 */
	function emulsion_php_version_notice() {

		printf( '<div class="%1$s"><p>%2$s<br />%3$s</p></div>', 
				'notice notice-error is_dismissable', 
				esc_html__( 'You need to update your PHP version to run this theme.', 'emulsion' ), 
				sprintf(
						/* translators: 1: PHP_VERSION 2: EMULSION_MIN_PHP_VERSION */
						esc_html__( 'Actual version is: %1$s, required version is: %2$s', 'emulsion' ), esc_html( PHP_VERSION ), esc_html( EMULSION_MIN_PHP_VERSION )
				)
		);
	}

}

if ( ! function_exists( 'emulsion_tiny_mce_before_init' ) ) {
	
	/**
	 * tinymce settings
	 * remove cache , add body class
	 */

	function emulsion_tiny_mce_before_init( $mce_init ) {

		if ( current_user_can( 'edit_theme_options' ) ) {

			$mce_init['cache_suffix'] = 'v=' . time();
		}

		if ( empty( $mce_init['body_class'] ) ) {

			$mce_init['body_class'] = 'entry-content';
		} else {

			$mce_init['body_class'] = ' entry-content';
		}

		return $mce_init;
	}

}

if ( ! function_exists( 'emulsion_content_type' ) ) {
	
	/**
	 * return page is full text or excerpt
	 * grid, stream return false
	 */
	function emulsion_content_type() {
		global $post;

		if ( is_singular() ) {

			return 'full_text';
		} else {

			switch ( true ) {
				case emulsion_is_posts_page():

					$setting_value = get_theme_mod( 'emulsion_layout_posts_page', emulsion_get_var( 'emulsion_layout_posts_page' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_home():

					$setting_value = get_theme_mod( 'emulsion_layout_homepage', emulsion_get_var( 'emulsion_layout_homepage' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_date():

					$setting_value = get_theme_mod( 'emulsion_layout_date_archives', emulsion_get_var( 'emulsion_layout_date_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_category():

					$setting_value = get_theme_mod( 'emulsion_layout_category_archives', emulsion_get_var( 'emulsion_layout_category_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_tag():

					$setting_value = get_theme_mod( 'emulsion_layout_tag_archives', emulsion_get_var( 'emulsion_layout_tag_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_author():

					$setting_value = get_theme_mod( 'emulsion_layout_author_archives', emulsion_get_var( 'emulsion_layout_author_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_search():

					$setting_value = get_theme_mod( 'emulsion_layout_search_results', emulsion_get_var( 'emulsion_layout_search_results' ) );

					$setting_value = str_replace( 'highlight', 'excerpt', $setting_value );
					return $setting_value;
					break;
			}

			return false;
		}
	}

}
if ( ! function_exists( 'emulsion_is_display_featured_image_in_the_loop' ) ) {
	
	/**
	 * Show post image in each loop pages ( archive ...)
	 * @return boolean
	 */

	function emulsion_is_display_featured_image_in_the_loop() {

		if ( is_home() ) {
			return get_theme_mod( 'emulsion_layout_homepage_post_image', emulsion_get_var( 'emulsion_layout_homepage_post_image' ) ) == 'show';
		}
		if ( emulsion_is_posts_page() ) {
			return get_theme_mod( 'emulsion_layout_posts_page_post_image', emulsion_get_var( 'emulsion_layout_posts_page_post_image' ) ) == 'show';
		}
		if ( is_date() ) {
			return get_theme_mod( 'emulsion_layout_date_archives_post_image', emulsion_get_var( 'emulsion_layout_date_archives_post_image' ) ) == 'show';
		}
		if ( is_category() ) {
			return get_theme_mod( 'emulsion_layout_category_archives_post_image', emulsion_get_var( 'emulsion_layout_category_archives_post_image' ) ) == 'show';
		}
		if ( is_tag() ) {
			return get_theme_mod( 'emulsion_layout_tag_archives_post_image', emulsion_get_var( 'emulsion_layout_tag_archives_post_image' ) ) == 'show';
		}
		if ( is_author() ) {
			return get_theme_mod( 'emulsion_layout_author_archives_post_image', emulsion_get_var( 'emulsion_layout_author_archives_post_image' ) ) == 'show';
		}
		if ( is_search() ) {
			return get_theme_mod( 'emulsion_layout_search_results_post_image', emulsion_get_var( 'emulsion_layout_search_results_post_image' ) ) == 'show';
		}
		return true;
	}

}

if ( ! function_exists( 'emulsion_customizer_is_changed' ) ) {
	
	/**
	 * if customizer saved emulsion_customizer_is_changed value change 'no' to 'yes'
	 * @see emulsion_get_css_variables_values()
	 */

	function emulsion_customizer_is_changed() {

		set_theme_mod( 'emulsion_customizer_is_changed', 'yes' );
	}
}


function emulsion_add_woocommerce_shortcode_class_to_post( $classes ) {
	global $post;
	
	$shortcodes = array( 'product', 'products', 'product_attribute', 
						'product_category', 'product_categories', 'recent_products',
						'featured_products', 'sale_products', 'best_selling_products', 
						'top_rated_products' );
	
	foreach( $shortcodes as $tag ){	
		if( has_shortcode( $post->post_content, $tag ) ) {
			$classes[] = 'has-wc-shotcode';
			break;
		}	
	}
	return $classes;
}

do_action( 'emulsion_functions_after' );