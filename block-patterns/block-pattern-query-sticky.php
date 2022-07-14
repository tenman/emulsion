<?php

if ( empty( get_option( 'sticky_posts' ) ) ) {
	return '';
}
if ( is_paged() ) {
	return '';
}

$html = <<<HTML
<!-- wp:query {"queryId":15,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"only","inherit":false},"displayLayout":{"type":"list","columns":3},"className":"pattern-sticky-posts"} -->
<div class="wp-block-query pattern-sticky-posts">
<!-- wp:post-template -->
	<!-- wp:group {"tagName":"article","className":"post loop-item","layout":{"inherit":true}} -->
	<article class="wp-block-group post loop-item">

		<!-- wp:group {"tagName":"header","className":"post-header","layout":{"inherit":true}} -->
		<header class="wp-block-group post-header">
			<!-- wp:group {"className":"post-header-content","layout":{"inherit":true}} -->
			<div class="wp-block-group post-header-content"><!-- wp:post-title {"isLink":true} /--></div>
		<!-- /wp:group -->
		</header>
		<!-- /wp:group -->

		<!-- wp:post-featured-image /-->

		<!-- wp:post-excerpt /-->
	</article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->
<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query -->
HTML;

$html = str_replace( array( PHP_EOL, "\t" ), array( '', '' ), $html );

if ( ( is_home() == true && is_front_page() == true ) || // default
		( is_home() == false && is_front_page() == true )   // static front page
 ) {
	//return $html;
}
return $html;

