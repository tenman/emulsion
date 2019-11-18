<?php
/**
 * Simple header template
 */
$current_post_type	 = trim( get_post_type() );
emulsion_remove_supports( 'title_in_page_header' );
$metabox_menu_control = true;

if( is_page() ) {
	$metabox_menu_control	 = emulsion_metabox_display_control( 'page_menu' );
}
if( is_single() ) {
	$metabox_menu_control	 = emulsion_metabox_display_control( 'menu' );
}
?>
<header class="header-layer <?php emulsion_the_header_layer_class() . emulsion_template_identification_class( __FILE__ ) ?>">
	<div class="header-layer-site-title-navigation" >
		<?php  emulsion_site_text_markup(); ?>
		<?php if( emulsion_get_supports( 'primary_menu' ) && $metabox_menu_control ) { ?>
		<div class="header-layer-nav-menu" >
			<input type="checkbox" id="primary-menu-controll" name="primary-menu-controll" data-skin="hamburger" data-mod="button" /><label for="primary-menu-controll"><span tabindex="0"></span></label>
			<?php
			$defaults			 = array(
				'menu_class'	 => 'menu wp-nav-menu primary top-right',
				'container'		 => 'nav',
				'fallback_cb'	 => '',
				'link_before'	 => '',
				'link_after'	 => '',
				'echo'			 => true,
				'depth'			 => 0,
				'theme_location' => 'primary',
				'items_wrap'	 => '<ul id="%1$s" class="%2$s" data-direction="horizontal"  data-type="accordion">%3$s</ul>',
				'item_spacing'   => 'discard',
			);
			wp_nav_menu( $defaults );
			?>
		</div>
		<?php } ?>
	</div>
	
	<?php emulsion_get_supports( 'title_in_page_header' ) ? emulsion_entry_text_markup() : ''; ?>
	<?php do_action( 'emulsion_append_header_layer' ); ?>
</header>


