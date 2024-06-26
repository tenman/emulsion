<?php
/**
 * Title: Emulsion Sidebar Single
 * Slug: emulsion/page-single-sidebar
 * Categories: recently-added, layout, emulsion
 * Template Types: single
 * Inserter: no
 * Keywords: single
 * Description: Post with Sidebar
 */
?>
<!-- wp:template-part {"slug":"header-singular","tagName":"header","align":"full","className":"fse-header header-layer banner wp-block-template-part-header-singular is-pattern-single-sidebar"} /-->

<!-- wp:navigation {"__unstableLocation":"primary","align":"full","className":"fse-primary sticky","layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"center","orientation":"horizontal","flexWrap":"nowrap"}} -->
<!-- wp:navigation-link {"label":"Home","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Blog","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Contact","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:columns {"className":"alignfull fse-columns"} -->
<div class="wp-block-columns alignfull fse-columns"><!-- wp:column {"className":"main"} -->
<div class="wp-block-column main"><!-- wp:group {"tagName":"main","align":"full","className":"","layout":{"type":"constrained"},"metadata":{"name":"Main"}} -->
<main class="wp-block-group alignfull"><!-- wp:template-part {"slug":"post-content","tagName":"div","align":"full","className":"article-wrapper"} /--></main>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"400px"} -->
<div class="wp-block-column" style="flex-basis:400px"><!-- wp:pattern {"slug":"emulsion/sidebar-single"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"tagName":"nav","className":"wp-block-post-navigation","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"},"metadata":{"name":"Post Navigation"}} -->
<nav class="wp-block-group wp-block-post-navigation"><!-- wp:post-navigation-link {"showTitle":true} /-->

<!-- wp:post-navigation-link {"type":"previous","showTitle":true} /--></nav>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer","align":"full","className":"footer-layer fse-footer banner "} /-->
