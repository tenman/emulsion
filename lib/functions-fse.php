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

			add_filter( 'render_block', 'emulsion_add_flex_container_classes', 10, 2 );
			add_filter( 'render_block', 'emulsion_add_layout_classes', 10, 2 );
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
		true === emulsion_the_theme_supports( 'toc' ) ? add_filter( 'emulsion_toc_script', 'emulsion_toc' ) : '';

		add_filter( 'emulsion_instantclick_script', 'emulsion_instantclick' );
		add_filter( 'body_class', 'emulsion_fse_body_class' );
		add_filter( 'admin_body_class', 'emulsion_fse_admin_body_class' );

		add_filter( 'render_block_core/template-part', 'emulsion_fse_footer_content_filter', 10, 2 );
		add_filter( 'render_block_core/post-title', 'emulsion_accesible_post_title_link_control', 10, 2 );
		add_filter( 'render_block_core/site-title', 'emulsion_accesible_site_title_link_control', 10, 2 );

		/**
		 * Plugin Settings relate
		 */
		add_action( 'wp_footer', 'emulsion_theme_google_tracking_code', 99 );

		do_action( 'emulsion_setup_after' );
	}

}

/**
 * Style and Scripts
 */
add_action( 'wp_enqueue_scripts', 'emulsion_register_scripts_and_styles' );

