<?php
class emulsion_add_meta_boxes {

	public $screens = array(

		'emulsion_post_sidebar'			 => array(
			'post_type'	 => 'post',
			'title'		 => 'Sidebar',
			'html'		 => 'emulsion_post_metabox_html',
			'args'		 => array(
				'icon'			 => '<span class="dashicons dashicons-lightbulb"></span>',
				'fields'		 => array( 'Default' => 'default', 'Remove Sidebar' => "no_sidebar" ),
				'description'	 => 'You can hide the sidebar for each post.',
			),
		),
		'emulsion_post_header'				 => array(
			'post_type'	 => 'post',
			'title'		 => 'Header',
			'html'		 => 'emulsion_post_metabox_html',
			'args'		 => array(
				'icon'			 => '<span class="dashicons dashicons-lightbulb"></span>',
				'fields'		 => array( 'Default' => 'default', 'Remove Header' => "no_header",'Reset Header Color Settings' => 'no_bg' ),
				'description'	 => 'This setting is mainly for page builder users.',
			),
		),
		'emulsion_post_theme_style_script'	 => array(
			'post_type'	 => 'post',
			'title'		 => 'Style',
			'html'		 => 'emulsion_post_metabox_html',
			'args'		 => array(
				'icon'			 => '<span class="dashicons dashicons-lightbulb"></span>',
				'fields'		 => array( 'Default' => 'default', 'Remove All Style, Script' => "no_style", "Reset All Color Settings" => 'no_bg' ),
				'description'	 => 'This setting is mainly for page builder users.',
			),
		),
		'emulsion_post_primary_menu'		 => array(
			'post_type'	 => 'post',
			'title'		 => 'Menu',
			'html'		 => 'emulsion_post_metabox_html',
			'args'		 => array(
				'icon'			 => '<span class="dashicons dashicons-lightbulb"></span>',
				'fields'		 => array( 'Default' => 'default', 'Remove Primary Menu' => "no_menu" ),
				'description'	 => 'Remove Primary Menu',
			),
		),
		// Page
		'emulsion_page_sidebar'			 => array(
			'post_type'	 => 'page',
			'title'		 => 'Sidebar',
			'html'		 => 'emulsion_post_metabox_html',
			'args'		 => array(
				'icon'			 => '<span class="dashicons dashicons-lightbulb"></span>',
				'fields'		 => array( 'Default' => 'default', 'Remove Sidebar' => "no_sidebar" ),
				'description'	 => 'You can hide the sidebar for each page.',
			),
		),
		'emulsion_page_header'				 => array(
			'post_type'	 => 'page',
			'title'		 => 'Header',
			'html'		 => 'emulsion_post_metabox_html',
			'args'		 => array(
				'icon'			 => '<span class="dashicons dashicons-lightbulb"></span>',
				'fields'		 => array( 'Default' => 'default', 'Remove Header' => "no_header",'Reset Header Color Settings' => 'no_bg' ),
				'description'	 => 'This setting is mainly for page builder users.',
			),
		),
		'emulsion_page_theme_style_script'	 => array(
			'post_type'	 => 'page',
			'title'		 => 'Style',
			'html'		 => 'emulsion_post_metabox_html',
			'args'		 => array(
				'icon'			 => '<span class="dashicons dashicons-lightbulb"></span>',
				'fields'		 => array( 'Default' => 'default', 'Remove All Style, Script' => "no_style", "Reset All Color Settings" => 'no_bg'  ),
				'description'	 => 'This setting is mainly for page builder users.',
			),
		),
		'emulsion_page_primary_menu'		 => array(
			'post_type'	 => 'page',
			'title'		 => 'Menu',
			'html'		 => 'emulsion_post_metabox_html',
			'args'		 => array(
				'icon'			 => '<span class="dashicons dashicons-lightbulb"></span>',
				'fields'		 => array( 'Default' => 'default', 'Remove Primary Menu' => "no_menu" ),
				'description'	 => 'Remove Primary Menu',
			),
		),
	);

