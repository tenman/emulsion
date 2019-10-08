<?php
add_action( 'after_switch_theme', 'emulsion_test_for_min_php' );
add_action( 'after_setup_theme', 'emulsion_hooks_setup' );
add_action( 'widgets_init', 'emulsion_unregister_default_widgets', 11);

function emulsion_hooks_setup() {

	add_action( 'tgmpa_register', 'emulsion_theme_register_required_plugins' );

	add_action( 'wp_head', 'emulsion_meta_elements' );
	add_action( 'wp_head', 'emulsion_pingback_header' );
	add_action( 'wp_body_open', 'emulsion_skip_link' );
	add_filter( 'wp_resource_hints', 'emulsion_resource_hints', 10, 2 );
	add_filter( 'body_class', 'emulsion_body_class' );
	add_filter( 'emulsion_inline_style', 'emulsion_styles' );
	
	$wp_scss_status = get_theme_mod( 'emulsion_wp_scss_status' );
	
	if ( 'active' !== $wp_scss_status ) {
		add_action( 'wp_ajax_emulsion_tiny_mce_css_variables', 'emulsion_tiny_mce_css_variables_callback' );
	}
	add_action( 'widgets_init', 'emulsion_widgets_init' );
	add_filter( 'wp_list_categories', 'emulsion_category_link_format', 10, 2 );
	add_filter( 'get_the_archive_title', 'emulsion_archive_title_filter' );
	add_filter( 'the_title', 'emulsion_keyword_with_mark_elements_title', 99999 );
	add_filter( 'the_content', 'emulsion_entry_content_html_cleaner', 11 );
	add_filter( 'the_content', 'emulsion_keyword_with_mark_elements', 99999 );
	add_filter( 'get_the_excerpt', 'emulsion_get_the_excerpt_filter', 10, 2 );
	add_filter( 'embed_oembed_html', 'emulsion_oembed_filter', 99, 4 );
	add_filter( 'do_shortcode_tag', 'emulsion_shortcode_tag_filter', 99, 4 );
	add_filter( 'get_archives_link', 'emulsion_archive_link_format', 10, 6 );
	add_filter( 'the_content_more_link', 'emulsion_read_more_link' );
	add_action( 'edit_post_link', 'emulsion_custom_gutenberg_edit_link', 10, 3 );
	add_filter( 'emulsion_footer_text', 'capital_P_dangit', 11 );
	add_filter( 'emulsion_footer_text', 'wptexturize' );
	add_filter( 'emulsion_footer_text', 'convert_smilies', 20 );
	add_filter( 'emulsion_footer_text', 'wpautop' );
	add_action( 'emulsion_template_pre_index', 'emulsion_customizer_add_supports_excerpt' );
	add_filter( 'the_password_form', 'emulsion_get_the_password_form', 11 );
	add_filter( 'do_shortcode_tag', 'emulsion_shortcode_wrapper', 10, 4 );
	add_filter( 'emulsion_lazyload_script', 'emulsion_lazyload' );
	add_filter( 'emulsion_instantclick_script', 'emulsion_instantclick' );
	add_filter( 'script_loader_tag', 'emulsion_disable_instantclick', 10, 3 );
	add_filter( 'emulsion_toc_script', 'emulsion_toc' );
	add_filter( 'the_excerpt_embed', 'emulsion_the_excerpt_embed', 99 );
	add_filter( 'oembed_default_width', 'emulsion_oembed_default_width', 99 );
	add_filter( 'excerpt_length', 'emulsion_excerpt_length', 99 );
	add_filter( 'tiny_mce_before_init', 'emulsion_remove_verify_html', 10, 2 );
	add_filter( 'tiny_mce_before_init', 'emulsion_tiny_mce_before_init' );
	add_filter( 'admin_body_class', 'emulsion_admin_body_class' );
	add_filter( 'body_class', 'emulsion_brightness_class', 15 );
	add_filter( 'dynamic_sidebar_params', 'emulsion_footer_widget_params' );
	add_action( 'init', 'emulsion_plugins' );
}

