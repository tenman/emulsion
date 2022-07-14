<?php

$html = <<<HTML
<!-- wp:group {"tagName":"header","className":"alignfull fse-header header-layer wp-block-template-part-header-singular wp-block-template-part","layout":{"inherit":true}} -->
<header class="wp-block-group alignfull fse-header header-layer wp-block-template-part-header-singular wp-block-template-part"><!-- wp:group {"className":"header-text fse-header-content","layout":{"inherit":true}} -->
<div class="wp-block-group header-text fse-header-content"><!-- wp:site-title {"className":"alignleft"} /-->

<!-- wp:site-tagline {"className":"alignleft"} /--></div>
<!-- /wp:group --></header>
<!-- /wp:group -->

<!-- wp:group {"tagName":"main","align":"full","layout":{"inherit":true}} -->
<main class="wp-block-group alignfull"><!-- wp:group {"tagName":"article","align":"full","className":"post","layout":{"inherit":true}} -->
<article class="wp-block-group alignfull post"><!-- wp:post-featured-image /-->

<!-- wp:group {"tagName":"header","className":"post-header wp-block-template-post-header wp-block-template-part","layout":{"inherit":true}} -->
<header class="wp-block-group post-header wp-block-template-post-header wp-block-template-part"><!-- wp:group {"className":"post-header-content","layout":{"inherit":true}} -->
<div class="wp-block-group post-header-content"><!-- wp:post-title {"isLink":true} /--></div>
<!-- /wp:group --></header>
<!-- /wp:group -->

<!-- wp:post-content {"layout":{"inherit":true}} /-->

<!-- wp:group {"className":"post-footer wp-block-template-part-post-footer wp-block-template-part","layout":{"inherit":true}} -->
<div class="wp-block-group post-footer wp-block-template-part-post-footer wp-block-template-part"><!-- wp:post-comments {"className":"comment-wrapper"} /-->

</div>
<!-- /wp:group --></article>
<!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:group {"tagName":"footer","className":"alignfull footer-layer fse-footer banner wp-block-template-part-footer wp-block-template-par"} -->
<footer class="wp-block-group alignfull footer-layer fse-footer banner wp-block-template-part-footer wp-block-template-par"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Copyright © %current_year% Site proudly powered by WordPress %privacy_policy%</p>
<!-- /wp:paragraph --></footer>
<!-- /wp:group -->
HTML;

$html = str_replace( array( PHP_EOL, "\t" ), array( '', '' ), $html );

return $html;

