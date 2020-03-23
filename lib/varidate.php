<?php

/**
 * Form allowed elements
 * for wp_kses();
 * target password post form and search form
 */
const EMULSION_FORM_ALLOWED_ELEMENTS = array(
	'div'	 => array(
		'class'	 => true,
		'id'	 => true,
	),
	'form'	 => array(
		'action' => true,
		'class'	 => true,
		'method' => true,
		'role'	 => true,
	),
	'p'		 => array(
		'class'	 => true,
		'id'	 => true,
	),
	'wbr'	 => true,
	'label'	 => array(
		'for'	 => true,
		'class'	 => true,
	),
	'input'	 => array(
		'name'				 => true,
		'id'				 => true,
		'class'				 => true,
		'type'				 => true,
		'size'				 => true,
		'placeholder'		 => true,
		'required'			 => true,
		'value'				 => true,
		'aria-required'		 => true,
		'aria-describedby'	 => true,
		'aria-label'		 => true,
	),
	'button' => array(
		'type'	 => true,
		'class'	 => true,
	)
);

/**
 * Target inline svg
 */
const EMULSION_ICON_SVG_SYMBOLS_ALLOWED_ELEMENTS = array(
	'svg'	 => array(
		'class'				 => true,
		'aria-labelledby'	 => true,
		'role'				 => true,
		'aria-hidden'		 => true,
		'width'				 => true,
		'height'			 => true,
		'xmlns'				 => true,
		'id'              => true,
	),
	'defs' => true,
	'symbol' => array(
		'class'		 => true,
		'id'		 => true,
		'viewBox'	 => true,
		'viewbox'	 => true,
	),
	'title'	 => array(
		'id'	 => true,
		'desc'	 => true,
	),
	'path'	 => array(
		'd'		 => true,
		'class'	 => true,
		'fill'	 => true
	),
	'circle' => array(
		'cx' => true,
		'cy' => true,
		'r'	 => true,
	),
	'use'	 => array(
		'href'		 => true,
		'xlink:href' => true
	),
);
const EMULSION_EXCERPT_ALLOWED_ELEMENTS = array(
	'p'	 => array(
		'data-rows'	 => true,
		'class'		 => true,
		'span'		 => true
	),
	'br' => array(),
);

const EMULSION_POST_META_DATA_ALLOWED_ELEMENTS = array(
	/* posted on */
	'a'		 => array(
		'href'		 => true,
		'class'		 => true,
		'rel'		 => true,
		'data-title' => true,
		'title'		 => true,
	),
	'time'	 => array(
		'datetime'	 => true,
		'class'		 => true,
	),
	'span'	 => array(
		'class' => true,
	),
	'div'	 => array(
		'class' => true,
	),
	'img'	 => array(
		'class'	 => true,
		'src'	 => true,
		'width'	 => true,
		'height' => true,
		'alt'	 => true,
	)
);
/**
 * Theme wp_kses_post allowed tag and attribute
 * filter page_menu_link_attributes
 * @since 1.0.0
 */

add_filter( "wp_kses_allowed_html", function( $allowedposttags, $context ) {

	if ( $context == "post" ) {

		$emulsion_allowed_tag	 = array(
			'a' => array(
				'href'				 => true,
				'rel'				 => true,
				'rev'				 => true,
				'name'				 => true,
				'target'			 => true,
				'download'			 => array(
					'valueless' => 'y',
				),
				'aria-current'		 => true,
				'data-no-instant'	 => true,
			),
				);
		$emulsion_allowed_tag	 = array_map( '_wp_add_global_attributes', $emulsion_allowed_tag );

		return array_merge( $allowedposttags, $emulsion_allowed_tag );
	}

	return $allowedposttags; }, 99, 2 );

