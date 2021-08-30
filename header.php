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

		if( 'html' !== get_theme_mod('emulsion_header_template') ) {

			$emulsion_header_type = is_page() ? 'page_header' : 'header';

			emulsion_metabox_display_control( $emulsion_header_type )  ? get_template_part( 'template-parts/header', emulsion_header_layout() ) : '';

		} else {

			if( is_home() ) {
				$template_part = 'header-rich';
			} elseif( is_single() || is_page() ) {
				$template_part = 'header-singular';
			} else {
				$template_part = 'header';
			}

			emulsion_block_template_part( $template_part );

		}

		emulsion_sidebar_manager();
		?>
		<div class="page-wrapper layout">

			<?php emulsion_action('emulsion_prepend_page_wrapper'); ?>

			<main id="main">
				<?php ! have_posts() ? get_template_part( 'template-parts/failed' ) : ''; ?>