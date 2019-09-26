<?php
/**
 * WP-SCSS Plugin Helper script
 *
 * @see https://wordpress.org/plugins/wp-scss/
 */

/**
 * Check WP-SCSS Plugin is ACTIVE
 * After activating the theme, the WP - SCSS plug - in must activate.
 *
 * 'active' == get_theme_mod('emulsion_wp_scss_status')
 */
function emulsion_set_wp_scss_options() {

	$wpscss_options = get_option( 'wpscss_options', false );

	if ( false == $wpscss_options ) {

		$emulsion_scss_dir	 = '/source/scss/';
		$emulsion_css_dir	 = '/css/';

		if ( $wpscss_options['scss_dir'] !== $emulsion_scss_dir || $wpscss_options['css_dir'] !== $emulsion_css_dir ) {
			if ( file_exists( get_theme_file_path( $emulsion_scss_dir ) ) ) {

				$wpscss_options['scss_dir'] = $emulsion_scss_dir;
			}
			if ( file_exists( get_theme_file_path( $emulsion_css_dir ) ) ) {

				$wpscss_options['css_dir'] = $emulsion_css_dir;
			}

			update_option( 'wpscss_options', $wpscss_options );
		}
	}
}

register_activation_hook( WP_CONTENT_DIR . '/plugins/wp-scss/wp-scss.php', 'emulsion_wp_scss_activate_check' );

function emulsion_wp_scss_activate_check() {
	set_theme_mod( 'emulsion_wp_scss_status', 'active' );
	emulsion_set_wp_scss_options();
}

register_deactivation_hook( WP_CONTENT_DIR . '/plugins/wp-scss/wp-scss.php', 'emulsion_wp_scss_deactivate_check' );

function emulsion_wp_scss_deactivate_check() {
	set_theme_mod( 'emulsion_wp_scss_status', 'deactive' );
}

if ( function_exists( 'is_plugin_active' ) && is_plugin_active( 'wp-scss/wp-scss.php' ) && 'deactive' == get_theme_mod( 'emulsion_wp_scss_status', false ) ) {
	//When you switch themes, cooperation with wp-scss may be canceled, and if the plugin is active, cooperate.
	//Do nothing if wp-scss is active before installing the theme.
	set_theme_mod( 'emulsion_wp_scss_status', 'active' );
}

if ( 'active' == get_theme_mod( 'emulsion_wp_scss_status' ) ) {

	add_filter( 'wp_scss_needs_compiling', 'emulsion_wp_scss_needs_compiling' );
}

function emulsion_wp_scss_needs_compiling( $compile ) {

	if ( ! is_user_logged_in() ) {
		return false;
	}
	if ( current_user_can( 'edit_theme_options' ) && ! is_customize_preview( ) ) {

		$reset_val = get_theme_mod( 'emulsion_reset_theme_settings' );

		if ( 'reset' == $reset_val ) {
			return true;
		}
		return true;
	}
	return $compile;
}
/**
 * Force recompile
 */
//if ( current_user_can( 'edit_theme_options' ) ) {
//define( 'WP_SCSS_ALWAYS_RECOMPILE', true );
//}

add_filter( 'emulsion_inline_style', 'emulsion_plugins_style_change_inline' );

/**
 * SCSS variables $image_sizes
 *
 * @global type $_wp_additional_image_sizes
 * @return Comma-separated string
 */
function emulsion_get_images_width_for_scss() {
	global $_wp_additional_image_sizes;

	$sizes		 = '';
	$image_sizes = get_intermediate_image_sizes();

	foreach ( $image_sizes as $_size ) {
		if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
			$sizes .= $_size . "	" . get_option( "{$_size}_size_w" ) . ',';
		} elseif ( isset( $_wp_additional_image_sizes[$_size] ) ) {
			$sizes .= $_size . "	" . $_wp_additional_image_sizes[$_size]['width'] . ',';
		}
	}

	$sizes = rtrim( $sizes, ',' );
	return $sizes;
}

/**
 * Creating SCSS variables for wp-scss plugin
 * @global type $emulsion_custom_header_defaults
 * @return string
 */
