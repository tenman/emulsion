<?php

/**
 * Experimental block effect
 */
if ( function_exists( 'register_block_style' ) ) {

	register_block_style( 'core/code', array( 'name' => 'dark', 'label' => esc_html__( 'Dark', 'emulsion' ), ) );

	register_block_style( 'core/tag-cloud', array( 'name'			 => 'flat', 'label'			 => esc_html__( 'Flat', 'emulsion' ),
		'inline_style'	 => '#document .is-style-flat a,#wpbody .is-style-flat a{ '
		. 'font-size:1rem ! important; display:inline-block;padding:.6rem; }', ) );

	register_block_style( 'core/image', array( 'name' => 'circle-mask', 'label' => esc_html__( 'Circle Mask', 'emulsion' ), ) );
	register_block_style( 'core/image', array( 'name' => 'shrink', 'label' => esc_html__( 'Align Offset Zero', 'emulsion' ), ) );

	if ( 'theme' !== emulsion_get_theme_operation_mode() ) {

		register_block_style( 'core/image', array( 'name' => 'fit-wide', 'label' => esc_html__( 'Align Offset Wide', 'emulsion' ), ) );
		register_block_style( 'core/gallery', array( 'name' => 'fit-wide', 'label' => esc_html__( 'Align Offset Wide', 'emulsion' ), ) );
		register_block_style( 'core/gallery', array( 'name' => 'shrink', 'label' => esc_html__( 'Align Offset Zero', 'emulsion' ), ) );
	}

	register_block_style( 'core/list', array( 'name' => 'list-style-none', 'label' => esc_html__( 'No Bullet', 'emulsion' ), ) );
	register_block_style( 'core/list', array( 'name' => 'list-style-inline', 'label' => esc_html__( 'Inline List', 'emulsion' ), ) );
	//register_block_style( 'core/list', array( 'name' => 'list-style-initial', 'label' => esc_html__( 'Remove Theme Bullet', 'emulsion' ), ) );

	register_block_style( 'core/archives', array( 'name' => 'list-style-inline', 'label' => esc_html__( 'Inline', 'emulsion' ), ) );
	register_block_style( 'core/categories', array( 'name' => 'list-style-inline', 'label' => esc_html__( 'Inline', 'emulsion' ), ) );

	register_block_style( 'core/paragraph', array( 'name' => 'hanging-indent', 'label' => esc_html__( 'Hanging Indent', 'emulsion' ), ) );
	register_block_style( 'core/paragraph', array( 'name' => 'indent-5rem', 'label' => esc_html__( 'Indent S', 'emulsion' ), ) );
	register_block_style( 'core/paragraph', array( 'name' => 'indent-10rem', 'label' => esc_html__( 'Indent M', 'emulsion' ), ) );
	register_block_style( 'core/paragraph', array( 'name' => 'indent-15rem', 'label' => esc_html__( 'Indent L', 'emulsion' ), ) );

	register_block_style( 'core/group', array( 'name' => 'responsive', 'label' => esc_html__( 'Responsive', 'emulsion' ), ) );

	if ( 'ffffff' !== get_theme_mod( 'background_color' ) ) {

		register_block_style( 'core/spacer', array( 'name' => 'seigaiha', 'label' => esc_html__( 'Background Pattern Seigaiha', 'emulsion' ), ) );
		register_block_style( 'core/spacer', array( 'name' => 'carbon-fiber', 'label' => esc_html__( 'Background Pattern Carbon Fiber', 'emulsion' ), ) );
		register_block_style( 'core/spacer', array( 'name' => 'cicada', 'label' => esc_html__( 'Background Pattern Cicada', 'emulsion' ), ) );
	}

	register_block_style( 'core/buttons', array( 'name' => 'has-shadow', 'label' => esc_html__( 'Add Shadow', 'emulsion' ), ) );
	//@since 2.5.1 repeal Because it is now possible to adjust the font size in each block
	//register_block_style( 'core/column', array( 'name' => 'main', 'label' => esc_html__( 'Main Column', 'emulsion' ), ) );



	if ( 'theme' !== emulsion_get_theme_operation_mode() && 'enable' !== get_theme_mod( 'emulsion_gutenberg_render_layout_support_flag','disable' ) ) {
		register_block_style( 'core/column', array( 'name' => 'layout-flow', 'label' => esc_html__( 'Flow Layout', 'emulsion' ), ) );
		register_block_style( 'core/group', array( 'name' => 'layout-flow', 'label' => esc_html__( 'Flow Layout', 'emulsion' ), ) );
		register_block_style( 'core/template-part', array( 'name' => 'layout-flow', 'label' => esc_html__( 'Flow Layout', 'emulsion' ), ) );
		register_block_style( 'core/template-part', array( 'name' => 'layout-wide', 'label' => esc_html__( 'Contents Alignwide', 'emulsion' ), ) );
	}



	register_block_style( 'core/column', array( 'name' => 'sticky', 'label' => esc_html__( 'Sticky Column', 'emulsion' ), ) );
// 'freeform', 'shortcode', 'html',
	$styles = array( 'archives', 'audio', 'blocks', 'buttons', 'calendar', 'categories', 'code', 'columns', 'comment-content', 'comment-date',
		'comment-edit-link', 'comment-reply-link', 'comment-template', 'comments-author-avatar', 'comments-author-name', 'commentspagination-next',
		'comments-pagination-next', 'comments-pagination-numbers', 'comments-pagination-previous', 'comments-pagination', 'comments-query-loop',
		'cover', 'embed', 'file', 'gallery', 'group', 'heading', 'home-link', 'image', 'latest-comments', 'latest-posts',
		'list', 'media-text', 'missing', 'more', 'navigation-area', 'navigation-link', 'navigation-submenu', 'navigation', 'next-page', 'page-list',
		'paragraph', 'pattern', 'post-author-name', 'post-author', 'post-comment-author', 'post-comment-content', 'post-comment-date',
		'post-comments-count', 'post-comments-form', 'post-comments-link', 'post-comments', 'post-content', 'post-date', 'post-excerpt',
		'post-featured-image', 'post-navigation-link', 'post-template', 'post-terms', 'post-title', 'preformatted', 'pullquote',
		'query-pagination-next', 'query-pagination-numbers', 'query-pagination-previous', 'query-pagination', 'query-title', 'query',
		'quote', 'rss', 'search', 'separator', 'site-logo', 'site-tagline', 'site-title', 'social-link', 'social-links',
		'spacer', 'table', 'tag-cloud', 'template-part', 'term-description', 'text-columns', 'verse', 'video', 'post-author-biography', 'avatar', 'table-of-contents' );

	foreach ( $styles as $style ) {

		register_block_style( 'core/' . $style, array( 'name' => 'new-line', 'label' => esc_html__( 'New Line', 'emulsion' ), ) );
	}


	add_filter(
			'block_editor_settings_all',
			function ( $settings ) {

				if ( is_customize_preview() ) {

					return $settings;
				}
				$post_id		 = get_the_ID();
				$current_post	 = get_post( $post_id );
				$template_path	 = '';

				if ( $current_post ) {

					$filename		 = sanitize_file_name( sprintf( 'block-template-default-%1$s', $current_post->post_type . '.php' ) );
					$template_path	 = get_template_directory() . '/default-templates/' . $filename;
				}

				if ( is_readable( $template_path ) ) {

					$settings['defaultBlockTemplate'] = include( $template_path );
				}
				return $settings;
			} );
}


