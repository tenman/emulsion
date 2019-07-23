<?php
	if ( !defined( 'ABSPATH' ) ) {
			exit;
	}
	global $template;
	$emulsion_title_in_page_header = emulsion_get_supports( 'title_in_page_header' );

	get_header();
	
	$emulsion_title_in_page_header ? '': emulsion_archive_title();
	
	emulsion_have_posts();
	
	emulsion_pagination();
	
	get_footer();

