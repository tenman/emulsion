<?php
/**
 * Template Name: 2col has widget area
 * Template Post Type: post, page
 *
 * fse compatible classic template
 *
 * Place this template in the classic-templates directory
 *
 */

global $template;

if ( 'fse' !== emulsion_get_theme_operation_mode() && strstr( $template, '/classic-templates/' ) ) {

	/* Templates in the classic directory are used as backwards compatible templates only if the Customizer theme scheme is the Full Site Editing Theme. */

	get_template_part( 'index' );

	return;
}
?>
<?php get_header( emulsion_get_theme_operation_mode() ); ?>
<div class="wp-site-blocks">

	<?php emulsion_block_template_part( 'header-2col' ) ?>
	<?php echo do_blocks('<!-- wp:pattern {"slug":"emulsion/primary-menu"} /-->'); ?>

	<div class="is-layout-flex alignfull has-sidebar-widget-area fse-columns">

		<main class="alignfull is-layout-constrained">
			<?php is_singular() ? emulsion_block_template_part( 'post-content' ) : emulsion_block_template_part( 'query-post' ); ?>
		</main>

		<?php
		if ( is_single() ) {
			if ( is_active_sidebar( 'sidebar-1' ) ) {
				?>
				<aside class="sidebar-widget-area post-sidebar" aria-label="sidebar widget area">
					<ul class="sidebar-widget-area-lists">
						<?php dynamic_sidebar( 'sidebar-1' ) ?>
					</ul>
				</aside>
				<?php
			}
		}
		if ( is_page() ) {
			if ( is_active_sidebar( 'sidebar-3' ) ) {
				?>
				<aside class="sidebar-widget-area post-sidebar" aria-label="sidebar widget area">
					<ul class="sidebar-widget-area-lists">
						<?php dynamic_sidebar( 'sidebar-3' ) ?>
					</ul>
				</aside>
				<?php
			}
		}
		?>

	</div>

	<nav class="wp-block-group wp-block-post-navigation">
		<?php	echo do_blocks('<!-- wp:post-navigation-link {"showTitle":true} /--><!-- wp:post-navigation-link {"type":"previous","showTitle":true} /-->'); ?>
	</nav>

	<?php emulsion_block_template_part( 'footer' ) ?>

</div>
<?php get_footer( emulsion_get_theme_operation_mode() ); ?>