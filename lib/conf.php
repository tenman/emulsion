<?php

/**
 *
 * @param type $name
 * @param type $type string unit or value
 * @return array
 */
define( 'EMULSION_MIN_PHP_VERSION', '5.6' );

if( ! defined( 'EMULSION_DARK_MODE_SUPPORT') ) {
	
	define( 'EMULSION_DARK_MODE_SUPPORT', false );
}

/**
 * Note:content width
 * required smaller than emulsion_main_width value (default 1280)
 * unit: px
 */
$content_width = ! isset( $content_width ) ? 720 : $content_width;


if ( ! function_exists( 'emulsion_theme_default_val' ) ) {

	function emulsion_theme_default_val( $name, $type = 'val' ) {
		global $content_width;

		/**
		 * If you enable the plugin, it is calculated with dynamic values.
		 * array( note=>*** )
		 * $type unit_val or val
		 */
		$emulsion_default_values = array(
			/**
			 * Background color
			 *
			 * If you don't use the emulsion addons plugin, don't change the background color here.
			 * Instead, in CSS, overwrite the value of CSS variables
			 */
			'emulsion_header_gradient'				 => array( 'default' => 'disable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_header_background_color'		 => array( 'default' => '#eeeeee', 'unit' => '', ),
			'emulsion_header_sub_background_color'	 => array( 'default' => '#ffffff', 'unit' => '', ),
			'emulsion_category_colors'				 => array( 'default' => 'disable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_sidebar_background'			 => array( 'default' => '#ffffff', 'note' => 'emulsion_sidebar_background', 'unit' => '', ),
			'emulsion_primary_menu_background'		 => array( 'default' => '#ffffff', 'note' => 'emulsion_sidebar_background', 'unit' => '', ),
			'emulsion_relate_posts_bg'				 => array( 'default' => '#eeeeee', 'unit' => '', ),
			'emulsion_comments_bg'					 => array( 'default' => '#eeeeee', 'unit' => '', ),
			'emulsion_bg_image_text'				 => array( 'default' => 'current', 'unit' => '', ),
			'emulsion_bg_image_blend_color'			 => array( 'default' => '#000000', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_bg_image_blend_color_amount'	 => array( 'default' => 50, 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_background_css_pattern'		 => array( 'default' => 'none', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_general_link_color'			 => array( 'default' => '#666666', 'note' => 'emulsion_link_colors', 'unit' => '', ),
			'emulsion_general_link_hover_color'		 => array( 'default' => '#333333', 'note' => 'emulsion_hover_colors', 'unit' => '', ),
			'emulsion_general_text_color'			 => array( 'default' => '#333333', 'note' => 'emulsion_contrast_color', 'unit' => '', ),
			/**
			 * Fonts  General
			 */
			'emulsion_common_font_size'			 => array( 'default' => 16, 'unit' => 'px', ), // required emulsion-addons plugin
			'emulsion_common_font_family'		 => array( 'default' => 'sans-serif', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_common_google_font_url'	 => array( 'default' => '', 'unit' => '', ), // required emulsion-addons plugin

			/**
			 * Fonts Heading
			 */
			'emulsion_heading_font_family'		 => array( 'default' => 'serif', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_heading_font_weight'		 => array( 'default' => '700', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_heading_font_base'		 => array( 'default' => '16', 'note' => 'get_theme_mod(emulsion_common_font_size)', 'unit' => 'px', ), // required emulsion-addons plugin
			'emulsion_heading_font_scale'		 => array( 'default' => 'xxx', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_heading_font_transform'	 => array( 'default' => 'uppercase', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_heading_google_font_url'	 => array( 'default' => '', 'unit' => '', ), // required emulsion-addons plugin

			/**
			 * Fonts Widget and metadata
			 */
			'emulsion_widget_meta_font_size'		 => array( 'default' => 13, 'unit' => 'px', ), // required emulsion-addons plugin
			'emulsion_widget_meta_font_family'		 => array( 'default' => 'sans-serif', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_widget_meta_font_transform'	 => array( 'default' => 'none', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_widget_meta_google_font_url'	 => array( 'default' => '', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_widget_meta_title'			 => array( 'default' => false, 'unit' => '', ), // required emulsion-addons plugin

			/**
			 * Layout
			 */
			'emulsion_header_layout'					 => array( 'default' => 'custom', 'unit' => '', ), // custom, simple, self
			'emulsion_header_html'						 => array( 'default' => '', 'unit' => '', ),
			'emulsion_title_in_header'					 => array( 'default' => 'yes', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_header_media_max_height'			 => array( 'default' => 75, 'unit' => 'vh', ),
			'emulsion_sidebar_position'					 => array( 'default' => 'right', 'unit' => '', ), // left, right
			'emulsion_sidebar_width'					 => array( 'default' => 400, 'unit' => 'px', ), //
			'emulsion_condition_display_posts_sidebar'	 => array( 'default' => 'allways', 'unit' => '', ), //logged_in_user, allways
			'emulsion_condition_display_page_sidebar'	 => array( 'default' => 'allways', 'unit' => '', ), //logged_in_user, allways
			'emulsion_main_width'						 => array( 'default' => 1280, 'unit' => 'px', ),
			'emulsion_content_width'					 => array( 'default' => 720, 'note' => '$content_width', 'unit' => 'px', ),
			'emulsion_content_margin_top'				 => array( 'default' => 0, 'unit' => 'px', ),
			/**
			 * Archives Content Layout
			 * 
			 * emulsion_layout_***		full_text, excerpt, grid, stream
			 * emulsion_layout_***_post_image show, hide
			 */
			'emulsion_layout_homepage'						 => array( 'default' => 'excerpt', 'unit' => '', ),
			'emulsion_layout_homepage_post_image'			 => array( 'default' => 'show', 'unit' => '', ),
			'emulsion_layout_posts_page'					 => array( 'default' => 'excerpt', 'unit' => '', ),
			'emulsion_layout_posts_page_post_image'			 => array( 'default' => 'hide', 'unit' => '', ),
			'emulsion_layout_date_archives'					 => array( 'default' => 'grid', 'unit' => '', ),
			'emulsion_layout_date_archives_post_image'		 => array( 'default' => 'show', 'unit' => '', ),
			'emulsion_layout_category_archives'				 => array( 'default' => 'stream', 'unit' => '', ),
			'emulsion_layout_category_archives_post_image'	 => array( 'default' => 'show', 'unit' => '', ),
			'emulsion_layout_tag_archives'					 => array( 'default' => 'stream', 'unit' => '', ),
			'emulsion_layout_tag_archives_post_image'		 => array( 'default' => 'show', 'unit' => '', ),
			'emulsion_layout_author_archives'				 => array( 'default' => 'stream', 'unit' => '', ),
			'emulsion_layout_author_archives_post_image'	 => array( 'default' => 'show', 'unit' => '', ),
			'emulsion_layout_search_results'				 => array( 'default' => 'full_text', 'unit' => '', ),
			'emulsion_layout_search_results_post_image'		 => array( 'default' => 'hide', 'unit' => '', ),
			
			/**
			 * Footer
			 * If the number of footer widgets is less than emulation_footer_columns, they will be evenly distributed.
			 * If there are more footer widgets than emulsion_footer_columns, they will be arranged in emulsion_footer_columns columns.
			 * 
			 * emulsion_footer_columns 1-4
			 */
			'emulsion_footer_credit'	 => array( 'default' => '', 'unit' => '', ),
			'emulsion_footer_columns'	 => array( 'default' => 3, 'unit' => '', ),
			
			/**
			 * Advanced
			 * emulsion_excerpt_length_grid, emulsion_excerpt_length_stream represents the number of lines in the summary display
			 */
			'emulsion_reset_theme_settings'			 => array( 'default' => 'continue', 'unit' => '', ), // do not change
			'emulsion_excerpt_length'				 => array( 'default' => 256, 'unit' => '', ),
			'emulsion_excerpt_linebreak'			 => array( 'default' => 'none', 'unit' => '', ),
			'emulsion_excerpt_length_grid'			 => array( 'default' => 4, 'unit' => '', ),
			'emulsion_excerpt_length_stream'		 => array( 'default' => 2, 'unit' => '', ),
			'emulsion_table_of_contents'			 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_tooltip'						 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_sticky_sidebar'				 => array( 'default' => 'enable', 'unit' => '', ),
			'emulsion_lazyload'						 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_instantclick'					 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_search_drawer'				 => array( 'default' => 'enable', 'unit' => '', ), 
			'emulsion_relate_posts'					 => array( 'default' => 'enable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_customizer_preview_redirect'	 => array( 'default' => 'disable', 'unit' => '', ), // required emulsion-addons plugin

			/**
			 * Block editor
			 */
			'emulsion_alignfull'						 => array( 'default' => 'enable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_box_gap'							 => array( 'default' => 3, 'unit' => 'px', ),
			'emulsion_block_gallery_section_height'		 => array( 'default' => 100, 'unit' => 'vh', ),
			'emulsion_block_gallery_section_bg'			 => array( 'default' => '#ffffff', 'note' => 'emulsion_get_background_color', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_block_columns_section_height'		 => array( 'default' => 0, 'unit' => 'vh', ),
			'emulsion_block_columns_section_bg'			 => array( 'default' => '#ffffff', 'note' => 'emulsion_get_background_color', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_block_media_text_section_height'	 => array( 'default' => 0, 'unit' => 'vh', ),
			'emulsion_block_media_text_section_bg'		 => array( 'default' => '#ffffff', 'note' => 'emulsion_get_background_color', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_colors_for_editor'				 => array( 'default' => 'enable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_favorite_color_palette'			 => array( 'default' => '#bebebe', 'unit' => '', ), // required emulsion-addons plugin

			/**
			 * Post
			 */
			'emulsion_post_display_date'			 => array( 'default' => 'inherit', 'unit' => '', ), // none, inherit
			'emulsion_post_display_date_format'		 => array( 'default' => 'default', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_post_display_author'			 => array( 'default' => 'inherit', 'unit' => '', ), // none, inherit
			'emulsion_post_display_author_format'	 => array( 'default' => 'text', 'unit' => '', ), // text inline block
			'emulsion_post_display_category'		 => array( 'default' => 'inherit', 'unit' => '', ), // none, inherit
			'emulsion_post_display_tag'				 => array( 'default' => 'inherit', 'unit' => '', ), // none, inherit
		);

		
		if ( 'val' === $type ) {

			$result	 = $emulsion_default_values[$name]['default'];
			$result	 = apply_filters( $result . '_filter', $result );
			return $result;
		}
		if ( 'unit_val' === $type ) {
						
			$result	 = $emulsion_default_values[$name]['default'];
			$result	 = apply_filters( $result . '_filter', $result );
			return $result . $emulsion_default_values[$name]['unit'];
		}
	}

}
if ( ! function_exists( 'emulsion_the_theme_supports' ) ) {

	function emulsion_the_theme_supports( $name ) {

		$emulsion_default_supports = array(
			'theme_documents'			 => array( 'default' => false, ), // required emulsion-addons plugin
			'enqueue'					 => array( 'default' => true, ),
			'primary_menu'				 => array( 'default' => true, ),
			'search_drawer'				 => array( 'default' => true, ), // required emulsion-addons plugin
			'search_keyword_highlight'	 => array( 'default' => false, ), // required emulsion-addons plugin
			'sidebar'					 => array( 'default' => true, ),
			'sidebar_page'				 => array( 'default' => true, ),
			'footer'					 => array( 'default' => true, ),
			'footer_page'				 => array( 'default' => true, ),
			'alignfull'					 => array( 'default' => true, ), // required emulsion-addons plugin
			'title_in_page_header'		 => array( 'default' => true, ),
			'toc'						 => array( 'default' => true, ),
			'header'					 => array( 'default' => true, ),
			'background'				 => array( 'default' => false, ), // required emulsion-addons plugin
			'custom-logo'				 => array( 'default' => true, ),
			'social-link-menu'			 => array( 'default' => true, ),
			'footer-svg'				 => array( 'default' => true, ),
			'relate_posts'				 => array( 'default' => true, ),
			'tooltip'					 => array( 'default' => true, ),
			'amp'						 => array( 'default' => false, ), // required emulsion-addons,amp plugin
			'entry_content_filter'		 => array( 'default' => true, ),
			'block_sectionize'			 => array( 'default' => true, ), //Change not recommended
			'background_css_pattern'	 => array( 'default' => false, ), // required emulsion-addons,amp plugin
			'meta_description'			 => array( 'default' => true, ),
			'TGMPA'						 => array( 'default' => true, ),
			'instantclick'				 => array( 'default' => true, ),
			'lazyload'					 => array( 'default' => true, ),
			'excerpt'					 => array( 'default' => true, ),
			'grid'						 => array( 'default' => array( array( 'date' ) ) ),
			'stream'					 => array( 'default' => array( array( 'category', 'post_tag', 'author' ) ) ),
			'metabox'					 => array( 'default' => false ), // required emulsion-addons,amp plugin
		);

		/**
		 * Note:custom post type and layout
		 * You can change the layout of custom post type by writing as follows.
		 * 'grid' => array( 'default' => array ( array ( 'date', 'post_type' => array( 'news' ) ) ) ),
		 */
		if ( function_exists( 'emulsion_get_supports' ) ) {

			return emulsion_get_supports( $name );
		}

		return apply_filters( 'emulsion_the_theme_supports', $emulsion_default_supports[$name]['default'] );
	}

}

/**
 * Theme varsion and slug
 * @param type $echo
 * @return string
 */
function emulsion_version( $echo = false ) {

	$emulsion_current_data			 = wp_get_theme();
	$emulsion_current_data_version	 = $emulsion_current_data->get( 'Version' );

	if ( is_child_theme() ) {

		/**
		 * If you are using child theme, version queries may remain unchanged
		 * when parent themes are updated, sometimes cached
		 */
		$emulsion_this_parent_theme		 = wp_get_theme( get_template() );
		$emulsion_current_data_version	 = $emulsion_this_parent_theme->get( 'Version' ) .
				'-' . $emulsion_current_data_version;
	}

	if ( $echo == true ) {

		echo sanitize_text_field( $emulsion_current_data_version );
	} else {

		return sanitize_text_field( $emulsion_current_data_version );
	}
}

function emulsion_slug( $echo = false ) {

	$emulsion_current_data		 = wp_get_theme();
	$emulsion_current_theme_name = $emulsion_current_data->get( 'Name' );
	$emulsion_current_theme_slug = sanitize_title_with_dashes( $emulsion_current_theme_name );

	if ( $echo == true ) {

		echo $emulsion_current_theme_slug;
	} else {

		return $emulsion_current_theme_slug;
	}
}