	public function __construct() {

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'rest_api_init', array( $this, 'rest_save' ) );
		$this->metabox_display_control();
	}

	public function metabox_display_control() {

		if ( ! is_active_sidebar( 'sidebar-1' ) && is_single() ) {
			unset( $this->screens['emulsion_post_sidebar'] );
		}
		if ( ! is_active_sidebar( 'sidebar-3' ) && is_page() ) {
			unset( $this->screens['emulsion_page_sidebar'] );
		}

		$this->screens = $this->screens;
	}
	
	public function add_meta_box() {

		$args			 = $this->screens[key( $this->screens )]['args'];
		$metabox_label	 = '';
		if ( current_user_can( 'edit_posts' ) ) {

			foreach ( $this->screens as $key => $screen ) {

				if ( 'Sidebar' == $screen['title'] ) {

					add_meta_box(
							$key, esc_html__( 'Sidebar', 'emulsion' ), $screen['html'], $screen['post_type'], 'side', 'low', $screen['args']
					);
				} elseif ( 'Header' == $screen['title'] ) {

					add_meta_box(
							$key, esc_html__( 'Header', 'emulsion' ), $screen['html'], $screen['post_type'], 'side', 'low', $screen['args']
					);
				} elseif ( 'Style' == $screen['title'] ) {

					add_meta_box(
							$key, esc_html__( 'Style', 'emulsion' ), $screen['html'], $screen['post_type'], 'side', 'low', $screen['args']
					);
				} elseif ( 'Menu' == $screen['title'] ) {

					add_meta_box(
							$key, esc_html__( 'Menu', 'emulsion' ), $screen['html'], $screen['post_type'], 'side', 'low', $screen['args']
					);
				} else {

					add_meta_box(
							$key, $screen['title'], $screen['html'], $screen['post_type'], 'side', 'low', $screen['args']
					);
				}
			}
			/* 	register_post_meta( $screen['post_type'], $key, array(
		  'show_in_rest'	 => true,
		  'single'		 => true,
		  'type'			 => 'string',
		  'auth_callback'	 => function() {
		  return current_user_can( 'edit_posts' );
		  },
		  'sanitize_callback' => 'wp_filter_nohtml_kses',
		  ) ); */
		}
	}

	public function rest_save( $post_id ) {
		
	}

	public function save( $post_id ) {

		if ( ! current_user_can( 'edit_posts' ) ) {

			return;
		}

		if ( isset( $this->screens ) ) {

			foreach ( $this->screens as $key => $screen ) {
				
				$key_check = filter_input(INPUT_POST, $key );
				if ( isset( $key_check ) && ! empty( $key_check ) ) {
					
					$nonce		 = $key . '-nonce';
					$nonce =  filter_input(INPUT_POST, $nonce );
					$post_type	 = filter_input(INPUT_POST, 'post_type' );
					
					if ( ! isset( $nonce ) ||
							! wp_verify_nonce( $nonce, $key ) ||
							defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ||
							'post' == $post_type && ! current_user_can( 'edit_posts', $post_id ) ||
							'page' == $post_type && ! current_user_can( 'edit_pages', $post_id ) ) {

						return;
					}

					$data = wp_filter_nohtml_kses( filter_input(INPUT_POST, $key ) );
					update_post_meta( $post_id, $key, $data );
				}
			}
		}
	}

}

function emulsion_metabox_display_control( $location ) {

	global $post, $emulsion_supports;

	$post_id = get_the_ID();

	if ( 'style' == $location && metadata_exists( 'post', $post_id, 'emulsion_post_theme_style_script' ) ) {

		$setting = get_post_meta( $post_id, 'emulsion_post_theme_style_script', true );
		
		
		if ( 'no_bg' == $setting && is_single() ) {
			
			add_filter('emulsion_inline_style','emulsion_reset_no_bg' );
		}
		if ( 'no_style' == $setting && is_single() ) {

			return false;
		}
	}

	if ( 'sidebar' == $location && metadata_exists( 'post', $post_id, 'emulsion_post_sidebar' ) ) {

		$setting = get_post_meta( $post_id, 'emulsion_post_sidebar', true );
		
		
		if ( 'no_sidebar' == $setting && is_single() ) {

			return false;
		}
	}


	if ( 'header' == $location && metadata_exists( 'post', $post_id, 'emulsion_post_header' ) ) {

		$setting = get_post_meta( $post_id, 'emulsion_post_header', true );
		
		if ( 'no_bg' == $setting && is_single() ) {
			add_filter( 'theme_mod_emulsion_header_background_color', 'emulsion_header_background_color_reset' );
		}
		if ( 'no_header' == $setting && is_single() ) {

			return false;
		}
	}
	if ( 'menu' == $location && metadata_exists( 'post', $post_id, 'emulsion_post_primary_menu' ) ) {

		$setting = get_post_meta( $post_id, 'emulsion_post_primary_menu', true );
		
		if ( 'no_menu' == $setting && is_single() ) {

			return false;
		}
	}

	////////

	if ( 'page_header' == $location && metadata_exists( 'post', $post_id, 'emulsion_page_header' ) ) {

		$setting = get_post_meta( $post_id, 'emulsion_page_header', true );
		
		if ( 'no_bg' == $setting && is_page() ) {
			add_filter( 'theme_mod_emulsion_header_background_color', 'emulsion_header_background_color_reset' );
		}

		if ( 'no_header' == $setting && is_page() ) {

			return false;
		}
	}

	if ( 'page_sidebar' == $location && metadata_exists( 'post', $post_id, 'emulsion_page_sidebar' ) ) {

		$setting = get_post_meta( $post_id, 'emulsion_page_sidebar', true );

		if ( 'no_sidebar' == $setting && is_page() ) {

			return false;
		}
	}

	if ( 'page_style' == $location && metadata_exists( 'post', $post_id, 'emulsion_page_theme_style_script' ) ) {

		$setting = get_post_meta( $post_id, 'emulsion_page_theme_style_script', true );
		
		if ( 'no_bg' == $setting && is_page() ) {			
			add_filter('emulsion_inline_style','emulsion_reset_no_bg' );
		}

		if ( 'no_style' == $setting && is_page() ) {

			return false;
		}
	}
	if ( 'page_menu' == $location && metadata_exists( 'post', $post_id, 'emulsion_page_primary_menu' ) ) {

		$setting = get_post_meta( $post_id, 'emulsion_page_primary_menu', true );
		
		if ( 'no_menu' == $setting && is_page() ) {

			return false;
		}
	}

	return true;
}

