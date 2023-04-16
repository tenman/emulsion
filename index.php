<?php

/**
 * Theme emulsion
 * fallback template file
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'emulsion_template_pre' );
do_action( 'emulsion_template_pre_' . basename( __FILE__, '.php' ) );


// transitional removed @since 2.6.9
$template_type = 'transitional' == emulsion_get_theme_operation_mode() ? 'fse': emulsion_get_theme_operation_mode();

get_header( $template_type );

if ( true === emulsion_is_custom_post_type() && 'fse' == emulsion_get_theme_operation_mode() ) {

	/**
	 * Template tags are not loaded for the Full Site Editing Theme setting.
	 * But the plugin has a request for a php template. (Ex: bbpress) Fallback for this case.
	 */
	if ( have_posts() ) {

		while ( have_posts() ) {

			the_post();

			the_title( '<h2>', '</h2>' );

			print('<div style="width:var(--wp--custom--width--content);margin:var(--wp--custom--margin--block);padding:0 var(--wp--custom--padding--content)">' );

			the_content();

			print('</div>' );
		}
	}
} else {

	emulsion_the_theme_supports( 'title_in_page_header' ) ? '' : emulsion_archive_title();

	emulsion_have_posts();

	emulsion_pagination();
}
get_footer( $template_type );
