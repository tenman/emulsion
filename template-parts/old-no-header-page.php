<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$current_post_type = trim( get_post_type());
?>
<header class="header-layer <?php emulsion_the_header_layer_class(). emulsion_template_identification_class( __FILE__ ) ?>">
		<?php emulsion_site_text_markup(); ?>
	<div class="header-layer-nav-menu" ><?php
				$defaults = array(
					'menu_class'	 => 'menu wp-nav-menu primary top-right',
					'container'		 => 'nav',
					'fallback_cb'	 => '',
					'link_before'	 => '',
					'link_after'	 => '',
					'echo'			 => true,
					'depth'			 => 0,
					'theme_location' => 'primary',
					'items_wrap'	 => '<ul id="%1$s" class="%2$s" data-direction="horizontal">%3$s</ul>',
				);
				wp_nav_menu( $defaults );?></div>
	<?php
		
		the_custom_header_markup();//get_custom_header_markup
		
		the_post_thumbnail(); //get_the_post_thumbnail
	?>
	<?php emulsion_entry_text_markup(); ?>
	
	
	
	<?php // emulsion_search_drawer(); ?>
	<?php do_action( 'emulsion_append_header_layer' ); ?>
<!--page header -->	
</header>
<?php //@see emulsion_template_part_header()