function emulsion_reset_no_bg( $css ){
	
	$post_id = get_the_ID();
	
		
	$sidebar_background		 = emulsion_sidebar_background_reset();
	$header_bg_color		 = emulsion_header_background_color_reset();
	$background_color		 = emulsion_background_color_reset();
	$general_text_color		 = emulsion_general_text_color_reset();
	$general_link_color		 = emulsion_general_link_color_reset();
	$primary_menu_background = emulsion_primary_menu_background_reset();
	$sidebar_color			 = emulsion_sidebar_text_color_reset();
	$sidebar_link_color		 = emulsion_sidebar_link_color_reset();
	$header_text_color		 = emulsion_header_text_color_reset();
	$header_link_color		 = emulsion_header_link_color_reset();
	$primary_menu_link_color = emulsion_primary_menu_link_color_reset();
	$primary_menu_color		 = emulsion_primary_menu_text_color_reset();


	$css_reset = <<<CSS

		.page-id-{$post_id}.metabox-reset-page-presentation,	
		.postid-{$post_id}.metabox-reset-post-presentation{
			
				
			--thm_general_text_color:{$general_text_color};
			--thm_general_link_color:{$general_link_color};
			--thm_primary_menu_background:{$primary_menu_background};
			--thm_primary_menu_link_color:$primary_menu_link_color;
			--thm_primary_menu_color:$primary_menu_color;
			--thm_sidebar_bg_color:{$sidebar_background};
			--thm_sidebar_text_color:{$sidebar_color};
			--thm_sidebar_link_color:{$sidebar_link_color};
			--thm_background_color:{$background_color};
		}
		.page-id-{$post_id}.metabox-reset-page-presentation.custom-background,
		.postid-{$post_id}.metabox-reset-post-presentation.custom-background{
			background:{$background_color};
		}
CSS;

	$setting = get_post_meta( $post_id, 'emulsion_post_theme_style_script', true );
	$setting_page = get_post_meta( $post_id, 'emulsion_page_theme_style_script', true );

	if ( 'no_bg' == $setting && is_single() || 'no_bg' == $setting_page && is_page()) {	

			return $css. $css_reset;
	}

	return $css;
	
}

