<?php

add_action( 'after_switch_theme', 'emulsion_minimum_php_version_check' );
add_action( 'after_setup_theme', 'emulsion_hooks_setup' );

function emulsion_hooks_setup() {

	do_action( 'emulsion_hooks_setup_before' );

	//both

	add_filter( 'body_class', 'emulsion_body_class' );

	/**
	 * Script
	 */
	true === emulsion_the_theme_supports( 'lazyload' ) ? add_filter( 'emulsion_lazyload_script', 'emulsion_lazyload' ) : '';
	true === emulsion_the_theme_supports( 'instantclick' ) ? add_filter( 'emulsion_instantclick_script', 'emulsion_instantclick' ) : '';
	true === emulsion_the_theme_supports( 'toc' ) ? add_filter( 'emulsion_toc_script', 'emulsion_toc' ) : '';
	'html' == get_theme_mod( 'emulsion_header_template', emulsion_theme_default_val( 'emulsion_header_template', 'default' ) ) ? add_filter( 'theme_mod_emulsion_title_in_header', function ( $yesno ) {
		return 'no';
	} ) : '';
	/**
	 * Block editor notation
	 */
	if ( function_exists( 'do_blocks' ) ) {
		! empty( get_theme_mod( 'emulsion_header_html' ) ) ? add_action( 'theme_mod_emulsion_header_html', 'do_blocks' ) : '';
		! empty( get_theme_mod( 'emulsion_footer_credit' ) ) ? add_action( 'theme_mod_emulsion_footer_credit', 'do_blocks' ) : '';
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

		/**
		 * Data validations
		 */
		//add_filter( 'emulsion_the_post_meta_on', 'ent2ncr' );
		add_filter( 'emulsion_the_post_meta_in', 'ent2ncr' );

		/**
		 * Plugin Settings relate
		 */
		add_action( 'wp_footer', 'emulsion_theme_google_tracking_code', 99 );

	}

	if ( 'theme' == emulsion_get_theme_operation_mode() ) {

		add_action( 'wp_head', 'emulsion_meta_elements' );
		add_action( 'wp_head', 'emulsion_pingback_header' );
		add_action( 'wp_body_open', 'emulsion_skip_link' );
		//add_action( 'wp_enqueue_scripts', 'emulsion_not_support_presentation_page_link' );

		add_filter( 'get_the_archive_title', 'emulsion_archive_title_filter' );
		add_filter( 'the_title', 'emulsion_empty_the_title_fallback' );
		add_filter( 'the_content', 'emulsion_entry_content_filter', 11 );
		add_filter( 'embed_oembed_html', 'emulsion_oembed_filter', 99, 4 );
		add_filter( 'do_shortcode_tag', 'emulsion_shortcode_tag_filter', 99, 4 );
		add_filter( 'the_password_form', 'emulsion_get_the_password_form', 11 );
		add_filter( 'oembed_default_width', 'emulsion_oembed_default_width', 99 );

		add_filter( 'the_excerpt', 'emulsion_excerpt_remove_p' );
		add_filter( 'gettext_with_context_default', 'emulsion_change_translate', 99, 4 );
		add_filter( 'the_content_more_link', 'emulsion_read_more_link' );
		add_filter( 'navigation_markup_template', 'emulsion_remove_role_from_pagination' );
		//add_filter( 'get_header_image_tag', 'emulsion_amp_add_layout_attribute' );
		add_filter( 'get_the_archive_description', 'wpautop' );

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

		$post_id = get_the_ID();

		if ( emulsion_the_theme_supports( 'sidebar' ) || emulsion_the_theme_supports( 'sidebar_page' ) ) {

			if ( is_page() ) {

				unset( $classes['emulsion-no-sidebar'] );
				unset( $classes['emulsion-has-sidebar'] );

				$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_page_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_page_sidebar' ) );
				$metabox_page_control	 = emulsion_metabox_display_control( 'page_sidebar' );

				$classes[] = is_active_sidebar( 'sidebar-3' ) &&
						emulsion_the_theme_supports( 'sidebar_page' ) &&
						$metabox_page_control ? ' emulsion-has-sidebar' : ' emulsion-no-sidebar';
			} else {

				unset( $classes['emulsion-no-sidebar'] );
				unset( $classes['emulsion-has-sidebar'] );

				$sidebar_condition		 = get_theme_mod( 'emulsion_condition_display_posts_sidebar', emulsion_theme_default_val( 'emulsion_condition_display_posts_sidebar' ) );
				$metabox_post_control	 = emulsion_metabox_display_control( 'sidebar' );

				$classes[] = is_active_sidebar( 'sidebar-1' ) &&
						emulsion_the_theme_supports( 'sidebar' ) &&
						$metabox_post_control ? ' emulsion-has-sidebar' : ' emulsion-no-sidebar';
			}
		}

		// fse background class
		$classes[] = emulsion_fse_background_color_class();

		if ( is_singular() ) {

			$classes[] = 'is-singular';

			$emulsion_post_id = get_the_ID();

			$classes[] = comments_open( $emulsion_post_id ) ? 'is-comments-open' : 'is-comments-close';
		}

		if ( is_child_theme() ) {

			$classes[] = 'is-child-theme';
		}

		if ( get_theme_support( 'align-wide' ) ) {

			$classes[] = 'enable-alignfull';
		}

		$classes[] = 'emulsion';

		if ( is_singular() && isset( $post ) ) {
			$author_name = 'by-' . get_the_author_meta( 'display_name', $post->post_author );
			$classes[]	 = sanitize_html_class( $author_name );
		}

		// fse background class
		$classes[] = emulsion_fse_background_color_class();

		if ( is_singular() ) {

			$post_id = get_the_ID();
			$content = get_post( $post_id )->post_content;
			// remove block comments
			$content = trim( preg_replace( '#<![^>]*>#', '', $content ) );
			// maybe first element
			$content = strstr( $content, '/', true );

			if ( preg_match( '!^<([^>]*)?\balignwide\b([^>]*)?>!m', $content ) ) {
				$classes[] = 'keep-align-wide';
			} elseif ( preg_match( '!^<[^>]*\balignfull\b[^>]*>!m', $content ) ) {
				$classes[] = 'keep-align-full';
			}
		}
		if ( has_blocks() && is_singular() ) {

			$classes[] = 'has-block';
		}

		if ( ! has_blocks() && ! empty( get_post( $post_id )->post_content ) && is_singular() ) {

			//The front page,blog page usually have no content, so no-block breaks the layout then

			$classes[] = 'no-block';
		}

		if ( emulsion_the_theme_supports( 'full_site_editor' ) ) {

			$classes[] = 'emulsion-fse-active';

			if ( ! is_page() && ! is_attachment() && ! is_single() ) {

				$classes[]	 = 'summary'; //for transitional theme
				$classes[]	 = 'excerpt'; // for classic theme
			} else {
				$classes[] = 'full_text';
			}
		}

		$classes[] = sanitize_html_class( 'is-presentation-' . get_theme_mod( 'emulsion_editor_support', 'fse' ) );

		// current template

		$classes[] = 'is-tpl-' . emulsion_get_template();

		if ( emulsion_is_custom_post_type() ) {

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
if ( ! function_exists( 'emulsion_skip_link' ) ) {

	function emulsion_skip_link() {

		$skip_link_url = emulsion_request_url() . '#main';

		printf( '<div class="%1$s" role="navigation" aria-label="Skip Link"><a href="%2$s" class="%3$s" title="%4$s">%5$s</a></div>', 'skip-link', esc_url( $skip_link_url ), 'screen-reader-text', esc_attr__( 'Skip to content', 'emulsion' ), esc_html__( 'Skip to content', 'emulsion' )
		);
	}

}

if ( ! function_exists( 'emulsion_archive_title_filter' ) ) {

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

if ( ! function_exists( 'emulsion_get_rest' ) ) {

	function emulsion_get_rest( $script ) {
		if ( 'fse' !== emulsion_get_theme_operation_mode() && 'html' !== get_theme_mod( 'emulsion_header_template', emulsion_theme_default_val( 'emulsion_header_template', 'default' ) ) ) {
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
		$post			  = get_post( $post_id );
		$content_arr	  = get_extended( $post->post_content );
		$custom_more_text = wp_kses( $content_arr['more_text'], array() );

		if ( is_int( $post_id ) ) {

			return sprintf(
					'<p class="read-more"><a class="skin-button" href="%1$s" aria-label="%3$s">%2$s<span class="screen-reader-text read-more-context">%3$s</span></a></p>',
					esc_url( get_permalink() ),
					! empty($custom_more_text) ? $custom_more_text : esc_html__( 'Read more', 'emulsion' ),
					$title_text
			);
		}
	}

}
/*
if ( ! function_exists( 'emulsion_block_editor_class' ) ) {

	function emulsion_block_editor_class( $classes ) {

		global $wp_version;
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $classes;
		}

		$block_editor_class_name = '';
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {

			$classes = str_replace( array( 'is-loop', 'layout-list', 'is-light', 'is-dark' ), '', $classes );
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
		$block_editor_class_name .= ' ' . emulsion_fse_background_color_class();

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

}*/
/*
if ( ! function_exists( 'emulsion_amp_add_layout_attribute' ) ) {

	function emulsion_amp_add_layout_attribute( $html ) {
		if ( emulsion_is_amp() ) {
			return str_replace( ' />', ' layout="responsive" />', $html );
		}

		return str_replace( '/>', ' class="custom-header-image" />', $html );
	}

}
 *
 */
/*
if ( ! function_exists( 'emulsion_not_support_presentation_page_link' ) ) {

	function emulsion_not_support_presentation_page_link() {

		if ( 'fse' == emulsion_get_theme_operation_mode() && 'html' == get_theme_mod( 'emulsion_header_template', emulsion_theme_default_val( 'emulsion_header_template', 'default' ) ) ) {
			return;
		}
		$post_id = absint( get_the_ID() );

		if ( ! empty( $post_id ) && is_singular() && metadata_exists( 'post', $post_id, 'emulsion_post_theme_style_script' ) ) {
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

}*/


if ( ! function_exists( 'emulsion_remove_role_from_pagination' ) ) {

	function emulsion_remove_role_from_pagination( $template ) {

		return str_replace( 'role="navigation"', '', $template );
	}

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


