<?php
/**
 * Title: Emulsion Front Page Sidebar
 * Slug: emulsion/page-front-page-sidebar
 * Categories: recently-added, layout, emulsion
 * Post Types: page, wp_template
 * Template Types: front-page
 * Inserter: no
 * Keywords: page
 * Description: Front Page Example Width Sidebar
 */
?>
<!-- wp:template-part {"slug":"header-rich","tagName":"header","className":"fse-header header-layer alignfull is-pattern-front-page-sidebar"} /-->

<!-- wp:navigation {"__unstableLocation":"primary","align":"full","className":"fse-primary sticky","layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"center","orientation":"horizontal","flexWrap":"nowrap"}} -->
<!-- wp:navigation-link {"label":"Home","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Blog","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Contact","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:columns {"className":"alignfull fse-columns"} -->
<div class="wp-block-columns alignfull fse-columns"><!-- wp:column {"className":"main"} -->
<div class="wp-block-column main"><!-- wp:group {"tagName":"main","align":"full","layout":{"type":"constrained"}} -->
<main class="wp-block-group alignfull"><!-- wp:group {"align":"full","className":"article-wrapper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull article-wrapper"><!-- wp:group {"className":"alignfull post"} -->
<div class="wp-block-group alignfull post"><!-- wp:template-part {"slug":"theme-front-page-demo","align":"full","className":"alignfull entry-content wp-block-template-part-theme-front-page-demo"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></main>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"400px"} -->
<div class="wp-block-column" style="flex-basis:400px"><!-- wp:template-part {"slug":"sidebar","className":"sidebar wp-block-template-sidebar"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:template-part {"slug":"footer","tagName":"footer","align":"full","className":"footer-layer fse-footer banner  alignfull"} /-->