function emulsion_register_scripts_and_styles() {
	global $wp_scripts, $wp_version;

	$emulsion_current_data_version = is_user_logged_in() ? time() : null;

	wp_register_style( 'emulsion-fse', get_template_directory_uri() . '/css/fse.css', array(), $emulsion_current_data_version, 'all' );
	wp_enqueue_style( 'emulsion-fse' );

	$inline_style = emulsion_fse_inline_style();
	wp_add_inline_style( 'emulsion-fse', $inline_style );

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

	//////////////////////////////////////////////////////////////////////////
	/**
	 * SCRIPT
	 * Table of contents
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

	/**
	 * Instantclick
	 */
	$support = emulsion_the_theme_supports( 'instantclick' ) ? 'enable' : 'disable';
	$support = 'enable' == get_theme_mod( 'emulsion_instantclick', $support ) ? true : false;

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

function emulsion_fse_body_class( $classes ) {
	$classes[] = 'emulsion';

	if ( has_blocks() ) {

		$classes[] = 'has-blocks';
	} else {

		$classes[] = 'no-blocks';
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

	return $classes;
}

function emulsion_fse_admin_body_class( $classes ) {

	$classes .= ' emulsion';

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
		'post-featured-image', 'post-navigation-link', 'post-template', 'post-term', 'post-title', 'preformatted', 'pullquote',
		'query-pagination-next', 'query-pagination-numbers', 'query-pagination-previous', 'query-pagination', 'query-title', 'query',
		'quote', 'rss', 'search', 'separator', 'shortcode', 'site-logo', 'site-tagline', 'site-title', 'social-link', 'social-links',
		'spacer', 'table', 'tag-cloud', 'template-part', 'term-description', 'text-columns', 'verse', 'video' );

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

if ( ! function_exists( 'emulsion_fallback_block_class' ) ) {

	function emulsion_fallback_block_class( $block_content, $block ) {

		$block_name		 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$target_block	 = array( 'wp-block-audio', 'wp-block-buttons', 'wp-block-columns', 'wp-block-file', 'wp-block-group', 'wp-block-post-excerpt', 'wp-block-table', 'wp-block-navigation' );

		if ( in_array( $block_name, $target_block ) ) {

			$new_class		 = array( 'wp-block' );
			$block_content	 = emulsion_add_class( $block_content, $block_name, $new_class );
		}

		return $block_content;
	}

}

function emulsion_corrected_core_css_max_width() {

	/**
	 * max-width: none
	 * The max-width property can easily cause an overflow if width is set
	 */
	$css = <<<STYLE
		div.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > .alignfull,
		div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .alignfull{
			/* max-width: none;
			   Content overflows if width is set
			*/
		max-width:100%;
	}
STYLE;
	return $css;
}

function emulsion_corrected_core_css_image_resizable_box__container_overflow() {

	/**
	 * image size 1280 * 862 set 75%
	 * core element style
	 *
	  element.style {
	  position: relative;
	  user-select: auto;
	  width: 960px;
	  height: 647px;
	  max-width: 1450px;
	  max-height: 976.484px;
	  min-width: 29.6984px;
	  min-height: 20px;
	  box-sizing: border-box;
	  flex-shrink: 0;
	  }
	 *
	 */
	$css = <<<STYLE
	.wp-block-image .components-resizable-box__container:not(#specificity){
		/*
		  If the image size is large, the resize box overflows and the resize handle cannot be operated.
		*/
		width:auto!important;
		max-width:100%!important;
		height:auto!important;

	}

STYLE;
	return $css;
}

function emulsion_corrected_core_css_flex_gap_size_consistency() {

	/**
	 * gap value site editor:1.25em, post editor:--wp--style--block-gap
	 * Inconsistent settings are seen
	 * Site grid layout bloken
	 */
	$css = <<<STYLE

	.wp-block-post-template.is-flex-container,
	.wp-block-query-loop.is-flex-container{
		gap:var(--wp--custom--margin--gap);
	}
	.wp-block-post-template.is-flex-container.is-flex-container[class*="columns-"] > li,
	.wp-block-query-loop.is-flex-container.is-flex-container[class*="columns-"] > li{
		/*Simple fix for columns not aligning as expected*/
		box-sizing:border-box;
	}
STYLE;
	return $css;
}

function emulsion_corrected_core_css_block_data_align() {

	/**
	 * It seems that the core lacks CSS for wp-block [data-align].
	 */
	$css = <<<STYLE

	.wp-block[data-align="wide"] {
		position: relative;
		left: 0;
		width: var(--thm_wide_width, 920px);
		max-width: 100%;
		margin-right: auto;
		margin-left: auto;
   }
	.wp-block[data-align="wide"] [data-block]{
		width:100%;
	}
	.wp-block[data-align="left"] {
		clear: left;
		float: left;
		height: max-content;
		width: calc(50%);
		margin-right: 1rem;
		height: auto;
		overflow: hidden;
   }
	.wp-block[data-align="left"] [data-block] {
		width: 100%;
   }
	.wp-block[data-align="left"] [data-block] .wp-block-gallery.alignright,
	.wp-block[data-align="left"] [data-block] .wp-block-gallery.alignleft,
	.wp-block[data-align="left"] [data-block] .alignleft,
	.wp-block[data-align="left"] [data-block] .alignright {
		width: 100%;
		float: none;
		max-width: 100%;
   }
	.wp-block[data-align="left"] [data-block].wp-block-button {
		padding-left: 24px;
		padding-right: 24px;
		width: auto;
   }
	.wp-block[data-align="left"] .is-style-shrink {
		text-align: right;
		width:calc(var(--wp--custom--width--content) / 2 - 1rem);
		margin-right:0;
		margin-left:auto;
		padding-right:0;
   }
	.wp-block[data-align="right"] {
		clear: right;
		float: right;
		height: auto;
		width: calc(50%);
		margin-left: 1rem;
		height: auto;
		overflow: hidden;
   }
	..wp-block[data-align="right"] [data-block] .wp-block-gallery.alignright,
	.wp-block[data-align="right"] [data-block] .alignleft,
	.wp-block[data-align="right"] [data-block] .alignright {
		width: 100%;
		max-width: 100%;
		float: none;
   }
	.wp-block[data-align="right"] [data-block].wp-block-button {
		padding-left: 24px;
		padding-right: 24px;
		width: auto;
   }
	.wp-block[data-align="right"] .is-style-shrink {
		text-align: left;
		width:calc(var(--wp--custom--width--content) / 2 - 1rem);
		padding-left:0;
		margin-right:auto;
		margin-left:0;
   }
	.wp-block[data-align="full"]{
		width: var(--thm_editor_main_width, 100%);
		max-width: 100%;
   }
	.wp-block[data-align="full"] [data-block]{
		width:100%;
	}wp-block[data-align="right"] [data-block] {
		width: 100%;
   }
	.wp-block[data-align="right"] [data-block] .wp-block-gallery.alignleft,
	.wp-block[data-align="right"] [data-block] .wp-block-gallery.alignright,
	.wp-block[data-align="right"] [data-block] .alignleft,
	.wp-block[data-align="right"] [data-block] .alignright {
		width: 100%;
		max-width: 100%;
		float: none;
   }
	.wp-block[data-align="right"] [data-block].wp-block-button {
		padding-left: 24px;
		padding-right: 24px;
		width: auto;
   }
	.wp-block[data-align="right"] .is-style-shrink {
		text-align: left;
		width:calc(var(--wp--custom--width--content) / 2 - 1rem);
		padding-left:0;
		margin-right:auto;
		margin-left:0;
   }
	.wp-block[data-align="full"]{
		width: var(--thm_editor_main_width, 100%);
		max-width: 100%;
   }
	.wp-block[data-align="full"] [data-block]{
		width:100%;
	}


STYLE;
	return $css;
}

function emulsion_corrected_core_css_float_contentmargins() {

	/**
	 * Over Write alignleft, alignright margins
	 *
	  .editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > .alignleft,
	  .editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .alignleft {
	  float: left;
	  margin-inline-start: 0;
	  margin-inline-end: 2em;
	  }
	  .editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > .alignright,
	  .editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .alignright {
	  float: right;
	  margin-inline-start: 2em;
	  margin-inline-end: 0;
	  }
	 */
	$css = <<<STYLE
			div.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > .alignleft,
			div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .alignleft {
				box-sizing: border-box;
				float: left;
				width: var(--wp--custom--width--alignleft);
				max-width: var(--wp--custom--width--alignleft);
				padding: 0;
				margin-inline: var(--wp--custom--padding--content, 0.75rem)  1rem;
				clear: left;
			}
			div.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > .alignright,
			div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .alignright {
				box-sizing: border-box;
				float: right;
				width: var(--wp--custom--width--alignright);
				max-width: var(--wp--custom--width--alignright);
				padding: 0;
				margin-inline: 1rem var(--wp--custom--padding--content, 0.75rem);
				clear: right;
			}
STYLE;
	return $css;
}


function new_srcset_max($max_width) {
	if(! is_singular()){
    return 800;
	}
	return $max_width;
}

add_filter('max_srcset_image_width', 'new_srcset_max');
