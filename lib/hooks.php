<?php
add_action( 'after_switch_theme', 'emulsion_minimum_php_version_check' );
add_action( 'after_setup_theme', 'emulsion_hooks_setup' );

function emulsion_hooks_setup() {

	do_action( 'emulsion_hooks_setup_before' );

	add_filter( 'body_class', 'emulsion_body_class' );
	add_filter( 'body_class', 'emulsion_body_background_class' );
	add_action( 'wp_head', 'emulsion_meta_elements' );
	add_action( 'wp_head', 'emulsion_pingback_header' );
	add_action( 'wp_body_open', 'emulsion_skip_link' );
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
	add_filter('the_excerpt', 'emulsion_excerpt_remove_p');
	
	/**
	 * Scripts
	 */
	false === emulsion_is_amp()
			? add_filter( 'emulsion_inline_script', 'emulsion_get_rest' )
			: '';
	true === emulsion_the_theme_supports('lazyload')
			? add_filter( 'emulsion_lazyload_script', 'emulsion_lazyload' )
			: '';
	true === emulsion_the_theme_supports('instantclick')
			? add_filter( 'emulsion_instantclick_script', 'emulsion_instantclick' )
			: '';

	true === emulsion_the_theme_supports('toc')
			? add_filter( 'emulsion_toc_script', 'emulsion_toc' )
			: '';

	if( ! emulsion_theme_addons_exists() ) {

	/**
	 * Theme Style
	 */
		add_filter('emulsion_inline_style', 'emulsion_theme_styles' );

	/**
	 * CJK language ( CJK unified ideographs ) issue instant fix
	 * For languages that do not use single-byte spaces,
	 * solve the problem of string overflow in the_excerpt ()
	 */
		add_filter('get_the_excerpt', 'emulsion_force_excerpt');


	/**
	 * Data validations
	 */
		add_filter('emulsion_the_site_title', 'ent2ncr');
		add_filter('emulsion_site_text_markup_self', 'ent2ncr');
		add_filter('emulsion_site_text_markup', 'ent2ncr');
		add_filter('emulsion_the_post_title', 'ent2ncr');
		add_filter('emulsion_the_post_meta_on', 'ent2ncr');
		add_filter('emulsion_the_post_meta_in', 'ent2ncr');
		add_filter('emulsion_archive_year_navigation', 'ent2ncr');
		add_filter('emulsion_monthly_archive_prev_next_navigation', 'ent2ncr');
		add_filter('emulsion_footer_text', 'ent2ncr');
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
			return $manifest;
		}

	}
	
	

	//JSON-LD add desscription
	add_filter( 'amp_post_template_metadata', 'emulsion_amp_description', 10, 2 );
	


	do_action( 'emulsion_hooks_setup_after' );
}

