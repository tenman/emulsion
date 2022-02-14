<?php get_header( 'fse' ); ?>
<div class="wp-site-blocks">

	<?php emulsion_block_template_part( 'header' ); ?>

	<?php is_user_logged_in() ? printf( '<p style="background:#000;color:#fff">%1$s</p>', 'load PHP template:emulsion/template-parts/template-fse.php' ) : ''; ?>

	<main class="wp-block-group alignfull">
		<?php
		if ( is_attachment() ) {

			emulsion_have_posts();
		} elseif ( is_single() ) {

			emulsion_block_template_part( 'post-content' );
		} elseif ( is_page() ) {

			emulsion_block_template_part( 'page-content' );
		} else {

			emulsion_block_template_part( 'query-post' );
		}
		?>
	</main>

	<?php emulsion_block_template_part( 'footer' ); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>

