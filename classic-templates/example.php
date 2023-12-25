<?php
/**
 * Template Name: Example
 * Template Post Type: post, page
 *
 * The templates in the classic-templates directory are dedicated templates when the customize/Theme Scheme/Theme Operation Mode Setting setting is set to Full Site Editiong Theme
 *
 * If you want the ability to associate specific posts, you'll need PHP templates. This is a template prepared for such a special purpose.
 *
 * If you copy the code below and save it as single.php, classic-templates/single.php will be applied on the post page.
 */
?>

<?php get_header( emulsion_get_theme_operation_mode() ); ?>

<div class="wp-site-blocks">

	<?php emulsion_block_template_part( 'header' ) ?>

	<main class="alignfull is-layout-constrained">
		<?php emulsion_block_template_part( 'post-content' ) ?>
	</main>

	<nav class="wp-block-group wp-block-post-navigation">
		<?php	echo do_blocks('<!-- wp:post-navigation-link {"showTitle":true} /--><!-- wp:post-navigation-link {"type":"previous","showTitle":true} /-->'); ?>
	</nav>

	<?php emulsion_block_template_part( 'footer' ) ?>

</div>

<?php get_footer( emulsion_get_theme_operation_mode() ); ?>
