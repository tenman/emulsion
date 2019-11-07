<?php
/**
 * Template Name: Blank Template
 *  Template Post Type: post, page
 *
 */

emulsion_remove_supports( 'title_in_page_header' );
emulsion_remove_supports( 'primary_menu' );
emulsion_remove_supports( 'sidebar' );
emulsion_remove_supports( 'sidebar_page' );
emulsion_remove_supports( 'relate_posts' );
emulsion_remove_supports( 'search_drawer' );


//global $template;

get_header();

emulsion_have_posts();

if ( is_single() ) {
	emulsion_pagination();
}

get_footer();