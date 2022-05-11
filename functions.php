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
		$css = '';
		//@since ver 13.1.0 $css = emulsion_corrected_core_css_has_nested_images_gallery();

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

	    //Fixed @since ver 13.1.0 $css .= emulsion_corrected_core_css_image_resizable_box__container_overflow();
		//@since ver 13.1.0 .wp-block [data-align] seems to have been deleted again
		//$css .= emulsion_corrected_core_css_block_data_align();
		//$css .= emulsion_corrected_core_css_wp_block_data_align();

		//ver 13.1.0 Not completely removed yet
		$css  = emulsion_corrected_core_css_max_width();
		$css .= emulsion_corrected_core_css_flex_gap_size_consistency();
		$css .= emulsion_corrected_core_css_float_contentmargins();
		$css .= emulsion_add_classic_custom_field_css();
		$css .= emulsion_corrected_core_css_not_sure_universal_selector();


		$css .=<<<STYLE

STYLE;
		return $css;
	}


} else {

	require_once( get_theme_file_path( 'lib/functions-classic.php' ) );
}

add_action( 'enqueue_block_editor_assets', 'emulsion_block_editor_assets' );
