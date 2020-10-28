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


if ( has_action( 'emulsion_article_wrapper_before' ) ) {
	?><div class="placeholder-article-wrapper-before"><?php do_action( 'emulsion_article_wrapper_before' ); ?></div><?php
}

emulsion_have_posts();

if ( has_action( 'emulsion_article_wrapper_after' ) ) {
	?><div class="placeholder-article-wrapper-after"><?php do_action( 'emulsion_article_wrapper_after' ); ?></div><?php
}

emulsion_pagination();

get_footer();