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

get_header();

emulsion_the_theme_supports( 'title_in_page_header' ) ? '' : emulsion_archive_title();


emulsion_action( 'emulsion_article_wrapper_before' );

emulsion_have_posts();

emulsion_action( 'emulsion_article_wrapper_after' );

emulsion_pagination();

get_footer();
