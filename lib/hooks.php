<?php
add_action( 'after_switch_theme', 'emulsion_minimum_php_version_check' );
add_action( 'after_setup_theme', 'emulsion_hooks_setup' );

function emulsion_hooks_setup() {

	add_action( 'wp_head', 'emulsion_meta_elements' );//c
	add_action( 'wp_head', 'emulsion_pingback_header' );//c
	add_action( 'wp_body_open', 'emulsion_skip_link' );//c
	add_filter( 'get_the_archive_title', 'emulsion_archive_title_filter' );
	add_filter( 'the_title', 'emulsion_empty_the_title_fallback' );//c
	add_filter( 'the_content', 'emulsion_entry_content_filter', 11 );//c
	add_filter( 'embed_oembed_html', 'emulsion_oembed_filter', 99, 4 );//c
	add_filter( 'do_shortcode_tag', 'emulsion_shortcode_tag_filter', 99, 4 );
	add_filter( 'the_password_form', 'emulsion_get_the_password_form', 11 );
	add_filter( 'oembed_default_width', 'emulsion_oembed_default_width', 99 );
	add_filter( 'emulsion_lazyload_script', 'emulsion_lazyload' );
	add_filter( 'emulsion_instantclick_script', 'emulsion_instantclick' );
	add_filter( 'script_loader_tag', 'emulsion_disable_instantclick', 10, 3 );
	add_filter( 'emulsion_toc_script', 'emulsion_toc' );
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
/**
 * Viewport
 */
if ( ! function_exists( 'emulsion_meta_elements' ) ) {

	function emulsion_meta_elements() {
		if ( emulsion_the_theme_supports( 'enqueue' ) ) {
			?><meta name="viewport" content="width=device-width, initial-scale=1" id="emulsion-viewport" />
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
				$('article .has-post-image,.wp-block-cover').each(function (index) {
					var text = $(this).attr('style');
					$(this).attr('data-src', text);
					$(this).addClass('lazyload');
					});

					$('img.lazyload').lazyload();
					$('article .has-post-image').lazyload();

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
if ( ! function_exists( 'emulsion_disable_instantclick' ) ) {

	function emulsion_disable_instantclick( $tag, $handle, $src ) {

		$support = emulsion_the_theme_supports( 'instantclick' );

		if ( 'emulsion-instantclick-js' === $handle && $support ) {
			$tag = str_replace( 'src=', 'data-no-instant src=', $tag );
		}
		return $tag;
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
if ( ! function_exists( 'emulsion_the_excerpt_embed' ) ) {

	/**
	 * The summary sentence is displayed in five lines.
	 * @param type $excerpt_text
	 * @since 1.09 line nuber changed from 2 to 5
	 */
	function emulsion_the_excerpt_embed( $excerpt_text ) {

		$excerpt_text = strip_tags( $excerpt_text );

		printf( '<p style="font-size:13px;max-height:calc(1em * 1.5 * 5);overflow:hidden;">%1$s</p>', wp_kses_post( $excerpt_text ) );
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

if ( ! function_exists( 'emulsion_inline_style_filter' ) ) {

	function emulsion_inline_style_filter( $style ) {

		if ( defined( 'WPSCSS_PLUGIN_DIR' ) ) {
			return $style;
		}
		// ignone default color
		$header_text_color = get_theme_mod( 'header_textcolor', false );

		if ( ! empty( $header_text_color ) && ctype_xdigit( $header_text_color ) ) {
			////varidate hex color value
			//$header_text_color  = sanitize_hex_color( $header_text_color );
			$style .= '
		div.header-layer .entry-text,
		div.header-layer .entry-text a,
		div.header-layer .site-description,
		div.header-layer .site-title .site-title-text,
		div.header-layer .header-text a{ color:#' . $header_text_color . ';}';
		}

		$style = emulsion_sanitize_css( $style );

		return $style;
	}

}
if ( ! function_exists( 'emulsion_term_duplicate_link_hide' ) ) {

	function emulsion_term_duplicate_link_hide( $css ) {

		$css = emulsion_sanitize_css( $css );

		$term_link = esc_url( get_category_link( 1 ) );

		if ( is_category() || is_tag() ) {
			/**
			 * Hide same term link each post
			 */
			$term_id = get_queried_object_id();

			if ( is_category() ) {
				$term_link	 = esc_url( get_category_link( $term_id ) );
				$css		 .= '.post-categories a[href="' . $term_link . '"]{display:none;} ';
			}
			if ( is_tag() ) {
				$term_link	 = esc_url( get_term_link( $term_id ) );
				$css		 .= '.post-tag a[href="' . $term_link . '"]{display:none;} ';
			}
		}

		return $css;
	}

}

if ( ! function_exists( 'emulsion_empty_the_title_fallback' ) ) {

	function emulsion_empty_the_title_fallback( $title ) {

		if ( empty( $title ) ) {
			return esc_html__( '...', 'emulsion' );
		}
		return $title;
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
				$('article .has-post-image,.wp-block-cover').each(function (index) {
					var text = $(this).attr('style');
					$(this).attr('data-src', text);
					$(this).addClass('lazyload');
					});

					$('img.lazyload').lazyload();
					$('article .has-post-image').lazyload();

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
if ( ! function_exists( 'emulsion_disable_instantclick' ) ) {

	function emulsion_disable_instantclick( $tag, $handle, $src ) {
		
		if( function_exists('emulsion_get_supports') ) {
			
			$support = emulsion_get_supports( 'instantclick' );
		} else {
			$support = false;
		}	
			if ( 'emulsion-instantclick-js' === $handle && $support ) {
				$tag = str_replace( 'src=', 'data-no-instant src=', $tag );
			}
			return $tag;

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