<?php
if ( ! function_exists( 'emulsion_get_css_variables_values' ) ) {

	/**
	 * Pass the value saved in the customizer to the CSS variable with units and so on.
	 *
	 * @global type $emulsion_custom_header_defaults
	 * @global type $wp_filter
	 * @global type $content_width
	 * @global type $emulsion_customize_args
	 * @global type $emulsion_custom_header_defaults
	 * @param type $name
	 * @return boolean
	 */
	function emulsion_get_css_variables_values( $name = '' ) {

		global $emulsion_custom_header_defaults, $wp_filter, $content_width, $emulsion_customize_args;

		if ( 'enable' == emulsion_get_var( 'emulsion_header_gradient' ) ) {

			$header_background_color			 = emulsion_get_var( 'emulsion_header_background_color' );
			$header_background_gradient_color	 = emulsion_get_var( 'emulsion_header_sub_background_color' );
		} else {

			$header_background_gradient_color = emulsion_get_var( 'emulsion_header_background_color' );
		}
		$emulsion_bg_image_blend_color =  emulsion_get_var( 'emulsion_bg_image_blend_color' );
		$emulsion_bg_image_blend_color_amount =  emulsion_get_var( 'emulsion_bg_image_blend_color_amount' ) / 100;
		
		$background_image_dim = emulsion_the_hex2rgba( $emulsion_bg_image_blend_color, $emulsion_bg_image_blend_color_amount );
		
		$header_background_color = emulsion_get_var( 'emulsion_header_background_color' );

		$has_set_header_textcolor = get_theme_mod( 'header_textcolor', false );

		if( false !== $has_set_header_textcolor && $has_set_header_textcolor !== get_theme_support( 'custom-header', 'default-text-color' ) && 'blank' !== $has_set_header_textcolor ){

			$header_text_color = '#'. get_theme_mod( 'header_textcolor' );
			
		} else {
			
			$header_text_color		 = emulsion_contrast_color( $header_background_color );
		}
		$header_link_color				 = emulsion_link_colors( $header_background_color, 'site_header' );
		$header_hover_color				 = emulsion_hover_colors( $header_background_color, 'site_header' );
		$columns_section_bg				 = emulsion_get_var( 'emulsion_block_columns_section_bg' );
		$columns_section_color			 = emulsion_contrast_color( $columns_section_bg );
		$columns_section_link_color		 = emulsion_link_colors( $columns_section_bg, 'columns' );
		$gallery_section_bg				 = emulsion_get_var( 'emulsion_block_gallery_section_bg' );
		$gallery_section_color			 = emulsion_contrast_color( $gallery_section_bg );
		$gallery_section_link_color		 = emulsion_link_colors( $gallery_section_bg, 'gallery' );
		$media_text_section_bg			 = emulsion_get_var( 'emulsion_block_media_text_section_bg' );
		$media_text_section_color		 = emulsion_contrast_color( $media_text_section_bg );
		$media_text_section_link_color	 = emulsion_link_colors( $media_text_section_bg, 'media_text' );
		$relate_posts_bg				 = emulsion_get_var( 'emulsion_relate_posts_bg' );
		$relate_posts_color				 = emulsion_contrast_color( $relate_posts_bg );
		$relate_posts_link_color		 = emulsion_link_colors( $relate_posts_bg, 'relate_posts' );
		$sidebar_background				 = emulsion_get_var( 'emulsion_sidebar_background' );
		$sidebar_color					 = emulsion_contrast_color( $sidebar_background );
		$sidebar_link_color				 = emulsion_link_colors( $sidebar_background, 'sidebar' );
		$sidebar_hover_color			 = emulsion_hover_colors( $sidebar_background, 'sidebar' );
		$primary_menu_background		 = emulsion_get_var( 'emulsion_primary_menu_background' );
		$primary_menu_color				 = emulsion_contrast_color( $primary_menu_background );
		$primary_menu_link_color		 = emulsion_link_colors( $primary_menu_background, 'primary_menu' );
		$comments_bg					 = emulsion_get_var( 'emulsion_comments_bg' );
		$comments_color					 = emulsion_contrast_color( $comments_bg );
		$comments_link_color			 = emulsion_link_colors( $comments_bg, 'comments' );
		$heading_web_font_family		 = get_theme_mod( 'emulsion_heading_google_font_url', emulsion_get_var( 'emulsion_heading_google_font_url' ) );
		$fallback_heading_font_family	 = get_theme_mod( 'emulsion_heading_font_family', emulsion_get_var( 'emulsion_heading_font_family' ) );

		if ( ! empty( $heading_web_font_family ) ) {

			$heading_font_family = emulsion_get_google_font_family_from_url( $heading_web_font_family, $fallback_heading_font_family ) ;
		} else {

			$heading_font_family = $fallback_heading_font_family;
		}

		$settings = array(
			'background_image_dim'				 => array( 'value' => $background_image_dim, 'unit' => '' ),
			'heading_font_base'					 => array( 'value' => emulsion_get_var( 'emulsion_heading_font_base' ), 'unit' => '' ),// Do not add units due to font size calculations.
			'header_media_max_height'			 => array( 'value' => emulsion_get_var( 'emulsion_header_media_max_height' ), 'unit' => 'vh' ),
			'post_display_date'					 => array( 'value' => emulsion_get_var( 'emulsion_post_display_date' ), 'unit' => '' ),
			'post_display_author'				 => array( 'value' => emulsion_get_var( 'emulsion_post_display_author' ), 'unit' => '' ),
			'post_display_category'				 => array( 'value' => emulsion_get_var( 'emulsion_post_display_category' ), 'unit' => '' ),
			'post_display_tag'					 => array( 'value' => emulsion_get_var( 'emulsion_post_display_tag' ), 'unit' => '' ),
			'sub_background_color_lighten'		 => array( 'value' => emulsion_sub_background_color_lighten(), 'unit' => '' ),
			'sub_background_color_darken'		 => array( 'value' => emulsion_sub_background_color_darken(), 'unit' => '' ),
			'favorite_color_palette'			 => array( 'value' => emulsion_get_var( 'emulsion_favorite_color_palette' ), 'unit' => '' ),
			'header_text_color'					 => array( 'value' => $header_text_color, 'unit' => '' ),
			'header_link_color'					 => array( 'value' => $header_link_color, 'unit' => '' ),
			'header_hover_color'				 => array( 'value' => $header_hover_color, 'unit' => '' ),
			'header_category'					 => array( 'value' => emulsion_get_var( 'emulsion_category_colors' ), 'unit' => '' ),
			'header_gradient'					 => array( 'value' => emulsion_get_var( 'emulsion_header_gradient' ), 'unit' => '' ),
			'content_margin_top'				 => array( 'value' => emulsion_get_var( 'emulsion_content_margin_top' ), 'unit' => 'px' ),
			'colors_for_editor'					 => array( 'value' => emulsion_get_var( 'emulsion_colors_for_editor' ), 'unit' => '' ),
			'general_text_color'				 => array( 'value' => emulsion_get_var( 'emulsion_general_text_color' ), 'unit' => '' ),
			'general_link_hover_color'			 => array( 'value' => emulsion_hover_colors(), 'unit' => '' ),
			'general_link_color'				 => array( 'value' => emulsion_link_colors(), 'unit' => '' ),
			'excerpt_linebreak'					 => array( 'value' => emulsion_get_var( 'emulsion_excerpt_linebreak' ), 'unit' => '' ),
			'comments_link_color'				 => array( 'value' => $comments_link_color, 'unit' => '' ),
			'comments_color'					 => array( 'value' => $comments_color, 'unit' => '' ),
			'comments_bg'						 => array( 'value' => $comments_bg, 'unit' => '' ),
			'relate_posts_link_color'			 => array( 'value' => $relate_posts_link_color, 'unit' => '' ),
			'relate_posts_color'				 => array( 'value' => $relate_posts_color, 'unit' => '' ),
			'relate_posts_bg'					 => array( 'value' => $relate_posts_bg, 'unit' => '' ),
			'media_text_section_link_color'		 => array( 'value' => $media_text_section_link_color, 'unit' => '' ),
			'media_text_section_color'			 => array( 'value' => $media_text_section_color, 'unit' => '' ),
			'media_text_section_bg'				 => array( 'value' => $media_text_section_bg, 'unit' => '' ),
			'media_text_section_height'			 => array( 'value' => emulsion_get_var( 'emulsion_block_media_text_section_height' ), 'unit' => 'vh' ),
			'columns_section_link_color'		 => array( 'value' => $columns_section_link_color, 'unit' => '' ),
			'columns_section_color'				 => array( 'value' => $columns_section_color, 'unit' => '' ),
			'columns_section_bg'				 => array( 'value' => $columns_section_bg, 'unit' => '' ),
			'columns_section_height'			 => array( 'value' => emulsion_get_var( 'emulsion_block_columns_section_height' ), 'unit' => 'vh' ),
			'gallery_section_link_color'		 => array( 'value' => $gallery_section_link_color, 'unit' => '' ),
			'gallery_section_color'				 => array( 'value' => $gallery_section_color, 'unit' => '' ),
			'gallery_section_bg'				 => array( 'value' => $gallery_section_bg, 'unit' => '' ),
			'gallery_section_height'			 => array( 'value' => emulsion_get_var( 'emulsion_block_gallery_section_height' ), 'unit' => 'vh' ),
			'hover_color'						 => array( 'value' => emulsion_hover_colors(), 'unit' => '' ),
			'sidebar_link_color'				 => array( 'value' => $sidebar_link_color, 'unit' => '' ),
			'sidebar_color'						 => array( 'value' => $sidebar_color, 'unit' => '' ),
			'sidebar_background'				 => array( 'value' => $sidebar_background, 'unit' => '' ),
			'sidebar_hover_color'				 => array( 'value' => $sidebar_hover_color, 'unit' => '' ),
			'primary_menu_link_color'			 => array( 'value' => $primary_menu_link_color, 'unit' => '' ),
			'primary_menu_color'				 => array( 'value' => $primary_menu_color, 'unit' => '' ),
			'primary_menu_background'			 => array( 'value' => $primary_menu_background, 'unit' => '' ),
			'header_image_ratio'				 => array( 'value' => emulsion_header_image_ratio(), 'unit' => '' ),
			'upload_base_dir'					 => array( 'value' => emulsion_upload_base_dir(), 'unit' => '' ),
			'theme_image_dir'					 => array( 'value' => emulsion_theme_image_dir(), 'unit' => '' ),
			'box_gap'							 => array( 'value' => emulsion_get_var( 'emulsion_box_gap' ), 'unit' => 'px' ),
			'layout_posts_page'					 => array( 'value' => emulsion_get_var( 'emulsion_layout_posts_page' ), 'unit' => '' ),
			'layout_author_archives'			 => array( 'value' => emulsion_get_var( 'emulsion_layout_author_archives' ), 'unit' => '' ),
			'layout_tag_archives'				 => array( 'value' => emulsion_get_var( 'emulsion_layout_tag_archives' ), 'unit' => '' ),
			'layout_category_archives'			 => array( 'value' => emulsion_get_var( 'emulsion_layout_category_archives' ), 'unit' => '' ),
			'layout_date_archives'				 => array( 'value' => emulsion_get_var( 'emulsion_layout_date_archives' ), 'unit' => '' ),
			'layout_homepage'					 => array( 'value' => emulsion_get_var( 'emulsion_layout_homepage' ), 'unit' => '' ),
			'sidebar_position'					 => array( 'value' => emulsion_get_var( 'emulsion_sidebar_position' ), 'unit' => '' ),
			'widget_meta_font_transform'		 => array( 'value' => emulsion_get_var( 'emulsion_widget_meta_font_transform' ), 'unit' => '' ),
			'widget_meta_font_family'			 => array( 'value' => emulsion_get_var( 'emulsion_widget_meta_font_family' ), 'unit' => '' ),
			'widget_meta_font_size'				 => array( 'value' => emulsion_get_var( 'emulsion_widget_meta_font_size' ), 'unit' => 'px' ),
			'heading_font_transform'			 => array( 'value' => emulsion_get_var( 'emulsion_heading_font_transform' ), 'unit' => '' ),
			'heading_font_scale'				 => array( 'value' => emulsion_get_var( 'emulsion_heading_font_scale' ), 'unit' => '' ),
			'heading_font_weight'				 => array( 'value' => emulsion_get_var( 'emulsion_heading_font_weight' ), 'unit' => '' ),
			'heading_font_family'				 => array( 'value' => $heading_font_family, 'unit' => '' ),
			'common_font_family'				 => array( 'value' => emulsion_get_var( 'emulsion_common_font_family' ), 'unit' => '' ),
			'common_font_size'					 => array( 'value' => emulsion_get_var( 'emulsion_common_font_size' ), 'unit' => 'px' ),
			'align_offset'						 => array( 'value' => 200, 'unit' => 'px' ),
			'main_width'						 => array( 'value' => emulsion_get_var( 'emulsion_main_width' ), 'unit' => 'px' ),
			'content_width'						 => array( 'value' => emulsion_get_var( 'emulsion_content_width' ), 'unit' => 'px' ),
			'sidebar_width'						 => array( 'value' => emulsion_get_var( 'emulsion_sidebar_width' ), 'unit' => 'px' ),
			'content_gap'						 => array( 'value' => 24, 'unit' => 'px' ),
			'content_line_height'				 => array( 'value' => 1.5, 'unit' => '' ),
			'common_line_height'				 => array( 'value' => 1.15, 'unit' => '' ),
			'caption_height'					 => array( 'value' => 1.5, 'unit' => 'em' ),
			'default_header_height'				 => array( 'value' => 300, 'unit' => 'px' ),
			'header_background_color'			 => array( 'value' => emulsion_get_var( 'emulsion_header_background_color' ), 'unit' => '' ),
			'header_background_gradient_color'	 => array( 'value' => $header_background_gradient_color, 'unit' => '' ),
			'background_color'					 => array( 'value' => emulsion_get_background_color(), 'unit' => '' ),
			'footer_widget_width'				 => array( 'value' => emulsion_get_footer_cols_css(), 'unit' => '%' ),
			'stream'							 => array( 'value' => emulsion_get_template_part_css_selectors( 'stream' ), 'unit' => '' ),
			'grid'								 => array( 'value' => emulsion_get_template_part_css_selectors( 'grid' ), 'unit' => '' ),
			'font_sizes'						 => array( 'value' => emulsion_get_font_sizes(), 'unit' => '' ),
			'color_palette'						 => array( 'value' => emulsion_get_color_palette(), 'unit' => '' ),
		);

		$check_customizer_change = get_theme_mod('emulsion_customizer_is_changed');

		if ( 'is_changed' == $name && 'yes' == $check_customizer_change ) {

			set_theme_mod('emulsion_customizer_is_changed','no');

			return true;
		}

		/**
		 * full_width_nagative_margin
		 */

		if ( 'full_width_nagative_margin' == $name && ! empty( $settings['main_width']['value'] ) && ! empty( $settings['content_width']['value'] )) {

			return ( absint( $settings['main_width']['value'] ) - absint( $settings['content_width']['value'] ) ) / -2 . $settings['content_width']['unit'];
		}

		/**
		 * get from $settings
		 */

		if ( array_key_exists( $name, $settings ) ) {

			return $settings[$name]['value'] . $settings[$name]['unit'];
		}
		return false;
	}

}
if ( ! function_exists( 'emulsion_rgb2hex' ) ) {

	function emulsion_rgb2hex( $rgb = array( 0, 0, 0 ) ) {

		return '#' . str_pad( dechex( $rgb[0] ), 2, '0', STR_PAD_LEFT ) .
				str_pad( dechex( $rgb[1] ), 2, '0', STR_PAD_LEFT ) .
				str_pad( dechex( $rgb[2] ), 2, '0', STR_PAD_LEFT );
	}

}


