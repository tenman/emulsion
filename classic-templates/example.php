<?php

/**
 * Template Name: Example
 * Template Post Type: post, page
 *
 * This template can only be used when the emulsion-addons plugin is active
 */

get_header( emulsion_get_theme_operation_mode() );

if( 'theme' !== emulsion_get_theme_operation_mode() ) {
	echo '<div class="wp-site-blocks">';

		echo preg_replace('!</[^>]+>!', '', do_blocks('<!-- wp:template-part {"slug":"header-singular","tagName":"header", "align":"full", "className":"fse-header header-layer banner wp-block-template-part-header-singular"} /-->'));
			block_template_part( 'header' );
		echo '</header>';

		echo '<main class="alignfull is-layout-constrained">';

		echo preg_replace('!</[^>]+>!', '', do_blocks( '<!-- wp:template-part {"slug":"post-content","tagName":"div", "align":"full", "className":"article-wrapper"} /-->'));
			block_template_part( 'post-content' );
		echo '</div>';

		print('</main>' );

		echo preg_replace('!</[^>]+>!', '', do_blocks( '<!-- wp:template-part {"slug":"footer", "tagName":"footer", "align":"full", "className":"footer-layer fse-footer banner wp-block-template-part-footer"} /-->'));
			block_template_part( 'footer' );
		echo '</footer>';

	echo '</div>';
} else {

	emulsion_the_theme_supports( 'title_in_page_header' ) ? '' : emulsion_archive_title();

	emulsion_action( 'emulsion_article_wrapper_before' );

	emulsion_have_posts();

	emulsion_action( 'emulsion_article_wrapper_after' );

	emulsion_pagination();


	get_footer();
}



