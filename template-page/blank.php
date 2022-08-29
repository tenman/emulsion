<?php
/**
 * Template Name: Blank Template
 * Template Post Type: post, page
 *
 * This template can only be used when the emulsion-addons plugin is active
 */

if ( ! emulsion_theme_addons_exists() ) {

	return;
}

emulsion_remove_supports( 'header' );
emulsion_remove_supports( 'title_in_page_header' );
emulsion_remove_supports( 'primary_menu' );
emulsion_remove_supports( 'sidebar' );
emulsion_remove_supports( 'sidebar_page' );
emulsion_remove_supports( 'search_drawer' );

get_header();

emulsion_have_posts();

if ( is_single() ) {
	emulsion_pagination();
}

get_footer();
