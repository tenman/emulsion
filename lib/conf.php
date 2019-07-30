<?php
/**
 * Theme default settings
 * 
 * Background color
 * Fonts  General
 * Fonts Heading
 * Fonts Widget and metadata
 * Layout
 * Footer
 * Advanced
 * Block editor
 * Post
 *
 * Panel
 * Section
 * Active Callback
 */
define( 'EMULSION_MIN_PHP_VERSION', '5.6' );

$content_width			 = ! isset( $content_width ) ? 720 : $content_width;
$emulsion_setting_type	 = 'theme_mod';
$emulsion_customize_cap	 = 'edit_theme_options';

$emulsion_customize_args = array(
	/**
	 * Background color
	 */
	"emulsion_header_gradient"				 => array(
		'section'					 => 'colors',
		'priority'					 => 7,
		'default'					 => "disable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Gradient header', 'emulsion' ),
		'description'				 => esc_html__( 'Display gradation with Background Color and Sub Background Color.', 'emulsion' ),
		'validate'					 => 'emulsion_header_gradient_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_header_background_color"		 => array(
		'section'					 => 'colors',
		//'default'					 => '#f8f8ff',
		'default'					 => '#ffffff',
		'priority'					 => 8,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Header Background Color', 'emulsion' ),
		'description'				 => '',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'validate'					 => 'emulsion_header_background_color_validate',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
		'extend_customize_setting'	 => '',
	),
	"emulsion_header_sub_background_color"	 => array(
		'section'					 => 'colors',
		'default'					 => '#ffffff',
		'priority'					 => 8,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Header Sub Background Color', 'emulsion' ),
		'description'				 => '',
		//'active_callback'			 => 'emulsion_header_sub_background_color_active_callback',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'validate'					 => 'emulsion_header_sub_background_color_validate',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
		'extend_customize_setting'	 => '',
	),
	
	"emulsion_category_colors"					 => array(
		'section'					 => 'colors',
		'priority'					 => 9,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Category Color', 'emulsion' ),
		'description'				 => esc_html__( 'Add category colors to headers and links', 'emulsion' ),
		'validate'					 => 'emulsion_category_colors_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_sidebar_background"				 => array(
		'section'					 => 'colors',
		'default'					 => emulsion_sidebar_background(),
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Sidebar Background Color', 'emulsion' ),
		'description'				 => '',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'validate'					 => 'emulsion_sidebar_background_validate',
		'extend_customize_control'	 => '',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
		'extend_customize_setting'	 => '',
	),
	"emulsion_primary_menu_background"			 => array(
		'section'					 => 'colors',
		'default'					 => emulsion_sidebar_background(),
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Primary Menu Background Color', 'emulsion' ),
		'description'				 => '',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'validate'					 => 'emulsion_primary_menu_background_validate',
		'extend_customize_control'	 => '',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
		'extend_customize_setting'	 => '',
	),
	"emulsion_relate_posts_bg"					 => array(
		'section'					 => 'colors',
		'default'					 => '#eeeeee',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Relate Posts background Color', 'emulsion' ),
		'description'				 => emulsion_control_description( 'emulsion_relate_posts_bg' ),
		
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'validate'					 => 'emulsion_relate_posts_bg_validate',
		'extend_customize_control'	 => '',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
		'extend_customize_setting'	 => '',
	),
	"emulsion_comments_bg"						 => array(
		'section'					 => 'colors',
		'default'					 => '#eeeeee',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Comments background Color', 'emulsion' ),
		'description'				 => emulsion_control_description( 'emulsion_comments_bg' ),
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'validate'					 => 'emulsion_comments_bg_validate',
		'extend_customize_control'	 => '',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
		'extend_customize_setting'	 => '',
	),
	"emulsion_background_css_pattern"			 => array(
		'section'					 => 'colors',
		'priority'					 => 10,
		'default'					 => "none",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Background Pattern', 'emulsion' ),
		'description'				 => esc_html__( 'The background color must be set in advance', 'emulsion' ),
		'validate'					 => 'emulsion_background_css_pattern_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'none'			 => esc_html__( 'None', 'emulsion' ),
			'carbon-fiber'	 => esc_html__( 'Carbon Fiber pattern', 'emulsion' ),
			'seigaiha'		 => esc_html__( 'Seigaiha pattern', 'emulsion' ),
			'cicada'		 => esc_html__( 'Cicada Principle', 'emulsion' ),
			'lattice'		 => esc_html__( 'Lattice pattern', 'emulsion' ),
			'hexagonal'		 => esc_html__( 'Hexagon pattern', 'emulsion' ),
		),
	),
	"emulsion_general_link_color"				 => array(
		'section'					 => 'colors',
		'priority'					 => 10,
		'default'					 => emulsion_link_colors(),
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Link Color', 'emulsion' ),
		'description'				 => esc_html__( 'set link color', 'emulsion' ),
		'validate'					 => 'emulsion_general_link_color_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
	),
	"emulsion_general_link_hover_color"		 => array(
		'section'					 => 'colors',
		'priority'					 => 10,
		'default'					 => emulsion_hover_colors(),
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Link Hover Color', 'emulsion' ),
		'description'				 => esc_html__( 'set hover color', 'emulsion' ),
		'validate'					 => 'emulsion_general_link_hover_color_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
	),
	"emulsion_general_text_color"				 => array(
		'section'					 => 'colors',
		'priority'					 => 10,
		'default'					 => emulsion_contrast_color(),
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Text Color', 'emulsion' ),
		'description'				 => esc_html__( 'set text color', 'emulsion' ),
		'validate'					 => 'emulsion_general_text_color_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
	),
	/**
	 * Fonts  General
	 */
	"emulsion_common_font_size"				 => array(
		'section'					 => 'emulsion_section_fonts_general',
		'priority'					 => 10,
		'default'					 => 16,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'emulsion_unit'			 => 'px',
		'label'						 => esc_html__( 'Base font size', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_common_font_size_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 13,
			'max'	 => 24,
			'step'	 => 1,
		),
	),
	"emulsion_common_font_family"				 => array(
		'section'					 => 'emulsion_section_fonts_general',
		'priority'					 => 10,
		'default'					 => "sans-serif",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Base font family', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_common_font_family_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'serif'		 => esc_html__( 'Serif', 'emulsion' ),
			'sans-serif' => esc_html__( 'Sans Serif', 'emulsion' ),
		),
	),
	"emulsion_common_google_font_url"			 => array(
		'section'					 => 'emulsion_section_fonts_general',
		'priority'					 => 10,
		'default'					 => "",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Google fonts', 'emulsion' ),
		'description'				 => sprintf( '<a href="%1$s" target="blank" rel="nofollow noopener noreferrer">%2$s</a>', 'https://fonts.google.com/', esc_html__( 'Google fonts', 'emulsion' ) ) .
		' ' . esc_html__( '( new tab )', 'emulsion' ),
		'validate'					 => 'emulsion_common_google_font_url_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'esc_attr',
		'extend_customize_control'	 => '',
		'type'						 => 'url',
		'input_attrs'				 => array(
			/* translators: Here is an example of google font url. Please do not translate, please show original text */
			'placeholder' => esc_html__( 'https://fonts.googleapis.com/css?family=Roboto', 'emulsion' ),
		),
	),
	/**
	 * Fonts Heading
	 */
	"emulsion_heading_font_family"				 => array(
		'section'					 => 'emulsion_section_fonts_heading',
		'priority'					 => 9,
		'default'					 => "serif",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Heading Font Family', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_title_fonts_family_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'serif'		 => esc_html__( 'Serif', 'emulsion' ),
			'sans-serif' => esc_html__( 'Sans Serif', 'emulsion' ),
		),
	),
	"emulsion_heading_font_weight"				 => array(
		'section'					 => 'emulsion_section_fonts_heading',
		'priority'					 => 9,
		'default'					 => '700',
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Heading Font Weight', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_heading_font_weight_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'100'	 => esc_html__( 'Thin', 'emulsion' ),
			'400'	 => esc_html__( 'Normal', 'emulsion' ),
			'700'	 => esc_html__( 'bold', 'emulsion' ),
		),
	),
	"emulsion_heading_font_size"				 => array(
		'section'					 => 'emulsion_section_fonts_heading',
		'priority'					 => 10,
		'default'					 => 'xxx',
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Font Size h1-h6', 'emulsion' ),
		'description'				 => esc_html__( 'h1 element font size, 3 times or 2 times normal character.', 'emulsion' ),
		'validate'					 => 'emulsion_heading_font_size_validate', //ch
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'xx'	 => esc_html__( '2x ', 'emulsion' ),
			'xxx'	 => esc_html__( '3x bigger', 'emulsion' ),
		),
	),
	"emulsion_heading_font_transform"			 => array(
		'section'					 => 'emulsion_section_fonts_heading',
		'priority'					 => 10,
		'default'					 => 'uppercase',
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Text transform', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_heading_font_transform_validate', //ch
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'none'		 => esc_html__( 'none', 'emulsion' ),
			'uppercase'	 => esc_html__( 'uppercase', 'emulsion' ),
			'lowercase'	 => esc_html__( 'lowercase', 'emulsion' ),
			'capitalize' => esc_html__( 'capitalize', 'emulsion' ),
		),
	),
	"emulsion_heading_google_font_url"			 => array(
		'section'					 => 'emulsion_section_fonts_heading',
		'priority'					 => 10,
		'default'					 => "",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Google fonts', 'emulsion' ),
		'description'				 => sprintf( '<a href="%1$s" target="blank" rel="nofollow noopener noreferrer">%2$s</a>', 'https://fonts.google.com/', esc_html__( 'Google fonts', 'emulsion' ) ) .
		' ' . esc_html__( '( new tab )', 'emulsion' ),
		'validate'					 => 'emulsion_heading_google_font_url_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'esc_attr',
		'extend_customize_control'	 => '',
		'type'						 => 'url',
		'input_attrs'				 => array(
			/* translators: Here is an example of google font url. Please do not translate, please show original text */
			'placeholder' => __( 'https://fonts.googleapis.com/css?family=Roboto', 'emulsion' ),
		),
	),
	/**
	 * Fonts Widget and metadata
	 */
	"emulsion_widget_meta_font_size"			 => array(
		'section'					 => 'emulsion_section_fonts_widget_meta',
		'priority'					 => 10,
		'default'					 => 13,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'emulsion_unit'			 => 'px',
		'label'						 => esc_html__( 'Font Size', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_widget_meta_font_size_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 10,
			'max'	 => 24,
			'step'	 => 1,
		),
	),
	"emulsion_widget_meta_font_family"			 => array(
		'section'					 => 'emulsion_section_fonts_widget_meta',
		'priority'					 => 10,
		'default'					 => "sans-serif",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Font Family', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_widget_meta_font_family',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'serif'		 => esc_html__( 'Serif', 'emulsion' ),
			'sans-serif' => esc_html__( 'Sans Serif', 'emulsion' ),
		),
	),
	"emulsion_widget_meta_font_transform"		 => array(
		'section'					 => 'emulsion_section_fonts_widget_meta',
		'priority'					 => 10,
		'default'					 => 'none',
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Text Transform', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_widget_meta_font_transform_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'none'		 => esc_html__( 'none', 'emulsion' ),
			'uppercase'	 => esc_html__( 'uppercase', 'emulsion' ),
			'lowercase'	 => esc_html__( 'lowercase', 'emulsion' ),
			'capitalize' => esc_html__( 'capitalize', 'emulsion' ),
		),
	),
	"emulsion_widget_meta_google_font_url"		 => array(
		'section'					 => 'emulsion_section_fonts_widget_meta',
		'priority'					 => 10,
		'default'					 => "",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Google fonts', 'emulsion' ),
		'description'				 => sprintf( '<a href="%1$s" target="blank" rel="nofollow noopener noreferrer">%2$s</a>', 'https://fonts.google.com/', esc_html__( 'Google fonts', 'emulsion' ) ) .
		' ' . esc_html__( '( new tab )', 'emulsion' ),
		'validate'					 => 'emulsion_widget_meta_google_font_url_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'esc_attr',
		'extend_customize_control'	 => '',
		'type'						 => 'url',
		'input_attrs'				 => array(
			/* translators: Here is an example of google font url. Please do not translate, please show original text */
			'placeholder' => __( 'https://fonts.googleapis.com/css?family=Roboto', 'emulsion' ),
		),
	),
	"emulsion_widget_meta_title"				 => array(
		'section'					 => 'emulsion_section_fonts_widget_meta',
		'priority'					 => 10,
		'default'					 => false,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Widget Title', 'emulsion' ),
		'description'				 => esc_html__( 'Widget title uses this font setting', 'emulsion' ),
		'validate'					 => 'emulsion_widget_meta_title_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'rest_sanitize_boolean',
		'extend_customize_control'	 => '',
		'type'						 => 'checkbox',
	),
	/**
	 * Layout
	 */
	"emulsion_header_layout"					 => array(
		'section'					 => 'emulsion_section_layout_header',
		'default'					 => "custom",
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Header Layout', 'emulsion' ),
		'description'				 => sprintf('<span>%1$s</span><span class="notice emulsion-notice emulsion-control-desc-notice">%2$s</span>', 
													esc_html__( 'You can select two header types or write your own header html.', 'emulsion' ),
													esc_html__( 'If you use header media, please select custom.', 'emulsion' )),
		'validate'					 => 'emulsion_header_layout_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'custom' => esc_html__( 'Custom', 'emulsion' ),
			'simple' => esc_html__( 'Simple', 'emulsion' ),
			'self'	 => esc_html__( 'Do it myself', 'emulsion' ),
		),
	),
	"emulsion_header_html"						 => array(
		'section'					 => 'emulsion_section_layout_header',
		'default'					 => "",
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Header HTML', 'emulsion' ),
		'description'				 => sprintf( '%1$s<br />%2$s', esc_html__( 'Please enter header HTML.', 'emulsion' ), esc_html__( 'If it is blank, the header is not displayed.', 'emulsion' )
		),
		'validate'					 => 'emulsion_header_html_validate',
		'active_callback'			 => 'emulsion_header_html_active_callback',
		'sanitize_callback'			 => 'esc_attr',
		'extend_customize_control'	 => '',
		'type'						 => 'textarea',
		'input_attrs'				 => array(
			/* translators: Here is an example of google font url. Please do not translate, please show original text */
			'placeholder' => __( '<div class="header-text">Site title<p class="site-description">Site description</p></div>', 'emulsion' ),
		),
	),
	"emulsion_title_in_header"					 => array(
		'section'					 => 'emulsion_section_layout_header',
		'default'					 => "yes",
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Display title in header', 'emulsion' ),
		'description'				 => '<p>'.esc_html__( 'You can choose whether to display the title on the header.', 'emulsion' ).'</p>'.
		'<p class="notice emulsion-info">'.esc_html__( 'This setting can not confirm the change in preview. Please open a blog and check it.', 'emulsion' ).'</p>',
		'validate'					 => 'emulsion_title_in_header_validate',
		'active_callback'			 => 'emulsion_title_in_header_active_callback',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'yes'	 => esc_html__( 'Yes', 'emulsion' ),
			'no'	 => esc_html__( 'No', 'emulsion' ),
		),
	),
	"emulsion_header_media_max_height"	 => array(
		'section'					 => 'header_image',
		'default'					 => 75,
		'priority'					 => 4,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Header media max height. percent of the browser window height', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_header_media_max_height_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 50,
			'max' => 120,
			'step' => 1,
		),
	),
	"emulsion_sidebar_position"				 => array(
		'section'					 => 'emulsion_section_layout_sidebar',
		'default'					 => "right",
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Position', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_sidebar_position_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'left'	 => esc_html__( 'Left', 'emulsion' ),
			'right'	 => esc_html__( 'Right', 'emulsion' ),
		),
	),
	"emulsion_sidebar_width"					 => array(
		'section'					 => 'emulsion_section_layout_sidebar',
		'default'					 => 400,
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Width', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_sidebar_width_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 120,
			'max'	 => 480,
			'step'	 => 1,
		),
	),
	"emulsion_condition_display_posts_sidebar"	 => array(
		'section'					 => 'emulsion_section_layout_sidebar',
		'default'					 => 'allways',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Posts sidebar display condition', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_condition_display_posts_sidebar_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'allways'		 => esc_html__( 'Always', 'emulsion' ),
			'logged_in_user' => esc_html__( 'Only Loggedin Users', 'emulsion' ),
		),
	),
	"emulsion_condition_display_page_sidebar"	 => array(
		'section'					 => 'emulsion_section_layout_sidebar',
		'default'					 => 'allways',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Page sidebar display condition', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_condition_display_page_sidebar_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'allways'		 => esc_html__( 'Always', 'emulsion' ),
			'logged_in_user' => esc_html__( 'Only Loggedin Users', 'emulsion' ),
		),
	),
	"emulsion_main_width"						 => array(
		'section'					 => 'emulsion_section_layout_main',
		'default'					 => 1280,
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Main width', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_main_width_validate',
		//'validate_callback'			=> 'emulsion_main_width_limit_value',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 480,
			'max'	 => 1920,
			'step'	 => 1,
		),
	),
	"emulsion_content_width"					 => array(
		'section'					 => 'emulsion_section_layout_main',
		'default'					 => 720,
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Content width', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_content_width_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 480,
			'max'	 => 960,
			'step'	 => 1,
		),
	),
	"emulsion_content_margin_top"				 => array(
		'section'					 => 'emulsion_section_layout_main',
		'default'					 => 0,
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Content margin top', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_content_margin_top_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 0,
			'max'	 => 96,
			'step'	 => 1,
		),
	),
	"emulsion_layout_homepage"					 => array(
		'section'					 => 'emulsion_section_layout_homepage',
		'default'					 => 'excerpt',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Layout', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_layout_homepage_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'grid'		 => esc_html__( 'Grid', 'emulsion' ),
			'stream'	 => esc_html__( 'Stream', 'emulsion' ),
			'excerpt'	 => esc_html__( 'Excerpt', 'emulsion' ),
			'full_text'	 => esc_html__( 'Full text', 'emulsion' ),
		),
	),
	"emulsion_layout_posts_page"				 => array(
		'section'					 => 'emulsion_section_layout_posts_page',
		'default'					 => 'excerpt',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Layout', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_layout_posts_page_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'grid'		 => esc_html__( 'Grid', 'emulsion' ),
			'stream'	 => esc_html__( 'Stream', 'emulsion' ),
			//'post'		 => esc_html__( 'excerpt', 'emulsion' ),
			'excerpt'		 => esc_html__( 'excerpt', 'emulsion' ),
			'full_text'	 => esc_html__( 'Full text', 'emulsion' ),
		),
	),
	"emulsion_layout_date_archives"			 => array(
		'section'					 => 'emulsion_section_layout_date_archives',
		'default'					 => 'grid',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Layout', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_layout_date_archives_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'grid'		 => esc_html__( 'Grid', 'emulsion' ),
			'stream'	 => esc_html__( 'Stream', 'emulsion' ),
			'excerpt'	 => esc_html__( 'Excerpt', 'emulsion' ),
			'full_text'	 => esc_html__( 'Full text', 'emulsion' ),
		),
	),
	"emulsion_layout_category_archives"		 => array(
		'section'					 => 'emulsion_section_layout_category_archives',
		'default'					 => 'stream',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Layout', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_layout_category_archives_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'grid'		 => esc_html__( 'Grid', 'emulsion' ),
			'stream'	 => esc_html__( 'Stream', 'emulsion' ),
			'excerpt'	 => esc_html__( 'Excerpt', 'emulsion' ),
			'full_text'	 => esc_html__( 'Full text', 'emulsion' ),
		),
	),
	"emulsion_layout_tag_archives"				 => array(
		'section'					 => 'emulsion_section_layout_tag_archives',
		'default'					 => 'stream',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Layout', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_layout_tag_archives_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'grid'		 => esc_html__( 'Grid', 'emulsion' ),
			'stream'	 => esc_html__( 'Stream', 'emulsion' ),
			'excerpt'	 => esc_html__( 'Excerpt', 'emulsion' ),
			'full_text'	 => esc_html__( 'Full text', 'emulsion' ),
		),
	),
	"emulsion_layout_author_archives"			 => array(
		'section'					 => 'emulsion_section_layout_author_archives',
		'default'					 => 'stream',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Layout', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_layout_author_archives_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'grid'		 => esc_html__( 'Grid', 'emulsion' ),
			'stream'	 => esc_html__( 'Stream', 'emulsion' ),
			'excerpt'	 => esc_html__( 'Excerpt', 'emulsion' ),
			'full_text'	 => esc_html__( 'Full text', 'emulsion' ),
		),
	),

	"emulsion_layout_search_results"			 => array(
		'section'					 => 'emulsion_section_layout_search_results',
		'default'					 => 'highlight',
		'priority'					 => 10,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Layout Search Results', 'emulsion' ),
		'description'				 => esc_html__( 'This setting does not support preview.Please open a blog and check it.', 'emulsion' ),
		'validate'					 => 'emulsion_layout_search_results_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'highlight'	 => esc_html__( 'Keyword Highlight', 'emulsion' ),
			'full_text'	 => esc_html__( 'Full text', 'emulsion' ),
		),
	),
	/**
	 * Footer
	 */
	"emulsion_footer_credit"					 => array(
		'section'					 => 'emulsion_section_layout_footer',
		'priority'					 => 10,
		'default'					 => "",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Footer Credit', 'emulsion' ),
		'description'				 => /* translators: %current_year%: Four letter current year. */
		esc_html__( '%current_year% keyword replace 4digit year value', 'emulsion' ),
		'validate'					 => 'emulsion_footer_credit_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_post_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'textarea',
	),
	"emulsion_footer_columns"					 => array(
		'section'					 => 'emulsion_section_layout_footer',
		'priority'					 => 10,
		'default'					 => 3,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Footer columns', 'emulsion' ),
		'description'				 => esc_html__( 'If the number of widgets set is less than the setting, the number of columns is displayed according to the number of widgets.', 'emulsion' ),
		'validate'					 => 'emulsion_footer_columns_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			1	 => esc_html__( '1 column', 'emulsion' ),
			2	 => esc_html__( '2 columns', 'emulsion' ),
			3	 => esc_html__( '3 columns', 'emulsion' ),
			4	 => esc_html__( '4 columns', 'emulsion' ),
		),
	),
	/**
	 * Advanced
	 */
	"emulsion_reset_theme_settings"			 => array(
		'section'					 => 'emulsion_section_advanced_reset',
		'priority'					 => 10,
		'default'					 => "continue",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Reset theme settings', 'emulsion' ),
		'description'				 => esc_html__( 'Initialize theme customizer settings', 'emulsion' ),
		'validate'					 => 'emulsion_reset_theme_settings_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'continue'	 => esc_html__( 'Maintain setting', 'emulsion' ),
			'reset'		 => esc_html__( 'Reset', 'emulsion' ),
		),
	),
	"emulsion_excerpt_length"					 => array(
		'section'					 => 'emulsion_section_advanced_excerpt',
		'priority'					 => 10,
		'default'					 => 256,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Excerpt length', 'emulsion' ),
		'description'				 => esc_html__( 'It is specified by the number of characters, not the number of words', 'emulsion' ),
		'validate'					 => 'emulsion_excerpt_length_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 0,
			'max'	 => 512,
			'step'	 => 1,
		),
	),
	"emulsion_excerpt_linebreak"				 => array(
		'section'					 => 'emulsion_section_advanced_excerpt',
		'priority'					 => 10,
		'default'					 => 'none',
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Excerpt Linebreak', 'emulsion' ),
		'description'				 => esc_html__( 'Remove linebreak from excerpt', 'emulsion' ),
		'validate'					 => 'emulsion_excerpt_linebreak_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'block'	 => esc_html__( 'Add linebreak', 'emulsion' ),
			'none'	 => esc_html__( 'Remove linebreak', 'emulsion' ),
		),
	),
	"emulsion_excerpt_length_grid"				 => array(
		'section'					 => 'emulsion_section_advanced_excerpt',
		'priority'					 => 10,
		'default'					 => 4,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Grid layout excerpt length', 'emulsion' ),
		'description'				 => esc_html__( 'It is specified by the number of line.', 'emulsion' ),
		'validate'					 => 'emulsion_excerpt_length_grid_validate. default:4',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 1,
			'max'	 => 8,
			'step'	 => 1,
		),
	),
	"emulsion_excerpt_length_stream"			 => array(
		'section'					 => 'emulsion_section_advanced_excerpt',
		'priority'					 => 10,
		'default'					 => 2,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'stream layout excerpt length', 'emulsion' ),
		'description'				 => esc_html__( 'It is specified by the number of line. default:2', 'emulsion' ),
		'validate'					 => 'emulsion_excerpt_length_stream_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 1,
			'max'	 => 8,
			'step'	 => 1,
		),
	),
	"emulsion_table_of_contents"				 => array(
		'section'					 => 'emulsion_section_advanced_toc',
		'priority'					 => 10,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Table of contents', 'emulsion' ),
		'description'				 => esc_html__( 'You can stop table of contents', 'emulsion' ),
		'validate'					 => 'emulsion_table_of_contents_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_tooltip"							 => array(
		'section'					 => 'emulsion_section_advanced_tooltip',
		'priority'					 => 10,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Tooltip', 'emulsion' ),
		'description'				 => esc_html__( 'You can stop display the tooltip', 'emulsion' ),
		'validate'					 => 'emulsion_tooltip_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_sticky_sidebar"					 => array(
		'section'					 => 'emulsion_section_advanced_sticky_sidebar',
		'priority'					 => 10,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Sticky Sidebar', 'emulsion' ),
		'description'				 => esc_html__( 'You can stop display the tooltip', 'emulsion' ),
		'validate'					 => 'emulsion_sticky_sidebar_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_lazyload"						 => array(
		'section'					 => 'emulsion_section_advanced_lazyload',
		'priority'					 => 10,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Lazyload', 'emulsion' ),
		'description'				 => esc_html__( 'You can stop the lazyloading', 'emulsion' ),
		'validate'					 => 'emulsion_lazyload_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_instantclick"					 => array(
		'section'					 => 'emulsion_section_advanced_instantclick',
		'priority'					 => 10,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'InstantClick', 'emulsion' ),
		'description'				 => esc_html__( 'You can stop the instantclick', 'emulsion' ),
		'validate'					 => 'emulsion_instantclick_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_search_drawer"					 => array(
		'section'					 => 'emulsion_section_advanced_search_drawer',
		'priority'					 => 10,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Search Drawer', 'emulsion' ),
		'description'				 => esc_html__( 'Header search box', 'emulsion' ),
		'validate'					 => 'emulsion_instantclick_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_relate_posts"					 => array(
		'section'					 => 'emulsion_section_advanced_relate_posts',
		'priority'					 => 10,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Relate Posts', 'emulsion' ),
		'description'				 => esc_html__( 'You can stop the relate posts', 'emulsion' ),
		'validate'					 => 'emulsion_relate_posts_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_customizer_preview_redirect"					 => array(
		'section'					 => 'emulsion_section_advanced_customizer',
		'priority'					 => 10,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Customize Preview Auto Redirect', 'emulsion' ),
		'description'				 => esc_html__( 'You can stop moving the preview page when you open the section.', 'emulsion' ),
		'validate'					 => 'emulsion_customizer_preview_redirect_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	/**
	 * Block editor
	 */
	"emulsion_alignfull"						 => array(
		'section'					 => 'emulsion_section_block_editor_alignwide',
		'priority'					 => 10,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Alignwide', 'emulsion' ),
		'description'				 => esc_html__( 'Display content in full page width.', 'emulsion' ),
		'validate'					 => 'emulsion_alignfull_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_box_gap"							 => array(
		'section'					 => 'emulsion_section_block_editor_box_gap',
		'priority'					 => 10,
		'default'					 => 3,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Box Gap', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_box_gap_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 0,
			'max'	 => 32,
			'step'	 => 1,
		),
	),
	"emulsion_block_gallery_section_height"	 => array(
		'section'					 => 'emulsion_section_block_editor_block_gallery',
		'priority'					 => 10,
		'default'					 => 0,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Block gallery height', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_block_gallery_section_height_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 0,
			'max'	 => 100,
			'step'	 => 1,
		),
	),
	"emulsion_block_gallery_section_bg"		 => array(
		'section'					 => 'emulsion_section_block_editor_block_gallery',
		'priority'					 => 10,
		'default'					 => emulsion_get_background_color(),
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Block gallery background', 'emulsion' ),
		'description'				 => '',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'validate'					 => 'emulsion_block_gallery_section_bg_validate',
		'extend_customize_control'	 => '',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
		'extend_customize_setting'	 => '',
	),
	"emulsion_block_columns_section_height"	 => array(
		'section'					 => 'emulsion_section_block_editor_block_columns',
		'priority'					 => 10,
		'default'					 => 0,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Block columns height', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_block_columns_section_height_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 0,
			'max'	 => 100,
			'step'	 => 1,
		),
	),
	"emulsion_block_columns_section_bg"		 => array(
		'section'					 => 'emulsion_section_block_editor_block_columns',
		'priority'					 => 10,
		'default'					 => emulsion_get_background_color(),
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Block columns background', 'emulsion' ),
		'description'				 => '',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'validate'					 => 'emulsion_block_columns_section_bg_validate',
		'extend_customize_control'	 => '',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
		'extend_customize_setting'	 => '',
	),
	"emulsion_block_media_text_section_height"	 => array(
		'section'					 => 'emulsion_section_block_editor_block_media_text',
		'priority'					 => 10,
		'default'					 => 0,
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Block media text height', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_block_media_text_section_height_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'absint',
		'extend_customize_control'	 => '',
		'type'						 => 'number',
		'input_attrs'				 => array(
			'min'	 => 0,
			'max'	 => 100,
			'step'	 => 1,
		),
	),
	"emulsion_block_media_text_section_bg"		 => array(
		'section'					 => 'emulsion_section_block_editor_block_media_text',
		'priority'					 => 10,
		'default'					 => emulsion_get_background_color(),
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Block media text background', 'emulsion' ),
		'description'				 => '',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'validate'					 => 'emulsion_block_media_text_section_bg_validate',
		'extend_customize_control'	 => '',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
		'extend_customize_setting'	 => '',
	),
	"emulsion_colors_for_editor"				 => array(
		'section'					 => 'emulsion_section_colors_for_editor',
		'priority'					 => 10,
		'default'					 => "enable",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Colors for block editor', 'emulsion' ),
		'description'				 => esc_html__( 'Apply customizer color settings to block editor', 'emulsion' ),
		'validate'					 => 'emulsion_colors_for_editor_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'enable'	 => esc_html__( 'Enable', 'emulsion' ),
			'disable'	 => esc_html__( 'Disable', 'emulsion' ),
		),
	),
	"emulsion_favorite_color_palette"			 => array(
		'section'					 => 'emulsion_section_colors_for_editor',
		'priority'					 => 10,
		'default'					 => "#fafafa",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Color Palette', 'emulsion' ),
		'description'				 => esc_html__( 'Add your favorite color to the editor color palette', 'emulsion' ),
		'validate'					 => 'emulsion_favorite_color_palette_validate',
		'active_callback'			 => 'emulsion_favorite_color_palette_active_callback',
		'sanitize_callback'			 => 'sanitize_hex_color',
		'extend_customize_control'	 => 'WP_Customize_Color_Control',
	),
	/**
	 * Post
	 */
	"emulsion_post_display_date"				 => array(
		'section'					 => 'emulsion_section_post',
		'priority'					 => 10,
		'default'					 => "inherit",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Publish Date', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_post_display_date_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'none'		 => esc_html__( 'hide', 'emulsion' ),
			'inherit'	 => esc_html__( 'show', 'emulsion' ),
		),
	),
	"emulsion_post_display_date_format"		 => array(
		'section'					 => 'emulsion_section_post',
		'priority'					 => 10,
		'default'					 => "default",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Publish Date Format', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_post_display_date_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'ago'		 => emulsion_post_display_method_date_example_value( 'ago' ),
			'default'	 => emulsion_post_display_method_date_example_value(),
		),
	),
	"emulsion_post_display_author"				 => array(
		'section'					 => 'emulsion_section_post',
		'priority'					 => 10,
		'default'					 => "inherit",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Author', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_post_display_author_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'none'		 => esc_html__( 'hide', 'emulsion' ),
			'inherit'	 => esc_html__( 'show', 'emulsion' ),
		),
	),
	"emulsion_post_display_author_format"		 => array(
		'section'					 => 'emulsion_section_post',
		'priority'					 => 10,
		'default'					 => "text",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'refresh',
		'unit'						 => '',
		'label'						 => esc_html__( 'Author Format', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_post_display_author_format_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'text'	 => esc_html__( 'text', 'emulsion' ),
			'inline' => esc_html__( 'inline avatar', 'emulsion' ),
			'block'	 => esc_html__( 'block avatar', 'emulsion' ),
		),
	),
	"emulsion_post_display_category"			 => array(
		'section'					 => 'emulsion_section_post',
		'priority'					 => 10,
		'default'					 => "inherit",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Category', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_post_display_category_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'none'		 => esc_html__( 'hide', 'emulsion' ),
			'inherit'	 => esc_html__( 'show', 'emulsion' ),
		),
	),
	"emulsion_post_display_tag"				 => array(
		'section'					 => 'emulsion_section_post',
		'priority'					 => 10,
		'default'					 => "inherit",
		'data_type'					 => $emulsion_setting_type,
		'capability'				 => $emulsion_customize_cap,
		'transport'					 => 'postMessage',
		'unit'						 => '',
		'label'						 => esc_html__( 'Tag', 'emulsion' ),
		'description'				 => '',
		'validate'					 => 'emulsion_post_display_tag_validate',
		'active_callback'			 => '',
		'sanitize_callback'			 => 'wp_filter_nohtml_kses',
		'extend_customize_control'	 => '',
		'type'						 => 'radio',
		'choices'					 => array(
			'none'		 => esc_html__( 'hide', 'emulsion' ),
			'inherit'	 => esc_html__( 'show', 'emulsion' ),
		),
	),
);

