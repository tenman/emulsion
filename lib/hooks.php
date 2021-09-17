<?php
add_action( 'after_switch_theme', 'emulsion_minimum_php_version_check' );
add_action( 'after_setup_theme', 'emulsion_hooks_setup' );

function emulsion_hooks_setup() {

	do_action( 'emulsion_hooks_setup_before' );

	add_filter( 'body_class', 'emulsion_body_class' );
	add_filter( 'admin_body_class', 'emulsion_block_editor_class' );
	add_filter( 'body_class', 'emulsion_body_background_class' );


	add_action( 'wp_head', 'emulsion_meta_elements' );
	add_action( 'wp_head', 'emulsion_pingback_header' );
	'fse' !== get_theme_mod( 'emulsion_editor_support' ) ? add_action( 'wp_body_open', 'emulsion_skip_link' ) : '';
	add_filter( 'get_the_archive_title', 'emulsion_archive_title_filter' );
	add_filter( 'the_title', 'emulsion_empty_the_title_fallback' );
	add_filter( 'the_content', 'emulsion_entry_content_filter', 11 );
	add_filter( 'embed_oembed_html', 'emulsion_oembed_filter', 99, 4 );
	add_filter( 'do_shortcode_tag', 'emulsion_shortcode_tag_filter', 99, 4 );
	add_filter( 'the_password_form', 'emulsion_get_the_password_form', 11 );
	add_filter( 'oembed_default_width', 'emulsion_oembed_default_width', 99 );
	add_filter( 'excerpt_length', 'emulsion_excerpt_length_with_lang', 99 );
	add_action( 'customize_controls_enqueue_scripts', 'emulsion_customizer_controls_script' );
	add_action( 'customize_controls_enqueue_scripts', 'emulsion_customizer_controls_style' );
	add_filter( 'theme_templates', 'emulsion_theme_templates' );
	add_filter( 'the_excerpt', 'emulsion_excerpt_remove_p' );
	add_filter( 'gettext_with_context_default', 'emulsion_change_translate', 99, 4 );
	add_filter( 'the_content_more_link', 'emulsion_read_more_link' );
	add_filter( 'navigation_markup_template', 'emulsion_remove_role_from_pagination' );

	add_filter( 'get_header_image_tag', 'emulsion_amp_add_layout_attribute' );
	add_filter( 'get_the_archive_description', 'wpautop' );
	add_action( 'wp_enqueue_scripts', 'emulsion_not_support_presentation_page_link' );
	add_filter( 'body_class', 'emulsion_remove_custom_background_class' );
	add_filter( 'wp_img_tag_add_loading_attr', 'emulsion_skip_loading_lazy_image', 10, 3 );
	/**
	 * Block editor notation
	 */
	if ( function_exists( 'do_blocks' ) ) {

		add_action( 'theme_mod_emulsion_header_html', 'do_blocks' );
		add_action( 'theme_mod_emulsion_footer_credit', 'do_blocks' );
	}
	//Post title cannot be displayed in header when html template is loaded
	'html' == get_theme_mod( 'emulsion_header_template' ) ? add_filter( 'theme_mod_emulsion_title_in_header', function($yesno) {
						return 'no';
					} ) : '';

	add_filter( 'excerpt_allowed_blocks', 'emulsion_excerpt_allowed_blocks' );
	/**
	 * Scripts
	 */
	//false === emulsion_is_amp() ? add_filter( 'emulsion_inline_script', 'emulsion_get_rest' ) : '';
	add_action( 'wp', static function () {
		if ( false === emulsion_is_amp() ) {
			add_filter( 'emulsion_inline_script', 'emulsion_get_rest' );
		}
	} );

	true === emulsion_the_theme_supports( 'lazyload' ) ? add_filter( 'emulsion_lazyload_script', 'emulsion_lazyload' ) : '';
	true === emulsion_the_theme_supports( 'instantclick' ) ? add_filter( 'emulsion_instantclick_script', 'emulsion_instantclick' ) : '';

	true === emulsion_the_theme_supports( 'toc' ) ? add_filter( 'emulsion_toc_script', 'emulsion_toc' ) : '';

	add_filter( 'render_block_core/list', function( $content ) {

		// Change static contents to dinamic contents

		if ( strstr( $content, 'emulsion-block-pattern-relate-posts' ) ) {

			$template_path = get_template_directory() . '/block-patterns/block-pattern-relate-posts.php';

			return include( $template_path );
		}
		return $content;
	} );

	if ( ! emulsion_theme_addons_exists() ) {

		remove_shortcode( 'emulsion_relate_posts' );

		add_filter( 'render_block_core/shortcode', function($content) {

			if ( '[emulsion_relate_posts]' == trim( strip_tags( $content ) ) ) {

				return;
			}
			return $content;
		} );



		/**
		 * CJK language ( CJK unified ideographs ) issue instant fix
		 * For languages that do not use single-byte spaces,
		 * solve the problem of string overflow in the_excerpt ()
		 */
		add_filter( 'get_the_excerpt', 'emulsion_force_excerpt' );


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

		if ( function_exists( 'wp_scss_compile' ) ) {
			add_filter( 'wp_scss_variables', 'emulsion_wp_scss_set_variables_fallback' );
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

	//JSON-LD add desscription
	if ( defined( 'AMP_VERSION' ) && version_compare( AMP_VERSION, '2.1.2', '>=' ) ) {

		add_filter( 'amp_post_template_metadata', 'emulsion_amp_description', 10, 2 );
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

		if ( true === emulsion_the_theme_supports( 'title_in_page_header' ) ) {

			$title_in_header = get_theme_mod( "emulsion_title_in_header", emulsion_theme_default_val( 'emulsion_title_in_header' ) );
			// fse needs this
			if ( 'yes' == $title_in_header ) {

				$classes[] = 'emulsion-header-has-title';
			}
			if ( 'no' == $title_in_header ) {

				$classes[] = 'emulsion-layout-no-title';
			}
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



		if ( get_theme_support( 'align-wide' ) ) {

			$classes[] = 'enable-alignfull';
		}

		if ( emulsion_the_theme_supports( 'block_experimentals' ) && emulsion_is_plugin_active( 'gutenberg/gutenberg.php' ) ) {

			$classes[] = 'enable-block-experimentals';
		}

		$classes[] = emulsion_theme_addons_exists() || get_theme_mod( 'emulsion_border_global' ) || get_theme_mod( 'emulsion_border_global_style' ) || get_theme_mod( 'emulsion_border_global_width' ) ? 'has-border-custom' : 'border-default';

		$classes[]	 = 'noscript';
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

		if ( has_blocks() ) {

			$classes[] = 'has-block';
		} else {

			$classes[] = 'no-block';
		}

		if ( emulsion_the_theme_supports( 'full_site_editor' ) && emulsion_do_fse() ) {

			$classes[] = 'emulsion-fse-active';

			// A compromised setting as I can't find an easy way to determine if the template is excerpt or post content
			$classes[] = 'full_text';
		}
		/**
		 * Font family class
		 */
		$heading_font_family = get_theme_mod( 'emulsion_heading_font_family', emulsion_theme_default_val( 'emulsion_heading_font_family' ) );

		$classes[] = sanitize_html_class( 'font-heading-' . $heading_font_family );

		if ( function_exists( 'emulsion_get_css_variables_values' ) ) {

			$common_font_family = emulsion_get_css_variables_values( 'common_font_family' );
		} else {

			$common_font_family = emulsion_theme_default_val( 'emulsion_common_font_family' );
		}

		$classes[] = sanitize_html_class( 'font-common-' . $common_font_family );

		if ( 'transitional' == filter_input( INPUT_GET, 'fse' ) ) {

			$classes[] = 'is-presentation-transitional';
		} elseif ( 'off' == filter_input( INPUT_GET, 'fse' ) ) {

			$classes[] = 'is-presentation-theme';
		} else {

			$classes[] = sanitize_html_class( 'is-presentation-' . get_theme_mod( 'emulsion_editor_support', 'theme' ) );
		}
		// current template

		$classes[] = 'is-tpl-' . emulsion_get_template();

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
if ( ! function_exists( 'emulsion_oembed_filter' ) ) {

	function emulsion_oembed_filter( $html, $url, $attr, $post_ID ) {
		global $is_IE, $post;
		/**
		 * Filtered by Oembed with TinyMCE
		 */
		if ( ! $is_IE ) {

			$html = str_replace( 'frameborder="0"', '', $html );
		}

		$element					 = 'figure';
		$not_exists_gutenberg_class	 = 'wp-block-embed__wrapper';
		$repair_style				 = '';
		$type						 = 'oembed-object';

		if ( function_exists( 'has_blocks' ) && has_blocks( $post_ID ) || isset( $post ) && preg_match( '$wp-block-embed__wrapper$', $post->post_content ) ) {
			// preg_match( '$wp-block-embed__wrapper$'... detect gutenberg post when gutenberg is not exists
			$not_exists_gutenberg_class = '';

			return $html;
		}

		return emulsion_oembed_object_wrapper( $html, $url, $type );
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

if ( ! function_exists( 'emulsion_oembed_object_wrapper' ) ) {

	/**
	 * Not Block editor embed media wrapper
	 */
	function emulsion_oembed_object_wrapper( $html, $url, $type = '' ) {

		/**
		 * Reason not to divert Gutenberg's class
		 * Because the structure of html is different
		 */
		$element					 = 'div';
		$not_exists_gutenberg_class	 = 'wp-block-embed__wrapper';
		if ( empty( $type ) ) {

			$not_exists_gutenberg_class	 .= ' ';
			$not_exists_gutenberg_class	 .= sanitize_html_class( $type );
		}
		$repair_style = '';

		/**
		 * https://www.instagram.com/
		 */
		if ( preg_match( '!(instagram.com)!', $url ) ) {
			return sprintf( '<div class="emulsion-instagram clearfix">%1$s</div>', $html );
		}

		/**
		 * https://www.reverbnation.com/
		 */
		if ( preg_match( '!(reverbnation.com)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-reverbnation clearfix"><div>%1$s</div></%2$s>', $html, $element );
		}

		/*
		 * https://speakerd.s3.amazonaws.com/presentations/50021f75cf1db900020005e7/slide_0.jpg?1362165300
		 */

		if ( preg_match( '!(speakerdeck.com|speakerd)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-ratio-075 emulsion-speakerdeck clearfix"><div>%1$s</div></%2$s>', $html, $element );
		}

		/*
		 * https://www.slideshare.net/slideshow/embed_code/7306301
		 */

		if ( preg_match( '!(slideshare.net)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-slideshare clearfix %3$s" %4$s><div>%1$s</div></%2$s>', $html, $element, $not_exists_gutenberg_class, $repair_style );
		}

		/*
		 * https://www.mixcloud.com/
		 */

		if ( preg_match( '!(mixcloud.com)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-mixcloud clearfix %3$s" %4$s><div>%1$s</div></%2$s>', $html, $element, $not_exists_gutenberg_class, $repair_style );
		}

		/**
		 * https://www.reddit.com/
		 */
		if ( preg_match( '!(reddit.com)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-reddit clearfix"><div>%1$s</div></%2$s>', $html, $element );
		}

		/**
		 * https://www.screencast.com/
		 * @since 1.480
		 */
		if ( preg_match( '!(screencast.com)!', $url ) ) {
			return sprintf( '<%2$s class="emulsion-screencast clearfix"><div>%1$s</div></%2$s>', $html, $element );
		}

		/**
		 * note: 4:3 ratio can use .emulsion-ratio-075
		 */
		if ( ! preg_match( '!(twitter.com|tumblr.com|speakerdeck)!', $url ) && ! preg_match( '!(wp-embedded-content)!', $html ) ) {
			return sprintf( '<%2$s class="clearfix %3$s" %4$s>%1$s</%2$s>', $html, $element, $not_exists_gutenberg_class, $repair_style );
		}

		return $html;
	}

}


if ( ! function_exists( 'emulsion_get_the_password_form' ) ) {

	/**
	 * Password post form
	 * @global type $post
	 * @param type $post
	 * @return type
	 */
	function emulsion_get_the_password_form( $output ) {
		global $post;

		if ( ! isset( $post ) ) {
			return $output;
		}

		$form_html = '<div class="theme-message aligncenter"><form action="%1$s" class="post-password-form" method="post">
	<p class="message" id="%7$s">%2$s</p>
	<p class="fields">
		<label for="%3$s" class="screen-reader-text">%4$s</label>
		<input name="post_password" id="%3$s" type="password" size="20" placeholder="%5$s" aria-required="true" aria-label="%5$s" aria-describedby="%7$s" required />
		<input type="submit" name="Submit" value="%6$s" />
	</p>
	</form></div>';

		$post_id			 = absint( $post->ID );
		$label				 = 'pwbox-' . ( empty( $post_id ) ? rand() : $post_id );
		// @since 1.1.6 change from pwbox- to password-box-. Duplicate id attribute
		$aria_describedby	 = 'password-box-' . ( empty( $post_id ) ? rand() : $post_id );
		$label_text			 = __( 'Password:', 'emulsion' );
		$url				 = esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) );
		$submit_text		 = esc_attr_x( 'Enter', 'post password form', 'emulsion' );
		$message			 = esc_html__( 'This content is password protected.', 'emulsion' );
		$message			 .= '<wbr />';
		$message			 .= esc_html__( 'To view it please enter your password below:', 'emulsion' );
		$placeholder		 = esc_html__( 'Password', 'emulsion' );

		$form = sprintf( $form_html, $url, $message, $label, $label_text, $placeholder, $submit_text, $aria_describedby );

		return $form;
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
if ( ! function_exists( 'emulsion_instantclick' ) ) {

	function emulsion_instantclick( $script ) {

		$support = emulsion_the_theme_supports( 'instantclick' );

		if ( $support && 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_admin() ) {
			$script = "InstantClick.init();";

			return $script;
		}

		return $script;
	}

}


if ( ! function_exists( 'emulsion_toc' ) ) {

	function emulsion_toc( $script ) {
		$support = emulsion_the_theme_supports( 'toc' );

		if ( $support ) {
			$script = "jQuery('.menu-placeholder .toc, .wp-site-blocks .toc').siblings('#toc-toggle, label').remove();\n"; // for browser back issue

			$script .= "jQuery('.menu-placeholder .toc').toc({'scrollToOffset':84, 'container':'main','anchorName': function(i, heading, prefix) { return prefix+'-'+i;},}).before('<input type=\"checkbox\" id=\"toc-toggle\" name=\"toc-toggle\" data-skin=\"inset\" /><label for=\"toc-toggle\"  title=\"" . esc_attr__( 'TOC', 'emulsion' ) . "\"><span></span><i class=\"toc-text screen-reader-text\">TOC</i></label>');";

			$script .= "jQuery('.wp-site-blocks .toc').toc({'scrollToOffset':5, 'container':'main','anchorName': function(i, heading, prefix) { return prefix+'-'+i;},})";

			return $script;
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

if ( ! function_exists( 'emulsion_instantclick' ) ) {

	function emulsion_instantclick( $script ) {

		$support = emulsion_the_theme_supports( 'instantclick' );

		if ( $support && 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_admin() ) {
			$script = "InstantClick.init();";

			return $script;
		}

		return $script;
	}

}

if ( ! function_exists( 'emulsion_toc' ) ) {

	function emulsion_toc( $script ) {

		$support = emulsion_the_theme_supports( 'toc' );

		if ( $support ) {
			$script	 = "jQuery('.toc').siblings('#toc-toggle, label').remove();\n"; // for browser back issue
			$script	 .= "jQuery('.toc').toc({'scrollToOffset':84, 'container':'main','anchorName': function(i, heading, prefix) { return prefix+'-'+i;},}).before('<input type=\"checkbox\" id=\"toc-toggle\" name=\"toc-toggle\" data-skin=\"inset\" /><label for=\"toc-toggle\"  title=\"" . esc_html__( 'TOC', 'emulsion' ) . "\"><span></span><i class=\"toc-text screen-reader-text\">TOC</i></label>');";

			return $script;
		}

		return $script;
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

		$variables = false !== get_theme_mod( 'emulsion__css_variables' ) ? get_theme_mod( 'emulsion__css_variables' ) : '';

		$responsive_break_point	 = emulsion_theme_default_val( 'emulsion_content_width' ) + emulsion_theme_default_val( 'emulsion_sidebar_width' ) + emulsion_theme_default_val( 'emulsion_common_font_size' );
		$responsive_break_point	 = absint( $responsive_break_point );


		/* hide uncategorized category */
		$uncagegorized_hide_style = absint( get_category_by_slug( 'uncategorized' )->term_id ) == absint( get_option( 'default_category' ) ) ? '#document .cat-item-1{display:none;}' : '';



		$customize_saved = <<< CUSTOMIZED_CSS

{$variables}
/* @see emulsion_theme_styles */
{$uncagegorized_hide_style}

.emulsion-addons-inactive .excerpt .article-wrapper{
	border-bottom-color:var(--thm_common_border);
	border-bottom-style:var(--thm_border_global_style);
	border-bottom-width:var(--thm_border_global_width);
}

.emulsion-addons-inactive aside h1{
	line-height:var(--thm_common_line_height, 1.15);
}
.emulsion-addons-inactive .header-layer{
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
	max-width:var(--thm_content_width);
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
	padding-left: var(--thm_content_gap);
    padding-right: var(--thm_content_gap);
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

if ( ! function_exists( 'emulsion_sanitize_css' ) ) {

	/**
	 * CSS sanitize
	 */
	function emulsion_sanitize_css( $css ) {

		/**
		 *
		 * Please add filter style sanitize code. if need
		 *
		 */
		return wp_strip_all_tags( $css );
	}

}
if ( ! function_exists( 'emulsion_force_excerpt' ) ) {

	function emulsion_force_excerpt( $excerpt ) {

		if ( emulsion_lang_cjk() ) {

			$length = absint( emulsion_theme_default_val( 'emulsion_excerpt_length' ) );

			return wp_html_excerpt( $excerpt, $length, '' );
		}
		return $excerpt;
	}

}

if ( ! function_exists( 'emulsion_get_rest' ) ) {

	function emulsion_get_rest( $script ) {

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

		if ( is_customize_preview() && ! emulsion_theme_addons_exists() && current_user_can( 'edit_theme_options' ) ) {

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

		$post_id	 = get_the_ID();
		$title_text	 = the_title_attribute(
				array( 'before' => esc_html__( 'link to ', 'emulsion' ),
					'echo'	 => false, )
		);

		if ( is_int( $post_id ) ) {

			return sprintf(
					'<p class="read-more"><a class="skin-button" href="%1$s" aria-label="%3$s">%2$s<span class="screen-reader-text read-more-context">%3$s</span></a></p>', get_permalink(), esc_html__( 'Read more', 'emulsion' ), $title_text
			);
		}
	}

}

if ( ! function_exists( 'emulsion_block_editor_class' ) ) {

	function emulsion_block_editor_class( $classes ) {

		global $wp_version;
		$block_editor_class_name = '';
		/**
		 * gutengerg7.2 html structure changed
		 * The editor style implemented in 5.0-core cannot control block styles after GB7.2.
		 * Need to add style for new editor structure and keep style for old structure
		 * Add a new body class to allow the theme to control the editor style
		 */
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

	$css_variables	 = get_theme_mod( 'emulsion__css_variables', false );

	$wp_css_status	 = get_theme_mod( 'emulsion_wp_scss_status' );

	if ( emulsion_is_amp() && 'active' !== $wp_css_status && ! empty( $css_variables ) ) {
		$css .= $css_variables;
	}
	return $css;
}

if ( ! function_exists( 'emulsion_add_third_party_block_css' ) ) {

	function emulsion_add_third_party_block_css( $css ) {

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
	width:calc( 50% - var(--thm_content_gap) - var(--thm_common_font_size) );
    max-width:calc( 50% - var(--thm_content_gap) - var(--thm_common_font_size) );
    margin-right:var(--thm_common_font_size);
    margin-left:var(--thm_content_gap);
    margin-top:1.5rem;
    margin-bottom:.75rem;
ALIGN_LEFT;
		$alignright				 = <<<ALIGN_RIGHT
    box-sizing:border-box;
    clear:right;
    float:right;
	width:calc( 50% - var(--thm_content_gap) - var(--thm_common_font_size) );
    max-width:calc( 50% - var(--thm_content_gap) - var(--thm_common_font_size) );
    margin-left:var(--thm_content_gap);
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
    width:calc( var(--thm_content_width) - var(--thm_align_offset) );
    max-width:100%;
    margin:1.5rem auto .75rem;
ALIGN_CENTER;
		$alignwide				 = <<<ALIGN_WIDE
    width:calc( var(--thm_content_width) + var(--thm_align_offset) );
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

if ( ! function_exists( 'emulsion_theme_google_tracking_code' ) ) {

	function emulsion_theme_google_tracking_code() {

		$tag			 = sanitize_text_field( get_theme_mod( 'emulsion_google_analytics_tracking_code' ) );
		$flag			 = get_theme_mod( 'emulsion_instantclick', emulsion_the_theme_supports( 'instantclick' ) ) ? 'enable' : 'disable';
		$theme_mod_name	 = 'emulsion_google_analytics_' . $tag . $flag;

		if ( $result = get_theme_mod( $theme_mod_name, false ) ) {

			echo $result;
			return;
		}
	}

}

if ( ! function_exists( 'emulsion_not_support_presentation_page_link' ) ) {

	function emulsion_not_support_presentation_page_link() {

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

function emulsion_excerpt_allowed_blocks( $allowed_blocks ) {

	if ( ! in_array( 'core/group', $allowed_blocks, true ) ) {

		$allowed_blocks[] = 'core/group';
	}

	return $allowed_blocks;
}

if ( ! function_exists( 'emulsion_add_common_font_css' ) ) {

	function emulsion_add_common_font_css( $css ) {

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
		} else {
			$font_google_family_url	 = emulsion_theme_default_val( 'emulsion_common_google_font_url' );
			$fallback_font_family	 = emulsion_theme_default_val( 'emulsion_common_font_family' );
			$font_size				 = emulsion_theme_default_val( 'emulsion_common_font_size' );
		}

		if ( function_exists( 'emulsion_get_google_font_family_from_url' ) && ! empty( $font_google_family_url ) ) {

			$font_family = emulsion_get_google_font_family_from_url( $font_google_family_url, $fallback_font_family );
		} else {

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
			$fallback_font_family	 = get_theme_mod( 'emulsion_heading_font_family', emulsion_get_var( 'emulsion_heading_font_family' ) );
			$font_scale				 = get_theme_mod( 'emulsion_heading_font_scale', emulsion_get_var( 'emulsion_heading_font_scale' ) );
			$heading_font_base		 = get_theme_mod( 'emulsion_heading_font_base', emulsion_get_var( 'emulsion_heading_font_base' ) );

			$font_google_family_url_meta = get_theme_mod( 'emulsion_widget_meta_google_font_url', emulsion_get_var( 'emulsion_widget_meta_google_font_url' ) );
			$fallback_font_family_meta	 = get_theme_mod( 'emulsion_widget_meta_font_family', emulsion_get_var( 'emulsion_widget_meta_font_family' ) );
			$heading_font_base_meta		 = get_theme_mod( 'emulsion_widget_meta_font_size', emulsion_get_var( 'emulsion_widget_meta_font_size' ) );
		} else {

			$font_google_family_url	 = emulsion_theme_default_val( 'emulsion_heading_google_font_url' );
			$fallback_font_family	 = emulsion_theme_default_val( 'emulsion_heading_font_family' );
			$font_scale				 = emulsion_theme_default_val( 'emulsion_heading_font_scale' );
			$heading_font_base		 = emulsion_theme_default_val( 'emulsion_heading_font_base' );

			$font_google_family_url_meta = emulsion_theme_default_val( 'emulsion_widget_meta_google_font_url' );
			$fallback_font_family_meta	 = emulsion_theme_default_val( 'emulsion_widget_meta_font_family' );
			$heading_font_base_meta		 = emulsion_theme_default_val( 'emulsion_widget_meta_font_size' );
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
		if ( function_exists( 'emulsion_get_var' ) ) {

			$font_weight = get_theme_mod( 'emulsion_heading_font_weight', emulsion_get_var( 'emulsion_heading_font_weight' ) );

			$text_transform = get_theme_mod( 'emulsion_heading_font_transform', emulsion_get_var( 'emulsion_heading_font_transform' ) );

			$font_weight_meta	 = get_theme_mod( 'emulsion_heading_font_weight', emulsion_get_var( 'emulsion_heading_font_weight' ) );
			$text_transform_meta = get_theme_mod( 'emulsion_widget_meta_font_transform', emulsion_get_var( 'emulsion_widget_meta_font_transform' ) );
		} else {
			$font_weight			 = emulsion_theme_default_val( 'emulsion_heading_font_weight' );
			$text_transform			 = emulsion_theme_default_val( 'emulsion_heading_font_transform' );
			$fallback_font_family	 = emulsion_theme_default_val( 'emulsion_heading_font_family' );

			$font_weight_meta			 = emulsion_theme_default_val( 'emulsion_heading_font_weight' );
			$text_transform_meta		 = emulsion_theme_default_val( 'emulsion_widget_meta_font_transform' );
			$fallback_font_family_meta	 = emulsion_theme_default_val( 'emulsion_widget_meta_font_family' );
		}

		if ( function_exists( 'emulsion_get_google_font_family_from_url' ) && ! empty( $font_google_family_url ) ) {

			$font_family = emulsion_get_google_font_family_from_url( $font_google_family_url, $fallback_font_family );

			$font_family_meta = emulsion_get_google_font_family_from_url( $font_google_family_url_meta, $fallback_font_family_meta );
		} else {

			$font_family = $fallback_font_family;

			$font_family_meta = $fallback_font_family_meta;
		}

		$inline_style	 .= <<<CSS
		body.font-heading-$fallback_font_family .h6,
		body.font-heading-$fallback_font_family .h5,
		body.font-heading-$fallback_font_family .h4,
		body.font-heading-$fallback_font_family h6,
		body.font-heading-$fallback_font_family h5,
		body.font-heading-$fallback_font_family h4{
			font-family:$font_family;
			font-weight:$font_weight;
			text-transform:$text_transform;
		}
		body.font-heading-$fallback_font_family .entry-title,
		body.font-heading-$fallback_font_family .h1,
		body.font-heading-$fallback_font_family h1,
		body.font-heading-$fallback_font_family .h2,
		body.font-heading-$fallback_font_family h2,
		body.font-heading-$fallback_font_family .h3,
		body.font-heading-$fallback_font_family h3{
			font-family:$font_family;
			font-weight:$font_weight;
			text-transform:$text_transform;
		}
		body.font-heading-$fallback_font_family aside .h6,
		body.font-heading-$fallback_font_family aside .h5,
		body.font-heading-$fallback_font_family aside .h4,
		body.font-heading-$fallback_font_family aside h6,
		body.font-heading-$fallback_font_family aside h5,
		body.font-heading-$fallback_font_family aside h4{
			font-family:$font_family_meta;
			font-weight:$font_weight_meta;
			text-transform:$text_transform_meta;
		}
		body.font-heading-$fallback_font_family aside .entry-title,
		body.font-heading-$fallback_font_family aside .h1,
		body.font-heading-$fallback_font_family aside h1,
		body.font-heading-$fallback_font_family aside .h2,
		body.font-heading-$fallback_font_family aside h2,
		body.font-heading-$fallback_font_family aside .h3,
		body.font-heading-$fallback_font_family aside h3{
			font-family:$font_family_meta;
			font-weight:$font_weight_meta;
			text-transform:$text_transform_meta;
		}

		body.font-heading-$fallback_font_family .h1,
		body.font-heading-$fallback_font_family h1{
			font-size:{$h1};

		}
		body.font-heading-$fallback_font_family .h2,
		body.font-heading-$fallback_font_family h2{
			font-size:{$h2};
		}
		body.font-heading-$fallback_font_family .h3,
		body.font-heading-$fallback_font_family h3{
			font-size:{$h3};
		}
		body.font-heading-$fallback_font_family .h4,
		body.font-heading-$fallback_font_family h4{
			font-size:{$h4};
		}
		body.font-heading-$fallback_font_family .h5,
		body.font-heading-$fallback_font_family h5{
			font-size:{$h5};
		}
		body.font-heading-$fallback_font_family .h6,
		body.font-heading-$fallback_font_family h6{
			font-size:{$h6};
		}

		body.font-heading-$fallback_font_family aside .h1,
		body.font-heading-$fallback_font_family aside h1{
			font-size:{$h1_meta};

		}
		body.font-heading-$fallback_font_family aside .h2,
		body.font-heading-$fallback_font_family aside h2{
			font-size:{$h2_meta};
		}
		body.font-heading-$fallback_font_family aside .h3,
		body.font-heading-$fallback_font_family adide h3{
			font-size:{$h3_meta};
		}
		body.font-heading-$fallback_font_family aside .h4,
		body.font-heading-$fallback_font_family aside h4{
			font-size:{$h4_meta};
		}
		body.font-heading-$fallback_font_family aside .h5,
		body.font-heading-$fallback_font_family aside h5{
			font-size:{$h5_meta};
		}
		body.font-heading-$fallback_font_family aside .h6,
		body.font-heading-$fallback_font_family aside h6{
			font-size:{$h6_meta};
		}

		@media screen and ( max-width : 640px ) {

			body.font-heading-$fallback_font_family .h1,
			body.font-heading-$fallback_font_family h1{
				font-size:{$h2};

			}
			body.font-heading-$fallback_font_family .page-wrapper article header .entry-title,
			body.font-heading-$fallback_font_family .h2,
			body.font-heading-$fallback_font_family h2{
				font-size:{$h3};
			}
			body.font-heading-$fallback_font_family .h4,
			body.font-heading-$fallback_font_family h4,
			body.font-heading-$fallback_font_family .h3,
			body.font-heading-$fallback_font_family h3{
				font-size:var(--thm_common_font_size);
			}
			body.font-heading-$fallback_font_family .h5,
			body.font-heading-$fallback_font_family h5{
				font-size:{$h5};
			}
			body.font-heading-$fallback_font_family .h6,
			body.font-heading-$fallback_font_family h6{
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