<?php

include_once( get_theme_file_path( 'lib/conf.php' ) );
include_once( get_theme_file_path( 'lib/hooks.php' ) );
include_once( get_theme_file_path( 'lib/template-tags.php' ) );
include_once( get_theme_file_path( 'lib/navigation-pagination.php' ) );
include_once( get_theme_file_path( 'lib/relate-posts.php' ) );
include_once( get_theme_file_path( 'lib/icon.php' ) );

if ( is_admin() && current_user_can( 'edit_theme_options' ) ) {
	
	/**
	 * TGMPA
	 */
	if (  emulsion_the_theme_supports( 'TGMPA' ) ) {
		include_once( get_theme_file_path( 'lib/tgm-config.php' ) );		
		include_once( get_template_directory() . '/lib/class-tgm-plugin-activation.php' );
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
	/**
	 * TGMPA
	 */		
		add_action( 'tgmpa_register', 'emulsion_theme_register_required_plugins' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );

		if ( emulsion_the_theme_supports( 'custom-logo' ) ) {
				
			add_theme_support( 'custom-logo', array(
					'height'		 => 60,
					'width'			 => 600,
					'flex-height'	 => true,
					'flex-width'	 => true,
					'header-text'	 => array( 'site-title', 'site-description' ),
			) );
		}
		
		/**
		 * Block editor font sizes
		 */		
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

		/**
		 * editor-color-palette
		 *
		 * Note: Do not remove Black and White color settings
		 *
		 * The color of the color palette is the same color scheme applied to the background and text
		 * Without white and black color settings, it may not be possible to ensure sufficient contrast.
		 */
		
		$emulsion_favorite_color_palette		 = get_theme_mod( 'emulsion_favorite_color_palette', false );
		$emulsion_favorite_color_palette_default = emulsion_theme_default_val( 'emulsion_favorite_color_palette' );

		if ( $emulsion_favorite_color_palette !== $emulsion_favorite_color_palette_default ) {

			$emulsion_favorite_color_name = esc_html__( 'My Color', 'emulsion' );
		} else {

			$emulsion_favorite_color_name = esc_html__( 'Silver', 'emulsion' );
		}

		add_theme_support(
				'editor-color-palette', array(
			array(
				'name'	 => esc_html__( 'Black', 'emulsion' ),
				'slug'	 => 'black',
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
				'name'	 => $emulsion_favorite_color_name,
				'slug'	 => sanitize_title_with_dashes( $emulsion_favorite_color_name ),
				'color'	 => $emulsion_favorite_color_palette,
			),
		) );
			
		/**
		 * Block editor alignwide
		 */
		if (  'enable' == get_theme_mod( 'emulsion_alignfull', emulsion_theme_default_val( 'emulsion_alignfull' ) ) ) {

			add_theme_support( 'align-wide' );
		}

		add_action( 'enqueue_block_editor_assets', 'emulsion_block_editor_styles' ); //back end
		add_editor_style( 'css/tinymce-style.css' );
		add_editor_style( add_query_arg( 'action', 'emulsion_tiny_mce_css_variables', admin_url( 'admin-ajax.php' ) ) );
		
		/**
		 * Nav menu
		 */
		register_nav_menus( array(
			'primary'	 => esc_html__( 'Primary Menu', 'emulsion' ),
			'header'	 => esc_html__( 'Header Menu', 'emulsion' ),
				)
		);
		
		add_action( 'widgets_init', 'emulsion_widgets_init');
		
		/**
		 * woocommerce
		 */
		add_theme_support( 'woocommerce', array(
			'thumbnail_image_width'	 => 150,
			'single_image_width'	 => 300,
			'product_grid'			 => array(
				'default_rows'		 => 3,
				'min_rows'			 => 2,
				'max_rows'			 => 8,
				'default_columns'	 => 4,
				'min_columns'		 => 2,
				'max_columns'		 => 5,
			),
		) );

		/**
		 * default woocommece sidebar and breadcrumb hide
		 */
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		/**
		 * Customizer relate dinamic style
		 */
		add_filter( 'emulsion_inline_style', 'emulsion_woocommerce_dinamic_css' );

		function emulsion_woocommerce_dinamic_css( $css ) {

			if ( emulsion_the_theme_supports( 'title_in_page_header' ) ) {
				$css .= '#document .woocommerce-page .content-area .woocommerce-products-header{ display:none;}';
			}

			return $css;
		}

		/**
		 * Custom Header media
		 */
		$emulsion_custom_header_defaults = get_theme_support( 'custom-header' );
		
		if ( function_exists( 'has_header_video' ) && $emulsion_custom_header_defaults ) {

			$emulsion_custom_header_defaults['video'] = true;

			add_filter( 'header_video_settings', 'emulsion_video_controls' );
		}
		
		add_theme_support( 'custom-header', apply_filters( 'emulsion_custom_header_defaults', $emulsion_custom_header_defaults ) );

		do_action( 'emulsion_setup_after' );
	}

}

