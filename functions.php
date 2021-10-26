<?php

include_once( get_theme_file_path( 'lib/conf.php' ) );
include_once( get_theme_file_path( 'lib/hooks.php' ) );
include_once( get_theme_file_path( 'lib/template-tags.php' ) );
include_once( get_theme_file_path( 'lib/navigation-pagination.php' ) );
include_once( get_theme_file_path( 'lib/relate-posts.php' ) );
include_once( get_theme_file_path( 'lib/icon.php' ) );
include_once( get_theme_file_path( 'lib/customize.php' ) );
include_once( get_theme_file_path( 'lib/blocks.php' ) );

emulsion_the_theme_supports( 'scheme' ) ? include_once( get_theme_file_path( 'scheme.php' ) ) : '';

emulsion_the_theme_supports( 'full_site_editor' ) && function_exists( 'gutenberg_is_fse_theme' ) ? include_once( get_template_directory() . '/lib/full_site_editor.php' ) : '';

if ( is_admin() && current_user_can( 'edit_theme_options' ) ) {

	/**
	 * TGMPA
	 */
	if ( emulsion_the_theme_supports( 'TGMPA' ) ) {
		include_once( get_theme_file_path( 'lib/tgm-config.php' ) );
		include_once( get_template_directory() . '/lib/class-tgm-plugin-activation.php' );
	}
}

if ( is_customize_preview() ) {

	add_theme_support( 'starter-content', emulsion_get_starter_content() );
}

add_action( 'admin_notices', 'emulsion_theme_admin_notice' );

function emulsion_theme_admin_notice() {

	if ( ! is_plugin_active( 'emulsion-addons/emulsion.php' ) && is_plugin_active( 'wp-scss/wp-scss.php' ) ) {

		$plugin_install_url = esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=all' ) );

		printf( '<div class="notice notice-error is-dismissible emulsion-addon-error"><p><strong>%1$s</strong>  <a href="%2$s">%3$s</a></p></div>', esc_html__( 'If you want to use the wp-scss plugin, you need to activate the emulsion-addons plugin', 'emulsion' ), $plugin_install_url, esc_html__( 'Please update', 'emulsion' )
		);
	}

	if ( version_compare( PHP_VERSION, '8.0.0' ) >= 0 ) {

		$php8_notice = esc_url( esc_html_x( 'https://make.wordpress.org/core/2020/11/23/wordpress-and-php-8-0/', 'linked url', 'emulsion' ) );

		printf( '<div class="notice notice-error is-dismissible emulsion-addon-error"><p><strong>%1$s</strong>  <a href="%2$s">%3$s</a></p></div>', esc_html__( 'emulsion theme notice: May not fully support PHP8 ', 'emulsion' ), $php8_notice, esc_html__( 'WordPress and PHP 8.0', 'emulsion' )
		);
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
		 * Block editor Custom Line height
		 */

		add_theme_support( 'custom-line-height' );

		/**
		 * Block Cover Custom Unit
		 */

		add_theme_support( 'custom-units' );

		/**
		 * Block editor alignwide
		 */
		if ( 'enable' == get_theme_mod( 'emulsion_alignfull', emulsion_theme_default_val( 'emulsion_alignfull' ) ) ) {

			add_theme_support( 'align-wide' );

		} else {

			remove_theme_support( 'align-wide' );

		}

		/**
		 * Block editor experimental style
		 */

		if ( emulsion_the_theme_supports( 'block_experimentals' ) && emulsion_is_plugin_active( 'gutenberg/gutenberg.php' ) ) {

			add_theme_support( 'custom-spacing' );
			add_theme_support( 'experimental-link-color' );
		}

		add_action( 'enqueue_block_editor_assets', 'emulsion_block_editor_styles_and_scripts' ); //back end
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

		add_action( 'widgets_init', 'emulsion_widgets_init' );

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
		 * Template editor
		 */

		if ( 'fse' == get_theme_mod( 'emulsion_editor_support' ) ) {

			add_theme_support( 'block-templates' );

			add_filter( 'block_editor_settings_all', function ( $settings ) {

				$settings['defaultBlockTemplate'] = file_get_contents( get_theme_file_path( 'block-templates/default.html' ) );

				return $settings;
			} );
		}

		/**
		 * Custom Header media
		 */

		$emulsion_custom_header_defaults = get_theme_support( 'custom-header' );
		add_theme_support( 'custom-header', apply_filters( 'emulsion_custom_header_defaults', $emulsion_custom_header_defaults ) );

		/**
		 * Lazy load
		 */

		$instantclick_status = emulsion_the_theme_supports( 'instantclick' ) ? 'eneble' : 'disable';

		if ( 'enable' == get_theme_mod( 'emulsion_instantclick', $instantclick_status ) ) {

			// If instantclick is enabled, it will load a 1px image for lazy load. ( firefox )

			add_filter( 'wp_lazy_loading_enabled', '__return_false' );
		}

		/**
		 * Fresh installation date
		 */

		$fresh_installation = get_theme_mod( 'fresh_installation', false );

		if ( false === $fresh_installation ) {

			set_theme_mod( 'fresh_installation', time() );
		}

		/**
		 * The theme requires a default value for the background color
		 * theme needs default background color but backgroun-image can not support
		 */

		if ( false === get_background_color() ) {

			set_theme_mod( 'background_color', 'ffffff' );
		}
		if ( get_theme_mod( 'emulsion_background_remenber' ) && ! emulsion_theme_addons_exists() ) {

			//Even if you set the background color in the emulsion-addons plugin and then deactivate the plugin,
			//the background color will be remembered and applied.

			add_filter( 'theme_mod_background_color', function($color) {

				return get_theme_mod( 'emulsion_background_remenber' );
			} );
		}


		do_action( 'emulsion_setup_after' );
	}

}

/**
 * Widget
 */
if ( ! function_exists( 'emulsion_widgets_init' ) ) {

	function emulsion_widgets_init() {

		if ( 'fse' == get_theme_mod( 'emulsion_editor_support' ) ) {
			return;
		}

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
				'text'			 => "1",
				'before_sidebar' => '',
				'after_sidebar'	 => '',
					)
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
				'text'			 => "2",
				'before_sidebar' => '',
				'after_sidebar'	 => '',
					)
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
				'text'			 => "3",
				'before_sidebar' => '',
				'after_sidebar'	 => '',
					)
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
				'text'			 => "4",
				'before_sidebar' => '',
				'after_sidebar'	 => '',
					)
			);
		}
		register_sidebar( array(
			'name'			 => esc_html__( 'Search Drawer Content', 'emulsion' ),
			'id'			 => 'sidebar-5',
			'description'	 => is_customize_preview() ? esc_html__( '', 'emulsion' ) : '',
			'before_widget'	 => '<li id="%1$s" class="%2$s widget search-drawer-content" tabindex="-1">',
			'after_widget'	 => "</li>\n",
			'before_title'	 => "\n\t<h2 class=\"widgettitle page-footer\">",
			'after_title'	 => "</h2>\n",
			'widget_id'		 => 'search-drawer-content',
			'widget_name'	 => 'search-drawer-content',
			'text'			 => "5",
			'before_sidebar' => '',
			'after_sidebar'	 => '',
				)
		);
	}

}

/**
 * Style and Scripts
 */
add_action( 'wp_enqueue_scripts', 'emulsion_register_scripts_and_styles' );