if ( ! function_exists( 'emulsion_the_hex2rgb' ) ) {

	/**
	 * Convert hex color to rgba color
	 * @param type $hex
	 * @param type $alpha
	 * @return type
	 */
	function emulsion_the_hex2rgb( $hex = '#000' ) {

		if ( list($r, $g, $b) = emulsion_get_hex2rgb_array( $hex ) ) {

			return sprintf( 'rgba( %1$d, %2$d, %3$d )', $r, $g, $b );
		}

		return $hex;
	}

}
if ( ! function_exists( 'emulsion_the_hex2rgba' ) ) {

	/**
	 * Convert hex color to rgba color
	 * @param type $hex
	 * @param type $alpha
	 * @return type
	 */
	function emulsion_the_hex2rgba( $hex = '#000', $alpha = 1 ) {

		if ( list($r, $g, $b) = emulsion_get_hex2rgb_array( $hex ) ) {

			return sprintf( 'rgba( %1$d, %2$d, %3$d, %4$.1F)', $r, $g, $b, $alpha );
		}

		return $hex;
	}

}
if ( ! function_exists( 'emulsion_the_hex2hsla' ) ) {

	/**
	 * Convert hex color to hsla color
	 * @param type $hex
	 * @param type $alpha
	 * @return type
	 */
	function emulsion_the_hex2hsla( $hex = '', $alpha = 1 ) {

		if ( empty( $hex ) ) {

			$hex = emulsion_the_background_color();
		}

		if ( list($r, $g, $b) = emulsion_get_hex2hsl_array( $hex ) ) {

			return sprintf( 'hsla( %1$d, %2$s, %3$s, %4$.1F)', $r, $g . '%', $b . '%', $alpha );
		}

		return $hex;
	}

}