if ( ! function_exists( 'emulsion_minimum_php_version_check' ) ) {

	function emulsion_minimum_php_version_check() {

		if ( version_compare( PHP_VERSION, EMULSION_MIN_PHP_VERSION, '<' ) ) {

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

		if ( is_page() ) {

			unset( $classes['emulsion-no-sidebar'] );
			unset( $classes['emulsion-has-sidebar'] );

			$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_page_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_page_sidebar' ) );
			$logged_in				 = 'logged_in_user' == $sidebar_condition && ! is_user_logged_in() ? false : true;
			$metabox_page_control	 = emulsion_metabox_display_control( 'page_sidebar' );

			$classes[] = is_active_sidebar( 'sidebar-3' ) &&
					emulsion_the_theme_supports( 'sidebar_page' ) &&
					$logged_in &&
					$metabox_page_control ? 'emulsion-has-sidebar' : 'emulsion-no-sidebar';
		} else {

			unset( $classes['emulsion-no-sidebar'] );
			unset( $classes['emulsion-has-sidebar'] );

			$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_posts_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_posts_sidebar' ) );
			$logged_in				 = 'logged_in_user' == $sidebar_condition && ! is_user_logged_in() ? false : true;
			$metabox_post_control	 = emulsion_metabox_display_control( 'sidebar' );

			$classes[] = is_active_sidebar( 'sidebar-1' ) &&
					emulsion_the_theme_supports( 'sidebar' ) &&
					$logged_in &&
					$metabox_post_control ? 'emulsion-has-sidebar' : 'emulsion-no-sidebar';
		}

		if( get_theme_support( 'align-wide' ) ) {

			$classes[] = 'enable-alignfull';
		}
		
		if ( emulsion_the_theme_supports( 'block_experimentals' ) && emulsion_is_plugin_active( 'gutenberg/gutenberg.php' ) ) {
			
			$classes[] = 'enable-block-experimentals';
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

		printf( '<div class="%1$s"><a href="%2$s" class="%3$s" title="%4$s">%5$s</a></div>', 'skip-link',
				esc_url( $skip_link_url ),
				'screen-reader-text',
				esc_attr__( 'Skip to content', 'emulsion' ),
				esc_html__( 'Skip to content', 'emulsion' )
		);
	}

}

function emulsion_archive_title_filter( $title ) {

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
			$script	 = "jQuery('.toc').siblings('#toc-toggle, label').remove();\n"; // for browser back issue
			$script	 .= "jQuery('.toc').toc({'scrollToOffset':84, 'container':'main','anchorName': function(i, heading, prefix) { return prefix+'-'+i;},}).before('<input type=\"checkbox\" id=\"toc-toggle\" name=\"toc-toggle\" data-skin=\"inset\" /><label for=\"toc-toggle\"  title=\"" . esc_attr__( 'TOC', 'emulsion' ) . "\"><span></span><i class=\"toc-text screen-reader-text\">TOC</i></label>');";

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
		$replace_pairs	 = array(
			'emulsion_header_background_color'		 => '--thm_header_bg_color',
			'emulsion_heading_font_transform'		 => '--thm_heading-font-transform',
			'emulsion_widget_meta_font_size'		 => '--thm_data_font_size',
			'emulsion_widget_meta_font_family'		 => '--thm_meta_data_font_family',
			'emulsion_widget_meta_font_transform'	 => '--thm_meta_data_font_transform',
			'emulsion_sidebar_background'			 => '--thm_sidebar_bg_color',
		);

		$css_variable = strtr( $theme_mod_name, $replace_pairs );
		$css_variable = str_replace('emulsion', '--thm', $css_variable );

		return $css_variable . ':' . emulsion_theme_default_val( $theme_mod_name, 'unit_val' ) . ';';
	}

}

if ( ! function_exists( 'emulsion_theme_styles' ) ) {

	function emulsion_theme_styles( $css ) {

		$variables				 = false !== get_theme_mod( 'emulsion__css_variables' ) 
				? get_theme_mod( 'emulsion__css_variables' ) 
				: '';
		$responsive_break_point	 = emulsion_theme_default_val( 'emulsion_content_width' ) + emulsion_theme_default_val( 'emulsion_sidebar_width' ) + emulsion_theme_default_val( 'emulsion_common_font_size' );
		$responsive_break_point	 = absint( $responsive_break_point );
		$background_color		 = ! empty( sanitize_hex_color_no_hash( get_background_color() ) )
				? 'background:'. sanitize_hex_color( sprintf('#%1$s', get_background_color() ) )
				: '';
		$header_textcolor		 = ! empty( sanitize_hex_color_no_hash( get_header_textcolor() ) )
				? 'color:'. sanitize_hex_color( sprintf('#%1$s', get_header_textcolor() ) )
				: '';
	

		$customize_saved =<<< CUSTOMIZED_CSS
				
{$variables}
.emulsion-addons-inactive body{
	{$background_color};
}
.emulsion-addons-inactive body > header.header-layer .site-description,
.emulsion-addons-inactive body body > header.header-layer .site-title-link{
	{$header_textcolor};
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

    &:focus {
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
}
.emulsion-addons-inactive .page-wrapper article header .entry-meta .cat-item a:hover {
   color: var(--thm_general_link_hover_color);
}
.emulsion-addons-inactive body  .grid article header.show-post-image:before{
	top:0;
}
.emulsion-addons-inactive div.page-wrapper .grid .article-wrapper article header{
	background:rgba(188,188,188,.2);
}
@media screen and (max-width: {$responsive_break_point}px) {
	.emulsion-addons-inactive body body.emulsion-has-sidebar .alignfull{
		width:100vw;
	}
}
CUSTOMIZED_CSS;

		$result	 = emulsion_sanitize_css( $customize_saved );
		$result	 = emulsion_remove_spaces_from_css( $result );
		return $css. $result;

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

		$language		 = get_locale();
		$non_space_lang	 = array( "zh-HK", "zh-TW", "zh-CN", "ko-KR", "ja" );

		if ( in_array( $language, $non_space_lang ) ) {

			$length = absint( emulsion_theme_default_val( 'emulsion_excerpt_length' ) );

			return wp_html_excerpt( $excerpt, $length, '' );
		}
		return $excerpt;
	}

}

if ( ! function_exists( 'emulsion_get_rest' ) ) {

	function emulsion_get_rest($script){

	$script .=<<<SCRIPT

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
		$language		 = get_locale();
		$non_space_lang	 = array( "zh-HK", "zh-TW", "zh-CN", "ko-KR", "ja" );

		if ( in_array( $language, $non_space_lang ) ) {

			return absint( emulsion_theme_default_val( 'emulsion_excerpt_length' ) );
		} else {

			return 55;
		}
	}

}


if ( ! function_exists( 'emulsion_customizer_controls_script' ) ) {

	function emulsion_customizer_controls_script(){

		$plugin_install_url	 = esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=all' ) );
		$message			 = sprintf( '<p>%1$s</p><a href="%2$s">%3$s</a>',
								esc_html__( 'You can use the emulsion-addons plugin for further customization.', 'emulsion' ),
								esc_url( $plugin_install_url ),
								esc_html__( 'Install Plugin', 'emulsion' )
		);

		$script =<<<SCRIPT

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
function emulsion_excerpt_remove_p($excerpt){
	
	if( ! emulsion_theme_addons_exists() ){
		
		return strip_tags($excerpt);
	}
	return $excerpt;
}
}
