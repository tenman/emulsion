<?php

if ( 'fse' !== emulsion_get_theme_operation_mode() ) {
	return;
}

add_action( 'after_setup_theme', 'emulsion_setup' );

if ( ! function_exists( 'emulsion_setup' ) ) {

	function emulsion_setup() {
		do_action( 'emulsion_setup_pre' );

		load_theme_textdomain( 'emulsion', get_template_directory() . '/languages' );

		/**
		 * TGMPA
		 */
		add_action( 'tgmpa_register', 'emulsion_theme_register_required_plugins' );

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

			add_theme_support( 'disable-layout-styles' );

			add_filter( 'render_block', 'emulsion_add_flex_container_classes', 10, 2 );
			add_filter( 'render_block', 'emulsion_block_group_variation_classes', 10, 2 );
			add_filter( 'render_block', 'emulsion_add_layout_classes', 10, 2 );
			add_filter( 'render_block', 'emulsion_add_custom_gap', 10, 2 );
			add_filter( 'render_block', 'emulsion_add_spacing', 10, 2 );
		} else {
			remove_filter( 'render_block', 'emulsion_add_flex_container_classes', 10, 2 );
			remove_filter( 'render_block', 'emulsion_block_group_variation_classes', 10, 2 );
			remove_filter( 'render_block', 'emulsion_add_layout_classes', 10, 2 );
			remove_filter( 'render_block', 'emulsion_add_custom_gap', 10, 2 );
			remove_filter( 'render_block', 'emulsion_add_spacing', 10, 2 );
			remove_theme_support( 'disable-layout-styles' );
		}

		/**
		 * class="wp-elements-xxxxxxxx" and inline style remove
		 */
		if ( 'disable' == get_theme_mod( 'emulsion_render_elements_support', 'disable' ) ) {

			function_exists( 'wp_render_elements_support' ) ? remove_filter( 'render_block', 'wp_render_elements_support', 10, 2 ) : '';
			function_exists( 'gutenberg_render_elements_support' ) ? remove_filter( 'render_block', 'gutenberg_render_elements_support', 10, 2 ) : '';

			add_filter( 'render_block', 'emulsion_add_link_color_class', 10, 2 );
			add_filter( 'render_block', 'emulsion_add_link_hover_class', 10, 2 );
		}
		add_action( 'admin_print_styles', function () {

			printf( '<style>%1$s</style>', '.is-presentation-theme a[href$="gutenberg-edit-site"],.is-presentation-theme a[href$="gutenberg-edit-site&styles=open"]{ display:none !important; }' );
			printf( '<style>%1$s</style>', '.is-presentation-fse a[href$="header_image"],.is-presentation-fse a[href$="background_image"]{ display:none !important; }' );
		} );

		if ( emulsion_is_plugin_active( 'gutenberg/gutenberg.php' ) ) {

			add_theme_support( 'custom-spacing' );
			add_theme_support( 'experimental-link-color' );
		}

		add_filter( 'render_block_core/query', 'archive_pages_header_auto_alignment', 10, 2 );

		add_filter( 'emulsion_toc_script', 'emulsion_toc_fse' );

		add_filter( 'emulsion_instantclick_script', 'emulsion_instantclick' );
		add_filter( 'body_class', 'emulsion_fse_body_class' );

		add_filter( 'admin_body_class', 'emulsion_fse_admin_body_class' );

		add_filter( 'get_the_author_description', 'emulsion_author_description', 20 );
		add_filter( 'the_password_form', 'emulsion_get_the_password_form', 11 );
		add_filter( 'render_block_post_content', 'emulsion_entry_content_filter', 11 );

		if ( 'enable' == get_theme_mod( 'emulsion_gutenberg_render_layout_support_flag' ) ) {

			add_theme_support( 'wp-block-styles' );
		}

		/**
		 * Fresh installation date
		 */
		$fresh_installation = get_theme_mod( 'fresh_installation', false );

		if ( false === $fresh_installation ) {

			set_theme_mod( 'fresh_installation', time() );
		}
		/**
		 * Plugin Settings relate
		 */
		add_action( 'wp_footer', 'emulsion_theme_google_tracking_code', 99 );

		/**
		 *
		 */
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'emulsion' )
				)
		);

		do_action( 'emulsion_setup_after' );
	}

}

function emulsion_author_description( $text ) {

	return nl2br( $text );
}

/**
 * Style and Scripts
 */
add_action( 'wp_enqueue_scripts', 'emulsion_register_scripts_and_styles_fse' );

function emulsion_register_scripts_and_styles_fse() {
	global $wp_scripts, $wp_version;

	$emulsion_current_data_version	 = is_user_logged_in() ? time() : null;
	$inline_style					 = apply_filters( 'emulsion_fse_inline_style', emulsion_fse_inline_style() );
	if ( 'enable' !== get_theme_mod( 'emulsion_gutenberg_render_layout_support_flag', emulsion_theme_default_val( 'emulsion_gutenberg_render_layout_support_flag' ) ) ) {

		wp_register_style( 'emulsion-fse', get_template_directory_uri() . '/css/fse.css', array(), $emulsion_current_data_version, 'all' );
		wp_enqueue_style( 'emulsion-fse' );

		wp_add_inline_style( 'emulsion-fse', $inline_style );
	} else {

		wp_register_style( 'emulsion-fse-layout-on', get_template_directory_uri() . '/css/fse-layout-on.css', array(), $emulsion_current_data_version, 'all' );
		wp_enqueue_style( 'emulsion-fse-layout-on' );

		wp_add_inline_style( 'emulsion-fse-layout-on', $inline_style );
	}

	wp_register_style( 'emulsion-patterns', get_template_directory_uri() . '/css/patterns.css', array(), $emulsion_current_data_version, 'all' );
	wp_enqueue_style( 'emulsion-patterns' );

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

		wp_register_style( $emulsion_child_theme_slug, get_template_directory_uri() . '/css/patterns.css', array(), $emulsion_current_data_version, 'all' );
		wp_enqueue_style( $emulsion_child_theme_slug );

		$inline_style	 = apply_filters( $emulsion_child_theme_slug . '_inline_style', "/* emulsion " . $emulsion_current_data_version . "*/" );
		$inline_style	 = emulsion_remove_spaces_from_css( $inline_style );

		wp_add_inline_style( $emulsion_child_theme_slug, $inline_style );
	}

	//////////////////////////////////////////////////////////////////////////
	/**
	 * SCRIPT
	 * Table of contents
	 */
	//////////////////////////////////////////////////////////////////////////
	$jquery_dependency = array( 'jquery' );
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

	/**
	 * Instantclick
	 */
	//$support = emulsion_the_theme_supports( 'instantclick' ) ? 'enable' : 'disable';
	$support = 'disable' == get_theme_mod( 'emulsion_instantclick' ) ? false : true;

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
	 * Load only if the single-with-toc template is used
	 */
	//$support = emulsion_the_theme_supports( 'toc' ) ? 'enable' : 'disable';
	//$support = 'enable' == get_theme_mod( 'emulsion_table_of_contents', $support ) ? true : false;

	$post_id		 = get_the_ID();
	$template_slug	 = get_page_template_slug( $post_id );
	$support		 = 'single-with-toc' == $template_slug ? true : false;

	if ( $support && ! emulsion_is_amp() ) {
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
	 * if child theme has parent name.js( js/emulsion.js ) Read the file of the child theme ( for replace script )
	 */
	if ( ! emulsion_is_amp() ) {
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
	}
	$emulsion_dark_mode_support_val = 'enable' == get_theme_mod( 'emulsion_dark_mode_support' ) ? true : false;

	wp_localize_script( 'emulsion', 'emulsion_script_vars', array(
		'emulsion_dark_mode_support' => $emulsion_dark_mode_support_val,
		'emulsion_body_id'			 => emulsion_slug(),
	) );
}

