<?php
/**
 * 
 * @param type $name
 * @param type $type string unit or value
 * @return array
 */
define( 'EMULSION_MIN_PHP_VERSION', '5.6' );
define( 'EMULSION_DARK_MODE_SUPPORT', false );

/**
 * Note:content width
 * required smaller than emulsion_main_width value (default 1280)
 * unit: px
 */
$content_width = ! isset( $content_width ) ? 720 : $content_width;

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
		 */
		'emulsion_header_gradient'						 => array( 'default' => 'disable', 'unit' => '', ),
		'emulsion_header_background_color'				 => array( 'default' => '#ffffff', 'unit' => '', ),
		'emulsion_header_sub_background_color'			 => array( 'default' => '#ffffff', 'unit' => '', ),
		'emulsion_category_colors'						 => array( 'default' => 'disable', 'unit' => '', ),
		'emulsion_sidebar_background'					 => array( 'default' => '#ffffff', 'note' => 'emulsion_sidebar_background', 'unit' => '', ),
		'emulsion_primary_menu_background'				 => array( 'default' => '#ffffff', 'note' => 'emulsion_sidebar_background', 'unit' => '', ),
		'emulsion_relate_posts_bg'						 => array( 'default' => '#eeeeee', 'unit' => '', ),
		'emulsion_comments_bg'							 => array( 'default' => '#eeeeee', 'unit' => '', ),
		'emulsion_bg_image_text'						 => array( 'default' => 'current', 'unit' => '', ),
		'emulsion_bg_image_blend_color'					 => array( 'default' => '#000000', 'unit' => '', ),
		'emulsion_bg_image_blend_color_amount'			 => array( 'default' => 50, 'unit' => '', ),
		'emulsion_background_css_pattern'				 => array( 'default' => 'none', 'unit' => '', ),
		'emulsion_general_link_color'					 => array( 'default' => '#666666', 'note' => 'emulsion_link_colors', 'unit' => '', ),
		'emulsion_general_link_hover_color'				 => array( 'default' => '#333333', 'note' => 'emulsion_hover_colors', 'unit' => '', ),
		'emulsion_general_text_color'					 => array( 'default' => '#333333', 'note' => 'emulsion_contrast_color', 'unit' => '', ),
		
		/**
		 * Fonts  General
		 */
		'emulsion_common_font_size'						 => array( 'default' => 16, 'unit' => 'px', ),
		'emulsion_common_font_family'					 => array( 'default' => 'sans-serif', 'unit' => '', ),
		'emulsion_common_google_font_url'				 => array( 'default' => '', 'unit' => '', ),
		
		/**
		 * Fonts Heading
		 */
		'emulsion_heading_font_family'					 => array( 'default' => 'serif', 'unit' => '', ),
		'emulsion_heading_font_weight'					 => array( 'default' => '700', 'unit' => '', ),
		'emulsion_heading_font_base'					 => array( 'default' => '16', 'note' => 'get_theme_mod(emulsion_common_font_size)', 'unit' => 'px', ),
		'emulsion_heading_font_scale'					 => array( 'default' => 'xxx', 'unit' => '', ),
		'emulsion_heading_font_transform'				 => array( 'default' => 'uppercase', 'unit' => '', ),
		'emulsion_heading_google_font_url'				 => array( 'default' => '', 'unit' => '', ),
		
		/**
		 * Fonts Widget and metadata
		 */
		'emulsion_widget_meta_font_size'				 => array( 'default' => 13, 'unit' => 'px', ),
		'emulsion_widget_meta_font_family'				 => array( 'default' => 'sans-serif', 'unit' => '', ),
		'emulsion_widget_meta_font_transform'			 => array( 'default' => 'none', 'unit' => '', ),
		'emulsion_widget_meta_google_font_url'			 => array( 'default' => '', 'unit' => '', ),
		'emulsion_widget_meta_title'					 => array( 'default'	 => false, 'unit' => '', ),
		
		/**
		 * Layout
		 */
		'emulsion_header_layout'						 => array( 'default' => 'custom', 'unit' => '', ),
		'emulsion_header_html'							 => array( 'default' => '', 'unit' => '', ),
		'emulsion_title_in_header'						 => array( 'default' => 'yes', 'unit' => '', ),
		'emulsion_header_media_max_height'				 => array( 'default' => 75, 'unit' => 'vh', ),
		'emulsion_sidebar_position'						 => array( 'default' => 'right', 'unit' => '', ),
		'emulsion_sidebar_width'						 => array( 'default' => 400, 'unit' => 'px', ),
		'emulsion_condition_display_posts_sidebar'		 => array( 'default' => 'allways', 'unit' => '', ),
		'emulsion_condition_display_page_sidebar'		 => array( 'default' => 'allways', 'unit' => '', ),
		'emulsion_main_width'							 => array( 'default' => 1280, 'unit' => 'px', ),
		'emulsion_content_width'						 => array( 'default' => 720, 'note' => '$content_width', 'unit' => 'px', ),// do not change value
		'emulsion_content_margin_top'					 => array( 'default' => 0, 'unit' => 'px', ),
		
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
		'emulsion_layout_search_results'				 => array( 'default' => 'highlight', 'unit' => '', ),
		'emulsion_layout_search_results_post_image'		 => array( 'default' => 'hide', 'unit' => '', ),
		
		/**
		 * Footer
		 */
		'emulsion_footer_credit'						 => array( 'default' => '', 'unit' => '', ),
		'emulsion_footer_columns'						 => array( 'default' => 3, 'unit' => '', ),
		
		/**
		 * Advanced
		 */
		'emulsion_reset_theme_settings'					 => array( 'default' => 'continue', 'unit' => '', ),
		'emulsion_excerpt_length'						 => array( 'default' => 256, 'unit' => '', ),
		'emulsion_excerpt_linebreak'					 => array( 'default' => 'none', 'unit' => '', ),
		'emulsion_excerpt_length_grid'					 => array( 'default' => 4, 'unit' => '', ),
		'emulsion_excerpt_length_stream'				 => array( 'default' => 2, 'unit' => '', ),
		'emulsion_table_of_contents'					 => array( 'default' => 'disable', 'unit' => '', ),
		'emulsion_tooltip'								 => array( 'default' => 'enable', 'unit' => '', ),
		'emulsion_sticky_sidebar'						 => array( 'default' => 'enable', 'unit' => '', ),
		'emulsion_lazyload'								 => array( 'default' => 'disable', 'unit' => '', ),
		'emulsion_instantclick'							 => array( 'default' => 'disable', 'unit' => '', ),
		'emulsion_search_drawer'						 => array( 'default' => 'disable', 'unit' => '', ),
		'emulsion_relate_posts'							 => array( 'default' => 'enable', 'unit' => '', ),
		'emulsion_customizer_preview_redirect'			 => array( 'default' => 'disable', 'unit' => '', ),
		
		/**
		 * Block editor
		 */
		'emulsion_alignfull'							 => array( 'default' => 'enable', 'unit' => '', ),
		'emulsion_box_gap'								 => array( 'default' => 3, 'unit' => 'px', ),
		'emulsion_block_gallery_section_height'			 => array( 'default' => 0, 'unit' => 'vh', ),
		'emulsion_block_gallery_section_bg'				 => array( 'default' => '#ffffff', 'note' => 'emulsion_get_background_color', 'unit' => '', ),
		'emulsion_block_columns_section_height'			 => array( 'default' => 0, 'unit' => 'vh', ),
		'emulsion_block_columns_section_bg'				 => array( 'default' => '#ffffff', 'note' => 'emulsion_get_background_color', 'unit' => '', ),
		'emulsion_block_media_text_section_height'		 => array( 'default' => 0, 'unit' => 'vh', ),
		'emulsion_block_media_text_section_bg'			 => array( 'default' => '#ffffff', 'note' => 'emulsion_get_background_color', 'unit' => '', ),
		'emulsion_colors_for_editor'					 => array( 'default' => 'enable', 'unit' => '', ),
		'emulsion_favorite_color_palette'				 => array( 'default' => '#bebebe', 'unit' => '', ),
		
		/**
		 * Post
		 */
		'emulsion_post_display_date'					 => array( 'default' => 'inherit', 'unit' => '', ),
		'emulsion_post_display_date_format'				 => array( 'default' => 'default', 'unit' => '', ),
		'emulsion_post_display_author'					 => array( 'default' => 'inherit', 'unit' => '', ),
		'emulsion_post_display_author_format'			 => array( 'default' => 'text', 'unit' => '', ),
		'emulsion_post_display_category'				 => array( 'default' => 'inherit', 'unit' => '', ),
		'emulsion_post_display_tag'						 => array( 'default' => 'inherit', 'unit' => '', ),
		'unit'											 => '', );
	
		if ( 'val' === $type ) {

			$result	 = $emulsion_default_values[ $name ]['default'];
			$result	 = apply_filters( $result . '_filter', $result );
			return $result;
		}
		if ( 'unit_val' === $type ) {

			$result	 = $emulsion_default_values[ $name ]['default'];
			$result	 = apply_filters( $result . '_filter', $result );
			return $result . $emulsion_default_values[ $name ]['unit'];
		}
}