if ( ! function_exists( 'emulsion_contrast_color' ) ) {

	/**
	 * Calculate text color from background color
	 * @param type $hex
	 * @param type $alpha
	 * @return type
	 */
	function emulsion_contrast_color( $hex_color = '' ) {

		if ( empty( $hex_color ) ) {

			$hex_color = emulsion_the_background_color();

		}

		list( $r, $g, $b) = emulsion_get_hex2rgb_array( $hex_color );

		$brightness	 = round( $r * 299 + $g * 587 + $b * 114 ) / 1000;
		$light		 = round( 255 * 299 + 244 * 587 + 255 * 114 ) / 1000;

		if ( $brightness < $light / 2 ) {
			$color = '#ffffff';
		} else {
			$color = '#333333';
		}

		return $color;
	}

}

if ( ! function_exists( 'emulsion_sub_background_color_darken' ) ) {

	/**
	 * Create hover color
	 *
	 * @param type $hex
	 * @param type $alpha
	 * @param type $hue
	 * @param type $saturation
	 * @param type $lightness
	 * @return type
	 */
	function emulsion_sub_background_color_darken(  ) {

		$hex		 = emulsion_the_background_color();
		$hue		 = emulsion_get_hex2hsl_array( $hex )[0];
		$saturation	 = emulsion_get_hex2hsl_array( $hex )[1];
		$lightness	 = emulsion_get_hex2hsl_array( $hex )[2];
		$alpha = 1;

		if ( 0 == $hue ) {
			$lightness = $lightness > 0 ? $lightness * 0.80: 0;
			return emulsion_accent_color( $hex, $alpha, $hue, $saturation, $lightness );
		} else {
			//$saturation = $saturation > 0 ? $saturation * 0.9: 0;
			$lightness = $lightness > 0 ? $lightness * 0.85: 0;
			return emulsion_accent_color( $hex, $alpha, $hue, $saturation, $lightness );
		}
	}

}
if ( ! function_exists( 'emulsion_sub_background_color_lighten' ) ) {

	function emulsion_sub_background_color_lighten(  ) {

		$hex		 = emulsion_the_background_color();
		$hue		 = intval(emulsion_get_hex2hsl_array( $hex )[0]);
		$saturation	 = intval(emulsion_get_hex2hsl_array( $hex )[1]);
		$lightness	 = intval(emulsion_get_hex2hsl_array( $hex )[2]);
		$alpha = 1;


		if ( 0 == $hue ) {
			$lightness = $lightness > 0 ? $lightness * 1.25: 0;
			if( $lightness > 100 ){
				$lightness = 100;
			}

			return emulsion_accent_color( $hex, $alpha, $hue, $saturation, $lightness );
		} else {
			if( $saturation > 100 ){
				$saturation = 100;
			}
			$lightness = $lightness > 0 ? $lightness * 1.25: 0;
			if( $lightness > 100 ){
				$lightness = 100;
			}
			return emulsion_accent_color( $hex, $alpha, $hue, $saturation, $lightness );
		}
	}
}


