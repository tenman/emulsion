<?php

add_action( 'after_setup_theme', 'emulsion_fse_compatible_classic_template_setup' );

if ( ! function_exists( 'emulsion_fse_compatible_classic_template_setup' ) ) {

	function emulsion_fse_compatible_classic_template_setup() {

		load_theme_textdomain( 'emulsion', get_template_directory() . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery' ) );

		add_action( 'wp_head', 'emulsion_meta_elements' );

		function_exists( 'emulsion_theme_google_tracking_code' ) ? add_action( 'wp_footer', 'emulsion_theme_google_tracking_code' ) : '';

		add_theme_support( 'widgets' );

		if ( 'fse' !== emulsion_get_theme_operation_mode() ) {

			set_theme_mod( 'emulsion_editor_support', 'fse' );
		}
	}

}

add_action( 'wp_enqueue_scripts', 'emulsion_classic' );

if ( ! function_exists( 'emulsion_classic' ) ) {

	function emulsion_classic() {


		$dependency_style = 'disable' == get_theme_mod( 'emulsion_gutenberg_render_layout_support_flag', 'disable' ) ? array( 'emulsion-fse' ) : array( 'emulsion-fse-layout-on' );

		wp_register_style(
				'emulsion-classic',
				get_template_directory_uri() . '/fse-compatible-classic-template/classic.css',
				$dependency_style,
				wp_get_theme()->get( 'Version' )
		);
		wp_enqueue_style( 'emulsion-classic' );

		if ( is_child_theme() ) {

			$emulsion_child_theme_slug	 = emulsion_slug() . '-classic';
			$child_classic_url			 = get_stylesheet_directory_uri() . '/fse-compatible-classic-template/classic.css';
			$child_classic_path			 = get_stylesheet_directory() . '/fse-compatible-classic-template/classic.css';

			if ( is_readable( $child_classic_path ) ) {
				wp_register_style(
						$emulsion_child_theme_slug,
						$child_classic_url,
						array( 'emulsion-classic' ),
						wp_get_theme()->get( 'Version' )
				);
				wp_enqueue_style( $emulsion_child_theme_slug );
			}
		}
	}

}

add_action( 'widgets_init', 'emulsion_fse_compatible_classic_template_widgets_init' );

if ( ! function_exists( 'emulsion_fse_compatible_classic_template_widgets_init' ) ) {

	function emulsion_fse_compatible_classic_template_widgets_init() {

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
		//Gutenberg widget area remove
		unregister_sidebar( 'primary-widget-area' );
		unregister_sidebar( 'secondary-widget-area' );
		unregister_sidebar( 'first-footer-widget-area' );
		unregister_sidebar( 'second-footer-widget-area' );
		unregister_sidebar( 'third-footer-widget-area' );
		unregister_sidebar( 'fourth-footer-widget-area' );
		unregister_sidebar( 'footer-1' );
		unregister_sidebar( 'footer-2' );
		unregister_sidebar( 'footer-3' );
		unregister_sidebar( 'footer-4' );
		unregister_sidebar( 'sidebar-2' );
	}

}
//var_dump( wp_get_sidebars_widgets());
/**
 * Change the php template loading to the classic directory.
 *
 * If you are using a child theme, it will not read from the parent theme's classic directory.
 *
 * @param type $template
 * @return type
 */
add_filter( 'template_include', 'emulsion_compatible_classic_template_include', 30 );

if ( ! function_exists( 'emulsion_compatible_classic_template_include' ) ) {

	function emulsion_compatible_classic_template_include( $template ) {

		$post_id			 = get_the_ID();
		$page_template_slug	 = get_page_template_slug( $post_id );

		$classic_template = emulsion_custom_template_include( $template );

		if ( is_child_theme() ) {

			$emulsion_child_theme_slug	 = emulsion_slug();
			$rename_before				 = DIRECTORY_SEPARATOR . 'emulsion' . DIRECTORY_SEPARATOR;
			$rename_after				 = DIRECTORY_SEPARATOR . $emulsion_child_theme_slug . DIRECTORY_SEPARATOR;

			$child_template = str_replace( $rename_before, $rename_after, $classic_template );

			if ( is_readable( $child_template ) ) {

				$classic_template = $child_template;
			}
		}

		if ( is_readable( $classic_template ) && 'template-canvas.php' !== basename( $classic_template ) ) {

			add_filter( 'body_class', function ( $classes ) use ( $classic_template ) {

				$classes[] = esc_attr( 'fse-conpatible-template-' . str_replace( '.', '-', basename( $classic_template ) ) );
				return $classes;
			} );

			return $classic_template;
		}

		return $template;
	}

}