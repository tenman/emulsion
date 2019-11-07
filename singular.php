<?php

/**
 * Theme emulsion
 * Single post , page template
 */

$emulsion_title_in_page_header = emulsion_get_supports( 'title_in_page_header' );

get_header();

if ( ! is_page() ) {

	$emulsion_title_in_page_header ? '' : emulsion_archive_title();
}

emulsion_have_posts();

if ( ! is_page() ) {

	emulsion_pagination();
}

get_footer();