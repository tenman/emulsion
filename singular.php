<?php
/**
 * Theme emulsion
 * Single post , page template
 */

do_action('emulsion_template_pre');
do_action('emulsion_template_pre_'.basename(__FILE__, '.php' ) );

get_header();

 ! is_page() &&	emulsion_the_theme_supports( 'title_in_page_header' ) ? '' : emulsion_archive_title();

emulsion_have_posts();

 ! is_page() ?	emulsion_pagination() : '';


get_footer();