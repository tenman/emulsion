<?php
is_user_logged_in() ? printf( '<p>%1$s</p>','load PHP template:template.php' ):'';
get_header();
emulsion_the_theme_supports( 'title_in_page_header' ) ? '' : emulsion_archive_title();
emulsion_action( 'emulsion_article_wrapper_before' );
emulsion_have_posts();
emulsion_action( 'emulsion_article_wrapper_after' );
emulsion_pagination();
get_footer();

