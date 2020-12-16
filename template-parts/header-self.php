<?php

/**
 * header template 'Do it myself template'
 * emulsion_site_text_markup() has emulsion_site_text_markup_self filter
 */

?>
<header class="header-layer <?php emulsion_the_header_layer_class() . emulsion_template_part_names_class( __FILE__ ) ?>">
	<?php
	if( has_filter( 'emulsion_site_text_markup_self' ) ) {

		?><div class="header-layer-site-title-navigation is-user-header" ><?php emulsion_site_text_markup(); ?></div><?php
	}
	?>
	<?php emulsion_action('emulsion_append_header_layer');?>
</header>