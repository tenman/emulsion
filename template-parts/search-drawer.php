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
	<input type="checkbox" id="c1" name="c1"  /><label for="c1"><svg class="icon" width="24" height="24" tabindex="0"><desc><?php esc_html_e('Open Search', 'emulsion'); ?></desc><use xlink:href="#search" /></svg></label>
	<div class="drawer search-drawer">
		<div class="drawer-block" >
			<label for="c1" class="close"><svg class="icon" width="24" height="24"><desc><?php esc_html_e('Close Search', 'emulsion'); ?></desc><use xlink:href="#cross" /></svg></label>
			<div class="search-box"><?php get_search_form(); ?></div>
<?php emulsion_action('emulsion_drawer_before'); ?>
			<div class="search-info" aria-hidden="true"><?php

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