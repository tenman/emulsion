<?php

/**
 * Theme emulsion
 * fallback template file
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action('emulsion_template_pre');
do_action('emulsion_template_pre_'.basename(__FILE__, '.php' ) );

is_post_type_archive() ? emulsion_remove_supports( 'excerpt' ) : '';

global $template;

get_header();

emulsion_get_supports( 'title_in_page_header' ) ? '' : emulsion_archive_title();

emulsion_have_posts();

emulsion_pagination();

get_footer();