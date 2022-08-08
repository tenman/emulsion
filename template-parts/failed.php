<?php

if( 'theme' == emulsion_get_theme_operation_mode() ) {

?><div class="emulsion-failed <?php emulsion_template_part_names_class( __FILE__ ) ?>"><?php

	if ( is_search() ) {

		$search_failed_html = '<h2 class="%4$s">%3$s</h2><p class="search-query"><span class="keyword">%1$s</span><span class="separator">:</span><span class="count">%2$s</span></p>';

		printf( $search_failed_html, get_search_query( true ), absint( $wp_query->found_posts ), esc_html__( 'Sorry, no posts matched your search. Please try again', 'emulsion' ), 'fail-search' );

		print get_search_form();
	}

	if ( is_404() ) {

		$file_not_found_html = '<h2 class="not-found-title">%1$s</h2><p>%2$s<u class="disable">%3$s</u></p><p>%4$s</p>';

		printf( $file_not_found_html, esc_html__( 'Page not found', 'emulsion' ), esc_html__( 'Request URL: ', 'emulsion' ), esc_url( emulsion_request_url() ), esc_html__( 'We could not find the above page on our server', 'emulsion' )
		);

		print get_search_form();
	}
?></div><?php
}