/**
 * test 
 * List of judgment tests for emulsion_color_value_validate.
 * Test listings are here for recently created functions.
 * 
			echo '<div class="fit"> <h1>Unit test</h1>';
			echo '<h2>correct emulsion_rgb2hex</h2>';			
			echo emulsion_rgb2hex( $rgb = array( 0, 0, 0 ) );
			echo '<h2>count error</h2>';
			echo var_dump( emulsion_rgb2hex( $rgb = array( 0, 0, 0, 0 ) ) );
			echo '<h2>value error</h2>';
			echo var_dump( emulsion_rgb2hex( $rgb = array( 0, 0, 256 ) ) );
			echo '<hr />';			
			echo '<h2>correct emulsion_the_hex2rgb</h2>';			
			echo emulsion_the_hex2rgb( '#ffa500' ) ;		
			echo '<h2>correct emulsion_the_hex2rgb no hash</h2>';	
			echo emulsion_the_hex2rgb( 'ffa500' ) ;
			echo '<h2>bad value</h2>';
			echo var_dump( emulsion_the_hex2rgb( '#ffa50') );
			echo '<h2>bad value no hash</h2>';
			echo var_dump( emulsion_the_hex2rgb( '#ffa50' ) );
			echo '<hr />';			
			echo '<h2>correct emulsion_the_hex2rgba</h2>';			
			echo emulsion_the_hex2rgba( '#ffa500' ) ;		
			echo '<h2>correct emulsion_the_hex2rgba no hash</h2>';	
			echo emulsion_the_hex2rgba( 'ffa500' ) ;
			echo '<h2>bad value</h2>';
			echo var_dump( emulsion_the_hex2rgba( '#ffa50') );
			echo '<h2>bad value no hash</h2>';
			echo var_dump( emulsion_the_hex2rgba( '#ffa50' ) );
			echo '<hr />';
			echo '<h2> 2 correct emulsion_the_hex2rgba</h2>';			
			echo emulsion_the_hex2rgba( '#ffa500',.5 ) ;		
			echo '<h2>correct emulsion_the_hex2rgba no hash</h2>';	
			echo emulsion_the_hex2rgba( 'ffa500',.5 ) ;
			echo '<h2>bad value</h2>';
			echo var_dump( emulsion_the_hex2rgba( '#ffa50',1.1) );
			echo '<h2>bad value no hash</h2>';
			echo var_dump( emulsion_the_hex2rgba( '#ffa50',1.1 ) );
			echo '<hr />';			
			echo '<h2>correct emulsion_the_hex2hsla</h2>';			
			echo emulsion_the_hex2hsla( '#ffa500' ) ;		
			echo '<h2>correct emulsion_the_hex2hsla no hash</h2>';	
			echo emulsion_the_hex2hsla( 'ffa500' ) ;
			echo '<h2>bad value</h2>';
			echo var_dump( emulsion_the_hex2hsla( '#ffa50') );
			echo '<h2>bad value no hash</h2>';
			echo var_dump( emulsion_the_hex2hsla( '#ffa50' ) );
			echo '<hr />';		
			echo '<h2> 2 correct emulsion_the_hex2hsla</h2>';			
			echo emulsion_the_hex2hsla( '#ffa500',.5 ) ;		
			echo '<h2>correct emulsion_the_hex2hsla no hash</h2>';	
			echo emulsion_the_hex2hsla( 'ffa500',.5 ) ;
			echo '<h2>bad value</h2>';
			echo var_dump( emulsion_the_hex2hsla( '#ffa50',1.1) );
			echo '<h2>bad value no hash</h2>';
			echo var_dump( emulsion_the_hex2hsla( '#ffa50',1 ) );
			echo '</div>';
 			echo '<h2> correct emulsion_color_value_validate $type = alpha</h2>';
			$extreme_value = [ 'correct-1' => 1, 'correct-2' => .5, 'correct-3' => 0, 'incorrect-1' => -1, 'incorrect-2' => 1.1 ];

			foreach ( $extreme_value as $key => $val ) {
				echo '<p>';
				echo 'emulsion_color_value_validate( ' . $val . ', $type = \'alpha\' )[' . $key . '] :' . var_export( emulsion_color_value_validate( $val, 'alpha' ), true );
				echo '</p>';
			}
 * Coding example
 * 
				$base_color		 = '#8e44ad';
				$accent_color	 = emulsion_accent_color( $base_color );
				$text_color		 = emulsion_contrast_color( $accent_color );

				$html = sprintf(
						'<div class="fit" style="background:%1$s;padding:2rem;">'
							. '<div style="background:%2$s;color:%3$s">'
								. '<p>hello world</p>'
							. '</div>'
						. '</div>', 
						$base_color, 
						$accent_color, 
						$text_color );

				echo $html;
 * 
 */

