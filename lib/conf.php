<?php

/**
 *
 * @param type $name
 * @param type $type string unit or value
 * @return array
 */
define( 'EMULSION_MIN_PHP_VERSION', '5.6' );

if ( ! defined( 'EMULSION_DARK_MODE_SUPPORT' ) ) {

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

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {

			return false;
		}

		/**
		 * If you enable the plugin, it is calculated with dynamic values.
		 * array( note=>*** )
		 * $type unit_val or val
		 */
		$emulsion_default_values = array(
			/**
			 * Used when emulsion addons is not active.
			 * If the plugin is active, use the default value of
			 * $emulsion_customize_args in emulsion-addons / includes / conf.php.
			 */
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
			'emulsion_sidebar_background'			 => array( 'default' => '#ffffff', 'unit' => '', 'note' => 'emulsion_sidebar_background' ),
			'emulsion_primary_menu_background'		 => array( 'default' => '#ffffff', 'unit' => '', ),
			'emulsion_relate_posts_bg'				 => array( 'default' => '#eeeeee', 'unit' => '', ),
			'emulsion_comments_bg'					 => array( 'default' => '#eeeeee', 'unit' => '', ),
			'emulsion_bg_image_text'				 => array( 'default' => 'current', 'unit' => '', ),
			'emulsion_bg_image_blend_color'			 => array( 'default' => '#000000', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_bg_image_blend_color_amount'	 => array( 'default' => 50, 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_background_css_pattern'		 => array( 'default' => 'none', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_general_link_color'			 => array( 'default' => '#666666', 'unit' => '', 'note' => 'emulsion_link_colors', ),
			'emulsion_general_link_hover_color'		 => array( 'default' => '#333333', 'unit' => '', 'note' => 'emulsion_hover_colors', ),
			'emulsion_general_text_color'			 => array( 'default' => '#333333', 'unit' => '', 'note' => 'emulsion_contrast_color', ),
			'background_color'						 => array( 'default' => get_theme_mod( 'background_color' ), 'note' => 'emulsion_contrast_color', 'unit' => '', ),
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
			'emulsion_heading_font_base'		 => array( 'default' => 16, 'unit' => '', 'note' => 'get_theme_mod(emulsion_common_font_size)', ), // required emulsion-addons plugin
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
			'emulsion_content_width'					 => array( 'default' => 720, 'unit' => 'px', 'note' => '$content_width', ),
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
			'emulsion_lazyload'						 => array( 'default' => 'disable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_instantclick'					 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_search_drawer'				 => array( 'default' => 'enable', 'unit' => '', ),
			'emulsion_relate_posts'					 => array( 'default' => 'enable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_customizer_preview_redirect'	 => array( 'default' => 'disable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_single_post_navigation'		 => array( 'default' => 'enable', 'unit' => '', ),
			/**
			 * Block editor
			 */
			'emulsion_alignfull'				 => array( 'default' => 'enable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_box_gap'					 => array( 'default' => 3, 'unit' => 'px', ),
			'emulsion_colors_for_editor'		 => array( 'default' => 'enable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_favorite_color_palette'	 => array( 'default' => '#bebebe', 'unit' => '', ), // required emulsion-addons plugin

			/**
			 * Post
			 */
			'emulsion_post_display_date'			 => array( 'default' => 'inherit', 'unit' => '', ), // none, inherit
			'emulsion_post_display_date_format'		 => array( 'default' => 'default', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_post_display_author'			 => array( 'default' => 'inherit', 'unit' => '', ), // none, inherit
			'emulsion_post_display_author_format'	 => array( 'default' => 'text', 'unit' => '', ), // text inline block
			'emulsion_post_display_category'		 => array( 'default' => 'inherit', 'unit' => '', ), // none, inherit
			'emulsion_post_display_tag'				 => array( 'default' => 'inherit', 'unit' => '', ), // none, inherit

			/**
			 * border
			 */
			'emulsion_border_global'		 => array( 'default' => '#bcbcbc', 'unit' => '', ),
			'emulsion_border_sidebar'		 => array( 'default' => '#bcbcbc', 'unit' => '', ),
			'emulsion_border_grid'			 => array( 'default' => '#bcbcbc', 'unit' => '', ),
			'emulsion_border_stream'		 => array( 'default' => '#bcbcbc', 'unit' => '', ),
			'emulsion_border_global_style'	 => array( 'default' => 'solid', 'unit' => '', ),
			'emulsion_border_sidebar_style'	 => array( 'default' => 'solid', 'unit' => '', ),
			'emulsion_border_grid_style'	 => array( 'default' => 'solid', 'unit' => '', ),
			'emulsion_border_stream_style'	 => array( 'default' => 'solid', 'unit' => '', ),
			'emulsion_border_global_width'	 => array( 'default' => 1, 'unit' => 'px', ),
			'emulsion_border_sidebar_width'	 => array( 'default' => 1, 'unit' => 'px', ),
			'emulsion_border_grid_width'	 => array( 'default' => 1, 'unit' => 'px', ),
			'emulsion_border_stream_width'	 => array( 'default' => 1, 'unit' => 'px', ),

			/**
			 * Theme Customizer for Block Editor
			 */
			'emulsion_header_template' => array( 'default' => 'default', 'unit' => '', ),
			'emulsion_footer_template' => array( 'default' => 'default', 'unit' => '', ),
			'emulsion_editor_support'  => array( 'default' => 'transitional', 'unit' => '', ),
		);

			$exclude_name = array('emulsion_header_template', 'emulsion_footer_template','emulsion_editor_support' );

		if ( emulsion_theme_addons_exists() && function_exists( 'emulsion_addons_default_values' )
				&&  ! in_array( $name, $exclude_name, true ) ) {

			if ( 'default' === $type || 'val' === $type ) {

				return emulsion_addons_default_values( $name, $emulsion_default_values[$name]['default'] );
			}
			if ( 'unit_val' === $type ) {

				return emulsion_addons_default_values( $name, $emulsion_default_values[$name]['default'] . $emulsion_default_values[$name]['unit'] );
			}
		}

		if ( 'default' === $type ) {

			$result = emulsion_theme_default_values( $name, $emulsion_default_values[$name]['default'] );

			return $result;
		}

		if ( 'val' === $type ) {

			$result	 = emulsion_theme_default_values( $name, $emulsion_default_values[$name]['default'] );
			$result	 = get_theme_mod( $name, $result );

			return $result;
		}
		if ( 'unit_val' === $type ) {

			$result	 = emulsion_theme_default_values( $name, $emulsion_default_values[$name]['default'] );
			$result	 = get_theme_mod( $name, $result );

			return $result . $emulsion_default_values[$name]['unit'];
		}
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

	if ( ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $fallback;
	}

	$scheme			 = get_theme_mod( 'emulsion_scheme' );
	$include_path	 = get_template_directory() . '/scheme.php';
	$settings		 = md5( serialize( get_theme_mods() ) );
	$transient_name	 = sprintf( '%1$s-%2$s-%3$s-%4$s', $scheme, $name, md5_file( $include_path ), $settings );

	$transient_val = get_transient( $transient_name );

	if ( false === $transient_val ) {

		if ( ! defined( 'emulsion_theme_scheme' ) ) {

			include( $include_path );
		}

		if ( defined( 'emulsion_theme_scheme' ) && isset( emulsion_theme_scheme[$scheme][$name] ) ) {

			$function_name			 = emulsion_theme_scheme[$scheme][$name];
			$function_name_validate	 = $name . '_validate';

			if ( function_exists( $function_name ) &&
					function_exists( $function_name_validate ) &&
					false !== strstr( emulsion_theme_scheme[$scheme][$name], 'emulsion' ) ) {

				$function = $function_name();

				$result = $function_name_validate( $function );
			}

			$result = get_theme_mod( $name, emulsion_theme_scheme[$scheme][$name] );
		} else {

			$result = get_theme_mod( $name, $fallback );
		}

		set_transient( $transient_name, $result, DAY_IN_SECONDS );

		return $result;
	} else {

		return $transient_val;
	}
}


add_filter( 'theme_mod_emulsion__css_variables', 'emulsion_theme_variables' );

function emulsion_theme_variables( $variables ) {
	/**
	 * Auxiliary for scheme settings to work plugin-independently
	 */

	if ( emulsion_theme_addons_exists() ) {

		return $variables;
	}

	if ( ( false == get_theme_mod( 'emulsion_scheme' ) || 'default' == get_theme_mod( 'emulsion_scheme' ) )
			&& ! emulsion_theme_addons_exists()
			&& 'fse' == emulsion_get_theme_operation_mode()
	) {

		return '.emulsion-addons-inactive body{' . EMULSION_DEFAULT_VARIABLES . '}';
	}


	$heading_font_scale				 = emulsion_theme_default_val( 'emulsion_heading_font_scale', 'unit_val' );
	$heading_font_base				 = emulsion_theme_default_val( 'emulsion_heading_font_base' );
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

	$heading_font_transform		 = emulsion_theme_default_val( 'emulsion_heading_font_transform', 'unit_val' );
	$heading_font_weight		 = emulsion_theme_default_val( 'emulsion_heading_font_weight', 'unit_val' );
	$heading_font_family		 = emulsion_theme_default_val( 'emulsion_heading_font_family', 'unit_val' );
	$common_font_family			 = emulsion_theme_default_val( 'emulsion_common_font_family', 'unit_val' );
	$common_font_size			 = emulsion_theme_default_val( 'emulsion_common_font_size', 'unit_val' );
	$meta_data_font_size		 = emulsion_theme_default_val( 'emulsion_widget_meta_font_size', 'unit_val' );
	$meta_data_font_family		 = emulsion_theme_default_val( 'emulsion_widget_meta_font_family', 'unit_val' );
	$meta_data_font_transform	 = emulsion_theme_default_val( 'emulsion_widget_meta_font_transform', 'unit_val' );
	$align_offset				 = emulsion_theme_default_val( 'emulsion_widget_meta_font_transform', 'unit_val' );
	$main_width					 = emulsion_theme_default_val( 'emulsion_main_width', 'unit_val' );
	$content_width				 = emulsion_theme_default_val( 'emulsion_content_width', 'unit_val' );
	$sidebar_width				 = emulsion_theme_default_val( 'emulsion_sidebar_width', 'unit_val' );
	$content_gap				 = emulsion_theme_default_val( 'emulsion_sidebar_width', 'unit_val' );
	$box_gap					 = emulsion_theme_default_val( 'emulsion_box_gap', 'unit_val' );
	$header_bg_color			 = emulsion_theme_default_val( 'emulsion_header_background_color', 'unit_val' );
	$header_text_color			 = sanitize_hex_color( emulsion_accessible_color( $header_bg_color ) );

	$background_color		 = sanitize_hex_color( sprintf( '#%1$s', emulsion_theme_default_val( 'background_color', 'unit_val' ) ) );
	$border_global			 = emulsion_theme_default_val( 'emulsion_border_global', 'unit_val' );
	$border_sidebar			 = emulsion_theme_default_val( 'emulsion_border_sidebar', 'unit_val' );
	$border_grid			 = emulsion_theme_default_val( 'emulsion_border_grid', 'unit_val' );
	$border_stream			 = emulsion_theme_default_val( 'emulsion_border_stream', 'unit_val' );
	$border_global_style	 = emulsion_theme_default_val( 'emulsion_border_global_style', 'unit_val' );
	$border_sidebar_style	 = emulsion_theme_default_val( 'emulsion_border_sidebar_style', 'unit_val' );
	$border_grid_style		 = emulsion_theme_default_val( 'emulsion_border_grid_style', 'unit_val' );
	$border_stream_style	 = emulsion_theme_default_val( 'emulsion_border_stream_style', 'unit_val' );
	$border_global_width	 = emulsion_theme_default_val( 'emulsion_border_global_width', 'unit_val' );
	$border_sidebar_width	 = emulsion_theme_default_val( 'emulsion_border_sidebar_width', 'unit_val' );
	$border_grid_width		 = emulsion_theme_default_val( 'emulsion_border_grid_width', 'unit_val' );
	$border_stream_width	 = emulsion_theme_default_val( 'emulsion_border_stream_width', 'unit_val' );

	if ( ( ! empty( get_header_textcolor() ) && is_home() && ! has_header_image() && ! is_header_video_active() ) ||
			( ! empty( get_header_textcolor() ) && is_singular() && ! has_post_thumbnail() ) ) {

		$header_text_color = sprintf( '#%1$s', get_header_textcolor() );
	}


	$header_sub_background_color = emulsion_theme_default_val( 'emulsion_header_sub_background_color', 'unit_val' );

	$relate_posts_background_color	 = get_theme_mod( 'emulsion_relate_posts_bg', emulsion_theme_default_val( 'emulsion_relate_posts_bg', 'unit_val' ) );
	$relate_posts_text_color		 = sanitize_hex_color( emulsion_accessible_color( $relate_posts_background_color ) );

	$comments_background_color	 = get_theme_mod( 'emulsion_comments_bg', emulsion_theme_default_val( 'emulsion_comments_bg', 'unit_val' ) );
	$comments_text_color		 = sanitize_hex_color( emulsion_accessible_color( $comments_background_color ) );

	$sidebar_text_color = sanitize_hex_color( emulsion_accessible_color( $sidebar_background ) );

	$primary_menu_link_color = sanitize_hex_color( emulsion_accessible_color( $primary_menu_background ) );

	$style = <<<CSS
.emulsion-addons-inactive body{
	/* non addons variables @see emulsion_theme_variables */

	--thm_border_global:$border_global;
	--thm_border_global_style:$border_global_style;
	--thm_border_global_width:$border_global_width;
	--thm_border_grid:$border_grid;
	--thm_border_grid_style:$border_grid_style;
	--thm_border_grid_width:$border_grid_width;
	--thm_border_sidebar:$border_sidebar;
	--thm_border_sidebar_style:$border_sidebar_style;
	--thm_border_sidebar_width:$border_sidebar_width;
	--thm_border_stream:$border_stream;
	--thm_border_stream_style:$border_stream_style;
	--thm_border_stream_width:$border_stream_width;
	--thm_comments_bg:$comments_bg;
	--thm_comments_color:$comments_text_color;
	--thm_content_margin_top:$content_margin_top;
	--thm_excerpt_linebreak:$excerpt_linebreak;
	--thm_favorite_color_palette:$favorite_color_palette;

	--thm_general_link_color:$general_link_color;
	--thm_general_link_hover_color:$general_link_hover_color;
	--thm_general_text_color:$general_text_color;
	--thm_header_background_gradient_color:$header_sub_background_color;
	--thm_header_hover_color:$header_text_color;
	--thm_header_image_dim:rgba(0,0,0,.3);
	--thm_header_link_color: $header_text_color;
	--thm_header_media_max_height:$header_media_max_height;
	--thm_header_text_color:$header_text_color;
	--thm_heading_font_base:$heading_font_base;
	--thm_heading_font_scale:$heading_font_scale;

	--thm_post_display_author:$post_display_author;
	--thm_post_display_category:$post_display_category;
	--thm_post_display_date:$post_display_date;
	--thm_post_display_tag:$post_display_tag;
	--thm_primary_menu_background:$primary_menu_background;
	--thm_primary_menu_link_color:$primary_menu_link_color;
	--thm_primary_menu_color:$primary_menu_link_color;
	--thm_relate_posts_bg:$relate_posts_bg;
	--thm_relate_posts_link_color: $relate_posts_text_color;
	--thm_sidebar_bg_color:$sidebar_background;
	--thm_sidebar_link_color: $sidebar_text_color;
	--thm_sidebar_text_color: $sidebar_text_color;
    --thm_background_color: $background_color;
    --thm_box_gap: $box_gap;

    --thm_comments_link_color:$comments_text_color;
    --thm_common_font_family: $common_font_family;
    --thm_common_font_size: $common_font_size;
	--thm_common_line_height:1.15;
	--thm_content_line_height:1.5;
    --thm_content_width: $content_width;
	--thm_wide_width: 920px;
    --thm_header_bg_color: $header_bg_color;
    --thm_heading_font_family: $heading_font_family;
    --thm_heading_font_transform:$heading_font_transform;
    --thm_heading_font_weight: $heading_font_weight;
    /*--thm_main_width-with-sidebar: calc(100vw - var(--thm_sidebar_width) - 48px);*/
    --thm_main_width: $main_width;
    --thm_meta_data_font_family: $meta_data_font_family;
    --thm_meta_data_font_size: $meta_data_font_size;
    --thm_meta_data_font_transform: $meta_data_font_transform;
    --thm_relate_posts_color: $relate_posts_text_color;
    --thm_sidebar_hover_color: $sidebar_text_color;
    --thm_sidebar_text_color: $sidebar_text_color;
    --thm_sidebar_width: $sidebar_width;
    --thm_social_icon_color:$general_link_color;
	--thm_h6_font_size:calc(var(--thm_heading_font_base, 16) * 0.6875px);
	--thm_h5_font_size:calc(var(--thm_heading_font_base, 16) * 0.8125px);
	--thm_h4_font_size:calc(var(--thm_heading_font_base, 16) * 1px);
	--thm_h3_font_size:calc(var(--thm_heading_font_base, 16) * 1.5px);
	--thm_h2_font_size:calc(var(--thm_heading_font_base, 16) * 2px);
	--thm_h1_font_size:calc(var(--thm_heading_font_base, 16) * 3px);
	--thm_footer_widget_width:30%;
	--thm_content_min_width:296px;


}
CSS;

	return $style;
}
