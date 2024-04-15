<?php
get_header();
is_user_logged_in() ? printf( '<p style="background:#000;color:#fff">%1$s</p>', 'load PHP template:emulsion/template-parts/template.php' ) : '';
emulsion_action( 'emulsion_article_wrapper_before' );
emulsion_have_posts();
emulsion_action( 'emulsion_article_wrapper_after' );
emulsion_pagination();
get_footer();