/**
 *  Create Accent color
 * @param type $hex
 * @param type $alpha
 * @param type $hue
 * @param type $saturation
 * @param type $lightness
 * @return type
 */
function emulsion_accent_color( $hex = '', $alpha = 1, $hue = '',
		$saturation = '', $lightness = '') {

	$emulsion_contrast_color = emulsion_contrast_color();

	if ( empty( $hex ) ) {

		$hex		 = emulsion_the_background_color();
		$hsl_array	 = emulsion_get_hex2hsl_array( $hex );
		$hue		 = (int) $hsl_array[0] + $hue;

	}
	if ( ! empty( $hex ) && empty( $hue )) {

		$hsl_array	 = emulsion_get_hex2hsl_array( $hex );
		$hue		 = (int) $hsl_array[0];

	}

	if ( '#ffffff' == $emulsion_contrast_color && empty( $saturation ) && empty( $lightness ) ) {

		$saturation	 = empty( $saturation ) ? 100 : $saturation;
		$lightness	 = empty( $lightness ) ? 30 : $lightness;
	}

	if ( '#333333' == $emulsion_contrast_color && empty( $saturation ) && empty( $lightness ) ) {

		$saturation	 = empty( $saturation ) ? 70 : $saturation;
		$lightness	 = empty( $lightness ) ? 30 : $lightness;
	}

	if( $hue > 360 ){
		$hue = $hue - 360;
	}
	if( $saturation > 100 ){
		$saturation = 100;
	}
	if( $lightness > 100 ){
		$lightness = 100;
	}


	$hue		 = absint( $hue ) . 'deg';
	$saturation	 = absint( $saturation ) . '%';
	$lightness	 = absint( $lightness ) . '%';
	$alpha = floatval( $alpha );
	return sprintf( 'hsla(%1$s,%2$s,%3$s,%4$s)', $hue, $saturation, $lightness, $alpha );
}



