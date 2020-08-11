<?php

/**
 * Theme emulsion
 * Search result template file
 */

do_action('emulsion_template_pre');
do_action('emulsion_template_pre_'.basename(__FILE__, '.php' ) );

$emulsion_title_in_page_header = emulsion_the_theme_supports( 'title_in_page_header' );

get_header();

$emulsion_title_in_page_header ? '': emulsion_archive_title();

emulsion_have_posts();

emulsion_pagination();

get_footer();