/**
 * Panel
 */
$emulsion_theme_customize_panels = array(
	'emulsion_theme_settings_fonts_panel'			 => array(
		'priority'		 => 41,
		'capability'	 => $emulsion_customize_cap,
		'theme_supports' => '',
		'title'			 => __( 'Fonts', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_theme_settings_link_panel'			 => array(
		'priority'		 => 41,
		'capability'	 => $emulsion_customize_cap,
		'theme_supports' => '',
		'title'			 => __( 'Link', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_theme_settings_layout_panel'			 => array(
		'priority'		 => 42,
		'capability'	 => $emulsion_customize_cap,
		'theme_supports' => '',
		'title'			 => __( 'Layout', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_theme_settings_advanced_panel'		 => array(
		'priority'		 => 250,
		'capability'	 => $emulsion_customize_cap,
		'theme_supports' => '',
		'title'			 => __( 'Theme Advanced Settings', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_theme_settings_block_editor_panel'	 => array(
		'priority'		 => 62,
		'capability'	 => $emulsion_customize_cap,
		'theme_supports' => '',
		'title'			 => __( 'Block editor', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_theme_settings_post_panel'			 => array(
		'priority'		 => 59,
		'capability'	 => $emulsion_customize_cap,
		'theme_supports' => '',
		'title'			 => __( 'Post', 'emulsion' ),
		'description'	 => '',
	),

);

/**
 * Section
 */

$emulsion_theme_customize_sections = array(
	'emulsion_section_fonts_general'					 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_fonts_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'General', 'emulsion' ),
		'description'	 => '',
	),
	'blocktyp_section_link_style'						 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_link_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Link Style', 'emulsion' ),
		'description'	 => esc_html__( 'Set link CSS', 'emulsion' ),
	),
	'emulsion_section_fonts_heading'					 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_fonts_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Heading', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_fonts_widget_meta'				 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_fonts_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Widget, Meta data,', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_layout_header'					 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Header', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_layout_sidebar'					 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Sidebar', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_layout_main'						 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Main content area', 'emulsion' ),
		'description'	 => '', 
	),
	'emulsion_section_layout_footer'					 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Footer', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_layout_homepage'					 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Homepage', 'emulsion' ),
		'description'	 => '', 
	),
	'emulsion_section_layout_posts_page'				 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Posts page', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_layout_date_archives'			 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Archives: Date', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_layout_category_archives'		 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Archives: Category', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_layout_tag_archives'				 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Archives: Tag', 'emulsion' ),
		'description'	 => '', 
	),
	'emulsion_section_layout_author_archives'			 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Archives: Author', 'emulsion' ),
		'description'	 => '', 
	),
	'emulsion_section_layout_search_results'			 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_layout_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Search Results', 'emulsion' ),
		'description'	 => '',
	),

	/**
	 * Advanced
	 */
	'emulsion_section_advanced_reset'					 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_advanced_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Reset theme settings', 'emulsion' ),
		'description'	 => esc_html__( 'This change can not be undone. This process is performed when the blog is displayed', 'emulsion' ),
	),
	'emulsion_section_advanced_excerpt'				 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_advanced_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Excerpt', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_advanced_toc'					 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_advanced_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Table of contents', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_advanced_tooltip'				 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_advanced_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Tooltip', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_advanced_sticky_sidebar'			 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_advanced_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Sticky sidebar', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_advanced_lazyload'				 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_advanced_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Lazyload', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_advanced_instantclick'			 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_advanced_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'InstantClick', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_advanced_search_drawer'			 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_advanced_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Search Drawer', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_advanced_relate_posts'			 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_advanced_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Relate Posts', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_advanced_customizer'			 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_advanced_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Customizer', 'emulsion' ),
		'description'	 => '',
	),
	/**
	 * Post
	 */
	'emulsion_section_post'				 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_post_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Post Metadata', 'emulsion' ),
		'description'	 => '',
	),
	/**
	 * emulsion
	 */
	'emulsion_section_block_editor_alignwide'			 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_post_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Alignwide', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_block_editor_box_gap'			 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_post_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Box gap', 'emulsion' ),
		'description'	 => esc_html__( 'Adjust the spacing of blocks in which the border is displayed', 'emulsion' ),
	),
	'emulsion_section_block_editor_block_gallery'		 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_post_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Block gallery', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_block_editor_block_columns'		 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_post_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Block columns', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_block_editor_block_media_text'	 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_post_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Block media text', 'emulsion' ),
		'description'	 => '',
	),
	'emulsion_section_colors_for_editor'				 => array(
		'priority'		 => 25,
		'panel'			 => 'emulsion_theme_settings_post_panel',
		'theme_supports' => '',
		'title'			 => esc_html__( 'Editor Color', 'emulsion' ),
		'description'	 => esc_html__( 'Your favorite color to the post color palette.', 'emulsion' ),
	),
);

