<?php
add_action( 'after_switch_theme', 'emulsion_minimum_php_version_check' );
add_action( 'after_setup_theme', 'emulsion_hooks_setup' );

function emulsion_hooks_setup() {

	do_action( 'emulsion_hooks_setup_before' );

	//both

	add_filter( 'body_class', 'emulsion_body_class' );
	add_filter( 'admin_body_class', 'emulsion_block_editor_class' );
	add_action( 'customize_controls_enqueue_scripts', 'emulsion_customizer_controls_script' );
	add_action( 'customize_controls_enqueue_scripts', 'emulsion_customizer_controls_style' );

	/**
	 * Script
	 */
	true === emulsion_the_theme_supports( 'lazyload' ) ? add_filter( 'emulsion_lazyload_script', 'emulsion_lazyload' ) : '';
	true === emulsion_the_theme_supports( 'instantclick' ) ? add_filter( 'emulsion_instantclick_script', 'emulsion_instantclick' ) : '';
	true === emulsion_the_theme_supports( 'toc' ) ? add_filter( 'emulsion_toc_script', 'emulsion_toc' ) : '';
	'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ? add_filter( 'theme_mod_emulsion_title_in_header', function ( $yesno ) {
						return 'no';
					} ) : '';
	/**
	 * Block editor notation
	 */
	if ( function_exists( 'do_blocks' ) ) {

		add_action( 'theme_mod_emulsion_header_html', 'do_blocks' );
		add_action( 'theme_mod_emulsion_footer_credit', 'do_blocks' );
	}
	add_action( 'wp', static function () {

		if ( false === emulsion_is_amp() ) {
			add_filter( 'emulsion_inline_script', 'emulsion_get_rest' );
		}
	} );
	/**
	 * Scripts
	 */
	if ( ! emulsion_theme_addons_exists() ) {

		/*
		 * removed shortcode
		 * @since 2.3.9
		 * remove_shortcode( 'emulsion_relate_posts' );

		add_filter( 'render_block_core/shortcode', function ( $content ) {

			if ( '[emulsion_relate_posts]' == trim( strip_tags( $content ) ) ) {

				return;
			}
			return $content;
		} );*/

		/**
		 * CJK language ( CJK unified ideographs ) issue instant fix
		 * For languages that do not use single-byte spaces,
		 * solve the problem of string overflow in the_excerpt ()
		 */
		'theme' == get_theme_mod( 'emulsion_editor_support', 'theme' ) ? add_filter( 'get_the_excerpt', 'emulsion_force_excerpt' ) : '';
		/**
		 * Data validations
		 */
		add_filter( 'emulsion_the_site_title', 'ent2ncr' );
		add_filter( 'emulsion_site_text_markup_self', 'ent2ncr' );
		add_filter( 'emulsion_site_text_markup', 'ent2ncr' );
		add_filter( 'emulsion_the_post_title', 'ent2ncr' );
		add_filter( 'emulsion_the_post_meta_on', 'ent2ncr' );
		add_filter( 'emulsion_the_post_meta_in', 'ent2ncr' );
		add_filter( 'emulsion_archive_year_navigation', 'ent2ncr' );
		add_filter( 'emulsion_monthly_archive_prev_next_navigation', 'ent2ncr' );
		add_filter( 'emulsion_footer_text', 'ent2ncr' );
		/**
		 * Plugin Settings relate
		 */
		add_action( 'wp_footer', 'emulsion_theme_google_tracking_code', 99 );

		if ( ! emulsion_theme_addons_exists() ) {
			add_filter( 'wp_scss_needs_compiling', '__return_false' );
		}
		if ( function_exists( 'wp_scss_compile' ) ) {
			//add_filter( 'wp_scss_variables', 'emulsion_wp_scss_set_variables_fallback' );
		}

	}
	/**
	 * PWA
	 * https://wordpress.org/plugins/pwa/
	 * required : customize / site icon
	 */
	if ( defined( 'PWA_VERSION' ) ) {

		add_filter( 'web_app_manifest', 'emulsion_manifest' );

		function emulsion_manifest( $manifest ) {

			if ( ! empty( $manifest['name'] ) && empty( $manifest['short_name'] ) ) {

				$manifest['short_name'] = mb_strimwidth( $manifest['name'], 0, 13 );
			}
			if ( ! empty( $manifest['icons'] ) ) {

				foreach ( $manifest['icons'] as $key => $icon ) {

					$manifest['icons'][$key]["purpose"] = "any maskable";
				}
			}

			return $manifest;
		}

	}
	// fse or transitional

	if ( 'theme' !== emulsion_get_theme_operation_mode() ) {



		add_filter( 'render_block_core/navigation', function ( $content, $block ) {

			if ( 'transitional' == emulsion_get_theme_operation_mode() && 'fse-primary' == $block["attrs"]["className"] ) {

				return;
			}
			return $content;
		}, 10, 2 );

		add_filter( 'render_block_core/template-part', 'emulsion_fse_footer_content_filter', 10, 2 );

		// core issue hotfix





	}

	if ( 'fse' == emulsion_get_theme_operation_mode() ) {

	} else {
		// transitional or theme

		add_filter( 'body_class', 'emulsion_body_background_class' );
		add_filter( 'body_class', 'emulsion_remove_custom_background_class' );

		add_action( 'wp_head', 'emulsion_meta_elements' );
		add_action( 'wp_head', 'emulsion_pingback_header' );
		'fse' !== emulsion_get_theme_operation_mode() ? add_action( 'wp_body_open', 'emulsion_skip_link' ) : '';

		add_action( 'wp_enqueue_scripts', 'emulsion_not_support_presentation_page_link' );

		add_filter( 'get_the_archive_title', 'emulsion_archive_title_filter' );
		add_filter( 'the_title', 'emulsion_empty_the_title_fallback' );
		add_filter( 'the_content', 'emulsion_entry_content_filter', 11 );
		add_filter( 'embed_oembed_html', 'emulsion_oembed_filter', 99, 4 );
		add_filter( 'do_shortcode_tag', 'emulsion_shortcode_tag_filter', 99, 4 );
		add_filter( 'the_password_form', 'emulsion_get_the_password_form', 11 );
		add_filter( 'oembed_default_width', 'emulsion_oembed_default_width', 99 );
		'theme' == get_theme_mod( 'emulsion_editor_support', 'theme' ) ? add_filter( 'excerpt_length', 'emulsion_excerpt_length_with_lang', 99 ) : '';

		add_filter( 'theme_templates', 'emulsion_theme_templates' );
		add_filter( 'the_excerpt', 'emulsion_excerpt_remove_p' );
		add_filter( 'gettext_with_context_default', 'emulsion_change_translate', 99, 4 );
		add_filter( 'the_content_more_link', 'emulsion_read_more_link' );
		add_filter( 'navigation_markup_template', 'emulsion_remove_role_from_pagination' );
		add_filter( 'get_header_image_tag', 'emulsion_amp_add_layout_attribute' );
		add_filter( 'get_the_archive_description', 'wpautop' );
		add_filter( 'wp_img_tag_add_loading_attr', 'emulsion_skip_loading_lazy_image', 10, 3 );

		//Post title cannot be displayed in header when html template is loaded
		//JSON-LD add desscription
		if ( defined( 'AMP_VERSION' ) && version_compare( AMP_VERSION, '2.1.2', '>=' ) ) {

			add_filter( 'amp_post_template_metadata', 'emulsion_amp_description', 10, 2 );
		}
	}

	do_action( 'emulsion_hooks_setup_after' );
}




if ( ! function_exists( 'emulsion_minimum_php_version_check' ) ) {

	function emulsion_minimum_php_version_check() {

		if ( ! is_php_version_compatible( EMULSION_MIN_PHP_VERSION ) ) {

			add_action( 'admin_notices', 'emulsion_php_version_notice' );
			switch_theme( get_option( 'theme_switched' ) );
			return false;
		};
	}

}