function emulsion_fse_body_class( $classes ) {

	$classes[] = 'emulsion';

	$classes[] = 'is-presentation-fse';

	if ( ! is_page() && ! is_attachment() && ! is_single() ) {

		$classes[] = 'summary';
	}

	$post_id = get_the_ID();

	if ( is_singular() ) {

		if ( has_blocks() ) {

			$classes[] = 'has-block';
		}
		if ( ! has_blocks() && ! empty( get_post( $post_id )->post_content ) ) {

			//The front page,blog page usually have no content, so no-block breaks the layout then

			$classes[] = 'no-block';
		}

		$post_content = get_post( $post_id )->post_content;
		// Now Test

		if ( false !== strstr( $post_content, 'emulsion-base-layout-apply-globaly' ) ) {
			$classes[] = 'has-emulsion-base-layout-apply-globaly';
		}
	}

	if ( emulsion_is_custom_post_type() ) {

		$classes[] = 'post-type-custom';
	} else {

		$classes[] = 'post-type-default';
	}
	if ( emulsion_theme_addons_exists() ) {

		$classes[] .= ' emulsion-addons-active';
	} else {

		$classes[] .= ' emulsion-addons-inactive';
	}
	$classes[] = 'is-tpl-' . emulsion_get_template();

	if ( strstr( emulsion_get_template(), '-php' ) ) {
		$classes[] = 'is-php-template';
	}
	// fse background class
	$classes[] = emulsion_fse_background_color_class();

	if ( is_singular() ) {

		$post_id = get_the_ID();
		$content = get_post( $post_id )->post_content;
		// remove block comments
		$content = trim( preg_replace( '#<![^>]*>#', '', $content ) );
		// maybe first element
		$content = strstr( $content, '/', true );

		if ( preg_match( '!^<([^>]*)?\balignwide\b([^>]*)?>!m', $content ) ) {
			$classes[] = 'keep-align-wide';
		} elseif ( preg_match( '!^<[^>]*\balignfull\b[^>]*>!m', $content ) ) {
			$classes[] = 'keep-align-full';
		}
	}
	if (false !== strstr( emulsion_get_template(), '-php' ) && ( emulsion_the_theme_supports( 'sidebar' ) || emulsion_the_theme_supports( 'sidebar_page' ) ) ) {

		if ( is_page() ) {

			unset( $classes['emulsion-no-sidebar'] );
			unset( $classes['emulsion-has-sidebar'] );

			$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_page_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_page_sidebar' ) );
			$metabox_page_control	 = emulsion_metabox_display_control( 'page_sidebar' );

			$classes[] = is_active_sidebar( 'sidebar-3' ) &&
					emulsion_the_theme_supports( 'sidebar_page' ) &&
					$metabox_page_control ? ' emulsion-has-sidebar' : ' emulsion-no-sidebar';
		} else {

			unset( $classes['emulsion-no-sidebar'] );
			unset( $classes['emulsion-has-sidebar'] );

			$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_posts_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_posts_sidebar' ) );
			$metabox_post_control	 = emulsion_metabox_display_control( 'sidebar' );

			$classes[] = is_active_sidebar( 'sidebar-1' ) &&
					emulsion_the_theme_supports( 'sidebar' ) &&
					$metabox_post_control ? ' emulsion-has-sidebar' : ' emulsion-no-sidebar';
		}
	}


	return $classes;
}

function emulsion_fse_admin_body_class( $classes ) {

	$classes .= ' emulsion';
	$classes .= ' ' . emulsion_fse_background_color_class();
	$classes .= ' is-presentation-fse';

	if ( isset( $_GET['postId'] ) ) {

		$template = get_post_meta( absint( $_GET['postId'] ), '_wp_page_template', true );
		if ( strstr( $template, '.php' ) ) {
			$classes .= ' is-php-template';
		}
	}
	return $classes;
}

function custom_load_separate_theme_block_assets() {

	$styles = array( 'archives', 'audio', 'blocks', 'buttons', 'calendar', 'categories', 'code', 'columns', 'comment-content', 'comment-date',
		'comment-edit-link', 'comment-reply-link', 'comment-template', 'comments-author-avatar', 'comments-author-name', 'commentspagination-next',
		'comments-pagination-next', 'comments-pagination-numbers', 'comments-pagination-previous', 'comments-pagination', 'comments-query-loop',
		'cover', 'embed', 'file', 'freeform', 'gallery', 'group', 'heading', 'home-link', 'html', 'image', 'latest-comments', 'latest-posts',
		'list', 'media-text', 'missing', 'more', 'navigation-area', 'navigation-link', 'navigation-submenu', 'navigation', 'next-page', 'page-list',
		'paragraph', 'pattern', 'post-author-name', 'post-author', 'post-comment-author', 'post-comment-content', 'post-comment-date',
		'post-comments-count', 'post-comments-form', 'post-comments-link', 'post-comments', 'post-content', 'post-date', 'post-excerpt',
		'post-featured-image', 'post-navigation-link', 'post-template', 'post-terms', 'post-title', 'preformatted', 'pullquote',
		'query-pagination-next', 'query-pagination-numbers', 'query-pagination-previous', 'query-pagination', 'query-title', 'query',
		'quote', 'rss', 'search', 'separator', 'shortcode', 'site-logo', 'site-tagline', 'site-title', 'social-link', 'social-links',
		'spacer', 'table', 'tag-cloud', 'template-part', 'term-description', 'text-columns', 'verse', 'video', 'post-author-biography', 'avatar', 'loginout' );

	foreach ( $styles as $block ) {
		wp_enqueue_block_style(
				'core/' . $block,
				array(
					'handle' => 'theme-' . $block,
					'src'	 => get_theme_file_uri( 'css/' . $block . '.css' ),
					'path'	 => get_theme_file_path( 'css/' . $block . '.css' ),
				)
		);
	}
}

