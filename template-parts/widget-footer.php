<div class="footer-layer"><?php
	if ( is_page() && emulsion_the_theme_supports( 'footer_page' ) ) {

		$emulsion_metabox_menu_control	 = get_theme_mod( 'emulsion_condition_display_page_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_page_sidebar' ) );
		$emulsion_metabox_menu_control	 = 'logged_in_user' == $emulsion_metabox_menu_control && ! is_user_logged_in() ? false : true;

		if ( is_active_sidebar( 'sidebar-4' ) && $emulsion_metabox_menu_control ) {
			?>
			<aside class="footer-widget-area  <?php echo esc_attr( emulsion_element_classes( 'footer-widget-area' ) ); ?> <?php emulsion_template_part_names_class( __FILE__ ) ?>" aria-label="footer widget area">
				<ul class="footer-widget-area-lists"><?php
					if ( ! dynamic_sidebar( 'sidebar-4' ) ) {
						echo '<li>';
						emulsion_action( 'emulsion_footer_widget_fallback' );
						echo '</li>';
						echo '<li>';
						emulsion_action( 'emulsion_footer_page_widget_fallback' );
						echo '</li>';
					}
					?></ul>
			</aside>
			<?php
		}
	} elseif ( emulsion_the_theme_supports( 'footer' ) ) {

		$emulsion_metabox_menu_control	 = get_theme_mod( 'emulsion_condition_display_posts_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_posts_sidebar' ) );
		$emulsion_metabox_menu_control	 = 'logged_in_user' == $emulsion_metabox_menu_control && ! is_user_logged_in() ? false : true;

		if ( is_active_sidebar( 'sidebar-2' ) && $emulsion_metabox_menu_control ) {
			?>
			<aside class="footer-widget-area  <?php echo emulsion_theme_addons_exists() ? esc_attr( emulsion_element_classes( 'footer-widget-area' ) ) : ''; ?> <?php emulsion_template_part_names_class( __FILE__ ) ?>" aria-label="sidebar widget area">
				<ul class="footer-widget-area-lists"><?php
					if ( ! dynamic_sidebar( 'sidebar-2' ) ) {
						echo '<li>';
						emulsion_action( 'emulsion_footer_widget_fallback' );
						echo '</li>';
						echo '<li>';
						emulsion_action( 'emulsion_footer_post_widget_fallback' );
						echo '</li>';
					}
					?></ul>
			</aside>
			<?php
		}
	}

	if( 'html' !== get_theme_mod('emulsion_footer_template', emulsion_theme_default_val( 'emulsion_footer_template', 'default') ) ) {

	?><footer class="banner" id="footer"><?php emulsion_footer_text(); ?></footer><?php
	} else {

		 emulsion_block_template_part( 'footer' );
	}
	?>
</div>