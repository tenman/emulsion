<?php

$html = <<<HTML
<!-- wp:buttons -->
<div class="wp-block-buttons modal-open-link emulsion-dependency">
	<!-- wp:button -->
	<div class="wp-block-button">
		<a class="wp-block-button__link" href="./#modal-group-1">modal link text</a>
	</div>
	<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

<!-- wp:group {"className":"emulsion-modal solid-border modal","layout":{"inherit":true}} -->
<div id="modal-group-1" class="wp-block-group emulsion-modal solid-border modal">
	<div class="wp-block-group__inner-container">

		<!-- wp:paragraph {"textAlign":"right","placeholder":"Panel Title","className":"emulsion-modal-title alignfull emulsion-dependency"} -->
		<p class="has-text-align-right emulsion-modal-title emulsion-dependency">
			<a href="./" class="modal-close-link">X</a>
		</p>
		<!-- /wp:paragraph -->

		<!-- wp:group {"className":"emulsion-modal-content", "layout":{"inherit":true}} -->
		<div class="wp-block-group emulsion-modal-content">
			<div class="wp-block-group__inner-container">

					<!-- wp:paragraph {"placeholder":"content"} -->
					<p>content</p>
					<!-- /wp:paragraph -->

			</div>
		</div>
		<!-- /wp:group -->

	</div>
</div>
<!-- /wp:group -->
HTML;

$html = str_replace( array(PHP_EOL,"\t"), array('',''), $html );

return $html;