function emulsion_register_scripts_and_styles() {
	global $wp_scripts, $wp_version;

	$jquery_dependency = array( 'jquery' );

	/**
	 * jQuery in Footer when user not logged in.
	 */

	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

	if ( false === version_compare( $wp_version, '5.7.0', '<' ) ) {

		$jquery_dependency = array( 'jquery', 'jquery-migrate' );
	}

	$emulsion_current_data_version = null;

	if ( is_user_logged_in() ) {

		$emulsion_current_data_version = emulsion_version();
	}

	$body_classes = get_body_class();

	foreach ( $body_classes as $class ) {

		$file_name	 = 'css/style-' . $class . '.css';
		$handle		 = 'style-' . $class;
		if ( file_exists( get_theme_file_path( $file_name ) ) ) {

			add_filter(
					'body_class', function( $current_css ) use( $handle ) {
				$current_css[] = $handle;
				return $current_css;
			}
			);
			wp_register_style( $handle, get_theme_file_uri( $file_name ), array(), $emulsion_current_data_version, 'all' );
			wp_enqueue_style( $handle );
		}
	}

	wp_register_style( 'emulsion', get_template_directory_uri() . '/style.css', array(), $emulsion_current_data_version, 'all' );

	false === wp_style_is( 'emulsion' ) ? wp_enqueue_style( 'emulsion' ) : '';

	$inline_style_pre = apply_filters( 'emulsion_inline_style_pre', '' ); //@charset "UTF-8";

	/**
	 * style and script version query only when logged in.
	 * In an environment where you do not log in, it will be cached successfully.
	 */

	if ( is_page() && false == emulsion_metabox_display_control( 'page_style' ) ) {

		false === wp_style_is( 'emulsion' ) ? wp_enqueue_style( 'emulsion' ) : '';

		wp_add_inline_style( 'emulsion', $inline_style_pre );

		return;
	}

	if ( is_single() && false == emulsion_metabox_display_control( 'style' ) ) {

		false === wp_style_is( 'emulsion' ) ? wp_enqueue_style( 'emulsion' ) : '';

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

		false === wp_style_is( 'emulsion' ) ? wp_enqueue_style( 'emulsion' ) : '';

		wp_register_style( 'emulsion-backward-compatible', get_template_directory_uri() . '/css/backward-compatible.css', array(), $emulsion_current_data_version, 'all' );
		wp_enqueue_style( 'emulsion-backward-compatible' );

		/**
		 * if child theme has parent name.js( js/emulsion.js ) Read the file of the child theme ( for replace script )
		 */
		wp_register_script( 'emulsion-backward-compatible-js', get_theme_file_uri( 'js/backward-compatible.js' ), $jquery_dependency, $emulsion_current_data_version, true );
		wp_enqueue_script( 'emulsion-backward-compatible-js' );

		return;
	}

	/**
	 * AMP plugin options
	 * Do not load styles if amp plugin end point and support is reader
	 */

	$post_id				 = absint( get_the_ID() );
	$amp_meta_status_value	 = '';

	if ( metadata_exists( 'post', $post_id, 'amp_status' ) ) {

		$amp_meta_status_value = get_post_meta( $post_id, 'amp_status', true );
	}

	/**
	 * load user css files
	 */

	$wp_scss_options = get_option( 'wpscss_options' );

	$css_dir = ! empty( $wp_scss_options ) ? sanitize_text_field( $wp_scss_options["css_dir"] ) : '/css/';

	wp_register_style( 'emulsion-common', get_theme_file_uri( $css_dir . 'common.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-header', get_theme_file_uri( $css_dir . 'header.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-archives', get_theme_file_uri( $css_dir . 'archives.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-single', get_theme_file_uri( $css_dir . 'single.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-block-presentation', get_theme_file_uri( $css_dir . 'block-presentation.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-columns', get_theme_file_uri( $css_dir . 'columns.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-accessibility', get_theme_file_uri( $css_dir . 'accessibility.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-custom-color', get_theme_file_uri( $css_dir . 'custom-color.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-gallery', get_theme_file_uri( $css_dir . 'gallery.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-comments', get_theme_file_uri( $css_dir . 'comments.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-primary-menu', get_theme_file_uri( $css_dir . 'primary-menu.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-misc', get_theme_file_uri( $css_dir . 'misc.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-boxed', get_theme_file_uri( $css_dir . 'boxed.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-responsive', get_theme_file_uri( $css_dir . 'responsive.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'emulsion-fse', get_theme_file_uri( $css_dir . 'fse.css' ), array(), $emulsion_current_data_version, 'all' );

	wp_register_style( 'amp-reader', get_theme_file_uri( $css_dir . 'amp.css' ), array(), '', 'all' );


	$emulsion_theme_styles = array( 'common', 'header', 'archives', 'single', 'block-presentation', 'columns', 'accessibility', 'custom-color', 'gallery', 'comments'
		, 'primary-menu', 'misc', 'boxed', 'responsive' );

	// instantclick Always need all styles

	$support_instantclick	 = emulsion_the_theme_supports( 'instantclick' ) ? 'enable' : 'disable';
	$support_instantclick	 = 'enable' == get_theme_mod( 'emulsion_instantclick', $support_instantclick ) ? true : false;

	if ( $support_instantclick && false === wp_style_is( 'admin-bar' ) && false === wp_style_is( 'emulsion-instantclick-js' ) ) {
		// Cached
		wp_enqueue_style( 'admin-bar' );
	}

	if ( true === $support_instantclick && ! emulsion_is_amp() ) {

		foreach ( $emulsion_theme_styles as $emulsion_theme_style ) {

			$handle = sprintf( 'emulsion-%1$s', $emulsion_theme_style );

			wp_enqueue_style( $handle );
		}
	}

	if ( ! emulsion_is_amp() && false === $support_instantclick ) {

		emulsion_style_load_controller( 'emulsion-common' ) ? wp_enqueue_style( 'emulsion-common' ) : '';

		emulsion_style_load_controller( 'emulsion-header' ) ? wp_enqueue_style( 'emulsion-header' ) : '';

		emulsion_style_load_controller( 'emulsion-archives' ) ? wp_enqueue_style( 'emulsion-archives' ) : '';

		emulsion_style_load_controller( 'emulsion-single' ) ? wp_enqueue_style( 'emulsion-single' ) : '';

		emulsion_style_load_controller( 'emulsion-block-presentation' ) ? wp_enqueue_style( 'emulsion-block-presentation' ) : '';

		emulsion_style_load_controller( 'emulsion-columns' ) ? wp_enqueue_style( 'emulsion-columns' ) : '';

		emulsion_style_load_controller( 'emulsion-accessibility' ) ? wp_enqueue_style( 'emulsion-accessibility' ) : '';

		emulsion_style_load_controller( 'emulsion-custom-color' ) ? wp_enqueue_style( 'emulsion-custom-color' ) : '';

		emulsion_style_load_controller( 'emulsion-gallery' ) ? wp_enqueue_style( 'emulsion-gallery' ) : '';

		emulsion_style_load_controller( 'emulsion-comments' ) ? wp_enqueue_style( 'emulsion-comments' ) : '';

		emulsion_style_load_controller( 'emulsion-primary-menu' ) ? wp_enqueue_style( 'emulsion-primary-menu' ) : '';

		emulsion_style_load_controller( 'emulsion-misc' ) ? wp_enqueue_style( 'emulsion-misc' ) : '';

		emulsion_style_load_controller( 'emulsion-boxed' ) ? wp_enqueue_style( 'emulsion-boxed' ) : '';

		emulsion_style_load_controller( 'emulsion-responsive' ) ? wp_enqueue_style( 'emulsion-responsive' ) : '';
	}

	emulsion_style_load_controller( 'emulsion-fse' ) ? wp_enqueue_style( 'emulsion-fse' ) : '';


	if ( emulsion_style_load_controller( 'amp-reader' ) ) {

		wp_enqueue_style( 'amp-reader' );

		! emulsion_theme_addons_exists() ? add_filter( 'emulsion_the_theme_supports', 'emulsion_amp_exclude_supports', 10, 2 ) : '';
	}

	if ( ! empty( $inline_style_pre ) ) {

		$inline_style = apply_filters( 'emulsion_inline_style', $inline_style_pre );
	} else {

		$inline_style = apply_filters( 'emulsion_inline_style', '' );
	}

	$inline_style = emulsion_sanitize_css( $inline_style );

	$inline_style = emulsion_remove_spaces_from_css( $inline_style );



	$emulsion_style = function_exists( 'emulsion_custom_field_css' ) ? emulsion_custom_field_css( '' ) : '';

	$emulsion_style .= ! is_user_logged_in() ? get_theme_mod( 'emulsion__css_variables', '' ) : '';

	$emulsion_style .= ! emulsion_theme_addons_exists() && function_exists( 'emulsion_theme_styles' ) ? emulsion_theme_styles( '' ) : '';

	$emulsion_style .= function_exists( 'emulsion_woocommerce_dinamic_css' ) ? emulsion_woocommerce_dinamic_css( '' ) : '';

	$emulsion_style .= function_exists( 'emulsion_add_third_party_block_css' ) ? emulsion_add_third_party_block_css( '' ) : '';

	$emulsion_style .= function_exists( 'emulsion_add_common_font_css' ) ? emulsion_add_common_font_css( '' ) : '';

	$emulsion_style .= function_exists( 'emulsion_heading_font_css' ) ? emulsion_heading_font_css( '' ) : '';

	$emulsion_style .= function_exists( 'emulsion_block_experimentals_style' ) ? emulsion_block_experimentals_style( '' ) : '';

	//Currently, AMP does not read CSS variables.
	$emulsion_style .= function_exists( 'emulsion_add_amp_css_variables' ) ? emulsion_add_amp_css_variables( '' ) : '';

	$emulsion_style .= function_exists( 'emulsion_icon_svg_styles' ) ? emulsion_icon_svg_styles( '' ) : '';

	$emulsion_style = emulsion_sanitize_css( $emulsion_style );

	wp_add_inline_style( 'emulsion', $emulsion_style . $inline_style );

	/**
	 * Child Theme
	 */
	if ( is_child_theme() ) {

		$emulsion_child_theme_slug = emulsion_slug();

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
			wp_register_script( $emulsion_child_theme_slug . '-js', get_stylesheet_directory_uri() . '/js/' . $emulsion_child_theme_slug . '.js', $jquery_dependency, $emulsion_current_data_version, true );

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

	$emulsion_widget_meta_google_font_url = esc_url( get_theme_mod( 'emulsion_widget_meta_google_font_url', emulsion_theme_default_val( 'emulsion_widget_meta_google_font_url' ) ) );

	if ( ! empty( $emulsion_widget_meta_google_font_url ) ) {

		wp_register_style( 'emulsion-widget-meta-google-font', $emulsion_widget_meta_google_font_url, array( 'emulsion' ), null, 'all' );
		wp_enqueue_style( 'emulsion-widget-meta-google-font' );
	}

	/**
	 * Lazyload
	 */

	$support = emulsion_the_theme_supports( 'lazyload' ) ? 'enable' : 'disable';
	$support = 'enable' == get_theme_mod( 'emulsion_lazyload', $support ) ? true : false;

	if ( $support && ! emulsion_is_amp() ) {

		if ( true == WP_DEBUG ) {

			wp_register_script( 'emulsion-lazyload-js', get_theme_file_uri( 'js/lazyload.js' ), $jquery_dependency, $emulsion_current_data_version, true );
		} else {

			wp_register_script( 'emulsion-lazyload-js', get_theme_file_uri( 'js/lazyload.min.js' ), $jquery_dependency, $emulsion_current_data_version, true );
		}
		wp_enqueue_script( 'emulsion-lazyload-js' );

		$inline_script = apply_filters( 'emulsion_lazyload_script', "" );
		wp_add_inline_script( 'emulsion-lazyload-js', $inline_script );
	}

	/**
	 * Instantclick
	 */

	$support = emulsion_the_theme_supports( 'instantclick' ) ? 'enable' : 'disable';
	$support = 'enable' == get_theme_mod( 'emulsion_instantclick', $support ) ? true : false;

	if ( $support && 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_user_logged_in() && ! emulsion_is_amp() ) {

		if ( true == WP_DEBUG ) {

			wp_register_script( 'emulsion-instantclick-js', get_theme_file_uri( 'js/instantclick.js' ), array( 'emulsion-js' ), $emulsion_current_data_version, true );
		} else {

			wp_register_script( 'emulsion-instantclick-js', get_theme_file_uri( 'js/instantclick.min.js' ), array( 'emulsion-js' ), $emulsion_current_data_version, true );
		}
		wp_enqueue_script( 'emulsion-instantclick-js' );

		$inline_script = apply_filters( 'emulsion_instantclick_script', "" );
		wp_add_inline_script( 'emulsion-instantclick-js', $inline_script );
	}

	/**
	 * Table of contents
	 */

	$support = emulsion_the_theme_supports( 'toc' ) ? 'enable' : 'disable';
	$support = 'enable' == get_theme_mod( 'emulsion_table_of_contents', $support ) ? true : false;

	if ( $support && ! emulsion_is_amp() ) {
		if ( true == WP_DEBUG ) {

			wp_register_script( 'emulsion-toc-js', get_theme_file_uri( 'js/toc.js' ), array( 'emulsion-js' ), $emulsion_current_data_version, true );
		} else {

			wp_register_script( 'emulsion-toc-js', get_theme_file_uri( 'js/toc.min.js' ), array( 'emulsion-js' ), $emulsion_current_data_version, true );
		}
		wp_enqueue_script( 'emulsion-toc-js' );

		$inline_script = apply_filters( 'emulsion_toc_script', "" );
		wp_add_inline_script( 'emulsion-toc-js', $inline_script );
	}


	/**
	 * Tooltip
	 */

	$support = emulsion_the_theme_supports( 'tooltip' ) ? 'enable' : 'disable';
	$support = 'enable' == get_theme_mod( 'emulsion_tooltip', $support ) ? true : false;

	if ( $support && ! is_customize_preview() && ! emulsion_is_amp() ) {

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

		wp_register_script( 'emulsion-js', get_theme_file_uri( 'js/emulsion.js' ), $jquery_dependency, $emulsion_current_data_version, true );
	} else {

		wp_register_script( 'emulsion-js', get_theme_file_uri( 'js/emulsion.min.js' ), $jquery_dependency, $emulsion_current_data_version, true );
	}
	if ( ! emulsion_is_amp() ) {
		wp_enqueue_script( 'emulsion-js' );

		$inline_script = apply_filters( 'emulsion_inline_script', "" );
		wp_add_inline_script( 'emulsion-js', $inline_script );
	}

	/**
	 * Localize Script
	 * Note:Remember the emulsion_script_vars objects values are all embedded in string format.
	 */

	$wp_scss_status_relate_setting = emulsion_theme_addons_exists() ? get_theme_mod( 'emulsion_sidebar_position', emulsion_get_var( 'emulsion_sidebar_position' ) ) : get_theme_mod( 'emulsion_sidebar_position', emulsion_theme_default_val( 'emulsion_sidebar_position' ) );

	$emulsion_background_color = true === emulsion_theme_addons_exists() ? emulsion_the_hex2rgb( emulsion_get_background_color() ) : 'rgb(255,255,255)'; //sprintf( '#%1$s', get_background_color() );

	$instantclick_support = emulsion_the_theme_supports( 'instantclick' ) ? 'enable' : 'disable';

	if ( ! emulsion_is_amp() ) {
		wp_localize_script( 'emulsion-js', 'emulsion_script_vars', array(
			'locale'					 => sanitize_text_field( get_locale() ),
			'end_point'					 => esc_url( rest_url() ),
			'allowed_query'				 => array( 'posts', 'page', 'categories', 'tag' ),
			'rest_query'				 => 'wp/v2/posts?page=',
			'permalink'					 => esc_url( get_permalink() ),
			'home_url'					 => esc_url( home_url() ),
			'posts_page_url'			 => get_option( 'page_for_posts' ) ? esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) : 'none',
			'i18n_blank_entry_title'	 => esc_html__( 'No Title', 'emulsion' ),
			'sidebar_bg_dark'			 => emulsion_theme_addons_exists() ? emulsion_accent_color( '', 5, 5, 20, 15 ) : $emulsion_background_color,
			'sidebar_bg_light'			 => emulsion_theme_addons_exists() ? emulsion_accent_color( '', 5, 5, 20, 90 ) : $emulsion_background_color,
			'sidebar_position'			 => $wp_scss_status_relate_setting, // left right none
			'sidebar_width'				 => absint( get_theme_mod( 'emulsion_sidebar_width', emulsion_theme_default_val( 'emulsion_sidebar_width' ) ) ),
			'block_sectionize'			 => emulsion_the_theme_supports( 'block_sectionize' ),
			'header_bg_color'			 => sanitize_hex_color( get_theme_mod( 'emulsion_header_background_color', emulsion_theme_default_val( 'emulsion_header_background_color' ) ) ),
			'sticky_sidebar'			 => sanitize_text_field( get_theme_mod( 'emulsion_sticky_sidebar', emulsion_theme_default_val( 'emulsion_sticky_sidebar' ) ) ),
			'align_offset'				 => emulsion_theme_addons_exists() ? emulsion_get_css_variables_values( 'align_offset' ) : 200,
			'content_width'				 => absint( get_theme_mod( 'emulsion_content_width', emulsion_theme_default_val( 'emulsion_content_width' ) ) ),
			'content_gap'				 => emulsion_theme_addons_exists() ? absint( emulsion_get_css_variables_values( 'content_gap' ) ) : 24,
			'background_color'			 => $emulsion_background_color,
			'force_contrast'			 => true,
			'block_quote_class_title'	 => esc_html__( 'Quote block', 'emulsion' ),
			'block_buttons_class_title'	 => esc_html__( 'Buttons block', 'emulsion' ),
			'meta_description'			 => ! empty( emulsion_meta_description() ) ? emulsion_meta_description() : 'none',
			'is_customize_preview'		 => is_customize_preview() ? 'is_preview' : '',
			'post_id'					 => absint( get_the_ID() ),
			'header_default_text_color'	 => get_theme_support( 'custom-header', 'default-text-color' ),
			'prefers_color_scheme'		 => defined( 'EMULSION_DARK_MODE_SUPPORT' ) && true === EMULSION_DARK_MODE_SUPPORT ? 'enable' : 'disable',
			'go_to_top_label'			 => esc_html__( 'Go to top', 'emulsion' ),
			'emulsion_accepted_svg_ids'	 => sanitize_text_field( get_theme_mod( 'emulsion_accepted_svg_ids' ) ),
			'instantclick_support'		 => get_theme_mod( 'emulsion_instantclick', $instantclick_support ),
		) );
	}
}

if ( ! function_exists( 'emulsion_template_part_names_class' ) ) {

	/**
	 * the class name associated with the included template
	 *
	 * @global type $template
	 * @param type $file
	 * @param type $echo
	 * @return boolean
	 */
	function emulsion_template_part_names_class( $file = '', $echo = true ) {

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

		$post_id = get_the_ID();

		$header_text_color	 = ! empty( get_header_textcolor() ) ? sprintf( '#%1$s', get_header_textcolor() ) : '';
		$class_name			 = '';

		if ( ! empty( $header_text_color ) ) {

			$class_name = ' has-header-text-color';
		}

		/**
		 * Whether the header has images or video, its state is represented by class.
		 * classes : header-video-active, header-image-active, no-header-media password-required
		 */
		$class_name			 .= post_password_required() ? ' password-required' : '';
		$post_id			 = get_the_ID();
		$current_post_type	 = trim( get_post_type( $post_id ) );

		if ( is_header_video_active() &&
				has_header_video() &&
				false !== emulsion_home_type() &&
				'custom' == get_theme_mod( 'emulsion_header_layout', emulsion_theme_default_val( 'emulsion_header_layout' ) )
		) {

			$class_name .= ' header-video-active';
		} elseif ( has_header_image() &&
				( ! is_singular( $current_post_type ) || is_page() ) &&
				! is_paged() &&
				false !== emulsion_home_type() &&
				'custom' == get_theme_mod( 'emulsion_header_layout', emulsion_theme_default_val( 'emulsion_header_layout' ) )
		) {
			//plugin active
			//static page or loop
			$class_name .= ' header-image-active';
		} elseif ( is_singular( $current_post_type ) ) {

			if ( ! post_password_required( $post_id ) ) {
				// Post using featured image

				if( emulsion_media_display_judgment() ) {

					$class_name .= ' header-image-active';
				} elseif ( emulsion_is_amp() && has_post_thumbnail( $post_id ) ) {

					$class_name .= ' amp-singular-has-header-image';
				} else {

					$class_name .= ' no-header-media';
				}
			}
		} else {

			$class_name .= ' no-header-media';
		}

		/**
		 * CTA layer
		 */
		if ( has_nav_menu( 'header' ) ) {
			$class_name .= ' cta-layer-active';
		} else {
			$class_name .= ' cta-layer-deactive';
		}

		/**
		 * Logo
		 */
		if ( has_custom_logo() ) {

			$class_name .= ' has-custom-logo';
		}

		$class_name = apply_filters( 'emulsion_the_header_layer_class', $class_name );

		echo emulsion_class_name_sanitize( $class_name . ' ' . $class );
	}

}

function emulsion_media_display_judgment() {

	$current_post_type = trim( get_post_type() );
	$post_id			 = get_the_ID();

	if ( has_post_thumbnail( $post_id ) &&
		! emulsion_is_amp() &&
		'yes' == get_theme_mod( 'emulsion_title_in_header', emulsion_theme_default_val( 'emulsion_title_in_header' ) &&
		'custom' == get_theme_mod( 'emulsion_header_layout', emulsion_theme_default_val( 'emulsion_header_layout' ) ) &&
		! empty( get_the_post_thumbnail() ) ) &&  // like woocommerce
		is_singular( array( $current_post_type ) ) &&
		! post_password_required( $post_id )
	) {

		return true;
	}
	return false;
}

if ( ! function_exists( 'emulsion_body_background_class' ) ) {

	function emulsion_body_background_class( $classes ) {

		$emulsion_background_color = true === emulsion_theme_addons_exists() ? emulsion_get_background_color() : sprintf( '#%1$s', get_background_color() );

		$color = emulsion_accessible_color( $emulsion_background_color );
		if ( '#ffffff' == $color ) {
			$classes[] = 'is-dark';
		} else {
			$classes[] = 'is-light';
		}
		return $classes;
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

		$required_password = post_password_required();

		if ( 'root' == $location ) {
			$root_class	 = '';
			$amp_options = get_option( 'amp-options' );

			if ( ! empty( $amp_options ) && ! empty( $amp_options['theme_support'] ) ) {

				$class_name	 = 'emulsion-amp-' . $amp_options['theme_support'];
				$root_class	 .= ' ' . sanitize_html_class( $class_name );
			}
			if ( emulsion_theme_addons_exists() ) {

				$root_class .= ' emulsion-addons-active';
			} else {

				$root_class .= ' emulsion-addons-inactive';
			}

			if ( function_exists( 'emulsion_stop_fse' ) && emulsion_stop_fse() ) {

				$root_class .= ' emulsion-fse-stopped';
			}

			return apply_filters( 'emulsion_element_classes_root', $root_class );
		}

		$post_id = get_the_ID();

		if ( 'primary' == $location ) {

			$is_active_menu		 = emulsion_is_active_nav_menu( $location );
			$sidebar_position	 = get_theme_mod( 'emulsion_sidebar_position', emulsion_theme_default_val( 'emulsion_sidebar_position' ) );
			$menu_background	 = get_theme_mod( 'emulsion_primary_menu_background', emulsion_theme_default_val( 'emulsion_primary_menu_background' ) );

			if ( emulsion_theme_addons_exists() ) {

				//$menu_background = false === $menu_background ? emulsion_sidebar_background(): $menu_background;

				$menu_background = false === $menu_background ? emulsion_get_var( 'emulsion_primary_menu_background' ) : $menu_background;
			} else {

				if ( false === $menu_background && false !== get_theme_mod( 'background_color' ) ) {

					$menu_background = sanitize_hex_color( sprintf( '#%1$s', get_theme_mod( 'background_color' ) ) );
				} else {

					$menu_background = get_theme_mod( 'emulsion_primary_menu_background', emulsion_theme_default_val( 'emulsion_primary_menu_background' ) );
				}
			}

			$menu_text_color	 = emulsion_accessible_color( $menu_background );
			$menu_color_class	 = '#333333' == $menu_text_color ? 'menu-is-light' : 'menu-is-dark';

			if ( ! emulsion_theme_addons_exists() && ( false == get_theme_mod( 'emulsion_primary_menu_background', false ) ||
					get_theme_mod( 'emulsion_primary_menu_background', false ) == emulsion_theme_default_val( 'emulsion_primary_menu_background', 'default' )) ) {
				$menu_color_class = 'menu-is-default';
			}

			$class	 = 'primary-menu-wrapper';
			$class	 .= $is_active_menu ? ' menu-active' : ' menu-inactive';
			$class	 .= ' ' . sanitize_html_class( 'side-' . $sidebar_position );
			$class	 .= ' ' . $menu_color_class;

			return ' ' . emulsion_class_name_sanitize( $class );
		}

		if ( 'sidebar-widget-area' == $location || 'footer-widget-area' == $location ) {

			$background = get_theme_mod( 'emulsion_sidebar_background', emulsion_theme_default_val( 'emulsion_sidebar_background' ) );

			if ( emulsion_theme_addons_exists() ) {

				$background = false === $background || 'ffffff' === $background ? emulsion_sidebar_background() : $background;
			} else {

				//$background = get_theme_mod('emulsion_sidebar_background', emulsion_theme_default_val( 'emulsion_sidebar_background' ) );
				$background = false === $background || 'ffffff' === $background ? emulsion_theme_default_val( 'emulsion_sidebar_background' ) : $background;
			}

			$text_color			 = emulsion_accessible_color( $background );
			$text_color_class	 = '#333333' == $text_color ? 'sidebar-is-light' : 'sidebar-is-dark';

			$custom_border_class = emulsion_theme_addons_exists() || get_theme_mod( 'emulsion_border_sidebar' ) || get_theme_mod( 'emulsion_border_sidebar_style' ) || get_theme_mod( 'emulsion_border_sidebar_width' ) ? 'has-border-custom' : 'border-default';

			$footer_cols_class = '';

			if ( ! emulsion_theme_addons_exists() && ( false == get_theme_mod( 'emulsion_sidebar_background', false ) ||
					get_theme_mod( 'emulsion_sidebar_background', false ) == emulsion_theme_default_val( 'emulsion_sidebar_background', 'default' ) ) ) {

				$text_color_class = 'sidebar-is-default';
			}

			if ( 'footer-widget-area' == $location ) {

				$footer_cols_class	 = get_theme_mod( 'emulsion_footer_columns', emulsion_theme_default_val( 'emulsion_footer_columns' ) );
				$footer_cols_class	 = 'footer-cols-' . absint( $footer_cols_class );
			}

			return ' ' . emulsion_class_name_sanitize( $text_color_class . ' ' . $custom_border_class . ' ' . $footer_cols_class );
		}

		if ( 'article-header' == $location ) {

			if ( $required_password ) {

				return false;
			}
			$page_title_position			 = emulsion_the_theme_supports( 'title_in_page_header' ) ? 'yes' : 'no';
			$emulsion_title_in_page_header	 = get_theme_mod( 'emulsion_title_in_header', $page_title_position );


			if ( ! is_singular() || 'no' == $emulsion_title_in_page_header ) {

				$required_password	 = post_password_required();
				$show_post_image	 = emulsion_is_display_featured_image_in_the_loop();
				$thumbnail_url		 = get_the_post_thumbnail_url();
				if ( ! empty( $thumbnail_url ) && ! $required_password && $show_post_image ) {

					return 'show-post-image';
				} else {

					__return_empty_string();
				}
			} else {

				return 'screen-reader-text';
			}
		}
	}

}

if ( ! function_exists( 'emulsion_class_name_sanitize' ) ) {

	/**
	 * Normally use sanitize_html_class.
	 *
	 * Useful for multi-classes such as space delimiters or class arrays.
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
		 * add_filter('emulsion_layout_control', function($html){ return 'grid'; } );
		 */
		if ( is_single() ) {

			return;
		}
		$custom_border_class = '';
		$type				 = apply_filters( 'emulsion_layout_control', $type );
		$type				 = sanitize_html_class( $type );

		if ( 'grid' == $type ) {
			$custom_border_class = emulsion_theme_addons_exists() || get_theme_mod( 'emulsion_border_grid' ) || get_theme_mod( 'emulsion_border_grid_style' ) || get_theme_mod( 'emulsion_border_grid_width' ) ? 'has-border-custom' : 'thm-border-default';
		}
		if ( 'stream' == $type ) {
			$custom_border_class = emulsion_theme_addons_exists() || get_theme_mod( 'emulsion_border_stream' ) || get_theme_mod( 'emulsion_border_stream_style' ) || get_theme_mod( 'emulsion_border_stream_width' ) ? 'has-border-custom' : 'thm-border-default';
		}

		if ( post_type_exists( $type ) && 'post' !== $type && 'page' !== $type ) {

			$type .= ' custom-post-type';
		}

		$position = $position == ('before' || 'after') ? $position : '';

		if ( ! empty( $type ) && ! empty( $position ) ) {

			echo 'before' === $position ? '<div class="' . $type . ' ' . $custom_border_class . '">' : '</div>';
		}
	}

}

if ( ! function_exists( 'emulsion_search_drawer' ) ) {

	/**
	 * Add Search Page if enable
	 */
	function emulsion_search_drawer() {

		true == emulsion_the_theme_supports( 'search_drawer' ) && 'enable' == get_theme_mod( 'emulsion_search_drawer', emulsion_theme_default_val( 'emulsion_search_drawer' ) ) ? get_template_part( 'template-parts/search', 'drawer' ) : '';
	}

}

if ( ! function_exists( 'emulsion_block_editor_styles_and_scripts' ) ) {

	/**
	 * Gutenberg stylesheet for backend editor
	 */
	function emulsion_block_editor_styles_and_scripts() {

		$emulsion_current_data_version = WP_DEBUG ? time() : emulsion_version();

		if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {

			wp_enqueue_style( 'emulsion-block-editor-styles', get_theme_file_uri( '/css/style-editor.css' ), array(), $emulsion_current_data_version, 'all' );

			$add_css = '';
			$get_css = file( get_theme_file_path( 'css/boxed.css' ) );
			$add_css .= implode( '', $get_css );
			$get_css = file( get_theme_file_path( 'css/misc.css' ) );
			$add_css .= implode( '', $get_css );
			$get_css = file( get_theme_file_path( 'css/block-presentation.css' ) );
			$add_css .= implode( '', $get_css );

			if ( function_exists( 'emulsion__css_variables' ) ) {

				//The style may not be reflected due to the cache. Always change style dynamically
				$dinamic_css = emulsion__css_variables() . $add_css;

				wp_add_inline_style( 'emulsion-block-editor-styles', $dinamic_css );
			} else {

				$default_variables = <<<DEFAULT_VARIABLES
:root{
    --thm_background_image_dim: rgba( 0, 0, 0, 0.0);
    --thm_border_global: #bcbcbc;
    --thm_border_global_style: solid;
    --thm_border_global_width: 1px;
    --thm_border_grid: #bcbcbc;
    --thm_border_grid_style: solid;
    --thm_border_grid_width: 1px;
    --thm_border_sidebar: #bcbcbc;
    --thm_border_sidebar_style: solid;
    --thm_border_sidebar_width: 1px;
    --thm_border_stream: #bcbcbc;
    --thm_border_stream_style: solid;
    --thm_border_stream_width: 1px;
    --thm_comments_bg: #eeeeee;
    --thm_comments_color: #333333;
    --thm_comments_link_color: #666666;
    --thm_content_margin_top: 0px;
    --thm_excerpt_linebreak: none;
    --thm_favorite_color_palette: #1e73be;
    --thm_general_link_color: #666666;
    --thm_general_link_hover_color: #333333;
    --thm_general_text_color: #333333;
    --thm_header_background_gradient_color: #eeeeee;
    --thm_header_hover_color: #333333;
    --thm_header_image_dim: rgba(0,0,0,.5);
    --thm_header_link_color: #666666;
    --thm_header_media_max_height: 75vh;
    --thm_heading_font_base: 16;
    --thm_heading_font_scale: xxx;
    --thm_post_display_author: inherit;
    --thm_post_display_category: inherit;
    --thm_post_display_date: inherit;
    --thm_post_display_tag: inherit;
    --thm_primary_menu_background: #ffffff;
    --thm_primary_menu_color: #333333;
    --thm_primary_menu_link_color: #666666;
    --thm_relate_posts_bg: #eeeeee;
    --thm_relate_posts_color: #333333;
    --thm_relate_posts_link_color: #666666;
    --thm_sidebar_bg_color: #ffffff;
    --thm_sidebar_hover_color: #333333;
    --thm_sidebar_link_color: #666666;
    --thm_sidebar_text_color: #333333;
    --thm_sub_background_color_darken: hsla(0deg,0%,75%,1);
    --thm_sub_background_color_lighten: hsla(0deg,0%,100%,1);
    --thm_align_offset: 200px;
    --thm_background_color: #ffffff;
    --thm_box_gap: 3px;
    --thm_caption_height: 1.5em;
    --thm_common_font_family: sans-serif;
    --thm_common_font_size: 16px;
    --thm_common_line_height: 1.15;
    --thm_content_gap: 24px;
    --thm_content_line_height: 1.5;
    --thm_content_width: 720px;
    --thm_default_header_height: 300px;
    --thm_footer_widget_width: 30%;
    --thm_header_bg_color: #eeeeee;
    --thm_header_text_color: #333333;
    --thm_heading_font_family: serif;
    --thm_heading_font_transform: uppercase;
    --thm_heading_font_weight: 700;
    --thm_hover_color: #333333;
    --thm_i18n_no_title: 無題;
    --thm_main_width-with-sidebar: calc(100vw - var(--thm_sidebar_width) - 48px );
    --thm_main_width: 1280px;
    --thm_meta_data_font_family: sans-serif;
    --thm_meta_data_font_size: 13px;
    --thm_meta_data_font_transform: none;
    --thm_sidebar_width: 400px;
    --thm_social_icon_color: #666666;
						}

DEFAULT_VARIABLES;
				wp_add_inline_style( 'emulsion-block-editor-styles', $default_variables . $add_css );
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

		$result = apply_filters( 'emulsion_svg_icon', $result );

		if ( true == $args['fallback'] ) {

			echo ent2ncr( $result );
		}
		if ( false == $args['fallback'] ) {

			return ent2ncr( $result );
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

		$settings['l10n']['play']	 = '<span class="screen-reader-text">' . esc_html__( 'Play header video', 'emulsion' ) . '</span>' . emulsion_svg_icon( array( 'icon' => 'play' ) );
		$settings['l10n']['pause']	 = '<span class="screen-reader-text">' . esc_html__( 'Pause header video', 'emulsion' ) . '</span>' . emulsion_svg_icon( array( 'icon' => 'pause' ) );

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


if ( ! function_exists( 'emulsion_get_footer_cols_css' ) ) {

	/**
	 * Get number of columns in footer widget area in% width
	 * @return number
	 */
	function emulsion_get_footer_cols_css() {

		$cols			 = emulsion_get_footer_cols();
		$cols_percent	 = 100 / $cols;
		$cols_percent	 = floor( $cols_percent ) - 3;

		return $cols_percent;
	}

}

if ( ! function_exists( 'emulsion_current_layout_type' ) ) {

	/**
	 * Determine whether the current page is a grid layout or a stream layout
	 * @return string
	 */
	function emulsion_current_layout_type() {

		return apply_filters( 'emulsion_current_layout_type', 'list' );
	}

}


if ( ! function_exists( 'emulsion_header_layout' ) ) {

	/**
	 * Get the type of the header.element
	 * @return type
	 */
	function emulsion_header_layout() {

		return get_theme_mod( 'emulsion_header_layout', emulsion_theme_default_val( 'emulsion_header_layout' ) );
	}

}

if ( ! function_exists( 'emulsion_is_display_featured_image_in_the_loop' ) ) {

	/**
	 * Show post image in each loop pages ( archive ...)
	 * @return boolean
	 */
	function emulsion_is_display_featured_image_in_the_loop() {

		$setting = 'show' === get_theme_mod( 'emulsion_layout_homepage_post_image', emulsion_theme_default_val( 'emulsion_layout_homepage_post_image' ) ) ? true : false;

		return apply_filters( 'emulsion_is_display_featured_image_in_the_loop', $setting );
	}

}

if ( ! function_exists( 'emulsion_get_svg_ids' ) ) {

	function emulsion_get_svg_ids( $svgs ) {

		preg_match_all( '#id=(\'|\")([^(\'|\")]+)(\'|\")#', $svgs, $result, PREG_PATTERN_ORDER );

		return isset( $result[2] ) && ! empty( $result[2] ) ? apply_filters( 'emulsion_get_svg_ids', json_encode( $result[2] ) ) : false;
	}

}

if ( ! function_exists( 'emulsion_theme_addons_exists' ) ) {

	function emulsion_theme_addons_exists() {

		return function_exists( 'emulsion_get_var' );
	}

}

if ( ! function_exists( 'emulsion_is_amp' ) ) {

	function emulsion_is_amp() {

		if ( function_exists( 'is_amp_endpoint' ) ) {



			return is_amp_endpoint();
		}

		return false;
	}

}

if ( ! function_exists( 'emulsion_lang_cjk' ) ) {

	function emulsion_lang_cjk() {

		$locale = sanitize_text_field( get_locale() );

		if ( 'ja' == $locale || 'ko-KR' == $locale || 'zh-CN' == $locale || 'zh-TW' == $locale || 'zh-HK' == $locale ) {

			return true;
		}

		return false;
	}

}

if ( ! function_exists( 'emulsion_is_plugin_active' ) ) {

	function emulsion_is_plugin_active( $plugin ) {

		return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || emulsion_is_plugin_active_for_network( $plugin );
	}

	function emulsion_is_plugin_active_for_network( $plugin ) {
		if ( ! is_multisite() ) {
			return false;
		}

		$plugins = get_site_option( 'active_sitewide_plugins' );
		if ( isset( $plugins[$plugin] ) ) {
			return true;
		}

		return false;
	}

}

if ( ! function_exists( 'emulsion_metabox_display_control' ) ) {

	function emulsion_metabox_display_control( $location ) {
		global $post, $emulsion_supports;

		$post_id = absint( get_the_ID() );

		$result = true;

		if ( function_exists( 'emulsion_get_supports' ) && 'header' == $location && false === emulsion_get_supports( $location ) && is_singular() ) {

			return false;
		}

		/**
		 * Fall back to the metabox settings in the plugin even if you no longer use emulsion addons plugin
		 */
		if ( is_single() ) {

			if ( metadata_exists( 'post', $post_id, 'emulsion_post_header' ) && 'header' == $location ) {
				$result = 'no_header' == get_post_meta( $post_id, 'emulsion_post_header', true ) ? false : true;
			}
			if ( metadata_exists( 'post', $post_id, 'emulsion_post_primary_menu' ) && 'menu' == $location ) {
				$result = 'no_header' == get_post_meta( $post_id, 'emulsion_post_header', true ) ? false : true;
			}
			if ( metadata_exists( 'post', $post_id, 'emulsion_post_sidebar' ) && 'sidebar' == $location ) {
				$result = 'no_sidebar' == get_post_meta( $post_id, 'emulsion_post_sidebar', true ) ? false : true;
			}
			if ( metadata_exists( 'post', $post_id, 'emulsion_post_theme_style_script' ) && 'style' == $location ) {
				$result = 'no_style' == get_post_meta( $post_id, 'emulsion_post_theme_style_script', true ) ? false : true;
			}
		}
		if ( is_page() ) {

			if ( metadata_exists( 'page', $post_id, 'emulsion_page_header' ) && 'page_header' == $location ) {
				$result = 'no_header' == get_page_meta( $post_id, 'emulsion_page_header', true ) ? false : true;
			}
			if ( metadata_exists( 'page', $post_id, 'emulsion_page_primary_menu' ) && 'page_menu' == $location ) {
				$result = 'no_header' == get_page_meta( $post_id, 'emulsion_page_header', true ) ? false : true;
			}
			if ( metadata_exists( 'page', $post_id, 'emulsion_page_sidebar' ) && 'page_sidebar' == $location ) {
				$result = 'no_sidebar' == get_page_meta( $post_id, 'emulsion_page_sidebar', true ) ? false : true;
			}
			if ( metadata_exists( 'page', $post_id, 'emulsion_page_theme_style_script' ) && 'page_style' == $location ) {
				$result = 'no_style' == get_page_meta( $post_id, 'emulsion_page_theme_style_script', true ) ? false : true;
			}
		}

		return apply_filters( 'emulsion_metabox_display_control', $result, $location, $post_id, is_single(), is_page() );
	}

}


if ( ! function_exists( 'emulsion_accessible_color' ) ) {

	/**
	 * Calculate text color from background color
	 * @param type $hex
	 * @param type $alpha
	 * @return type
	 */
	function emulsion_accessible_color( $hex_background_color = '' ) {

		$hex = str_replace( '#', '', $hex_background_color );
		$d	 = '[a-fA-F0-9]';

		if ( preg_match( "/^($d$d)($d$d)($d$d)\$/", $hex, $rgb ) ) {

			$r	 = hexdec( $rgb[1] );
			$g	 = hexdec( $rgb[2] );
			$b	 = hexdec( $rgb[3] );
		} elseif ( preg_match( "/^($d)($d)($d)$/", $hex, $rgb ) ) {

			$r	 = hexdec( $rgb[1] . $rgb[1] );
			$g	 = hexdec( $rgb[2] . $rgb[2] );
			$b	 = hexdec( $rgb[3] . $rgb[3] );
		} else {

			return false;
		}

		$brightness	 = round( $r * 299 + $g * 587 + $b * 114 ) / 1000;
		$light		 = round( 255 * 299 + 244 * 587 + 255 * 114 ) / 1000;

		if ( $brightness < $light / 2 ) {

			$color = '#ffffff';
		} else {

			$color = '#333333';
		}

		return $color;
	}

}
if ( function_exists( 'amp_init' ) ) {
	/**
	 * AMP
	 * https://wordpress.org/plugins/amp/
	 */
	add_action( 'amp_post_template_css', 'emulsion_theme_amp_css' );

	if ( ! function_exists( 'emulsion_theme_amp_css' ) ) {

		function emulsion_theme_amp_css() {

			$supports	 = false;
			$supports	 = emulsion_the_theme_supports( 'amp' );

			if ( ! $supports ) {
				return;
			}

			$get_css = file( get_theme_file_path( 'css/amp.css' ) );
			$css	 = implode( '', $get_css );

			/**
			 * @see emulsion_sanitize_css() in functions.php
			 * For sanitization, you can add any processing you need
			 */
			echo emulsion_sanitize_css( $css );
		}

	}
}

if ( ! function_exists( 'emulsion_amp_exclude_supports' ) ) {

	// AMP remove supports
	// Works if emulsion-addons plugin is disabled


	function emulsion_amp_exclude_supports( $default, $name ) {


		$remove_supports = emulsion_amp_excludes();

		if ( ! empty( $remove_supports ) && in_array( $name, $remove_supports ) ) {

			return false;
		}

		//add_filter( 'post_thumbnail_html', '__return_empty_string' );

		return $default;
	}

}

if ( ! function_exists( 'emulsion_amp_excludes' ) ) {

	function emulsion_amp_excludes() {

		$emulsion_amp_exclude_support = array( 'search_drawer', 'enqueue', 'primary_menu', 'title_in_page_header', 'instantclick', 'toc', 'tooltip', 'sidebar', 'sidebar_page' );

		return $emulsion_amp_exclude_support;
	}

}

if ( ! function_exists( 'emulsion_block_experimentals_style' ) ) {

	function emulsion_block_experimentals_style( $css ) {

		$css .= <<<CSS

		/* for experimental-custom-spacing cover block */

		body.enable-block-experimentals .wp-block-cover{
			padding:0;
		}
		body.enable-block-experimentals .wp-block-cover__inner-container{
			padding:0;
		}

CSS;
		return $css;
	}

}


if ( ! function_exists( 'emulsion_style_load_controller' ) ) {

	function emulsion_style_load_controller( $handle ) {

		global $post;

		$body_classes		 = get_body_class();
		$theme_support		 = emulsion_the_theme_supports( 'instantclick' ) ? 'enable' : 'disable';
		$theme_editor_mode	 = get_theme_mod( 'emulsion_editor_support' );

		if ( 'emulsion-fse' == $handle ) {

			$flag = emulsion_do_fse();

			return apply_filters( $handle . '-load', $flag );
		}

		if ( 'emulsion-header' == $handle ) {

			$flag = true;

			$flag = false === emulsion_metabox_display_control( 'header' ) ? false : $flag;


			return apply_filters( $handle . '-load', $flag );
		}


		if ( 'emulsion-primary-menu' == $handle ) {

			$flag = has_nav_menu( 'primary' );

			if ( ! empty( $theme_editor_mode ) && $flag ) {

				switch ( $theme_editor_mode ) {

					case 'theme':
						$flag	 = true;
						break;
					case 'experimental':
						$flag	 = true;
						break;
					case 'transitional':
						$flag	 = true;
						break;
					case 'fse':
						$flag	 = false;
						break;
					default:
						$flag	 = true;
				}
			}
			if ( 'enable' == get_theme_mod( 'emulsion_primary_menu_css_load' ) ) {

				//$flag = true;
			}

			return apply_filters( $handle . '-load', $flag );
		}


		if ( 'emulsion-block-presentation' == $handle ) {

			$flag	 = in_array( 'has-block', $body_classes );
			$flag	 = has_blocks( $post ) ? true : $flag;
			/**
			 * exception
			 * FSE needs block style
			 */
			//$flag	 = emulsion_do_fse() ? true: $flag;

			$flag = 'full_text' !== emulsion_content_type() ? false : $flag;

			return apply_filters( $handle . '-load', $flag );
		}


		if ( 'emulsion-custom-color' == $handle ) {

			$flag = emulsion_has_color_settings();

			return apply_filters( $handle . '-load', $flag );
		}


		if ( 'emulsion-boxed' == $handle ) {

			$flag = in_array( 'has-border-custom', $body_classes, true );

			return apply_filters( $handle . '-load', $flag );
		}


		if ( 'emulsion-columns' == $handle ) {

			//$flag	 = in_array( 'emulsion-has-sidebar', $body_classes, true );
			if ( is_page() ) {

				$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_page_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_page_sidebar' ) );
				$logged_in				 = 'logged_in_user' == $sidebar_condition && ! is_user_logged_in() ? false : true;
				$metabox_page_control	 = emulsion_metabox_display_control( 'page_sidebar' );

				$flag = is_active_sidebar( 'sidebar-3' ) &&
						emulsion_the_theme_supports( 'sidebar_page' ) &&
						$logged_in &&
						$metabox_page_control ? true : false;
			} else {

				$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_posts_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_posts_sidebar' ) );
				$logged_in				 = 'logged_in_user' == $sidebar_condition && ! is_user_logged_in() ? false : true;
				$metabox_post_control	 = emulsion_metabox_display_control( 'sidebar' );

				$flag = is_active_sidebar( 'sidebar-1' ) &&
						emulsion_the_theme_supports( 'sidebar' ) &&
						$logged_in &&
						$metabox_post_control ? true : false;
			}

			if ( ! empty( $theme_editor_mode ) && $flag ) {

				switch ( $theme_editor_mode ) {

					case 'theme':
						$flag	 = true;
						break;
					case 'experimental':
						$flag	 = true;
						break;
					case 'transitional':
						$flag	 = true;
						break;
					case 'fse':
						$flag	 = false;
						break;
					default:
						$flag	 = true;
				}
			}

			return apply_filters( $handle . '-load', $flag );
		}

		if ( 'emulsion-accessibility' == $handle ) {

			$flag = true;

			//Accessibility is always set for the entire site,
			//so you don't have to worry about instantClick

			return apply_filters( $handle . '-load', $flag );
		}
		if ( 'emulsion-misc' == $handle ) {

			$flag = true;

			return apply_filters( $handle . '-load', $flag );
		}


		if ( 'emulsion-archives' == $handle ) {
			$flag = false;

			if ( count( array_intersect( array( 'home', 'blog', 'archive', 'attachment' ), $body_classes ) ) != 0 ) {
				$flag = true;
			}

			//$flag	 = emulsion_do_fse() ? false: $flag;

			return apply_filters( $handle . '-load', $flag );
		}


		if ( 'emulsion-single' == $handle ) {

			$flag = false;

			if ( is_singular() ) {

				$flag = true;
			}

			//$flag	 = emulsion_do_fse() ? false: $flag;

			return apply_filters( $handle . '-load', $flag );
		}

		if ( 'emulsion-gallery' == $handle ) {

			$flag = false;

			$flag = has_block( 'gallery' ) ? true : false;

			//$flag	 = emulsion_do_fse() ? false: $flag;

			if ( false == $flag ) {

				if ( ! empty( $post ) && strpos( $post->post_content, '[gallery' ) !== false ) {
					$flag = true;
				}
			}

			return apply_filters( $handle . '-load', $flag );
		}
		if ( 'emulsion-comments' == $handle ) {

			$flag	 = false;
			$flag	 = is_singular() && comments_open() ? true : $flag;

			//$flag	 = emulsion_do_fse() ? false: $flag;

			return apply_filters( $handle . '-load', $flag );
		}
		if ( 'emulsion-responsive' == $handle ) {

			$flag	 = true;
			$flag	 = ! emulsion_theme_addons_exists() ? true : $flag;
			$flag	 = 'active' == get_theme_mod( 'emulsion_wp_scss_status' ) ? true : $flag;

			//$flag	 = emulsion_do_fse() ? false: $flag;

			return apply_filters( $handle . '-load', $flag );
		}

		if ( 'emulsion-common' == $handle ) {

			$flag = true;

			//$flag	 = emulsion_do_fse() ? false: $flag;

			return apply_filters( $handle . '-load', $flag );
		}



		if ( 'amp-reader' == $handle && emulsion_is_amp() ) {

			return apply_filters( $handle . '-load', emulsion_is_amp() );
		}

		return false;
	}

}

if ( ! function_exists( 'emulsion_has_color_settings' ) ) {

	function emulsion_has_color_settings() {

		$field_names = array(
			'emulsion_header_gradient',
			'emulsion_header_background_color',
			'emulsion_header_sub_background_color',
			'emulsion_category_colors',
			'emulsion_sidebar_background',
			'emulsion_primary_menu_background',
			'emulsion_relate_posts_bg',
			'emulsion_comments_bg',
			'emulsion_bg_image_text',
			'emulsion_bg_image_blend_color',
			'emulsion_bg_image_blend_color_amount',
			'emulsion_background_css_pattern',
			'emulsion_general_link_color',
			'emulsion_general_link_hover_color',
			'emulsion_general_text_color',
			'emulsion_get_background_color',
			'emulsion_sidebar_background_dark',
			'emulsion_sidebar_background_light',
			'emulsion_sidebar_background',
			'emulsion_hover_color_article_dark',
			'emulsion_hover_color_article_light',
			'emulsion_hover_color',
			'emulsion_link_color_gallery',
			'emulsion_link_color',
			'emulsion_the_background_color',
		);

		if ( has_filter( 'theme_mod_background_color' ) ) {

			if ( 'ffffff' !== get_background_color() ) {

				return true;
			}
		}
		if ( has_filter( 'emulsion_inline_style_pre' ) ) {
			// if custom field CSS exists
			return true;
		}

		foreach ( $field_names as $name ) {


			if ( has_filter( 'theme_mod_' . $name ) ) {

				return true;
			}

			if ( false !== get_theme_mod( $name, false ) ) {

				return true;
			}
		}

		return false;
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

					$setting_value = get_theme_mod( 'emulsion_layout_posts_page', emulsion_theme_default_val( 'emulsion_layout_posts_page' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_home():

					$setting_value = get_theme_mod( 'emulsion_layout_homepage', emulsion_theme_default_val( 'emulsion_layout_homepage' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_date():

					$setting_value = get_theme_mod( 'emulsion_layout_date_archives', emulsion_theme_default_val( 'emulsion_layout_date_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_category():

					$setting_value = get_theme_mod( 'emulsion_layout_category_archives', emulsion_theme_default_val( 'emulsion_layout_category_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_tag():

					$setting_value = get_theme_mod( 'emulsion_layout_tag_archives', emulsion_theme_default_val( 'emulsion_layout_tag_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_author():

					$setting_value = get_theme_mod( 'emulsion_layout_author_archives', emulsion_theme_default_val( 'emulsion_layout_author_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_search():

					$setting_value = get_theme_mod( 'emulsion_layout_search_results', emulsion_theme_default_val( 'emulsion_layout_search_results' ) );

					$setting_value = str_replace( 'highlight', 'excerpt', $setting_value );
					return $setting_value;
					break;
			}

			return false;
		}
	}

}

if ( ! function_exists( 'emulsion_get_third_party_block_classes' ) ) {


	function emulsion_get_third_party_block_classes() {
		global $post;

		if ( empty( $post ) ) {
			return;
		}

		$blocks	 = parse_blocks( $post->post_content );
		$result	 = array();

		foreach ( $blocks as $block ) {

			if ( ! isset( $block['blockName'] ) ) {
				continue;
			}

			$block_id = $block['blockName'];

			if ( false === strpos( $block_id, 'core/' ) ) {

				$block_id = rtrim( $block_id, '*' );

				$class_name = sprintf( 'wp-block-%1$s', str_replace( '/', '-', $block_id ) );

				$result[] = sanitize_html_class( $class_name );
			}
		}
		return $result;
	}

}

function emulsion_get_template() {

	global $template;

	$current_template_class = str_replace( '.', '-', basename( $template ) );

	$template = sanitize_html_class( $current_template_class );

	if ( 'template-canvas-php' == $template ) {
		/*
		  $filter_list = array( 'embed_template', '404_template', 'search_template',
		  'frontpage_template', 'home_template', 'privacypolicy_template',
		  'taxonomy_template', 'attachment_template', 'single_template',
		  'page_template', 'singular_template', 'category_template',
		  'tag_template', 'author_template', 'date_template',
		  'archive_template', 'index_template', ); */

		/**
		 * if set Custom Template
		 */

		$post_id		 = get_the_ID();
		$custom_template = get_post_meta( $post_id, '_wp_page_template', true );

		if ( ! empty( $custom_template ) && 'default' !== $custom_template ) {

			return  sanitize_html_class( $custom_template. '_template' );
		}

		if ( is_404() && is_readable( get_template_directory() . '/block-templates/404.html' ) ) {
			return '404_template';
		}
		if ( is_search() && is_readable( get_template_directory() . '/block-templates/search.html' ) ) {
			return 'search_template';
		}
		if ( ! is_home() && is_front_page() && is_readable( get_template_directory() . '/block-templates/front-page.html' ) ) {
			return 'front-page_template';
		}
		if ( is_home() && is_front_page() && is_readable( get_template_directory() . '/block-templates/home.html' ) ) {
			return 'home_template';
		}
		if ( is_privacy_policy() && is_readable( get_template_directory() . '/block-templates/privacy-policy.html' ) ) {
			return 'privacy-policy_template';
		}
		if ( is_tax() && is_readable( get_template_directory() . '/block-templates/taxsonomy.html' ) ) {
			return 'taxonomy_template';
		}
		if ( is_attachment() && is_readable( get_template_directory() . '/block-templates/attachment.html' ) ) {
			return 'attachment_template';
		}
		if ( is_single() && is_readable( get_template_directory() . '/block-templates/single.html' ) ) {
			return 'single_template';
		}
		if ( is_page() && is_readable( get_template_directory() . '/block-templates/page.html' ) ) {
			return 'page_template';
		}
		if ( is_singular() && is_readable( get_template_directory() . '/block-templates/singular.html' ) ) {
			return 'singular_template';
		}
		if ( is_category() && is_readable( get_template_directory() . '/block-templates/category.html' ) ) {
			return 'category_template';
		}
		if ( is_tag() && is_readable( get_template_directory() . '/block-templates/tag.html' ) ) {
			return 'tag_template';
		}
		if ( is_author() && is_readable( get_template_directory() . '/block-templates/author.html' ) ) {
			return 'author_template';
		}
		if ( is_date() && is_readable( get_template_directory() . '/block-templates/date.html' ) ) {
			return 'date_template';
		}
		if ( is_archive() && is_readable( get_template_directory() . '/block-templates/archive.html' ) ) {
			return 'archive_template';
		}

		return 'index_template';
	}
	return $template;
}

function emulsion_get_starter_content() {
	// do not function_exists check

	$template_path = get_template_directory() . '/starter-content/content.php';

	$starter_content = array(
		'posts'		 => array(
			'front' => array(
				'post_type'		 => 'page',
				'post_title'	 => esc_html_x( 'emulsion home demo', 'Theme starter content', 'emulsion' ),
				'post_content'	 => include( $template_path ),
			),
			'about',
			'contact',
			'blog',
		),
		'options'	 => array(
			'show_on_front'	 => 'page',
			'page_on_front'	 => '{{front}}',
			'page_for_posts' => '{{blog}}',
		),
		'nav_menus'	 => array(
			'primary' => array(
				'name'	 => esc_html__( 'emulsion starter demo menu', 'emulsion' ),
				'items'	 => array(
					'link_home',
					'page_about',
					'page_blog',
					'page_contact',
				),
			),
		),
			//'theme_mods' => array(),
	);
	return apply_filters( 'emulsion_starter_content', $starter_content );
}

function emulsion_theme_image_sizes_for_scss() {

	global $_wp_additional_image_sizes;

	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	$result = '';

	foreach ( $get_intermediate_image_sizes as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$result .= sprintf( '%1$s %2$s %3$s %4$s,', $_size, get_option( $_size . '_size_w' ), get_option( $_size . '_size_h' ), (bool) get_option( $_size . '_crop' ) );
		} elseif ( isset( $_wp_additional_image_sizes[$_size] ) ) {


			$result .= sprintf( '%1$s %2$s %3$s %4$s,', $_size, $_wp_additional_image_sizes[$_size]['width'], $_wp_additional_image_sizes[$_size]['height'], (bool) $_wp_additional_image_sizes[$_size]['crop'] );
		}
	}

	return trim( $result, ',' );
}

if ( ! function_exists( 'emulsion_theme_get_font_sizes' ) ) {

	/**
	 * block editor font sizes
	 * @return string
	 */
	function emulsion_theme_get_font_sizes() {

		$font_size_vals				 = get_theme_support( 'editor-font-sizes' );
		$disable_custom_font_size	 = get_theme_support( 'disable-custom-font-size' );
		$font_sizes					 = '';

		if ( isset( $font_size_vals ) && is_array( $font_size_vals ) && ! $disable_custom_font_size ) {

			foreach ( $font_size_vals[0] as $font_val ) {

				$font_sizes .= sprintf( '%1$s %2$s,', $font_val['slug'], $font_val['size'] );
			}
			$font_sizes = trim( $font_sizes, "," );
		} else {

			// gutenberg default values
			$font_sizes = "small 14,regular 16, large 36, larger 48";
		}
		return $font_sizes;
	}

}

function emulsion_block_template_part( $part ) {



	if ( ! function_exists( 'gutenberg_get_block_template' )   ) {

		printf( '<div class="error" style="%2$s">%1$s</div>', esc_html__( 'Required gutenberg plugin', 'emulsion' ), 'padding:1.5rem; text-align:center;border:1px dashed red;' );

		return;
	} else {

		$template_part = gutenberg_get_block_template( get_stylesheet() . '//' . $part, 'wp_template_part' );

		if ( ! $template_part || empty( $template_part->content ) ) {

			printf( '<div class="error" style="%2$s">%1$s</div>', esc_html__( 'Can not find template', 'emulsion' ), 'padding:1.5rem; text-align:center;border:1px dashed red;' );
			return;
		}
		if ( 'header' == $template_part->area ) {

			$classes = 'wp-block-template-part-' . sanitize_html_class( $template_part->slug ) . ' fse-header header-layer wp-block-template-part included-block-template-part';

			printf( '<%1$s class="%3$s">%2$s</%1$s>', esc_attr( $template_part->area ), do_blocks( $template_part->content ), $classes );

			return;
		}
		if ( 'footer' == $template_part->area ) {

			$classes = 'wp-block-template-part-' . sanitize_html_class( $template_part->slug ) . ' fse-footer footer-layer wp-block-template-part included-block-template-part';

			printf( '<%1$s class="%3$s">%2$s</%1$s>', esc_attr( $template_part->area ), do_blocks( $template_part->content ), $classes );

			return;
		}

		//if ( 'uncategorized' == $template_part->area ) {

		$classes = 'wp-block-template-part-' . sanitize_html_class( $template_part->slug ) . ' wp-block-template-part included-block-template';

		printf( '<%1$s class="%3$s">%2$s</%1$s>', 'div', do_blocks( $template_part->content ), $classes );

		return;
		//}
	}
}

if ( ! function_exists( 'emulsion_woocommerce_dinamic_css' ) ) {

	function emulsion_woocommerce_dinamic_css( $css ) {

		if ( emulsion_the_theme_supports( 'title_in_page_header' ) ) {

			$css .= '#document .woocommerce-page .content-area .woocommerce-products-header{ display:none;}';
		}

		return $css;
	}

}

if ( ! function_exists( 'emulsion_custom_field_css' ) ) {

	function emulsion_custom_field_css() {

		$post_id			 = absint( get_the_ID() );
		$meta_style			 = '';
		$post_type			 = get_post_type();
		$custom_css_class	 = 'has-custom-style';
		$meta_field			 = 'css';

		if ( metadata_exists( $post_type, $post_id, $meta_field ) ) {

			$meta_style = get_metadata( $post_type, $post_id, $meta_field, true );

			add_filter(
					'body_class', function( $class ) use( $custom_css_class ) {
				$class[] = $custom_css_class;
				return $class;
			} );

			$meta_style_css = preg_replace_callback( '![^}]+{[^}]+}!siu', function($matches) use($post_id) {

				$result = '';
				foreach ( $matches as $match ) {

					if ( is_singular() ) {

						if ( false === strstr( $match, 'has-custom-style' ) ) {

							$result .= sprintf( ' .postid-%1$d %2$s', $post_id, $match );
						} else {

							$result .= $match;
						}
					}
				}

				return $result;
			}, $meta_style );

			return emulsion_sanitize_css( $meta_style_css );
		}
	}

}

do_action( 'emulsion_functions_after' );