function emulsion_the_theme_supports( $name ) {

	$emulsion_default_supports = array(
		'theme_documents'			 => array( 'default' => false, ),
		'enqueue'					 => array( 'default' => true, ),
		'primary_menu'				 => array( 'default' => true, ),
		'search_drawer'				 => array( 'default' => false, ),
		'search_keyword_highlight'	 => array( 'default' => false, ),
		'sidebar'					 => array( 'default' => true, ),
		'sidebar_page'				 => array( 'default' => true, ),
		'footer'					 => array( 'default' => true, ),
		'footer_page'				 => array( 'default' => true, ),
		'alignfull'					 => array( 'default' => true, ),
		'title_in_page_header'		 => array( 'default' => true, ),
		'toc'						 => array( 'default' => true, ),
		'header'					 => array( 'default' => true, ),
		'background'				 => array( 'default' => false, ),
		'custom-logo'				 => array( 'default' => true, ),
		'social-link-menu'			 => array( 'default' => true, ),
		'footer-svg'				 => array( 'default' => true, ),
		'excerpt'					 => array( 'default' => true, ),
		'relate_posts'				 => array( 'default' => true, ),
		'tooltip'					 => array( 'default' => true, ),
		'amp'						 => array( 'default' => false, ),
		'entry_content_filter'		 => array( 'default' => true, ),
		'block_sectionize'			 => array( 'default' => true, ),
		'background_css_pattern'	 => array( 'default' => false, ),
		'meta_description'			 => array( 'default' => true, ),
		'TGMPA'						 => array( 'default' => true, ),
		'instantclick'				 => array( 'default' => true, ),
		'lazyload'					 => array( 'default' => true, ),
		'grid'						 => array( 'default' => false ),
		'stream'					 => array( 'default' => false ),
		'metabox'					 => array( 'default' => false )
	);

	if ( function_exists( 'emulsion_get_supports' ) ) {

		return emulsion_get_supports( $name );
	}

	return apply_filters( 'emulsion_the_theme_supports', $emulsion_default_supports[ $name ]['default'] );
}