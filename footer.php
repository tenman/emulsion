<?php
/**
 * Theme emulsion
 * footer template part file
 */

$footer_text = sprintf( '</div><footer class="alignfull footer-layer fse-footer banner  wp-block-template-part">%1$s</footer>',
		do_blocks('<!-- wp:pattern {"slug":"emulsion/copyright-notice"} /-->')
);

if ( true === emulsion_is_custom_post_type() && 'fse' == emulsion_get_theme_operation_mode() ) {

	echo $footer_text;
	wp_footer();

} else {

	?></main>
	<?php emulsion_action( 'emulsion_append_page_wrapper' ); ?>
	</div>

	<?php //get_template_part( 'template-parts/widget', 'sidebar' );  ?>
	<?php get_template_part( 'template-parts/widget', 'footer' ); ?>
	<?php emulsion_the_theme_supports( 'footer-svg' )  ? get_template_part( 'images/svg' ) : ''; ?>

	<?php
	echo $footer_text;
	wp_footer();
	?>

	</body>
	</html><?php
}