/**
 * Active Callback
 * @param type $control
 * @return boolean
 */
function emulsion_header_html_active_callback( $control ) {

	if ( $control->manager->get_setting( 'emulsion_header_layout' )->value() == 'self' ) {
		return true;
	} else {
		return false;
	}
	return false;
}

function emulsion_title_in_header_active_callback( $control ) {
	// @see customize.php: customizer value conditional change

	if ( $control->manager->get_setting( 'emulsion_header_layout' )->value() == 'custom' ) {
		return true;
	} else {
		return false;
	}
	return false;
}

function emulsion_header_sub_background_color_active_callback( $control ) {

	if ( $control->manager->get_setting( 'emulsion_header_gradient' )->value() == 'enable' ) {
		return true;
	} else {
		return false;
	}
	return false;
}
function emulsion_favorite_color_palette_active_callback( $control ) {

	if ( $control->manager->get_setting( 'emulsion_colors_for_editor' )->value() == 'enable' ) {
		return true;
	} else {
		return false;
	}
	return false;
}
/**
 * Validate callback
 *
 */
function emulsion_main_width_limit_value( $validity, $value ) {
	$value = absint( $value );

	$limit_value = get_theme_mod( 'emulsion_content_width', emulsion_get_var( 'emulsion_content_width' ) );

	if ( $value < $limit_value ) {

		$validity->add( 'hello', $value . $limit_value . esc_html__( 'The Main width must be the same as or greater than the Content width', 'emulsion' ) );
	}
	return $validity;
}

