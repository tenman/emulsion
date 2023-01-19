<?php
/**
 * fse compatible classic template
 *
 * If you want to use this template, please remove the example- prefix from the file name and rename it to archive.php
 * Place this template in the fse-compatible-classic-template directory
 * Exception: You cannot put front-page.php home.php index.php
 *
 */
?>
<?php get_header( emulsion_get_theme_operation_mode() ); ?>

<div class="wp-site-blocks">

	<?php emulsion_block_template_part( 'header' ) ?>

	<main class="alignfull is-layout-constrained">
		<?php is_singular() ? emulsion_block_template_part( 'post' ) : emulsion_block_template_part( 'query-post' ); ?>
	</main>

	<?php emulsion_block_template_part( 'footer' ) ?>

</div>
<?php get_footer( emulsion_get_theme_operation_mode() ); ?>