if ( ! function_exists( 'emulsion_test_for_min_php' ) ) {

	function emulsion_test_for_min_php() {

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
		if ( emulsion_get_supports( 'enqueue' ) ) {
			?><meta name="viewport" content="width=device-width, initial-scale=1" id="emulsion-viewport" />
			<meta name="apple-mobile-web-app-capable" content="yes" />
			<meta name="apple-mobile-web-app-status-bar-style" content="default" /><?php
		}
	}

}
if ( ! function_exists( 'emulsion_pingback_header' ) ) {

	function emulsion_pingback_header() {
		if ( is_singular() && pings_open( get_queried_object() ) ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

}
if ( ! function_exists( 'emulsion_skip_link' ) ) {

	function emulsion_skip_link() {

		printf( '<div class="%1$s"><a href="%2$s" class="%3$s" title="%4$s">%5$s</a></div>', 'skip-link', '#main', 'screen-reader-text', esc_attr__( 'Skip to content', 'emulsion' ), esc_html__( 'Skip to content', 'emulsion' )
		);
	}

}
if ( ! function_exists( 'emulsion_resource_hints' ) ) {

	function emulsion_resource_hints( $urls, $relation_type ) {

		if ( ( wp_style_is( 'common-google-font', 'queue' ) ||
				wp_style_is( 'heading-google-font', 'queue' ) ||
				wp_style_is( 'widget-meta-google-font', 'queue' ) ) && 'preconnect' === $relation_type ) {

			$urls[] = array(
				'href' => 'https://fonts.googleapis.com/',
				'crossorigin',
			);
		}

		return $urls;
	}

}
if ( ! function_exists( 'emulsion_tiny_mce_css_variables_callback' ) ) {

	function emulsion_tiny_mce_css_variables_callback() {
		global $post;

		if ( isset( $post ) && function_exists('use_block_editor_for_post') && use_block_editor_for_post( $post ) ) {
			return;
		}

		$wp_scss_status = get_theme_mod( 'emulsion_wp_scss_status' );

		if ( 'active' !== $wp_scss_status ) {

			// css variables dinamic ( not active wp_scss plugin ) and classic editor
			header( "Content-type: text/css" );
			echo esc_html( emulsion__css_variables() );
			die();
		}
	}

}
/**
 * Widget
 */
if ( ! function_exists( 'emulsion_widgets_init' ) ) {

	function emulsion_widgets_init() {

		if ( emulsion_get_supports( 'sidebar' ) ) {

			register_sidebar( array(
				'name'			 => esc_html__( 'Post Sidebar', 'emulsion' ),
				'id'			 => 'sidebar-1',
				'description'	 => is_customize_preview() ? esc_html__( 'You can set the sidebar widget for post by displaying the post in preview.', 'emulsion' ) : '',
				'before_widget'	 => '<li id="%1$s" class="%2$s widget sidebar post-sidebar" tabindex="-1">',
				'after_widget'	 => "</li>\n",
				'before_title'	 => "\n\t<h2 class=\"widgettitle default\">",
				'after_title'	 => "</h2>\n",
				'widget_id'		 => 'default',
				'widget_name'	 => 'default',
				'text'			 => "1" )
			);
		}
		if ( emulsion_get_supports( 'footer' ) ) {

			register_sidebar( array(
				'name'			 => esc_html__( 'Post Footer', 'emulsion' ),
				'id'			 => 'sidebar-2',
				'description'	 => is_customize_preview() ? esc_html__( 'You can set the footer wigget for post by displaying the post in preview.', 'emulsion' ) : '',
				'before_widget'	 => '<li id="%1$s" class="%2$s widget footer post-footer" tabindex="-1">',
				'after_widget'	 => "</li>\n",
				'before_title'	 => "\n\t<h2 class=\"widgettitle post-footer\">",
				'after_title'	 => "</h2>\n",
				'widget_id'		 => 'extra',
				'widget_name'	 => 'extra',
				'text'			 => "2" )
			);
		}
		if ( emulsion_get_supports( 'sidebar_page' ) ) {

			register_sidebar( array(
				'name'			 => esc_html__( 'Page Sidebar', 'emulsion' ),
				'id'			 => 'sidebar-3',
				'description'	 => is_customize_preview() ? esc_html__( 'You can set the page sidebar widget for page by displaying the page in preview.', 'emulsion' ) : '',
				'before_widget'	 => '<li id="%1$s" class="%2$s widget sidebar-page" tabindex="-1">',
				'after_widget'	 => "</li>\n",
				'before_title'	 => "\n\t<h2 class=\"widgettitle sidebar-page\">",
				'after_title'	 => "</h2>\n",
				'widget_id'		 => 'sidebar-page',
				'widget_name'	 => 'sidebar-page',
				'text'			 => "3" )
			);
		}
		if ( emulsion_get_supports( 'footer_page' ) ) {

			register_sidebar( array(
				'name'			 => esc_html__( 'Page Footer', 'emulsion' ),
				'id'			 => 'sidebar-4',
				'description'	 => is_customize_preview() ? esc_html__( 'You can set the page footer widget for page by displaying the page in preview.', 'emulsion' ) : '',
				'before_widget'	 => '<li id="%1$s" class="%2$s widget footer page-footer" tabindex="-1">',
				'after_widget'	 => "</li>\n",
				'before_title'	 => "\n\t<h2 class=\"widgettitle page-footer\">",
				'after_title'	 => "</h2>\n",
				'widget_id'		 => 'footer-page',
				'widget_name'	 => 'footer-page',
				'text'			 => "4" )
			);
		}
	}

}
if ( ! function_exists( 'emulsion_category_link_format' ) ) {

	/**
	 * wrap the number of categories in span elements.
	 *
	 * @param type $output
	 * @param type $args
	 * @return type
	 */
	function emulsion_category_link_format( $output, $args ) {
		if ( is_page() && false == emulsion_metabox_display_control( 'page_style' ) ) {

			return $output;
		}
		if ( is_single() && false == emulsion_metabox_display_control( 'style' ) ) {

			return $output;
		}

		if ( ! emulsion_get_supports( 'enqueue' ) ) {

			return $output;
		}

		if ( isset( $args['show_count'] ) && ! empty( $args['show_count'] ) ) {

			return preg_replace( '!\(([0-9]+)\)!', "<span class=\"emulsion-cat-count\">$1</span>", $output );
		}

		return $output;
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


if ( ! function_exists( 'emulsion_entry_content_html_cleaner' ) ) {

	/**
	 *
	 * @param type $content
	 * @return type
	 */
	function emulsion_entry_content_html_cleaner( $content ) {

		$support = emulsion_get_supports( 'entry_content_html_cleaner' );

		if ( true !== $support ) {
			return $content;
		}

		$allblocks	 = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|h[1-6]|hr|fieldset|noscript|legend|section|article|aside|hgroup|header|footer|nav|figure|details|menu|summary)';
		$content	 = preg_replace( '!([^(<p>)]*)</p>(</' . $allblocks . '>)!', "$1$2", $content );
		$content	 = preg_replace( '!(<(select|del|option|canvas|mrow|svg|rect|optgroup) [^>]*>)(<br />|</p>)!', "$1", $content );
		$content	 = preg_replace( '!(</option>|</svg>|</figcaption>|<mrow>|<msup>|</msup>|</mi>|</mn>|</mrow>|</mo>|</rect>|</button>|</optgroup>|</select>)<br />!', "$1", $content );
		$content	 = preg_replace( '!<p>\s*(</?(ins|del|msup|input)[^>]*>)\s*</p>!', "$1", $content );
		$content	 = preg_replace( '!(</?(svg|msup|keygen|command|canvas|datalist|script)[^>]*>)\s*</p>!', "$1", $content );
		$content	 = preg_replace( '!(<p>)(</?(svg|msup|keygen|command|canvas|datalist|input)[^>]*>)!', "$2", $content );
		$content	 = preg_replace( '!(<p>[^<]*)(</' . $allblocks . '>)!', "$1</p>$2", $content );
		$content	 = preg_replace( '!(<' . $allblocks . '[^>]*>[^<]*)</p>!', "$1", $content );
		$content	 = preg_replace( '!(<' . $allblocks . '[^>]*>)([^(<|\s)]+)<p>!', "$1<p>$2</p>", $content );
		$content	 = str_replace( 'class="wp-caption-text"></p>', 'class="wp-caption-text">', $content );
		$content	 = preg_replace( '!<p>(<figure[^>]*>(.*)?</figure>)</p>!', "$1", $content );
		$content	 = preg_replace( '!<p>(<ruby[^>]*>(.*)?</ruby>)</p>!', "$1", $content );

		// decode url encoded text
		$content = preg_replace_callback( "|<a[^>]+>.*?(https?:\/\/[-_.!*\'()a-zA-Z0-9;\/?:@&=+$,%#]+).*?</a>|", "emulsion_link_url_text_decode", $content );
		return $content;
	}

}
if ( ! function_exists( 'emulsion_oembed_filter' ) ) {

	function emulsion_oembed_filter( $html, $url, $attr, $post_ID ) {
		global $is_IE, $post;
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
if ( ! function_exists( 'emulsion_archive_link_format' ) ) {

	/**
	 * wrap the number of tags in span elements.
	 *
	 * @param string $link_html
	 * @param type $url
	 * @param type $text
	 * @param type $format
	 * @param type $before
	 * @param type $after
	 * @return type
	 */
	function emulsion_archive_link_format( $link_html, $url, $text, $format,
			$before, $after ) {
		if ( is_page() && false == emulsion_metabox_display_control( 'page_style' ) ) {

			return $link_html;
		}
		if ( is_single() && false == emulsion_metabox_display_control( 'style' ) ) {

			return $link_html;
		}
		if ( ! emulsion_get_supports( 'enqueue' ) ) {

			return $link_html;
		}

		if ( $format == 'html' ) {

			$after = str_replace( array( '(', ')', '&nbsp;' ), '', $after );

			$link_html = '<li><a href="%1$s" class="emulsion-archive-link"><span class="emulsion-archive-date">%2$s</span></a>
<span class="emulsion-archive-count">%3$s</span></li>';

			return sprintf( $link_html, $url, $text, $after );
		}

		return $link_html;
	}

}
if ( ! function_exists( 'emulsion_read_more_link' ) ) {

	/**
	 *
	 * @return type
	 */
	function emulsion_read_more_link() {

		$post_id	 = get_the_ID();
		$title_text	 = the_title_attribute(
				array( 'before' => esc_html__( 'link to:', 'emulsion' ),
					'echo'	 => false, )
		);

		if ( is_int( $post_id ) ) {

			return sprintf(
					'<p class="read-more"><a class="skin-button" href="%1$s" aria-label="%3$s">%2$s<span class="screen-reader-text">%3$s</span></a></p>', get_permalink(), esc_html__( 'Read more', 'emulsion' ), $title_text
			);
		}
	}

}
if ( ! function_exists( 'emulsion_custom_gutenberg_edit_link' ) ) {

	/**
	 * Identify posts edited in the classic editor and posts edited in the block editor.
	 *
	 * Classic editor Plug-in dependent function
	 *
	 * @param type $link
	 * @param type $post_id
	 * @param type $text
	 * @return type
	 */
	function emulsion_custom_gutenberg_edit_link( $link, $post_id, $text ) {

		$which				 = get_post_meta( $post_id, 'classic-editor-remember', true );
		$allow_users_option	 = get_option( 'classic-editor-allow-users' );

		$emulsion_disallow_old_post_open_classic_editor = apply_filters( 'emulsion_disallow_old_post_open_classic_editor', false );

		if ( 'allow' == $allow_users_option ) {

			if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && 'classic-editor' == $which ) {

				$gutenberg_action = sprintf(
						'<a href="%1$s" class="skin-button">%2$s</a>', esc_url( add_query_arg(
										array( 'post' => $post_id, 'action' => 'edit', 'classic-editor' => '', 'classic-editor__forget' => '' ), admin_url( 'post.php' )
						) ), esc_html__( 'Classic Editor', 'emulsion' ) );

				return $gutenberg_action;
			}
		}
		if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && ! metadata_exists( 'post', $post_id, 'classic-editor-remember' ) && ! $emulsion_disallow_old_post_open_classic_editor ) {

			$gutenberg_action = sprintf(
					'<a href="%1$s" class="skin-button">%2$s</a>', esc_url( add_query_arg(
									array( 'post' => $post_id, 'action' => 'edit', 'classic-editor' => '', 'classic-editor__forget' => '' ), admin_url( 'post.php' )
					) ), esc_html__( 'Classic Editor', 'emulsion' ) );

			return $gutenberg_action;
		}

		return $link;
	}

}
if ( ! function_exists( 'emulsion_get_the_password_form' ) ) {

	/**
	 * Password post form
	 * @global type $post
	 * @param type $post
	 * @return type
	 */
	function emulsion_get_the_password_form( $post = 0 ) {
		global $post;

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
		$aria_describedby	 = 'pwbox-' . ( empty( $post_id ) ? rand() : $post_id );
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
if ( ! function_exists( 'emulsion_shortcode_wrapper' ) ) {

	/**
	 * Wrap short code with html element
	 * The purpose is to apply CSS style using classes included in short code.
	 * @param type $output
	 * @param type $tag
	 * @param type $attr
	 * @param type $m
	 * @return type
	 */
	function emulsion_shortcode_wrapper( $output, $tag, $attr, $m ) {

		$tag_class = sanitize_html_class( $tag );

		$output = sprintf( '<div class="shortcode-wrapper wrap-%2$s">%1$s</div>', $output, $tag_class );

		return $output;
	}

}
if ( ! function_exists( 'emulsion_lazyload' ) ) {

	function emulsion_lazyload( $script ) {

		$support = emulsion_get_supports( 'lazyload' );
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
		$support = emulsion_get_supports( 'instantclick' );

		if ( $support && 'wp-login.php' !== $GLOBALS['pagenow'] && ! is_admin() ) {
			$script = "InstantClick.init();";

			return $script;
		}

		return $script;
	}

}
if ( ! function_exists( 'emulsion_disable_instantclick' ) ) {

	function emulsion_disable_instantclick( $tag, $handle, $src ) {
		$support = emulsion_get_supports( 'instantclick' );
		if ( 'emulsion-instantclick-js' === $handle && $support ) {
			$tag = str_replace( 'src=', 'data-no-instant src=', $tag );
		}
		return $tag;
	}

}
if ( ! function_exists( 'emulsion_toc' ) ) {

	function emulsion_toc( $script ) {
		$support = emulsion_get_supports( 'toc' );

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
	 * The summary sentence is displayed in two lines.
	 * @param type $excerpt_text
	 */
	function emulsion_the_excerpt_embed( $excerpt_text ) {


		$excerpt_text = strip_tags( $excerpt_text );

		printf( '<p style="height:calc(1rem * 1.5 * 2);overflow:hidden">%1$s</p>', wp_kses_post( $excerpt_text ), 'trancate', '2' );
	}

}
if ( ! function_exists( 'emulsion_oembed_default_width' ) ) {

	/**
	 * Default width of oembed media
	 * @param type $width
	 * @return int
	 */
	function emulsion_oembed_default_width( $width ) {

		return 720;
	}

}
if ( ! function_exists( 'emulsion_excerpt_length' ) ) {

	/**
	 * get excerpt length
	 * @param type $length
	 * @return type
	 */
	function emulsion_excerpt_length( $length ) {

		$length = get_theme_mod( 'emulsion_excerpt_length', 256 );

		return absint( $length );
	}

}
if ( ! function_exists( 'emulsion_remove_verify_html' ) ) {

	function emulsion_remove_verify_html( $init, $block ) {

		if ( 'classic-block' == $block ) {
			$init['verify_html'] = false;
		}
		return $init;
	}

}
/**
 * Theme body class
 */
if ( ! function_exists( 'emulsion_admin_body_class' ) ) {

	function emulsion_admin_body_class( $classes ) {
		global $post;
		if ( isset( $post ) && use_block_editor_for_post( $post ) ) {

			$text_color							 = emulsion_contrast_color();
			$emulsion_post_theme_style_script	 = get_post_meta( absint( $post->ID ), 'emulsion_post_theme_style_script', true );
			$emulsion_page_theme_style_script	 = get_post_meta( absint( $post->ID ), 'emulsion_page_theme_style_script', true );

			if ( 'no_bg' !== $emulsion_post_theme_style_script && 'no_bg' !== $emulsion_page_theme_style_script ) {

				if ( '#ffffff' == $text_color ) {

					$emulsion_brightnes = ' is-dark is-dark-theme';
				}
				if ( '#333333' == $text_color ) {

					$emulsion_brightnes = ' is-light';
				}
			}
			if ( 'no_bg' == $emulsion_post_theme_style_script || 'no_bg' == $emulsion_page_theme_style_script ) {

				$default_bacckground = '#' . emulsion_get_supports( 'background' )[0]['default']['default-color'];
				$text_color			 = emulsion_contrast_color( $default_bacckground );

				if ( '#ffffff' == $text_color ) {

					$emulsion_brightnes = ' is-dark is-dark-theme';
				}
				if ( '#333333' == $text_color ) {

					$emulsion_brightnes = ' is-light';
				}
			}

			$colors_for_editor = get_theme_mod( 'emulsion_colors_for_editor', emulsion_get_var( 'emulsion_colors_for_editor' ) );

			if ( 'enable' == $colors_for_editor ) {

				$color_for_editor_class = ' emulsion-color-enable';
			} else {
				$color_for_editor_class = ' emulsion-color-disable';
			}

			$theme_classes	 = implode( ' ', emulsion_body_class( array() ) );
			$theme_classes	 = str_replace( array( 'noscript' ), '', $theme_classes );

			return $classes . $theme_classes . $emulsion_brightnes . $color_for_editor_class;
		}

		return $classes;
	}

}
if ( ! function_exists( 'emulsion_brightness_class' ) ) {

	function emulsion_brightness_class( $classes ) {
		global $post;

		if ( ! is_singular() ) {
			$text_color = emulsion_contrast_color();

			if ( '#ffffff' == $text_color ) {
				$classes[]	 = 'is-dark';
				$classes	 = array_diff( $classes, array( 'is-light' ) );
				$classes	 = array_values( $classes );

				return $classes;
			}
			if ( '#333333' == $text_color ) {
				$classes[]	 = 'is-light';
				$classes	 = array_diff( $classes, array( 'is-dark' ) );
				$classes	 = array_values( $classes );

				return $classes;
			}
		} else {

			$text_color							 = emulsion_contrast_color();
			$emulsion_post_theme_style_script	 = get_post_meta( absint( $post->ID ), 'emulsion_post_theme_style_script', true );
			$emulsion_page_theme_style_script	 = get_post_meta( absint( $post->ID ), 'emulsion_page_theme_style_script', true );

			if ( 'no_bg' !== $emulsion_post_theme_style_script && 'no_bg' !== $emulsion_page_theme_style_script ) {

				if ( '#ffffff' == $text_color ) {

					$classes[] = 'is-dark';

					$classes = array_diff( $classes, array( 'is-light' ) );
					$classes = array_values( $classes );
					return $classes;
				}
				if ( '#333333' == $text_color ) {

					$classes[]	 = 'is-light';
					$classes	 = array_diff( $classes, array( 'is-dark' ) );
					$classes	 = array_values( $classes );

					return $classes;
				}
			}
			if ( 'no_bg' == $emulsion_post_theme_style_script || 'no_bg' == $emulsion_page_theme_style_script ) {

				$default_bacckground = '#' . emulsion_get_supports( 'background' )[0]['default']['default-color'];
				$text_color			 = emulsion_contrast_color( $default_bacckground );

				if ( '#ffffff' == $text_color ) {

					$classes[] = 'is-dark';

					$classes = array_diff( $classes, array( 'is-light' ) );
					$classes = array_values( $classes );
					return $classes;
				}
				if ( '#333333' == $text_color ) {

					$classes[]	 = 'is-light';
					$classes	 = array_diff( $classes, array( 'is-dark' ) );
					$classes	 = array_values( $classes );

					return $classes;
				}
			}
		}
	}

}
if ( ! function_exists( 'emulsion_get_the_excerpt_filter' ) ) {

	function emulsion_get_the_excerpt_filter( $excerpt, $post ) {

		$locale	 = get_locale();
		$count	 = 200;
		$more	 = '...';

		if ( 'ja' == $locale ) {

			$excerpt = apply_filters( 'the_excerpt', $post->post_excerpt );

			if ( empty( $excerpt ) ) {
				$excerpt = $post->post_content;
				$excerpt = apply_filters( 'the_content', $excerpt );
			}

			$excerpt = strip_shortcodes( $excerpt );

			return wp_html_excerpt( $excerpt, $count, $more );
		}

		return $excerpt;
	}

}
if ( ! function_exists( 'emulsion_styles' ) ) {

	function emulsion_styles( $css ) {
		$style	 = $css;
		$style	 .= emulsion_inline_style_filter( '' );
		$style	 .= emulsion_term_duplicate_link_hide( '' );
		$style	 .= emulsion_smart_category_highlight( '' );
		$style	 .= emulsion_add_common_font_css( '' );
		$style	 .= emulsion_heading_font_css( '' );
		$style	 .= emulsion_widget_meta_font_css( '' );

		//if ( 'active' !== get_theme_mod( 'emulsion_wp_scss_status' ) || is_customize_preview() ) {
		
		if ( is_user_logged_in() || is_admin() || is_customize_preview() ) {

			$style .= emulsion_dinamic_css( '' );
		}
		$style = emulsion_sanitize_css( $style );
		return $style;
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
if ( ! function_exists( 'emulsion_smart_category_highlight' ) ) {

	/**
	 *
	 * @param type $css
	 * @return type
	 */
	function emulsion_smart_category_highlight( $css ) {

		$css = emulsion_sanitize_css( $css );

		$saturation_base = 50;
		$lightness_base	 = 45;
		$start_angle	 = 0;
		$result			 = '';

		/*
		 * Do not display if the number of posts belonging to the category is
		 * less than or equal to the specified number
		 */
		$count_sep	 = 0;
		$alpha		 = 1;
		$taxonomies	 = array( 'category' );

		$args = array(
			'orderby'		 => 'count',
			'order'			 => 'DESC',
			'hierarchical'	 => false,
		);

		$terms = get_terms( $taxonomies, $args );

		$transient_name = md5( serialize( $terms ) );

		if ( empty( $terms ) ) {
			return $css;
		}
		if ( get_theme_mod( 'emulsion_delete_transient' ) || is_customize_preview() ) {

			delete_transient( $transient_name );
		}

		$transient_val = get_transient( $transient_name );

		if ( false !== ( $transient_val ) ) {

			return $css . apply_filters( 'emulsion_smart_category_highlight', $transient_val );
		}

		$count_terms = count( $terms );
		$radian		 = 270 / $count_terms;
		$body_id	 =  '#'. emulsion_theme_info( 'Slug' , false );
	
		foreach ( $terms as $key => $term ) {

			$v			 = $key + 1;
			$hue		 = $start_angle + ( $radian * $v );
			$saturation	 = $saturation_base . '%';
			$lightness	 = $lightness_base . '%';

			if ( $lightness_base <= 50 ) {
				$color = '#fff';
			} else {
				$color = '#000';
			}
			/* category header style */
			if ( 'enable' == get_theme_mod( 'emulsion_category_colors', emulsion_get_var( 'emulsion_category_colors' ) ) ) {
				if ( $term->count > $count_sep ) {

					if ( 'enable' == get_theme_mod( 'emulsion_header_gradient', emulsion_get_var( 'emulsion_header_gradient' ) ) ) {

						$gradient_hue = $hue + 30;

						$result .= '.on-scroll.has-category-colors.category-' . $term->term_id . " .header-layer-site-title-navigation, \n"
								. '.on-scroll.has-category-colors.category.archive.category-' . $term->term_id . " .header-layer,\n"
								. '.has-category-colors.category.archive.category-' . $term->term_id . " .header-layer{\n"
								. 'color:' . $color . ";\n"
								. 'background: linear-gradient(90deg,  hsl(' . $hue . ',' . $saturation . ',' . $lightness . '),'
								. ' hsl(' . $gradient_hue . ',' . $saturation . ',' . $lightness . ") );\n"
								. "\n}\n";
					} else {

						$result .= '.on-scroll.has-category-colors.category-' . $term->term_id . " .header-layer-site-title-navigation, \n"
								. '.on-scroll.has-category-colors.category-' . $term->term_id . " .header-layer, \n"
								. '.has-category-colors.category-' . $term->term_id . " .header-layer{\n color:" . $color . ";\nbackground:hsla(" . $hue . ',' . $saturation . ',' . $lightness . ',' . $alpha . ");\n} \n";
					}
					/* cta link button */
					$result					 .= '.category.has-category-colors.archive.category-' . $term->term_id . " .header-layer .cta-layer a{\n color:" . $color . ';background:hsla(' . $hue . ',' . $saturation . ',' . $lightness . ',' . $alpha . ");\n}\n";
					$hover_hue				 = $hue + 180;
					$link_lightness			 = '90%';
					$description_lightness	 = '100%';

					$result	 .= '.has-category-colors.category.archive.category-' . $term->term_id . " .header-layer .drawer-wrapper .icon:hover{\n"
							. 'fill: hsla(' . $hover_hue . ',' . $saturation . ',' . $lightness . ',' . $alpha . "); \n"
							. 'stroke: hsla(' . $hover_hue . ',' . $saturation . ',' . $lightness . ',' . $alpha . ");\n}\n";
					$result	 .= '.has-category-colors.category.archive.category-' . $term->term_id . " .header-layer a{\n color: hsla(" . $hover_hue . ',' . $saturation . ',' . $link_lightness . ',' . $alpha . ");\n }\n";
					$result	 .= '.has-category-colors.category.archive.category-' . $term->term_id . " .header-layer a:hover{\n color: hsla(" . $hover_hue . ',' . $saturation . ',' . $link_lightness . ',' . $alpha . "); \n}\n";
					$result	 .= '.has-category-colors.category.archive.category-' . $term->term_id . " .header-layer .taxonomy-description{\n color: hsla(" . $hover_hue . ',' . $saturation . ',' . $description_lightness . ',' . $alpha . ");\n }\n";




					/* category header style end */
					$result	 .= $body_id . ' .entry-meta .cat-item-' . $term->term_id . " {\n background:hsla(" . $hue . ',' . $saturation . ',' . $lightness . ',' . $alpha . ');} ';
					$result	 .= $body_id . ' .entry-meta .cat-item-' . $term->term_id . "{\n transition:all .5s ease-in-out;\n} \n";
					$result	 .= $body_id . ' .entry-meta .cat-item-' . $term->term_id . ', .cat-item-' . $term->term_id . " a{\n color:#fff;} \n";
					$result	 .= $body_id . ' .entry-meta .cat-item-' . $term->term_id . " a{\n color:#eee;\n} \n";					
					/* hover */ 
					$result	 .= $body_id . ' .cat-item-' . $term->term_id . ":hover {\n background:hsla(" . $hue . ',' . $saturation . ',' . $lightness . ',' . $alpha . ');} ';
					$result	 .= $body_id . ' .cat-item-' . $term->term_id . "{\n transition:all .5s ease-in-out;\n} \n";
					$result	 .= $body_id . ' .cat-item-' . $term->term_id . ':hover, .cat-item-' . $term->term_id . ":hover a{\n color:#fff;} \n";
					$result	 .= $body_id . ' .cat-item-' . $term->term_id . ":hover a{\n color:#eee;\n} \n";

					/* link before icon style */

					/* $result	 .= $body_id . ' .cat-item-' . $term->term_id . ':before {content:\'\'; display:inline-block; width:1rem; height:1rem; vertical-align:middle;}';
					  $result	 .= $body_id . ' .cat-item-' . $term->term_id . ':before {background:hsla(' . $hue . ',' . $saturation . ',' . $lightness . ',' . $alpha . ');} ';
					  $result	 .= $body_id . ' .cat-item-' . $term->term_id . '{transition:all .5s ease-in-out;} ';
					  $result	 .= $body_id . ' .cat-item-' . $term->term_id . ':before, .cat-item-' . $term->term_id . ':before a{color:#fff;} '; */

					/* relate style effect.scss */

					$result	 .= $body_id . ' .cat-item-' . $term->term_id . '.current-cat a,' . $body_id . ' .cat-item-' . $term->term_id . ".current-cat{\n color:#fff;} \n";
					$result	 .= $body_id . ' .cat-item-' . $term->term_id . ".current-cat {\n background:hsla(" . $hue . ',' . $saturation . ',' . $lightness . ',' . $alpha . ");\n} \n";
					$result	 .= $body_id . '.hilight-cat-item-' . $term->term_id . ' .cat-item-' . $term->term_id . " {\n background:hsla(" . $hue . ',' . $saturation . ',' . $lightness . ',' . $alpha . ");\n} \n";
					$result	 .= $body_id . '.hilight-cat-item-' . $term->term_id . ' .cat-item-' . $term->term_id . "{color:#fff;\n} \n";
					$result	 .= $body_id . '.hilight-cat-item-' . $term->term_id . ' .cat-item-' . $term->term_id . " li{color:#fff;\n} \n";
					$result	 .= $body_id . '.hilight-cat-item-' . $term->term_id . ' .cat-item-' . $term->term_id . " a{color:#fff!important;\n } \n";
				} else {
					$result	 .= $body_id . ' .cat-item.cat-item-' . $term->term_id . " {\n display:none;\n} \n";
					$result	 .= $body_id . '.category-archives .cat-item.cat-item-' . $term->term_id . " {\n display:none; \n } \n";
				}
			}
		}
		
		$result	 = emulsion_sanitize_css( $result );
		$result	 = emulsion_remove_spaces_from_css( $result );

		set_transient( $transient_name, $result, 60 * 60 * 24 );
		return $css . $result;
	}

}
if ( ! function_exists( 'emulsion_add_common_font_css' ) ) {

	function emulsion_add_common_font_css( $css ) {
		
		$transient_name = __FUNCTION__;
				
		if ( is_customize_preview() ) {

			delete_transient( $transient_name );			
		}
	/*	if( 'active' == get_theme_mod( 'emulsion_wp_scss_status' ) ){

			return;
		}*/
		
		$transient_val = get_transient( $transient_name );

		if ( false !== ( $transient_val ) && ! is_user_logged_in() ) {

			return $css. $transient_val;
		}

		$inline_style			 = emulsion_sanitize_css( $css );
		$font_google_family_url	 = get_theme_mod( 'emulsion_common_google_font_url', emulsion_get_var( 'emulsion_common_google_font_url' ) );
		$fallback_font_family	 = get_theme_mod( 'emulsion_common_font_family', emulsion_get_var( 'emulsion_common_font_family' ) );
		$font_size				 = get_theme_mod( 'emulsion_common_font_size', emulsion_get_var( 'emulsion_common_font_size' ) );
//	$id = emulsion_theme_info( 'Slug' );

		if ( ! empty( $font_google_family_url ) ) {

			$font_family = emulsion_get_google_font_family_from_url( $font_google_family_url, $fallback_font_family );
		} else {

			$font_family = $fallback_font_family;
		}

		$inline_style	 .= <<<CSS
			:root{
				font-family:$font_family;
				font-size:{$font_size}px;
			}
			.font-common-$fallback_font_family{
				font-family:$font_family;
				font-size:{$font_size}px;
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
		
		$transient_name = __FUNCTION__;
				
		if ( is_customize_preview() ) {

			delete_transient( $transient_name );			
		}
	
		$transient_val = get_transient( $transient_name );

		if ( false !== ( $transient_val ) && ! is_user_logged_in() ) {

			return $css. $transient_val;
		}
		

		$inline_style			 = emulsion_sanitize_css( $css );
		$font_google_family_url	 = get_theme_mod( 'emulsion_heading_google_font_url', emulsion_get_var( 'emulsion_heading_google_font_url' ) );
		$fallback_font_family	 = get_theme_mod( 'emulsion_heading_font_family', emulsion_get_var( 'emulsion_heading_font_family' ) );
		$font_size				 = get_theme_mod( 'emulsion_heading_font_size', emulsion_get_var( 'emulsion_heading_font_size' ) );
		// 変換
		$heading_font_base		 = 16;
		if ( 'xx' == $font_size ) {
			$h3	 = $heading_font_base * 1.17 . 'px';  // H3
			$h2	 = $heading_font_base * 1.4 . 'px';   // H2
			$h1	 = $heading_font_base * 2 . 'px';   // H1
		}
		if ( 'xxx' == $font_size ) {
			$h3	 = $heading_font_base * 1.5 . 'px';  // H3
			$h2	 = $heading_font_base * 2 . 'px';   // H2
			$h1	 = $heading_font_base * 3 . 'px';   // H1
		}
		$font_weight	 = get_theme_mod( 'emulsion_heading_font_weight', emulsion_get_var( 'emulsion_heading_font_weight' ) );
		$text_transform	 = get_theme_mod( 'emulsion_heading_font_transform', emulsion_get_var( 'emulsion_heading_font_transform' ) );

		if ( ! empty( $font_google_family_url ) ) {

			$font_family = emulsion_get_google_font_family_from_url( $font_google_family_url, $fallback_font_family );
		} else {

			$font_family = $fallback_font_family;
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
			body.font-heading-$fallback_font_family .h3,
			body.font-heading-$fallback_font_family h3{
				font-size:var(--thm_common_font_size);
			}
		}
CSS;
		
		
		$inline_style	 = emulsion_sanitize_css( $inline_style );
		$inline_style	 = emulsion_remove_spaces_from_css( $inline_style );
		
		set_transient( $transient_name, $inline_style, 60 * 60 * 24 );
		return $css . $inline_style;
	}

}
if ( ! function_exists( 'emulsion_widget_meta_font_css' ) ) {

	function emulsion_widget_meta_font_css( $css ) {
		
		$transient_name = __FUNCTION__;
				
		if ( is_customize_preview() ) {

			delete_transient( $transient_name );			
		}
		
		$transient_val = get_transient( $transient_name );

		if ( false !== ( $transient_val ) && ! is_user_logged_in() ) {

			return $css. $transient_val;
		}

		$inline_style = emulsion_sanitize_css( $css );

		$font_google_family_url	 = get_theme_mod( 'emulsion_widget_meta_google_font_url', emulsion_get_var( 'emulsion_widget_meta_google_font_url' ) );
		$fallback_font_family	 = get_theme_mod( 'emulsion_widget_meta_font_family', emulsion_get_var( 'emulsion_widget_meta_font_family' ) );
		$font_size				 = get_theme_mod( 'emulsion_widget_meta_font_size', emulsion_get_var( 'emulsion_widget_meta_font_size' ) );
		$text_transform			 = get_theme_mod( 'emulsion_widget_meta_font_transform', emulsion_get_var( 'emulsion_widget_meta_font_transform' ) );
		$widget_title_font		 = get_theme_mod( 'emulsion_widget_meta_title', emulsion_get_var( 'emulsion_widget_meta_title' ) );
		$common_font_size		 = get_theme_mod( 'emulsion_common_font_size', emulsion_get_var( 'emulsion_common_font_size' ) );
		if ( ! empty( $font_google_family_url ) ) {

			$font_family = emulsion_get_google_font_family_from_url( $font_google_family_url, $fallback_font_family );
		} else {



			$font_family = $fallback_font_family;
		}

		if ( $widget_title_font ) {
			$widget_title_font_family = 'font-family:' . $font_family . ';';
		} else {
			$widget_title_font_family = '';
		}


		$inline_style .= <<<CSS


		body .primary-menu-wrapper a {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body .menu-placeholder {
		  font-size: {$common_font_size}px
		}
		body.emulsion-has-sidebar .template-part-widget-sidebar .sidebar-widget-area-lists {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body.emulsion-has-sidebar .template-part-widget-sidebar .sidebar-widget-area-lists li {
		  line-height: calc({$common_font_size}px * var( --thm_content-line-height, 1.5 ));
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body.emulsion-has-sidebar .template-part-widget-sidebar .sidebar-widget-area-lists li #wp-calendar caption,
		body.emulsion-has-sidebar .template-part-widget-sidebar .sidebar-widget-area-lists li .widgettitle {
		  font-size: 20px;
		  $widget_title_font_family
		}
		body.emulsion-has-sidebar .template-part-widget-sidebar .sidebar-widget-area-lists li a,
		body.emulsion-has-sidebar .template-part-widget-sidebar a {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body .footer-widget-area.template-part-widget-footer .footer-widget-area-lists {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body .footer-widget-area.template-part-widget-footer .footer-widget-area-lists li {
		  line-height: calc({$common_font_size}px * var( --thm_content-line-height, 1.5 ));
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body .footer-widget-area.template-part-widget-footer .footer-widget-area-lists li #wp-calendar caption,
		body .footer-widget-area.template-part-widget-footer .footer-widget-area-lists li .widgettitle {
		  font-size: 20px;
		  $widget_title_font_family
		}
		body .footer-widget-area.template-part-widget-footer .footer-widget-area-lists li a,
		body .footer-widget-area.template-part-widget-footer a {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body .relate-content-wrapper {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		}
		body .relate-content-wrapper .relate-posts-title {
		  font-size: calc({$font_size}px * 1.4);
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body article footer {
		  font-size: 16px;
		}
		body article footer .skin-button{
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body .post-navigation a {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body footer.banner {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body .navigation.pagination .page-numbers{
		 font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body footer.banner a {
		  font-size: 13px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body .entry-meta a {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body .posted-on a {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body .footer-widget-area .footer-widget-area-lists a {
		  font-size: {$font_size}px;
		  font-family: {$font_family};
		  text-transform: {$text_transform};
		}
		body.layout-grid .entry-title {
		  font-size: 22px;
		}
		body.layout-stream .entry-title {
		  font-size: 22px;
		}
		body .relate-posts-title {
		  font-size: 22px;
		}
CSS;

		$inline_style	 = emulsion_sanitize_css( $inline_style );
		$inline_style	 = emulsion_remove_spaces_from_css( $inline_style );
		set_transient( $transient_name, $inline_style, 60 * 60 * 24 );
		return $css. $inline_style;
	}

}

if ( ! function_exists( 'emulsion_do_snippet' ) ) {

	function emulsion_do_snippet( $hook = '', $type = 'action', $css = '',
			$js = '', $html = '' ) {

		if ( empty( $hook ) ) {
			return;
		}

		empty( $css ) ? '' : add_filter( 'emulsion_inline_style', function( $current_css ) use( $css ) {
							$css	 = emulsion_sanitize_css( $css );
							return $current_css . ' ' . $css;
						} );

		empty( $js ) ? '' : add_filter( 'emulsion_inline_script', function( $current_js ) use( $js ) {

							return $current_js . ' ' . $js;
						} );

		$type == 'filter' ? add_filter( $hook, function($current_html) use( $html ) {

							if ( is_array( $current_html ) && is_array( $html ) ) {

								$current_html = array_merge( $current_html, $html );

								return $current_html;
							}
							if ( is_string( $current_html ) && is_string( $html ) ) {

								return $current_html . $html;
							}
						} ) : '';
		$type == 'action' ? add_action( $hook, function() use( $html ) {
						/* $html output action hook results */
							echo $html;
						} ) : '';
	}

}
if ( ! function_exists( 'emulsion_footer_widget_params' ) ) {

	function emulsion_footer_widget_params( $params ) {

		$sidebar_id = $params[0]['id'];

		if ( $sidebar_id == 'sidebar-2' ) {
			static $count = 1;

			$params[0]['before_widget'] = str_replace( 'class="', 'class="col-' . absint( $count ) . ' ', $params[0]['before_widget'] );
			$count ++;
		}
		if ( $sidebar_id == 'sidebar-4' ) {
			static $count_page = 1;

			$params[0]['before_widget'] = str_replace( 'class="', 'class="col-' . absint( $count_page ) . ' ', $params[0]['before_widget'] );
			$count_page ++;
		}

		return $params;
	}

}
if ( ! function_exists( 'emulsion_plugins' ) ) {

	function emulsion_plugins() {

		if ( function_exists( 'amp_init' ) ) {

			add_action( 'amp_post_template_footer', 'emulsion_svg' );
			add_filter( 'amp_post_template_data', 'emulsion_amp_post_template_data' );
		}
	}

}
if ( ! function_exists( 'emulsion_amp_post_template_data' ) ) {

	function emulsion_amp_post_template_data( $data ) {

		$spacer				 = empty( $data['body_class'] ) ? '' : ' ';
		$data['body_class']	 .= $spacer . 'emulsion';

		return $data;
	}

}
if ( ! function_exists( 'emulsion_svg' ) ) {

	function emulsion_svg() {

		if ( emulsion_get_supports( 'footer-svg' ) ) {

			get_template_part( 'images/svg' );
		}
	}

}
if ( ! function_exists( 'emulsion_unregister_default_widgets' ) ) {

	function emulsion_unregister_default_widgets() {
		/**
		 * Core broken widget
		 */
		unregister_widget( 'WP_Widget_Text' );
	}

}