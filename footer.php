<?php

/**
 * Theme emulsion
 * footer template part file
 */

if ( true === emulsion_is_custom_post_type() && 'fse' == emulsion_get_theme_operation_mode() ) {

	printf( '<footer class="alignfull footer-layer fse-footer banner wp-block-template-part-footer wp-block-template-part">
    <p class="has-text-align-center">%1$s %2$s %3$s <a href="%4$s" class="emulsion-privacy-policy">%5$s</a></p></footer>',
			esc_html__( 'Copyright', 'emulsion' ),
			absint( date('Y') ),
			esc_html__( 'Site proudly powered by WordPress', 'emulsion' ),
			esc_url( get_privacy_policy_url() ),
			esc_html__( 'Privacy policy', 'emulsion' )
	);
	wp_footer();
} else {
			?></main>
<?php do_action( 'emulsion_append_page_wrapper' ); ?>
		</div>
<?php get_template_part( 'template-parts/widget', 'sidebar' ); ?>
<?php  get_template_part( 'template-parts/widget', 'footer' ); ?>
<?php emulsion_the_theme_supports( 'footer-svg' )  ? get_template_part( 'images/svg' ) : ''; ?>
<?php wp_footer(); ?>
	</body>
</html><?php
}