if ( ! function_exists( 'emulsion_get_hex2rgb_array' ) ) {

	/**
	 * return rgb array from hex color
	 * @param type $hex
	 * @return boolean
	 */
	function emulsion_get_hex2rgb_array( $hex ) {

		$hex = str_replace( '#', '', $hex );
		$d	 = '[a-fA-F0-9]';

		if ( preg_match( "/^($d$d)($d$d)($d$d)\$/", $hex, $rgb ) ) {

			return array(
				hexdec( $rgb[1] ),
				hexdec( $rgb[2] ),
				hexdec( $rgb[3] )
			);
		}

		if ( preg_match( "/^($d)($d)($d)$/", $hex, $rgb ) ) {

			return array(
				hexdec( $rgb[1] . $rgb[1] ),
				hexdec( $rgb[2] . $rgb[2] ),
				hexdec( $rgb[3] . $rgb[3] )
			);
		}
		return false;
	}
}


if ( ! function_exists( 'emulsion_get_hex2hsl_array' ) ) {

	/**
	 * eturn hsl array from hex color
	 * @param type $hex
	 * @return type
	 */
	function emulsion_get_hex2hsl_array( $hex ) {

		if ( list( $r, $g, $b ) = emulsion_get_hex2rgb_array( $hex ) ) {

			$r	 = max( min( intval( $r, 10 ) / 255, 1 ), 0 );
			$g	 = max( min( intval( $g, 10 ) / 255, 1 ), 0 );
			$b	 = max( min( intval( $b, 10 ) / 255, 1 ), 0 );
			$max = max( $r, $g, $b );
			$min = min( $r, $g, $b );
			$l	 = ($max + $min) / 2;

			if ( $max !== $min ) {

				$d	 = $max - $min;
				$s	 = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
				if ( $max === $r ) {
					$h = ($g - $b) / $d + ($g < $b ? 6 : 0);
				} else if ( $max === $g ) {
					$h = ($b - $r) / $d + 2;
				} else {
					$h = ($r - $g) / $d + 4;
				}
				$h = $h / 6;
			} else {

				$h	 = $s	 = 0;
			}
			return array( round( $h * 360 ), round( $s * 100 ), round( $l * 100 ) );
		}
	}
}
function emulsion_comment_brightness_class(){
	$comment_bg_color = get_theme_mod('emulsion_comments_bg', emulsion_get_var( 'emulsion_comments_bg' ) );

	$class = '#ffffff' == emulsion_contrast_color( $comment_bg_color ) ? 'comment-is-dark': 'comment-is-light';

	echo esc_attr( $class );
}


