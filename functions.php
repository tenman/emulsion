<?php
include_once( get_theme_file_path( 'lib/conf.php' ) );
current_user_can( 'edit_posts' )  ? include_once( get_theme_file_path( 'lib/customize.php' ) ): '';
include_once( get_theme_file_path( 'lib/functions-global.php' ) );
include_once( get_theme_file_path( 'lib/blocks.php' ) );

if('fse' == emulsion_get_theme_operation_mode() ) {

	require_once( get_theme_file_path( 'lib/functions-fse.php' ) );
	require_once( get_template_directory() . '/lib/full_site_editor.php' );

	/**
	 * front emd extend CSS
	 * @return type
	 */

	function emulsion_fse_inline_style(){
		$css = emulsion_custom_field_css();
		//@since ver 13.1.0 , 13.2.2 Reappear
		$css .= emulsion_corrected_core_css_has_nested_images_gallery();

		$css .=<<<STYLE

STYLE;
		return $css;
	}



	/**
	 * editor extend CSS
	 * @return type
	 */

	function emulsion_fse_editor_inline_style(){
		$css = '';

	    //Fixed @since ver 13.1.0 13.2.2 Reappear
		$css .= emulsion_corrected_core_css_image_resizable_box__container_overflow();
		//@since ver 13.1.0 .wp-block [data-align] seems to have been deleted again 13.2.2 Reappear
		$css .= emulsion_corrected_core_css_block_data_align();
		$css .= emulsion_corrected_core_css_wp_block_data_align();

		//ver 13.1.0 Not completely removed yet
		//@since ver 13.2.0 wordpress 6.0 Reappear
		$css  = emulsion_corrected_core_css_max_width();
		$css .= emulsion_corrected_core_css_flex_gap_size_consistency();
		$css .= emulsion_corrected_core_css_float_contentmargins();
		$css .= emulsion_add_classic_custom_field_css();
		$css .= emulsion_corrected_core_css_not_sure_universal_selector();
		$css .= emulsion_add_narrow_align_css();
		$css .= emulsion_add_misc_css();


		$css .=<<<STYLE


STYLE;
		return $css;
	}


} else {

	function emulsion_fse_transitional_editor_inline_style(){

		$css = '';
		if( 'html' !== get_theme_mod('emulsion_header_template') ) {
			// html means use block template header
			$css .= '
				.edit-site-header__actions .interface-pinned-items [aria-label="Navigation"],
				.block-editor-list-view-tree [aria-label="Navigation link"],
				.block-editor-list-view-tree [aria-label="Header link"] ~ .block-editor-list-view-block__menu-cell,
				.is-root-container > nav.fse-primary,
				.edit-site-template-card__template-areas .edit-site-template-card__template-areas-list li:first-child,
				.block-editor-list-view-tree [aria-label="Header link"],
				.is-root-container > .fse-header{
					display:none;
				}
				.components-resizable-box__container .edit-site-visual-editor__editor-canvas{
					margin:0 auto;
				}';
		}
		if( 'html' !== get_theme_mod('emulsion_footer_template') ) {
			// html means use block template header
			$css .= '
				.block-editor-list-view-tree [aria-label="Navigation link"] ~ .block-editor-list-view-block__menu-cell,
				.edit-site-template-card__template-areas .edit-site-template-card__template-areas-list li:last-child,
				.block-editor-list-view-tree [aria-label="Header link"],
				.is-root-container > .fse-footer{
				display:none;
			}';
		}
		$css .=<<<STYLE
				.edit-site-template-card__template-areas:after{
					content:'Please customize the header and footer with the customizer.';
					display:block;
					padding:.75rem;
					border:1px solid #ccc;
				}
STYLE;
		return $css;
	}

	require_once( get_theme_file_path( 'lib/functions-classic.php' ) );
}

add_action( 'enqueue_block_editor_assets', 'emulsion_block_editor_assets' );



