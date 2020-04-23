<?php
/**
 * Theme emulsion
 * header template part file
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> id="document">
	<head>
		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<?php wp_head(); ?>
	</head>
	<body id="<?php echo esc_attr(  emulsion_slug( ) ); ?>" <?php body_class(); ?>>
		<?php

		has_action( 'wp_body_open' ) ? do_action( 'wp_body_open' ) : '';

		$emulsion_header_type = is_page() ? 'page_header' : 'header';

		if(  is_singular() ) {

			emulsion_metabox_display_control( $emulsion_header_type  ) && emulsion_the_theme_supports( 'header' )
			? get_template_part( 'template-parts/header', emulsion_header_layout() )
			: '';

		} else {

			emulsion_the_theme_supports( $emulsion_header_type  )
			? get_template_part( 'template-parts/header', emulsion_header_layout() )
			: '';
		}

		emulsion_sidebar_manager();
		?>
		<div class="page-wrapper layout">
		<?php if ( has_action( 'emulsion_prepend_page_wrapper' ) ) { ?>
			<div class="placeholder-header"><?php do_action( 'emulsion_prepend_page_wrapper' ); ?></div>
		<?php } ?>
			<main id="main">