if ( ! function_exists( 'emulsion_brightness_dark_class' ) ) {

	/**
	 * remove is-light class and add is-dark class from Classes array
	 * @param type $classes
	 * @return type
	 */
	function emulsion_brightness_dark_class( $classes ) {

		$classes[] = 'is-dark';

		$classes = array_diff( $classes, array( 'is-light' ) );
		$classes = array_values( $classes );

		return $classes;
	}

}

if ( ! function_exists( 'emulsion_brightness_light_class' ) ) {

	/**
	 * remove is-dark class and add is-lightclass from Classes array
	 * @param type $classes
	 * @return type
	 */
	function emulsion_brightness_light_class( $classes ) {

		$classes[] = 'is-light';

		$classes = array_diff( $classes, array( 'is-dark' ) );
		$classes = array_values( $classes );

		return $classes;
	}
}




if ( ! function_exists( 'emulsion_the_background_color' ) ) {

	/**
	 * get background color
	 * @return type
	 */
	function emulsion_the_background_color() {

		$background_color	 = sprintf( '#%2s', get_background_color() );
		$background_color	 = sanitize_hex_color( $background_color );

		if ( empty( $background_color ) ) {

			$background_color = sprintf('#%1$s', emulsion_get_supports( 'background' )[0]['default']['default-color'] );
		}
		$background_color = apply_filters( 'emulsion_the_background_color', $background_color );

		return $background_color;
	}
}
if ( ! function_exists( 'emulsion_get_background_color' ) ) {
	/**
	 *
	 * @return type
	 */
	function emulsion_get_background_color() {

		$background_color = get_background_color();

		if ( empty( $background_color ) ) {
			$background_color = emulsion_get_supports( 'background' )[0]['default']['default-color'];
			$background_color = str_replace('#','', $background_color);
		}
		$background_color	 = sprintf( '#%1$s', $background_color );
		$background_color	 = sanitize_hex_color( $background_color );

		return apply_filters( 'emulsion_get_background_color' , $background_color );
	}
}

if ( ! function_exists( 'emulsion_get_font_sizes' ) ) {

	/**
	 * block editor font sizes
	 * @return string
	 */
	function emulsion_get_font_sizes() {

		$font_size_vals				 = get_theme_support( 'editor-font-sizes' );
		$disable_custom_font_size	 = get_theme_support( 'disable-custom-font-size' );
		$font_sizes					 = '';

		if ( isset( $font_size_vals ) && is_array( $font_size_vals ) && ! $disable_custom_font_size ) {

			foreach ( $font_size_vals[0] as $font_val ) {

				$font_sizes .= sprintf( '%1$s %2$s,', $font_val['slug'], $font_val['size'] );
			}
			$font_sizes = trim( $font_sizes, "," );
		} else {

			// gutenberg default values
			$font_sizes = "small 14,regular 16, large 36, larger 48";
		}
		return $font_sizes;
	}
}

if ( ! function_exists( 'emulsion_get_color_palette' ) ) {

	/**
	 * get color pallet value
	 * @return string
	 */
	function emulsion_get_color_palette() {

		$color_palette_vals			 = get_theme_support( 'editor-color-palette' );
		$disable_color_palette_vals	 = get_theme_support( 'disable-custom-colors' );
		$color_palettes				 = '';

		if ( isset( $color_palette_vals ) && is_array( $color_palette_vals ) && ! $disable_color_palette_vals ) {

			foreach ( $color_palette_vals[0] as $palet_val ) {
				$color_palettes .= sprintf( '%1$s %2$s,', $palet_val['slug'], $palet_val['color'] );
			}

			$color_palettes = trim( $color_palettes, "," );
		} else {
			// gutenberg default values
			$color_palettes = "pale-pink #f78da7,vivid-red #cf2e2e,luminous-vivid-orange #ff6900,luminous-vivid-amber #fcb900,light-green-cyan #7bdcb5,vivid-green-cyan #00d084,pale-cyan-blue #8ed1fc,vivid-cyan-blue #0693e3,very-light-gray #eee,cyan-bluish-gray #abb8c3,very-dark-gray #313131";
		}
		return $color_palettes;
	}
}