// only debug purpus
//add_action( 'after_setup_theme', 'custom_load_separate_theme_block_assets' );

add_filter( 'render_block', 'emulsion_fallback_block_class', 10, 2 );

function emulsion_corrected_core_css_has_nested_images_gallery() {

	/**
	 * Excessive specificity makes styling in the block editor difficult.
	 * not(#individual-image)
	 * :not does not participate in specificity, but the ID in parentheses is included in the specificity calculation

	  @media (min-width: 600px)
	  .wp-block-gallery.has-nested-images.columns-default figure.wp-block-image:not(#individual-image) {
	  margin-right: var(--gallery-block--gutter-size, 16px);
	  width: calc(33.33% - (var(--gallery-block--gutter-size, 16px) * 0.6666666667));
	  }
	 */
	$css = <<<STYLE

	.has-nested-images:not(#specificity).alignleft {
		float: left;
		clear: left;
	}

	.has-nested-images:not(#specificity).alignright {
		float: right;
		clear: right;
	}

	.has-nested-images:not(#specificity).alignfull {
		width: var(--wp--custom--width--full, 100%);
			max-width:100%;
			margin:0 auto;

	}

	.has-nested-images:not(#specificity).wp-block-gallery {
		display: flex;
		gap: var(--wp--style--block-gap, 3px);
	}

	.has-nested-images:not(#specificity).wp-block-gallery > figure.wp-block-image:not(.specificity){
		margin: 0;
		padding: 0;
	}
	.has-nested-images:not(#specificity).wp-block-gallery.columns-1 .wp-block-image {
		width: 100%;
	}
	.has-nested-images:not(#specificity).wp-block-gallery.columns-2 .wp-block-image {
		width: calc(100% / 2 - var(--wp--style--block-gap, 3px));
	}
	.has-nested-images:not(#specificity).wp-block-gallery.columns-default .wp-block-image,
	.has-nested-images:not(#specificity).wp-block-gallery.columns-3 .wp-block-image {
		width: calc(100% / 3 - var(--wp--style--block-gap, 3px));
	}
	.has-nested-images:not(#specificity).wp-block-gallery.columns-4 .wp-block-image {
		width: calc(100% / 4 - var(--wp--style--block-gap, 3px));
	}
	.has-nested-images:not(#specificity).wp-block-gallery.columns-5 .wp-block-image {
		width: calc(100% / 5 - var(--wp--style--block-gap, 3px));
	}
	.has-nested-images:not(#specificity).wp-block-gallery.columns-6 .wp-block-image {
		width: calc(100% / 6 - var(--wp--style--block-gap, 3px));
	}
	.has-nested-images:not(#specificity).wp-block-gallery.columns-7 .wp-block-image {
		width: calc(100% / 7 - var(--wp--style--block-gap, 3px));
	}
	.has-nested-images:not(#specificity).wp-block-gallery.columns-8 .wp-block-image {
		width: calc(100% / 8 - var(--wp--style--block-gap, 3px));
	}
STYLE;
	return $css;
}

function emulsion_add_classic_custom_field_css() {

	/**
	 * Add Classic Custom Field CSS
	 */
	$css = <<<STYLE
	#newmeta,
	#newmeta thead,
	#newmeta thead tr,
	#newmeta thead th,
	#newmeta tbody,
	#newmeta tbody tr,
	#newmeta tbody td,
	.edit-post-meta-boxes-area.is-side  #list-table thead,
	.edit-post-meta-boxes-area.is-side  #list-table thead th,
	 .edit-post-meta-boxes-area.is-side  #list-table thead tr,
	.edit-post-meta-boxes-area.is-side  #list-table tbody,
	.edit-post-meta-boxes-area.is-side  #list-table tbody tr,
	.edit-post-meta-boxes-area.is-side  #list-table tbody tr td{
		display:block;

	}
		.edit-post-meta-boxes-area.is-side .inside #newmeta thead th,
	.edit-post-meta-boxes-area.is-side .inside #list-table thead th,
	.edit-post-meta-boxes-area.is-side .inside #list-table tbody tr #newmetaleft,
	.edit-post-meta-boxes-area.is-side .inside #list-table tbody tr td.left{
		width:100%;
		display:block;
	}
	#newmeta,
	#postcustom .inside{
		padding:0;
	}
	#postcustom .inside td{
		padding:0;
	}
STYLE;
	return $css;
}

function emulsion_add_narrow_align_css() {

	/**
	 * narrow alignleft alignright
	 */
	$css = <<<STYLE

div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-categories.alignleft, div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-archives.alignleft,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-page-list.alignleft, div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-latest-comments.alignleft {
	 box-sizing: border-box;
	 float: left;
	 width: 320px;
	 max-width: 100%;
	 margin-right: 1rem;
	 margin-left: var(--wp--custom--padding--content, 0.75rem);
	 clear: left;
}
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-categories.alignleft .alignleft, div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-archives.alignleft .alignleft,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-page-list.alignleft .alignleft, div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-latest-comments.alignleft .alignleft,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-categories.alignleft .alignright, div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-archives.alignleft .alignright,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-page-list.alignleft .alignright, div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-latest-comments.alignleft .alignright {
	 float: none;
	 width: 100%;
	 max-width: 100%;
	 margin-right: 0;
	 margin-left: 0;
}
 @media screen and (max-width: 640px) {
	div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-categories.alignleft,
	div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-archives.alignleft,
	div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-page-list.alignleft,
	div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-latest-comments.alignleft {
		 width: 100%;
		 max-width: 100%;
		 padding-left: clamp(2rem, calc(100vw / 36), calc(40px + var(--wp--custom--padding--content,.75rem)));
		 margin: 1.5rem auto;
	}
}

 div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-categories.alignright,
	div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-archives.alignright,
	div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-page-list.alignright,
	div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-latest-comments.alignright {
	 box-sizing: border-box;
	 float: right;
	 width: 320px;
	 max-width: 100%;
	 margin-right: var(--wp--custom--padding--content, 0.75rem);
	 margin-left: 1rem;
	 clear: right;
}
 div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-categories.alignright .alignleft,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-archives.alignright .alignleft,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-page-list.alignright .alignleft,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-latest-comments.alignright .alignleft,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-categories.alignright .alignright,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-archives.alignright .alignright,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-page-list.alignright .alignright,
div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-latest-comments.alignright .alignright {
	 float: none;
	 width: 100%;
	 max-width: 100%;
	 margin-right: 0;
	 margin-left: 0;
}
 @media screen and (max-width: 640px) {
	 div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-categories.alignright,
	div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-archives.alignright,
	div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-page-list.alignright,
	div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-latest-comments.alignright {
		 width: 100%;
		 max-width: 100%;
		 padding-left: clamp(2rem, calc(100vw / 36), calc(40px + var(--wp--custom--padding--content,.75rem)));
		 margin: 1.5rem auto;
	}
}

 div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block-latest-comments {
	 margin-left: auto;
	 box-sizing: border-box;
}

STYLE;
	return $css;
}

