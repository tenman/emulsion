<?php

$html = <<<HTML

<!-- wp:template-part {"slug":"header","tagName":"header", "align":"full", "className":"fse-header header-layer default-tpl-header alignfull"} /-->

<!-- wp:group {"align":"full","tagName":"main"} -->
<main class="wp-block-group alignfull">
    <!-- wp:group {"align":"full","className":"article-wrapper"} -->
    <div class="wp-block-group article-wrapper alignfull">

        <!-- wp:group {,"tagName":"article", "align":"full","className":"post"} -->
        <article class="wp-block-group alignfull post">

            <!-- wp:post-featured-image /-->

            <!-- wp:template-part {"slug":"post-header","tagName":"header","className":"post-header wp-block-template-post-header"} /-->

            <!-- wp:post-content /-->

            <!-- wp:template-part {"slug":"post-footer", "tagName":"footer", "className":"post-footer wp-block-template-part-post-footer","style":{"color":{"background":"#eeeeee"}}} /-->

        </article>
        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->

</main>
<!-- /wp:group -->
<!-- wp:group {"align":"wide","tagName":"nav","class":"wp-block-post-navigation"} -->
	<nav class="wp-block-group alignwide wp-block-post-navigation">
	<!-- wp:post-navigation-link {"type":"previous"} /-->
	<!-- wp:post-navigation-link /-->
	</nav>
<!-- /wp:group -->
<!-- wp:template-part {"slug":"footer", "tagName":"footer", "align":"full", "className":"footer-layer fse-footer banner default-tpl-footer alignfull"} /-->
HTML;

$html = str_replace( array(PHP_EOL,"\t"), array('',''), $html );

return $html;