if ( ! function_exists( 'emulsion_body_class' ) ) {

	/**
	 * Theme body class
	 * @global type $_wp_theme_features
	 * @param type $classes
	 * @return array;
	 */
	function emulsion_body_class( $classes ) {
		global $post, $template;

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $classes;
		}

		if ( is_admin() && $_GET['legacy-widget-preview'] ) {
			$classes[] = 'legacy-widget-preview';
		}

		$post_id = get_the_ID();

		if ( false === emulsion_the_theme_supports( 'enqueue' ) && ! emulsion_is_amp() ) {

			$classes[]		 = 'emulsion-not-support-presentation';
			$metabox_flag	 = true;
			//return $classes;
		}
		if ( is_page() && 'no_style' === get_post_meta( $post_id, 'emulsion_page_theme_style_script', true ) ) {

			$classes[]		 = 'emulsion-removed-presentation';
			$metabox_flag	 = true;
			//return $classes;
		}
		if ( is_single() && 'no_style' === get_post_meta( $post_id, 'emulsion_post_theme_style_script', true ) ) {

			$classes[]		 = 'emulsion-removed-presentation';
			$metabox_flag	 = true;
			//return $classes;
		}
		if ( emulsion_the_theme_supports( 'sidebar' ) || emulsion_the_theme_supports( 'sidebar_page' ) ) {

			if ( is_page() ) {

				unset( $classes['emulsion-no-sidebar'] );
				unset( $classes['emulsion-has-sidebar'] );

				$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_page_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_page_sidebar' ) );
				$logged_in				 = 'logged_in_user' == $sidebar_condition && ! is_user_logged_in() ? false : true;
				$metabox_page_control	 = emulsion_metabox_display_control( 'page_sidebar' );

				$classes[] = is_active_sidebar( 'sidebar-3' ) &&
						emulsion_the_theme_supports( 'sidebar_page' ) &&
						$logged_in &&
						$metabox_page_control ? ' emulsion-has-sidebar' : ' emulsion-no-sidebar';
			} else {

				unset( $classes['emulsion-no-sidebar'] );
				unset( $classes['emulsion-has-sidebar'] );

				$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_posts_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_posts_sidebar' ) );
				$logged_in				 = 'logged_in_user' == $sidebar_condition && ! is_user_logged_in() ? false : true;
				$metabox_post_control	 = emulsion_metabox_display_control( 'sidebar' );

				$classes[] = is_active_sidebar( 'sidebar-1' ) &&
						emulsion_the_theme_supports( 'sidebar' ) &&
						$logged_in &&
						$metabox_post_control ? ' emulsion-has-sidebar' : ' emulsion-no-sidebar';
			}
		}
		// fse background class
		$classes[] = emulsion_fse_background_color_class();

		if ( true === emulsion_the_theme_supports( 'title_in_page_header' ) ) {
			// fse mode allways return no
			$title_in_header = get_theme_mod( "emulsion_title_in_header", emulsion_theme_default_val( 'emulsion_title_in_header' ) );

			// fse needs this
			if ( 'yes' == $title_in_header ) {

				$classes[] = 'emulsion-header-has-title';
			}
			if ( 'no' == $title_in_header ) {

				$classes[] = 'emulsion-layout-no-title';
			}
		}
		if('theme' == get_theme_mod( 'emulsion_editor_support' ) && emulsion_is_amp() ){
			$classes[] = 'amp-give-up';
		}
		if ( is_singular() ) {

			$classes[]	 = 'no_bg' === get_post_meta( $post_id, 'emulsion_page_theme_style_script', true ) ? 'metabox-reset-page-presentation' : '';
			$classes[]	 = 'no_bg' === get_post_meta( $post_id, 'emulsion_post_theme_style_script', true ) ? 'metabox-reset-post-presentation' : '';
			$classes[]	 = 'no_menu' === get_post_meta( $post_id, 'emulsion_post_primary_menu', true ) ? 'metabox-removed-post-menu' : '';
			$classes[]	 = 'no_menu' === get_post_meta( $post_id, 'emulsion_page_primary_menu', true ) ? 'metabox-removed-page-menu' : '';
			$classes[]	 = 'no_bg' === get_post_meta( $post_id, 'emulsion_post_header', true ) ? 'metabox-reset-post-header' : '';
			$classes[]	 = 'no_bg' === get_post_meta( $post_id, 'emulsion_page_header', true ) ? 'metabox-reset-page-header' : '';
			$classes[]	 = 'no_header' === get_post_meta( $post_id, 'emulsion_post_header', true ) ? 'metabox-removed-post-header' : '';
			$classes[]	 = 'no_header' === get_post_meta( $post_id, 'emulsion_page_header', true ) ? 'metabox-removed-page-header' : '';
			$classes[]	 = 'is-singular';

			$emulsion_post_id = get_the_ID();

			$classes[] = comments_open( $emulsion_post_id ) ? 'is-comments-open' : 'is-comments-close';
		}

		if( is_child_theme() ){

			$classes[] = 'is-child-theme';
		}

		if ( get_theme_support( 'align-wide' ) ) {

			$classes[] = 'enable-alignfull';
		}

		if ( emulsion_the_theme_supports( 'block_experimentals' ) && emulsion_is_plugin_active( 'gutenberg/gutenberg.php' ) ) {

			$classes[] = 'enable-block-experimentals';
		}

		$classes[] = get_theme_mod( 'emulsion_border_global' ) || get_theme_mod( 'emulsion_border_global_style' ) || get_theme_mod( 'emulsion_border_global_width' ) ? 'has-border-custom' : 'border-default';
		if('transitional' !== emulsion_get_theme_operation_mode() &&
			'html' !== get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {
		$classes[]	 = 'noscript';
			}
		$classes[]	 = 'emulsion';

		if ( is_singular() && isset( $post ) ) {
			$author_name = 'by-' . get_the_author_meta( 'display_name', $post->post_author );
			$classes[]	 = sanitize_html_class( $author_name );
		}

		if ( emulsion_the_theme_supports( 'scheme' ) ) {

			$emulsion_scheme = get_theme_mod( 'emulsion_scheme' );

			if ( $emulsion_scheme ) {

				$classes[] = sanitize_html_class( 'scheme-' . $emulsion_scheme );

				if ( 'grid' == $emulsion_scheme || 'stream' == $emulsion_scheme ) {

					$classes[] = sanitize_html_class( 'layout-' . $emulsion_scheme );
				}
			}
		}

		if ( has_blocks() && is_singular() ) {

			$classes[] = 'has-block';
		}
		if ( ! has_blocks() && is_singular() ) {

			$classes[] = 'no-block';
		}

		if ( emulsion_the_theme_supports( 'full_site_editor' ) && emulsion_do_fse() ) {

			$classes[] = 'emulsion-fse-active';

			if ( ! is_page() || ! is_attachment() || ! is_single() || has_block( 'post-excerpt' ) ) {

				$classes[] = 'summary';//for transitional theme
				$classes[] = 'excerpt';// for classic theme
			} else {
				$classes[] = 'full_text';
			}
		}
		/**
		 * Font family class
		 */
		if ( 'theme' == emulsion_get_theme_operation_mode() ) {

			$heading_font_family = get_theme_mod( 'emulsion_heading_font_family', emulsion_theme_default_val( 'emulsion_heading_font_family' ) );

			$classes[] = sanitize_html_class( 'font-heading-' . $heading_font_family );

			if ( function_exists( 'emulsion_get_css_variables_values' ) ) {

				$common_font_family = emulsion_get_css_variables_values( 'common_font_family' );
			} else {

				$common_font_family = emulsion_theme_default_val( 'emulsion_common_font_family' );
			}

			$classes[] = sanitize_html_class( 'font-common-' . $common_font_family );
		}

		$emulsion_scheme = get_theme_mod( 'emulsion_scheme' );

		if ( 'transitional' == emulsion_get_theme_operation_mode() && 'default' == $emulsion_scheme ) {

			if( ! empty( get_theme_mod( 'emulsion_heading_font_family') ) ||
				! empty( get_theme_mod( 'heading_font_weight') ) ||
				! empty( get_theme_mod( 'heading_font_scale') ) ){

				$classes[] = 'has-customizer-heading-style';

			}

			if( ! empty( get_theme_mod( 'common_font_family') ) ||
				! empty( get_theme_mod( 'common_font_size') ) ){

				$classes[] = 'has-customizer-common-font-style';

			}

			if( ! empty( get_theme_mod( 'widget_meta_font_transform') ) ||
				! empty( get_theme_mod( 'widget_meta_font_family') ) ||
				! empty( get_theme_mod( 'widget_meta_font_size') ) ){

				$classes[] = 'has-customizer-meta-style';

			}



		}



		$classes[] = sanitize_html_class( 'is-presentation-' . get_theme_mod( 'emulsion_editor_support', 'theme' ) );

		// current template

		$classes[] = 'is-tpl-' . emulsion_get_template();

		if( emulsion_is_custom_post_type() ) {

			$classes[] = 'post-type-custom';
		} else {

			$classes[] = 'post-type-default';
		}

		return $classes;
	}

}

/**
 * Viewport
 */
if ( ! function_exists( 'emulsion_meta_elements' ) ) {

	function emulsion_meta_elements() {
		if ( emulsion_the_theme_supports( 'viewport' ) ) {
			?><meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1" id="emulsion-viewport" />
			<meta name="apple-mobile-web-app-capable" content="yes" />
			<meta name="apple-mobile-web-app-status-bar-style" content="default" /><?php
		}
	}

}

