<?php

include_once( get_theme_file_path( 'lib/conf.php' ) );
include_once( get_theme_file_path( 'lib/hooks.php' ) );
'fse' !== emulsion_get_theme_operation_mode() ? include_once( get_theme_file_path( 'lib/template-tags.php' ) ) : '';
'fse' == emulsion_get_theme_operation_mode() ? include_once( get_theme_file_path( 'lib/functions-fse.php' ) ) : '';
include_once( get_theme_file_path( 'lib/navigation-pagination.php' ) );
include_once( get_theme_file_path( 'lib/relate-posts.php' ) );
//include_once( get_theme_file_path( 'lib/customize.php' ) );
//include_once( get_theme_file_path( 'lib/blocks.php' ) );
 ! empty( wp_get_nav_menu_name( 'social' ) ) ? include_once( get_theme_file_path( 'lib/icon.php' ) ) : '';

emulsion_the_theme_supports( 'scheme' ) ? include_once( get_theme_file_path( 'scheme.php' ) ) : '';

emulsion_do_fse() ? include_once( get_template_directory() . '/lib/full_site_editor.php' ) : '';

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

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}

		do_action( 'emulsion_setup_pre' );

		load_theme_textdomain( 'emulsion', get_template_directory() . '/languages' );

		/**
		 * TGMPA
		 */
		add_action( 'tgmpa_register', 'emulsion_theme_register_required_plugins' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );

		if ( emulsion_the_theme_supports( 'custom-logo' ) && 'theme' == emulsion_get_theme_operation_mode() ) {

			add_theme_support( 'custom-logo', array(
				'height'		 => 60,
				'width'			 => 600,
				'flex-height'	 => true,
				'flex-width'	 => true,
				'header-text'	 => array( 'site-title', 'site-description' ),
			) );
		}
		if ( emulsion_the_theme_supports( 'custom-logo' ) && 'transitional' == emulsion_get_theme_operation_mode() ) {

			add_theme_support( 'custom-logo', array(
				'height'		 => 32,
				'width'			 => 32,
				'flex-height'	 => true,
				'flex-width'	 => true,
				'header-text'	 => array( 'site-title', 'site-description' ),
			) );
		}

		/**
		 * Block editor alignwide
		 */
		if ( 'enable' == get_theme_mod( 'emulsion_alignfull', emulsion_theme_default_val( 'emulsion_alignfull' ) ) ) {

			add_theme_support( 'align-wide' );
		} else {

			remove_theme_support( 'align-wide' );
		}

		if ( ! empty( $wp_version ) && version_compare( $wp_version, '5.9', '<' ) ) {

			if ( 'fse' == emulsion_get_theme_operation_mode() && ! emulsion_do_fse() ) {

				set_theme_mod( 'emulsion_editor_support', 'theme' );
			}
			if ( 'transitional' !== emulsion_get_theme_operation_mode() && ! emulsion_do_fse() ) {

				set_theme_mod( 'emulsion_editor_support', 'transitional' );
			}
		}

		/**
		 * Block editor experimental style
		 */
		/**
		 * Disable Only load styles for used blocks
		 * Currently these styles are inserted in the footer. This means more detail in the style,
		 * which has stopped working due to the issue of overwriting the style of the theme.
		 * Hope that detail issues will be resolved in the future
		 * https://make.wordpress.org/core/2021/07/01/block-styles-loading-enhancements-in-wordpress-5-8/
		 */
		'disable' == get_theme_mod( 'emulsion_should_load_separate_core_block_assets', 'disable' ) ? add_filter( 'should_load_separate_core_block_assets', '__return_false' ) : '';

		/**
		 * class="wp-container-xxxxxxxx" and inline style remove
		 *
		 */
		if ( 'disable' == get_theme_mod( 'emulsion_gutenberg_render_layout_support_flag', 'disable' ) ) {

			has_filter( 'render_block', 'gutenberg_render_layout_support_flag' ) ? remove_filter( 'render_block', 'gutenberg_render_layout_support_flag' ) : '';
			has_filter( 'render_block', 'wp_render_layout_support_flag' ) ? remove_filter( 'render_block', 'wp_render_layout_support_flag' ) : '';

			add_filter( 'render_block', 'emulsion_add_flex_container_classes', 10, 2 );
			add_filter( 'render_block', 'emulsion_add_layout_classes', 10, 2 );
			add_filter( 'render_block', 'emulsion_add_custom_gap',10,2);
		}
		/**
		 * class="wp-elements-xxxxxxxx" and inline style remove
		 */
		if ( 'disable' == get_theme_mod( 'emulsion_render_elements_support', 'disable' ) ) {

			function_exists( 'wp_render_elements_support' ) ? remove_filter( 'render_block', 'wp_render_elements_support', 10, 2 ) : '';
			function_exists( 'gutenberg_render_elements_support' ) ? remove_filter( 'render_block', 'gutenberg_render_elements_support', 10, 2 ) : '';

			add_filter( 'render_block', 'emulsion_add_link_color_class', 10, 2 );
		}
		add_action( 'admin_print_styles', function () {

			printf( '<style>%1$s</style>', '.is-presentation-theme a[href$="gutenberg-edit-site"],.is-presentation-theme a[href$="gutenberg-edit-site&styles=open"]{ display:none !important; }' );
			printf( '<style>%1$s</style>', '.is-presentation-fse a[href$="header_image"],.is-presentation-fse a[href$="background_image"]{ display:none !important; }' );
		} );

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
		if ( 'fse' !== emulsion_get_theme_operation_mode() ) {
			register_nav_menus( array(
				'primary'	 => esc_html__( 'Primary Menu', 'emulsion' ),
				'header'	 => esc_html__( 'Header Menu', 'emulsion' ),
					)
			);
		}



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
		 * @since 2.3.9 remove_theme_support() when classic theme;
		 */
		if ( 'theme' == emulsion_get_theme_operation_mode() ) {
			remove_theme_support( 'block-templates' );
		} else {
			add_theme_support( 'block-templates' );
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

			add_filter( 'theme_mod_background_color', function ( $color ) {

				return get_theme_mod( 'emulsion_background_remenber' );
			} );
		}

		add_filter( 'render_block', 'emulsion_relate_posts_when_addons_inactive', 10, 2 );

		do_action( 'emulsion_setup_after' );
	}

}