function emulsion_wp_scss_set_variables() {

	global $emulsion_custom_header_defaults;

	$stream_condition	 = emulsion_get_css_variables_values( 'stream' );
	$grid_condition		 = emulsion_get_css_variables_values( 'grid' );

	$variables			 = array(
		'header_media_max_height'			 => emulsion_get_css_variables_values( 'header_media_max_height' ),
		'post_display_date'					 => emulsion_get_css_variables_values( 'post_display_date' ),
		'post_display_author'				 => emulsion_get_css_variables_values( 'post_display_author' ),
		'post_display_category'				 => emulsion_get_css_variables_values( 'post_display_category' ),
		'post_display_tag'					 => emulsion_get_css_variables_values( 'post_display_tag' ),
		'sub_background_color_lighten'		 => emulsion_get_css_variables_values( 'sub_background_color_lighten' ),
		'sub_background_color_darken'		 => emulsion_get_css_variables_values( 'sub_background_color_darken' ),
		'favorite_color_palette'			 => emulsion_get_css_variables_values( 'favorite_color_palette' ),
		'header_category'					 => emulsion_get_css_variables_values( 'header_category' ), // Not CSS variables
		'wp_scss_status'					 => get_theme_mod( 'emulsion_wp_scss_status', 'active' ),
		'header_category'					 => emulsion_get_css_variables_values( 'header_category' ), // Not CSS variables
		'header_gradient'					 => emulsion_get_css_variables_values( 'header_gradient' ), // Not CSS variables
		'content_margin_top'				 => emulsion_get_css_variables_values( 'content_margin_top' ),
		'colors_for_editor'					 => emulsion_get_css_variables_values( 'colors_for_editor' ),
		'general_text_color'				 => emulsion_get_css_variables_values( 'general_text_color' ),
		'general_link_hover_color'			 => emulsion_get_css_variables_values( 'general_link_hover_color' ),
		'general_link_color'				 => emulsion_get_css_variables_values( 'general_link_color' ),
		'excerpt_linebreak'					 => emulsion_get_css_variables_values( 'excerpt_linebreak' ),
		'comments_link_color'				 => emulsion_get_css_variables_values( 'comments_link_color' ),
		'comments_color'					 => emulsion_get_css_variables_values( 'comments_color' ),
		'comments_bg'						 => emulsion_get_css_variables_values( 'comments_bg' ),
		'sidebar_link_color'				 => emulsion_get_css_variables_values( 'sidebar_link_color' ),
		'sidebar_hover_color'				 => emulsion_get_css_variables_values( 'sidebar_hover_color' ),
		'sidebar_color'						 => emulsion_get_css_variables_values( 'sidebar_color' ),
		'sidebar_background'				 => emulsion_get_css_variables_values( 'sidebar_background' ),
		'primary_menu_link_color'			 => emulsion_get_css_variables_values( 'primary_menu_link_color' ),
		'primary_menu_color'				 => emulsion_get_css_variables_values( 'primary_menu_color' ),
		'primary_menu_background'			 => emulsion_get_css_variables_values( 'primary_menu_background' ),
		'relate_posts_link_color'			 => emulsion_get_css_variables_values( 'relate_posts_link_color' ),
		'relate_posts_color'				 => emulsion_get_css_variables_values( 'relate_posts_color' ),
		'relate_posts_bg'					 => emulsion_get_css_variables_values( 'relate_posts_bg' ),
		'media_text_section_link_color'		 => emulsion_get_css_variables_values( 'media_text_section_link_color' ),
		'media_text_section_color'			 => emulsion_get_css_variables_values( 'media_text_section_color' ),
		'media_text_section_bg'				 => emulsion_get_css_variables_values( 'media_text_section_bg' ),
		'media_text_section_height'			 => emulsion_get_css_variables_values( 'media_text_section_height' ),
		'columns_section_link_color'		 => emulsion_get_css_variables_values( 'columns_section_link_color' ),
		'columns_section_color'				 => emulsion_get_css_variables_values( 'columns_section_color' ),
		'columns_section_bg'				 => emulsion_get_css_variables_values( 'columns_section_bg' ),
		'columns_section_height'			 => emulsion_get_css_variables_values( 'columns_section_height' ),
		'gallery_section_link_color'		 => emulsion_get_css_variables_values( 'gallery_section_link_color' ),
		'gallery_section_color'				 => emulsion_get_css_variables_values( 'gallery_section_color' ),
		'gallery_section_bg'				 => emulsion_get_css_variables_values( 'gallery_section_bg' ),
		'gallery_section_height'			 => emulsion_get_css_variables_values( 'gallery_section_height' ),
		'status'							 => get_theme_mod( 'emulsion_wp_scss_status' ),
		'image_sizes'						 => emulsion_get_images_width_for_scss(), // Old gallery caliculate wrapper width
		'header_text_color'					 => emulsion_get_css_variables_values( 'header_text_color' ),
		'header_link_color'					 => emulsion_get_css_variables_values( 'header_link_color' ),
		'header_hover_color'				 => emulsion_get_css_variables_values( 'header_hover_color' ),
		'header_bg_color'					 => emulsion_get_css_variables_values( 'header_background_color' ),
		'header_background_gradient_color'	 => emulsion_get_css_variables_values( 'header_background_gradient_color' ),
		'theme_image_dir'					 => emulsion_get_css_variables_values( 'theme_image_dir' ),
		'upload_base_dir'					 => emulsion_get_css_variables_values( 'upload_base_dir' ),
		'header_image_ratio'				 => emulsion_get_css_variables_values( 'header_image_ratio' ),
		'background_color'					 => emulsion_get_css_variables_values( 'background_color' ),
		'stream-condition'					 => empty( $stream_condition ) ? 'body' : $stream_condition,
		'grid-condition'					 => empty( $grid_condition ) ? 'body' : $grid_condition,
		'language'							 => esc_attr( get_locale() ),
		'hover_color'						 => emulsion_get_css_variables_values( 'hover_color' ),
		'sidebar_width'						 => emulsion_get_css_variables_values( 'sidebar_width' ),
		'sidebar-position'					 => emulsion_get_css_variables_values( 'sidebar_position' ),
		'i18n_no_title'						 => esc_html__( 'No Title', 'emulsion' ),
		'editor_font_sizes'					 => emulsion_get_css_variables_values( 'font_sizes' ),
		'editor_color_palettes'				 => emulsion_get_css_variables_values( 'color_palette' ),
		'body_id'							 => '#' . emulsion_theme_info( 'Slug', false ),
		'footer_widget_width'				 => emulsion_get_footer_cols_css(),
		'common_font_size'					 => emulsion_get_css_variables_values( 'common_font_size' ),
		'common_font_family'				 => emulsion_get_css_variables_values( 'common_font_family' ),
		'heading_font_family'				 => emulsion_get_css_variables_values( 'heading_font_family' ),
		'heading_font_weight'				 => emulsion_get_css_variables_values( 'heading_font_weight' ),
		'heading-font-size'					 => emulsion_get_css_variables_values( 'heading_font_size' ),
		'heading_font_transform'			 => emulsion_get_css_variables_values( 'heading_font_transform' ),
		'meta_data_font_size'				 => emulsion_get_css_variables_values( 'widget_meta_font_size' ),
		'meta_data_font_family'				 => emulsion_get_css_variables_values( 'widget_meta_font_family' ),
		'meta_data_font_transform'			 => emulsion_get_css_variables_values( 'widget_meta_font_transform' ),
		'layout_homepage'					 => emulsion_get_css_variables_values( 'layout_homepage' ),
		'layout_date_archives'				 => emulsion_get_css_variables_values( 'layout_date_archives' ),
		'layout_category_archives'			 => emulsion_get_css_variables_values( 'layout_category_archives' ),
		'layout_tag_archives'				 => emulsion_get_css_variables_values( 'layout_tag_archives' ),
		'layout_author_archives'			 => emulsion_get_css_variables_values( 'layout_author_archives' ),
		'layout_posts_page'					 => emulsion_get_css_variables_values( 'layout_posts_page' ),
		'content_width'						 => emulsion_get_css_variables_values( 'content_width' ),
		'box_gap'							 => emulsion_get_css_variables_values( 'box_gap' ),
		'main_width'						 => emulsion_get_css_variables_values( 'main_width' ),
		'align_offset'						 => emulsion_get_css_variables_values( 'align_offset' ),
		'sidebar_width'						 => emulsion_get_css_variables_values( 'sidebar_width' ),
		'content_gap'						 => emulsion_get_css_variables_values( 'content_gap' ),
		'content_line_height'				 => emulsion_get_css_variables_values( 'content_line_height' ),
		'common_line_height'				 => emulsion_get_css_variables_values( 'common_line_height' ),
		'caption_height'					 => emulsion_get_css_variables_values( 'caption_height' ),
		'default_header_height'				 => emulsion_get_css_variables_values( 'default_header_height' ),
		'full_width_negative_margin'		 => emulsion_get_css_variables_values( 'full_width_nagative_margin' ),
	);

	return $variables;
}