if ( ! function_exists( 'emulsion_pingback_header' ) ) {

	function emulsion_pingback_header() {
		if ( is_singular() && pings_open( get_queried_object() ) ) {
			printf( '<link rel="pingback" href="%1$s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

}

if ( ! function_exists( 'emulsion_skip_link' ) ) {

	function emulsion_skip_link() {

		$skip_link_url = emulsion_request_url() . '#main';

		printf( '<div class="%1$s" role="navigation" aria-label="Skip Link"><a href="%2$s" class="%3$s" title="%4$s">%5$s</a></div>', 'skip-link', esc_url( $skip_link_url ), 'screen-reader-text', esc_attr__( 'Skip to content', 'emulsion' ), esc_html__( 'Skip to content', 'emulsion' )
		);
	}

}

function emulsion_archive_title_filter( $title ) {

	if ( has_filter( 'get_the_archive_title_prefix' ) || has_filter( 'get_the_archive_title_prefix' ) ) {
		//WordPress 5.5
		return $title;
	}

	if ( strpos( $title, ':' ) !== false ) {

		list($archive_title, $archive_name ) = explode( ':', $title );

		$html = '<span class="term" tabindex="0">%1$s</span><span class="separator">:</span><span class="archive-name"  tabindex="0">%2$s</span>';

		return sprintf( $html, $archive_title, $archive_name );
	}
	return $title;
}

if ( ! function_exists( 'emulsion_entry_content_filter' ) ) {

	/**
	 *
	 * @param type $content
	 * @return type
	 */
	function emulsion_entry_content_filter( $content ) {

		$support = emulsion_the_theme_supports( 'entry_content_filter' );

		if ( true !== $support ) {
			return $content;
		}
		// decode url encoded text
		$content = preg_replace_callback( "|<a[^>]+>.*?(https?:\/\/[-_.!*\'()a-zA-Z0-9;\/?:@&=+$,%#]+).*?</a>|", "emulsion_link_url_text_decode", $content );
		return $content;
	}

}
if ( ! function_exists( 'emulsion_link_url_text_decode' ) ) {

	/**
	 * Decode URL-encoded link text
	 *
	 * @param type $matches
	 * @return type
	 */
	function emulsion_link_url_text_decode( $matches ) {

		if ( isset( $matches[1] ) && preg_match( '!%[0-9A-Z][0-9A-Z]+!', $matches[1] ) ) {

			$replace = urldecode( $matches[1] );
			$replace = esc_html( $replace );

			return preg_replace( "|>" . $matches[1] . "</a>|", ">{$replace}</a>", $matches[0] );
		}
		return $matches[0];
	}

}


if ( ! function_exists( 'emulsion_shortcode_tag_filter' ) ) {

	function emulsion_shortcode_tag_filter( $output, $tag, $attr, $m ) {

		if ( 'embed' == $tag && preg_match( '!\[embed\].+\[/embed\]!', $m[0] ) ) {
			//preg_match is auto embed not has attribute

			return emulsion_oembed_object_wrapper( $output, $m[5], 'shortcode-object' );
		}
		return $output;
	}

}






if ( ! function_exists( 'emulsion_lazyload' ) ) {

	function emulsion_lazyload( $script ) {

		$support = emulsion_the_theme_supports( 'lazyload' );

		if ( $support ) {

			$script .= "jQuery(function ($) {
				$('img').each(function (index) {
					var text = $(this).attr('src');
					var responsive_set = $(this).attr('srcset');
					$(this).attr('data-src', text);
					$(this).attr('data-srcset', responsive_set);
					$(this).removeAttr('src');
					$(this).attr('src', 'data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs=');
					$(this).removeAttr('srcset');
					$(this).addClass('lazyload');
					});
				$('article .show-post-image,.wp-block-cover').each(function (index) {
					var text = $(this).attr('style');
					$(this).attr('data-src', text);
					$(this).addClass('lazyload');
					});

					$('img.lazyload').lazyload();
					$('article .show-post-image').lazyload();

			});";
		}

		return $script;
	}

}




if ( ! function_exists( 'emulsion_oembed_default_width' ) ) {

	/**
	 * Default width of oembed media
	 * @param type $width
	 * @return int
	 */
	function emulsion_oembed_default_width( $width ) {

		return emulsion_theme_default_val( 'emulsion_content_width' );
	}

}

if ( ! function_exists( 'emulsion_empty_the_title_fallback' ) ) {

	function emulsion_empty_the_title_fallback( $title ) {

		if ( empty( $title ) ) {
			return esc_html_x( '...', 'Alternative string when the title is blank', 'emulsion' );
		}
		return $title;
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

if ( ! function_exists( 'emulsion_make_css_variable' ) ) {

	function emulsion_make_css_variable( $theme_mod_name ) {
//
		//exceptions todo Ensuring consistency
		$replace_pairs = array(
			'emulsion_header_background_color'		 => '--thm_header_bg_color',
			'emulsion_heading_font_transform'		 => '--thm_heading_font_transform',
			'emulsion_widget_meta_font_size'		 => '--thm_data_font_size',
			'emulsion_widget_meta_font_family'		 => '--thm_meta_data_font_family',
			'emulsion_widget_meta_font_transform'	 => '--thm_meta_data_font_transform',
			'emulsion_sidebar_background'			 => '--thm_sidebar_bg_color',
		);

		$css_variable	 = strtr( $theme_mod_name, $replace_pairs );
		$css_variable	 = str_replace( 'emulsion', '--thm', $css_variable );

		return $css_variable . ':' . emulsion_theme_default_val( $theme_mod_name, 'unit_val' ) . ';';
	}

}

if ( ! function_exists( 'emulsion_theme_styles' ) ) {

	function emulsion_theme_styles( $css ) {
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $css;
		}

		if ( emulsion_inline_style_load_controller( __FUNCTION__ ) ) {

			return $css;
		}

		$variables = false !== get_theme_mod( 'emulsion__css_variables' ) ? get_theme_mod( 'emulsion__css_variables' ) : '';

		$responsive_break_point	 = emulsion_theme_default_val( 'emulsion_content_width' ) + emulsion_theme_default_val( 'emulsion_sidebar_width' ) + emulsion_theme_default_val( 'emulsion_common_font_size' );
		$responsive_break_point	 = absint( $responsive_break_point );

		/* hide uncategorized category */
		$uncagegorized_hide_style = absint( get_category_by_slug( 'uncategorized' )->term_id ) == absint( get_option( 'default_category' ) ) ? '#document .cat-item-1{display:none;}' : '';

		$customize_saved = <<< CUSTOMIZED_CSS

{$variables}
/* @see emulsion_theme_styles */
{$uncagegorized_hide_style}

.emulsion-addons-inactive{
	--thm_content_gap:24px;
	--thm_align_offset:200px;

}

.emulsion-addons-inactive .article-wrapper:after {
	display:block;
    width: 720px;
    max-width: 100%;
    margin: auto;
    content: ' ';
    border-bottom: 1px solid rgba(188, 188, 188, 0.5);
}

.emulsion-addons-inactive aside h1{
	line-height:var(--thm_common_line_height, 1.15);
}
.emulsion-addons-inactive .footer-layer,
.emulsion-addons-inactive .header-layer{
	--thm_header_background_gradient_color:var(--thm_header_bg_color);
	background-color:var(--thm_header_bg_color);
	color:var(--thm_header_text_color);
}
.emulsion-addons-inactive .is-dark .header-layer ~ .scroll-button-top.skin-button {
    color: var(--thm_general_text_color);
    background: var(--thm_background_color);
}
.emulsion-addons-inactive .scheme-midnight{
	--thm_sub_background_color_darken: rgba(0,0,0,1);
    --thm_sub_background_color_lighten: rgba(255, 255, 255,.2);

}
.emulsion-addons-inactive .scheme-midnight{
	background: var(--thm_background_color);
	color: var(--thm_general_text_color);
	font-size:var(--thm_common_font_size);
}
.emulsion-addons-inactive .scheme-midnight .banner {
  background: var(--thm_background_color);
  color: var(--thm_general_text_color);
}
.emulsion-addons-inactive .scheme-midnight .banner a,
.emulsion-addons-inactive .scheme-midnight .banner .widgettitle {
	color: var(--thm_general_text_color);
}
.emulsion-addons-inactive body.scheme-daybreak > .template-part-header .menu .children,
.emulsion-addons-inactive body.scheme-daybreak > .template-part-header .menu .sub-menu{
	background-color:var(--thm_header_bg_color);
	color:var(--thm_header_text_color);
}
.emulsion-addons-inactive body > header.header-layer .site-description,
.emulsion-addons-inactive body > header.header-layer .site-title-link{
	color:var(--thm_header_text_color);
}
.emulsion-addons-inactive main .grid .trancate-heading,
.emulsion-addons-inactive main .stream .trancate-heading{
	font-size:22px;
}
.emulsion-addons-inactive main .excerpt article footer{
	padding-left:0;
	padding-right:0;
}
.emulsion-addons-inactive main > .excerpt .has-post-thumbnail footer,
.emulsion-addons-inactive main > .excerpt .has-post-thumbnail .entry-content,
.screen-reader-text {
    clip:rect(1px,1px,1px,1px);
    clip-path:polygon(0px 0px,0px 0px,0px 0px,0px 0px);
    height:1px;
    overflow:hidden;
    position:absolute!important;
    white-space:nowrap;
    width:1px;
}
.emulsion-addons-inactive main > .excerpt .has-post-thumbnail footer:focus,
.emulsion-addons-inactive main > .excerpt .has-post-thumbnail .entry-content:focus,
.screen-reader-text:focus{
		clip:auto!important;
        clip-path:none;
        display:block;
        height:auto;
        left:5px;
        padding:0 .3em;
        top:5px;
        width:auto;
        z-index:100000;
}

.emulsion-addons-inactive main > .excerpt .entry-content .content-excerpt p{
	width:-moz-fit-content;
	width:fit-content;
	max-width:var(--thm_content_width, 720px);
	margin-left:auto;
	margin-right:auto;
	padding-left:var(--thm_content_gap, 24px);
	padding-right:var(--thm_content_gap, 24px);
}
.emulsion-addons-inactive main > .excerpt .entry-content .content-excerpt{
	width:100%;
}
.emulsion-addons-inactive main > .excerpt .entry-content{
	width:100%;
}
.emulsion-addons-inactive .wp-block-rss__item{
	padding-left: var(--thm_content_gap, 24px);
    padding-right: var(--thm_content_gap, 24px);
}
.emulsion-addons-inactive .page-wrapper article header .entry-meta .cat-item a:hover {
   color: var(--thm_general_link_hover_color);
}

.emulsion-addons-inactive  .grid .article-wrapper article footer span,
.emulsion-addons-inactive  .stream .article-wrapper article footer span{
		height:48px;
}
.emulsion-addons-inactive body  .grid article header.show-post-image:before{
	top:0;
}
.emulsion-addons-inactive body  .grid article header.show-post-image{
	min-height:25vh;
}
.emulsion-addons-inactive .has-column main > grid{
	 --thm_main_width:calc(100vw - var(--thm_sidebar_width) - 48px );
}
.emulsion-addons-inactive .has-column main > stream{
	--thm_main_width:calc(100vw - var(--thm_sidebar_width) - 48px );
                --thm_content_width:410px;
}
.emulsion-addons-inactive main > .grid {
  --thm_content_width: 300px;
}
.emulsion-addons-inactive main > .grid article {
  --thm_content_width: 100%;
}
.emulsion-addons-inactive main > .stream {
  --thm_content_width: 400px;
}
.emulsion-addons-inactive main > .stream article {
  --thm_content_width: 100%;
}
.emulsion-addons-inactive main > .stream article .content {
  display: block;
}
.emulsion-addons-inactive main > .stream article .entry-content {
  display: none;
}
.emulsion-addons-inactive main > .stream article.preview-is-active .content {
  display: none;
}
.emulsion-addons-inactive main > .stream article.preview-is-active .entry-content {
  display: block;
}
.emulsion-addons-inactive main > .stream article:not(.preview-is-active) .content {
  display: block;
}
.emulsion-addons-inactive main > .stream article:not(.preview-is-active) .entry-content {
  display: none;
}


@media screen and (max-width: {$responsive_break_point}px) {
	.emulsion-addons-inactive body body.emulsion-has-sidebar .alignfull{
		width:100vw;
	}
}
CUSTOMIZED_CSS;

		$result	 = emulsion_sanitize_css( $customize_saved );
		$result	 = emulsion_remove_spaces_from_css( $result );
		return $css . $result;
	}

}


if ( ! function_exists( 'emulsion_force_excerpt' ) ) {

	function emulsion_force_excerpt( $excerpt ) {

		if ( emulsion_lang_cjk() ) {

			$emulsion_cjk_excerpt_length = apply_filters('emulsion_cjk_excerpt_length', emulsion_theme_default_val( 'emulsion_excerpt_length' ) );
			$emulsion_cjk_excerpt_more = apply_filters('emulsion_cjk_excerpt_more', '...');

			return wp_html_excerpt( $excerpt, $emulsion_cjk_excerpt_length, $emulsion_cjk_excerpt_more );
		}
		return $excerpt;
	}

}

if ( ! function_exists( 'emulsion_get_rest' ) ) {

	function emulsion_get_rest( $script ) {
		if ( 'fse' !== emulsion_get_theme_operation_mode() && 'html' !== get_theme_mod( 'emulsion_header_template', emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {
		$script .= <<<SCRIPT

jQuery(function ($) {
    "use strict";
    $(document).on("click", ".show-content", function (event) {

        if (!$('body').hasClass('home') || !$('body').hasClass('archive') || !$('body').hasClass('blog')) {
            event.preventDefault();
        }
        var state = $(this).data('state');
        var single_id = parseInt($(this).data("id"));
        var single_type = $(this).data("type");

        switch (state) {

            case 1 :
            case undefined :
                $(this).addClass('is-active');
                $(this).parents('article').addClass('preview-is-active');
                $(this).data('state', 2);
                $("#loading").css("display", "block");
                if ('page' == single_type) {
                    var nobita_rest_query = 'wp/v2/pages/' + single_id;
                }
                if ('post' == single_type) {
                    var nobita_rest_query = 'wp/v2/posts/' + single_id;
                }
                var request_url = emulsion_script_vars.end_point + nobita_rest_query;
                $.getJSON(request_url, function (results) {
                    if ($("#post-" + single_id + " div").hasClass('entry-content')) {
                    } else {
                        $("#post-" + single_id + " .content").after('<div class="entry-content">' + results.content.rendered + '</div>');
                    }
                    $(".blog #post-" + single_id + ",.home #post-" + single_id + ",.archive #post-" + single_id).parents('.article-wrapper').css({'flex-basis': '100%'});
                });
                $(document).ajaxComplete(function () {
                    $("#loading").css("display", "none").removeAttr('style');
					$("#post-" + single_id + " .entry-content").addClass('archive-preview');
                    $("html,body").animate({scrollTop: $("#post-" + single_id).offset().top - 100});
                });
                break;
            case 2 :
                console.log(state);
                $(this).removeClass('is-active');
                $(this).parents('article').removeClass('preview-is-active');
                $("#post-" + single_id + " .content").show();
                $("#post-" + single_id).parents('.article-wrapper').removeAttr('style');
				$(this).data('state', 1);
                break;
        }
    });
});
SCRIPT;
		}
		return $script;
	}

}
if ( ! function_exists( 'emulsion_excerpt_length_with_lang' ) ) {

	function emulsion_excerpt_length_with_lang() {

		if ( emulsion_theme_addons_exists() ) {

			return absint( emulsion_get_var( 'emulsion_excerpt_length' ) );
		}

		if ( emulsion_lang_cjk() ) {

			return absint( emulsion_theme_default_val( 'emulsion_excerpt_length' ) );
		} else {

			return 55;
		}
	}

}


if ( ! function_exists( 'emulsion_customizer_controls_script' ) ) {

	function emulsion_customizer_controls_script() {

		if ( is_plugin_active( 'emulsion-addons/emulsion.php' ) ) {

			return;
		}

		$plugin_install_url	 = esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=all' ) );
		$message			 = sprintf( '<p>%1$s</p><a href="%2$s">%3$s</a>', esc_html__( 'You can use the emulsion-addons plugin for further customization.', 'emulsion' ), esc_url( $plugin_install_url ), esc_html__( 'Install Plugin', 'emulsion' )
		);

		$script = <<<SCRIPT

	( function( $ ) {
		'use strict';
		wp.customize.bind( 'ready', function () {
			wp.customize.notifications.add(
				'emulsion-addons-custom-notification',
				new wp.customize.Notification(
					'emulsion-addons-custom-notification', {
						dismissible: true,
						message: '{$message}',
						type: 'warning'
					}
				)
			);
		} );

	} )( jQuery );


SCRIPT;

		if ( is_customize_preview() && current_user_can( 'edit_theme_options' ) ) {

			wp_add_inline_script( 'customize-controls', $script );
		}
	}

}

if ( ! function_exists( 'emulsion_customizer_controls_style' ) ) {

	function emulsion_customizer_controls_style() {

		$plugin_icon_url = get_template_directory_uri() . '/images/emulsion-addons.png';
		$css			 = <<<CSS

	[data-code="emulsion-addons-custom-notification"] .notification-message{
			margin-left:72px;
	}

	[data-code="emulsion-addons-custom-notification"]:before{
			content:'';
			background:url({$plugin_icon_url});
			background-size:contain;
			width:64px;
			height:64px;
			position:absolute;
			top:1rem;
	}
CSS;
		if ( is_customize_preview() && ! emulsion_theme_addons_exists() && current_user_can( 'edit_theme_options' ) ) {

			wp_add_inline_style( 'customize-controls', $css );
		}
	}

}
if ( ! function_exists( 'emulsion_theme_templates' ) ) {

	/**
	 * Remove templates that are only valid when using plugins
	 * @param type $post_templates
	 * @return array
	 */
	function emulsion_theme_templates( $post_templates ) {

		if ( false === emulsion_theme_addons_exists() ) {

			unset( $post_templates['template-page/blank.php'] );
			unset( $post_templates['template-page/gallery.php'] );
		}
		return $post_templates;
	}

}

if ( ! function_exists( 'emulsion_amp_description' ) ) {

	function emulsion_amp_description( $metadata, $post ) {

		$metadata['description'] = emulsion_meta_description();
		return $metadata;
	}

}
if ( ! function_exists( 'emulsion_excerpt_remove_p' ) ) {

	function emulsion_excerpt_remove_p( $excerpt ) {

		if ( ! emulsion_theme_addons_exists() ) {

			return strip_tags( $excerpt );
		}
		return $excerpt;
	}

}
if ( ! function_exists( 'emulsion_change_translate' ) ) {

	function emulsion_change_translate( $translation, $text, $context, $domain ) {

		// remove <link crossorigin="anonymous" rel='stylesheet' id='wp-editor-font-css'  href='https://fonts.googleapis.com/css?family=Noto+Serif+JP%3A400%2C700&#038;ver=5.5' media='all' />

		if ( $context == 'Google Font Name and Variants' ) {
			$translation = str_replace( 'Noto Serif:400,400i,700,700i', 'off', $translation );
		}
		return $translation;
	}

}
if ( ! function_exists( 'emulsion_read_more_link' ) ) {

	/**
	 * layout type list
	 * @return type
	 */
	function emulsion_read_more_link() {

		$post_id	 = absint( get_the_ID() );
		$title_text	 = the_title_attribute(
				array( 'before' => esc_html__( 'link to ', 'emulsion' ),
					'echo'	 => false, )
		);

		if ( is_int( $post_id ) ) {

			return sprintf(
					'<p class="read-more"><a class="skin-button" href="%1$s" aria-label="%3$s">%2$s<span class="screen-reader-text read-more-context">%3$s</span></a></p>',
					esc_url( get_permalink() ),
					esc_html__( 'Read more', 'emulsion' ),
					$title_text
			);
		}
	}

}

if ( ! function_exists( 'emulsion_block_editor_class' ) ) {

	function emulsion_block_editor_class( $classes ) {

		global $wp_version;
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $classes;
		}

		$block_editor_class_name = '';
		if('fse' == emulsion_get_theme_operation_mode() ){

			$classes = str_replace( array('is-loop','layout-list','is-light','is-dark'),'', $classes );
		}

		if ( has_action( 'admin_enqueue_scripts', 'gutenberg_edit_site_init' ) ) {

			$block_editor_class_name = ' emulsion-gb-phase-site';
		} else {

			$block_editor_class_name = ' emulsion-gb-phase-block';
		}

		if ( version_compare( $wp_version, '5.5', '>=' ) ) {

			$block_editor_class_name = ' emulsion-gb-phase-site';
		}
		if ( is_plugin_active( 'gutenberg/gutenberg.php' ) ) {

			$block_editor_class_name .= ' emulsion-gb-active';
		} else {

			$block_editor_class_name .= ' emulsion-gb-deactive';
		}

		$block_editor_class_name .= ' ' . sanitize_html_class( 'is-presentation-' . get_theme_mod( 'emulsion_editor_support', 'theme' ) );

		$block_editor_class_name .= ' emulsion';

		// fse background class
		$block_editor_class_name .= ' '. emulsion_fse_background_color_class();

		if ( 'ffffff' !== get_background_color() ) {

			$block_editor_class_name .= ' custom-background';
		}
		if ( 'enable' == emulsion_theme_default_val( 'emulsion_alignfull' ) ) {

			$block_editor_class_name .= ' enable-alignfull';
		} else {

			$block_editor_class_name .= ' disable-alignfull';
		}

		$block_editor_class_name .= emulsion_theme_addons_exists() || get_theme_mod( 'emulsion_border_global' ) || get_theme_mod( 'emulsion_border_global_style' ) || get_theme_mod( 'emulsion_border_global_width' ) ? ' has-border-custom' : ' border-default';

		return $classes . $block_editor_class_name;
	}

}
if ( ! function_exists( 'emulsion_amp_add_layout_attribute' ) ) {

	function emulsion_amp_add_layout_attribute( $html ) {
		if ( emulsion_is_amp() ) {
			return str_replace( ' />', ' layout="responsive" />', $html );
		}

		return str_replace( '/>', ' class="custom-header-image" />', $html );
	}

}

function emulsion_add_amp_css_variables( $css ) {

	// emulsion-addons active and wp-scss not active

	$css_variables = get_theme_mod( 'emulsion__css_variables', false );

	$wp_css_status = get_theme_mod( 'emulsion_wp_scss_status' );

	if ( emulsion_is_amp() && 'active' !== $wp_css_status && ! empty( $css_variables ) ) {
		$css .= $css_variables;
	}
	return $css;
}




if ( ! function_exists( 'emulsion_not_support_presentation_page_link' ) ) {

	function emulsion_not_support_presentation_page_link() {
		//if ( 'fse' == emulsion_get_theme_operation_mode() ) {
		if ( 'fse' == emulsion_get_theme_operation_mode() && 'html' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {
			return;
		}
		$post_id = absint( get_the_ID() );

		if ( is_singular() && metadata_exists( 'post', $post_id, 'emulsion_post_theme_style_script' ) ) {
			$data = <<<EOT

(function () {
	if(document.getElementsByClassName('emulsion-removed-presentation').length || document.getElementsByClassName('emulsion-not-support-presentation').length ){
		var links = document.querySelector('.emulsion-removed-presentation a, .emulsion-not-support-presentation a');
		links.setAttribute("data-no-instant", "data-no-instant");
	}
})();

EOT;
			wp_add_inline_script( 'wp-embed', $data );
		}
	}

}

if ( ! function_exists( 'emulsion_remove_custom_background_class' ) ) {

	/**
	 * If you reset the theme color in the Editor menu, the state will not come out of a custom-background
	 */
	function emulsion_remove_custom_background_class( $classes ) {
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $css;
		}
		$post_id = get_the_ID();

		if ( is_singular() && 'no_bg' == get_post_meta( $post_id, 'emulsion_post_theme_style_script', true ) ) {

			foreach ( $classes as $key => $value ) {
				if ( $value == 'custom-background' )
					unset( $classes[$key] );
			}
			return $classes;
		}

		return $classes;
	}

}
if ( ! function_exists( 'emulsion_remove_role_from_pagination' ) ) {

	function emulsion_remove_role_from_pagination( $template ) {

		return str_replace( 'role="navigation"', '', $template );
	}

}

function emulsion_skip_loading_lazy_image( $value, $image, $context ) {
	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $value;
		}
	if ( 'the_content' === $context ) {

		if ( false !== strpos( $image, 'custom-logo' ) ) {
			return false;
		}

		if ( false !== strpos( $image, 'wp-post-image' ) ) {
			return false;
		}

		if ( false !== strpos( $image, 'custom-header-image' ) ) {
			return false;
		}
	}
	return $value;
}

if ( ! function_exists( 'emulsion_add_third_party_block_css' ) ) {

	function emulsion_add_third_party_block_css( $css ) {
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $css;
		}
		$third_party_blocks = emulsion_get_third_party_block_classes();

		if ( empty( $third_party_blocks ) ) {
			return $css;
		}

		$result					 = '';
		$default				 = <<<DEFAULT_STYLE

	width: var( --thm_content_width, 720px );
    max-width:100%;
    margin:1.5rem auto .75rem;
    padding-left:var( --thm_content_gap, 24px );
    padding-right:var( --thm_content_gap, 24px );
    box-sizing:border-box;

DEFAULT_STYLE;
		$alignleft				 = <<<ALIGN_LEFT
    box-sizing:border-box;
    clear:left;
    float:left;
	width:calc( 50% - var(--thm_content_gap, 24px) - var(--thm_common_font_size) );
    max-width:calc( 50% - var(--thm_content_gap, 24px) - var(--thm_common_font_size) );
    margin-right:var(--thm_common_font_size);
    margin-left:var(--thm_content_gap, 24px);
    margin-top:1.5rem;
    margin-bottom:.75rem;
ALIGN_LEFT;
		$alignright				 = <<<ALIGN_RIGHT
    box-sizing:border-box;
    clear:right;
    float:right;
	width:calc( 50% - var(--thm_content_gap, 24px) - var(--thm_common_font_size) );
    max-width:calc( 50% - var(--thm_content_gap, 24px) - var(--thm_common_font_size) );
    margin-left:var(--thm_content_gap, 24px);
    margin-right:var(--thm_common_font_size);
    margin-top:1.5rem;
    margin-bottom:.75rem;
ALIGN_RIGHT;
		$float_child			 = <<<FLOAT_CHILD
	margin-top:0;
	margin-bottom:0;
FLOAT_CHILD;
		$aligncenter			 = <<<ALIGN_CENTER
    box-sizing:border-box;
    clear:both;
    float:none;
    width:calc( var(--thm_content_width, 720px) - var(--thm_align_offset) );
    max-width:100%;
    margin:1.5rem auto .75rem;
ALIGN_CENTER;
		$alignwide				 = <<<ALIGN_WIDE
    width:calc( var(--thm_content_width, 720px) + var(--thm_align_offset) );
    position: relative;
    left:0;
    margin-left:auto;
    margin-right:auto;
    max-width:100%;
ALIGN_WIDE;
		$has_sidebar_alignfull	 = <<<HAS_SIDEBAR_ALIGN_FULL
    position:relative;
	width:100%;
HAS_SIDEBAR_ALIGN_FULL;
		$no_sidebar_alignfull	 = <<<NO_SIDEBAR_ALIGN_FULL
    width:100vw;
    position:relative;
    overflow:visible;
NO_SIDEBAR_ALIGN_FULL;

		foreach ( $third_party_blocks as $block_class ) {
			$result .= 'body .' . $block_class . '{' . $default . '}';

			$result	 .= 'body .' . $block_class . '.alignleft{' . $alignleft . '}';
			$result	 .= 'body .' . $block_class . '.alignleft > figure{' . $float_child . '}';

			$result	 .= 'body .' . $block_class . '.alignright{' . $alignright . '}';
			$result	 .= 'body .' . $block_class . '.alignright > figure{' . $float_child . '}';

			$result .= 'body .' . $block_class . '.aligncenter{' . $aligncenter . '}';

			if ( emulsion_the_theme_supports( 'alignfull' ) ) {

				$result	 .= 'body .' . $block_class . '.alignwide{' . $alignwide . '}';
				$result	 .= '.emulsion-has-sidebar .' . $block_class . '.alignfull{' . $has_sidebar_alignfull . '}';
				$result	 .= '.emulsion-no-sidebar .' . $block_class . '.alignfull{' . $no_sidebar_alignfull . '}';
			}
		}

		return $css . emulsion_remove_spaces_from_css( $result );
	}

}
if ( ! function_exists( 'emulsion_get_third_party_block_classes' ) ) {

	function emulsion_get_third_party_block_classes() {
		global $post;


		if ( empty( $post ) ) {
			return;
		}

		$blocks	 = parse_blocks( $post->post_content );
		$result	 = array();

		foreach ( $blocks as $block ) {

			if ( ! isset( $block['blockName'] ) ) {
				continue;
			}

			$block_id = $block['blockName'];

			if ( false === strpos( $block_id, 'core/' ) ) {

				$block_id = rtrim( $block_id, '*' );

				$class_name = sprintf( 'wp-block-%1$s', str_replace( '/', '-', $block_id ) );

				$result[] = sanitize_html_class( $class_name );
			}
		}
		return $result;
	}

}


if ( ! function_exists( 'emulsion_add_common_font_css' ) ) {

	function emulsion_add_common_font_css( $css ) {
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $css;
		}

		$pre_filter = apply_filters( 'emulsion_add_common_font_css_pre', false );

		if ( false !== $pre_filter ) {

			return $css . $pre_filter;
		}

		$transient_name = __FUNCTION__;

		if ( is_customize_preview() ) {

			delete_transient( $transient_name );
		}


		$transient_val = get_transient( $transient_name );

		if ( false !== ( $transient_val ) && ! is_user_logged_in() ) {

			return $css . $transient_val;
		}

		$inline_style = emulsion_sanitize_css( $css );

		if ( function_exists( 'emulsion_get_var' ) ) {

			$font_google_family_url	 = get_theme_mod( 'emulsion_common_google_font_url', emulsion_get_var( 'emulsion_common_google_font_url' ) );
			$fallback_font_family	 = get_theme_mod( 'emulsion_common_font_family', emulsion_get_var( 'emulsion_common_font_family' ) );
			$font_size				 = get_theme_mod( 'emulsion_common_font_size', emulsion_get_var( 'emulsion_common_font_size' ) );

			$font_family = ! empty( $font_google_family_url ) ? emulsion_get_google_font_family_from_url( $font_google_family_url, $fallback_font_family ) : $fallback_font_family;
		} else {
			$font_google_family_url	 = emulsion_theme_default_val( 'emulsion_common_google_font_url' );
			$fallback_font_family	 = emulsion_theme_default_val( 'emulsion_common_font_family' );
			$font_size				 = emulsion_theme_default_val( 'emulsion_common_font_size' );

			$font_family = $fallback_font_family;
		}

		$inline_style	 .= <<<CSS
			:root{
				font-family:$font_family;

			}
			.font-common-$fallback_font_family{
				font-family:$font_family;

			}
CSS;
		$inline_style	 = emulsion_sanitize_css( $inline_style );
		$inline_style	 = emulsion_remove_spaces_from_css( $inline_style );
		set_transient( $transient_name, $inline_style, 60 * 60 * 24 );

		return $css . $inline_style;
	}

}
if ( ! function_exists( 'emulsion_heading_font_css' ) ) {

	function emulsion_heading_font_css( $css ) {
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $css;
		}
		$pre_filter = apply_filters( 'emulsion_heading_font_css_pre', false );

		if ( false !== $pre_filter ) {

			return $css . $pre_filter;
		}



		$transient_name = __FUNCTION__;

		if ( is_customize_preview() ) {

			delete_transient( $transient_name );
		}

		$transient_val = get_transient( $transient_name );

		if ( false !== ( $transient_val ) && ! is_user_logged_in() ) {

			return $css . $transient_val;
		}


		$inline_style = emulsion_sanitize_css( $css );

		if ( function_exists( 'emulsion_get_var' ) ) {

			$font_google_family_url	 = get_theme_mod( 'emulsion_heading_google_font_url', emulsion_get_var( 'emulsion_heading_google_font_url' ) );
			$font_family			 = get_theme_mod( 'emulsion_heading_font_family', emulsion_get_var( 'emulsion_heading_font_family' ) );
			$font_scale				 = get_theme_mod( 'emulsion_heading_font_scale', emulsion_get_var( 'emulsion_heading_font_scale' ) );
			$heading_font_base		 = get_theme_mod( 'emulsion_heading_font_base', emulsion_get_var( 'emulsion_heading_font_base' ) );
			$font_weight			 = get_theme_mod( 'emulsion_heading_font_weight', emulsion_get_var( 'emulsion_heading_font_weight' ) );
			$text_transform			 = get_theme_mod( 'emulsion_heading_font_transform', emulsion_get_var( 'emulsion_heading_font_transform' ) );

			$font_google_family_url_meta = get_theme_mod( 'emulsion_widget_meta_google_font_url', emulsion_get_var( 'emulsion_widget_meta_google_font_url' ) );
			$font_family_meta			 = get_theme_mod( 'emulsion_widget_meta_font_family', emulsion_get_var( 'emulsion_widget_meta_font_family' ) );
			$heading_font_base_meta		 = get_theme_mod( 'emulsion_widget_meta_font_size', emulsion_get_var( 'emulsion_widget_meta_font_size' ) );
			$font_weight_meta			 = get_theme_mod( 'emulsion_heading_font_weight', emulsion_get_var( 'emulsion_heading_font_weight' ) );
			$text_transform_meta		 = get_theme_mod( 'emulsion_widget_meta_font_transform', emulsion_get_var( 'emulsion_widget_meta_font_transform' ) );
			$font_family_meta			 = get_theme_mod( 'emulsion_widget_meta_font_family', emulsion_theme_default_val( 'emulsion_widget_meta_font_family' ) );

			$fallback_font_family = get_theme_mod( 'emulsion_common_font_family', emulsion_get_var( 'emulsion_common_font_family' ) );
		} else {

			$font_google_family_url	 = emulsion_theme_default_val( 'emulsion_heading_google_font_url' );
			$font_scale				 = emulsion_theme_default_val( 'emulsion_heading_font_scale' );
			$heading_font_base		 = emulsion_theme_default_val( 'emulsion_heading_font_base' );
			$font_weight			 = emulsion_theme_default_val( 'emulsion_heading_font_weight' );
			$text_transform			 = emulsion_theme_default_val( 'emulsion_heading_font_transform' );
			$font_family			 = emulsion_theme_default_val( 'emulsion_heading_font_family' );

			$font_google_family_url_meta = emulsion_theme_default_val( 'emulsion_widget_meta_google_font_url' );
			$font_family_meta			 = emulsion_theme_default_val( 'emulsion_widget_meta_font_family' );
			$heading_font_base_meta		 = emulsion_theme_default_val( 'emulsion_widget_meta_font_size' );
			$font_weight_meta			 = emulsion_theme_default_val( 'emulsion_heading_font_weight' );
			$text_transform_meta		 = emulsion_theme_default_val( 'emulsion_widget_meta_font_transform' );
			$font_family_meta			 = emulsion_theme_default_val( 'emulsion_widget_meta_font_family' );

			$fallback_font_family = emulsion_theme_default_val( 'emulsion_common_font_family' );
		}

		if ( 'xx' == $font_scale ) {
			$h6		 = $heading_font_base * 0.6875 . 'px';
			$h5		 = $heading_font_base * 0.8125 . 'px';
			$h4		 = $heading_font_base * 1 . 'px';
			$h3		 = $heading_font_base * 1.17 . 'px';  // H3
			$h2		 = $heading_font_base * 1.4 . 'px';   // H2
			$h1		 = $heading_font_base * 2 . 'px';   // H1
			// meta font
			$h6_meta = $heading_font_base_meta * 0.6875 . 'px';
			$h5_meta = $heading_font_base_meta * 0.8125 . 'px';
			$h4_meta = $heading_font_base_meta * 1 . 'px';
			$h3_meta = $heading_font_base_meta * 1.17 . 'px';  // H3
			$h2_meta = $heading_font_base_meta * 1.4 . 'px';   // H2
			$h1_meta = $heading_font_base_meta * 2 . 'px';   // H1
		}
		if ( 'xxx' == $font_scale ) {
			$h6	 = $heading_font_base * 0.6875 . 'px';
			$h5	 = $heading_font_base * 0.8125 . 'px';
			$h4	 = $heading_font_base * 1 . 'px';
			$h3	 = $heading_font_base * 1.5 . 'px';  // H3
			$h2	 = $heading_font_base * 2 . 'px';   // H2
			$h1	 = $heading_font_base * 3 . 'px';   // H1

			$h6_meta = $heading_font_base_meta * 0.6875 . 'px';
			$h5_meta = $heading_font_base_meta * 0.8125 . 'px';
			$h4_meta = $heading_font_base_meta * 1 . 'px';
			$h3_meta = $heading_font_base_meta * 1.5 . 'px';  // H3
			$h2_meta = $heading_font_base_meta * 2 . 'px';   // H2
			$h1_meta = $heading_font_base_meta * 3 . 'px';   // H1
		}

		if ( function_exists( 'emulsion_get_google_font_family_from_url' ) ) {

			if ( ! empty( $font_google_family_url ) ) {

				$font_family = emulsion_get_google_font_family_from_url( $font_google_family_url, $fallback_font_family );
			}
			if ( ! empty( $font_google_family_url_meta ) ) {

				$font_family_meta = emulsion_get_google_font_family_from_url( $font_google_family_url_meta, $fallback_font_family_meta );
			}
		}

		$inline_style	 .= <<<CSS
				/* emulsion_heading_font_css */
		:root{
			--thm_heading_font_base:{$heading_font_base};
		}
		body.font-heading-{$fallback_font_family} .h6,
		body.font-heading-{$fallback_font_family} .h5,
		body.font-heading-{$fallback_font_family} .h4,
		body.font-heading-{$fallback_font_family} h6,
		body.font-heading-{$fallback_font_family} h5,
		body.font-heading-{$fallback_font_family} h4{
			font-family:{$font_family};
			font-weight:{$font_weight};
			text-transform:$text_transform;
		}
		body.font-heading-{$fallback_font_family} .entry-title,
		body.font-heading-{$fallback_font_family} .h1,
		body.font-heading-{$fallback_font_family} h1,
		body.font-heading-{$fallback_font_family} .h2,
		body.font-heading-{$fallback_font_family} h2,
		body.font-heading-{$fallback_font_family} .h3,
		body.font-heading-{$fallback_font_family} h3{
			font-family:{$font_family};
			font-weight:{$font_weight};
			text-transform:{$text_transform};
		}
		body.font-heading-{$fallback_font_family} aside .h6,
		body.font-heading-{$fallback_font_family} aside .h5,
		body.font-heading-{$fallback_font_family} aside .h4,
		body.font-heading-{$fallback_font_family} aside h6,
		body.font-heading-{$fallback_font_family} aside h5,
		body.font-heading-{$fallback_font_family} aside h4{
			font-family:{$font_family_meta};
			font-weight:{$font_weight_meta};
			text-transform:{$text_transform_meta};
		}
		body.font-heading-{$fallback_font_family} aside .entry-title,
		body.font-heading-{$fallback_font_family} aside .h1,
		body.font-heading-{$fallback_font_family} aside h1,
		body.font-heading-{$fallback_font_family} aside .h2,
		body.font-heading-{$fallback_font_family} aside h2,
		body.font-heading-{$fallback_font_family} aside .h3,
		body.font-heading-{$fallback_font_family} aside h3{
			font-family:{$font_family_meta};
			font-weight:{$font_weight_meta};
			text-transform:{$text_transform_meta};
		}

		body.font-heading-{$fallback_font_family} .h1,
		body.font-heading-{$fallback_font_family} h1{
			font-size:{$h1};

		}
		body.font-heading-{$fallback_font_family} .h2,
		body.font-heading-{$fallback_font_family} h2{
			font-size:{$h2};
		}
		body.font-heading-{$fallback_font_family} .h3,
		body.font-heading-{$fallback_font_family} h3{
			font-size:{$h3};
		}
		body.font-heading-{$fallback_font_family} .h4,
		body.font-heading-{$fallback_font_family} h4{
			font-size:{$h4};
		}
		body.font-heading-{$fallback_font_family} .h5,
		body.font-heading-{$fallback_font_family} h5{
			font-size:{$h5};
		}
		body.font-heading-{$fallback_font_family} .h6,
		body.font-heading-{$fallback_font_family} h6{
			font-size:{$h6};
		}

		body.font-heading-{$fallback_font_family} aside .h1,
		body.font-heading-{$fallback_font_family} aside h1{
			font-size:{$h1_meta};

		}
		body.font-heading-{$fallback_font_family} aside .h2,
		body.font-heading-{$fallback_font_family} aside h2{
			font-size:{$h2_meta};
		}
		body.font-heading-{$fallback_font_family} aside .h3,
		body.font-heading-{$fallback_font_family} adide h3{
			font-size:{$h3_meta};
		}
		body.font-heading-{$fallback_font_family} aside .h4,
		body.font-heading-{$fallback_font_family} aside h4{
			font-size:{$h4_meta};
		}
		body.font-heading-{$fallback_font_family} aside .h5,
		body.font-heading-{$fallback_font_family} aside h5{
			font-size:{$h5_meta};
		}
		body.font-heading-{$fallback_font_family} aside .h6,
		body.font-heading-{$fallback_font_family} aside h6{
			font-size:{$h6_meta};
		}

		@media screen and ( max-width : 640px ) {

			body.font-heading-{$fallback_font_family} .h1,
			body.font-heading-{$fallback_font_family} h1{
				font-size:{$h2};

			}
			body.font-heading-{$fallback_font_family} .page-wrapper article header .entry-title,
			body.font-heading-{$fallback_font_family} .h2,
			body.font-heading-{$fallback_font_family} h2{
				font-size:{$h3};
			}
			body.font-heading-{$fallback_font_family} .h4,
			body.font-heading-{$fallback_font_family} h4,
			body.font-heading-{$fallback_font_family} .h3,
			body.font-heading-{$fallback_font_family} h3{
				font-size:var(--thm_common_font_size);
			}
			body.font-heading-{$fallback_font_family} .h5,
			body.font-heading-{$fallback_font_family} h5{
				font-size:{$h5};
			}
			body.font-heading-{$fallback_font_family} .h6,
			body.font-heading-{$fallback_font_family} h6{
				font-size:{$h6};
			}
		}
CSS;
		$inline_style	 = emulsion_sanitize_css( $inline_style );
		$inline_style	 = emulsion_remove_spaces_from_css( $inline_style );

		set_transient( $transient_name, $inline_style, 60 * 60 * 24 );
		return $css . $inline_style;
	}

}