/**
 * Widget
 */
if ( ! function_exists( 'emulsion_widgets_init' ) ) {

	function emulsion_widgets_init() {

		if ( emulsion_the_theme_supports( 'sidebar' ) ) {

			register_sidebar( array(
				'name'			 => esc_html__( 'Post Sidebar', 'emulsion' ),
				'id'			 => 'sidebar-1',
				'description'	 => is_customize_preview() ? esc_html__( 'You can set the sidebar widget for post by displaying the post in preview.', 'emulsion' ) : '',
				'before_widget'	 => '<li id="%1$s" class="%2$s widget sidebar post-sidebar" tabindex="-1">',
				'after_widget'	 => "</li>\n",
				'before_title'	 => "\n\t<h2 class=\"widgettitle default\">",
				'after_title'	 => "</h2>\n",
				'widget_id'		 => 'default',
				'widget_name'	 => 'default',
				'text'			 => "1" )
			);
		}
		if ( emulsion_the_theme_supports( 'footer' ) ) {

			register_sidebar( array(
				'name'			 => esc_html__( 'Post Footer', 'emulsion' ),
				'id'			 => 'sidebar-2',
				'description'	 => is_customize_preview() ? esc_html__( 'You can set the footer wigget for post by displaying the post in preview.', 'emulsion' ) : '',
				'before_widget'	 => '<li id="%1$s" class="%2$s widget footer post-footer" tabindex="-1">',
				'after_widget'	 => "</li>\n",
				'before_title'	 => "\n\t<h2 class=\"widgettitle post-footer\">",
				'after_title'	 => "</h2>\n",
				'widget_id'		 => 'extra',
				'widget_name'	 => 'extra',
				'text'			 => "2" )
			);
		}
		if ( emulsion_the_theme_supports( 'sidebar_page' ) ) {

			register_sidebar( array(
				'name'			 => esc_html__( 'Page Sidebar', 'emulsion' ),
				'id'			 => 'sidebar-3',
				'description'	 => is_customize_preview() ? esc_html__( 'You can set the page sidebar widget for page by displaying the page in preview.', 'emulsion' ) : '',
				'before_widget'	 => '<li id="%1$s" class="%2$s widget sidebar-page" tabindex="-1">',
				'after_widget'	 => "</li>\n",
				'before_title'	 => "\n\t<h2 class=\"widgettitle sidebar-page\">",
				'after_title'	 => "</h2>\n",
				'widget_id'		 => 'sidebar-page',
				'widget_name'	 => 'sidebar-page',
				'text'			 => "3" )
			);
		}
		if ( emulsion_the_theme_supports( 'footer_page' ) ) {

			register_sidebar( array(
				'name'			 => esc_html__( 'Page Footer', 'emulsion' ),
				'id'			 => 'sidebar-4',
				'description'	 => is_customize_preview() ? esc_html__( 'You can set the page footer widget for page by displaying the page in preview.', 'emulsion' ) : '',
				'before_widget'	 => '<li id="%1$s" class="%2$s widget footer page-footer" tabindex="-1">',
				'after_widget'	 => "</li>\n",
				'before_title'	 => "\n\t<h2 class=\"widgettitle page-footer\">",
				'after_title'	 => "</h2>\n",
				'widget_id'		 => 'footer-page',
				'widget_name'	 => 'footer-page',
				'text'			 => "4" )
			);
		}
	}

}

/**
 * Style and Scripts
 */
add_action( 'wp_enqueue_scripts', 'emulsion_register_scripts_and_styles' );