function emulsion_add_misc_css() {
	/**
	 * Add Custom field CSS
	 */
	$post_id = get_the_ID();
	$css	 = get_post_meta( $post_id, 'css', true );

	$message = esc_html__( 'If you set the content to 100%, all child elements can be displayed in a fluid layout( only front end )', 'emulsion' );

	$css .= <<<STYLE

		ul.block-editor-block-list__block .block-list-appender{
					width:24px;
		}
		.block-editor-block-breadcrumb{
			width:auto;
		}
		.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .fse-header{
			margin:0 auto;
		}
		.block-editor-hooks__layout-controls-helptext:after{
			content:'{$message}';
			display:block;
			border-left:2px solid green;
			padding-left:1rem;
			margin-top:1rem;

		}
		.editor-styles-wrapper *{
			max-width:100%!important;
		}

STYLE;
	return $css;
}

if ( ! function_exists( 'emulsion_fse_scheme_pack_midnight_eiditor_style' ) ) {

	function emulsion_fse_scheme_pack_eiditor_style() {

		$style	 = emulsion_get_css_variables_value( '--wp--custom--color--scheme' );
		$css	 = '';

		if ( 'pack' == $style ) {

			$css = <<<pack
		.editor-styles-wrapper .article-wrapper article:not(.loop-item){
			/* singular page */
			background:#fff;
			color:#000;
		}
		.editor-styles-wrapper .loop-item{
			background:rgba(255,255,255,.7);
			transition:all .5s ease-in-out;
				}
		.editor-styles-wrapper .loop-item:hover{
				background:rgba(255,255,255,1);
			}

pack;
		}
		return $css;
	}

}
if ( ! function_exists( 'emulsion_fse_scheme_pack_midnight_eiditor_style' ) ) {

	function emulsion_fse_scheme_pack_midnight_eiditor_style() {

		$style	 = emulsion_get_css_variables_value( '--wp--custom--color--scheme' );
		$css	 = '';

		if ( 'pack-midnight' == $style ) {

			$css = <<<pack
		.editor-styles-wrapper .article-wrapper article:not(.loop-item){
			/* singular page */
                color: #fff;
                background-color: #000;
		}
		.editor-styles-wrapper .loop-item{
			background:rgba(0,0,0,.7);
			transition:all .5s ease-in-out;
				}
		.editor-styles-wrapper .loop-item:hover{
				background:rgba(0,0,0,1);
		}
pack;
		}
		return $css;
	}

}
if ( ! function_exists( 'emulsion_editor_color_scheme_correction' ) ) {

	function emulsion_editor_color_scheme_correction() {

		$global_styles = '';

		$css = <<<STYLE
		.editor-styles-wrapper .wp-block-comments-pagination-numbers a{
			padding:.375rem .75rem;
		}
		.editor-styles-wrapper .is-style-tategaki {
			flex-direction: row-reverse;
			display: flex;
			flex-wrap: wrap;
			padding: 0 0.75rem;
			gap: 0;
	   }
		.editor-styles-wrapper .is-style-tategaki [style*="vertical-rl"]:lang(ja) {
			flex: 0 0 auto;
			width: auto;
			display: inline-block;
			text-align: left;
			text-indent: 1rem;
			margin: 0;
			margin-block: 0.1875rem;
			padding: 0.75rem;
			padding-block: 0;
			box-sizing: content-box;
			max-height: 25rem;
	   }
		.editor-styles-wrapper .is-style-tategaki h1[style*="vertical-rl"]:lang(ja),
		.editor-styles-wrapper .is-style-tategaki h2[style*="vertical-rl"]:lang(ja),
		.editor-styles-wrapper .is-style-tategaki h3[style*="vertical-rl"]:lang(ja),
		.editor-styles-wrapper .is-style-tategaki h4[style*="vertical-rl"]:lang(ja),
		.editor-styles-wrapper .is-style-tategaki h5[style*="vertical-rl"]:lang(ja),
		.editor-styles-wrapper .is-style-tategaki h4[style*="vertical-rl"]:lang(ja) {
			margin-block: 0.75rem;
			text-indent: 0;
	   }
		.editor-styles-wrapper [style*="vertical-rl"]:lang(ja) {
			width: auto;
			max-height: 360px;
			margin: 0;
			margin-block: auto;
			padding: 0.75rem;
			padding-block: 0;
	   }
		.editor-styles-wrapper .wp-block-cover a,
		.editor-styles-wrapper .wp-block-cover{
			--wp--custom--color--palette-contrast:#000;
			color:#000;

		}
		.is-dark-theme .wp-block-cover a,
		.is-dark-theme .wp-block-cover{
			--wp--custom--color--palette-contrast:#fff;
			color:#fff;
		}
		.fse-header .wp-block-cover{
			background:var(--wp--preset--color--base-banner);
			color:var(--wp--preset--color--contrast-banner);
		}
		.editor-styles-wrapper .wp-block-post-navigation-link,
		.editor-styles-wrapper [type="submit"],
		.editor-styles-wrapper .wp-element-button,
		.editor-styles-wrapper .wp-block-post-excerpt__more-text a,
		.editor-styles-wrapper .wp-block-read-more,
		.editor-styles-wrapper .logged-out.editor-styles-wrapper .wp-block-loginout a,
		.editor-styles-wrapper .logged-in.editor-styles-wrapper .wp-block-loginout a,
		.editor-styles-wrapper .wp-block-comments-pagination-numbers a,
		.editor-styles-wrapper .wp-block-comments-pagination-numbers span,
		.editor-styles-wrapper .wp-block-comments-pagination-next,
		.editor-styles-wrapper .wp-block-comments-pagination-previous,
		.editor-styles-wrapper .comment-edit-link,
		.editor-styles-wrapper .comment-reply-link,
		.editor-styles-wrapper .wp-block-comment-edit-link a,
		.editor-styles-wrapper .is-style-list-style-inline li,
		.editor-styles-wrapper .form-submit [type="submit"],
		.editor-styles-wrapper .wp-block-file__button,
		.editor-styles-wrapper .wp-block-button__link,
		.editor-styles-wrapper .wp-block-query-pagination a,
		.editor-styles-wrapper .post-navigation-link-previous a,
		.editor-styles-wrapper .post-navigation-link-next a,
		.editor-styles-wrapper .wp-block-post-navigation-link{
				color:var(--wp--custom--color--button-text);
				background:var(--wp--custom--color--button-bg);
		}

		.editor-styles-wrapper li > ul,
		.editor-styles-wrapper li > ol{
			margin:0;
		}
		.editor-styles-wrapper .is-root-container .wp-block-group.is-nowrap > *{
				width:-moz-fit-content;
				width:fit-content;
				margin:0;
		}
		.editor-styles-wrapper .is-layout-constrained > [style*="margin"]{
			width:auto;
		}
		.edit-site-table-wrapper th,
		.edit-site-table-wrapper td{
				border:none;
		}
		.editor-styles-wrapper .wp-block-cover.wp-block-template-part-header-content.rich-header{
			width:100%;
		}
		.editor-styles-wrapper .wp-block-template-part.fse-header{
			width:100%;
		}
		.editor-styles-wrapper .alignleft{
			width:var(--wp--custom--width--float);
			max-width:100%;
			margin:var(--wp--custom--margin--alignleft);

		}
		.editor-styles-wrapper .alignleft.size-thumbnail{
			width:var(--wp--custom--width--thumbnail-float);
			max-width:100%;
			margin:var(--wp--custom--margin--alignleft);
			text-align:right;
		}
		.editor-styles-wrapper .alignright{
			width:var(--wp--custom--width--float);
			max-width:100%;
			margin:var(--wp--custom--margin--alignright);
		}
		.editor-styles-wrapper .alignright.size-thumbnail{
			width:var(--wp--custom--width--thumbnail-float);
			max-width:100%;
			margin:var(--wp--custom--margin--alignright);
			text-align:left;
		}
		.editor-styles-wrapper .alignleft.size-thumbnail .components-resizable-box__container img{
				margin-right:0;
		}
		.editor-styles-wrapper .alignright.size-thumbnail .components-resizable-box__container img{
				margin-left:0;
		}
		.editor-styles-wrapper .alignnone,
		.editor-styles-wrapper .wp-block{
			width: var(--wp--style--global--content-size);
			 max-width: 100%;
		}
		.editor-styles-wrapper .aligncenter {
			 width: var(--wp--custom--width--aligncenter);
			 max-width: 100%;
			 margin: var(--wp--custom--margin--block);
			 clear: both;
		}
		 .editor-styles-wrapper .aignwide {
			 width: var(--wp--style--global--wide-size);
			 max-width: 100%;
			 margin: var(--wp--custom--margin--block);
		}
		 .editor-styles-wrapper .aignfull {
			 width: var(--wp--custom--width--full);
			 max-width: 100%;
			 margin: var(--wp--custom--margin--container);
		}
		.editor-styles-wrapper .wp-block-archives{

		}
		.editor-styles-wrapper div:not([class]):not([style]){
			width:100%;
		}

		.editor-styles-wrapper div.wp-block-term-description{
			margin-bottom:1.5rem;
			padding-left:.75rem;
		}
		.editor-styles-wrapper .is-layout-flex{
			display:flex;
			gap:var(--wp--style--block-gap, 0.75rem);
		}
		.editor-styles-wrapper .wp-block-comments-pagination-numbers,
		.editor-styles-wrapper .wp-block-comments-pagination-next,
		.editor-styles-wrapper .wp-block-comments-pagination-previous,
		.editor-styles-wrapper .wp-block-comment-reply-link,
		.editor-styles-wrapper .wp-block-comment-edit-link{
			width:-moz-fit-content;
			width:fit-content;
			align-items: center;
		}
		.editor-styles-wrapper .wp-block-comments-pagination.block-editor-block-list__layout{
			box-sizing:border-box;
			padding:0 0 0 0;
			margin:var(--wp--custom--margin--container);
			overflow:hidden;
		}
		.editor-styles-wrapper .wp-block{
			margin-left:auto;
			margin-right:auto;
		}
		.editor-styles-wrapper .file-not-found {
			 min-height: var(--wp--custom--min-height--harf);
		}
		 .editor-styles-wrapper .wp-block-post-content {
			 min-height: var(--wp--custom--min-height--one-third);
		}
		.editor-styles-wrapper .is-root-container > *{
			margin-left:auto;
			margin-right:auto;
		}
		.editor-styles-wrapper .column-toc ol {
			padding-top: 0;
			margin-top: 0;
	   }
		.editor-styles-wrapper .column-toc ol ol {
			padding-left: 0.75rem;
	   }
		.editor-styles-wrapper .column-toc ol .toc-active:marker {
			color: red;
	   }
		/** * Since the site editor has changed to iframe, the style for the site editor is duplicated * WordPress 6.2 */
		/** * name: core/gallery */
		.editor-styles-wrapper {
		   /** * name: core/group */
		   /** * name: core/post-excerpt */
	   }
		.editor-styles-wrapper figure.wp-block-gallery {
			display: flex;
	   }
		.editor-styles-wrapper .is-root-container > .is-layout-flex.is-content-justification-left > * {
			margin-left: 0;
	   }
		.editor-styles-wrapper .is-root-container > .is-layout-flex.is-content-justification-right > * {
			margin-right: 0;
	   }
		.editor-styles-wrapper .alignfull {
			width: var(--wp--custom--width--full);
	   }
		.editor-styles-wrapper .wp-block-post-excerpt__excerpt {
			display: -webkit-box;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: normal;
			-webkit-line-clamp: var(--wp--custom--max-height--excerpt-lines);
			-webkit-box-orient: vertical;
			width: min(100%, var(--wp--style--global--content-size));
			margin-top: 0;
	   }
		.editor-styles-wrapper .post-header-content{
			flex-direction:column;
		}
		.editor-styles-wrapper .post-header-content .wp-block-post-title {
			flex-basis:100%;
		}
		.editor-styles-wrapper .post-header-content .wp-block-post-date {
			width: auto;
			margin: 0;
			display: inline-block;
	   }
		.editor-styles-wrapper .post-header-content .wp-block-post-author {
			width: auto;
			margin: 0;
	   }
		.editor-styles-wrapper .post-header-content .wp-block-template-part.taxsonomy {
			margin: 0 auto;
			flex-basis:100%;
	   }
		.editor-styles-wrapper .wp-block-table > table{
			//OW
			margin: 0 auto;
		}

		/** * name: core/post-featured-image * for full site editor */
		 .editor-styles-wrapper .is-root-container .wp-block-post-featured-image {
			 margin-top: 1.5rem;
		}
		.editor-styles-wrapper .wp-block-post-excerpt__excerpt {
			 display: -webkit-box;
			 overflow: hidden;
			 text-overflow: ellipsis;
			 white-space: normal;
			 -webkit-line-clamp: var(--wp--custom--max-height--excerpt-lines);
			 -webkit-box-orient: vertical;
		}
		.editor-styles-wrapper .wp-block-cover-image.is-light .wp-block-cover__inner-container,
		.editor-styles-wrapper .wp-block-cover.is-light .wp-block-cover__inner-container{
			color:revert;
		}
		.editor-styles-wrapper .rich-header	.wp-block-site-logo,
		.editor-styles-wrapper .rich-header	.wp-block-site-title,
		.editor-styles-wrapper .rich-header	.wp-block-site-tagline{
			margin:var(--wp--custom--margin--block) !important;
			display:block;
		}
		.editor-styles-wrapper .fse-header .fse-header-content {
			padding-top: 1.5rem;
			padding-bottom: 1.5rem;
			margin: 0 auto;
	   }
		.editor-styles-wrapper .is-root-container > p.wp-block-site-tagline:not(.specificity):not(.specificity){
				/* OW */
			margin: var(--wp--custom--margin--block, 1.5rem auto);
			width: var(--wp--style--global--content-size);
		}
		.editor-styles-wrapper .is-root-container > .wp-block-site-title{
			margin-left:auto;
			margin-right:auto;
		}
		.editor-styles-wrapper .fse-header .fse-header-content .wp-block-site-title {
			margin-bottom: 0;
			margin-left: 0;
			margin-top:0;
			text-transform: var(--wp--custom--text-transform--heading);
	   }
		.editor-styles-wrapper .fse-header .fse-header-content .wp-block-site-tagline {
			margin-top: 0;
			margin-left: 0;
	   }
		.editor-styles-wrapper .is-root-container .wp-block-group.fse-header-content {
			 display: flex;
			 flex-wrap: wrap;
			 gap: var(--wp--style--block-gap, 0.75rem);
			 --wp--style--block-gap: var(--wp--custom--margin--gap, 0.75rem);
			 flex-direction: row;
			 flex-wrap: nowrap;
			 align-items: center;
			 justify-content: flex-start;
		}
		 .editor-styles-wrapper .is-root-container .wp-block-group.fse-header-content .columns-default {
			 flex-wrap: nowrap;
		}
		 .editor-styles-wrapper .is-root-container .wp-block-group.fse-header-content.is-nowrap {
			 flex-wrap: nowrap;
		}
		 .editor-styles-wrapper .is-root-container .wp-block-group.fse-header-content .fse-header-text {
			 display: flex;
			 flex-wrap: wrap;
			 gap: 0;
			 --wp--style--block-gap: var(--wp--custom--margin--gap, 0.75rem);
			 flex-direction: column;
			 align-items: flex-start;
			 margin: 0;
		}
		 .editor-styles-wrapper .is-root-container .wp-block-group.fse-header-content .fse-header-text .columns-default {
			 flex-wrap: nowrap;
		}
		 .editor-styles-wrapper .is-root-container .wp-block-group.fse-header-content .fse-header-text.is-nowrap {
			 flex-wrap: nowrap;
		}
		 .editor-styles-wrapper .is-root-container .wp-block-group.fse-header-content .wp-block-site-title {
			 width: auto;
		}
		 .editor-styles-wrapper .is-root-container .wp-block-group.fse-header-content .wp-block-site-logo:not(#specificity) {
			 width: -moz-fit-content;
			 width: fit-content;
			 padding-left: var(--wp--preset--spacing--40);
		}
		 .editor-styles-wrapper .is-root-container > .wp-block-group.is-layout-flex:not(.is-vertical):not(.is-nowrap):not(.items-justified-space-between) > *:nth-child(1):nth-last-child(2) {
			 width: calc(100% - min( 30vw, var(--wp--custom--width--sidebar)));
			 overflow: hidden;
		}
		 .editor-styles-wrapper .is-root-container > .wp-block-group.is-layout-flex:not(.is-vertical):not(.is-nowrap):not(.items-justified-space-between) > *:nth-child(1):nth-last-child(2) .wp-block-site-logo {
			 width: -moz-fit-content;
			 width: fit-content;
			 padding-left: var(--wp--preset--spacing--40);
		}
		.editor-styles-wrapper ul.wp-block-post-template {
			 margin-left: auto;
		}
		 .editor-styles-wrapper ul.wp-block-post-template li {
			 padding: 0;
		}
		.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper {
			width: var(--wp--style--global--content-size);
			margin: auto;
	   }
		.editor-styles-wrapper .posted-on, .editor-styles-wrapper .wp-block-post-title {
			flex-basis: 100%;
	   }
		body.editor-styles-wrapper .wp-block-query .wp-block-query-pagination, body.editor-styles-wrapper .pattern-sticky-posts .wp-block-query-pagination {
			 margin: var(--wp--custom--margin--block);
		}
		 body.editor-styles-wrapper .posted-on > div {
			 display: inline-flex;
			 vertical-align: bottom;
		}
		 body.editor-styles-wrapper .posted-on > div.wp-block-post-author {
			 align-items: baseline;
			 justify-content: center;
		}
		 body.editor-styles-wrapper .posted-on > div.taxonomy {
			 height: auto;
		}
		 body.editor-styles-wrapper .posted-on > div .wp-block-post-author__content {
			 width: -moz-fit-content;
			 width: fit-content;
		}
		 body.editor-styles-wrapper .posted-on > div .wp-block-post-author__content .wp-block-post-author__name {
			 display: inline;
			 margin: 0;
			 vertical-align: bottom;
		}
		 body.editor-styles-wrapper .posted-on > div.wp-block-template-part-taxsonomy {
			 display: block;
			 height: auto;
			 padding: 0 var(--wp--custom--padding--content, 0.75rem);
		}
		.editor-styles-wrapper .wp-block-navigation {
			width: 100%;
			padding-top: 0.75rem;
			padding-bottom: 0.75rem;
	   }
		.editor-styles-wrapper .wp-block-navigation .wp-block-navigation-item {
			width: -moz-fit-content;
			width: fit-content;
			min-width: 0;
	   }
		.editor-styles-wrapper .wp-block-navigation .block-list-appender {
			width: auto;
	   }
		.editor-styles-wrapper .wp-block-navigation .wp-block-search {
			width: auto;
	   }
		.editor-styles-wrapper .wp-block-navigation .wp-block-navigation-item__content {
			padding-left: var(--wp--preset--spacing--40);
			padding-right: var(--wp--preset--spacing--40);
	   }
		.editor-styles-wrapper .wp-block-navigation__responsive-container-content > * {
			width: -moz-fit-content;
			width: fit-content;
	   }
		.editor-styles-wrapper .wp-block-page-list{
			flex-wrap: wrap;
		}
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide {
			width: auto;
			margin-left: auto !important;
			margin-right: auto !important;
	   }
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide > *:not(.alignfull) {
			width: var(--wp--style--global--wide-size, 57.5rem);
			margin-left: auto !important;
			margin-right: auto !important;
	   }
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .archive-title,
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .post-header-content,
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .fse-header-content,
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .wp-block-comment-template .wp-block-columns,
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .wp-block-comment-template,
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .wp-block-post-featured-image img {
			width: var(--wp--style--global--wide-size, 57.5rem);
	   }
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .wp-block-query-title,
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .post-footer,
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .wp-block-comments-title,
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .taxsonomy,
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .posted-on,
		.editor-styles-wrapper .wp-block-template-part.is-style-layout-wide .wp-block-post-title {
			width: auto;
	   }
		.editor-styles-wrapper .wp-block-navigation__responsive-container-content > *,
			.wp-block-navigation__responsive-container-content > * {
			width: fit-content;
	   }
		.editor-styles-wrapper .single-with-toc-columns{
			margin:var(--wp--custom--margin--container);
			gap:var(--wp--custom--margin--gap);
		}
		.editor-styles-wrapper .is-layout-flex .fse-column main > div > ul,
		.editor-styles-wrapper .is-layout-flex.fse-columns,
		.editor-styles-wrapper div:where(.wp-site-blocks) > *{
			margin-block-start:0;
			margin-top:0;
		}
		.editor-styles-wrapper p.wp-block-site-tagline:not(.specificity):not(.specificity){
			margin:0;
			width:auto;
		}
		.editor-styles-wrapper .wp-block-post-excerpt__excerpt{
			display: -webkit-box;
			overflow:hidden;
			text-overflow: ellipsis;
			white-space: normal;
			-webkit-line-clamp: var(--wp--custom--max-height--excerpt-lines);
			-webkit-box-orient: vertical;
        }
		.editor-styles-wrapper h1,
		.editor-styles-wrapper h2{
			font-family: var(--wp--preset--font-family--heading);
			font-weight: var(--wp--custom--font-weight--heading, initial);
		}
		.editor-styles-wrapper header.wp-block-template-part-header-singular,
		.editor-styles-wrapper .is-root-container > footer{
			background:var(--wp--preset--color--base-banner);
		}
		.editor-styles-wrapper .is-root-container > main [data-type="core/query"],
		.editor-styles-wrapper .is-root-container > main,
		.editor-styles-wrapper .is-root-container > header .wp-block-cover{
		    margin:0 auto;
		}

		.editor-styles-wrapper .fse-footer p{
			margin:1.5rem auto;
		}
		.editor-styles-wrapper .rich-header .wp-block-site-title{
			font-size: clamp(var(--wp--preset--font-size--extra-large), calc(100vw / 72 * 3), var(--wp--preset--font-size--huge));
			margin:1.5rem auto;
		}
		.editor-styles-wrapper .edit-site-style-book__example-title{
			white-space:pre;
		}
		.editor-styles-wrapper .fse-footer{
			min-height: var(--wp--custom--min-height--eighth, 12.5vh);
			width:100%;
			margin:0 auto;
			-webkit-box-sizing: border-box;
			box-sizing: border-box;
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			-ms-flex-direction: column;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			-webkit-box-pack: center;
			-webkit-box-align: center;
			-ms-flex-align: center;
			-ms-flex-pack: center;
		}

		body.editor-styles-wrapper div.wp-block-site-logo{
			margin:0;
			width:-moz-fit-content;
			width:fit-content;
		}
		body.editor-styles-wrapper .rich-header .wp-block-site-logo{
			margin:0 auto;
		}
		.editor-styles-wrapper:where(body) .wp-block.wp-block-query,
		.editor-styles-wrapper:where(body) .wp-block.main-query{
			width:100%;
		}
		.editor-styles-wrapper .wp-block.alignwide{
			width:var(--wp--style--global--wide-size);
		}
		.editor-styles-wrapper .wp-block.alignfull{
			width:100%;
		}
		.editor-styles-wrapper ul.wp-block-post-template.alignfull{
			margin-left:auto;
			padding-left:var(--wp--custom--padding--content);
		}
		.editor-styles-wrapper .comment-wrapper,
		.editor-styles-wrapper .page article.page,
		.editor-styles-wrapper .article-wrapper article.post,
		.editor-styles-wrapper .wp-block-column.main > main.wp-block-group{
			width:100%;
		}
		.editor-styles-wrapper .relate-posts-wrapper{
			margin:auto;
		}
		.editor-styles-wrapper .components-placeholder:not(#spacificity) {
			margin-left:auto!important;
			margin-right:auto!important;
		}
		.editor-styles-wrapper .is-layout-flex.fse-header-text{
			justify-content: flex-start;
		}
		.editor-styles-wrapper .wp-block-group{
			overflow:hidden;
		}

		.editor-styles-wrapper .wp-block-group.taxsonomy > div{
			margin:auto;
		}

STYLE;

		return $css;
	}

}
if ( ! function_exists( 'emulsion_toc_fse' ) ) {

	function emulsion_toc_fse( $script ) {

		$script = "jQuery('.toc').toc({'scrollToOffset':64, 'container':'.entry-content','anchorName': function(i, heading, prefix) { return prefix+'-'+i;},})";
		return $script;
	}

}

