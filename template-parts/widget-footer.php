<div class="footer-layer"><?php

	if ( is_page() && emulsion_the_theme_supports( 'footer_page' ) ) {

		$emulsion_metabox_menu_control = get_theme_mod( 'emulsion_condition_display_page_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_page_sidebar' ) );
		$emulsion_metabox_menu_control = 'logged_in_user' == $emulsion_metabox_menu_control && ! is_user_logged_in() ? false : true;

		if ( is_active_sidebar( 'sidebar-4' ) && $emulsion_metabox_menu_control )  { ?>
			<aside class="footer-widget-area  <?php echo esc_attr( emulsion_element_classes( 'footer-widget-area' ) ); ?> <?php emulsion_template_part_names_class( __FILE__ ) ?>">
				<ul class="footer-widget-area-lists"><?php
					if ( ! dynamic_sidebar( 'sidebar-4' ) ) {
						do_action( 'emulsion_footer_widget_fallback', '' );
						do_action( 'emulsion_footer_page_widget_fallback', '' );
					}
					?></ul>
			</aside>
<?php
		}
	} elseif( emulsion_the_theme_supports( 'footer' ) ) {
		
		$emulsion_metabox_menu_control = get_theme_mod( 'emulsion_condition_display_posts_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_posts_sidebar' ) );
		$emulsion_metabox_menu_control = 'logged_in_user' == $emulsion_metabox_menu_control && ! is_user_logged_in() ? false : true;
		
		if ( is_active_sidebar( 'sidebar-2' ) && $emulsion_metabox_menu_control )  {	?>
			<aside class="footer-widget-area  <?php echo function_exists('emulsion_element_classes') ? esc_attr( emulsion_element_classes( 'footer-widget-area' ) ):''; ?> <?php emulsion_template_part_names_class( __FILE__ ) ?>">
				<ul class="footer-widget-area-lists"><?php
					if ( ! dynamic_sidebar( 'sidebar-2' ) ) {
						do_action( 'emulsion_footer_widget_fallback', '' );
						do_action( 'emulsion_footer_post_widget_fallback', '' );
					}
					?></ul>
			</aside>
<?php
		}
	}
?>
	<footer class="banner" id="footer"><?php emulsion_footer_text(); ?></footer>
</div>