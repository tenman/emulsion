<?php

$html = <<<HTML
<!-- wp:group {"tagName":"header","className":"alignfull fse-header header-layer wp-block-template-part-header-singular wp-block-template-part","layout":{"type":"constrained"}} -->
<header class="wp-block-group alignfull fse-header header-layer wp-block-template-part-header-singular wp-block-template-part">
	<!-- wp:group {"className":"fse-header-content","layout":{"type":"flex"}} -->
	<div class="wp-block-group fse-header-content">
		<!-- wp:site-logo {"width":48} /-->
		<!-- wp:group {"className":"fse-header-text","layout":{"type":"flex"}} -->
		<div class="wp-block-group fse-header-text">
			<!-- wp:site-title /-->
			<!-- wp:site-tagline /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</header>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"emulsion/primary-menu"} /-->

<!-- wp:group {"tagName":"main","align":"full","layout":{"type":"constrained"}} -->
<main class="wp-block-group alignfull">
	<!-- wp:group {"tagName":"article","align":"full","className":"post","layout":{"type":"constrained"}} -->
	<article class="wp-block-group alignfull post"><!-- wp:post-featured-image /-->

	<!-- wp:group {"className":"post-header wp-block-template-post-header wp-block-template-part alignfull centered","layout":{"type":"constrained"}} -->
	<div class="wp-block-group post-header wp-block-template-post-header wp-block-template-part centered alignfull ">
		<!-- wp:group {"className":"post-header-content","layout":{"type":"default"}} -->
		<div class="wp-block-group post-header-content">
			<!-- wp:post-title {"isLink":true} /-->
			<!-- wp:group {"className":"posted-on","layout":{"type":"constrained"}} -->
			<div class="wp-block-group posted-on">
				<!-- wp:post-date {"isLink":true} /-->
				<!-- wp:post-author {"avatarSize":24,"showBio":false} /-->

				<!-- wp:group {"className":"taxsonomy","layout":{"type":"constrained"}} -->
				<div class="wp-block-group taxsonomy"><!-- wp:post-terms {"term":"category"} /-->

					<!-- wp:post-terms {"term":"post_tag"} /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

    <!-- wp:post-content { "align":"full", "layout":{"type":"constrained"}} /-->

	<!-- wp:group {"align":"full","className":"post-footer wp-block-template-part-post-footer wp-block-template-part"} -->
	<div class="wp-block-group alignfull post-footer wp-block-template-part-post-footer wp-block-template-part">
		<!-- wp:comments {"align";"full", className":"wp-block-comments-query-loop comment-wrapper","layout":{"type":"constrained"}} -->
		<div class="wp-block-comments wp-block-comments-query-loop comment-wrapper is-layout-constrained alignfull">

			<!-- wp:comments-title /-->

			<!-- wp:comment-template -->
				<!-- wp:columns -->
				<div class="wp-block-columns"><!-- wp:column {"width":"40px"} -->
					<div class="wp-block-column" style="flex-basis:40px">
						<!-- wp:avatar {"size":40,"style":{"border":{"radius":"20px"}}} /-->
					</div>
					<!-- /wp:column -->
					<!-- wp:column -->
					<div class="wp-block-column">
						<!-- wp:comment-author-name /-->
						<!-- wp:group {"style":{"spacing":{"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"flex"}} -->
						<div class="wp-block-group" style="margin-top:0px;margin-bottom:0px"><!-- wp:comment-date /-->
						<!-- wp:comment-edit-link /-->
					</div>
					<!-- /wp:group -->
						<!-- wp:comment-content /-->
						<!-- wp:comment-reply-link /-->
					</div>
					<!-- /wp:column -->
				</div>
				<!-- /wp:columns -->
			<!-- /wp:comment-template -->

			<!-- wp:comments-pagination -->
			<!-- wp:comments-pagination-previous /-->
			<!-- wp:comments-pagination-numbers /-->
			<!-- wp:comments-pagination-next /-->
			<!-- /wp:comments-pagination -->
			<!-- wp:post-comments-form /-->
		</div>
		<!-- /wp:comments -->
	</div>
	<!-- /wp:group -->
	</article>
<!-- /wp:group -->
</main>
<!-- /wp:group -->

<!-- wp:group {"tagName":"nav","className":"wp-block-post-navigation","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<nav class="wp-block-group wp-block-post-navigation"><!-- wp:post-navigation-link {"showTitle":true} /--><!-- wp:post-navigation-link {"type":"previous","showTitle":true} /-->
</nav>
<!-- /wp:group -->

<!-- wp:group {"tagName":"footer","className":"alignfull footer-layer fse-footer banner  wp-block-template-part"} -->
<footer class="wp-block-group alignfull footer-layer fse-footer banner  wp-block-template-part">
	<!-- wp:pattern {"slug":"emulsion/copyright-notice"} /-->
</footer>
<!-- /wp:group -->
HTML;

$html = str_replace( array( PHP_EOL, "\t" ), array( '', '' ), $html );

return $html;