function emulsion_get_template_part_css_selectors( $name = null,
		$template_slug = 'template-parts/content.php' ) {

	$name = (string) $name;

	$template_path = get_theme_file_path( $template_slug );

	if ( ! file_exists( $template_path ) || empty( $name ) ) {
		return '';
	}

	$stream_conditionals = emulsion_get_supports( $name );
	$stream_classes		 = '';
	$custom_post_type	 = '';
	$custom_post_types	 = '';

	if ( ! empty( $stream_conditionals[0] ) ) {

		foreach ( $stream_conditionals[0] as $key => $class ) {

			if ( $key !== 0 && 'post_type' == $key ) {

				if ( is_array( $class ) ) {

					foreach ( $class as $custom_post_type ) {

						$custom_post_types .= '.post-type-archive-' . sanitize_html_class( $custom_post_type ) . ',';
					}
					$custom_post_type = $custom_post_types;
				} else {

					$custom_post_type .= '.post-type-archive-' . sanitize_html_class( $class ) . ',';
				}

				$stream_classes .= $custom_post_type;
			} elseif ( 'post_type' !== $key ) {
				
				if ( is_array( $class ) ) {
					
					$class = intval( $class );				
				}
				$class			 = str_replace( 'post_tag', 'tag', $class );
				$class			 = sanitize_html_class( $class );
				$stream_classes	 .= sprintf( '.%1$s,', $class );
				
			}
		}

		$stream_classes = trim( $stream_classes, ',' );
	}
	return $stream_classes;
}

