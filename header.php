<?php

/**
 * Theme emulsion
 * header template part file
 */

$emulsion_metabox_page_header_control	 = emulsion_metabox_display_control( 'page_header' );
$emulsion_metabox_post_header_control	 = emulsion_metabox_display_control( 'header' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?> id="document">
	<head>
		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<?php wp_head(); ?>
	</head>
	<body id="<?php echo esc_attr( emulsion_theme_info( 'Slug', false ) ); ?>" <?php  body_class(); ?>><?php
	
		has_action( 'wp_body_open' ) ? do_action( 'wp_body_open' ) : '';
		
		if ( is_page() ) {

			emulsion_get_supports( 'header' ) && $emulsion_metabox_page_header_control ? get_template_part( 'template-parts/header', emulsion_header_layout() ) : '';
		} elseif ( is_single() ) {

			emulsion_get_supports( 'header' ) && $emulsion_metabox_post_header_control ? get_template_part( 'template-parts/header', emulsion_header_layout() ) : '';
		} elseif ( ! is_singular() ) {

			emulsion_get_supports( 'header' ) ? get_template_part( 'template-parts/header', emulsion_header_layout() ) : '';
		}
		emulsion_sidebar_manager(); 
		?>
		<div class="page-wrapper layout">
			<?php
			if ( has_action( 'emulsion_prepend_page_wrapper' ) ) {
				
				?><div class="placeholder-header"><?php do_action( 'emulsion_prepend_page_wrapper' ); ?></div><?php
			}
			?>
			<main id="main"><?php
			
			