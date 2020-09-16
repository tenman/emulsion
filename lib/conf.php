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
			'emulsion_header_background_color'		 => array( 'default' => emulsion_theme_default_values('emulsion_header_background_color', '#eeeeee'), 'unit' => '', ),
			'emulsion_header_sub_background_color'	 => array( 'default' => emulsion_theme_default_values('emulsion_header_sub_background_color', '#ffffff'), 'unit' => '', ),
			'emulsion_category_colors'				 => array( 'default' => 'disable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_sidebar_background'			 => array( 'default' => emulsion_theme_default_values('emulsion_sidebar_background','#ffffff'), 'note' => 'emulsion_sidebar_background', 'unit' => '', ),
			'emulsion_primary_menu_background'		 => array( 'default' => emulsion_theme_default_values('emulsion_primary_menu_background','#ffffff'), 'unit' => '', ),
			'emulsion_relate_posts_bg'				 => array( 'default' => emulsion_theme_default_values('emulsion_relate_posts_bg','#eeeeee'), 'unit' => '', ),
			'emulsion_comments_bg'					 => array( 'default' => emulsion_theme_default_values('emulsion_comments_bg', '#eeeeee'), 'unit' => '', ),
			'emulsion_bg_image_text'				 => array( 'default' => emulsion_theme_default_values('emulsion_bg_image_text','current'), 'unit' => '', ),
			'emulsion_bg_image_blend_color'			 => array( 'default' => '#000000', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_bg_image_blend_color_amount'	 => array( 'default' => 50, 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_background_css_pattern'		 => array( 'default' => 'none', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_general_link_color'			 => array( 'default' => emulsion_theme_default_values('emulsion_general_link_color','#666666'), 'note' => 'emulsion_link_colors', 'unit' => '', ),
			'emulsion_general_link_hover_color'		 => array( 'default' => emulsion_theme_default_values('emulsion_general_link_hover_color', '#333333'), 'note' => 'emulsion_hover_colors', 'unit' => '', ),
			'emulsion_general_text_color'			 => array( 'default' => emulsion_theme_default_values('emulsion_general_text_color','#333333'), 'note' => 'emulsion_contrast_color', 'unit' => '', ),
			'emulsion_theme_background_color'		 => array( 'default' => emulsion_theme_default_values('emulsion_background_color','#ffffff'), 'note' => 'emulsion_contrast_color', 'unit' => '', ),
			/**
			 * Fonts  General
			 */
			'emulsion_common_font_size'			 => array( 'default' => 16, 'unit' => 'px', ), // required emulsion-addons plugin
			'emulsion_common_font_family'		 => array( 'default' => 'sans-serif', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_common_google_font_url'	 => array( 'default' =>  '', 'unit' => '', ), // required emulsion-addons plugin

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
			'emulsion_widget_meta_font_size'		 => array( 'default' =>  13, 'unit' => 'px', ), // required emulsion-addons plugin
			'emulsion_widget_meta_font_family'		 => array( 'default' => 'sans-serif', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_widget_meta_font_transform'	 => array( 'default' => 'none', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_widget_meta_google_font_url'	 => array( 'default' => '', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_widget_meta_title'			 => array( 'default' => false, 'unit' => '', ), // required emulsion-addons plugin

			/**
			 * Layout
			 */
			'emulsion_header_layout'					 => array( 'default' => emulsion_theme_default_values('emulsion_header_layout','custom'), 'unit' => '', ), // custom, simple, self
			'emulsion_header_html'						 => array( 'default' => emulsion_theme_default_values('emulsion_header_html',''), 'unit' => '', ),
			'emulsion_title_in_header'					 => array( 'default' => 'yes', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_header_media_max_height'			 => array( 'default' => emulsion_theme_default_values('emulsion_header_media_max_height', 75), 'unit' => 'vh', ),
			'emulsion_sidebar_position'					 => array( 'default' => emulsion_theme_default_values('emulsion_sidebar_position','right'), 'unit' => '', ), // left, right
			'emulsion_sidebar_width'					 => array( 'default' => emulsion_theme_default_values('emulsion_sidebar_width', 400), 'unit' => 'px', ), //
			'emulsion_condition_display_posts_sidebar'	 => array( 'default' => emulsion_theme_default_values('emulsion_condition_display_posts_sidebar', 'allways'), 'unit' => '', ), //logged_in_user, allways
			'emulsion_condition_display_page_sidebar'	 => array( 'default' => emulsion_theme_default_values('emulsion_condition_display_page_sidebar','allways'), 'unit' => '', ), //logged_in_user, allways
			'emulsion_main_width'						 => array( 'default' => emulsion_theme_default_values('emulsion_main_width', 1280), 'unit' => 'px', ),
			'emulsion_content_width'					 => array( 'default' => emulsion_theme_default_values('emulsion_content_width', 720), 'note' => '$content_width', 'unit' => 'px', ),
			'emulsion_content_margin_top'				 => array( 'default' => emulsion_theme_default_values('emulsion_content_margin_top', 0), 'unit' => 'px', ),
			/**
			 * Archives Content Layout
			 * 
			 * emulsion_layout_***		full_text, excerpt, grid, stream
			 * emulsion_layout_***_post_image show, hide
			 */
			'emulsion_layout_homepage'						 => array( 'default' => emulsion_theme_default_values('emulsion_layout_homepage','excerpt'), 'unit' => '', ),
			'emulsion_layout_homepage_post_image'			 => array( 'default' => emulsion_theme_default_values('emulsion_layout_homepage_post_image','show'), 'unit' => '', ),
			'emulsion_layout_posts_page'					 => array( 'default' => emulsion_theme_default_values('emulsion_layout_posts_page','excerpt'), 'unit' => '', ),
			'emulsion_layout_posts_page_post_image'			 => array( 'default' => emulsion_theme_default_values('emulsion_layout_posts_page_post_image','hide'), 'unit' => '', ),
			'emulsion_layout_date_archives'					 => array( 'default' => emulsion_theme_default_values('emulsion_layout_date_archives','grid'), 'unit' => '', ),
			'emulsion_layout_date_archives_post_image'		 => array( 'default' => emulsion_theme_default_values('emulsion_layout_date_archives_post_image','show'), 'unit' => '', ),
			'emulsion_layout_category_archives'				 => array( 'default' => emulsion_theme_default_values('emulsion_layout_category_archives','stream'), 'unit' => '', ),
			'emulsion_layout_category_archives_post_image'	 => array( 'default' => emulsion_theme_default_values('emulsion_layout_category_archives_post_image','show'), 'unit' => '', ),
			'emulsion_layout_tag_archives'					 => array( 'default' => emulsion_theme_default_values('emulsion_layout_tag_archives','stream'), 'unit' => '', ),
			'emulsion_layout_tag_archives_post_image'		 => array( 'default' => emulsion_theme_default_values('emulsion_layout_tag_archives_post_image','show'), 'unit' => '', ),
			'emulsion_layout_author_archives'				 => array( 'default' => emulsion_theme_default_values('emulsion_layout_author_archives','stream'), 'unit' => '', ),
			'emulsion_layout_author_archives_post_image'	 => array( 'default' => emulsion_theme_default_values('emulsion_layout_author_archives_post_image','show'), 'unit' => '', ),
			'emulsion_layout_search_results'				 => array( 'default' => emulsion_theme_default_values('emulsion_layout_search_results','full_text'), 'unit' => '', ),
			'emulsion_layout_search_results_post_image'		 => array( 'default' => emulsion_theme_default_values('emulsion_layout_search_results_post_image','hide'), 'unit' => '', ),
			
			/**
			 * Footer
			 * If the number of footer widgets is less than emulation_footer_columns, they will be evenly distributed.
			 * If there are more footer widgets than emulsion_footer_columns, they will be arranged in emulsion_footer_columns columns.
			 * 
			 * emulsion_footer_columns 1-4
			 */
			'emulsion_footer_credit'	 => array( 'default' => emulsion_theme_default_values('emulsion_footer_credit',''), 'unit' => '', ),
			'emulsion_footer_columns'	 => array( 'default' => emulsion_theme_default_values('emulsion_footer_columns', 3), 'unit' => '', ),
			
			/**
			 * Advanced
			 * emulsion_excerpt_length_grid, emulsion_excerpt_length_stream represents the number of lines in the summary display
			 */
			'emulsion_reset_theme_settings'			 => array( 'default' => 'continue', 'unit' => '', ), // do not change
			'emulsion_excerpt_length'				 => array( 'default' => emulsion_theme_default_values('emulsion_excerpt_length', 256), 'unit' => '', ),
			'emulsion_excerpt_linebreak'			 => array( 'default' => emulsion_theme_default_values('emulsion_excerpt_linebreak','none'), 'unit' => '', ),
			'emulsion_excerpt_length_grid'			 => array( 'default' => emulsion_theme_default_values('emulsion_excerpt_length_grid',4), 'unit' => '', ),
			'emulsion_excerpt_length_stream'		 => array( 'default' => emulsion_theme_default_values('emulsion_excerpt_length_stream', 2), 'unit' => '', ),
			'emulsion_table_of_contents'			 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_tooltip'						 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_sticky_sidebar'				 => array( 'default' => emulsion_theme_default_values('emulsion_sticky_sidebar','enable'), 'unit' => '', ),
			'emulsion_lazyload'						 => array( 'default' => 'disable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_instantclick'					 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_search_drawer'				 => array( 'default' => emulsion_theme_default_values('emulsion_search_drawer','enable'), 'unit' => '', ), 
			'emulsion_relate_posts'					 => array( 'default' => 'enable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_customizer_preview_redirect'	 => array( 'default' => 'disable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_single_post_navigation'		 =>  array( 'default' => emulsion_theme_default_values('emulsion_single_post_navigation', 'enable'), 'unit' => '', ),

			/**
			 * Block editor
			 */
			
			'emulsion_alignfull'						 => array( 'default' => 'enable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_box_gap'							 => array( 'default' => emulsion_theme_default_values('emulsion_box_gap', 3), 'unit' => 'px', ),
			'emulsion_block_gallery_section_height'		 => array( 'default' => emulsion_theme_default_values('emulsion_block_gallery_section_height', 100), 'unit' => 'vh', ),
			'emulsion_block_gallery_section_bg'			 => array( 'default' => '#ffffff', 'note' => 'emulsion_get_background_color', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_block_columns_section_height'		 => array( 'default' => emulsion_theme_default_values('emulsion_block_columns_section_height', 0), 'unit' => 'vh', ),
			'emulsion_block_columns_section_bg'			 => array( 'default' => '#ffffff', 'note' => 'emulsion_get_background_color', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_block_media_text_section_height'	 => array( 'default' => emulsion_theme_default_values('emulsion_block_media_text_section_height', 0), 'unit' => 'vh', ),
			'emulsion_block_media_text_section_bg'		 => array( 'default' => '#ffffff', 'note' => 'emulsion_get_background_color', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_colors_for_editor'				 => array( 'default' => 'enable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_favorite_color_palette'			 => array( 'default' => '#bebebe', 'unit' => '', ), // required emulsion-addons plugin

			/**
			 * Post
			 */
			'emulsion_post_display_date'			 => array( 'default' => emulsion_theme_default_values('emulsion_post_display_date','inherit'), 'unit' => '', ), // none, inherit
			'emulsion_post_display_date_format'		 => array( 'default' => 'default', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_post_display_author'			 => array( 'default' => emulsion_theme_default_values('emulsion_post_display_author','inherit'), 'unit' => '', ), // none, inherit
			'emulsion_post_display_author_format'	 => array( 'default' => emulsion_theme_default_values('emulsion_post_display_author_format','text'), 'unit' => '', ), // text inline block
			'emulsion_post_display_category'		 => array( 'default' => emulsion_theme_default_values('emulsion_post_display_category','inherit'), 'unit' => '', ), // none, inherit
			'emulsion_post_display_tag'				 => array( 'default' => emulsion_theme_default_values('emulsion_post_display_tag', 'inherit'), 'unit' => '', ), // none, inherit
			/**
			 * border
			 */
			'emulsion_border_global'				 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_global', '#eeeeee' ), 'unit' => '', ),
			'emulsion_border_sidebar'				 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_sidebar', '#eeeeee' ), 'unit' => '', ),
			'emulsion_border_grid'					 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_grid', '#eeeeee' ), 'unit' => '', ),
			'emulsion_border_stream'				 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_stream', '#eeeeee' ), 'unit' => '', ),
			'emulsion_border_global_style'			 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_global_style', 'solid' ), 'unit' => '', ),
			'emulsion_border_sidebar_style'			 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_sidebar_style', 'solid' ), 'unit' => '', ),
			'emulsion_border_grid_style'			 => array( 'default' => emulsion_theme_default_values( 'mulsion_border_grid_style', 'solid' ), 'unit' => '', ),
			'emulsion_border_stream_style'			 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_stream_style', 'solid' ), 'unit' => '', ),
			'emulsion_border_global_width'			 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_global_width', 1 ), 'unit' => '', ),
			'emulsion_border_sidebar_width'			 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_sidebar_width', 1 ), 'unit' => '', ),
			'emulsion_border_grid_width'			 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_grid_width', 1 ), 'unit' => '', ),
			'emulsion_border_stream_width'			 => array( 'default' => emulsion_theme_default_values( 'emulsion_border_stream_width', 1 ), 'unit' => '', ),
		);
		
		if(  emulsion_theme_addons_exists() && function_exists('emulsion_addons_default_values') ) {
			if ( 'default' === $type ||  'val' === $type ) {
				
				return emulsion_addons_default_values( $name, $emulsion_default_values[$name]['default'] );
			}
			if ( 'unit_val' === $type ) {
				
				return emulsion_addons_default_values( $name, $emulsion_default_values[$name]['default']. $emulsion_default_values[$name]['unit']);
			}
		}
		
		if ( 'default' === $type ) {

			$result	 = $emulsion_default_values[$name]['default'];
			
			return $result;
		}
		
		if ( 'val' === $type ) {

			$result	 = $emulsion_default_values[$name]['default'];
			$result	 = apply_filters( $result . '_filter', $result );
			$result = get_theme_mod( $name, $result);
			return $result;
		}
		if ( 'unit_val' === $type ) {
						
			$result	 = $emulsion_default_values[$name]['default'];
			$result	 = apply_filters( $result . '_filter', $result );
			$result = get_theme_mod( $name, $result);
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
			'amp'						 => array( 'default' => true, ), 
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
			'viewport'					 => array( 'default' => true, ),
			'block_experimentals'		 => array( 'default' => true, ),
		);

		/**
		 * Note:custom post type and layout
		 * You can change the layout of custom post type by writing as follows.
		 * 'grid' => array( 'default' => array ( array ( 'date', 'post_type' => array( 'news' ) ) ) ),
		 */
		if ( function_exists( 'emulsion_get_supports' ) ) {

			return emulsion_get_supports( $name );
		}

		return apply_filters( 'emulsion_the_theme_supports', $emulsion_default_supports[$name]['default'], $name );
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

function emulsion_theme_default_values( $name, $fallback ) {

	global $content_width;
	
	$scheme = get_theme_mod('emulsion_scheme');
	
	if( ! defined( 'emulsion_theme_scheme' ) ) {
		include( get_template_directory().'/scheme.php');
	}
	
	if ( defined( 'emulsion_theme_scheme' ) && isset( emulsion_theme_scheme[ $scheme ][ $name ] ) ) {

		$function_name			 = emulsion_theme_scheme[ $scheme ][ $name ];
		$function_name_validate	 = $name . '_validate';

		if ( function_exists( $function_name ) &&
				function_exists( $function_name_validate ) &&
				false !== strstr( emulsion_theme_scheme[ $scheme ][ $name ], 'emulsion' ) ) {

			$result = $function_name();

			return $function_name_validate( $result );
		}

		return emulsion_theme_scheme[ $scheme ][ $name ];
	} else {

		return $fallback;
	}
}
add_filter('theme_mod_emulsion__css_variables', 'emulsion_theme_variables');


function emulsion_theme_variables( $variables ){
	
	if( emulsion_theme_addons_exists() ) {
		
		return $variables;
	}
	
	$heading_font_scale				 = emulsion_theme_default_val( 'emulsion_heading_font_scale', 'unit_val' );
	$heading_font_base				 = emulsion_theme_default_val( 'emulsion_heading_font_base', 'unit_val' );
	$header_media_max_height		 = emulsion_theme_default_val( 'emulsion_header_media_max_height', 'unit_val' );
	$post_display_date				 = emulsion_theme_default_val( 'emulsion_post_display_date', 'unit_val' );
	$post_display_author			 = emulsion_theme_default_val( 'emulsion_post_display_author', 'unit_val' );
	$post_display_category			 = emulsion_theme_default_val( 'emulsion_post_display_category', 'unit_val' );
	$post_display_tag				 = emulsion_theme_default_val( 'emulsion_post_display_tag', 'unit_val' );
	$sub_background_color_lighten	 = emulsion_theme_default_val( 'emulsion_post_display_tag', 'unit_val' );
	$favorite_color_palette			 = emulsion_theme_default_val( 'emulsion_favorite_color_palette', 'unit_val' );
	$content_margin_top				 = emulsion_theme_default_val( 'emulsion_content_margin_top', 'unit_val' );
	$general_text_color				 = emulsion_theme_default_val( 'emulsion_general_text_color', 'unit_val' );
	$general_link_color				 = emulsion_theme_default_val( 'emulsion_general_link_color', 'unit_val' );
	$general_link_hover_color		 = emulsion_theme_default_val( 'emulsion_general_link_hover_color', 'unit_val' );
	$excerpt_linebreak				 = emulsion_theme_default_val( 'emulsion_excerpt_linebreak', 'unit_val' );
	$comments_bg					 = emulsion_theme_default_val( 'emulsion_comments_bg', 'unit_val' );
	$sidebar_background				 = emulsion_theme_default_val( 'emulsion_sidebar_background', 'unit_val' );
	$primary_menu_background		 = emulsion_theme_default_val( 'emulsion_primary_menu_background', 'unit_val' );
	$relate_posts_bg				 = emulsion_theme_default_val( 'emulsion_relate_posts_bg', 'unit_val' );
	$media_text_section_bg			 = emulsion_theme_default_val( 'emulsion_block_media_text_section_bg', 'unit_val' );
	$media_text_section_height		 = emulsion_theme_default_val( 'emulsion_block_media_text_section_height', 'unit_val' );
	$columns_section_bg				 = emulsion_theme_default_val( 'emulsion_block_columns_section_bg', 'unit_val' );
	$columns_section_height			 = emulsion_theme_default_val( 'emulsion_block_columns_section_height', 'unit_val' );
	$gallery_section_bg				 = emulsion_theme_default_val( 'emulsion_block_gallery_section_bg', 'unit_val' );
	$gallery_section_height			 = emulsion_theme_default_val( 'emulsion_block_gallery_section_height', 'unit_val' );
	$heading_font_transform			 = emulsion_theme_default_val( 'emulsion_heading_font_transform', 'unit_val' );
	$heading_font_weight			 = emulsion_theme_default_val( 'emulsion_heading_font_weight', 'unit_val' );
	$heading_font_family			 = emulsion_theme_default_val( 'emulsion_heading_font_family', 'unit_val' );
	$common_font_family				 = emulsion_theme_default_val( 'emulsion_common_font_family', 'unit_val' );
	$common_font_size				 = emulsion_theme_default_val( 'emulsion_common_font_size', 'unit_val' );
	$meta_data_font_size			 = emulsion_theme_default_val( 'emulsion_widget_meta_font_size', 'unit_val' );
	$meta_data_font_family			 = emulsion_theme_default_val( 'emulsion_widget_meta_font_family', 'unit_val' );
	$meta_data_font_transform		 = emulsion_theme_default_val( 'emulsion_widget_meta_font_transform', 'unit_val' );
	$align_offset					 = emulsion_theme_default_val( 'emulsion_widget_meta_font_transform', 'unit_val' );
	$main_width						 = emulsion_theme_default_val( 'emulsion_main_width', 'unit_val' );
	$content_width					 = emulsion_theme_default_val( 'emulsion_content_width', 'unit_val' );
	$sidebar_width					 = emulsion_theme_default_val( 'emulsion_sidebar_width', 'unit_val' );
	$content_gap					 = emulsion_theme_default_val( 'emulsion_sidebar_width', 'unit_val' );
	$box_gap						 = emulsion_theme_default_val( 'emulsion_box_gap', 'unit_val' );
	$header_bg_color				 = emulsion_theme_default_val( 'emulsion_header_background_color', 'unit_val' );
	$background_color				 = emulsion_theme_default_val( 'emulsion_theme_background_color', 'unit_val' );
	$background_color				 = sprintf( '#%1$s', get_background_color() );
	$border_global					 = emulsion_theme_default_val( 'emulsion_border_global', 'unit_val' );
	$border_sidebar					 = emulsion_theme_default_val( 'emulsion_border_sidebar', 'unit_val' );
	$border_grid					 = emulsion_theme_default_val( 'emulsion_border_grid', 'unit_val' );
	$border_stream					 = emulsion_theme_default_val( 'emulsion_border_stream', 'unit_val' );
	$border_global_style			 = emulsion_theme_default_val( 'emulsion_border_global_style', 'unit_val' );
	$border_sidebar_style			 = emulsion_theme_default_val( 'emulsion_border_sidebar_style', 'unit_val' );
	$border_grid_style				 = emulsion_theme_default_val( 'emulsion_border_grid_style', 'unit_val' );
	$border_stream_style			 = emulsion_theme_default_val( 'emulsion_border_stream_style', 'unit_val' );
	$border_global_width			 = emulsion_theme_default_val( 'emulsion_border_global_width', 'unit_val' );
	$border_sidebar_width			 = emulsion_theme_default_val( 'emulsion_border_sidebar_width', 'unit_val' );
	$border_grid_width				 = emulsion_theme_default_val( 'emulsion_border_grid_width', 'unit_val' );
	$border_stream_width			 = emulsion_theme_default_val( 'emulsion_border_stream_width', 'unit_val' );
	$header_sub_background_color	= emulsion_theme_default_val( 'emulsion_header_sub_background_color', 'unit_val' );
	

if( 'default' == get_theme_mod('emulsion_scheme' ) ||
	'bloging' == get_theme_mod('emulsion_scheme' ) ||
	'grid' == get_theme_mod('emulsion_scheme' ) ||
	'stream' == get_theme_mod('emulsion_scheme' ) ) {
	$header_text_color = '#333333';
} else {
	$header_text_color = '#ffffff';
}	
	$style = <<<CSS
body{
	/* non addons variables */
	--thm_header_text_color: $header_text_color;
	--thm_header_background_gradient_color:$header_sub_background_color;	
	
	--thm_heading_font_scale:$heading_font_scale;
	--thm_heading_font_base:$heading_font_base;
	--thm_header_media_max_height:$header_media_max_height;
	--thm_post_display_date:$post_display_date;
	--thm_post_display_author:$post_display_author;
	--thm_post_display_category:$post_display_category;
	--thm_post_display_tag:$post_display_tag;
	

	--thm_favorite_color_palette:$favorite_color_palette;
	--thm_header_image_dim:rgba(0,0,0,.3);
	--thm_content_margin_top:$content_margin_top;
	--thm_general_text_color:$general_text_color;
	--thm_general_link_color:$general_link_color;
	--thm_general_link_hover_color:$general_link_hover_color;
	--thm_excerpt_linebreak:$excerpt_linebreak;
	--thm_comments_bg:$comments_bg;
	--thm_sidebar_bg_color:$sidebar_background;
	--thm_primary_menu_background:$primary_menu_background;
	--thm_relate_posts_bg:$relate_posts_bg;
	--thm_media_text_section_bg:$media_text_section_bg;
	--thm_media_text_section_height:$media_text_section_height;
	--thm_columns_section_bg: $columns_section_bg;
    --thm_columns_section_height:$columns_section_height;
	--thm_gallery_section_bg: $gallery_section_bg;
    --thm_gallery_section_height:$gallery_section_height;
    --thm_heading_font_transform:$heading_font_transform;
    --thm_heading_font_weight: $heading_font_weight;
    --thm_heading_font_family: $heading_font_family;
    --thm_common_font_family: $common_font_family;
    --thm_common_font_size: $common_font_size;
    --thm_meta_data_font_size: $meta_data_font_size;
    --thm_meta_data_font_family: $meta_data_font_family;
    --thm_meta_data_font_transform: $meta_data_font_transform;
    --thm_main_width: $main_width;
    --thm_content_width: $content_width;
    --thm_sidebar_width: $sidebar_width;
    /* This variable has a browser width of 1680 px,(--thm_main_width + -sidebar_width) which is unreliable, but it is limited by max-width */
    --thm_main_width-with-sidebar: calc(100vw - var(--thm_sidebar_width) - 48px );
    --thm_box_gap: $box_gap;
    /* when header media not exists */
    --thm_social_icon_color:$general_link_color;
    
     --thm_header_bg_color: $header_bg_color;
    --thm_background_color: $background_color;
	--thm_border_global:$border_global;
	--thm_border_sidebar:$border_sidebar;
	--thm_border_grid:$border_grid;
	--thm_border_stream:$border_stream;
	--thm_border_global_style:$border_global_style;
	--thm_border_sidebar_style:$border_sidebar_style;
	--thm_border_grid_style:$border_grid_style;
	--thm_border_stream_style:$border_stream_style;
	--thm_border_global_width:$border_global_width;
	--thm_border_sidebar_width:$border_sidebar_width;	
	--thm_border_grid_width:$border_grid_width;
	--thm_border_stream_width:$border_stream_width;
}
CSS;
	
	return $style;
}