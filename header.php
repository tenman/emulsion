<?php

/**
 * Theme emulsion
 * header template part file
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> id="document" <?php printf( 'class="%1$s"', esc_attr( emulsion_element_classes( 'root' ) ) ); ?>>
	<head>
		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<?php wp_head(); ?>
	</head>
	<body id="<?php echo esc_attr( emulsion_slug() ); ?>" <?php body_class(); ?>>
		<?php
		has_action( 'wp_body_open' ) ? do_action( 'wp_body_open' ) : '';



			$emulsion_header_type = is_page() ? 'page_header' : 'header';

			emulsion_metabox_display_control( $emulsion_header_type )  ? get_template_part( 'template-parts/header', emulsion_header_layout() ) : '';


		emulsion_sidebar_manager();
		?>
		<div class="page-wrapper layout">

			<?php emulsion_action('emulsion_prepend_page_wrapper'); ?>

			<main id="main">
				<?php ! have_posts() ? get_template_part( 'template-parts/failed' ) : ''; ?>