function emulsion_block_pattern() {

	if ( function_exists( 'register_block_pattern' ) ) {

		if ( 'enable' !== get_theme_mod( 'emulsion_core_block_patterns_support' ) ) {

			add_action( 'init', 'remove_default_block_pattern_category' );

			function remove_default_block_pattern_category() {
				$categories = [
					'about',
					'call-to-action',
					'contact',
					//'footers',
					//'headers',
					'media',
					'portfolio',
					'posts',
					'services',
					'team',
					'testimonials',
					'query',
					'buttons',
					'columns',
					'featured',
					'gallery',
					'text'

				];
				foreach ( $categories as $category ) {
					unregister_block_pattern_category( $category );
				}
			}

			add_action( 'init', 'my_plugin_register_my_pattern_categories' );

			function my_plugin_register_my_pattern_categories() {
				$categories = [
					'recently-added' => esc_html_x( 'Recentry Added', 'Emulsion Block pattern', 'emulsion' ),
					'sub-query'		 => esc_html_x( 'Sub Query', 'Emulsion Block pattern', 'emulsion' ),
					'headers'		 => esc_html_x( 'Headers', 'Emulsion Block pattern', 'emulsion' ),
					'contents'		 => esc_html_x( 'Contents', 'Emulsion Block pattern', 'emulsion' ),
					'footers'		 => esc_html_x( 'Footers', 'Emulsion Block pattern', 'emulsion' ),
					'layout'		 => esc_html_x( 'Layout', 'Emulsion Block pattern', 'emulsion' ),
					'sidebars'		 => esc_html_x( 'Sidebars', 'Emulsion Block pattern', 'emulsion' )
				];

				foreach ( $categories as $category_slug => $category_text ) {
					register_block_pattern_category(
							$category_slug, array( 'label' => $category_text )
					);
				}
			}

		} else {

			register_block_pattern_category( 'emulsion', array( 'label' => esc_html_x( 'Emulsion', 'Emulsion Block pattern', 'emulsion' ) ) );
		}
	}
}

add_action( 'init', 'emulsion_block_pattern', 9 );