if ( ! function_exists( 'emulsion_theme_image_dir' ) ) {
	/**
	 * Theme Image Directory
	 * for scss variable
	 */
	function emulsion_theme_image_dir() {

		$theme_image_dir = esc_url( get_template_directory_uri() . '/images/' );
		$child_image_dir = esc_url( get_stylesheet_directory_uri() . '/images/' );

		if ( file_exists( $child_image_dir ) && is_child_theme() ) {

			$theme_image_dir = $child_image_dir;
		}

		$theme_image_dir = wp_make_link_relative( $theme_image_dir );

		return $theme_image_dir;
	}
}

if ( ! function_exists( 'emulsion_upload_base_dir' ) ) {
	/**
	 * Theme Image Directory
	 * for scss variable
	 * Not support uploads_use_yearmonth_folders
	 */
	function emulsion_upload_base_dir() {

		$upload_base_dir = '';

		$holder = get_option( 'uploads_use_yearmonth_folders' );

		if ( ! empty( $holder ) ) {
			return $upload_base_dir;
		}

		$upload_dir		 = wp_upload_dir();
		$url			 = esc_url( $upload_dir['baseurl'] . '/' );
		$upload_base_dir = wp_make_link_relative( $url );

		return $upload_base_dir;
	}

}

if ( ! function_exists( 'emulsion_header_image_ratio' ) ) {
	/**
	 * header image ratio
	 * Todo: can not give out the ratio of all header images
	 * Currently, I want the size of the header image to be unified
	 */
	function emulsion_header_image_ratio() {

		$header_width		 = get_custom_header()->width;
		$header_height		 = get_custom_header()->height;
		$header_image_ratio	 = 0.5625;

		if ( is_singular() && has_post_thumbnail() ) {

			$post_id			 = get_the_ID();
			$post_thumbnail_id	 = get_post_thumbnail_id( $post_id );
			$attachment			 = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
			$header_width		 = $attachment[1];
			$header_height		 = $attachment[2];
			$header_image_ratio	 = floatval( $header_height / $header_width );
		}

		if ( ! empty( $header_width ) && ! empty( $header_height ) && ! is_singular() ) {

			$header_image_ratio = floatval( $header_height / $header_width );
		}
		
		if( is_float( $header_image_ratio ) ) {
			
			return $header_image_ratio;
		} else {
			return 0.5625;
		}
	}
}

if ( ! function_exists( 'emulsion_sidebar_background' ) ) {
	/**
	 * Return sidebar color calculated from background color
	 * @return string
	 */
	function emulsion_sidebar_background(  ) {

		$background_color	 = emulsion_get_background_color();
		$background_default  = emulsion_get_supports( 'background' )[0]['default']['default-color'];
		$text_color			 = emulsion_contrast_color();

		if ( '#ffffff' == $text_color ) {

			if ( $background_default !== $background_color ) {

				$sidebar_background = '#000000';
			} else {

				$sidebar_background = 'inherit';
			}
			$sidebar_background = apply_filters( 'emulsion_sidebar_background_light', $sidebar_background );
		}
		if ( '#333333' == $text_color ) {

			if ( $background_default !== $background_color ) {


				$sidebar_background = '#ffffff';

			} else {

				$sidebar_background = 'inherit';
			}
			$sidebar_background = apply_filters( 'emulsion_sidebar_background_light', $sidebar_background );
		}

		return apply_filters('emulsion_sidebar_background', $sidebar_background );
	}
}

if ( ! function_exists( 'emulsion_hover_colors' ) ) {
	/**
	 * Returns the hover color calculated from the background color
	 * The hover color mainly applies to .entry-content links. Hover colors such as headers and sidebars are defined in CSS
	 * for customizer link hover setting
	 * @return type
	 */
	function emulsion_hover_colors( $hex_color = '' , $location = '' ) {

		$text_color = emulsion_contrast_color( $hex_color );

		if ( '#ffffff' == $text_color ) {

			$hover_color = apply_filters( 'emulsion_hover_color_article_dark', $text_color );
		}
		if ( '#333333' == $text_color ) {

			$hover_color = apply_filters( 'emulsion_hover_color_article_light', $text_color );
		}
		if( ! empty( $location ) ) {

			$hover_color = apply_filters('emulsion_link_color_'. $location , $hover_color );
		}
		return apply_filters( 'emulsion_hover_color', $hover_color );
	}
}


if ( ! function_exists( 'emulsion_link_colors' ) ) {

	/**
	 * Return link color calculated from background color
	 * CSS variables
	 * @return hex color
	 */

	function emulsion_link_colors( $hex_color = '' , $location = '' ) {

		$text_color = emulsion_contrast_color( $hex_color );

		if( 'gallery' == $location ) {

			return apply_filters('emulsion_link_color_gallery', '#cccccc' );
		}

		if ( '#ffffff' == $text_color ) {

			$link_color = apply_filters( 'emulsion_link_color_dark_'. $location, '#cccccc' );
		}
		if ( '#333333' == $text_color ) {

			$link_color = apply_filters( 'emulsion_link_color_light'. $location, '#666666' );
		}

		if( ! empty( $location ) ) {

			$link_color = apply_filters('emulsion_link_color_'. $location , $link_color );
		}

		return apply_filters( 'emulsion_link_color', $link_color );
	}

}


