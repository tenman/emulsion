<?php
//
if ( is_page() && emulsion_the_theme_supports( 'sidebar_page' ) ) {



	if ( is_active_sidebar( 'sidebar-3' ) ) {
		?><aside class="sidebar-widget-area page-sidebar <?php echo esc_attr( emulsion_element_classes( 'sidebar-widget-area' ) ); ?>  <?php emulsion_template_part_names_class( __FILE__ ) ?>" aria-label="sidebar widget area"><ul class="sidebar-widget-area-lists"><?php
		if ( ! dynamic_sidebar( 'sidebar-3' ) ) {
			echo '<li>';
			emulsion_action( 'emulsion_sidebar_widget_fallback' );
			echo '</li>';
			echo '<li>';
			emulsion_action( 'emulsion_sidebar_page_widget_fallback' );
			echo '</li>';
		}
		?></ul></aside></div><?php
	}
} elseif ( emulsion_the_theme_supports( 'sidebar' ) ) {



	if ( is_active_sidebar( 'sidebar-1' ) ) {
		?><aside class="sidebar-widget-area post-sidebar  <?php //echo esc_attr( emulsion_element_classes( 'sidebar-widget-area' ) ); ?> <?php //emulsion_template_part_names_class( __FILE__ ) ?>" aria-label="sidebar widget area"><ul class="sidebar-widget-area-lists"><?php
				if ( ! dynamic_sidebar( 'sidebar-1' ) ) {
					echo '<li>';
					emulsion_action( 'emulsion_sidebar_widget_fallback' );
					echo '</li>';
					echo '<li>';
					emulsion_action( 'emulsion_sidebar_post_widget_fallback' );
					echo '</li>';
				}
				?></ul></aside></div>
			<?php
	}
}
?>