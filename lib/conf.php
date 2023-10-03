<?php

/**
 *
 * @param type $name
 * @param type $type string unit or value
 * @return array
 */
define( 'EMULSION_MIN_PHP_VERSION', '7.0' );

if ( ! defined( 'EMULSION_DARK_MODE_SUPPORT' ) ) {
	$emulsion_dark_mode_support_val = 'enable' == get_theme_mod( 'emulsion_dark_mode_support' ) ? true : false;
	define( 'EMULSION_DARK_MODE_SUPPORT', $emulsion_dark_mode_support_val );
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
			'emulsion_common_font_size'				 => array( 'default' => 16, 'unit' => 'px', ), // required emulsion-addons plugin
			'emulsion_common_font_family'			 => array( 'default' => 'sans-serif', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_common_google_font_url'		 => array( 'default' => '', 'unit' => '', ), // required emulsion-addons plugin

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
			'emulsion_header_layout'						 => array( 'default' => 'custom', 'unit' => '', ), // custom, simple, self
			'emulsion_header_html'							 => array( 'default' => '', 'unit' => '', ),
			'emulsion_title_in_header'						 => array( 'default' => 'yes', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_header_media_max_height'				 => array( 'default' => 75, 'unit' => 'vh', ),
			'emulsion_sidebar_position'						 => array( 'default' => 'right', 'unit' => '', ), // left, right
			'emulsion_sidebar_width'						 => array( 'default' => 400, 'unit' => 'px', ), //
			'emulsion_condition_display_posts_sidebar'		 => array( 'default' => 'allways', 'unit' => '', ), //logged_in_user, allways
			'emulsion_condition_display_page_sidebar'		 => array( 'default' => 'allways', 'unit' => '', ), //logged_in_user, allways
			'emulsion_main_width'							 => array( 'default' => 1280, 'unit' => 'px', ),
			'emulsion_content_width'						 => array( 'default' => 720, 'unit' => 'px', 'note' => '$content_width', ),
			'emulsion_content_margin_top'					 => array( 'default' => 0, 'unit' => 'px', ),
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
			'emulsion_footer_credit'							 => array( 'default' => '', 'unit' => '', ),
			'emulsion_footer_columns'							 => array( 'default' => 3, 'unit' => '', ),
			/**
			 * Advanced
			 * emulsion_excerpt_length_grid, emulsion_excerpt_length_stream represents the number of lines in the summary display
			 */
			'emulsion_reset_theme_settings'						 => array( 'default' => 'continue', 'unit' => '', ), // do not change
			'emulsion_excerpt_length'							 => array( 'default' => 256, 'unit' => '', ),
			'emulsion_excerpt_linebreak'						 => array( 'default' => 'none', 'unit' => '', ),
			'emulsion_excerpt_length_grid'						 => array( 'default' => 4, 'unit' => '', ),
			'emulsion_excerpt_length_stream'					 => array( 'default' => 2, 'unit' => '', ),
			'emulsion_table_of_contents'						 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_tooltip'									 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_sticky_sidebar'							 => array( 'default' => 'enable', 'unit' => '', ),
			'emulsion_lazyload'									 => array( 'default' => 'disable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_instantclick'								 => array( 'default' => 'enable', 'unit' => '', ), //Please use emulsion_the_theme_supports()
			'emulsion_search_drawer'							 => array( 'default' => 'enable', 'unit' => '', ),
			'emulsion_relate_posts'								 => array( 'default' => 'enable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_customizer_preview_redirect'				 => array( 'default' => 'disable', 'unit' => '', ), // required emulsion-addons plugin
			'emulsion_single_post_navigation'					 => array( 'default' => 'enable', 'unit' => '', ),
			'emulsion_gutenberg_render_layout_support_flag'		 => array( 'default' => 'disable', 'unit' => '', ),
			'emulsion_scheme'									 => array( 'default' => 'default', 'unit' => '', ),
			'emulsion_header_template'							 => array( 'default' => 'html', 'unit' => '', ),
			'emulsion_footer_template'							 => array( 'default' => 'html', 'unit' => '', ),
			'emulsion_should_load_separate_core_block_assets'	 => array( 'default' => 'disable', 'unit' => '', ),
			'emulsion_gutenberg_render_layout_support_flag'		 => array( 'default' => 'disable', 'unit' => '', ),
			'emulsion_render_elements_support'					 => array( 'default' => 'disable', 'unit' => '', ),
			'emulsion_custom_css_support'						 => array( 'default' => 'disable', 'unit' => '', ),
			'emulsion_core_block_patterns_support'				 => array( 'default' => 'disable', 'unit' => '', ),
			'emulsion_dark_mode_support'						 => array( 'default' => 'disable', 'unit' => '', ),
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
			'emulsion_header_template'	 => array( 'default' => 'default', 'unit' => '', ),
			'emulsion_footer_template'	 => array( 'default' => 'default', 'unit' => '', ),
			'emulsion_editor_support'	 => array( 'default' => 'transitional', 'unit' => '', ),
		);

		$exclude_name = array( 'emulsion_header_template', 'emulsion_footer_template', 'emulsion_editor_support' );

		if ( emulsion_theme_addons_exists() && function_exists( 'emulsion_addons_default_values' ) && ! in_array( $name, $exclude_name, true ) ) {

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



