<?php

/**
 * Form allowed elements
 * for wp_kses();
 * target password post form and search form
 */
const EMULSION_FORM_ALLOWED_ELEMENTS = array(
	'div'	 => array(
		'class'	 => array(),
		'id'	 => array(),
	),
	'form'	 => array(
		'action' => array(),
		'class'	 => array(),
		'method' => array(),
		'role'	 => array(),
	),
	'p'		 => array(
		'class'	 => array(),
		'id'	 => array(),
	),
	'wbr'	 => array(),
	'label'	 => array(
		'for'	 => array(),
		'class'	 => array(),
	),
	'input'	 => array(
		'name'				 => array(),
		'id'				 => array(),
		'class'              => array(),
		'type'				 => array(),
		'size'				 => array(),
		'placeholder'		 => array(),
		'required'			 => array(),
		'value'				 => array(),
		'aria-required'		 => array(),
		'aria-describedby'	 => array(),
		'aria-label'		 => array(),
	),
	'button' => array(
		'type'	 => array(),
		'class'	 => array(),
	)
);
/**
 * Target inline svg
 */
const EMULSION_ICON_SVG_SYMBOLS_ALLOWED_ELEMENTS = array(
			'svg'	 => array( 
				'class' => array(), 
				'aria-labelledby' => array(), 
				'role' => array(), 
				'aria-hidden' => array(), 
				'width' => array(), 
				'height' => array() 
			),
			'symbol' => array(
				'class'		 => array(),
				'id'		 => array(),
				'viewBox'	 => array(),
				'viewbox'	 => array(),
			),
			'title'	 => array( 
				'id' => array(), 
				'desc' => array(),
			),
			'path'	 => array(
				'd'		 => array(),
				'class'	 => array(),
				'fill'	 => array()
			),
			'circle' => array(
				'cx' => array(),
				'cy' => array(),
				'r'	 => array(),
			),
			'use'	 => array( 
				'href' => array(), 
				'xlink:href' => array() 
			),
		);
const EMULSION_EXCERPT_ALLOWED_ELEMENTS	= array( 
	'p' => array( 
		'data-rows' => array(), 
		'class' => array(), 
		'span' => array() 
		), 
	'br' => array(),
	);

const EMULSION_POST_META_DATA_ALLOWED_ELEMENTS = array(
	/* posted on */
			'a'		 => array(
				'href'	 => array(),
				'class'	 => array(),
				'rel'	 => array(),
				'data-title' => array(),
				'title' => array(),
			),
			'time'	 => array(
				'datetime'	 => array(),
				'class'		 => array(),
			),
			'span'	 => array(
				'class' => array(),
			),
			'div' => array(
				'class' => array(),
			),
			'img' => array(
				'class' => array(),
				'src' => array(),
				'width'=> array(),
				'height'=>array(),
				'alt'=> array(),
			)
		);
const EMULSION_ANCHOR_ALLOWED_ELEMENTS = array(
	/* posted on */
			'a'		 => array(
				'href'	 => array(),
				'class'	 => array(),
				'rel'	 => array(),
				'data-title' => array(),
				'title' => array(),
				'download' => array(),
				'hreflang' => array(),
				'ping' => array(),
				'target' => array(),
				'id' => array(),
				'style' => array(),
				'data-no-instant' => array(),
			),
		);
/**
 * Customizer sanitize callback
 *
 */
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
function emulsion_layout_search_results_post_image_validate( $input ) {

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

function emulsion_heading_font_size_validate( $input ) {

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
		$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
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
	$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
	true === WP_DEBUG ? emulsion_elements_assert_equal(  $input, wp_kses_post( $input ), $emulsion_place ) : '';

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