/**
 *
 * @global type $wp_styles
 * @return boolean
 */
function emulsion_get_plugins_style_path() {
	global $wp_styles;

	$result	 = array();
	$handles = $wp_styles->queue;

	if ( isset( $handles ) && is_array( $handles ) ) {
		foreach ( $handles as $handle ) {

			$src_path = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $wp_styles->registered[$handle]->src );

			if ( file_exists( $src_path ) && strpos( $src_path, '/plugins/' ) !== false ) {
				$result[$handle] = wp_normalize_path( $src_path );
			}
		}
		return $result;
	}
	return false;
}

function emulsion_plugins_style_change_inline( $css ) {
	global $wp_style;

	$add_css = '';
//'active' !== get_theme_mod( 'emulsion_wp_scss_status' ) &&
	if (  is_user_logged_in() || is_admin() ) {

		return $css;
	}
	if( is_page() &&  false == emulsion_metabox_display_control( 'page_style' ) ) {
		
		return;	
	}
	if( is_single() && false == emulsion_metabox_display_control( 'style' ) ) {

		return;
	}
	if( ! emulsion_get_supports( 'enqueue' ) ) {
		
		return;
	}

	if ( ! is_admin() || ! is_user_logged_in() ) {

		$get_css = file( get_theme_file_path( 'css/common.css' ) );
		$add_css .= implode( '', $get_css );
		return $css . $add_css;
	}
	return $css;
}

/**
 * Plugin AMP
 * https://ja.wordpress.org/plugins/amp/
 */
if ( function_exists( 'amp_init' ) ) {
	/**
	 * AMP
	 * https://wordpress.org/plugins/amp/
	 */
	add_action( 'amp_post_template_css', 'emulsion_amp_css' );

	if ( ! function_exists( 'emulsion_amp_css' ) ) {

		function emulsion_amp_css() {

			$supports = emulsion_get_supports( 'amp' );

			if ( ! $supports ) {
				return;
			}
			$css_variables	 = emulsion__css_variables();
			$get_css		 = file( get_theme_file_path( 'css/amp.css' ) );
			$css			 = implode( '', $get_css );
			/**
			 * @see emulsion_sanitize_css() in functions.php
			 * For sanitization, you can add any processing you need
			 */
			echo emulsion_sanitize_css( $css_variables . $css );
		}

	}

}