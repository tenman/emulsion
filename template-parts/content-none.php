<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><div class="not-found <?php emulsion_template_identification_class( __FILE__ ) ?>">
	<h2 class="not-found-title"><?php esc_html_e( 'Page not found', 'emulsion' ) ?></h2>
	<p class="fit"><?php esc_html_e( 'Request URL: ', 'emulsion' ); ?><u class="disable"><?php echo esc_url(  emulsion_request_url() ); ?></u></p>
	<p class="fit"><?php esc_html_e( 'We could not find the above page on our server', 'emulsion' ); ?></p>
	<?php /* translators: 1: home_url() link */ ?>
	<p class="fit"><?php
		esc_html_e( 'Alternatively, you can visit the', 'emulsion' );
		printf( ' <a href="%1$s"  rel="home"><u>%2$s</u></a> ', esc_url( home_url( '/' ) ), esc_html__( 'Home', 'emulsion' ) );
		esc_html_e( 'or search using below search form', 'emulsion' );
		?></p>			
		<?php get_search_form(); ?>
</div>