if ( ! function_exists( 'emulsion_element_classes' ) ) {

/**
 * Adds a class according to the primary menu background color,sidebar background color specified in the customizer.
 * Return the class specified by location
 * @param type $location
 * @return string
 * 
 * @since 0.99 class name change from menu-has-column to menu-active
 */

	function emulsion_element_classes( $location = '' ) {

		if ( 'primary' == $location ) {

			$is_active_menu		 = emulsion_is_active_nav_menu( $location );
			$sidebar_position	 = get_theme_mod( 'emulsion_sidebar_position', emulsion_get_var( 'emulsion_sidebar_position' ) );
			$menu_background	 = get_theme_mod( 'emulsion_primary_menu_background', emulsion_get_var( 'emulsion_primary_menu_background' ) );
			$menu_text_color	 = emulsion_contrast_color( $menu_background );
			$menu_color_class	 = '';

			if ( '#ffffff' == $menu_text_color ) {

				$menu_color_class = 'menu-is-dark';
			}
			if ( '#333333' == $menu_text_color ) {

				$menu_color_class = 'menu-is-light';
			}

			$class	 = 'primary-menu-wrapper';
			$class	 .= $is_active_menu ? ' menu-active' : ' menu-inactive';
			$class	 .= ' ' . sanitize_html_class( 'side-' . $sidebar_position );
			$class	 .= ' ' . $menu_color_class;

			return $class;
		}

		if ( 'sidebar-widget-area' == $location || 'footer-widget-area' == $location ) {

			$background			 = get_theme_mod( 'emulsion_sidebar_background', emulsion_get_var( 'emulsion_sidebar_background', 'default' ) );
			$text_color			 = emulsion_contrast_color( $background );
			$text_color_class	 = '';
			$footer_cols_class   = '';

			if ( '#ffffff' == $text_color ) {

				$text_color_class = 'sidebar-is-dark';
			}
			if ( '#333333' == $text_color ) {

				$text_color_class = 'sidebar-is-light';
			}
			if( get_theme_mod( 'emulsion_sidebar_background', false ) == emulsion_get_var( 'emulsion_sidebar_background', 'default' ) ||
				false === get_theme_mod( 'emulsion_sidebar_background', false ) ) {
				$text_color_class = 'sidebar-is-default';
			}

			if ( 'footer-widget-area' == $location ) {

				$footer_cols_class = get_theme_mod( 'emulsion_footer_columns', emulsion_get_var( 'emulsion_footer_columns' ) );				
				$footer_cols_class = 'footer-cols-'. absint( $footer_cols_class );
			}

			return ' ' . $text_color_class . ' '. $footer_cols_class;
		}
	}
}


function emulsion_sidebar_background_reset(  ) {

	return '#'. emulsion_get_supports( 'background' )[0]['default']['default-color'];
}
function emulsion_sidebar_text_color_reset(  ) {

	$background = emulsion_sidebar_background_reset();

	return emulsion_contrast_color( $background );

}
function emulsion_sidebar_link_color_reset(  ) {

	$background = emulsion_sidebar_background_reset();

	return emulsion_link_colors( $background );

}

function emulsion_header_background_color_reset(  ) {

	return emulsion_get_var( 'emulsion_header_background_color', 'default' );
}

function emulsion_header_text_color_reset(  ) {

	$background = emulsion_header_background_color_reset();

	return emulsion_contrast_color( $background );

}
function emulsion_header_link_color_reset(  ) {

	$background = emulsion_sidebar_background_reset();

	return emulsion_link_colors( $background );

}

function emulsion_background_color_reset(  ) {

	return '#'. emulsion_get_supports( 'background' )[0]['default']['default-color'];
}

function emulsion_general_text_color_reset(  ) {

	$default_bacckground = '#'. emulsion_get_supports( 'background' )[0]['default']['default-color'];

	return emulsion_contrast_color( $default_bacckground );
}

function emulsion_general_link_color_reset(  ) {

	$default_bacckground = '#'. emulsion_get_supports( 'background' )[0]['default']['default-color'];

	$link_color = emulsion_link_colors( $default_bacckground );

	return $link_color;
}

function emulsion_primary_menu_background_reset( ) {

	return '#'. emulsion_get_supports( 'background' )[0]['default']['default-color'];

}
function emulsion_primary_menu_link_color_reset( ) {

	$background = emulsion_primary_menu_background_reset( );

	return emulsion_link_colors( $background );
}
function emulsion_primary_menu_text_color_reset( ) {

	$background =emulsion_primary_menu_background_reset();

	return emulsion_contrast_color( $background );

}