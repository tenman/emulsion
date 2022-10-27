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
	<!-- wp:group {"tagName":"article","className":"post loop-item","layout":{"type":"constrained"}} -->
	<article class="wp-block-group post loop-item is-layout-constrained">

		<!-- wp:group {"tagName":"header","className":"post-header","layout":{"type":"constrained"}} -->
		<header class="wp-block-group post-header is-layout-constrained">
			<!-- wp:group {"className":"post-header-content","layout":{"type":"constrained"}} -->
			<div class="wp-block-group post-header-content is-layout-constrained"><!-- wp:post-title {"isLink":true} /--></div>
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


return $html;