/**
 * Widget
 */
if ( ! function_exists( 'emulsion_widgets_init' ) ) {

	function emulsion_widgets_init() {

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
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

////////////////////////////////////////////////////////////

/**
 * Style and Scripts
 */
add_action( 'wp_enqueue_scripts', 'emulsion_register_scripts_and_styles' );

function emulsion_register_scripts_and_styles() {
	global $wp_scripts, $wp_version;

	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
		return;
	}

	$wp_scss_options				 = get_option( 'wpscss_options' );
	$css_dir						 = ! empty( $wp_scss_options ) ? sanitize_text_field( $wp_scss_options["css_dir"] ) : '/css/';
	$emulsion_current_data_version	 = is_user_logged_in() ? emulsion_version() : null;

	$jquery_dependency	 = array( 'jquery' );
	$jquery_dependency	 = true === version_compare( $wp_version, '5.7.0', '<' ) ? array( 'jquery', 'jquery-migrate' ) : '';
	$jquery_dependency	 = 'fse' == get_theme_mod( 'emulsion_editor_support' ) ? array() : $jquery_dependency;

	$support_instantclick	 = emulsion_the_theme_supports( 'instantclick' ) ? 'enable' : 'disable';
	$support_instantclick	 = 'enable' == get_theme_mod( 'emulsion_instantclick', $support_instantclick ) ? true : false;

	$emulsion_styles_list = array(
		'emulsion-common'				 => 'common.css',
		'emulsion-header'				 => 'header.css',
		'emulsion-archives'				 => 'archives.css',
		'emulsion-single'				 => 'single.css',
		'emulsion-block-presentation'	 => 'block-presentation.css',
		'emulsion-columns'				 => 'columns.css',
		'emulsion-accessibility'		 => 'accessibility.css',
		'emulsion-custom-color'			 => 'custom-color.css',
		'emulsion-gallery'				 => 'gallery.css',
		'emulsion-comments'				 => 'comments.css',
		'emulsion-primary-menu'			 => 'primary-menu.css',
		'emulsion-misc'					 => 'misc.css',
		'emulsion-boxed'				 => 'boxed.css',
		'emulsion-responsive'			 => 'responsive.css',
			//'emulsion-fse'					 => 'fse.css',
			//'amp-reader'					 => 'amp.css',
	);

	if ( 'html' == get_theme_mod( 'emulsion_header_template',emulsion_theme_default_val( 'emulsion_header_template', 'default') ) && get_theme_mod( 'emulsion_footer_template',emulsion_theme_default_val( 'emulsion_footer_template', 'default') ) ) {

		$exclude_stylesheets = array(
			'emulsion-header' => 'header.css',
		);

		$emulsion_theme_styles = array_keys( array_diff( $emulsion_styles_list, $exclude_stylesheets ) );
	}
	if ( false === has_nav_menu( 'primary' ) ) {
		$exclude_stylesheets = array(
			'emulsion-primary-menu' => 'primary-menu.css',
		);

		$emulsion_theme_styles = array_keys( array_diff( $emulsion_styles_list, $exclude_stylesheets ) );
	}


//////////////////////////////////////////////////////////////////////////
//	STYLE
//////////////////////////////////////////////////////////////////////////
	/**
	 * AMP plugin
	 * Do not load styles if amp plugin end point and support is reader
	 */
	$post_id				 = absint( get_the_ID() );
	$amp_meta_status_value	 = '';

	$amp_options = get_option( 'amp-options' );
	$amp_support = ! empty( $amp_options ) ? $amp_options['theme_support'] : 'amp-no-support';

	if ( metadata_exists( 'post', $post_id, 'amp_status' ) ) {

		$amp_meta_status_value = get_post_meta( $post_id, 'amp_status', true );
	}

	if ( emulsion_is_amp() ) {

		add_filter( 'emulsion_the_theme_supports', 'emulsion_amp_exclude_supports', 10, 2 );

		if ( 'disabled' !== $amp_meta_status_value  && 'theme' == get_theme_mod( 'emulsion_editor_support' ) ) {

			wp_register_style( 'emulsion', get_template_directory_uri() . '/style.css', array(), $emulsion_current_data_version, 'all' );

			false === wp_style_is( 'emulsion' ) ? wp_enqueue_style( 'emulsion' ) : '';

			$emulsion_style	 = function_exists( 'emulsion_custom_field_css' ) ? emulsion_custom_field_css( '' ) : '';
			$emulsion_style .= emulsion_amp_background_helper();
			wp_add_inline_style('emulsion', $emulsion_style);

			wp_register_style( 'amp_reader', get_theme_file_uri( $css_dir . 'amp.css' ), array(), '', 'all' );
			false === wp_style_is( 'amp_reader' ) ? wp_enqueue_style( 'amp_reader' ) : '';
		}

		if ( false == wp_style_is( 'emulsion-fse-transitional' ) && 'transitional' == get_theme_mod( 'emulsion_editor_support' ) ) {

			wp_register_style( 'emulsion-fse-transitional', get_template_directory_uri() . '/css/fse-transitional.css', array(), $emulsion_current_data_version, 'all' );

			wp_enqueue_style( 'emulsion-fse-transitional' );
			$emulsion_style	 = function_exists( 'emulsion_custom_field_css' ) ? emulsion_custom_field_css( '' ) : '';
			$emulsion_style .= emulsion_amp_background_helper();
			wp_add_inline_style( 'emulsion-fse-transitional', $emulsion_style );

		}

		return;
	}
	/**
	 * theme style.css
	 */
	wp_register_style( 'emulsion', get_template_directory_uri() . '/style.css', array(), $emulsion_current_data_version, 'all' );

	false === wp_style_is( 'emulsion' ) ? wp_enqueue_style( 'emulsion' ) : '';

	/**
	 *
	 *
	 * Filters for styles that must be used at the beginning of inline styles, such as @import rules
	 */
	$inline_style_pre = apply_filters( 'emulsion_inline_style_pre', '' ); //@charset "UTF-8";

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
	 * Register Theme Styles
	 */
	$emulsion_register_styles = $emulsion_styles_list;
	foreach ( $emulsion_register_styles as $handle => $css_file ) {

		wp_register_style( $handle, get_theme_file_uri( $css_dir . $css_file ), array(), $emulsion_current_data_version, 'all' );
	}

	/**
	 * enqueue style when instantclick enabled ( default )
	 *
	 * instantclick Always need all styles
	 */
	$emulsion_theme_styles = array_keys( $emulsion_register_styles );

	/**
	 * enqueue style when theme operation mode FSE
	 */
	if ( 'transitional' == emulsion_get_theme_operation_mode() ) {
		/**
		 * FSE Transitional
		 */
		wp_register_style( 'emulsion-fse-transitional', get_template_directory_uri() . '/css/fse-transitional.css', array(), $emulsion_current_data_version, 'all' );
		wp_enqueue_style( 'emulsion-fse-transitional' );

		if ( 'html' !== get_theme_mod( 'emulsion_header_template', emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {

			$exclude_stylesheets = array(
				'emulsion-single'		 => 'single.css',
				'emulsion-responsive'	 => 'responsive.css',
				'emulsion-comments'		 => 'comments.css',
				'emulsion-archives'		 => 'archives.css',
				'emulsion-block-presentation'	 => 'block-presentation.css',
			);
		}
		if ( 'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {

			$exclude_stylesheets = array(
				'emulsion-common'				 => 'common.css',
				'emulsion-header'				 => 'header.css',
				'emulsion-archives'				 => 'archives.css',
				'emulsion-single'				 => 'single.css',
				'emulsion-block-presentation'	 => 'block-presentation.css',
				//'emulsion-columns'				 => 'columns.css',
				//'emulsion-accessibility'		 => 'accessibility.css',
				//'emulsion-custom-color'			 => 'custom-color.css',
				'emulsion-gallery'				 => 'gallery.css',
				'emulsion-comments'				 => 'comments.css',
				'emulsion-primary-menu'			 => 'primary-menu.css',
				'emulsion-misc'					 => 'misc.css',
				'emulsion-boxed'				 => 'boxed.css',
				'emulsion-responsive'			 => 'responsive.css',
			);

		}


		$emulsion_theme_styles	 = array_keys( array_diff( $emulsion_styles_list, $exclude_stylesheets ) );


	}

	if ( true === $support_instantclick || is_search() ) {

		foreach ( $emulsion_theme_styles as $emulsion_theme_style ) {

			wp_enqueue_style( $emulsion_theme_style );
		}
	} else {

		/**
		 * If instant click is disabled, load the required stylesheet for the open page
		 */
		$enqueue_style = $emulsion_styles_list;

		foreach ( $enqueue_style as $handle => $name ) {

			emulsion_style_load_controller( $handle ) ? wp_enqueue_style( $handle ) : '';
		}
	}

	if ( is_user_logged_in() && $support_instantclick && false === wp_style_is( 'admin-bar' ) && false === wp_style_is( 'emulsion-instantclick' ) ) {

		wp_enqueue_style( 'admin-bar' );
	}


	/**
	 * Theme Inline styles
	 */
	if ( ! empty( $inline_style_pre ) ) {

		$inline_style = apply_filters( 'emulsion_inline_style', $inline_style_pre );
	} else {

		$inline_style = apply_filters( 'emulsion_inline_style', '' );
	}



		$inline_style	 = emulsion_sanitize_css( $inline_style );
		$inline_style	 = emulsion_remove_spaces_from_css( $inline_style );

		$emulsion_style	 = function_exists( 'emulsion_custom_field_css' ) ? emulsion_custom_field_css( '' ) : '';
		$emulsion_style	 .= ! is_user_logged_in() ? get_theme_mod( 'emulsion__css_variables', '' ) : '';
		$emulsion_style	 .= function_exists( 'emulsion_add_third_party_block_css' ) ? emulsion_add_third_party_block_css( '' ) : '';

	if ( 'html' !== get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {

		$emulsion_style	 .= ! emulsion_theme_addons_exists() && function_exists( 'emulsion_theme_styles' ) ? emulsion_theme_styles( '' ) : '';
		$emulsion_style	 .= function_exists( 'emulsion_woocommerce_dinamic_css' ) ? emulsion_woocommerce_dinamic_css( '' ) : '';
		$emulsion_style	 .= function_exists( 'emulsion_add_common_font_css' ) ? emulsion_add_common_font_css( '' ) : '';
		$emulsion_style	 .= function_exists( 'emulsion_heading_font_css' ) ? emulsion_heading_font_css( '' ) : '';
		$emulsion_style	 .= function_exists( 'emulsion_block_experimentals_style' ) ? emulsion_block_experimentals_style( '' ) : '';
		//Currently, AMP does not read CSS variables.
		//$emulsion_style .= function_exists( 'emulsion_add_amp_css_variables' ) ? emulsion_add_amp_css_variables( '' ) : '';
		$emulsion_style	 .= function_exists( 'emulsion_icon_svg_styles' ) ? emulsion_icon_svg_styles( '' ) : '';

	}
		$emulsion_style	 = emulsion_sanitize_css( $emulsion_style );
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

//////////////////////////////////////////////////////////////////////////
	/**
	 * LSCRIPT
	 *
	 * Lazyload
	 * Instantclick
	 * Table of contents
	 * Tooltip
	 * Localize Script
	 */
//////////////////////////////////////////////////////////////////////////


	/**
	 * jQuery in Footer when user not logged in.
	 */
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

	if ( is_child_theme() ) {

		/**
		 * Child theme script
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

	/*if ( ! emulsion_is_amp() &&
			'transitional' == emulsion_get_theme_operation_mode() &&
			'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {
		//pending
		//wp_register_script( 'emulsion-fse', get_theme_file_uri( 'js/emulsion-fse.js' ), array(), $emulsion_current_data_version, true );
		//wp_enqueue_script( 'emulsion-fse' );
	}*/
	/**
	 * Lazyload
	 */
	$support = emulsion_the_theme_supports( 'lazyload' ) ? 'enable' : 'disable';
	$support = 'disable' == get_theme_mod( 'emulsion_lazyload', $support ) ? false : true;

	if ( $support && ! emulsion_is_amp() ) {

		if ( true == WP_DEBUG ) {

			wp_register_script( 'emulsion-lazyload', get_theme_file_uri( 'js/lazyload.js' ), array( 'jquery', 'emulsion' ), $emulsion_current_data_version, true );
		} else {

			wp_register_script( 'emulsion-lazyload', get_theme_file_uri( 'js/lazyload.min.js' ), array( 'jquery', 'emulsion' ), $emulsion_current_data_version, true );
		}
		wp_enqueue_script( 'emulsion-lazyload' );

		$inline_script = apply_filters( 'emulsion_lazyload_script', "" );
		wp_add_inline_script( 'emulsion-lazyload', $inline_script );
	}

	/**
	 * Instantclick
	 */
	$support = emulsion_the_theme_supports( 'instantclick' ) ? 'enable' : 'disable';
	$support = 'disable' == get_theme_mod( 'emulsion_instantclick', $support ) ? false : true;

	if ( $support && 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_user_logged_in() && ! emulsion_is_amp() ) {

		if ( true == WP_DEBUG ) {

			wp_register_script( 'emulsion-instantclick', get_theme_file_uri( 'js/instantclick.js' ), array(), $emulsion_current_data_version, true );
		} else {

			wp_register_script( 'emulsion-instantclick', get_theme_file_uri( 'js/instantclick.min.js' ), array(), $emulsion_current_data_version, true );
		}
		wp_enqueue_script( 'emulsion-instantclick' );

		$inline_script = apply_filters( 'emulsion_instantclick_script', "" );
		wp_add_inline_script( 'emulsion-instantclick', $inline_script );
	}

	/**
	 * Table of contents
	 */
	$support = emulsion_the_theme_supports( 'toc' ) ? 'enable' : 'disable';
	$support = 'disable' == get_theme_mod( 'emulsion_table_of_contents', $support ) &&  'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) )
			? false : true;

	if ( $support && ! emulsion_is_amp()  ) {
		if ( true == is_user_logged_in() ) {

			wp_register_script( 'emulsion-toc', get_theme_file_uri( 'js/toc.js' ), array( 'jquery', 'emulsion' ), $emulsion_current_data_version, true );
		} else {

			wp_register_script( 'emulsion-toc', get_theme_file_uri( 'js/toc.min.js' ), array( 'jquery', 'emulsion' ), $emulsion_current_data_version, true );
		}
		wp_enqueue_script( 'emulsion-toc' );

		$inline_script = apply_filters( 'emulsion_toc_script', "" );
		wp_add_inline_script( 'emulsion-toc', $inline_script );
	}

	/**
	 * Tooltip
	 */
	$support = emulsion_the_theme_supports( 'tooltip' ) ? 'enable' : 'disable';
	$support = 'disable' == get_theme_mod( 'emulsion_tooltip', $support ) ? false : true;


	if ( $support &&
			! is_customize_preview() &&
			! emulsion_is_amp() && 'fse' !== get_theme_mod( 'emulsion_editor_support' ) &&
			'html' !== get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {

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




	if ( ! emulsion_is_amp() || is_customize_preview()  ) {


		if ( 'fse' !== emulsion_get_theme_operation_mode() && 'html' !== get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {

			/**
			 * if child theme has parent name.js( js/emulsion.js ) Read the file of the child theme ( for replace script )
			 */
			if ( true == is_user_logged_in() ) {

				$emulsion_js_uri	 = 'fse' !== emulsion_get_theme_operation_mode() ? get_theme_file_uri( 'js/emulsion.js' ) : get_theme_file_uri( 'js/emulsion-fse.js' );
				$jquery_dependency	 = 'fse' !== emulsion_get_theme_operation_mode() ? $jquery_dependency : array();
				wp_register_script( 'emulsion', $emulsion_js_uri, $jquery_dependency, $emulsion_current_data_version, true );
			} else {
				$emulsion_js_uri	 = 'fse' !== emulsion_get_theme_operation_mode() ? get_theme_file_uri( 'js/emulsion.min.js' ) : get_theme_file_uri( 'js/emulsion-fse.min.js' );
				$jquery_dependency	 = 'fse' !== emulsion_get_theme_operation_mode() ? $jquery_dependency : array();
				wp_register_script( 'emulsion', $emulsion_js_uri, $jquery_dependency, $emulsion_current_data_version, true );
			}

			wp_enqueue_script( 'emulsion' );
			$inline_script = apply_filters( 'emulsion_inline_script', "" );
			wp_add_inline_script( 'emulsion', $inline_script );

			/**
			 * Localize Script
			 * Note:Remember the emulsion_script_vars objects values are all embedded in string format.
			 */
			$wp_scss_status_relate_setting	 = emulsion_theme_addons_exists() ? get_theme_mod( 'emulsion_sidebar_position', emulsion_get_var( 'emulsion_sidebar_position' ) ) : get_theme_mod( 'emulsion_sidebar_position', emulsion_theme_default_val( 'emulsion_sidebar_position' ) );
			$emulsion_background_color		 = true === emulsion_theme_addons_exists() ? emulsion_the_hex2rgb( emulsion_get_background_color() ) : 'rgb(255,255,255)'; //sprintf( '#%1$s', get_background_color() );
			$instantclick_support			 = emulsion_the_theme_supports( 'instantclick' ) ? 'enable' : 'disable';

			wp_localize_script( 'emulsion', 'emulsion_script_vars', array(
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
				'meta_description'			 => function_exists( 'emulsion_meta_description' ) && ! empty( emulsion_meta_description() ) ? emulsion_meta_description() : 'none',
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
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}
		if( 'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ){
			 return;
		}
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

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}
		if( 'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ){
			 return;
		}

		$post_id = get_the_ID();

		$header_text_color	 = ! empty( get_header_textcolor() ) ? sprintf( '#%1$s', get_header_textcolor() ) : '';
		$class_name			 = '';

		if ( ! empty( $header_text_color ) ) {

			$class_name = ' has-header-text-color';
		}

		if ( 'transitional' == emulsion_get_theme_operation_mode() && false !== get_theme_mod('emulsion_header_background_color', false ) ) {
			$class_name = ' has-customizer-bg';
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

				if ( emulsion_media_display_judgment() ) {

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

	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
		return;
	}

	if( 'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ){
		 return;
	}

	$current_post_type	 = trim( get_post_type() );
	$post_id			 = get_the_ID();

	if ( has_post_thumbnail( $post_id ) &&
			! emulsion_is_amp() &&
			'yes' == get_theme_mod( 'emulsion_title_in_header', emulsion_theme_default_val( 'emulsion_title_in_header' ) &&
					'custom' == get_theme_mod( 'emulsion_header_layout', emulsion_theme_default_val( 'emulsion_header_layout' ) ) &&
					! empty( get_the_post_thumbnail() ) ) && // like woocommerce
			is_singular( array( $current_post_type ) ) &&
			! post_password_required( $post_id )
	) {

		return true;
	}
	return false;
}

if ( ! function_exists( 'emulsion_body_background_class' ) ) {

	function emulsion_body_background_class( $classes ) {
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}

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
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}

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

			$custom_border_class = get_theme_mod( 'emulsion_border_sidebar' ) || get_theme_mod( 'emulsion_border_sidebar_style' ) || get_theme_mod( 'emulsion_border_sidebar_width' ) ? 'has-border-custom' : 'border-default';

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



if ( ! function_exists( 'emulsion_layout_control' ) ) {

	/**
	 * Add html element for grid display and stream display.
	 * Using the filter, you can return the page displayed in grid format to normal display.
	 * @param type $position
	 * @param type $type
	 * @return type
	 */
	function emulsion_layout_control( $position = 'before', $type = '' ) {

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}
		if( 'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ){
			return;
		}
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

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}
		if( 'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ){
			return;
		}

		true == emulsion_the_theme_supports( 'search_drawer' ) && 'enable' == get_theme_mod( 'emulsion_search_drawer', emulsion_theme_default_val( 'emulsion_search_drawer' ) ) ? get_template_part( 'template-parts/search', 'drawer' ) : '';
	}

}

if ( ! function_exists( 'emulsion_block_editor_styles_and_scripts' ) ) {

	/**
	 * Gutenberg stylesheet for backend editor
	 */
	function emulsion_block_editor_styles_and_scripts() {

		$emulsion_current_data_version	 = WP_DEBUG ? time() : emulsion_version();
		$add_css						 = '';

		if ( current_user_can( 'edit_posts' ) ) {

			if ( 'fse' !== emulsion_get_theme_operation_mode() ) {
				wp_enqueue_style( 'emulsion-block-editor-styles', get_theme_file_uri( '/css/style-editor.css' ), array(), $emulsion_current_data_version, 'all' );

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

					$default_variables = ':root{' . EMULSION_DEFAULT_VARIABLES . '}';
					wp_add_inline_style( 'emulsion-block-editor-styles', $default_variables . $add_css );
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

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}
		if( 'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ){
			return;
	    }

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
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}
		if( 'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ){
		 return;
		}

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



if ( ! function_exists( 'emulsion_lang_cjk' ) ) {

	function emulsion_lang_cjk() {

		$locale = sanitize_text_field( get_locale() );

		if ( 'ja' == $locale || 'ko-KR' == $locale || 'zh-CN' == $locale || 'zh-TW' == $locale || 'zh-HK' == $locale ) {

			return true;
		}

		return false;
	}

}


if ( function_exists( 'amp_init' ) ) {
	/**
	 * AMP
	 * https://wordpress.org/plugins/amp/
	 */
	$amp_options = get_option( 'amp-options' );

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

		$emulsion_amp_exclude_support = array( 'search_drawer', 'enqueue', 'title_in_page_header', 'instantclick', 'toc', 'tooltip', 'primary_menu', 'sidebar', 'sidebar_page' );

		return $emulsion_amp_exclude_support;
	}

}

if ( ! function_exists( 'emulsion_block_experimentals_style' ) ) {

	function emulsion_block_experimentals_style( $css ) {

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}
		if ( 'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {
			return;
		}

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

if ( ! function_exists( 'emulsion_inline_style_load_controller' ) ) {


	function emulsion_inline_style_load_controller( $key = '' ) {


		if ( 'fse' == get_theme_mod( 'emulsion_editor_support' ) ) {

			return true;
		}

		return false;
	}

}

if ( ! function_exists( 'emulsion_style_load_controller' ) ) {

	function emulsion_style_load_controller( $handle ) {

		global $post;
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}
		if ( 'disable' !== get_theme_mod( 'emulsion_instantclick' ) ) {

			return;
		}

		$body_classes		 = get_body_class();
		$theme_support		 = emulsion_the_theme_supports( 'instantclick' ) ? 'enable' : 'disable';
		$theme_editor_mode	 = emulsion_get_theme_operation_mode();

		if ( 'emulsion-fse' == $handle ) {

			$flag = false;

			if ( 'fse' == emulsion_get_theme_operation_mode() ||
					'transitional' == emulsion_get_theme_operation_mode() ) {
				$flag = true;
				return apply_filters( $handle . '-load', $flag );
			}

			if ( 'theme' == emulsion_get_theme_operation_mode() ) {
				$flag = false;
				return apply_filters( $handle . '-load', $flag );
			}

			return apply_filters( $handle . '-load', $flag );
		}

		if ( 'emulsion-header' == $handle ) {

			$flag = 'fse' !== emulsion_get_theme_operation_mode() ? true : false;

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

			$flag = 'fse' !== get_theme_mod( 'emulsion_editor_support' ) ? emulsion_has_color_settings() : false;

			return apply_filters( $handle . '-load', $flag );
		}


		if ( 'emulsion-boxed' == $handle ) {

			$flag = in_array( 'has-border-custom', $body_classes, true );

			$flag = 'fse' !== get_theme_mod( 'emulsion_editor_support' ) ? $flag : false;

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

			$flag = 'fse' !== get_theme_mod( 'emulsion_editor_support' ) ? $flag : false;

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

			$flag = 'fse' !== get_theme_mod( 'emulsion_editor_support' ) ? $flag : false;

			return apply_filters( $handle . '-load', $flag );
		}
		if ( 'emulsion-responsive' == $handle ) {

			$flag	 = true;
			$flag	 = ! emulsion_theme_addons_exists() ? true : $flag;
			$flag	 = 'active' == get_theme_mod( 'emulsion_wp_scss_status' ) ? true : $flag;

			$flag = 'fse' !== get_theme_mod( 'emulsion_editor_support' ) ? $flag : false;

			return apply_filters( $handle . '-load', $flag );
		}

		if ( 'emulsion-common' == $handle ) {

			$flag = true;

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
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return;
		}
		if ( 'disable' !== get_theme_mod( 'emulsion_instantclick' ) ) {
			return;
		}


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

function emulsion_get_starter_content() {
	// do not function_exists check

	$template_path = get_template_directory() . '/starter-content/content.php';

	$starter_content = array(
		'posts'		 => array(
			'front' => array(
				'post_type'		 => 'page',
				'post_title'	 => esc_html_x( 'emulsion front page demo', 'Theme starter content', 'emulsion' ),
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
		'theme_mods' => array(
			'emulsion_header_template' => 'html',
			'emulsion_footer_template' => 'html',
			'emulsion_scheme' => 'midnight'
			),
		'widgets' => array(),
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

if ( ! function_exists( 'emulsion_woocommerce_dinamic_css' ) ) {

	function emulsion_woocommerce_dinamic_css( $css ) {

		if ( emulsion_inline_style_load_controller( __FUNCTION__ ) ) {

			return $css;
		}

		if ( emulsion_the_theme_supports( 'title_in_page_header' ) ) {

			$css .= '#document .woocommerce-page .content-area .woocommerce-products-header{ display:none;}';
		}

		return $css;
	}

}



add_filter( 'render_block', 'emulsion_modified_main_element', 10, 2 );

if ( ! function_exists( 'emulsion_modified_main_element' ) ) {

	/**
	 *
	 *
	 * @param type $block_content
	 * @param type $block
	 * @return text/html
	 */
	function emulsion_modified_main_element( $block_content, $block ) {

		if ( 'transitional' !== emulsion_get_theme_operation_mode() ) {

			return $block_content;
		}
		$block_name	 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$used_layout = isset( $block['attrs']['layout'] ) ? $block['attrs']['layout'] : '';

		if ( 'wp-block-template-part' == $block_name && ! empty( $block['attrs']['tagName'] ) && 'main' == $block['attrs']['tagName'] ) {

			//Why simple replacement is right: The main element is a special element that appears only once in the document

			$block_content = str_replace( array( '<main ', '</main>' ), array( '<div ', '</div>' ), $block_content );
		}

		return $block_content;
	}

}


add_filter( 'render_block', 'emulsion_posted_on_classes', 10, 2 );

if ( ! function_exists( 'emulsion_posted_on_classes' ) ) {

	/**
	 *
	 *
	 * @param type $block_content
	 * @param type $block
	 * @return text/html
	 */
	function emulsion_posted_on_classes( $block_content, $block ) {
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $block_content;
		}

		if ( 'theme' == emulsion_get_theme_operation_mode() ) {

			return $block_content;
		}

		// The bio setting is true for enable, but string C for disable. Why ?

		$block_name					 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$author_bio_setting			 = ! empty( $block["innerBlocks"][1]["blockName"]['attr']["showBio"] ) && is_bool( $block["innerBlocks"][1]["blockName"]['attr']["showBio"] ) && true == $block["innerBlocks"][1]["blockName"]['attr']["showBio"] ? true : false;
		$block_has_posted_on_class	 = ! empty( $block['attrs']['className'] ) && false !== strstr( $block['attrs']['className'], 'posted-on' ) ? true : false;

		if ( 'wp-block-group' == $block_name && $block_has_posted_on_class && $author_bio_setting ) {

			$new_class		 = array( 'has-author-bio' );
			$block_content	 = emulsion_add_class( $block_content, $block_name, $new_class );
		}

		return $block_content;
	}

}

add_filter( 'render_block', 'emulsion_modify_cjk_excerpt', 10, 2 );

if ( ! function_exists( 'emulsion_modify_cjk_excerpt' ) ) {

	/**
	 * CJK language excerpt
	 * For languages that don't use spaces between words, we'll add an excerpt feature based on the number of characters.
	 *
	 * @param type $block_content
	 * @param type $block
	 * @return text/html
	 */
	function emulsion_modify_cjk_excerpt( $block_content, $block ) {

		if ( 'theme' == emulsion_get_theme_operation_mode() ) {

			return $block_content;
		}

		// The bio setting is true for enable, but string C for disable. Why ?

		$block_name	 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$is_lang_cjk = emulsion_lang_cjk();

		if ( 'wp-block-post-excerpt' == $block_name && $is_lang_cjk ) {

			$emulsion_cjk_excerpt_length = apply_filters( 'emulsion_cjk_excerpt_length', emulsion_theme_default_val( 'emulsion_excerpt_length' ) );
			$emulsion_cjk_excerpt_more	 = apply_filters( 'emulsion_cjk_excerpt_more', '...' );
			$new_excerpt				 = wp_html_excerpt( $block_content, $emulsion_cjk_excerpt_length, $emulsion_cjk_excerpt_more );

			return sprintf( '<div class="wp-block-post-excerpt"><p class="wp-block-post-excerpt__excerpt">%1$s</p></div>', $new_excerpt );
		}


		return $block_content;
	}

}
if ( ! function_exists( 'emulsion_amp_background_helper' ) ) {

	function emulsion_amp_background_helper() {

		$background_color	 = sprintf( '#%1$s', get_background_color() );
		$banner_background	 = get_theme_mod( 'emulsion_header_background_color', 'transparent' );

		if ( empty( sanitize_hex_color( $background_color ) ) ) {
			return;
		}
		$css = <<<STYLE

			[amp] .custom-background{
				background:{$background_color};
			}
			[amp] .header-layer ~ .footer-layer,
			.header-layer{
				background:{$banner_background};
			}
			[amp] .header-is-dark ~ .footer-layer a,
			[amp] .header-is-dark ~ .footer-layer,
			[amp] .header-is-dark a,
			[amp] .header-is-dark,
		    [amp] .custom-background.is-dark .layout a,
			[amp] .custom-background.is-dark .layout{
				color:#fff;
			}
			[amp] .header-is-light ~ .footer-layer a,
			[amp] .header-is-light ~ .footer-layer,
			[amp] .header-is-light a,
			[amp] .header-is-light,
			[amp] .custom-background.is-light .layout a,
			[amp] .custom-background.is-light .layout{
				color:#333;
			}
			[amp] .footer-layer,
			[amp] .relate-content-wrapper{
				background:rgba(0,0,0,.1);
				color:currentColor;
			}
			[amp] .emulsion .layout li.has-post-thumbnail .post-header a,
			[amp] .emulsion .layout li.has-post-thumbnail .post-header{
				color:#fff;

			}
STYLE;
		return $css;
	}

}

//add_filter('emulsion_site_text_markup', '__return_empty_string');




do_action( 'emulsion_functions_after' );