<?php
/**
 * enqueue style and script
 */
emulsion_add_supports( 'enqueue' );

emulsion_add_supports( 'primary_menu' );
/**
 * Search drawer
 */

emulsion_add_supports( 'search_drawer' );
get_theme_mod('emulsion_search_drawer', emulsion_get_var('emulsion_search_drawer') ) == 'disable' ? emulsion_remove_supports( 'search_drawer' ) : '';

/**
 * Search keyword highlight
 */

emulsion_add_supports( 'search_keyword_highlight' );
get_theme_mod( 'emulsion_layout_search_results', emulsion_get_var('emulsion_layout_search_results') ) == 'full_text' ? emulsion_remove_supports( 'search_keyword_highlight' ) : '';

/**
 * Sidebar
 */

emulsion_add_supports( 'sidebar' );
emulsion_add_supports( 'sidebar_page' );



/**
 * Footer
 */

//emulsion_add_supports( 'footer', array( 'cols' => 4 ) );
emulsion_add_supports( 'footer' );
emulsion_add_supports( 'footer_page' );
//emulsion_customizer_add_supports_footer();

/**
 * Alignfull
 */

emulsion_add_supports( 'alignfull' );
get_theme_mod( 'emulsion_alignfull', emulsion_get_var('emulsion_alignfull') ) == 'disable' ? emulsion_remove_supports( 'alignfull' ) : '';

/**
 * Layout
 */



/**
 * Title
 */

emulsion_add_supports( 'title_in_page_header' );
get_theme_mod( 'emulsion_title_in_header', emulsion_get_var('emulsion_title_in_header') ) == 'no' ? emulsion_remove_supports( 'title_in_page_header' ) : '';

/**
 * Table of contents
 */

emulsion_add_supports( 'toc' );
get_theme_mod( 'emulsion_table_of_contents', emulsion_get_var('emulsion_table_of_contents') ) == 'disable' ? emulsion_remove_supports( 'toc' ) : '';

/**
 * Header
 */

emulsion_add_supports( 'header', array(
		'default' => array(
			'default-text-color' => '#333333',
			'width'				 => 0,
			'flex-width'		 => true,
			'height'			 => 0,
			'flex-height'		 => true,
			'header-text'		 => true,
			'default-image'		 => '',
			'wp-head-callback'	 => apply_filters( 'emulsion_wp_head_callback', '' ),
		),
	)
);

get_theme_mod( 'emulsion_page_header', emulsion_get_var('emulsion_page_header') ) == 'remove' ? emulsion_remove_supports( 'header' ) : '';

/**
 * Background
 */

emulsion_add_supports( 'background' , array( 
		'default' => array(
			'default-color'	=> 'ffffff',
			'default-image' => '',
			'default-preset'         => 'default',
			'default-position-x'     => 'left',
			'default-position-y'     => 'top',
			'default-size'           => 'auto',
			'default-repeat'         => 'repeat',
			'default-attachment'     => 'scroll',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		),
	) 
);

/**
 * Custom Logo
 */

emulsion_add_supports( 'custom-logo' , array( 
		'default' => array(
			'height'		 => 60,
			'width'			 => 600,
			'flex-height'	 => true,
			'flex-width'	 => true,
			'header-text'	 => array( 'site-title', 'site-description' ),
		),
	) 
);

/**
 * SVG
 * include footer
 */

emulsion_add_supports( 'social-link-menu');

emulsion_add_supports( 'footer-svg');

/**
 * Excerpt
 */

emulsion_add_supports( 'excerpt' );
$all_custom_post_types = get_post_types( array( '_builtin' => false ) );

//is_post_type_archive( $all_custom_post_types ) ? emulsion_remove_supports( 'excerpt' ) : '';

function remove_excerpt_post_type(){
	

	
}
remove_excerpt_post_type();

/**
 * relate posts
 */

emulsion_add_supports( 'relate_posts' );
get_theme_mod( 'emulsion_relate_posts', emulsion_get_var( 'emulsion_relate_posts' ) ) == 'disable' ? emulsion_remove_supports( 'relate_posts' ) : '';

/**
 * Tooltip
 */

emulsion_add_supports( 'tooltip' );
get_theme_mod( 'emulsion_tooltip', emulsion_get_var( 'emulsion_tooltip' ) ) == 'disable' ? emulsion_remove_supports( 'tooltip' ) : '';

/**
 * AMP
 */

emulsion_add_supports( 'amp' ); //https://wordpress.org/plugins/amp/

/**
 * utility
 */

emulsion_add_supports( 'entry_content_html_cleaner' );

/**
 * sectionize
 */

emulsion_add_supports( 'block_sectionize' ); // gutenberg block wrap with section elements

/**
 * background pattern
 */

emulsion_add_supports( 'background_css_pattern' ); // gutenberg block wrap with section elements

/**
 * Plugin TGMPA
 */
emulsion_add_supports( 'TGMPA' );

if ( ! is_admin() && ! is_customize_preview() && ! is_user_logged_in() && empty( $_GET ) ) {

	emulsion_add_supports( 'instantclick' );
	get_theme_mod( 'emulsion_instantclick', emulsion_get_var( 'emulsion_instantclick' ) ) == 'disable' ? emulsion_remove_supports( 'instantclick' ) : '';

	emulsion_add_supports( 'lazyload' );
	get_theme_mod( 'emulsion_lazyload', emulsion_get_var( 'emulsion_lazyload' ) ) == 'disable' ? emulsion_remove_supports( 'lazyload' ) : '';
}

if ( ! function_exists( 'amp_init' ) ) {

	emulsion_remove_supports( 'amp' );
}