function emulsion_color_value_validate( $values, $type = 'hex' ) {
	
	/**
	 * Color args value check
	 * @since ver1.1.6
	 */

	if ( 'rgb' == $type ) {
		if ( ! is_array( $values ) ) {
			return false;
		}

		foreach ( $values as $value ) {

			$is_valid = is_integer( $value ) && $value >= 0 && $value <= 255 ? true : false;

			if ( false === $is_valid ) {
				break;
			}
		}
		return ( 3 === count( $values ) && true === $is_valid );
	}
	
	if ( 'rgba' == $type ) {
		
		if ( ! is_array( $values ) ) {
			
			return false;
		}

		foreach ( $values as $key => $value ) {

			$is_valid = is_integer( $value ) && $value >= 0 && $value <= 255 ? true : false;
			
			if( 3 == $key ) {
				//The value is not necessarily a float 0,1
				$is_valid =  $value >= 0 && $value <= 1 ? true : false;
			}

			if ( false === $is_valid ) {
				
				break;
			}
		}
		return ( 4 === count( $values ) && true === $is_valid );
	}
	
	if( 'alpha' == $type ) {
		
		return is_numeric( $values ) && $values >= 0 && $values <= 1 ? true : false;
	}
	
	if( 'hex' == $type) {
		
		return ! empty( sanitize_hex_color( $values ) );
	}
	if( 'hex_no_hash' == $type) {
		
		return ! empty( sanitize_hex_color_no_hash( $values ) );
	}
}

/**
 * Customizer sanitize callback
 * 
 * Each option value has a corresponding varidate function.
 * 
 * Get_theme_mod (), a function to get option values, can use theme_mod_{$ option_name}.filter.
 * For example, the color property value set in the customizer is limited to hex color.
 * When a filter is used, not only hex color value but also rgb () and hsl () can be used even if the value is invalid.
 * 
 * What is the method when users always want to close with hex color values?
 * 
 * for example emulsion_sidebar_background
 * 
 * By using a filter like the following, if an unintended value is used, it will be able to return the default value.
 * 
 * add_filter('theme_mod_emulsion_sidebar_background', 'filter_emulsion_sidebar_background', PHP_INT_MAX);
 * 
 * function filter_color_varidate( $value ){
 *		
 *		$valid_value = emulsion_header_background_color_validate( $value );
 * 
 *		if( ! empty( $valid_value ) ) {
 *			return $valid_value;
 *		}
 * 
 *		return emulsion_get_var('emulsion_header_background_color','default' );
 * }
 *
 */
	
function emulsion_bg_image_blend_color_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_header_sub_background_color_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_favorite_color_palette_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_header_background_color_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_sidebar_background_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_primary_menu_background_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_relate_posts_bg_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_comments_bg_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_general_link_color_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_general_link_hover_color_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_general_text_color_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_bg_image_blend_color_amount_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( absint( $input ) && $input <= 100 ) {
		return $input;
	}
	return $default_value;
}

