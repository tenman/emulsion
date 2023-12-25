<div class="article-wrapper <?php emulsion_template_part_names_class( __FILE__ ) ?>">

	<?php $required_password = post_password_required( get_the_ID() ); ?>

	<?php emulsion_action( 'emulsion_article_before' ); ?>

	<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>

		<?php emulsion_article_header(); ?>

		<div class="entry-content is-layout-constrained"><?php
			if ( false === $required_password ) {
				if ( function_exists( 'emulsion_post_content' ) ) {

					emulsion_post_content();
				} else {

					$layout_setting = emulsion_get_layout_setting();

					if ( 'full_text' == $layout_setting && 'post' == $layout_setting || 'page' == $layout_setting || is_singular() ) {
						the_content();
					}

					if ( 'excerpt' == $layout_setting || 'grid' == $layout_setting ) {

						echo '<div class="content-excerpt classic">';
						echo '<p class="wp-block-post-excerpt__excerpt">';

						if ( strpos( $post->post_content, '<!--more-->' ) ) {
							the_content();
						} else {
							the_excerpt();
						}

						echo '</p>';
						echo '</div>';
					}
				}

				wp_link_pages( 'before=<div class="wp-link-pages page-break-links clearfix">&after=</div>&next_or_number=number&pagelink=<span>%</span>' );
				?>
				<?php
			} else {

				echo get_the_password_form();
			}
			?>
		</div>

	</article>
<?php emulsion_action( 'emulsion_article_after' ); ?>
</div>

	<?php if ( is_singular() ) { ?>

	<div class="comment-wrapper is-layout-constrained"><?php emulsion_have_comments(); ?></div>

<?php } ?>
<?php if ( is_single() && ! is_attachment() && emulsion_the_theme_supports( 'relate_posts' ) ) { ?>

	<div class="wrap-emulsion_relate_posts is-layout-constrained"><?php emulsion_related_posts(); ?></div>

<?php } ?>