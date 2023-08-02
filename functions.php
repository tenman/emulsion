<?php

include_once( get_theme_file_path( 'lib/conf.php' ) );
current_user_can( 'edit_posts' ) ? include_once( get_theme_file_path( 'lib/customize.php' ) ) : '';
include_once( get_theme_file_path( 'lib/functions-global.php' ) );
include_once( get_theme_file_path( 'lib/blocks.php' ) );

if ( 'fse' == emulsion_get_theme_operation_mode() ) {

	include_once( get_theme_file_path( 'lib/functions-fse.php' ) );
	include_once( get_template_directory() . '/lib/full_site_editor.php' );
	include_once( get_theme_file_path( 'fse-compatible-classic-template/functions.php' ) );

	/**
	 * front emd extend CSS
	 * @return type
	 */
	function emulsion_fse_inline_style() {
		$css = emulsion_custom_field_css();

		$css .= emulsion_corrected_core_css_has_nested_images_gallery();
		//$css .= emulsion_pattern_custom_layout_inline_css();
		$css .= emulsion_base_layout_apply_globaly_css();

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
		//$css .= emulsion_fse_scheme_grid_eiditor_style();

		$css .= <<<STYLE


STYLE;
		return $css;
	}

} else {


	require_once( get_theme_file_path( 'lib/functions-classic.php' ) );
}

add_action( 'enqueue_block_editor_assets', 'emulsion_block_editor_assets' );

function emulsion_pattern_custom_layout_inline_css(){
	$post_id = emulsion_get_current_post_id();
	$post_content = get_post( $post_id )->post_content;

	$blocks = parse_blocks($post_content);

	if( ! empty($blocks[0]['attrs']['className']) && 'emulsion-pattern-custom-layout' == $blocks[0]['attrs']['className'] ) {

		$content_size = $blocks[0]['attrs']['layout']["contentSize"];
		$wide_size = $blocks[0]['attrs']['layout']["wideSize"];

		$css=<<<CSS

		.has-emulsion-pattern-custom-layout{
			--wp--custom--width--content:$content_size;
			--wp--custom--width--wide:$wide_size;
		}

CSS;
		add_filter('body_class', function($classes){$remove_class = ['keep-align-wide',	'keep-align-full'];	return array_diff($classes, $remove_class);	},20);

		return $css;
	}
}



function emulsion_base_layout_apply_globaly_css() {


	$post_id		 = emulsion_get_current_post_id();

	if( 0 === $post_id ) {
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
			--wp--custom--width--content:$content_size;
			--wp--custom--width--wide:$wide_size;
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

