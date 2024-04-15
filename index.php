<?php
/**
 * Theme emulsion
 * fallback template file
 */
get_header( emulsion_get_theme_operation_mode() );

if ( true === emulsion_is_custom_post_type() && 'fse' == emulsion_get_theme_operation_mode() ) {
	/**
	 * Template tags are not loaded for the Full Site Editing Theme setting.
	 * But the plugin has a request for a php template. (Ex: bbpress) Fallback for this case.
	 */
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<div class="wp-block-group is-layout-constrained">
				<div style="width:var(--wp--style--global--content-size);margin:var(--wp--custom--margin--block);padding:0 var(--wp--custom--padding--content)">
			<?php the_content(); ?>
				</div>
			</div><?php
		}
	}
} else {

	emulsion_have_posts();
}

get_footer( emulsion_get_theme_operation_mode() );