if ( ! function_exists( 'emulsion_get_template_type' ) ) {

	function emulsion_get_template_type( $template_name = '' ) {
		global $template;

		$current_template = empty( $template_name ) ? $template : $template_name;

		if ( false !== strstr( $current_template, '.php' ) && false === strstr( $current_template, 'template-canvas' ) ) {

			return 'php';
		}

		return 'html';
	}

}

if ( ! function_exists( 'emulsion_pattern_custom_layout_inline_css' ) ) {

	function emulsion_pattern_custom_layout_inline_css() {
		$post_id		 = emulsion_get_current_post_id();
		$post_content	 = get_post( $post_id )->post_content;

		$blocks = parse_blocks( $post_content );

		if ( ! empty( $blocks[0]['attrs']['className'] ) && 'emulsion-pattern-custom-layout' == $blocks[0]['attrs']['className'] ) {

			$content_size	 = $blocks[0]['attrs']['layout']["contentSize"];
			$wide_size		 = $blocks[0]['attrs']['layout']["wideSize"];

			$css = <<<CSS

		.has-emulsion-pattern-custom-layout{
			--wp--style--global--content-size:$content_size;
			--wp--style--global--wide-size:$wide_size;
		}

CSS;
			add_filter( 'body_class', function ( $classes ) {
				$remove_class = [ 'keep-align-wide', 'keep-align-full' ];
				return array_diff( $classes, $remove_class );
			}, 20 );

			return $css;
		}
	}

}

