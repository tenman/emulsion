<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $template;
?>
			</main>
<?php do_action( 'emulsion_append_page_wrapper' ); ?> 
		</div>
<?php get_template_part( 'template-parts/widget', 'sidebar' ); ?>
<?php get_template_part( 'template-parts/widget', 'footer' ); ?>
<?php emulsion_get_supports( 'footer-svg' ) ? get_template_part( 'images/svg' ) : ''; ?>	
<?php wp_footer(); ?>
	</body>
</html>