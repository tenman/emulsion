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
			add_filter( 'render_block', 'emulsion_add_custom_gap', 10, 2 );

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

		if ( emulsion_is_plugin_active( 'gutenberg/gutenberg.php' ) ) {

			add_theme_support( 'custom-spacing' );
			add_theme_support( 'experimental-link-color' );
		}
		add_filter( 'emulsion_toc_script', 'emulsion_toc_fse' );

		add_filter( 'emulsion_instantclick_script', 'emulsion_instantclick' );
		add_filter( 'body_class', 'emulsion_fse_body_class' );
		add_filter( 'admin_body_class', 'emulsion_fse_admin_body_class' );

		add_filter( 'render_block_core/template-part', 'emulsion_fse_footer_content_filter', 10, 2 );
		add_filter( 'render_block_core/post-title', 'emulsion_accesible_post_title_link_control', 10, 2 );
		add_filter( 'render_block_core/site-title', 'emulsion_accesible_site_title_link_control', 10, 2 );
		add_filter( 'render_block', 'emulsion_relate_posts_when_addons_inactive', 10, 2 );

		add_filter( 'get_the_author_description', 'emulsion_author_description', 20 );
		add_filter( 'the_password_form', 'emulsion_get_the_password_form', 11 );



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

		do_action( 'emulsion_setup_after' );
	}

}

function emulsion_author_description( $text ) {

	return nl2br( $text );
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
}

function emulsion_fse_body_class( $classes ) {

	$classes[] = 'emulsion';

	$classes[] = 'is-presentation-fse';

	if ( ! is_page() || ! is_attachment() || ! is_single() || has_block( 'post-excerpt' ) ) {

		$classes[] = 'summary';
	}

	if ( has_blocks() ) {

		$classes[] = 'has-block';
	} else {

		$classes[] = 'no-block';
	}

	if( emulsion_is_custom_post_type() ) {

		$classes[] = 'post-type-custom';
	} else {

		$classes[] = 'post-type-default';
	}

	$classes[] = 'is-tpl-' . emulsion_get_template();

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
	$classes .= ' '. emulsion_fse_background_color_class();

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
		'spacer', 'table', 'tag-cloud', 'template-part', 'term-description', 'text-columns', 'verse', 'video','post-author-biography', 'avatar', 'loginout' );

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


