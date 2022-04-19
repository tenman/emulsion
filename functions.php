<?php
include_once( get_theme_file_path( 'lib/conf.php' ) );
include_once( get_theme_file_path( 'lib/customize.php' ) );
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
		$css=<<<STYLE
				/* test */
STYLE;
		return $css;
	}

	/**
	 * editor extend CSS
	 * @return type
	 */

	function emulsion_fse_editor_inline_style(){

		$css  = emulsion_corrected_core_css_max_width();
		$css .= emulsion_corrected_core_css_image_resizable_box__container_overflow();
		$css .= emulsion_corrected_core_css_flex_gap_size_consistency();
		$css .= emulsion_corrected_core_css_block_data_align();
		$css .= emulsion_corrected_core_css_float_contentmargins();
		$css .=<<<STYLE

STYLE;
		return $css;
	}


} else {

	require_once( get_theme_file_path( 'lib/functions-classic.php' ) );
}

add_action( 'enqueue_block_editor_assets', 'emulsion_block_editor_assets' );

