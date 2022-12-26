<?php
/**
 * Title: File Not Found
 * Slug: emulsion/page-404
 * Categories: contents, emulsion, recently-added
 * Viewport Width: 1280
 * Inserter: no
 * Keywords: shape
 * Description: Message page if file not found
 */

?>
<!-- wp:group {"tagName":"main","align":"full","className":"alignfull fse-main-category","layout":{"type":"constrained"}} -->
<main class="wp-block-group alignfull">
	<!-- wp:group {"tagName":"article", "className":"file-not-found","layout":{"type":"constrained"}} -->
	<article class="wp-block-group ile-not-found">
		<!-- wp:spacer {"height":"10vh"} -->
		<div style="height:10vh" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:heading {"textAlign":"center"} -->
		<h2 class="has-text-align-center"><?php esc_html_e( 'File not found', 'emulsion' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:search {"label":"Search","buttonText":"Search","buttonUseIcon":true,"align":"center"} /-->
	</article>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->