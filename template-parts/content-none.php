<div class="not-found <?php emulsion_template_part_names_class( __FILE__ ) ?>">
	<h2 class="not-found-title"><?php esc_html_e( 'Page not found', 'emulsion' ) ?></h2>
	<p><?php esc_html_e( 'Request URL: ', 'emulsion' ); ?><u class="disable"><?php echo esc_url(  emulsion_request_url() ); ?></u></p>
	<p><?php esc_html_e( 'We could not find the above page on our server', 'emulsion' ); ?></p>
	<?php get_search_form(); ?>
</div>