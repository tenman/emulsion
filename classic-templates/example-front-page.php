<?php
/**
 * fse compatible classic template
 *
 * If you want to use this template, please remove the example- prefix from the file name and rename it to archive.php
 * Place this template in the classic-templates directory
 *
 * Please note that this template behaves slightly differently.
 *
 * Just by enabling this template, the display will be the same as home.php.
 * Displays the front page when a static page /home page is specified in the customizer's home page settings.
 */
	get_header( emulsion_get_theme_operation_mode() );
	emulsion_block_template_part( 'header' );
	echo do_blocks('<!-- wp:pattern {"slug":"emulsion/primary-menu"} /-->');
	emulsion_have_posts();
	emulsion_block_template_part( 'footer' );
	get_footer( emulsion_get_theme_operation_mode() );
?>
