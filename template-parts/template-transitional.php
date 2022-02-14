<?php get_header(); ?>

<?php emulsion_the_theme_supports( 'title_in_page_header' ) ? '' : emulsion_archive_title(); ?>

<?php is_user_logged_in() ? printf( '<p style="background:#000;color:#fff">%1$s</p>', 'load PHP template:template-transitional.php' ) : ''; ?>

<div class="wp-site-blocks">

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

</div>

<?php get_footer(); ?>