if ( ! function_exists( 'emulsion_base_layout_apply_globaly_css' ) ) {

	function emulsion_base_layout_apply_globaly_css() {


		$post_id = emulsion_get_current_post_id();

		if ( 0 === $post_id ) {
			return '';
		}

		$post_content	 = get_post( $post_id )->post_content;
		$blocks			 = parse_blocks( $post_content );
		$css			 = '';

		if ( ! empty( $blocks[0]['attrs']['className'] ) && false !== strpos( $blocks[0]['attrs']['className'], 'emulsion-base-layout-apply-globaly' ) ) {

			$content_size	 = ! empty( $blocks[0]['attrs']['layout']["contentSize"] ) ? $blocks[0]['attrs']['layout']["contentSize"] : '';
			$wide_size		 = ! empty( $blocks[0]['attrs']['layout']["wideSize"] ) ? $blocks[0]['attrs']['layout']["wideSize"] : '';

			if ( ! empty( $content_size ) ) {
				$css = <<<CSS

		.has-emulsion-base-layout-apply-globaly{
			--wp--style--global--content-size:$content_size;
			--wp--style--global--wide-size:$wide_size;
		}

CSS;
			}
			add_filter( 'body_class', function ( $classes ) {
				$remove_class = [ 'keep-align-wide', 'keep-align-full' ];
				return array_diff( $classes, $remove_class );
			}, 20 );

			return $css;
		}
	}

}