function emulsion_content_width_limit_value( $validity, $value ) {
	$value = absint( $value );

	$limit_value = get_theme_mod( 'emulsion_main_width', emulsion_get_var( 'emulsion_main_width' ) );

	if ( $value > $limit_value ) {

		$validity->add( 'required', esc_html__( 'Content width must be less than or equal to Main width.', 'emulsion' ) );
	}
	return $validity;
}

function emulsion_post_display_method_date_example_value( $type = 'defaul' ){

	$example_date = time() - 259200;
	
	$date_format	 = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
	
	if( $type == 'ago'){
		/* translators: %s  human_time_diff() */
		return sprintf( esc_html__( '%s ago', 'emulsion' ), human_time_diff( $example_date, current_time( 'timestamp' ) ) );
	}
	
	return date( $date_format, $example_date );
	
}


//latest-post, gallery, columns, media-text, alignwide, comments-open tag-slug
function emulsion_get_customize_post_id( $type = '' ) {

	$posts_args	 = array(
		'posts_per_page' => -1,
		'date_query'	 => array(
			array(
				'after' => '2018/12/1'
			),
		),
	);
	$all_posts	 = get_posts( $posts_args );
	
	$result = 0;
	
	if ( 'latest-post' == $type ) {
		$latest_post_id = absint( $all_posts[0]->ID );
		
		return $latest_post_id;
	}
	
	if ( 'comments-open' == $type ) {
		
		foreach ( $all_posts as $post ) {
			$emulsion_post_id = absint( $post->ID );		
			if( comments_open( $emulsion_post_id ) ) {		
				$result = absint( $emulsion_post_id );
				break;
			}
		}
		wp_reset_postdata();
		return $result;
			
	}
	if ( 'gallery' == $type ) {
		
		foreach ( $all_posts as $post ) {
			//esclude alignleft alignright
			if ( preg_match( '#wp:gallery {(.+)?[^(left|right)]+}#', $post->post_content ) ) {

				$result = absint( $post->ID );
				break;
			}
		}
		wp_reset_postdata();
		return $result;	
	}
	if ( 'columns' == $type ) {
		
		foreach ( $all_posts as $post ) {
			if ( strstr( $post->post_content, 'wp:columns' ) ) {
				$result = absint( $post->ID );
				break;
			}
		}
		wp_reset_postdata();
		return $result;
	}
	if ( 'media-text' == $type ) {
		
		foreach ( $all_posts as $post ) {
			if ( strstr( $post->post_content, 'wp:media-text' ) ) {
				$result = absint( $post->ID );
				break;
			}
		}
		
		wp_reset_postdata();
		return $result;
	}
	if ( 'alignwide' == $type ) {
		
		foreach ( $all_posts as $post ) {
			if ( preg_match( '#{(.+)?("align":"full"|"align":"wide")(.+)?}#', $post->post_content )  ) {
				$result = absint( $post->ID );
				break;
			}
		}
		wp_reset_postdata();
		return $result;
	}
	if ( 'tag-slug' == $type ) {
			// not post id. return most used tag slug
			$args				 = array( 'order' => 'desc', 'orderby' => 'count', 'number' => 1, 'hide_empty' => true );
			$tags				 = get_tags( $args );
			if( isset($tags[0]) && ! empty( $tags[0]->slug ) ) {
				$most_used_tag_slug	 = sanitize_title( $tags[0]->slug );
				return $most_used_tag_slug;
			} else {
				return 0;
			}		
	}
}

