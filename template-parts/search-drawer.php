<?php
if ( is_page() && false == emulsion_metabox_display_control( 'page_style' ) ) {

return;
}
if ( is_single() && false == emulsion_metabox_display_control( 'style' ) ) {

return;
}
if ( ! emulsion_the_theme_supports( 'enqueue' ) ) {

return;
}
?><div class="drawer-wrapper <?php emulsion_template_part_names_class( __FILE__ ) ?>" tabindex="0">
	<input type="checkbox" id="c1" name="c1"  /><label for="c1"><svg class="icon" width="24" height="24" tabindex="0"><use xlink:href="#search" /></svg></label>
	<div class="drawer search-drawer">
		<div class="drawer-block" >
			<label for="c1" class="close"><svg class="icon" width="24" height="24"><use xlink:href="#cross" /></svg></label>
			<div class="search-box"><?php get_search_form(); ?></div>
<?php emulsion_action('emulsion_drawer_before'); ?>
			<div class="search-info" aria-hidden="true"><?php
			/* hook only this point */

			//add_filter( 'wp_list_categories', 'emulsion_list_categories_filter', 10 );

			function emulsion_list_categories_filter( $html ) {
			return str_replace( '<ul>', '<ul class="horizontal-list-group">', $html );
			}
			/*
			  echo '<ul class="taxonomy">';
			  wp_list_categories(
			  array( 'hierarchical' => false,
			  'title_li' => '<h4>' . esc_html__( 'Categories', 'emulsion' ) . '</h4>',
			  'hide_title_if_empty' => true ,
			  'show_option_none' => '' ) );
			  wp_list_categories(
			  array( 'taxonomy' => 'post_tag',
			  'hierarchical' => false,
			  'title_li' => '<h4>' . esc_html__( 'Tags', 'emulsion' ) . '</h4>',
			  'hide_title_if_empty' => true ,
			  'show_option_none' => '' ) );
			  echo '</ul>'; */
			if ( is_active_sidebar( 'sidebar-5' ) ) {

			?><ul class="search-drawer-content"><?php

				if ( ! dynamic_sidebar( 'sidebar-5' ) ) {

				}
				?></ul>	<?php
			}

				?></div>
				<?php emulsion_action( 'emulsion_drawer_after' ); ?><span class="drawer-end" tabindex="0"></span>

		</div>
	</div>
</div>