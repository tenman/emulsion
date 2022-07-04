<?php
/**
 * Theme emulsion
 * header template part file
 */
if ( true === emulsion_is_custom_post_type() && 'fse' == emulsion_get_theme_operation_mode() ) {


	/**
	 * Template tags are not loaded for the Full Site Editing Theme setting.
	 * But the plugin has a request for a php template. (Ex: bbpress) Fallback for this case.
	 */
	get_template_part( 'header', 'fse' );

	emulsion_block_template_part( 'header' );
} else {
	?><!DOCTYPE html>
	<html <?php language_attributes(); ?> id="document" <?php printf( 'class="%1$s"', esc_attr( emulsion_element_classes( 'root' ) ) ); ?>>
		<head>
			<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
			<?php wp_head(); ?>
		</head>
		<body id="<?php echo esc_attr( emulsion_slug() ); ?>" <?php body_class(); ?>>
			<?php
			has_action( 'wp_body_open' ) ? do_action( 'wp_body_open' ) : '';

			emulsion_header_manager();

			emulsion_sidebar_manager();
			?>
			<div class="page-wrapper layout">

				<?php emulsion_action( 'emulsion_prepend_page_wrapper' ); ?>

				<main id="main">
					<?php ! have_posts() ? get_template_part( 'template-parts/failed' ) : ''; ?>

	<?php
}
?>
