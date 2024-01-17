<?php
/**
 * Title: Emulsion Search Results Full Text
 * Slug: emulsion/page-search-full-text
 * Categories: recently-added, layout, emulsion
 * Template Types: search
 * Inserter: no
 * Keywords: search
 * Description: Page Search Results Full Text
 */
?>
<!-- wp:template-part {"slug":"header-singular","theme":"emulsion","tagName":"header","align":"full","className":"fse-header header-layer banner wp-block-template-part-header-singular alignfull is-pattern-search-full-text"} /-->

<!-- wp:query-title {"type":"search","level":2} /-->

<!-- wp:group {"tagName":"main","metadata":{"name":"Main"},"align":"full","className":"main-query"} -->
<main class="wp-block-group alignfull main-query"><!-- wp:query {"queryId":1,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"inherit":true},"align":"full","className":"is-layout-constrained","layout":{"type":"constrained"}} -->
<div class="wp-block-query alignfull is-layout-constrained"><!-- wp:post-template {"layout":{"type":"default"}} -->
<!-- wp:group {"tagName":"article","className":"post loop-item"} -->
<article class="wp-block-group post loop-item"><!-- wp:template-part {"slug":"post-header","theme":"emulsion","tagName":"header","className":"post-header wp-block-template-post-header"} /-->

<!-- wp:post-featured-image /-->

<!-- wp:post-content /--></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results {"align":"full"} -->
<!-- wp:pattern {"slug":"emulsion/404", "align":"full"} /-->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","theme":"emulsion","tagName":"footer","align":"full","className":"footer-layer fse-footer banner  alignfull"} /-->