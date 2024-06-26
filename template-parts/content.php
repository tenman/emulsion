<?php

if ( is_page() ) {

	$has_column = is_active_sidebar( 'sidebar-3' ) ? 'has-sidebar' : 'no-sidebar';
} else {

	$has_column = is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : 'no-sidebar';
}

printf( '<div class="fse-columns is-layout-flex wp-block-columns classic %1$s">', esc_attr( $has_column ) );

?>
<div class="wp-block-column main">
	<?php
	if ( have_posts() ) {

		while ( have_posts() ) {

			the_post();
			?>

			<div class="article-wrapper <?php emulsion_template_part_names_class( __FILE__ ) ?>">

				<?php $required_password = post_password_required( get_the_ID() ); ?>

				<?php emulsion_action( 'emulsion_article_before' ); ?>

				<article id="post-<?php the_ID() ?>" <?php //post_class();      ?>>

					<?php emulsion_article_header(); ?>

					<div class="entry-content wp-block-post-content is-layout-constrained"><?php
					if ( false === $required_password ) {

						emulsion_post_content();

						wp_link_pages( 'before=<div class="wp-link-pages page-break-links clearfix">&after=</div>&next_or_number=number&pagelink=<span>%</span>' );
						?>
							<?php
						} else {

							echo get_the_password_form();
						}
						?>
					</div>
					<footer>
						<?php if ( is_singular() ) { ?>

							<div class="comment-wrapper is-layout-constrained"><?php emulsion_have_comments(); ?></div>
						<?php } ?>
						<?php if ( is_single() && ! is_attachment() ) { ?>

							<div class="wrap-emulsion_relate_posts is-layout-constrained"><?php emulsion_related_posts(); ?></div>
						<?php } ?>
					</footer>

				</article>

				<?php emulsion_action( 'emulsion_article_after' ); ?>

				<?php emulsion_pagination(); ?>

			</div>

		<?php
	}
}
?>

</div>

<div class="wp-block-column" style="flex-basis:400px">
<?php get_template_part( 'template-parts/widget', 'sidebar' ); ?>
</div>
</div>
