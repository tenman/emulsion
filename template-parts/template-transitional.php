<?php
get_header();
emulsion_the_theme_supports( 'title_in_page_header' ) ? '' : emulsion_archive_title();

is_user_logged_in() ? printf( '<p style="background:#000;color:#fff">%1$s</p>', 'load PHP template:template-transitional.php' ) : '';

if ( is_attachment() ) {

	emulsion_have_posts();
}

if ( is_single() ) {

	emulsion_block_template_part( 'post-content' );
} elseif ( is_page() ) {

	emulsion_block_template_part( 'page-content' );

} elseif ( is_archive() ) {

	emulsion_block_template_part( 'query-post' );
} elseif ( is_search() ) {

	emulsion_block_template_part( 'query-post' );
} elseif ( is_home() ) {

	emulsion_block_template_part( 'query-post' );
}elseif ( is_tag() ) {

	emulsion_block_template_part( 'query-post' );
} elseif ( is_front_page() ) {
	// page id を指定する必要がある
	echo '<p style="color:red;font-weight:bold">has todo page id を指定する必要がある</p>';
	//emulsion_block_template_part( 'page-content' );
}
get_footer();