if ( ! function_exists( 'archive_pages_header_auto_alignment' ) ) {

	function archive_pages_header_auto_alignment( $block_content, $block ) {

		$post_id				 = emulsion_get_current_post_id();
		$content_size			 = ! empty( $block['attrs']['layout']["contentSize"] ) ? $block['attrs']['layout']["contentSize"] : '';
		$wide_size				 = ! empty( $block['attrs']['layout']["wideSize"] ) ? $block['attrs']['layout']["wideSize"] : '';
		$emulsion_additional_css = '';
		//
		if ( ! empty( $content_size ) && 0 === $post_id ) {

			$emulsion_additional_css = <<<CSS
		.main-query-has-custom-content-width .fse-header > *,
		.main-query-has-custom-content-width .fse-footer > *{
			--wp--style--global--content-size:$content_size;
			--wp--style--global--wide-size:$wide_size;
		}
CSS;

			add_filter( 'emulsion_fse_inline_style', function ( $styles ) use ( $emulsion_additional_css ) {

				return $styles . $emulsion_additional_css;
			} );

			add_filter( 'body_class', function ( $classes ) {
				$classes[]		 = "main-query-has-custom-content-width";
				$remove_class	 = [ 'keep-align-wide', 'keep-align-full' ];
				return array_diff( $classes, $remove_class );
			}, 20 );
		}

		return $block_content;
	}

}

