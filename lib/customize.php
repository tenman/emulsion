<?php

/**
 * Theme Customizer
 */
add_action( 'customize_register', 'emulsion_customize_register' );

if ( ! function_exists( 'emulsioncustomize_register' ) ) {

	function emulsion_customize_register( $wp_customize ) {



		$emulsion_theme_mod_args = array(
			'emulsion_scheme'			 => array(
				'section'			 => 'emulsion_scheme',
				'default'			 => 'default',
				'label'				 => esc_html__( 'Radio Icon Control', 'emulsion' ),
				'description'		 => ! emulsion_theme_addons_exists() ? esc_html__( 'Plugins activate more detailed settings such as fonts and sidebar colors.', 'emulsion' ) : '',
				'sanitize_callback'	 => 'emulsion_scheme_validate',
				'type'				 => 'emulsionImageRadio',
			),
			'emulsion_editor_support'	 => array(
				'section'			 => 'emulsion_editor',
				'default'			 => 'theme',
				'label'				 => esc_html__( 'Editor', 'emulsion' ),
				'description'		 => esc_html__( 'Choose between using the new template system or the old template (requred Gutenberg plugin)', 'emulsion' ),
				'sanitize_callback'	 => 'emulsion_editor_support_validate',
				'type'				 => 'radio',
				'choices'			 => array(
					'experimental'	 => esc_html__( 'Experimental Mode (Emulsion-addons plugin required)', 'emulsion' ),
					'fse'			 => esc_html__( 'Full Site Editor (HTML Template)', 'emulsion' ),
					'transitional'	 => esc_html__( 'FSE Transitional', 'emulsion' ),
					'theme'			 => esc_html__( 'Theme Default (PHP Template)', 'emulsion' ),
				),
			),
			'emulsion_header_template'	 => array(
				'section'			 => 'emulsion_editor',
				'default'			 => 'default',
				'label'				 => esc_html__( 'Header Template', 'emulsion' ),
				'description'		 => esc_html__( 'Select header template. If you select html, it will be displayed in the new html template in all editor settings.', 'emulsion' ),
				'sanitize_callback'	 => 'emulsion_header_template_validate',
				'type'				 => 'radio',
				'choices'			 => array(
					'html'		 => esc_html__( 'HTML Template', 'emulsion' ),
					'default'	 => esc_html__( 'Depends on editor settings', 'emulsion' ),
				),
			),
			'emulsion_footer_template'	 => array(
				'section'			 => 'emulsion_editor',
				'default'			 => 'default',
				'label'				 => esc_html__( 'Footer Template', 'emulsion' ),
				'description'		 => esc_html__( 'Select footer template. If you select html, it will be displayed in the new html template in all editor settings.', 'emulsion' ),
				'sanitize_callback'	 => 'emulsion_footer_template_validate',
				'type'				 => 'radio',
				'choices'			 => array(
					'html'		 => esc_html__( 'HTML Template', 'emulsion' ),
					'default'	 => esc_html__( 'Depends on editor settings', 'emulsion' ),
				),
			),
		);

		if ( ! emulsion_the_theme_supports( 'scheme' ) ) {

			unset( $emulsion_theme_mod_args['emulsion_scheme'] );
		} else {

			$wp_customize->add_section( 'emulsion_scheme', array(
				'title'			 => esc_html__( 'SCHEME', 'emulsion' ),
				'description'	 => $emulsion_theme_mod_args['emulsion_scheme']['description'],
				'priority'		 => 33
			) );

			$wp_customize->add_setting( 'emulsion_scheme', array(
				'default'			 => $emulsion_theme_mod_args['emulsion_scheme']['default'],
				'sanitize_callback'	 => $emulsion_theme_mod_args['emulsion_scheme']['sanitize_callback'],
			) );

			$wp_customize->add_control( new emulsion_Customize_Image_Radio_Control( $wp_customize, 'emulsion_scheme', array(
						'settings'	 => 'emulsion_scheme',
						'section'	 => $emulsion_theme_mod_args['emulsion_scheme']['section'],
						'label'		 => $emulsion_theme_mod_args['emulsion_scheme']['label'],
							)
			) );
		}

		if ( ! is_child_theme() ) {

			$wp_customize->add_section( 'emulsion_editor', array(
				'title'			 => esc_html__( 'Full Site Editor', 'emulsion' ),
				'description'	 => $emulsion_theme_mod_args['emulsion_scheme']['description'],
				'priority'		 => 33
			) );
			$wp_customize->add_setting( 'emulsion_editor_support', array(
				'default'			 => $emulsion_theme_mod_args['emulsion_editor_support']['default'],
				'sanitize_callback'	 => $emulsion_theme_mod_args['emulsion_editor_support']['sanitize_callback'],
			) );

			$wp_customize->add_control( 'emulsion_editor_support', array(
				'settings'		 => 'emulsion_editor_support',
				'section'		 => $emulsion_theme_mod_args['emulsion_editor_support']['section'],
				'label'			 => $emulsion_theme_mod_args['emulsion_editor_support']['label'],
				'description'	 => $emulsion_theme_mod_args['emulsion_editor_support']['description'],
				'type'			 => $emulsion_theme_mod_args['emulsion_editor_support']['type'],
				'choices'		 => $emulsion_theme_mod_args['emulsion_editor_support']['choices'],
			) );

			$wp_customize->add_setting( 'emulsion_header_template', array(
				'default'			 => $emulsion_theme_mod_args['emulsion_header_template']['default'],
				'sanitize_callback'	 => $emulsion_theme_mod_args['emulsion_header_template']['sanitize_callback'],
			) );

			$wp_customize->add_control( 'emulsion_header_template', array(
				'settings'		 => 'emulsion_header_template',
				'section'		 => $emulsion_theme_mod_args['emulsion_header_template']['section'],
				'label'			 => $emulsion_theme_mod_args['emulsion_header_template']['label'],
				'description'	 => $emulsion_theme_mod_args['emulsion_header_template']['description'],
				'type'			 => $emulsion_theme_mod_args['emulsion_header_template']['type'],
				'choices'		 => $emulsion_theme_mod_args['emulsion_header_template']['choices'],
			) );

			$wp_customize->add_setting( 'emulsion_footer_template', array(
				'default'			 => $emulsion_theme_mod_args['emulsion_footer_template']['default'],
				'sanitize_callback'	 => $emulsion_theme_mod_args['emulsion_footer_template']['sanitize_callback'],
			) );

			$wp_customize->add_control( 'emulsion_footer_template', array(
				'settings'		 => 'emulsion_footer_template',
				'section'		 => $emulsion_theme_mod_args['emulsion_footer_template']['section'],
				'label'			 => $emulsion_theme_mod_args['emulsion_footer_template']['label'],
				'description'	 => $emulsion_theme_mod_args['emulsion_footer_template']['description'],
				'type'			 => $emulsion_theme_mod_args['emulsion_footer_template']['type'],
				'choices'		 => $emulsion_theme_mod_args['emulsion_footer_template']['choices'],
			) );
		}
	}

}