function emulsion_corrected_core_css_max_width() {

	/**
	 * max-width: none
	 * The max-width property can easily cause an overflow if width is set
	 */
	/**
	 * Where it should be defined by width, it is defined by max-width, which causes wp-block-column overflow.
	 *
	 .editor-styles-wrapper .wp-container-9 > :where(:not(.alignleft):not(.alignright)) {
		 max-width: 720px;
	 }
	 */
	$css = <<<STYLE
		div.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > .alignfull,
		div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .alignfull{

			/* max-width: none;
			   Content overflows if width is set
				fixed @since ver 13.1.0
			*/
			max-width:100%;
		}
		.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > .alignfull,
		.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .alignfull {
			/*
				max-width: none;
				note: has max-width:none exists gutenberg_get_layout_style(), index.js
			*/
			max-width:100%;
		}
		div.editor-styles-wrapper [class*="wp-container-"] > :where(:not(.alignleft):not(.alignright)) {
			max-width: 100%;
			overflow:hidden;
		}
		div.editor-styles-wrapper [class*="wp-container-"] > * {
			margin-block-start:auto;
			margin-block-end:auto;
			margin:auto;

		}
		div.editor-styles-wrapper [class*="wp-container-"] > .alignleft,
		div.editor-styles-wrapper [class*="wp-container-"] > .alignright {
			margin:var(--wp--custom--padding--content)
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
	.wp-block-image .components-resizable-box__container:not(#specificity):not(.has-show-handle){
		/*
		  If the image size is large, the resize box overflows and the resize handle cannot be operated.
		*/
		width:auto!important;
		max-width:100%!important;
		height:auto!important;

	}
	.wp-block-image .components-resizable-box__container:not(#specificity):not(.has-show-handle){
			/*
			If width is specified, the size of the resize box cannot be changed.
			*/
		max-width:100%!important;
		height:auto!important;
		overflow:auto;
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
		gap:var(--wp--style--block-gap, 3px);
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
		width: var(--wp--custom--width--wide, 920px);
		max-width: 100%;
		margin-right: auto;
		margin-left: auto;
   }
	.wp-block[data-align="wide"] [data-block]{
		width:100%;
	}
	.editor-styles-wrapper .block-editor-block-list__layout.is-root-container .wp-block[data-align="left"] {
		clear: left;
		float: left;
		height: max-content;
		max-width: calc(50%);
		width:-moz-fit-content;
		width:fit-content;
		margin-right: 1rem;
		height: auto;
		overflow: hidden;
   }
	.wp-block[data-align="left"] > [data-block] {
		/*width: 100%;*/

   }
	.wp-block[data-align="left"] .wp-block-social-links,
	.wp-block[data-align="right"] .wp-block-social-links{
        width:100px;
	}
	.wp-block[data-align="left"]  .wp-block-categories,
	.wp-block[data-align="right"] .wp-block-categories,
	.wp-block[data-align="left"] .wp-block-archives,
	.wp-block[data-align="right"] .wp-block-archives,
	.wp-block[data-align="left"] .wp-block-latest-comments,
	.wp-block[data-align="right"] .wp-block-latest-comments,
	.wp-block[data-align="left"] .wp-block-search,
	.wp-block[data-align="right"] .wp-block-search{
			width:320px;
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
		padding-left: var(--wp--custom--padding--content, .75rem);
		padding-right: var(--wp--custom--padding--content, .75rem);
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
	.wp-block[data-align="right"] [data-block] .wp-block-gallery.alignright,
	.wp-block[data-align="right"] [data-block] .alignleft,
	.wp-block[data-align="right"] [data-block] .alignright {
		width: 100%;
		max-width: 100%;
		float: none;
   }
	.wp-block[data-align="right"] [data-block].wp-block-button {
		padding-left: var(--wp--custom--padding--content, .75rem);
		padding-right: var(--wp--custom--padding--content, .75rem);
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
		width: 100%;
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
		padding-left: var(--wp--custom--padding--content, .75rem);
		padding-right: var(--wp--custom--padding--content, .75rem);
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
		width: 100%;
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
				width: var(--wp--custom--width--float);
				max-width: 100%;

				margin:.75rem .375rem .75rem .75rem;
				clear: left;
			}
			div.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > .alignright,
			div.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .alignright {
				box-sizing: border-box;
				float: right;
				width: var(--wp--custom--width--float);
				max-width: 100%;
				margin:.75rem .375rem .75rem .75rem;
				clear: right;
			}
STYLE;
	return $css;
}

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

function emulsion_corrected_core_css_wp_block_data_align() {

	/**
	 * class="wp-block" data-align="[left, right, wide, full]"
	 * The child elements of the above elements require a different style than the front end.
	 * The alignleft, alignright, alignwide, and alignfull classes need to be overwritten.
	 *
	 */
	$css = <<<STYLE

	.wp-block[data-align] .aligncenter,
	.wp-block[data-align] .alignleft,
	.wp-block[data-align] .alignright,
	.wp-block[data-align] .alignwide,
	.wp-block[data-align] .alignfull{
		width:auto;
		max-width:100%;
	}
	.wp-block[data-align="left"] .components-resizable-box__container{
		float:right;
	}
	.wp-block[data-align="right"] .components-resizable-box__container{
		float:left;
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
STYLE;
	return $css;
}

function emulsion_corrected_core_css_not_sure_universal_selector() {

	/**
	 * The person who wrote this code may like the haiku-like setting method,
	 * but for theme developers and users, such tyles are less maintainable.
	 *
	 *	.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > * + *,
		.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > * + * {
			margin-block-start: var( --wp--style--block-gap );
		}
		.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > *,
		.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > * {
			margin-block-start: 0;
			margin-block-end: 0;
		}
	 *
	 *
	 *
	 */
		$css = <<<STYLE
		.editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > h1{
				/* not exists * + * */
				margin-top:4rem;
				argin-block-start: var(--wp--custom--margin--block, 1.5rem);
		}
		.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > *,
		.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .wp-block{
			margin: var(--wp--custom--margin--block, 1.5rem) auto;
		}
		.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .wp-block-buttons.alignleft,
		.editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .wp-block-buttons.alignright{
				width:-moz-fit-content;
				width:fit-content;
		}
STYLE;
		return $css;

}

if ( ! function_exists( 'emulsion_toc_fse' ) ) {

	function emulsion_toc_fse( $script ) {

			$script	 = "jQuery('.toc').toc({'scrollToOffset':16, 'container':'.entry-content','anchorName': function(i, heading, prefix) { return prefix+'-'+i;},})";
			return $script;

	}

}
