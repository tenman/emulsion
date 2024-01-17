<?php
/**
 * Title: Emulsion Grid Home
 * Slug: emulsion/page-home-grid
 * Categories: recently-added, layout, emulsion
 * Template Types: posts, home
 * Inserter: no
 * Keywords: home
 * Description: Grid Layout Pattern
 */
?>
<!-- wp:template-part {"slug":"header-rich","theme":"emulsion","tagName":"header","align":"full","className":"fse-header header-layer is-pattern-home-grid"} /-->

<!-- wp:navigation {"__unstableLocation":"primary","align":"full","className":"fse-primary sticky","layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"center","orientation":"horizontal","flexWrap":"nowrap"}} -->
<!-- wp:navigation-link {"label":"Home","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Blog","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Contact","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:columns {"className":"alignfull fse-columns"} -->
<div class="wp-block-columns alignfull fse-columns"><!-- wp:column {"className":"main"} -->
<div class="wp-block-column main"><!-- wp:group {"tagName":"main","align":"full","className":"main-query"} -->
<main class="wp-block-group alignfull main-query"><!-- wp:query {"queryId":1,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"inherit":true},"align":"full","className":"is-layout-constrained","layout":{"type":"constrained"}} -->
<div class="wp-block-query alignfull is-layout-constrained"><!-- wp:post-template {"align":"wide","layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"tagName":"article","className":"post loop-item"} -->
<article class="wp-block-group post loop-item"><!-- wp:template-part {"slug":"post-header","theme":"emulsion","tagName":"header","className":"post-header wp-block-template-post-header"} /-->

<!-- wp:post-featured-image /-->

<!-- wp:post-excerpt /--></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></main>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:template-part {"slug":"footer","theme":"emulsion","tagName":"footer","align":"full","className":"footer-layer fse-footer banner "} /-->