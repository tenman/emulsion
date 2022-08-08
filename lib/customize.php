<?php
/**
 * Theme Customizer
 */

add_action( 'customize_register', 'emulsion_customize_register' );

if ( ! function_exists( 'emulsioncustomize_register' ) ) {

	function emulsion_customize_register( $wp_customize ) {

		$emulsion_theme_mod_args = array(
			'emulsion_editor_support'							 => array(
				'section'			 => 'emulsion_editor',
				'default'			 => 'transitional',
				'label'				 => esc_html__( 'Theme Operation Mode Setting', 'emulsion' ),
				'description'		 => esc_html__( 'This theme can be run as either the currently widely used theme ( php template ) or the latest Full site editiong theme ( html template ) by changing the settings.', 'emulsion' ) .
				sprintf( '<p><a href="%1$s" target="blank" style="text-decoration:underline">%2$s</a></p>', 'https://www.tenman.info/wp3/emulsion/en/2021/10/28/emulsion-theme-editor-type/', esc_html__( 'More Details', 'emulsion' ) ),
				'sanitize_callback'	 => 'emulsion_editor_support_validate',
				'type'				 => 'radio',
				'choices'			 => array(
					'fse'			 => esc_html__( 'Full Site Editing Theme', 'emulsion' ),
					'transitional'	 => esc_html__( 'FSE Transitional Theme', 'emulsion' ),
					'theme'			 => esc_html__( 'Classic Theme', 'emulsion' ),
				),
			),
			'emulsion_scheme'									 => array(
				'section'			 => 'emulsion_scheme',
				'default'			 => 'default',
				'label'				 => esc_html__( 'Radio Icon Control', 'emulsion' ),
				'description'		 => esc_html__( 'Plugins activate more detailed settings such as fonts and sidebar colors.', 'emulsion' ),
				'sanitize_callback'	 => 'emulsion_scheme_validate',
				'type'				 => 'emulsionImageRadio',
			),
			'emulsion_header_template'							 => array(
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
			'emulsion_footer_template'							 => array(
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
			'emulsion_should_load_separate_core_block_assets'	 => array(
				'section'			 => 'emulsion_editor',
				'default'			 => 'disable',
				'label'				 => esc_html__( 'Sparate Core Block CSS Load', 'emulsion' ),
				'description'		 => esc_html__( 'Check for the presence of the block and load the required style.', 'emulsion' ),
				'sanitize_callback'	 => 'emulsion_should_load_separate_core_block_assets_validate',
				'type'				 => 'radio',
				'choices'			 => array(
					'disable'	 => esc_html__( 'Disabled', 'emulsion' ),
					'enable'	 => esc_html__( 'Enabled', 'emulsion' ),
				),
			),
			'emulsion_gutenberg_render_layout_support_flag'		 => array(
				'section'			 => 'emulsion_editor',
				'default'			 => 'disable',
				'label'				 => esc_html__( 'Renders the layout config to the block wrapper', 'emulsion' ),
				'description'		 => esc_html__( 'The hard-coded inline styles affect the display of the theme. use Class wp-container-XXXXXXXXXXXX', 'emulsion' ),
				'sanitize_callback'	 => 'emulsion_gutenberg_render_layout_support_flag_validate',
				'type'				 => 'radio',
				'choices'			 => array(
					'disable'	 => esc_html__( 'Use Theme Features', 'emulsion' ),
					'enable'	 => esc_html__( 'Use Gutenberg features', 'emulsion' ),
				),
			),
			'emulsion_render_elements_support'					 => array(
				'section'			 => 'emulsion_editor',
				'default'			 => 'disable',
				'label'				 => esc_html__( 'Elements styles block support.', 'emulsion' ),
				'description'		 => esc_html__( 'link style gutenberg use Class wp-elements-XXXXXXXXXXXX, theme use Class has-[preset color name]-link-color', 'emulsion' ),
				'sanitize_callback'	 => 'emulsion_render_elements_support_validate',
				'type'				 => 'radio',
				'choices'			 => array(
					'disable'	 => esc_html__( 'Use Theme Features', 'emulsion' ),
					'enable'	 => esc_html__( 'Use Gutenberg features', 'emulsion' ),
				),
			),
			'emulsion_custom_css_support'						 => array(
				'section'			 => 'emulsion_editor',
				'default'			 => 'disable',
				'label'				 => esc_html__( 'Site Editor with Custom CSS.', 'emulsion' ),
				'description'		 => esc_html__( 'If enabled, include one of the body classes (is-presentation-fse, is-presentation-transitional, is-presentation-theme) in the CSS ruleset.', 'emulsion' ),
				'sanitize_callback'	 => 'emulsion_custom_css_support_validate',
				'type'				 => 'radio',
				'choices'			 => array(
					'disable'	 => esc_html__( 'Disabled', 'emulsion' ),
					'enable'	 => esc_html__( 'Enabled', 'emulsion' ),
				),
			),
		);

		if ( 'fse' == get_theme_mod( 'emulsion_editor_support' ) ) {

			unset( $emulsion_theme_mod_args['emulsion_scheme'] );
		} else {

			$wp_customize->add_section( 'emulsion_scheme', array(
				'title'			 => esc_html__( 'One Click Configs', 'emulsion' ),
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

		$wp_customize->add_section( 'emulsion_editor', array(
			'title'			 => esc_html__( 'Theme Scheme', 'emulsion' ),
			'description'	 => $emulsion_theme_mod_args['emulsion_scheme']['description'],
			'priority'		 => 20
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
		//////////////////////
		$wp_customize->add_setting( 'emulsion_should_load_separate_core_block_assets', array(
			'default'			 => $emulsion_theme_mod_args['emulsion_should_load_separate_core_block_assets']['default'],
			'sanitize_callback'	 => $emulsion_theme_mod_args['emulsion_should_load_separate_core_block_assets']['sanitize_callback'],
		) );

		$wp_customize->add_control( 'emulsion_should_load_separate_core_block_assets', array(
			'settings'		 => 'emulsion_should_load_separate_core_block_assets',
			'section'		 => $emulsion_theme_mod_args['emulsion_should_load_separate_core_block_assets']['section'],
			'label'			 => $emulsion_theme_mod_args['emulsion_should_load_separate_core_block_assets']['label'],
			'description'	 => $emulsion_theme_mod_args['emulsion_should_load_separate_core_block_assets']['description'],
			'type'			 => $emulsion_theme_mod_args['emulsion_should_load_separate_core_block_assets']['type'],
			'choices'		 => $emulsion_theme_mod_args['emulsion_should_load_separate_core_block_assets']['choices'],
		) );

		$wp_customize->add_setting( 'emulsion_gutenberg_render_layout_support_flag', array(
			'default'			 => $emulsion_theme_mod_args['emulsion_gutenberg_render_layout_support_flag']['default'],
			'sanitize_callback'	 => $emulsion_theme_mod_args['emulsion_gutenberg_render_layout_support_flag']['sanitize_callback'],
		) );

		$wp_customize->add_control( 'emulsion_gutenberg_render_layout_support_flag', array(
			'settings'		 => 'emulsion_gutenberg_render_layout_support_flag',
			'section'		 => $emulsion_theme_mod_args['emulsion_gutenberg_render_layout_support_flag']['section'],
			'label'			 => $emulsion_theme_mod_args['emulsion_gutenberg_render_layout_support_flag']['label'],
			'description'	 => $emulsion_theme_mod_args['emulsion_gutenberg_render_layout_support_flag']['description'],
			'type'			 => $emulsion_theme_mod_args['emulsion_gutenberg_render_layout_support_flag']['type'],
			'choices'		 => $emulsion_theme_mod_args['emulsion_gutenberg_render_layout_support_flag']['choices'],
		) );

		$wp_customize->add_setting( 'emulsion_render_elements_support', array(
			'default'			 => $emulsion_theme_mod_args['emulsion_render_elements_support']['default'],
			'sanitize_callback'	 => $emulsion_theme_mod_args['emulsion_render_elements_support']['sanitize_callback'],
		) );

		$wp_customize->add_control( 'emulsion_render_elements_support', array(
			'settings'		 => 'emulsion_render_elements_support',
			'section'		 => $emulsion_theme_mod_args['emulsion_render_elements_support']['section'],
			'label'			 => $emulsion_theme_mod_args['emulsion_render_elements_support']['label'],
			'description'	 => $emulsion_theme_mod_args['emulsion_render_elements_support']['description'],
			'type'			 => $emulsion_theme_mod_args['emulsion_render_elements_support']['type'],
			'choices'		 => $emulsion_theme_mod_args['emulsion_render_elements_support']['choices'],
		) );
		//////////////////////////////
		$wp_customize->add_setting( 'emulsion_custom_css_support', array(
			'default'			 => $emulsion_theme_mod_args['emulsion_custom_css_support']['default'],
			'sanitize_callback'	 => $emulsion_theme_mod_args['emulsion_custom_css_support']['sanitize_callback'],
		) );

		$wp_customize->add_control( 'emulsion_custom_css_support', array(
			'settings'		 => 'emulsion_custom_css_support',
			'section'		 => $emulsion_theme_mod_args['emulsion_custom_css_support']['section'],
			'label'			 => $emulsion_theme_mod_args['emulsion_custom_css_support']['label'],
			'description'	 => $emulsion_theme_mod_args['emulsion_custom_css_support']['description'],
			'type'			 => $emulsion_theme_mod_args['emulsion_custom_css_support']['type'],
			'choices'		 => $emulsion_theme_mod_args['emulsion_custom_css_support']['choices'],
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
						'fse' !== get_theme_mod( 'emulsion_editor_support' ) ? $description = esc_html__( 'Disable all stylesheets in the theme. The core style of the block editor is maintained.', 'emulsion' ) : '';
						'fse' == get_theme_mod( 'emulsion_editor_support' ) ? $description = esc_html__( 'Only the Gutenberg block style and the core block style are valid, and most styles in the theme are disabled. Style by theme.json works', 'emulsion' ) : '';

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
.customize-control-notifications-container > ul,
#customize-notifications-area > ul{
	padding:.5rem;
}
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
	width:100%;
	margin:auto;
	font-size:16px;
}
[id|="details"] p{
	font-size:16px;
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

#customize-controls .customize-pane-child .customize-section-title h3,
#customize-controls .customize-pane-child h3.customize-section-title,
#customize-outer-theme-controls .customize-pane-child .customize-section-title h3,
#customize-outer-theme-controls .customize-pane-child h3.customize-section-title, #customize-controls .customize-info .panel-title{
	display:block;
}
#customize-control-emulsion_should_load_separate_core_block_assets:before{
    content: 'Gutenberg Settings';
    display: block;
    padding: 0.75rem;
    background: #fff;
    color: #333;
    font-weight: 700;
    border-left: 4px solid #0073aa;
    border-bottom: 1px solid #ddd;
    margin-top: 15px;
}
.customize-pane-parent li{
	padding:0;
}
CSS;

		if ( 'fse' == get_theme_mod( 'emulsion_editor_support' ) ) {

			$css .= <<<CSS2
		#customize-theme-controls #accordion-section-emulsion_section_single_post_navigation,
		#customize-theme-controls #accordion-section-emulsion_section_advanced_customizer,
		#customize-theme-controls #accordion-section-emulsion_section_advanced_relate_posts,
		#customize-theme-controls #accordion-section-emulsion_section_advanced_search_drawer,
		#customize-theme-controls #accordion-section-emulsion_section_advanced_instantclick,
		#customize-theme-controls #accordion-section-emulsion_section_advanced_lazyload,
		#customize-theme-controls #accordion-section-emulsion_section_advanced_sticky_sidebar,
		#customize-theme-controls #accordion-section-emulsion_section_advanced_tooltip,
		#customize-theme-controls #accordion-section-emulsion_section_advanced_toc,
		#customize-theme-controls #accordion-section-emulsion_section_advanced_excerpt,
		/*#customize-theme-controls #accordion-panel-emulsion_theme_settings_advanced_panel,*/
		#customize-theme-controls #accordion-section-header_image,
		#customize-theme-controls #accordion-panel-emulsion_theme_settings_post_panel,
		#customize-theme-controls #accordion-panel-emulsion_theme_settings_layout_panel,
		#customize-theme-controls #accordion-panel-emulsion_theme_settings_fonts_panel,
		#customize-theme-controls #accordion-panel-emulsion_theme_settings_border_panel,
		#customize-theme-controls #accordion-section-colors,
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
			display:none !important;

		}
CSS2;
		}


		if ( 'simple' == get_theme_mod( 'emulsion_header_layout' ) ) {

			$css .= <<<CSS3
		#customize-theme-controls #accordion-section-header_image{
			display:none !important;
		}
CSS3;
		}

		if ( 'theme' == get_theme_mod( 'emulsion_editor_support' ) ) {

			$css .= <<<CSS3
		#customize-notifications-area [data-code="site_editor_block_theme_notice"]{
			display:none !important;
		}
CSS3;
		}

		if ( 'transitional' == get_theme_mod( 'emulsion_editor_support' ) ) {
			//#customize-theme-controls #accordion-section-emulsion_section_advanced_excerpt,
			$css .= <<<CSS4
		#accordion-section-emulsion_section_post,
		#accordion-section-emulsion_section_layout_search_results,
		#accordion-section-emulsion_section_layout_author_archives,
		#accordion-section-emulsion_section_layout_tag_archives,
		#accordion-section-emulsion_section_layout_category_archives,
		#accordion-section-emulsion_section_layout_date_archives,
		#accordion-section-emulsion_section_layout_posts_page,
		#accordion-section-emulsion_section_layout_homepage,
		#accordion-section-emulsion_section_border_stream,
		#accordion-section-emulsion_section_border_grid,
		#accordion-section-emulsion_section_border_global,
		#customize-control-emulsion_background_css_pattern,

		#customize-control-emulsion_scheme #details-stream,
		#customize-control-emulsion_scheme [for="emulsion_schemestream"],
		#customize-control-emulsion_scheme #details-grid,
		#customize-control-emulsion_scheme [for="emulsion_schemegrid"],
		#customize-control-emulsion_scheme #details-bloging{
			display:none !important;

		}

CSS4;
		}


		wp_add_inline_style( 'customize-controls', $css );
	}

}

if ( version_compare( $wp_version, '5.9-bata', '<' ) ) {

	//add_action( 'customize_controls_enqueue_scripts', 'emulsion_theme_customizer_script' );
}

if ( ! function_exists( 'emulsion_theme_customizer_script' ) ) {

	function emulsion_theme_customizer_script() {

		$emulsion_gutenberg_install_url = esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=all' ) );

		$emulsion_gutengerg_status = is_plugin_active( 'gutenberg/gutenberg.php' ) ? sprintf( '<p class="is-gutenberg-active">%1$s</p>', esc_html__( 'Important settings have changed. Please save it and view the blog.If you need more settings, please reopen Customize', 'emulsion' ) ) : sprintf( '<p class="need-gutenberg-activate"><h3><a href="%1$s">%3$s</a></h3>%2$s</p>', $emulsion_gutenberg_install_url, esc_html__( 'If you choose anything other than default, you need to activate the Gutenberg Plugin. ', 'emulsion' ), esc_html__( 'Please Click and Install Gutenberg Plugin', 'emulsion' ) );

		$script = <<< SCRIPT
(function($){

	wp.customize( 'emulsion_scheme', function( setting ) {

        setting.bind( function( value ) {
				$('[id|="details"]').removeAttr('open');
				$('#details-' + value ).attr('open','open');
        } );
    } );
	wp.customize('emulsion_editor_support', function (setting) {
        setting.bind(function (value) {
            var code = 'need_plugin_gutenberg_activate';

            if ('theme' !==  value ) {
                setting.notifications.add(code, new wp.customize.Notification(
                        code,
                        {
                            type: 'warning',
                            message: '$emulsion_gutengerg_status'
                        }
                ));
            } else {

                setting.notifications.remove(code);
            }
        });
    });

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

	$values			 = array( 'fse', 'transitional', 'theme' );
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

function emulsion_render_elements_support_validate( $input ) {
	$values			 = array( 'enable', 'disable' );
	$default_value	 = 'disable';

	if ( in_array( $input, $values ) ) {

		return $input;
	}
	return $default_value;
}

function emulsion_gutenberg_render_layout_support_flag_validate( $input ) {
	$values			 = array( 'enable', 'disable' );
	$default_value	 = 'disable';

	if ( in_array( $input, $values ) ) {

		return $input;
	}
	return $default_value;
}

function emulsion_custom_css_support_validate( $input ) {

	$values			 = array( 'enable', 'disable' );
	$default_value	 = 'disable';

	if ( in_array( $input, $values ) ) {

		return $input;
	}
	return $default_value;
}

function emulsion_should_load_separate_core_block_assets_validate( $input ) {
	$values			 = array( 'enable', 'disable' );
	$default_value	 = 'disable';

	if ( in_array( $input, $values ) ) {

		return $input;
	}
	return $default_value;
}

function emulsion_header_template_validate( $input ) {

	$values			 = array( 'html', 'default' );
	$default_value	 = 'html';

	if ( in_array( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

function emulsion_footer_template_validate( $input ) {

	$values			 = array( 'html', 'default' );
	$default_value	 = 'html';

	if ( in_array( $input, $values ) ) {

		return $input;
	}

	return $default_value;
}

add_action( 'customize_controls_enqueue_scripts', 'emulsion_customizer_script' );

function emulsion_customizer_script() {

	$current_theme_mode = get_theme_mod( 'emulsion_editor_support' );

	$script = <<<SCRIPT
(function ( $ ) {
	var current_theme_mode = '{$current_theme_mode}';

	if( 'fse' == current_theme_mode ){
		var message = `<div id="fse-message-preview" style="overflow:hidden;width:100%;height:100vh;background:#000;color:#fff">
					<h1 style="color:#fff;margin:25vh auto .75rem;width:720px;line-height:1.5">The theme scheme setting is Full Site Editing Theme.<br> The preview cannot be displayed with this setting.</h1>
					<p style="margin:1rem auto;width:680px;max-width:100%;padding:0 1.5rem">Use the new editor (Dashboard / Apprearance / Editor) to customize your site.</p>
						</div>`;
		$('#customize-preview').prepend( message );
	}

	wp.customize('emulsion_editor_support', function (value) {
        value.bind(function (newval) {
			var current_theme_mode = '{$current_theme_mode}';

		if( newval == 'theme') {
			var current_theme_mode_label = 'Classic Theme';
		}
		if( newval == 'transitional') {
			var current_theme_mode_label =  'FSE Transitional Theme';
		}
		if( newval == 'fse') {
			var current_theme_mode_label =  'Full Site Editing Theme';
		}


			if( 'fse' !== current_theme_mode ){
				if('fse' == newval ){

				var message = `<div id="fse-message-preview" style="overflow:hidden;width:100%;height:100vh;background:#000;color:#fff">
					<h1 style="color:#fff;margin:25vh auto .75rem;width:720px;">Full Site Editor has been Activated</h1>
					<p style="margin:1rem auto;width:720px;max-width:100%;">Use the new editor (Dashboard / Apprearance / Editor) to customize your site.</p>
						</div>`;

					$('#customize-preview').prepend(message);

				} else {
					$('#fse-message-preview').remove();
				}
			}
			if( 'fse' == current_theme_mode ){

				var message = `<div id="fse-message-preview" style="overflow:hidden;width:100%;height:100vh;background:#000;color:#fff">
					<h1 style="color:#fff;margin:25vh auto .75rem;width:720px;line-height:1.5">The theme mode has been changed to <span style="color:lime">` + current_theme_mode_label + `</span>
						Publish it, reload the browser once, and change the design while watching the preview.</h1>
						</div>`;

					$('#customize-preview').prepend(message);
			}

        });
    });
})(jQuery);
SCRIPT;

	if ( is_customize_preview() ) {
		wp_add_inline_script( 'customize-controls', $script );
	}
}
