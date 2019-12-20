<h3><?php esc_html_e( 'Theme customizer overview', 'emulsion' ); ?></h3>

<table class="form-table emulsion-document-table">
	<col style="width:25%;" />
	<col style="" />
	<col style="" />
	<tr class="title"><td colspan="2"><h3><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e( 'Header', 'emulsion' ); ?></h3></td></tr>
	<tr class="item-title">
		<th><?php esc_html_e( 'control', 'emulsion' ); ?></th>
		<th><?php esc_html_e( 'description', 'emulsion' ); ?></th>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_header_background_color' ); ?></td>
		<td><?php echo wp_kses_post(emulsion_get_var( 'emulsion_header_background_color', 'description' )); ?></td>

	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_header_gradient' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_header_gradient', 'description' ) ); ?></td>

	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'custom_logo' ); ?></td>
		<td><?php esc_html_e( 'Setting custom-logo will replace site-title site-description with the logo', 'emulsion' ); ?></td>

	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_category_colors' ); ?></td>
		<td><?php esc_html_e( 'Set the color for each category in the header and link', 'emulsion' ); ?></td>

	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'header_textcolor' ); ?></td>
		<td><?php esc_html_e( "The header is automatically colored according to the image, video, and background color", 'emulsion' ); ?>
			</td>

	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_header_layout' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_header_layout', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_title_in_header' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_title_in_header', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-format-image"></span> <?php emulsion_get_customizer_link_element( 'section', 'header_image' ); ?></td>
		<td><?php esc_html_e( 'Header image and video can only be displayed on the homepage.', 'emulsion' ); ?></td>
	</tr>


	<tr class="title"><td colspan="2"><h3><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e( 'Footer', 'emulsion' ); ?></h3></td></tr>
	<tr class="item-title">
		<th><?php esc_html_e( 'control', 'emulsion' ); ?></th>
		<th><?php esc_html_e( 'description', 'emulsion' ); ?></th>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-edit"></span> <?php emulsion_get_customizer_link_element( 'section', 'emulsion_footer_credit' ); ?></td>
		<td><?php esc_html_e( 'You can change footer credits.', 'emulsion' ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span><?php emulsion_get_customizer_link_element( 'section', 'emulsion_footer_columns' ); ?></td>
		<td><?php esc_html_e( 'Footer Widgets can be set in the range of 1-4 columns.', 'emulsion' ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-archive"></span> <?php emulsion_get_customizer_link_element( 'panel', 'widgets' ); ?></td>
		<td><?php esc_html_e( "Please set the widget. It's okay not to set", 'emulsion' ); ?></td>
	</tr>
	<tr class="title"><td colspan="2"><h3><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e( 'Sidebar', 'emulsion' ); ?></h3></td></tr>
	<tr class="item-title">
		<th><?php esc_html_e( 'control', 'emulsion' ); ?></th>
		<th><?php esc_html_e( 'description', 'emulsion' ); ?></th>
	</tr>
	
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_widget_meta_font_size' ); ?></td>
		<td><?php esc_html_e( 'Ajust post text font size', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_widget_meta_font_family' ); ?></td>
		<td ><?php esc_html_e( 'serif or sans-serif', 'emulsion' ) ?></td>		
	</tr>
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_widget_meta_font_transform' ); ?></td>
		<td ><?php esc_html_e( 'uppercase, lowercase, capitalize or none', 'emulsion' ) ?></td>		
	</tr>
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_widget_meta_google_font_url' ); ?></td>
		<td><?php echo wp_kses( emulsion_get_var( 'emulsion_widget_meta_google_font_url', 'description' ), array( 'a' => array( 'href' => array() ) ) ); ?></td>				
	</tr>
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_widget_meta_title' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_widget_meta_title', 'description' ) ); ?></td>
	</tr>

	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_sidebar_position' ); ?></td>
		<td ><?php esc_html_e( 'Left sidebar or right sidebar', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_sidebar_width' ); ?></td>
		<td ><?php esc_html_e( 'Sidebar Width', 'emulsion' ) ?></td>
	</tr>	
	<tr>
		<td><span class="dashicons dashicons-archive"></span> <a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><?php esc_html_e( 'Sidebar Widget', 'emulsion' ); ?></a></td>
		<td><?php esc_html_e( 'There are two types of sidebar widgets, one for posting and one for page.', 'emulsion' ); ?></td>
	</tr>
	<tr class="title"><td colspan="2"><h3><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e( 'Main', 'emulsion' ); ?></h3></td></tr>
	<tr class="item-title">
		<th><?php esc_html_e( 'control', 'emulsion' ); ?></th>
		<th><?php esc_html_e( 'description', 'emulsion' ); ?></th>
	</tr>
	<tr>
		<td>  <span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'background_color' ); ?></td>
		<td><?php esc_html_e( 'It applies to all pages. you can reset the setting in the editor menu.', 'emulsion' ); ?></td>
	</tr>
	<tr>
		<td>  <span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'background_image' ); ?></td>
		<td><?php esc_html_e( 'The background image is only displayed as a single post or page. you can reset the setting in the editor menu.', 'emulsion' ) ?></td>
	</tr>
	<tr class="sub-title"><td colspan="2"><h3><?php esc_html_e( 'General fonts', 'emulsion' ) ?></h3></td></tr>
		<tr class="item-title">
		<th><?php esc_html_e( 'control', 'emulsion' ); ?></th>
		<th><?php esc_html_e( 'description', 'emulsion' ); ?></th>
	</tr>
	<tr><td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_common_font_size' ); ?></td>
		<td><?php esc_html_e( 'Post text font size', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_common_font_family' ); ?></td>
		<td ><?php esc_html_e( 'serif or sans-serif', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_common_google_font_url' ); ?></td>
		<td r><?php echo wp_kses( emulsion_get_var( 'emulsion_common_google_font_url', 'description' ), array( 'a' => array( 'href' => array() ) ) ); ?></td>
	</tr>
	<tr class="sub-title"><td colspan="2"><h3><?php esc_html_e( 'Heading fonts', 'emulsion' ) ?></h3></td></tr>
		<tr class="item-title">
		<th><?php esc_html_e( 'control', 'emulsion' ); ?></th>
		<th><?php esc_html_e( 'description', 'emulsion' ); ?></th>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_heading_font_scale' ); ?></td>
		<td ><?php echo wp_kses_post( emulsion_get_var( 'emulsion_heading_font_scale', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_heading_font_family' ); ?></td>
		<td ><?php esc_html_e( 'serif or sans-serif', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_heading_font_transform' ); ?></td>
		<td ><?php esc_html_e( 'uppercase, lowercase, capitalize or none', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-editor-paragraph"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_heading_google_font_url' ); ?></td>
		<td ><?php echo wp_kses( emulsion_get_var( 'emulsion_heading_google_font_url', 'description' ), array( 'a' => array( 'href' => array() ) ) ); ?></td>		
	</tr>
	<tr class="sub-title"><td colspan="2"><h3><?php esc_html_e( 'Block Editor Blocks', 'emulsion' ) ?></h3></td></tr>
		<tr class="item-title">
		<th><?php esc_html_e( 'control', 'emulsion' ); ?></th>
		<th><?php esc_html_e( 'description', 'emulsion' ); ?></th>
	</tr>
	<tr>
		<td>  <span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_block_columns_section_height' ); ?></td>
		<td><?php esc_html_e( 'Ajust columns block height', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_block_columns_section_bg' ); ?></td>
		<td><?php esc_html_e( 'Set columns block background', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td> <span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_block_gallery_section_height' ); ?></td>
		<td><?php esc_html_e( 'Ajust gallery block height', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_block_gallery_section_bg' ); ?></td>
		<td><?php esc_html_e( 'Set Gallery Block Background', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_box_gap' ); ?></td>
		<td><?php esc_html_e( 'Adjust margin of bordered block', 'emulsion' ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_alignfull' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_alignfull', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_content_width' ); ?></td>

		<td><?php esc_html_e( 'Content width', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_main_width' ); ?></td>

		<td><?php esc_html_e( 'Main content area width ( alignfull width )', 'emulsion' ) ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_favorite_color_palette' ); ?></td>

		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_favorite_color_palette', 'description' ) ); ?></td>
	</tr>
	<tr class="title"><td colspan="2"><h3><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e( 'Archives', 'emulsion' ); ?></h3></td></tr>
	<tr class="item-title">
		<th><?php esc_html_e( 'control', 'emulsion' ); ?></th>
		<th><?php esc_html_e( 'description', 'emulsion' ); ?></th>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_layout_homepage' ); ?></td>
		<td><?php esc_html_e('The layout can be selected from 4 options: grid, stream, excerpt list, full text', 'emulsion')?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_layout_posts_page' ); ?></td>
		<td><?php esc_html_e('The layout can be selected from 4 options: grid, stream, excerpt list, full text', 'emulsion')?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_layout_date_archives' ); ?></td>
		<td><?php esc_html_e('The layout can be selected from 4 options: grid, stream, excerpt list, full text', 'emulsion')?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_layout_category_archives' ); ?></td>
		<td><?php esc_html_e('The layout can be selected from 4 options: grid, stream, excerpt list, full text', 'emulsion')?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_layout_tag_archives' ); ?></td>
		<td><?php esc_html_e('The layout can be selected from 4 options: grid, stream, excerpt list, full text', 'emulsion')?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_layout_author_archives' ); ?></td>
		<td><?php esc_html_e('The layout can be selected from 4 options: grid, stream, excerpt list, full text', 'emulsion')?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-layout"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_layout_search_results' ); ?></td>
		<td><?php esc_html_e('Search Result: 2options  keyword hightlight or full text', 'emulsion')?></td>
	</tr>
	<tr class="title"><td colspan="2"><h3><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e( 'Advanced Settings', 'emulsion' ); ?></h3></td></tr>
	<tr class="item-title">
		<th><?php esc_html_e( 'control', 'emulsion' ); ?></th>
		<th><?php esc_html_e( 'description', 'emulsion' ); ?></th>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_reset_theme_settings' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_reset_theme_settings', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_excerpt_length' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_excerpt_length', 'description' ) ); ?></td>
	</tr>
	<tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_excerpt_linebreak' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_excerpt_linebreak', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_excerpt_length_grid' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_excerpt_length_grid', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_excerpt_length_stream' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_excerpt_length_stream', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_table_of_contents' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_table_of_contents', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_tooltip' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_tooltip', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_sticky_sidebar' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_sticky_sidebar', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_lazyload' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_lazyload', 'description' ) ); ?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-generic"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_instantclick' ); ?></td>
		<td><?php echo wp_kses_post( emulsion_get_var( 'emulsion_instantclick', 'description' ) ); ?></td>
	</tr>
	<tr class="title"><td colspan="2"><h3><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e( 'Other', 'emulsion' ); ?></h3></td></tr>
	<tr class="item-title">
		<th><?php esc_html_e( 'control', 'emulsion' ); ?></th>
		<th><?php esc_html_e( 'description', 'emulsion' ); ?></th>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_relate_posts_bg' ); ?></td>
		<td><?php esc_html_e('Set the background of related articles block', 'emulsion')?></td>
	</tr>
	<tr>
		<td><span class="dashicons dashicons-admin-customizer"></span> <?php emulsion_get_customizer_link_element( 'control', 'emulsion_comments_bg' ); ?></td>
		<td><?php esc_html_e('Set the background of comment block', 'emulsion')?></td>
	</tr>
</table>

<?php

