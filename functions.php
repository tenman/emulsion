<?php

include_once( get_theme_file_path( 'lib/conf.php' ) );
current_user_can( 'edit_posts' ) ? include_once( get_theme_file_path( 'lib/customize.php' ) ) : '';
include_once( get_theme_file_path( 'lib/functions-global.php' ) );
include_once( get_theme_file_path( 'lib/blocks.php' ) );
include_once( get_theme_file_path( 'lib/template-tags.php' ) );

if ( 'fse' == emulsion_get_theme_operation_mode() ) {

	include_once( get_theme_file_path( 'lib/functions-fse.php' ) );
	include_once( get_template_directory() . '/lib/full_site_editor.php' );
	include_once( get_theme_file_path( 'classic-templates/functions.php' ) );

	/**
	 * front emd extend CSS
	 * @return type
	 */
	function emulsion_fse_inline_style() {
		$css = emulsion_custom_field_css();
		$css .= emulsion_corrected_core_css_has_nested_images_gallery();
		$css .= emulsion_base_layout_apply_globaly_css();
		$css .= emulsion_hide_redundant_category();

		$css .= <<<STYLE


STYLE;
		return $css;
	}

	/**
	 * editor extend CSS
	 * @return type
	 */
	function emulsion_fse_editor_inline_style() {
		$css = '';

		$css .= emulsion_add_classic_custom_field_css();
		$css .= emulsion_add_narrow_align_css();
		$css .= emulsion_add_misc_css();
		$css .= emulsion_editor_color_scheme_correction();
		$css .= emulsion_fse_scheme_pack_eiditor_style();
		$css .= emulsion_fse_scheme_pack_midnight_eiditor_style();
		$css .= <<<STYLE


STYLE;
		return $css;
	}

} else {

	require_once( get_theme_file_path( 'lib/functions-classic.php' ) );
}

add_action( 'enqueue_block_editor_assets', 'emulsion_block_editor_assets' );

add_filter( 'emulsion_layout_control', 'emulsion_style_variation_grid_filter_classic', 11 );

function emulsion_style_variation_grid_filter_classic( $classes ) {
	//@see emulsion_style_variation_grid_filter()

	if ( 'grid' == emulsion_get_css_variables_value( '--wp--custom--color--scheme' ) || 'grid-midnight' == emulsion_get_css_variables_value( '--wp--custom--color--scheme' ) ) {

		return 'is-layout-grid columns-3 alignwide';
	}

	return $classes;
}