/**
 * Custom Control
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

	class emulsion_Customize_Image_Radio_Control extends WP_Customize_Control {

		public $type = 'emulsionImageRadio';

		public function render_content() {

			$image_dir		 = get_template_directory_uri() . '/images/';
			$defalt_image	 = get_template_directory_uri() . '/';

			$all_keys = array_keys( emulsion_theme_scheme );

			$choices = array();

			$choices['default'] = sprintf( '%1$s%2$s', $image_dir, 'default.png' );

			foreach ( $all_keys as $key => $val ) {

				$choices[$val] = sprintf( '%1$s%2$s', $image_dir, $val . '.png' );
			}

			$form_input	 = '<input class="image-select" type="radio" value="%1$s" id="%2$s" name="%3$s" %4$s';
			$form_label	 = '><label for="%1$s"><img src="%2$s" alt="%3$s" title="%4$s" width="300"></label>';
			$form_label	 .= '<details id="details-%7$s"><summary>%5$s</summary><p>%6$s</p></details>';
			$result		 = '';

			foreach ( $choices as $value => $label_image ) {

				switch ( $value ) {
					case 'default':
						$summary	 = esc_html__( 'default', 'emulsion' );
						$description = esc_html__( 'The default is to set the default value to the default setting of the theme.', 'emulsion' );
						break;
					case 'full-size-header':
						$summary	 = esc_html__( 'full size header', 'emulsion' );
						$description = esc_html__( 'The home page and featured image are displayed in browser size.', 'emulsion' );
						$description .= '<p>' . esc_html__( 'You can add a button link on the header image by adding the Header Menu in the menu options.', 'emulsion' ) . '</p>';
						break;
					case 'midnight':
						$summary	 = esc_html__( 'midnight', 'emulsion' );
						$description = esc_html__( 'Change to an indigo dark design.', 'emulsion' );
						break;
					case 'daybreak':
						$summary	 = esc_html__( 'daybreak', 'emulsion' );
						$description = esc_html__( 'Change to a light and bright design.', 'emulsion' );
						break;
					case 'bloging':
						$summary	 = esc_html__( 'bloging', 'emulsion' );
						$description = esc_html__( 'Change to a white clean blog design', 'emulsion' );
						break;
					case 'grid':
						$summary	 = esc_html__( 'grid', 'emulsion' );
						$description = esc_html__( 'Display all archive pages in a grid layout.', 'emulsion' );
						break;
					case 'stream':
						$summary	 = esc_html__( 'stream', 'emulsion' );
						$description = esc_html__( 'The Stream layout is a theme-specific layout that appears lower than the grid.', 'emulsion' );
						break;
					case 'boilerplate':
						$summary	 = esc_html__( 'boilerplate', 'emulsion' );
						$description = esc_html__( 'Disable all stylesheets and javascript in the theme. The core style of the block editor is maintained.', 'emulsion' );
						$description .= '<p>' . esc_html__( 'The plugin allows you to set each post or page.', 'emulsion' ) . '</p>';
						$description .= '<p>' . esc_html__( 'This setting does not support customizer preview. Please open the blog and check.', 'emulsion' ) . '</p>';
						break;
					default:
						$summary	 = '';
						$description = '';
						break;
				}

				$checked = checked( $this->value(), $value, false );

				printf( $form_input, esc_attr( $value ), $this->id . $value, esc_attr( $this->id ), $checked );
				$this->link();
				printf( $form_label, $this->id . $value, esc_html( $label_image ), esc_attr( $value ), esc_attr( $value ), $summary, $description, $value );
			}
		}

	}

}

/**
 * Customizer Styles
 */