/**
 * Scheme filters
 */

add_filter( 'theme_mod_background_color', 'emulsion_background_color_filter' );

function emulsion_background_color_filter( $color ) {

	if ( function_exists( 'emulsion_the_theme_supports' ) && ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $color;
	}

	if ( 'ffffff' !== $color && function_exists( 'emulsion_get_var' ) ) {

		return $color;
	}

	if ( ! empty( $scheme = get_theme_mod( 'emulsion_scheme' ) ) ) {

		$result = ! empty( emulsion_theme_scheme[$scheme]['background_color'] ) ? emulsion_theme_scheme[$scheme]['background_color'] : 'ffffff';

		return ltrim( $result, '#' );
	}

	return $color;
}

add_filter( 'theme_mod_emulsion_header_background_color', 'emulsion_header_background_color_filter' );

function emulsion_header_background_color_filter( $color ) {
	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $color;
	}

	if ( ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $color;
	}

	if ( ! empty( $scheme = get_theme_mod( 'emulsion_scheme' ) ) && empty( $color ) ) {

		$result = ! empty( emulsion_theme_scheme[$scheme]['emulsion_header_background_color'] ) ? emulsion_theme_scheme[$scheme]['emulsion_header_background_color'] : '#eeeeee';

		return get_theme_mod( 'emulsion_header_background_color', $result );
	}

	return $color;
}