function emulsion_register_scripts_and_styles() {
	global $wp_scripts;

	/**
	 * jQuery in Footer when user not logged in.
	 */
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

	$emulsion_current_data_version = null;

	if ( is_user_logged_in() ) {

		$emulsion_current_data_version = emulsion_version();
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
	if ( ! emulsion_the_theme_supports( 'enqueue' ) ) {

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

	if ( is_user_logged_in() || is_admin() || ! emulsion_theme_addons_exists( ) ) {
		/**
		 * If user is not logged in, load as inline style
		 * @see emulsion_plugins_style_change_inline()
		 */
		wp_register_style( 'emulsion-completion', get_template_directory_uri() . '/css/common.css', array(), $emulsion_current_data_version, 'all' );
		wp_enqueue_style( 'emulsion-completion' );
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

		$emulsion_child_theme_slug =  emulsion_slug( );

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
	 * Comments
	 */
	if ( is_singular() ) {

		wp_enqueue_script( "comment-reply" );
	}
	/**
	 * Google fonts
	 */
	$emulsion_common_google_font_url = '';

	$emulsion_common_google_font_url = esc_url( get_theme_mod( 'emulsion_common_google_font_url', emulsion_theme_default_val( 'emulsion_common_google_font_url' ) ) );
	
	if ( ! empty( $emulsion_common_google_font_url ) ) {

		wp_register_style( 'emulsion-common-google-font', $emulsion_common_google_font_url, array( 'emulsion' ), null, 'all' );
		wp_enqueue_style( 'emulsion-common-google-font' );
	}

	$emulsion_heading_google_font_url = esc_url( get_theme_mod( 'emulsion_heading_google_font_url', emulsion_theme_default_val( 'emulsion_heading_google_font_url' ) ) );

	if ( ! empty( $emulsion_heading_google_font_url ) ) {

		wp_register_style( 'emulsion-heading-google-font', $emulsion_heading_google_font_url, array( 'emulsion' ), null, 'all' );
		wp_enqueue_style( 'emulsion-heading-google-font' );
	}

	$emulsion_widget_meta_google_font_url = esc_url( get_theme_mod( 'emulsion_widget_meta_google_font_url',emulsion_theme_default_val( 'emulsion_widget_meta_google_font_url' ) ) );

	if ( ! empty( $emulsion_widget_meta_google_font_url ) ) {

		wp_register_style( 'emulsion-widget-meta-google-font', $emulsion_widget_meta_google_font_url, array( 'emulsion' ), null, 'all' );
		wp_enqueue_style( 'emulsion-widget-meta-google-font' );
	}
	
	/**
	 * Lazyload
	 */
	$support = emulsion_the_theme_supports( 'lazyload' );

	if ( $support ) {

		wp_register_script( 'emulsion-lazyload-js', get_theme_file_uri( 'js/lazyload.min.js' ), array( 'jquery', 'jquery-migrate' ), $emulsion_current_data_version, true );
		wp_enqueue_script( 'emulsion-lazyload-js' );

		$inline_script = apply_filters( 'emulsion_lazyload_script', "" );
		wp_add_inline_script( 'emulsion-lazyload-js', $inline_script );
	}

	/**
	 * Instantclick
	 */
	$support = emulsion_the_theme_supports( 'instantclick' );

	if ( $support && 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_admin() ) {

		wp_register_script( 'emulsion-instantclick-js', get_theme_file_uri( 'js/instantclick.js' ), array( 'emulsion-js' ), $emulsion_current_data_version, true );
		wp_enqueue_script( 'emulsion-instantclick-js' );

		$inline_script = apply_filters( 'emulsion_instantclick_script', "" );
		wp_add_inline_script( 'emulsion-instantclick-js', $inline_script );
	}

	/**
	 * Table of contents
	 */
	$support = emulsion_the_theme_supports( 'toc' );

	if ( $support ) {

		wp_register_script( 'emulsion-toc-js', get_theme_file_uri( 'js/toc.js' ), array( 'emulsion-js' ), $emulsion_current_data_version, true );
		wp_enqueue_script( 'emulsion-toc-js' );

		$inline_script = apply_filters( 'emulsion_toc_script', "" );
		wp_add_inline_script( 'emulsion-toc-js', $inline_script );
	}


	/**
	 * Tooltip
	 */
	
	$support = emulsion_the_theme_supports( 'tooltip' );

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
	 * Localize Script
	 */
		
	$wp_scss_status_relate_setting	 = 'deactive' == get_theme_mod( 'emulsion_wp_scss_status' ) 
			? emulsion_get_css_variables_values( 'sidebar_position' ) 
			: emulsion_theme_default_val( 'emulsion_sidebar_position' );
	$emulsion_background_color		 = function_exists( 'emulsion_get_background_color' ) ? emulsion_get_background_color() : sprintf( '#%1$s', get_background_color() );

	wp_localize_script( 'emulsion-js', 'emulsion_script_vars', array(
		'locale'						 => sanitize_text_field( get_locale() ),
		'end_point'						 => esc_url( rest_url() ),
		'allowed_query'					 => array( 'posts', 'page', 'categories', 'tag' ),
		'rest_query'					 => 'wp/v2/posts?page=',
		'permalink'						 => esc_url( get_permalink() ),
		'home_url'						 => esc_url( home_url() ),
		'i18n_blank_entry_title'		 => esc_html__( 'No Title', 'emulsion' ),
		'sidebar_bg_dark'				 => function_exists('emulsion_accent_color') ? emulsion_accent_color( '', 5, 5, 20, 15 ) : $emulsion_background_color ,
		'sidebar_bg_light'				 => function_exists('emulsion_accent_color') ? emulsion_accent_color( '', 5, 5, 20, 90 ) : $emulsion_background_color ,
		'sidebar_position'				 => $wp_scss_status_relate_setting, // left right none
		'sidebar_width'					 => get_theme_mod( 'emulsion_sidebar_width', emulsion_theme_default_val( 'emulsion_sidebar_width' ) ),
		'block_sectionize'				 => emulsion_the_theme_supports( 'block_sectionize' ),
		'header_bg_color'				 => get_theme_mod( 'emulsion_header_background_color',  emulsion_theme_default_val( 'emulsion_header_background_color' ) ),
		'sticky_sidebar'				 => get_theme_mod( 'emulsion_sticky_sidebar', emulsion_theme_default_val( 'emulsion_sticky_sidebar' ) ),
		'align_offset'					 => function_exists('emulsion_get_css_variables_values') ? emulsion_get_css_variables_values( 'align_offset' ) : 200,
		'content_width'					 => get_theme_mod( 'emulsion_content_width', emulsion_theme_default_val( 'emulsion_content_width' ) ),
		'content_gap'					 => function_exists('emulsion_get_css_variables_values') ? absint( emulsion_get_css_variables_values( 'content_gap' ) ) : 24,
		'background_color'				 => function_exists('emulsion_the_hex2rgb') ? emulsion_the_hex2rgb( $emulsion_background_color ) : "rgb(255,255,255)",
		'force_contrast'				 => true,
		'block_columns_class'			 => function_exists('emulsion_sectionized_class') ? sanitize_html_class( emulsion_sectionized_class( 'columns' ) ): "is-default",
		'block_columns_class_title'		 => esc_html__( 'Columns block', 'emulsion' ),
		'block_media_text_class'		 => function_exists('emulsion_sectionized_class') ? sanitize_html_class( emulsion_sectionized_class( 'media_text' ) ): "is-default",
		'block_media_text_class_title'	 => esc_html__( 'Media text block', 'emulsion' ),
		'block_gallery_class'			 => function_exists('emulsion_sectionized_class') ? sanitize_html_class( emulsion_sectionized_class( 'gallery' ) ): "is-default",
		'block_gallery_class_title'		 => esc_html__( 'Gallery block', 'emulsion' ),
		'block_quote_class_title'		 => esc_html__( 'Quote block', 'emulsion' ),
		'meta_description'				 => emulsion_meta_description(),
		'is_customize_preview'			 => is_customize_preview() ? 'is_preview' : '',
		'post_id'						 => get_the_ID(),
		'header_default_text_color'		 => get_theme_support( 'custom-header', 'default-text-color' ),
		'prefers_color_scheme'			 => EMULSION_DARK_MODE_SUPPORT,
		'go_to_top_label'				 => esc_html__( 'Go to top', 'emulsion' ),
		'emulsion_accepted_svg_ids'		 => get_theme_mod( 'emulsion_accepted_svg_ids' ),
	) );
}

/**
 * Theme Body Class
 */
add_filter( 'body_class', 'emulsion_body_class' );

if ( ! function_exists( 'emulsion_body_class' ) ) {

	/**
	 * Theme body class
	 * @global type $_wp_theme_features
	 * @param type $classes
	 * @return array;
	 */
	function emulsion_body_class( $classes ) {

		if ( is_page() ) {

			unset( $classes['emulsion-no-sidebar'] );
			unset( $classes['emulsion-has-sidebar'] );

			$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_page_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_page_sidebar' ) );
			$logged_in				 = 'logged_in_user' == $sidebar_condition && ! is_user_logged_in() ? false : true;
			$metabox_page_control	 = emulsion_metabox_display_control( 'page_sidebar' );

			$classes[] = is_active_sidebar( 'sidebar-3' ) &&
					emulsion_the_theme_supports( 'sidebar_page' ) &&
					$logged_in &&
					$metabox_page_control ? 'emulsion-has-sidebar' : 'emulsion-no-sidebar';
		} else {

			unset( $classes['emulsion-no-sidebar'] );
			unset( $classes['emulsion-has-sidebar'] );

			$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_posts_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_posts_sidebar' ) );
			$logged_in				 = 'logged_in_user' == $sidebar_condition && ! is_user_logged_in() ? false : true;
			$metabox_post_control	 = emulsion_metabox_display_control( 'sidebar' );

			$classes[] = is_active_sidebar( 'sidebar-1' ) &&
					emulsion_the_theme_supports( 'sidebar' ) &&
					$logged_in &&
					$metabox_post_control ? 'emulsion-has-sidebar' : 'emulsion-no-sidebar';
		}
		return $classes;
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

if ( ! function_exists( 'emulsion_the_header_layer_class' ) ) {

	/**
	 * Header Classes
	 * The CSS class is added by judging whether the image or video is set in the Site header.
	 * @param type $class
	 */
	function emulsion_the_header_layer_class( $class = '' ) {
		
		$add_class = apply_filters( 'emulsion_the_header_layer_class', '' );

		echo emulsion_class_name_sanitize( $add_class . ' '. $class );
	}
}
if ( ! function_exists( 'emulsion_element_classes' ) ) {

/**
 * Adds a class according to the primary menu background color,sidebar background color specified in the customizer.
 * Return the class specified by location
 * @param type $location
 * @return string
 * 
 * @since 0.99 class name change from menu-has-column to menu-active
 */

	function emulsion_element_classes( $location = '' ) {

		if ( 'primary' == $location ) {

			$is_active_menu		 = emulsion_is_active_nav_menu( $location );
			$sidebar_position	 = get_theme_mod( 'emulsion_sidebar_position', emulsion_theme_default_val( 'emulsion_sidebar_position' ) );
			$menu_background	 = get_theme_mod( 'emulsion_primary_menu_background', emulsion_theme_default_val( 'emulsion_primary_menu_background' ) );
			$menu_text_color	 = function_exists( 'emulsion_contrast_color' ) ? emulsion_contrast_color( $menu_background ) : '#333333';
			$menu_color_class	 = '#333333' == $menu_text_color ? 'menu-is-light' : 'menu-is-dark';

			$class	 = 'primary-menu-wrapper';
			$class	 .= $is_active_menu ? ' menu-active' : ' menu-inactive';
			$class	 .= ' ' . sanitize_html_class( 'side-' . $sidebar_position );
			$class	 .= ' ' . $menu_color_class;

			return ' '. emulsion_class_name_sanitize( $class );
		}

		if ( 'sidebar-widget-area' == $location || 'footer-widget-area' == $location ) {

			$background			 = get_theme_mod( 'emulsion_sidebar_background', emulsion_theme_default_val( 'emulsion_sidebar_background' ) );
			$text_color			 = function_exists( 'emulsion_contrast_color' ) ? emulsion_contrast_color( $menu_background ) : '#333333';
			$text_color_class	 = '#333333' == $text_color ? 'sidebar-is-light' : 'sidebar-is-dark';
			$footer_cols_class	 = '';

			if( get_theme_mod( 'emulsion_sidebar_background', false ) == emulsion_theme_default_val( 'emulsion_sidebar_background' ) ||
				false === get_theme_mod( 'emulsion_sidebar_background', false ) ) {
				
				$text_color_class = 'sidebar-is-default';
			}

			if ( 'footer-widget-area' == $location ) {

				$footer_cols_class = get_theme_mod( 'emulsion_footer_columns', emulsion_theme_default_val( 'emulsion_footer_columns' ) );	
				$footer_cols_class = 'footer-cols-'. absint( $footer_cols_class );
			}

			return ' ' . emulsion_class_name_sanitize( $text_color_class . ' '. $footer_cols_class );
		}
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

if ( ! function_exists( 'emulsion_remove_spaces_from_css' ) ) {

	/**
	 * Remove spaces from stylesheet
	 * When user logged in, output readable CSS, usually minified CSS
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

function emulsion_version( $echo = false ) {

	$emulsion_current_data			 = wp_get_theme();
	$emulsion_current_data_version	 = $emulsion_current_data->get( 'Version' );

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

		echo sanitize_text_field( $emulsion_current_data_version );
	} else {

		return sanitize_text_field( $emulsion_current_data_version );
	}
}

function emulsion_slug( $echo = false ) {

	$emulsion_current_data		 = wp_get_theme();
	$emulsion_current_theme_name = $emulsion_current_data->get( 'Name' );
	$emulsion_current_theme_slug = sanitize_title_with_dashes( $emulsion_current_theme_name );

	if ( $echo == true ) {

		echo $emulsion_current_theme_slug;
	} else {

		return $emulsion_current_theme_slug;
	}
}

if ( ! function_exists( 'emulsion_layout_control' ) ) {

	/**
	 * Add html element for grid display and stream display.
	 * Using the filter, you can return the page displayed in grid format to normal display.
	 * @param type $position
	 * @param type $type
	 * @return type
	 */
	function emulsion_layout_control( $position = 'before', $type = '' ) {

		/**
		 * Filter Example
		 *
		 * All archive pages are displayed in list format
		 * add_filter('emulsion_layout_control','__return_false');
		 * change stream to grid
		 * add_filter('emulsion_layout_control', function($html){ return is'grid'; } );
		 */
		if ( is_single() ) {
			return;
		}
		$type	 = apply_filters( 'emulsion_layout_control', $type );
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

			echo $result;
		}
	}

}

if ( ! function_exists( 'emulsion_search_drawer' ) ) {

	/**
	 * Add Search Page if enable
	 */
	function emulsion_search_drawer() {

		 emulsion_the_theme_supports( 'search_drawer' ) ? get_template_part( 'template-parts/search', 'drawer' ) : '';
	}

}


if ( ! function_exists( 'emulsion_block_editor_styles' ) ) {

	/**
	 * Gutenberg stylesheet for backend editor
	 */
	function emulsion_block_editor_styles() {

		$emulsion_current_data_version =  emulsion_version();

		if ( WP_DEBUG ) {
			$emulsion_current_data_version = time();
		}
		if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
			wp_enqueue_style(
				'emulsion-block-editor-styles', get_theme_file_uri( '/css/style-editor.css' ), array(), $emulsion_current_data_version, 'all'
			);

			$wp_scss_status = get_theme_mod( 'emulsion_wp_scss_status' );

			if ( 'active' !== $wp_scss_status  ) {
				if( function_exists('emulsion_css_variables') ){
					$dinamic_css = emulsion__css_variables();

					wp_add_inline_style( 'emulsion-block-editor-styles', $dinamic_css );
				}
			}
		}
	}

}

if ( ! function_exists( 'emulsion_svg_icon' ) ) {

	/**
	 * rendor svg, Server Side
	 *
	 * @param type $args
	 * @return boolean
	 */
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
			'width'		 => get_theme_mod( 'emulsion_common_font_size', emulsion_theme_default_val( 'emulsion_common_font_size' ) ),
			'height'	 => get_theme_mod( 'emulsion_common_font_size', emulsion_theme_default_val( 'emulsion_common_font_size' ) ),
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

			$svg_attribute	 = 'role="presentation"';
			$svg_attribute	 .= ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
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

		if ( true == $args['fallback'] ) {

			echo wp_kses( $result, EMULSION_ICON_SVG_SYMBOLS_ALLOWED_ELEMENTS );
		}
		if ( false == $args['fallback'] ) {

			return wp_kses( $result, EMULSION_ICON_SVG_SYMBOLS_ALLOWED_ELEMENTS );
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

if ( ! function_exists( 'emulsion_theme_image_dir' ) ) {
	/**
	 * Theme Image Directory
	 * for scss variable
	 */
	function emulsion_theme_image_dir() {

		$theme_image_dir = esc_url( get_template_directory_uri() . '/images/' );
		$child_image_dir = esc_url( get_stylesheet_directory_uri() . '/images/' );

		if ( file_exists( $child_image_dir ) && is_child_theme() ) {

			$theme_image_dir = $child_image_dir;
		}

		$theme_image_dir = wp_make_link_relative( $theme_image_dir );

		return $theme_image_dir;
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


if ( ! function_exists( 'emulsion_get_footer_cols_css' ) ) {

	/**
	 * Get number of columns in footer widget area in% width
	 * @return number
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
	function emulsion_strip_tags_content( $text, $tags = '', $invert = false ) {

		preg_match_all( '/<(.+?)[\s]*\/?[\s]*>/si', trim( $tags ), $tags );
		$tags = array_unique( $tags[1] );

		if ( is_array( $tags ) && count( $tags ) > 0 ) {
			if ( $invert == false ) {
				return preg_replace( '@<(?!(?:' . implode( '|', $tags ) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text );
			} else {
				return preg_replace( '@<(' . implode( '|', $tags ) . ')\b.*?>.*?</\1>@si', '', $text );
			}
		} elseif ( $invert == false ) {
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
			
		return apply_filters('emulsion_current_layout_type', 'list' );	
	}

}


if ( ! function_exists( 'emulsion_header_layout' ) ) {

	/**
	 * Get the type of the header.element
	 * @return type
	 */
	function emulsion_header_layout() {
		
		$result = get_theme_mod( 'emulsion_header_layout', emulsion_theme_default_val( 'emulsion_header_layout' ) );

		return $result;
	}

}

if ( ! function_exists( 'emulsion_is_display_featured_image_in_the_loop' ) ) {

	/**
	 * Show post image in each loop pages ( archive ...)
	 * @return boolean
	 */
	function emulsion_is_display_featured_image_in_the_loop() {
		
		$result = get_theme_mod( 'emulsion_layout_homepage_post_image', emulsion_theme_default_val( 'emulsion_layout_homepage_post_image' ) );
		
		$result = 'hide' === $result ? false: true;
		
		return apply_filters( 'emulsion_is_display_featured_image_in_the_loop' , $result );
	}

}

if ( ! function_exists( 'emulsion_get_svg_ids' ) ) {

	function emulsion_get_svg_ids( $svgs ) {

		return apply_filters( 'emulsion_get_svg_ids', emulsion_the_theme_supports( 'footer-svg' ) );
	}

}


add_filter( 'emulsion_inline_style', 'emulsion_plugins_style_change_inline' );

if ( ! function_exists( 'emulsion_plugins_style_change_inline' ) ) {

	function emulsion_plugins_style_change_inline( $css ) {
		global $wp_style;

		$add_css = '';

		if ( is_page() && false == emulsion_metabox_display_control( 'page_style' ) ) {

			return;
		}
		if ( is_single() && false == emulsion_metabox_display_control( 'style' ) ) {

			return;
		}
		if ( ! emulsion_the_theme_supports( 'enqueue' ) ) {

			return;
		}
		if ( is_user_logged_in() || is_admin() ) {

			return $css;
		}
		if ( ! is_admin() || ! is_user_logged_in() || emulsion_theme_addons_exists() ) {

			$get_css = file( get_theme_file_path( 'css/common.css' ) );
			$add_css .= implode( '', $get_css );
			return $css . $add_css;
		}
		return $css;
	}

}

if ( ! function_exists( 'emulsion_theme_addons_exists' ) ) {

	function emulsion_theme_addons_exists() {

		return function_exists( 'emulsion_get_var' );
	}

}

if ( ! function_exists( 'emulsion_metabox_display_control' ) ) {

	function emulsion_metabox_display_control( $location ) {

		global $post, $emulsion_supports;

		if ( false === emulsion_the_theme_supports( 'metabox' ) ) {

			return true;
		}

		$post_id	 = get_the_ID();
		$is_single	 = is_single();
		$is_page	 = is_page();

		return apply_filters( 'emulsion_metabox_display_control', true, $location, $post_id, $is_single, $is_page );
	}

}

 ! emulsion_theme_addons_exists() ? add_filter('emulsion_inline_style','emulsion_theme_styles') : '';

if ( ! function_exists( 'emulsion_theme_styles' ) ) {

	function emulsion_theme_styles() {

		$css_variables_values = array(
			'emulsion_heading_font_scale',
			'emulsion_heading_font_base',
			'emulsion_header_media_max_height',
			'emulsion_post_display_date',
			'emulsion_post_display_author',
			'emulsion_post_display_category',
			'emulsion_post_display_tag',
			'emulsion_favorite_color_palette',
			'emulsion_header_gradient',
			'emulsion_content_margin_top',
			'emulsion_general_text_color',
			'emulsion_general_link_hover_color',
			'emulsion_general_link_color',
			'emulsion_excerpt_linebreak',
			//'emulsion_sidebar_link_color',
			'emulsion_sidebar_background',
			'emulsion_primary_menu_background',
			'emulsion_comments_bg',
			'emulsion_relate_posts_bg',
			'emulsion_block_media_text_section_bg',
			'emulsion_block_media_text_section_height',
			'emulsion_block_columns_section_bg',
			'emulsion_block_columns_section_height',
			'emulsion_block_gallery_section_bg',
			'emulsion_block_gallery_section_height',
			'emulsion_header_background_color',
			'emulsion_sidebar_position',
			'emulsion_common_font_size',
			'emulsion_common_font_family',
			'emulsion_heading_font_family',
			'emulsion_heading_font_weight',
			'emulsion_heading_font_transform',
			'emulsion_widget_meta_font_size',
			'emulsion_widget_meta_font_family',
			'emulsion_widget_meta_font_transform',
			'emulsion_layout_homepage',
			'emulsion_layout_date_archives',
			'emulsion_layout_category_archives',
			'emulsion_layout_tag_archives',
			'emulsion_layout_author_archives',
			'emulsion_layout_posts_page',
			'emulsion_content_width',
			'emulsion_box_gap',
			'emulsion_main_width',
			'emulsion_sidebar_width', );

		$rule_set = '';

		foreach ( $css_variables_values as $value ) {

			$css_variable	 = str_replace( 'emulsion', '--thm', $value );
			$rule_set		 .= $css_variable . ':' . emulsion_theme_default_val( $value, 'unit_val' ) . ';';
		}

		$variables = <<<VARIABLES

body{
	{$rule_set}
	--thm_primary_menu_link_color:#666;
	
}		
VARIABLES;
	
		$header_text_color		 = sprintf( '#%1$s', get_header_textcolor() );
		$responsive_break_point	 = emulsion_theme_default_val( 'emulsion_content_width' ) + emulsion_theme_default_val( 'emulsion_sidebar_width' ) + emulsion_theme_default_val( 'emulsion_common_font_size' );

		$theme_style =<<<THEME_STYLE
.stream-wrapper	h2{
	font-size:24px;
}
body:not(.emulsion-addons) img{
	max-width:100%;	
	height:auto;
}
body.emulsion-no-sidebar:not(.emulsion-addons) .alignfull{
	width:100vw;
	max-width:none;
	position:relative;		
}
body.emulsion-has-sidebar:not(.emulsion-addons) .alignfull{
	width:calc(100vw - var(--thm_sidebar_width) );
				
}
@media screen and (max-width: {$responsive_break_point}px) {
	body.emulsion-has-sidebar:not(.emulsion-addons) .alignfull{
		width:100vw;				
	}
}
body:not(.emulsion-addons) .more-link{
	display:block;
	margin-left:auto;
	margin-right:auto;
	width:var(--thm_content_width);
	max-width:100%;
}
body:not(.emulsion-addons) .header-layer{
	min-height:80px;
}
body:not(.emulsion-addons) .template-part-header-custom .wp-custom-header,
body:not(.emulsion-addons) .template-part-header-custom .wp-post-image{
	filter: brightness(0.7);
}
body:not(.emulsion-addons) .template-part-header-custom .wp-custom-header,
body:not(.emulsion-addons) .template-part-header-custom img{

}
body:not(.emulsion-addons) .template-part-header-custom .post-featured-image ~ .header-text a,
body:not(.emulsion-addons) .header-layer.template-part-header-custom .entry-text a,	
body:not(.emulsion-addons) .template-part-header-custom .wp-custom-header ~ .header-text .site-title-link{
	color:{$header_text_color};			
}
body:not(.emulsion-addons) .header-layer.template-part-header-custom div:nth-child(2).entry-text{
	position:relative;

}
body:not(.emulsion-addons) .header-layer.template-part-header-custom div:nth-child(2).entry-text *{
	color:#333;
}		
body:not(.emulsion-addons) .template-part-header-custom .post-featured-image ~ .header-text,
body:not(.emulsion-addons) .template-part-header-custom .wp-custom-header ~ .header-text,
body:not(.emulsion-addons) .template-part-header-custom img ~ .header-text{
	position:absolute;
	color:{$header_text_color};
	background:transparent;
}
body:not(.emulsion-addons) .template-part-header-custom img ~ .entry-text a,
body:not(.emulsion-addons) .template-part-header-custom img ~ .header-text .site-description,
body:not(.emulsion-addons) .template-part-header-custom img ~ .header-text .site-title-text{
	color:{$header_text_color};
}
body:not(.emulsion-addons) .excerpt .has-post-image{
	position:relative;
}
body:not(.emulsion-addons) .excerpt footer{
	visibility:hidden;
}
body:not(.emulsion-addons) .excerpt .has-post-image ~ footer,
body:not(.emulsion-addons) .excerpt .has-post-image + .entry-content{
	display:none;
}
body:not(.emulsion-addons) ul.wp-nav-menu[data-direction="horizontal"] li .sub-menu li, 
body:not(.emulsion-addons) ul.wp-nav-menu[data-direction="horizontal"] li .children li{
	background:#fff;
}

THEME_STYLE;
	
		$theme_image_dir = emulsion_theme_image_dir();

		$image_style = <<<CSS

.header-layer-site-title-navigation .menu .nav-menu-child-opener-label:before {
	background: url({$theme_image_dir}svg/arrow-down.svg);
	background-size: contain;
	filter: none;
	-webkit-filter: none;
}
.header-layer-site-title-navigation .menu .nav-menu-child-opener[type="checkbox"]:checked ~ label:before {
	content: ' ';
	background: url("{$theme_image_dir}svg/arrow-up.svg");
	background-size: contain;
}

.header-layer.template-part-header-custom + .primary-menu-wrapper.menu-is-light .menu.wp-nav-menu .nav-menu-child-opener-label:before {
	background: url({$theme_image_dir}svg/arrow-down.svg);
	background-size: contain;
	filter: none;
	-webkit-filter: none;
}
.header-layer.template-part-header-custom + .primary-menu-wrapper.menu-is-light .menu.wp-nav-menu .nav-menu-child-opener[type="checkbox"]:checked ~ label:before {
	content: ' ';
	background: url("{$theme_image_dir}svg/arrow-up.svg");
	background-size: contain;
  
}
 .header-layer-site-title-navigation .menu[data-direction="vertical"] .menu-item .nav-menu-child-opener:checked ~ .nav-menu-child-opener-label:before {
	background: url({$theme_image_dir}svg/arrow-up.svg);
	background-size: contain;
	filter: none;
	-webkit-filter: none;
}
 .header-layer-site-title-navigation .menu[data-direction="vertical"] .menu-item .nav-menu-child-opener ~ .nav-menu-child-opener-label:before {
	background: url({$theme_image_dir}svg/arrow-down.svg);
	background-size: contain;
	filter: none;
	-webkit-filter: none;
}
.post-password-required .theme-message .post-password-form .message:before {
	content: ' ';
	position: absolute;
	display: inline-block;
	vertical-align: middle;
	-webkit-mask-size: contain;
	mask-size: contain;
	background: url("{$theme_image_dir}svg/lock.svg#alert") no-repeat 50% 50%;
	background-size: contain;
	left: -24px;
	width: 24px;
	height: 24px;
}

.skin-button.scroll-button-top:before {
	content:' ';
	background: url({$theme_image_dir}svg/arrow-up.svg);
	background-size: contain;
	background-position: center center;
	background-repeat: no-repeat;
	width: 16px;
	height: 16px;
	position: absolute;
	display: block;
	top: 0;
	right: 0;
	bottom: 0;
	left: -2px;
	margin: auto;
}


CSS;

		return $image_style . $variables . $theme_style ;
	}

}

do_action( 'emulsion_functions_after' );