add_action( 'customize_controls_enqueue_scripts', 'emulsion_theme_customizer_style' );

if ( ! function_exists( 'emulsion_theme_customizer_style' ) ) {

	function emulsion_theme_customizer_style() {

		$css = <<< CSS
.customize-control-emulsionImageRadio input {
	visibility:hidden;
}
.customize-control-emulsionImageRadio input:checked + label{
	display:block;
    background-color: #ccc;
	border:3px solid;

}
.customize-control-emulsionImageRadio input + label {
    display: inline-block;
    cursor: pointer;
	padding:5px 5px 3px;

}
[id|="details"]{
	background:#fff;
	padding:5px 5px 3px;
	box-sizing:border-box;
	width:248px;
	margin:auto;
}
.customize-panel-back, .customize-section-back {
	display:inline-block;

}
#customize-controls .customize-pane-child .customize-section-title h3,
#customize-controls .customize-pane-child h3.customize-section-title,
#customize-outer-theme-controls .customize-pane-child .customize-section-title h3,
#customize-outer-theme-controls .customize-pane-child h3.customize-section-title,
#customize-controls .customize-info .panel-title {
	display: inline-block;
	max-width: calc(100% - 50px);
				vertical-align:middle;
}
CSS;

if( 'fse' == get_theme_mod('emulsion_editor_support') )	{
	
		$css .=<<<CSS2
		#customize-control-emulsion_scheme #details-stream,
		#customize-control-emulsion_scheme [for="emulsion_schemestream"],
		#customize-control-emulsion_scheme #details-grid,
		#customize-control-emulsion_scheme [for="emulsion_schemegrid"],
		#customize-control-emulsion_scheme #details-bloging,
		#customize-control-emulsion_scheme [for="emulsion_schemebloging"],
		#customize-control-emulsion_scheme #details-daybreak,
		#customize-control-emulsion_scheme [for="emulsion_schemedaybreak"],
		#customize-control-emulsion_scheme #details-midnight,
		#customize-control-emulsion_scheme [for="emulsion_schememidnight"]{
			display:none;

		}

CSS2;
}

		wp_add_inline_style( 'customize-controls', $css );
	}

}

add_action( 'customize_controls_enqueue_scripts', 'emulsion_theme_customizer_script' );

if ( ! function_exists( 'emulsion_theme_customizer_script' ) ) {

	function emulsion_theme_customizer_script() {

		$script = <<< SCRIPT
(function($){

	wp.customize( 'emulsion_scheme', function( setting ) {

        setting.bind( function( value ) {
				$('[id|="details"]').removeAttr('open');
				$('#details-' + value ).attr('open','open');
        } );
    } );

})(jQuery);

SCRIPT;
		if ( is_customize_preview() ) {

			wp_add_inline_script( 'customize-controls', $script );
		}
	}

}

/**
 * Customizer validate
 */
function emulsion_scheme_validate( $input ) {

	if ( array_key_exists( $input, emulsion_theme_scheme ) ) {

		return $input;
	}

	return 'default';
}

function emulsion_editor_support_validate( $input ) {

	$values			 = array( 'fse', 'transitional', 'theme', 'experimental' );
	$default_value	 = 'theme';

	if ( in_array( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_color_control_validate( $input ) {

	$values			 = array( 'fse', 'theme' );
	$default_value	 = 'theme';

	if ( in_array( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_header_template_validate( $input ) {

	$values			 = array( 'html', 'default' );
	$default_value	 = 'default';

	if ( in_array( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_footer_template_validate( $input ) {

	$values			 = array( 'html', 'default' );
	$default_value	 = 'default';

	if ( in_array( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}