add_filter( 'theme_mod_emulsion_sidebar_background', 'emulsion_sidebar_background_filter' );

function emulsion_sidebar_background_filter( $color ) {

	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $color;
	}

	if ( ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $color;
	}

	if ( ! empty( $scheme = get_theme_mod( 'emulsion_scheme' ) ) && empty( $color ) ) {

		$result = ! empty( emulsion_theme_scheme[$scheme]['emulsion_sidebar_background'] ) ? emulsion_theme_scheme[$scheme]['emulsion_sidebar_background'] : '#ffffff';

		return get_theme_mod( 'emulsion_sidebar_background', $result );
	}

	return $color;
}

add_filter( 'theme_mod_emulsion_relate_posts_bg', 'emulsion_relate_posts_bg_filter' );

function emulsion_relate_posts_bg_filter( $color ) {

	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $color;
	}

	if ( function_exists( 'emulsion_the_theme_supports' ) && ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $color;
	}

	if ( ! empty( $scheme = get_theme_mod( 'emulsion_scheme' ) ) && empty( $color ) ) {

		$result = ! empty( emulsion_theme_scheme[$scheme]['emulsion_relate_posts_bg'] ) ? emulsion_theme_scheme[$scheme]['emulsion_relate_posts_bg'] : '#eeeeee';

		return get_theme_mod( 'emulsion_relate_posts_bg', $result );
	}

	return $color;
}

