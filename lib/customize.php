<?php

/**
 * Theme Customizer
 */

add_action( 'customize_register', 'emulsion_customize_register' );

if ( ! function_exists( 'emulsioncustomize_register' ) ) {

	function emulsion_customize_register( $wp_customize ) {

		if( ! emulsion_the_theme_supports('scheme') ) {
			return;
		}

		$emulsion_theme_mod_args = array(
			'emulsion_scheme' => array(
				'section'			 => 'emulsion_scheme',
				'default'			 => 'default',
				'label'				 => esc_html__( 'Radio Icon Control', 'emulsion' ),
				'description'		 => ! emulsion_theme_addons_exists() ? esc_html__( 'Plugins activate more detailed settings such as fonts and sidebar colors.', 'emulsion' ): '',
				'sanitize_callback'	 => 'emulsion_scheme_validate',
				'type'				 => 'emulsionImageRadio',
			)
		);

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
			$form_label .= '<details id="details-%7$s"><summary>%5$s</summary><p>%6$s</p></details>';
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
						$description .= '<p>'. esc_html__( 'You can add a button link on the header image by adding the Header Menu in the menu options.', 'emulsion' ). '</p>';
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
						$description .= '<p>'. esc_html__( 'The plugin allows you to set each post or page.', 'emulsion' ).'</p>';
						$description .= '<p>'. esc_html__( 'This setting does not support customizer preview. Please open the blog and check.', 'emulsion' ).'</p>';
						break;
					default:
						$summary	 = '';
						$description = '';
						break;
				}

				$checked = checked( $this->value(), $value, false );

				printf( $form_input, esc_attr( $value ), $this->id . $value, esc_attr( $this->id ), $checked );
				$this->link();
				printf( $form_label, $this->id . $value, esc_html( $label_image ), esc_attr( $value ), esc_attr( $value ), $summary, $description, $value);
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

CSS;

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