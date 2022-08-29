<?php

$html = <<<HTML
<!-- wp:group {"tagName":"header","className":"alignfull fse-header header-layer wp-block-template-part-header-singular wp-block-template-part","layout":{"inherit":true}} -->
<header class="wp-block-group alignfull fse-header header-layer wp-block-template-part-header-singular wp-block-template-part">
<!-- wp:group {"className":"fse-header-content","layout":{"inherit":true}} -->

<div class="wp-block-group fse-header-content">
<!-- wp:site-logo {"width":48} /-->
	<!-- wp:group {"className":"fse-header-text","layout":{"inherit":false}} -->
    <div class="wp-block-group fse-header-text">
		<!-- wp:site-title {"className":"alignleft"} /-->
		<!-- wp:site-tagline {"className":"alignleft"} /-->
		    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->
</header>
<!-- /wp:group -->

<!-- wp:navigation {"__unstableLocation":"primary","align":"full","className":"fse-primary","layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} /-->

<!-- wp:group {"tagName":"main","align":"full","layout":{"inherit":true}} -->
<main class="wp-block-group alignfull"><!-- wp:group {"tagName":"article","align":"full","className":"post","layout":{"inherit":true}} -->
<article class="wp-block-group alignfull post"><!-- wp:post-featured-image /-->

<!-- wp:group {"tagName":"header","className":"post-header wp-block-template-post-header wp-block-template-part","layout":{"inherit":true}} -->
<header class="wp-block-group post-header wp-block-template-post-header wp-block-template-part">
	<!-- wp:group {"className":"post-header-content","layout":{"inherit":true}} -->
<div class="wp-block-group post-header-content"><!-- wp:post-title {"isLink":true} /-->

<!-- wp:group {"className":"posted-on","layout":{"inherit":true}} -->
<div class="wp-block-group posted-on"><!-- wp:post-date {"isLink":true} /-->

<!-- wp:post-author {"avatarSize":24,"showBio":false} /-->

<!-- wp:template-part {"slug":"taxsonomy","className":"taxsonomy wp-block-template-part-taxsonomy"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></header>
<!-- /wp:group -->

<!-- wp:post-content {"layout":{"inherit":true}} /-->

<!-- wp:group {"className":"post-footer wp-block-template-part-post-footer wp-block-template-part","layout":{"inherit":true}} -->
<div class="wp-block-group post-footer wp-block-template-part-post-footer wp-block-template-part">
	<!-- wp:comments-query-loop {"className":"comment-wrapper"} -->
<div class="wp-block-comments-query-loop comment-wrapper">
    <!-- wp:comments-title /-->

    <!-- wp:comment-template -->
    <!-- wp:columns -->
    <div class="wp-block-columns"><!-- wp:column {"width":"40px"} -->
        <div class="wp-block-column" style="flex-basis:40px"><!-- wp:avatar {"size":40,"style":{"border":{"radius":"20px"}}} /--></div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column">
            <!-- wp:comment-author-name /-->

            <!-- wp:group {"style":{"spacing":{"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"flex"}} -->
            <div class="wp-block-group" style="margin-top:0px;margin-bottom:0px">
                <!-- wp:comment-date /-->
                <!-- wp:comment-edit-link /-->
            </div>
            <!-- /wp:group -->
            <!-- wp:comment-content /-->
            <!-- wp:comment-reply-link /-->
        </div>
        <!-- /wp:column --></div>
    <!-- /wp:columns -->
    <!-- /wp:comment-template -->

    <!-- wp:comments-pagination -->
        <!-- wp:comments-pagination-previous /-->
        <!-- wp:comments-pagination-numbers /-->
        <!-- wp:comments-pagination-next /-->
    <!-- /wp:comments-pagination -->

    <!-- wp:post-comments-form /-->
</div>
<!-- /wp:comments-query-loop -->
    <!-- wp:pattern {"slug":"emulsion/block-pattern-relate-posts"} /-->
</div>
<!-- /wp:group --></article>
<!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:group {"tagName":"nav","className":"wp-block-post-navigation","layout":{"inherit":true}} -->
<nav class="wp-block-group wp-block-post-navigation"><!-- wp:post-navigation-link {"type":"previous"} /-->

<!-- wp:post-navigation-link /--></nav>
<!-- /wp:group -->

<!-- wp:group {"tagName":"footer","className":"alignfull footer-layer fse-footer banner wp-block-template-part-footer wp-block-template-part"} -->
<footer class="wp-block-group alignfull footer-layer fse-footer banner wp-block-template-part-footer wp-block-template-part"><!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Copyright © %current_year% Site proudly powered by WordPress %privacy_policy%</p>
<!-- /wp:paragraph --></footer>
<!-- /wp:group -->
HTML;

$html = str_replace( array( PHP_EOL, "\t" ), array( '', '' ), $html );

return $html;