add_filter( 'theme_mod_emulsion_comments_bg', 'emulsion_comments_bg_filter' );

function emulsion_comments_bg_filter( $color ) {

	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $color;
	}

	if ( function_exists( 'emulsion_the_theme_supports' ) && ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $color;
	}

	if ( ! empty( $scheme = get_theme_mod( 'emulsion_scheme' ) ) && empty( $color ) ) {

		$result = ! empty( emulsion_theme_scheme[$scheme]['emulsion_comments_bg'] ) ? emulsion_theme_scheme[$scheme]['emulsion_comments_bg'] : '#eeeeee';

		return get_theme_mod( 'emulsion_comments_bg', $result );
	}

	return $color;
}

add_filter( 'theme_mod_emulsion_border_global', 'emulsion_border_global_filter' );

function emulsion_border_global_filter( $color ) {
	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $color;
	}

	if ( function_exists( 'emulsion_get_var' ) ) {

		return $color;
	}
	if ( function_exists( 'emulsion_the_theme_supports' ) && ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $color;
	}

	if ( ! empty( $scheme = get_theme_mod( 'emulsion_scheme' ) ) && empty( $color ) ) {

		$result = ! empty( emulsion_theme_scheme[$scheme]['emulsion_border_global'] ) ? emulsion_theme_scheme[$scheme]['emulsion_border_global'] : '#eeeeee';

		return get_theme_mod( 'emulsion_border_global', $result );
	}

	return $color;
}

