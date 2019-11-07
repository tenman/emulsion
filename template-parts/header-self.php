<?php
/**
 * header template 'Do it myself template'
 * 
 * emulsion_site_text_markup() has emulsion_site_text_markup_self filter
 */
?>
<header class="header-layer <?php emulsion_the_header_layer_class() . emulsion_template_identification_class( __FILE__ ) ?>">
	<div class="header-layer-site-title-navigation is-user-header" ><?php  emulsion_site_text_markup(); ?></div>
	<?php do_action( 'emulsion_append_header_layer' ); ?>
</header>