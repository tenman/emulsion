<?php
/**
 * Template Name: Example 2
 * Template Post Type: post, page
 *
 * This template can only be used when the emulsion-addons plugin is active
 *
 * Example of displaying using the emulsion function, unlike the template example
 */

get_header( emulsion_get_theme_operation_mode() );

if( 'theme' !== emulsion_get_theme_operation_mode() ) {
	echo '<div class="wp-site-blocks">';

			emulsion_block_template_part( 'header' );

			echo do_blocks('<!-- wp:pattern {"slug":"emulsion/primary-menu"} /-->');

		echo '<main class="alignfull is-layout-constrained">';

			emulsion_block_template_part( 'post-content' );

		echo do_blocks('<!-- wp:group {"tagName":"nav","className":"wp-block-post-navigation","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->'
				.'<nav class="wp-block-group wp-block-post-navigation"><!-- wp:post-navigation-link {"type":"previous"} /-->'
				.'<!-- wp:post-navigation-link /-->'
				.'</nav>'
				.'<!-- /wp:group -->');

		print('</main>' );

			emulsion_block_template_part( 'footer' );


	echo '</div>';
} else {

	emulsion_the_theme_supports( 'title_in_page_header' ) ? '' : emulsion_archive_title();

	emulsion_action( 'emulsion_article_wrapper_before' );

	emulsion_have_posts();

	emulsion_action( 'emulsion_article_wrapper_after' );

	emulsion_pagination();


	get_footer();
}