function emulsion_post_metabox_html( $post, $callback_args ) {

	$checked = get_post_meta( $post->ID, $callback_args["id"], true );
	
	if ( empty( $checked ) ) {
		$checked = 'default';
	}
	
	$echo = true;
	$nonce = $callback_args['id'] . '-nonce';
	
	echo '<input type="hidden" '
	. 'name="' . esc_attr( $nonce ) . '"'
	. ' id="' . esc_attr( $nonce ) . '"'
	. ' value="' . esc_attr( wp_create_nonce( $callback_args['id'] ) ) . '" />';

	if ( 'emulsion_post_sidebar' == $callback_args['id'] ) {
		$description = esc_html__( 'You can hide the sidebar for each post.', 'emulsion' );
	}
	if ( 'emulsion_post_theme_style_script' == $callback_args['id'] ||
			'emulsion_post_header' == $callback_args['id'] ||
			'emulsion_page_header' == $callback_args['id'] ||
			'emulsion_page_theme_style_script' == $callback_args['id'] ) {

		$description = esc_html__( 'This setting is mainly for page builder users.', 'emulsion' );
	}
	if ( 'emulsion_page_sidebar' == $callback_args['id'] ) {
		$description = esc_html__( 'You can hide the sidebar for each page.', 'emulsion' );
	}
	if ( 'emulsion_post_primary_menu' == $callback_args['id'] ||
			'emulsion_page_primary_menu' == $callback_args['id'] ) {
		$description = esc_html__( 'Remove Primary Menu', 'emulsion' );
	}
	// check lost element			
	$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
	true === WP_DEBUG ? emulsion_elements_assert_equal( $callback_args['args']['icon'],  wp_kses( $callback_args['args']['icon'], array('span' => array('class' => array() ) ) ), $emulsion_place ) : '';
	?>
	<p><?php echo wp_kses( $callback_args['args']['icon'], array('span' => array('class' => array() ) ) ) ?><?php echo esc_html( $description ); ?></p>
	<?php
	emulsion_radio_fields( $callback_args['id'], $callback_args['args']['fields'], $checked );
}

function emulsion_radio_fields( $group_name = '', $fields = array(), $current_field ) {

	foreach ( $fields as $key => $val ) {
		
		if( 'Default' == $key ) {
			
			printf( '<p><input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s><label for="%5$s">%6$s</label></p>', 
					esc_attr( $val ), 
					esc_attr( $group_name ), 
					esc_attr( $val ), 
					checked( $current_field, $val, false ),
					esc_attr( $val ),
					esc_html__( 'Default', 'emulsion' )
					);			
		}elseif( 'Remove Sidebar' == $key ) {
			
			printf( '<p><input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s><label for="%5$s">%6$s</label></p>', 
					esc_attr( $val ), 
					esc_attr( $group_name ), 
					esc_attr( $val ), 
					checked( $current_field, $val, false ),
					esc_attr( $val ),
					esc_html__( 'Remove Sidebar', 'emulsion' )
					);
		}elseif( 'Reset Header Color Settings' == $key ) {
			
			printf( '<p><input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s><label for="%5$s">%6$s</label></p>', 
					esc_attr( $val ), 
					esc_attr( $group_name ), 
					esc_attr( $val ), 
					checked( $current_field, $val, false ),
					esc_attr( $val ),
					esc_html__( 'Reset Header Color Settings', 'emulsion' )
					);	
		}elseif( 'Reset All Color Settings' == $key ) {
			
			printf( '<p><input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s><label for="%5$s">%6$s</label></p>', 
					esc_attr( $val ), 
					esc_attr( $group_name ), 
					esc_attr( $val ), 
					checked( $current_field, $val, false ),
					esc_attr( $val ),
					esc_html__( 'Reset All Color Settings', 'emulsion' )
					);			
		}elseif( 'Remove Header' == $key ) {
			
			printf( '<p><input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s><label for="%5$s">%6$s</label></p>', 
					esc_attr( $val ), 
					esc_attr( $group_name ), 
					esc_attr( $val ), 
					checked( $current_field, $val, false ),
					esc_attr( $val ),
					esc_html__( 'Remove Header', 'emulsion' )
					);			
		}elseif( 'Remove All Style, Script' == $key ) {
			
			printf( '<p><input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s><label for="%5$s">%6$s</label></p>', 
					esc_attr( $val ), 
					esc_attr( $group_name ), 
					esc_attr( $val ), 
					checked( $current_field, $val, false ),
					esc_attr( $val ),
					esc_html__( 'Remove All Style, Script', 'emulsion' )
					);			
		}elseif( 'Remove Primary Menu' == $key ) {
			
			printf( '<p><input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s><label for="%5$s">%6$s</label></p>', 
					esc_attr( $val ), 
					esc_attr( $group_name ), 
					esc_attr( $val ), 
					checked( $current_field, $val, false ),
					esc_attr( $val ),
					esc_html__( 'Remove Primary Menu', 'emulsion' )
					);			
		} else {
			printf( '<p><input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s><label for="%5$s">%6$s</label></p>', 
					esc_attr( $val ), 
					esc_attr( $group_name ), 
					esc_attr( $val ), 
					checked( $current_field, $val, false ),
					esc_attr( $val ),
					esc_html( $key )
					);
		}
	}
}

new emulsion_add_meta_boxes();