add_filter( 'theme_mod_emulsion_border_sidebar', 'emulsion_border_sidebar_filter' );

function emulsion_border_sidebar_filter( $color ) {
	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $color;
	}

	if ( function_exists( 'emulsion_get_var' ) ) {

		return $color;
	}
	if ( function_exists( 'emulsion_the_theme_supports' ) && ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $color;
	}

	if ( ! empty( $scheme = get_theme_mod( 'emulsion_scheme' ) ) && empty( $color ) ) {

		$result = ! empty( emulsion_theme_scheme[$scheme]['emulsion_border_sidebar'] ) ? emulsion_theme_scheme[$scheme]['emulsion_border_sidebar'] : '#eeeeee';

		return get_theme_mod( 'emulsion_border_sidebar', $result );
	}

	return $color;
}

add_filter( 'theme_mod_emulsion_border_grid', 'emulsion_border_grid_filter' );

function emulsion_border_grid_filter( $color ) {

	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $color;
	}

	if ( function_exists( 'emulsion_get_var' ) ) {

		return $color;
	}
	if ( function_exists( 'emulsion_the_theme_supports' ) && ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $color;
	}

	if ( ! empty( $scheme = get_theme_mod( 'emulsion_scheme' ) ) && empty( $color ) ) {

		$result = ! empty( emulsion_theme_scheme[$scheme]['emulsion_border_grid'] ) ? emulsion_theme_scheme[$scheme]['emulsion_border_grid'] : '#eeeeee';

		return $result;
	}

	return $color;
}

