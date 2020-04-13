<?php
/**
 * Simple header template
 */
function_exists('emulsion_remove_supports') ? emulsion_remove_supports( 'title_in_page_header' ) : '';
$emulsion_current_post_type		 = trim( get_post_type() );
$emulsion_metabox_menu_control	 = true;

if( is_page() ) {
	
	$emulsion_metabox_menu_control	 = emulsion_metabox_display_control( 'page_menu' );
}
if( is_single() ) {
	
	$emulsion_metabox_menu_control	 = emulsion_metabox_display_control( 'menu' );
}

?>
<header class="header-layer <?php emulsion_the_header_layer_class() . emulsion_template_part_names_class( __FILE__ ) ?>">
	<div class="header-layer-site-title-navigation" >
		<?php  emulsion_site_text_markup(); ?>
		<?php if( emulsion_the_theme_supports( 'primary_menu' ) && $emulsion_metabox_menu_control ) { ?>
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
				'items_wrap'	 => '<h2 class="screen-reader-text">'.esc_html__('Primary navigation','emulsion').'</h2><ul id="%1$s" class="%2$s" data-direction="horizontal"  data-type="accordion">%3$s</ul>',
				'item_spacing'   => 'discard',
			);
			wp_nav_menu( $defaults );
			?>
		</div>
		<?php } ?>
	</div>
	
	<?php emulsion_the_theme_supports( 'title_in_page_header' ) ? emulsion_entry_text_markup() : ''; ?>
	<?php do_action( 'emulsion_append_header_layer' ); ?>
</header>