function emulsion_layout_search_results_post_image_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_bg_image_text_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_author_archives_post_image_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_tag_archives_post_image_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_category_archives_post_image_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_date_archives_post_image_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_posts_page_post_image_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_homepage_post_image_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_customizer_preview_redirect_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_post_display_author_format_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_post_display_tag_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_post_display_category_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_post_display_author_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_post_display_date_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_background_css_pattern_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_common_font_family_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_heading_font_base_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_common_font_size_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_excerpt_length_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_excerpt_length_grid_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_excerpt_length_stream_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_box_gap_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_header_media_max_height_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_sidebar_width_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_main_width_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_content_width_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_content_margin_top_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_heading_font_family_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_header_gradient_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_category_colors_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_heading_font_weight_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_widget_meta_font_size_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_widget_meta_font_family( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_condition_display_posts_sidebar_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_condition_display_page_sidebar_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_widget_meta_font_transform_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_heading_font_scale_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_heading_font_transform_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_header_layout_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_header_html_validate( $input ) {

	if ( ! empty( $input ) ) {

		// check lost element			
		$emulsion_place = basename( __FILE__ ) . ' line:' . __LINE__ . ' ' . __FUNCTION__ . '()';
		true === WP_DEBUG ? emulsion_elements_assert_equal( $input, wp_kses_post( $input ), $emulsion_place ) : '';

		$input = wp_kses_post( $input );

		return $input;
	}
	return '';
}

function emulsion_title_in_header_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_sidebar_position_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_homepage_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_posts_page_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_date_archives_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_category_archives_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_tag_archives_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_author_archives_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_layout_search_results_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_footer_credit_validate( $input ) {

	// check lost element			
	$emulsion_place = basename( __FILE__ ) . ' line:' . __LINE__ . ' ' . __FUNCTION__ . '()';
	true === WP_DEBUG ? emulsion_elements_assert_equal( $input, wp_kses_post( $input ), $emulsion_place ) : '';

	$input = wp_kses_post( $input );

	return $input;
}

function emulsion_footer_columns_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_table_of_contents_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_reset_theme_settings_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_tooltip_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_sticky_sidebar_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_lazyload_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_instantclick_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_alignfull_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_colors_for_editor_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_common_google_font_url_validate( $input ) {

	if ( 'fonts.googleapis.com' !== parse_url( $input, PHP_URL_HOST ) ) {
		return '';
	}
	if ( ! wp_http_validate_url( $input ) ) {
		return '';
	}
	return esc_url_raw( $input );
}

function emulsion_heading_google_font_url_validate( $input ) {

	if ( 'fonts.googleapis.com' !== parse_url( $input, PHP_URL_HOST ) ) {
		return '';
	}
	if ( ! wp_http_validate_url( $input ) ) {
		return '';
	}

	return esc_url_raw( $input );
}

function emulsion_widget_meta_google_font_url_validate( $input ) {

	if ( 'fonts.googleapis.com' !== parse_url( $input, PHP_URL_HOST ) ) {
		return '';
	}
	if ( ! wp_http_validate_url( $input ) ) {
		return '';
	}
	return esc_url_raw( $input );
}

function emulsion_widget_meta_title_validate( $input ) {

	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function emulsion_excerpt_linebreak_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_relate_posts_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'choices' );
	$default_value	 = emulsion_get_var( $name, 'default' );

	if ( array_key_exists( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_block_gallery_section_bg_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_block_gallery_section_height_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_block_columns_section_bg_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_block_columns_section_height_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

function emulsion_block_media_text_section_bg_validate( $input ) {

	return sanitize_hex_color( $input );
}

function emulsion_block_media_text_section_height_validate( $input ) {

	$name			 = str_replace( '_validate', '', __FUNCTION__ );
	$values			 = emulsion_get_var( $name, 'input_attrs' );
	$default_value	 = (int) emulsion_get_var( $name, 'default' );

	$options = array(
		'min_range'	 => $values['min'],
		'max_range'	 => $values['max'],
		'default'	 => $default_value,
	);
	return filter_var( $input, FILTER_VALIDATE_INT, array( 'options' => $options ) );
}

if ( ! function_exists( 'emulsion_get_var' ) ) {

	function emulsion_get_var( $name = '', $property = '' ) {

		global $emulsion_customize_args;


		if ( ! empty( $emulsion_customize_args[$name] ) && array_key_exists( $name, $emulsion_customize_args ) ) {

			if ( empty( $property ) ) {

				return get_theme_mod( $name, $emulsion_customize_args[$name]['default'] );
			}
			if ( ! empty( $property ) && isset( $emulsion_customize_args[$name][$property] ) ) {

				return $emulsion_customize_args[$name][$property];
			}

			return false;
		} else {

			return false;
		}
	}

}
