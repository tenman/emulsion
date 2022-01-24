<?php

/**
 * Simple header template
 */

emulsion_theme_addons_exists() ? emulsion_remove_supports( 'title_in_page_header' ) : '';
$emulsion_current_post_type		 = trim( get_post_type() );
?>
<header class="header-layer <?php emulsion_the_header_layer_class() . emulsion_template_part_names_class( __FILE__ ) ?>">
	<div class="header-layer-site-title-navigation" >
		<?php  emulsion_site_text_markup(); ?>
<?php if ( emulsion_the_theme_supports( 'primary_menu' )
		&& ( !is_singular() || is_page() && true == emulsion_metabox_display_control( 'page_menu' )
		|| is_single() && true == emulsion_metabox_display_control( 'menu' ) ) ) { ?>
		<div class="header-layer-nav-menu" >
			<input type="checkbox" id="primary-menu-controll" name="primary-menu-controll" data-skin="hamburger" data-mod="form" />
			<label for="primary-menu-controll" title="<?php esc_attr_e( 'menu', 'emulsion' ); ?>"><span tabindex="0"><svg class="description" width="1" height="1"><desc><?php esc_html_e('Menu', 'emulsion'); ?></desc></svg></span></label>
			<?php
			$emulsion_menu_args		 = array(
				'menu_class'	 => 'menu wp-nav-menu primary top-right',
				'container'		 => 'nav',
				'fallback_cb'	 => '',
				'link_before'	 => '',
				'link_after'	 => '',
				'echo'			 => true,
				'depth'			 => 0,
				'theme_location' => 'primary',
				'items_wrap'	 => '<h2 class="screen-reader-text">'.esc_html__('Primary navigation','emulsion').'</h2><ul id="%1$s" class="%2$s" data-direction="horizontal" data-type="accordion">%3$s</ul>',
				'item_spacing'   => 'discard',
			);
			wp_nav_menu( $emulsion_menu_args );
			?>
		</div>
<?php } ?>
	</div>

	<?php emulsion_the_theme_supports( 'title_in_page_header' ) ? emulsion_page_header_title() : ''; ?>
	<?php emulsion_action('emulsion_append_header_layer');?>

	<?php //emulsion_action('emulsion_append_header_layer'); ?>
</header>