function emulsion_control_description( $control ) {
	
	$customizer_url = 'javascript:var url = wp.customize.settings.url.home + \'?%1$s\'; wp.customize.previewer.previewUrl.set( url );';
	$preview_text = esc_html__('Move preview to ', 'emulsion');
	switch ( $control ) {
		case 'emulsion_relate_posts_bg':

			$link_id	 = emulsion_get_customize_post_id( 'latest-post' );
			$url		 = sprintf( $customizer_url, 'p=' . $link_id );
			$link_text	 = esc_html__( 'latest post', 'emulsion' );
			
			$status = get_theme_mod('emulsion_relate_posts', emulsion_get_var( 'emulsion_relate_posts' ) );
			
			if( 'enable' == $status ) {
				
				return sprintf( '%1$s<a href="%2$s">%3$s</a>', $preview_text, $url, $link_text );
			} 
			if( 'disable' == $status ) {
				
				$preview_text	 = esc_html__( 'Move preview to ', 'emulsion' );
				$preview_text	 = esc_html__( 'This feature is set to disabled.', 'emulsion' );
				$link_text		 = esc_html__( 'change setting', 'emulsion' );
				$url			 = 'javascript:wp.customize.control( \'emulsion_relate_posts\' ).focus();';
				
				return sprintf( '%1$s<a href="%2$s">%3$s</a>', $preview_text, $url, $link_text );
			} 
			
			break;
		case 'emulsion_comments_bg':
			$preview_text			 = esc_html__('Change preview ', 'emulsion');
			$link_id				 = emulsion_get_customize_post_id( 'latest_post' );
			$url					 = sprintf( $customizer_url, 'p=' . $link_id );
			$link_text				 = esc_html__( 'latest post', 'emulsion' );
			$allow_comments_post	 = emulsion_get_customize_post_id( 'comments-open' );
			$allow_comments_post_url = sprintf( $customizer_url, 'p=' . $allow_comments_post );
		
			$emulsion_post_id = absint( $link_id );
		
			if( 0 < $emulsion_post_id && comments_open( $link_id ) ) {

				return sprintf( '%1$s<a href="%2$s">%3$s</a>', $preview_text, $url, $link_text );
			} elseif( 0 !== $allow_comments_post ) {
				
				$link_text = esc_html__( 'comments allowed post', 'emulsion' );
				return sprintf( '%1$s<a href="%2$s">%3$s</a>', $preview_text, $allow_comments_post_url, $link_text );
			} else {
				
				$link_text = esc_html__( 'Can not find comments allowed Post', 'emulsion' );
				return sprintf( '%1$s %2$s', '', $link_text );
			}

			break;

	}
}
