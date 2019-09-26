<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * default header template
 */

$current_post_type = trim( get_post_type() );

$metabox_menu_control = true;

if( is_page() ) {
	
	$metabox_menu_control	 = emulsion_metabox_display_control( 'page_menu' );
}
if( is_single() ) {
	
	$metabox_menu_control	 = emulsion_metabox_display_control( 'menu' );	
}

?>
<header class="header-layer clearfix <?php emulsion_the_header_layer_class() . emulsion_template_identification_class( __FILE__ ) ?>">
	<?php
	if ( has_post_thumbnail() && 'yes' == get_theme_mod('emulsion_title_in_header', emulsion_get_var('emulsion_title_in_header') ) && is_singular( array( $current_post_type ) ) && ! post_password_required( $post ) ) {
		the_post_thumbnail(); //get_the_post_thumbnail
	} else {
		if ( false !== emulsion_home_type() && ! is_paged() ) {

			the_custom_header_markup(); //get_custom_header_markup
		}
	}
	?>
	<?php emulsion_site_text_markup(); ?>
	<?php emulsion_get_supports( 'title_in_page_header' ) ? emulsion_entry_text_markup() : ''; ?>
	<?php emulsion_get_supports( 'search_drawer' ) ? emulsion_search_drawer() : ''; ?>
	<?php do_action( 'emulsion_append_header_layer' ); ?>
</header>
<?php if( emulsion_get_supports( 'primary_menu' ) && $metabox_menu_control ) { ?>
<div class="<?php echo esc_attr( emulsion_element_classes( 'primary' ) ) ?>"> 
	<input type="checkbox" id="primary-menu-controll" name="primary-menu-controll" data-skin="hamburger" data-mod="button" /><label for="primary-menu-controll"><span></span></label><?php
	$defaults = array(
		'menu_class'	 => 'menu wp-nav-menu primary',
		'container'		 => 'nav',
		'fallback_cb'	 => '',
		'link_before'	 => '',
		'link_after'	 => '',
		'echo'			 => true,
		'depth'			 => 0,
		'theme_location' => 'primary',
		'items_wrap'	 => '<ul id="%1$s" class="%2$s" data-direction="horizontal"><h2 class="screen-reader-text">'.esc_html__('Primary navigation','emulsion').'</h2>%3$s</ul>',
		'walker'         => '',
		'item_spacing'   => 'discard',
	);
	wp_nav_menu( $defaults );
	?>
	<div class="menu-placeholder"><?php if( emulsion_get_supports( 'toc' ) ) { print '<div class="toc"></div>'; }?></div>
</div>
<?php } ?>