add_filter( 'theme_mod_emulsion_border_stream', 'emulsion_border_stream_filter' );

function emulsion_border_stream_filter( $color ) {

	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $color;
	}

	if ( function_exists( 'emulsion_get_var' ) ) {

		return $color;
	}
	if ( function_exists( 'emulsion_the_theme_supports' ) && ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $color;
	}

	if ( ! empty( $scheme = get_theme_mod( 'emulsion_scheme' ) ) && empty( $color ) ) {

		$result = ! empty( emulsion_theme_scheme[$scheme]['emulsion_border_stream'] ) ? emulsion_theme_scheme[$scheme]['emulsion_border_stream'] : '#eeeeee';

		return $result;
	}

	return $color;
}

add_filter( 'theme_mod_emulsion_primary_menu_background', 'emulsion_primary_menu_background_filter' );

function emulsion_primary_menu_background_filter( $color ) {

	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $color;
	}

	if ( function_exists( 'emulsion_get_var' ) ) {

		return $color;
	}
	if ( function_exists( 'emulsion_the_theme_supports' ) && ! emulsion_the_theme_supports( 'scheme' ) ) {

		return $color;
	}

	if ( ! empty( $scheme = get_theme_mod( 'emulsion_scheme' ) ) && empty( $color ) ) {

		$result = ! empty( emulsion_theme_scheme[$scheme]['emulsion_primary_menu_background'] ) ? emulsion_theme_scheme[$scheme]['emulsion_primary_menu_background'] : '#ffffff';

		return $result;
	}

	return $color;
}

if ( 'daybreak' == get_theme_mod( 'emulsion_scheme' ) ||
		'bloging' == get_theme_mod( 'emulsion_scheme' ) ||
		'boilerplate' == get_theme_mod( 'emulsion_scheme' ) ) {

	add_filter( 'theme_mod_emulsion_title_in_header', 'emulsion_scheme_daybreak_filter' );

	function emulsion_scheme_daybreak_filter( $val ) {

		return 'no';
	}

}

if ( 'boilerplate' == get_theme_mod( 'emulsion_scheme' ) ) {

	add_filter( 'emulsion_the_theme_supports', 'emulsion_boilerplate', 10, 2 );

	if ( function_exists( 'emulsion_get_var' ) ) {

		emulsion_remove_supports( 'enqueue' );
	}

	function emulsion_boilerplate( $val, $name ) {

		false === wp_style_is( 'emulsion' ) ? wp_enqueue_style( 'emulsion' ) : '';
		if ( 'enqueue' == $name ) {

			return false;
		}
		return $val;
	}

}