add_filter( 'render_block_core/post-content', 'emulsion_post_content_has_custom_content_width', 10, 2 );

function emulsion_post_content_has_custom_content_width( $block_content, $block ) {
	$post_id				 = emulsion_get_current_post_id();
	$content_size			 = ! empty( $block['attrs']['layout']["contentSize"] ) ? $block['attrs']['layout']["contentSize"] : '';
	$wide_size				 = ! empty( $block['attrs']['layout']["wideSize"] ) ? $block['attrs']['layout']["wideSize"] : '';
	$emulsion_additional_css = '';

	//&& false === strpos($block['attrs']['className'],'emulsion-pattern-custom-layout')
	if ( ! empty( $content_size ) && 0 !== $post_id ) {

		$emulsion_additional_css = <<<CSS

		.post-content-has-custom-content-width:not(.has-emulsion-base-layout-apply-globaly) .wp-block-post-featured-image img,
		.post-content-has-custom-content-width:not(.has-emulsion-base-layout-apply-globaly) .post-header-content,
		.post-content-has-custom-content-width:not(.has-emulsion-base-layout-apply-globaly) .wp-block-post-navigation,
		.post-content-has-custom-content-width:not(.has-emulsion-base-layout-apply-globaly) .post-footer > *,
		.post-content-has-custom-content-width:not(.has-emulsion-base-layout-apply-globaly) .fse-header > *,
		.post-content-has-custom-content-width:not(.has-emulsion-base-layout-apply-globaly) .fse-footer > *{
			--wp--style--global--content-size:$content_size;
			--wp--style--global--wide-size:$wide_size;
		}
CSS;

		add_filter( 'emulsion_fse_inline_style', function ( $styles ) use ( $emulsion_additional_css ) {

			return $styles . $emulsion_additional_css;
		} );
		add_filter( 'body_class', function ( $classes ) {
			$classes[] = "post-content-has-custom-content-width";
			return $classes;
		}, 20 );
	}
	// link text decode
	$block_content = emulsion_entry_content_filter( $block_content );


	return $block_content;
}
