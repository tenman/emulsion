<?php

function emulsion_block_editor_assets() {

	wp_enqueue_script( 'emulsion-block', esc_url( get_template_directory_uri() . '/js/block.js' ), 	array( 'wp-blocks', 'wp-i18n','wp-editor', 'jquery' ) );
}

add_action( 'enqueue_block_editor_assets', 'emulsion_block_editor_assets' );

/**
 * Experimental block effect
 */

if ( function_exists( 'register_block_style' ) ) {

	register_block_style( 'core/code', array( 'name' => 'dark', 'label' => esc_html__( 'Dark', 'emulsion' ), ) );

	register_block_style( 'core/tag-cloud', array( 'name' => 'flat', 'label' => esc_html__( 'Flat', 'emulsion' ),
		'inline_style'	 => '#document .is-style-flat a,#wpbody .is-style-flat a{ '
		. 'font-size:1rem ! important; display:inline-block;padding:.6rem; }', ) );

	register_block_style( 'core/heading', array( 'name' => 'remove-text-transform', 'label' => esc_html__( 'Remove Text Transform', 'emulsion' ),
		'inline_style'	 => ' h6.is-style-remove-text-transform,'
		. ' h5.is-style-remove-text-transform,'
		. ' h4.is-style-remove-text-transform,'
		. ' h3.is-style-remove-text-transform,'
		. ' h2.is-style-remove-text-transform,'
		. '#document h6.is-style-remove-text-transform,'
		. '#document h5.is-style-remove-text-transform,'
		. '#document h4.is-style-remove-text-transform,'
		. '#document h3.is-style-remove-text-transform,'
		. '#document h2.is-style-remove-text-transform{'
		. "text-transform: none;"
		. "}",) );

	register_block_style( 'core/image', array( 'name' => 'circle-mask', 'label' => esc_html__('Circle Mask', 'emulsion' ), ) );
	register_block_style( 'core/image', array( 'name' => 'shrink', 'label' => esc_html__( 'Align Offset Zero', 'emulsion' ), ) );

	register_block_style( 'core/list', array( 'name' => 'list-style-none', 'label' => esc_html__( 'No Bullet', 'emulsion' ), ) );
	register_block_style( 'core/list', array( 'name' => 'list-style-inline', 'label' => esc_html__( 'Inline List', 'emulsion' ), ) );
	register_block_style( 'core/list', array( 'name' => 'list-style-initial', 'label' => esc_html__( 'Remove Theme Bullet', 'emulsion' ), ) );

	register_block_style( 'core/archives', array( 'name' => 'list-style-inline', 'label' => esc_html__('Inline', 'emulsion' ), ) );
	register_block_style( 'core/categories', array( 'name' => 'list-style-inline', 'label' => esc_html__( 'Inline', 'emulsion' ), ) );

	register_block_style( 'core/paragraph', array( 'name' => 'hanging-indent', 'label' => esc_html__( 'Hanging Indent', 'emulsion' ), ) );
	register_block_style( 'core/paragraph', array( 'name' => 'indent-5rem', 'label' => esc_html__( 'Left Indent S', 'emulsion' ), ) );
	register_block_style( 'core/paragraph', array( 'name' => 'indent-10rem', 'label' => esc_html__( 'Left Indent M', 'emulsion' ), ) );
	register_block_style( 'core/paragraph', array( 'name' => 'indent-15rem', 'label' => esc_html__( 'Left Indent L', 'emulsion' ), ) );

	if( 'ffffff' !== get_theme_mod('background_color') ) {

		register_block_style( 'core/spacer', array( 'name' => 'seigaiha', 'label' => esc_html__( 'Background Pattern Seigaiha', 'emulsion' ), ) );
		register_block_style( 'core/spacer', array( 'name' => 'carbon-fiber', 'label' => esc_html__( 'Background Pattern Carbon Fiber', 'emulsion' ), ) );
		register_block_style( 'core/spacer', array( 'name' => 'cicada', 'label' => esc_html__( 'Background Pattern Cicada', 'emulsion' ), ) );
	}

	register_block_style( 'core/verse', array( 'name' => 'has-regular-font-size', 'label' => esc_html__( 'Regular Font', 'emulsion' ), ) );
	register_block_style( 'core/verse', array( 'name' => 'has-large-font-size', 'label' => esc_html__( 'Large Font', 'emulsion' ), ) );
	register_block_style( 'core/verse', array( 'name' => 'has-extra-large-font-size', 'label' => esc_html__( 'Extra Large Font', 'emulsion' ), ) );

	register_block_style( 'core/buttons', array( 'name' => 'has-shadow', 'label' => esc_html__( 'Add Shadow', 'emulsion' ), ) );
	register_block_style( 'core/column', array( 'name' => 'main', 'label' => esc_html__( 'Main Column', 'emulsion' ), ) );

	register_block_style( 'core/column', array( 'name' => 'sticky', 'label' => esc_html__( 'Sticky Column', 'emulsion' ), ) );
}

function emulsion_block_pattern() {

	if ( function_exists( 'register_block_pattern' ) ) {

		register_block_pattern(
				'emulsion/block-pattern-list-tab', array(
			'title'			 => esc_html__( 'Presentation TAB', 'emulsion' ),
			'content'		 => '<!-- wp:list {"className":"list-style-tab"} --><ul class="list-style-tab"><li>tab 1<ul><li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, </li></ul></li><li>tab 2<ul><li> Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </li></ul></li></ul><!-- /wp:list -->',
			'categories'	 => array( 'emulsion' ),
			'description'	 => esc_html_x( 'Tabs on the front end', 'Block pattern description', 'emulsion' ),
				)
		);

		register_block_pattern(
			'emulsion/block-pattern-modal', array(
			'title'			 => esc_html__( 'Presentation Modal Box', 'emulsion' ),
			'content'		 => '<!-- wp:buttons --><div class="wp-block-buttons modal-open-link"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link" href="./#modal-group-1">modal link text</a></div><!-- /wp:button --></div><!-- /wp:buttons --><!-- wp:group {"className":"emulsion-modal solid-border modal"} --><div id="modal-group-1" class="wp-block-group emulsion-modal solid-border modal"><div class="wp-block-group__inner-container"><!-- wp:paragraph {"textAlign":"right","placeholder":"Panel Title","className":"emulsion-modal-title alignfull"} --><p class="has-text-align-right emulsion-modal-title"><a href="./" class="modal-close-link">X</a></p><!-- /wp:paragraph --><!-- wp:group {"className":"emulsion-modal-content"} --><div class="wp-block-group emulsion-modal-content"><div class="wp-block-group__inner-container"><!-- wp:paragraph {"placeholder":"content"} --><p>content</p><!-- /wp:paragraph --></div></div><!-- /wp:group --></div></div><!-- /wp:group -->',
			'categories'	 => array( 'emulsion' ),
			'description'	 => esc_html_x( 'Modal Box on the front end', 'Block pattern description', 'emulsion' ),
				)
		);

		register_block_pattern_category( 'emulsion', array( 'label' => esc_html_x( 'Emulsion', 'Emulsion Block pattern', 'emulsion' ) ) );
	}
}
add_action('init','emulsion_block_pattern',9);