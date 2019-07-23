<?php
if ( is_page() && false == emulsion_metabox_display_control( 'page_style' ) ) {

	return;
}
if ( is_single() && false == emulsion_metabox_display_control( 'style' ) ) {

	return;
}
if ( ! emulsion_get_supports( 'enqueue' ) ) {
	return;
}
?><div class="drawer-wrapper <?php emulsion_template_identification_class( __FILE__ ) ?>">
	<input type="checkbox" id="c1" name="c1"  /><label for="c1"><svg class="icon" width="24" height="24"><use xlink:href="#search" /></svg></label>
	<div class="drawer search-drawer">
		<div class="drawer-block">
		<label for="c1" class="close"><svg class="icon" width="24" height="24"><use xlink:href="#cross" /></svg></label>
		<div class="search-box">
			<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
				<label>
					<span class="screen-reader-text"><?php esc_html_e( 'Search', 'emulsion' ) ?></span>
					<input type="search" class="search-field" placeholder="<?php esc_html_e( 'Keyword...', 'emulsion' ) ?>" value="" name="s">
				</label>
				<input type="submit" class="search-submit" value="<?php esc_html_e( 'Search', 'emulsion' ) ?>">
			</form>
		</div>
		<?php do_action('emulsion_drawer_before');?>
		<div class="search-info" aria-hidden="true"><?php
			/* hook only this point */
			add_filter( 'wp_list_categories', 'emulsion_add_css_class', 10 );

			function emulsion_add_css_class( $html ) {
				return str_replace( '<ul>', '<ul class="horizontal-list-group">', $html );
			}

			echo '<ul class="taxonomy ">';
			wp_list_categories( array( 'hierarchical' => false, 'title_li' => '<p>' . esc_html__( 'Categories', 'emulsion' ) . '</p>' ) );
			wp_list_categories( array( 'taxonomy' => 'post_tag', 'hierarchical' => false, 'title_li' => '<p>' . esc_html__( 'Tags', 'emulsion' ) . '</p>' ) );
			echo '</ul>';
			?></div>
		<?php do_action('emulsion_drawer_after');?>
		</div>
	</div>
</div>