<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if ( ! function_exists( 'emulsion_get_theme_operation_mode' ) ) {

	function emulsion_get_theme_operation_mode() {

		return sanitize_text_field( get_theme_mod( 'emulsion_editor_support' ) );
	}

}

if ( ! function_exists( 'emulsion_the_theme_supports' ) ) {

	function emulsion_the_theme_supports( $name ) {

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {

			return false;
		}

		$emulsion_default_supports = array(
			'theme_documents'			 => array( 'default' => false, ), // required emulsion-addons plugin
			'enqueue'					 => array( 'default' => true, ),
			'primary_menu'				 => array( 'default' => true, ),
			'search_drawer'				 => array( 'default' => true, ), // required emulsion-addons plugin
			'search_keyword_highlight'	 => array( 'default' => false, ), // required emulsion-addons plugin
			'sidebar'					 => array( 'default' => true, ),
			'sidebar_page'				 => array( 'default' => true, ),
			'footer'					 => array( 'default' => true, ),
			'footer_page'				 => array( 'default' => true, ),
			'alignfull'					 => array( 'default' => true, ), // required emulsion-addons plugin
			'title_in_page_header'		 => array( 'default' => true, ),
			'toc'						 => array( 'default' => true, ),
			'header'					 => array( 'default' => true, ),
			'background'				 => array( 'default' => false, ), // required emulsion-addons plugin
			'custom-logo'				 => array( 'default' => true, ),
			'social-link-menu'			 => array( 'default' => true, ),
			'footer-svg'				 => array( 'default' => true, ),
			'relate_posts'				 => array( 'default' => true, ),
			'tooltip'					 => array( 'default' => true, ),
			'amp'						 => array( 'default' => true, ),
			'entry_content_filter'		 => array( 'default' => true, ),
			'block_sectionize'			 => array( 'default' => false, ), //Change not recommended
			'background_css_pattern'	 => array( 'default' => false, ), // required emulsion-addons,amp plugin
			'meta_description'			 => array( 'default' => true, ),
			'TGMPA'						 => array( 'default' => true, ),
			'instantclick'				 => array( 'default' => true, ),
			'lazyload'					 => array( 'default' => true, ),
			'excerpt'					 => array( 'default' => true, ),
			'grid'						 => array( 'default' => array( array( 'date' ) ) ),
			'stream'					 => array( 'default' => array( array( 'category', 'post_tag', 'author' ) ) ),
			'metabox'					 => array( 'default' => false ), // required emulsion-addons,amp plugin
			'viewport'					 => array( 'default' => true, ),
			'block_experimentals'		 => array( 'default' => true, ),
			'scheme'					 => array( 'default' => true ),
			'full_site_editor'			 => array( 'default' => true, ), //Currently depends on gutenberg_is_fse_theme()
		);

		/**
		 * Note:custom post type and layout
		 * You can change the layout of custom post type by writing as follows.
		 * 'grid' => array( 'default' => array ( array ( 'date', 'post_type' => array( 'news' ) ) ) ),
		 */
		if ( function_exists( 'emulsion_get_supports' ) ) {

			return emulsion_get_supports( $name );
		}

		return apply_filters( 'emulsion_the_theme_supports', $emulsion_default_supports[$name]['default'], $name );
	}

}

/**
 * EMULSION_DEFAULT_VARIABLES will reflect the changes if you don't use the plugin or theme schema.
 * If the plugin is enabled, this constant will not work as it will work depending on the value of the customizer.
 *
 * It is set only to save the calculation time of the color scheme
 */
$emulsion_default_variables = <<<DEFAULT_VARIABLES

	/* emulsion_block_editor_styles_and_scripts */
    --thm_background_image_dim: rgba( 0, 0, 0, 0.0);
    --thm_border_global: #bcbcbc;
    --thm_border_global_style: solid;
    --thm_border_global_width: 1px;
    --thm_border_grid: #bcbcbc;
    --thm_border_grid_style: solid;
    --thm_border_grid_width: 1px;
    --thm_border_sidebar: #bcbcbc;
    --thm_border_sidebar_style: solid;
    --thm_border_sidebar_width: 1px;
    --thm_border_stream: #bcbcbc;
    --thm_border_stream_style: solid;
    --thm_border_stream_width: 1px;
    --thm_comments_bg: #eeeeee;
    --thm_comments_color: #333333;
    --thm_comments_link_color: #666666;
    --thm_content_margin_top: 0px;
    --thm_excerpt_linebreak: none;
    --thm_favorite_color_palette: #1e73be;
    --thm_general_link_color: #666666;
    --thm_general_link_hover_color: #333333;
    --thm_general_text_color: #333333;

    --thm_header_hover_color: #333333;
    --thm_header_image_dim: rgba(0,0,0,.5);
    --thm_header_link_color: #666666;
    --thm_header_media_max_height: 75vh;
    --thm_heading_font_base: 16;
    --thm_heading_font_scale: xxx;
    --thm_post_display_author: inherit;
    --thm_post_display_category: inherit;
    --thm_post_display_date: inherit;
    --thm_post_display_tag: inherit;
    --thm_primary_menu_background: #ffffff;
    --thm_primary_menu_color: #333333;
    --thm_primary_menu_link_color: #666666;
    --thm_relate_posts_bg: #eeeeee;
    --thm_relate_posts_color: #333333;
    --thm_relate_posts_link_color: #666666;
    --thm_sidebar_bg_color: #ffffff;
    --thm_sidebar_hover_color: #333333;
    --thm_sidebar_link_color: #666666;
    --thm_sidebar_text_color: #333333;
    --thm_sub_background_color_darken: hsla(0deg,0%,75%,1);
    --thm_sub_background_color_lighten: hsla(0deg,0%,100%,1);
    --thm_align_offset: 200px;
    --thm_background_color: #ffffff;
    --thm_box_gap: 3px;
    --thm_caption_height: 1.5em;
    --thm_common_font_family: sans-serif;
    --thm_common_font_size: 16px;
    --thm_common_line_height: 1.15;
    --thm_content_gap: 24px;
    --thm_content_line_height: 1.5;
    --thm_content_width: 720px;
	--thm_wide_width: 920px;
    --thm_default_header_height: 300px;
    --thm_footer_widget_width: 30%;
    --thm_header_bg_color: #eeeeee;
    --thm_header_background_gradient_color: #eeeeee;
    --thm_header_text_color: #333333;
    --thm_heading_font_family: serif;
    --thm_heading_font_transform: uppercase;
    --thm_heading_font_weight: 700;
    --thm_hover_color: #333333;
    --thm_i18n_no_title: 無題;
    /*--thm_main_width-with-sidebar: calc(100vw - var(--thm_sidebar_width) - 48px);*/
    --thm_main_width: 1280px;
    --thm_meta_data_font_family: sans-serif;
    --thm_meta_data_font_size: 13px;
    --thm_meta_data_font_transform: none;
    --thm_sidebar_width: 400px;
    --thm_social_icon_color: #666666;
DEFAULT_VARIABLES;

define( 'EMULSION_DEFAULT_VARIABLES', $emulsion_default_variables );

if ( ! function_exists( 'emulsion_get_footer_cols_css' ) ) {

	/**
	 * Get number of columns in footer widget area in% width
	 * @return number
	 */
	function emulsion_get_footer_cols_css() {

		$cols			 = emulsion_get_footer_cols();
		$cols_percent	 = 100 / $cols;
		$cols_percent	 = floor( $cols_percent ) - 3;

		return $cols_percent;
	}

}

if ( ! function_exists( 'emulsion_theme_get_font_sizes' ) ) {

	/**
	 * block editor font sizes
	 * @return string
	 */
	function emulsion_theme_get_font_sizes() {

		$font_size_vals				 = get_theme_support( 'editor-font-sizes' );
		$disable_custom_font_size	 = get_theme_support( 'disable-custom-font-size' );
		$font_sizes					 = '';

		if ( isset( $font_size_vals ) && is_array( $font_size_vals ) && ! $disable_custom_font_size ) {

			foreach ( $font_size_vals[0] as $font_val ) {

				$font_sizes .= sprintf( '%1$s %2$s,', $font_val['slug'], $font_val['size'] );
			}
			$font_sizes = trim( $font_sizes, "," );
		} else {

			// gutenberg default values
			$font_sizes = "small 14,regular 16, large 36, larger 48";
		}
		return $font_sizes;
	}

}

if ( ! function_exists( 'emulsion_class_name_sanitize' ) ) {

	/**
	 * Normally use sanitize_html_class.
	 *
	 * Useful for multi-classes such as space delimiters or class arrays.
	 *
	 */
	function emulsion_class_name_sanitize( $class = '' ) {

		$class_name	 = '';
		$result		 = '';

		if ( is_string( $class ) && mb_stristr( $class, ' ' ) === false ) {

			return sanitize_html_class( $class );
		} elseif ( is_string( $class ) ) {

			$extend_class	 = mb_convert_kana( $class, 's' );
			$extend_classes	 = explode( ' ', $extend_class );

			foreach ( $extend_classes as $class_name ) {

				$result .= ' ' . sanitize_html_class( $class_name );
			}
			return trim( $result );
		}

		if ( is_array( $class ) ) {

			foreach ( $class as $class_name ) {

				$result .= ' ' . sanitize_html_class( $class_name );
			}
			return trim( $result );
		}

		return;
	}

}
if ( ! function_exists( 'emulsion_get_related_posts' ) ) {

	/**
	 *
	 * @since 1.1.3 removed global $post
	 */
	function emulsion_get_related_posts() {

		$relate_posts_enable = emulsion_the_theme_supports( 'relate_posts' );

		if ( empty( $relate_posts_enable ) && 'theme' == emulsion_get_theme_operation_mode() ) {

			return;
		}
		$html		 = sprintf( '<li>%1$s</li>', esc_html__( 'Not Found', 'emulsion' ) );
		$result_pre	 = sprintf( '<!-- wp:group {"className":"emulsion-block-pattern-relate-posts wrap-emulsion_relate_posts", "layout":{"inherit":true}} -->'
		. '<div class="emulsion-block-pattern-relate-posts wp-block-group wrap-emulsion_relate_posts" id="relate-posts">'
		. '<!-- wp:heading --><h2 class="relate-posts-title">%1$s</h2><!-- /wp:heading -->'
		. '<!-- wp:list --><ul class="relate-posts">', esc_html__( 'Relate Posts', 'emulsion' ) );

		$result_after = '</ul><!-- /wp:list --></div><!-- /wp:group -->';

		$algo = emulsion_related_posts_finder();

		if ( ! empty( $algo ) && is_single() && ! is_attachment() ) {

			$type			 = key( $algo );
			$id				 = $algo[$type];
			$args			 = "recent_post" == $type ? array( 'posts_per_page' => 5, 'post_status' => 'publish' ) : array( 'posts_per_page' => 5, $type => $id, 'post_status' => 'publish' );
			$relate_posts	 = get_posts( $args );

			if ( ! empty( $relate_posts ) && is_single() && ! is_attachment() ) {

				$result = '';

				foreach ( $relate_posts as $relate_post ) {

					$post_id			 = absint( $relate_post->ID );
					$relate_post_title	 = $relate_post->post_title;
					$link_url			 = get_permalink( $post_id );

					if ( has_post_thumbnail( $post_id ) ) {

						$result .= sprintf( '<li>%1$s', get_the_post_thumbnail( $post_id, 'thumbnail' ) );
					} else {

						$result .= '<li><span class="relate-post-no-icon"></span>';

					}
					$result .= sprintf( '<a href="%1$s">%2$s</a></li>', esc_url( $link_url ), wp_kses( $relate_post_title, array() ) );

				}
				wp_reset_postdata();
			}

			$result	 = ! empty( $result ) ? $result : $html;
			$html	 = $result_pre . $result . $result_after;
			$html	 = str_replace( array( PHP_EOL, "\t" ), array( '', '' ), $html );

			return $html;
		}
	}

}

if ( ! function_exists( 'emulsion_is_amp' ) ) {

	function emulsion_is_amp() {

		$amp_options = get_option( 'amp-options' );

		if( 'standard' == $amp_options["theme_support"] && defined('AMP__FILE__') ) {
			return true;
		}

		if ( function_exists( 'is_amp_endpoint' ) ) {

			return is_amp_endpoint();
		}



		return false;
	}

}

if ( ! function_exists( 'emulsion_related_posts_finder' ) ) {

	/**
	 *
	 * @global type $post
	 * @param type $type
	 * @return type
	 * @since 1.459
	 */
	function emulsion_related_posts_finder( $type = 'automatic' ) {

		global $post;
		$post_id			 = get_the_ID();
		$categories			 = get_the_category( $post_id );
		$default_category	 = sanitize_option( 'default_category', get_option( 'default_category' ) );
		$tags				 = wp_get_post_terms( $post_id, 'post_tag', array( "fields" => 'ids' ) );
		$recent_post_flag	 = false;
		$cat_id_biggest		 = 0;
		$cat_count_biggest	 = 0;
		$tag_id_biggest		 = 0;
		$tag_count_biggest	 = 0;

		If ( 1 < count( $categories ) ) {

			foreach ( $categories as $category ) {

				if ( $category->cat_ID == $default_category ) {

					continue;
				}
				if ( isset( $prev_count ) && $category->count > $prev_count ) {

					$cat_id_biggest		 = $category->cat_ID;
					$cat_count_biggest	 = $category->count;
				}
				$prev_count = $category->count;
			}
		}
		If ( 1 == count( $categories ) ) {

			$cat_id_biggest		 = $categories[0]->cat_ID;
			$cat_count_biggest	 = $categories[0]->count;
		}

		$count_tags = wp_get_post_terms( $post_id, 'post_tag', array( "fields" => 'all' ) );

		if ( 1 == count( $count_tags ) ) {

			$tag_id_biggest		 = $count_tags[0]->term_id;
			$tag_count_biggest	 = $count_tags[0]->count;
		} elseif ( ! empty( $count_tags ) ) {

			foreach ( $count_tags as $tag ) {

				if ( isset( $prev_count ) && $tag->count > $prev_count ) {

					$tag_id_biggest		 = $tag->term_id;
					$tag_count_biggest	 = $tag->count;
				}

				$prev_count = $tag->count;
			}

			if ( empty( $tag_id_biggest ) ) {

				$tag_id_biggest		 = $count_tags[0]->term_id;
				$tag_count_biggest	 = $count_tags[0]->count;
			}
		}
		If ( 1 == count( $categories ) && empty( $count_tags ) && intval( $default_category ) == intval( $cat_id_biggest ) ) {

			$recent_post_flag = true;
		}

		if ( 'automatic' == $type ) {

			if ( true == $recent_post_flag ) {

				return array( 'recent_post' => 0 );
			} else {

				if ( $tag_count_biggest > $cat_count_biggest && intval( $default_category ) !== intval( $cat_id_biggest ) ) {

					return array( 'post_tag' => $tag_id_biggest );
				} elseif ( $tag_count_biggest < $cat_count_biggest && intval( $default_category ) !== intval( $cat_id_biggest ) ) {

					return array( 'category' => $cat_id_biggest );
				} else {

					$tag = count( get_terms( 'post_tag', array( 'hide_empty' => false, ) ) );
					$cat = count( get_terms( 'category', array( 'hide_empty' => false, ) ) );

					if ( $tag > $cat ) {
						return array( 'post_tag' => $tag_id_biggest );
					} else {
						return array( 'category' => $cat_id_biggest );
					}
				}
			}
		}

		if ( 'category' == $type ) {
			return array( 'category' => $cat_id_biggest );
		}
		if ( 'post_tag' == $type ) {
			return array( 'post_tag' => $tag_id_biggest );
		}
		if ( 'recent_posts' == $type ) {
			return array( 'recent_post' => 0 );
		}
	}

}

if ( ! function_exists( 'emulsion_current_layout_type' ) ) {

	/**
	 * Determine whether the current page is a grid layout or a stream layout
	 * @return string
	 */
	function emulsion_current_layout_type() {

		return apply_filters( 'emulsion_current_layout_type', 'list' );
	}

}

/**
 * Theme varsion and slug
 * @param type $echo
 * @return string
 */
function emulsion_version( $echo = false ) {

	$emulsion_current_data			 = wp_get_theme();
	$emulsion_current_data_version	 = $emulsion_current_data->get( 'Version' );

	if ( is_child_theme() ) {

		/**
		 * If you are using child theme, version queries may remain unchanged
		 * when parent themes are updated, sometimes cached
		 */
		$emulsion_this_parent_theme		 = wp_get_theme( get_template() );
		$emulsion_current_data_version	 = $emulsion_this_parent_theme->get( 'Version' ) .
				'-' . $emulsion_current_data_version;
	}

	if ( $echo == true ) {

		echo sanitize_text_field( $emulsion_current_data_version );
	} else {

		return sanitize_text_field( $emulsion_current_data_version );
	}
}

if ( ! function_exists( 'emulsion_metabox_display_control' ) ) {

	function emulsion_metabox_display_control( $location ) {
		global $post, $emulsion_supports;

		$post_id = absint( get_the_ID() );

		$result = true;

		if ( function_exists( 'emulsion_get_supports' ) && 'header' == $location && false === emulsion_get_supports( $location ) && is_singular() ) {

			return false;
		}

		/**
		 * Fall back to the metabox settings in the plugin even if you no longer use emulsion addons plugin
		 */
		if ( is_single() ) {

			if ( metadata_exists( 'post', $post_id, 'emulsion_post_header' ) && 'header' == $location ) {
				$result = 'no_header' == get_post_meta( $post_id, 'emulsion_post_header', true ) ? false : true;
			}
			if ( metadata_exists( 'post', $post_id, 'emulsion_post_primary_menu' ) && 'menu' == $location ) {
				$result = 'no_header' == get_post_meta( $post_id, 'emulsion_post_header', true ) ? false : true;
			}
			if ( metadata_exists( 'post', $post_id, 'emulsion_post_sidebar' ) && 'sidebar' == $location ) {
				$result = 'no_sidebar' == get_post_meta( $post_id, 'emulsion_post_sidebar', true ) ? false : true;
			}
			if ( metadata_exists( 'post', $post_id, 'emulsion_post_theme_style_script' ) && 'style' == $location ) {
				$result = 'no_style' == get_post_meta( $post_id, 'emulsion_post_theme_style_script', true ) ? false : true;
			}
		}
		if ( is_page() ) {

			if ( metadata_exists( 'page', $post_id, 'emulsion_page_header' ) && 'page_header' == $location ) {
				$result = 'no_header' == get_page_meta( $post_id, 'emulsion_page_header', true ) ? false : true;
			}
			if ( metadata_exists( 'page', $post_id, 'emulsion_page_primary_menu' ) && 'page_menu' == $location ) {
				$result = 'no_header' == get_page_meta( $post_id, 'emulsion_page_header', true ) ? false : true;
			}
			if ( metadata_exists( 'page', $post_id, 'emulsion_page_sidebar' ) && 'page_sidebar' == $location ) {
				$result = 'no_sidebar' == get_page_meta( $post_id, 'emulsion_page_sidebar', true ) ? false : true;
			}
			if ( metadata_exists( 'page', $post_id, 'emulsion_page_theme_style_script' ) && 'page_style' == $location ) {
				$result = 'no_style' == get_page_meta( $post_id, 'emulsion_page_theme_style_script', true ) ? false : true;
			}
		}

		return apply_filters( 'emulsion_metabox_display_control', $result, $location, $post_id, is_single(), is_page() );
	}

}
if ( ! function_exists( 'emulsion_do_fse' ) ) {

	/**
	 * Rendering posts
	 * Call the required template part file.
	 */
	function emulsion_do_fse() {

		if ( function_exists( 'wp_is_block_theme' ) ) {

			return wp_is_block_theme();
		}

		if ( ! function_exists( 'gutenberg_is_fse_theme' ) ) {

			return false;
		}

		if ( ! gutenberg_is_fse_theme() ) {

			return false;
		}

		if ( ! emulsion_the_theme_supports( 'full_site_editor' ) ) {

			return false;
		}

		if ( 'fse' == get_theme_mod( 'emulsion_editor_support' ) ) {

			return true;
		}
		if ( 'transitional' == get_theme_mod( 'emulsion_editor_support' ) ) {

			return true;
		}
		if ( 'experimental' == get_theme_mod( 'emulsion_editor_support' ) ) {

			return true;
		}

		$result = false;

		$current_template = emulsion_get_template();

		if ( false !== strstr( $current_template, '_template' ) ) {

			return true;
		}

		return apply_filters( 'emulsion_do_fse', $result );
	}

}

if ( ! function_exists( 'emulsion_content_type' ) ) {

	/**
	 * return page is full text or excerpt
	 * grid, stream return false
	 */
	function emulsion_content_type() {
		global $post;

		if ( is_singular() ) {

			return 'full_text';
		} else {


			switch ( true ) {
				case emulsion_is_posts_page():

					$setting_value = get_theme_mod( 'emulsion_layout_posts_page', emulsion_theme_default_val( 'emulsion_layout_posts_page' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_home():

					$setting_value = get_theme_mod( 'emulsion_layout_homepage', emulsion_theme_default_val( 'emulsion_layout_homepage' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_date():

					$setting_value = get_theme_mod( 'emulsion_layout_date_archives', emulsion_theme_default_val( 'emulsion_layout_date_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_category():

					$setting_value = get_theme_mod( 'emulsion_layout_category_archives', emulsion_theme_default_val( 'emulsion_layout_category_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_tag():

					$setting_value = get_theme_mod( 'emulsion_layout_tag_archives', emulsion_theme_default_val( 'emulsion_layout_tag_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_author():

					$setting_value = get_theme_mod( 'emulsion_layout_author_archives', emulsion_theme_default_val( 'emulsion_layout_author_archives' ) );

					if ( 'full_text' == $setting_value || 'excerpt' == $setting_value ) {

						return $setting_value;
					}
					break;
				case is_search():

					$setting_value = get_theme_mod( 'emulsion_layout_search_results', emulsion_theme_default_val( 'emulsion_layout_search_results' ) );

					$setting_value = str_replace( 'highlight', 'excerpt', $setting_value );
					return $setting_value;
					break;
			}

			return false;
		}
	}

}

if ( ! function_exists( 'emulsion_is_posts_page' ) ) {

	/**
	 * Conditional function. Determine if it is posts_page
	 *
	 * @return boolean
	 */
	function emulsion_is_posts_page() {

		if ( ! is_front_page() && is_home() ) {

			return true;
		}
		return false;
	}

}

if ( ! function_exists( 'emulsion_theme_addons_exists' ) ) {

	function emulsion_theme_addons_exists() {

		return function_exists( 'emulsion_get_var' );
	}

}


if ( ! function_exists( 'emulsion_customizer_have_posts_class_helper' ) ) {

	/**
	 * If the displayed page is grid layout or stream layout, grid or stream are return
	 * @return type
	 */
	function emulsion_customizer_have_posts_class_helper() {

		//Note is_front_page()) is false on customize preview

		return apply_filters( 'emulsion_customizer_have_posts_class_helper', false );
	}

}

if ( ! function_exists( 'emulsion_is_plugin_active' ) ) {

	function emulsion_is_plugin_active( $plugin ) {

		return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || emulsion_is_plugin_active_for_network( $plugin );
	}

	function emulsion_is_plugin_active_for_network( $plugin ) {
		if ( ! is_multisite() ) {
			return false;
		}

		$plugins = get_site_option( 'active_sitewide_plugins' );
		if ( isset( $plugins[$plugin] ) ) {
			return true;
		}

		return false;
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


if ( ! function_exists( 'emulsion_add_flex_container_classes' ) ) {

	function emulsion_add_flex_container_classes( $block_content, $block ) {

		$block_name = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );

		$used_layout = isset( $block['attrs']['layout'] ) ? $block['attrs']['layout'] : '';

		if ( isset( $used_layout['type'] ) && 'flex' == $used_layout['type'] ) {
			// flex
			$new_class = array(
				'is-flex-container',
				! empty( $used_layout['justifyContent'] ) ? sanitize_html_class( 'items-justified-' . $used_layout['justifyContent'] ) : '',
				! empty( $used_layout['orientation'] ) ? sanitize_html_class( 'is-' . $used_layout['orientation'] ) : ''
			);

			$block_content = emulsion_add_class( $block_content, $block_name, $new_class );
		}
		return $block_content;
	}

}


if ( ! function_exists( 'emulsion_add_layout_classes' ) ) {

	function emulsion_add_layout_classes( $block_content, $block ) {

		if( ! is_singular() ){
			return $block_content;
		}

		$block_name			 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$used_layout		 = isset( $block['attrs']['layout'] ) ? $block['attrs']['layout'] : '';

		$default_layout		 = wp_get_global_settings( array( 'layout' ) );
		$default_contentSize = sanitize_text_field( $default_layout['contentSize'] );
		$default_wideSize	 = sanitize_text_field( $default_layout['wideSize'] );

		if( ! empty( $used_layout["contentSize"] ) && '100%' == $used_layout["contentSize"] ) {

			$new_class = array('has-fluid-children');

			if( ! empty( $used_layout["wideSize"] ) ) {
				preg_match( '$(<[^>]+>)$', $block_content, $target );
				$css_variables	 = ' --thm_wide_width:' . sanitize_text_field( $used_layout["wideSize"] ) . ';';
				$css_variables	 .= ' --wp--custom--width--wide:' . sanitize_text_field( $used_layout["wideSize"] );

				if ( false !== strpos( $target[0], 'style="' ) ) {

					$new_element = str_replace( ' style="', ' style="' . $css_variables . '; ', $target[0] );
				} else {

					$new_element = str_replace( '>', ' style="' . $css_variables . ';">', $target[0] );
				}
				$block_content = str_replace( $target[0], $new_element, $block_content );

				$new_class = array('has-fluid-children', 'has-custom-wide-width');
			}

			$block_content = emulsion_add_class( $block_content, $block_name, $new_class );


			return $block_content;
		}

		if ( isset( $used_layout ) && ( ! empty( $used_layout["contentSize"] ) || ! empty( $used_layout["wideSize"] ) ) ) {

			$used_layout["wideSize"] = empty( $used_layout["wideSize"] ) ? $default_wideSize : $used_layout["wideSize"];
			$used_layout["contentSize"] = empty( $used_layout["contentSize"] ) ? $default_contentSize : $used_layout["contentSize"];

			preg_match( '$(<[^>]+>)$', $block_content, $target );

			$css_variables	 = '--thm_content_width:' . sanitize_text_field( $used_layout["contentSize"] ) . '; --thm_wide_width:' . sanitize_text_field( $used_layout["wideSize"] ) . ';';
			$css_variables	 .= '--wp--custom--width--content:' . sanitize_text_field( $used_layout["contentSize"] ) . '; --wp--custom--width--wide:' . sanitize_text_field( $used_layout["wideSize"] );

			if ( false !== strpos( $target[0], 'style="' ) ) {

				$new_element = str_replace( ' style="', ' style="' . $css_variables . '; ', $target[0] );
			} else {

				$new_element = str_replace( '>', ' style="' . $css_variables . ';">', $target[0] );
			}

			$block_content = str_replace( $target[0], $new_element, $block_content );

			$new_class = array(
				isset( $used_layout["inherit"] ) && false === $used_layout["inherit"] ? 'is-layout-enabled' : '',
				! empty( $used_layout["contentSize"] ) ? 'has-custom-content-width' : '',
				! empty( $used_layout["wideSize"] ) ? 'has-custom-wide-width' : '',
			);

			$block_content = emulsion_add_class( $block_content, $block_name, $new_class );
		}


		return $block_content;
	}

}

if ( ! function_exists( 'emulsion_add_custom_gap' ) ) {

	function emulsion_add_custom_gap( $block_content, $block ) {
		if( ! is_singular() ){
			return $block_content;
		}
		$block_name			 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$block_gap			 = isset( $block['attrs']['style']['spacing']['blockGap'] ) ? $block['attrs']['style']['spacing']['blockGap'] : '';
		$css_propaty_name	 = 'gap';
		$new_class			 = array( 'has-custom-gap' );
		$exception_block	 = array( 'wp-block-column' );
		$row_gap			 = '';
		$column_gap			 = '';
		$css_variable_name   = '--wp--style--block-gap';

		$flag = 'string';

		if ( is_array( $block_gap ) ) {

			$flag = 'array';

			$column_gap = ! empty( $block_gap['left'] ) ? esc_attr( $block_gap['left'] ) : '';

			$row_gap = ! empty( $block_gap['top'] ) ? esc_attr( $block_gap['top'] ) : '';
		}

		if ( ! empty( $block_gap ) && ! in_array( $block_name, $exception_block ) ) {

			preg_match( '$(<[^>]+>)$', $block_content, $target );

			if ( false !== strpos( $target[0], 'style="' ) ) {

				if ( 'string' == $flag ) {

					$new_element = str_replace( ' style="',
							' style="'. $css_variable_name. ':'. $block_gap.';'. $css_propaty_name . ':' . esc_attr( $block_gap ) . ';',
							$target[0] );
				}
				if ( 'array' == $flag ) {

					$new_element = str_replace( ' style="',
							' style="'. $css_variable_name. ':'. $row_gap.';' . $css_propaty_name . ':' . $row_gap . ' ' . $column_gap . ';',
							$target[0] );
				}
			} else {

				if ( 'string' == $flag ) {

					$new_element = str_replace( '>',
							' style="'. $css_variable_name. ':'. $block_gap.';' . $css_propaty_name . ':' . $block_gap . ';">',
							$target[0] );
				}
				if ( 'array' == $flag ) {

					$new_element = str_replace( '>',
							' style="'. $css_variable_name. ':'. $row_gap.';' . $css_propaty_name . ':' . $row_gap . ' ' . $column_gap . ';">',
							$target[0] );
				}
			}

			$block_content = str_replace( $target[0], $new_element, $block_content );

			$block_content = emulsion_add_class( $block_content, $block_name, $new_class );
		}

		return $block_content;
	}
}



if ( ! function_exists( 'emulsion_add_link_color_class' ) ) {

	function emulsion_add_link_color_class( $block_content, $block ) {


		$block_name = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );

		$link_color = null;

		if ( ! empty( $block['attrs'] ) ) {
			$link_color = _wp_array_get( $block['attrs'], array( 'style', 'elements', 'link', 'color', 'text' ), null );

		}


		if ( null === $link_color ) {
			return $block_content;
		}

		if ( false !== strpos( $link_color, 'var:preset|color|' )  ) {

			$index_to_splice = strrpos( $link_color, '|' ) + 1;
			$link_color_name = substr( $link_color, $index_to_splice );

			$target_class	 = 'has-link-color';
			$new_class		 = sanitize_html_class( 'has-' . $link_color_name . '-link-color' );

			if( false !== strpos( $block_content, '-link-color' ) ) {

				$block_content = preg_replace('!has-link-color!','has-link-color '. $new_class, $block_content, 1);

			}else{

				$block_content	 = emulsion_add_class( $block_content, $block_name, $new_class );
			}
		}

		if ( maybe_hash_hex_color( $link_color ) && false === strpos( $link_color, 'var:preset|color|' ) ) {

			$target_block	 = $block['innerHTML'];

			$new_block		 = str_replace( '<a ', '<a style="color:' . $link_color . ';" ', $target_block );
			$block_content	 = str_replace( $target_block, $new_block, $block_content );
		}

		return $block_content;
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

if ( ! function_exists( 'emulsion_block_editor_assets' ) ) {

	function emulsion_block_editor_assets() {

		wp_enqueue_script( 'emulsion-block', esc_url( get_template_directory_uri() . '/js/block.js' ), array( 'wp-blocks', 'wp-i18n', 'jquery' ) );

		if ( 'fse' == emulsion_get_theme_operation_mode() && current_user_can( 'edit_posts' ) ) {

			wp_register_style( 'emulsion-fse', get_template_directory_uri() . '/css/fse.css', array(), time(), 'all' );
			wp_enqueue_style( 'emulsion-fse' );

			$inline_style = emulsion_fse_editor_inline_style();
			wp_add_inline_style( 'emulsion-fse', $inline_style );

			wp_enqueue_script( 'emulsion-block-fse', esc_url( get_template_directory_uri() . '/js/block-fse.js' ), array( 'wp-blocks' ) );
		}
		if ( 'transitional' == emulsion_get_theme_operation_mode() && current_user_can( 'edit_posts' ) ) {

			wp_register_style( 'emulsion-fse-transitional', get_template_directory_uri() . '/css/fse-transitional.css', array(), time(), 'all' );
			wp_enqueue_style( 'emulsion-fse-transitional' );

			$inline_style = emulsion_fse_transitional_editor_inline_style();
			wp_add_inline_style( 'emulsion-fse-transitional', $inline_style );

		}
	}

}

if ( ! function_exists( 'emulsion_fse_footer_content_filter' ) ) {

	function emulsion_fse_footer_content_filter( $content, $block ) {

		if ( 'footer' == $block['attrs']['slug'] ) {

			$policy_page_link	 = '';
			$policy_page_title	 = '';
			$policy_page_url	 = '';
			$policy_page_id		 = (int) get_option( 'wp_page_for_privacy_policy' );

			if ( $policy_page_id && get_post_status( $policy_page_id ) === 'publish' ) {

				$policy_page_title	 = wp_kses_post( get_the_title( $policy_page_id ) );
				$policy_page_url	 = esc_url( get_permalink( $policy_page_id ) );
				$policy_page_link	 = sprintf( '<a href="%1$s" class="emulsion-privacy-policy">%2$s</a>', esc_url( $policy_page_url ), $policy_page_title );
			}

			$html = str_replace( array( '%current_year%', '%privacy_policy%' ), array( date( 'Y' ), $policy_page_link ), $content );

			return $html;
		}
		return $content;
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


if ( ! function_exists( 'emulsion_fse_background_color_class' ) ) {

	function emulsion_fse_background_color_class() {


		if ( 'theme' == emulsion_get_theme_operation_mode() ) {
			return;
		}

		$style = wp_get_global_stylesheet( array( 'styles' ) );

		if ( false !== preg_match( '$body(\s*)?\{([^\}]*)?(background-color:|background:)([^\;]*)\;$', $style, $regs ) && ! empty( $regs[4] ) ) {

			$fse_class	 = sanitize_html_class( 'is-fse-bg-' . $regs[4] );
			$color		 = emulsion_accessible_color( trim( $regs[4] ) );



			if ( '#ffffff' == $color ) {

				$fse_class .= ' is-fse-dark';
			} elseif ( '#333333' == $color ) {

				$fse_class .= ' is-fse-light';
			}
			return $fse_class;
		}
		return 'is-fse-bg-default';
	}

}

if ( ! function_exists( 'emulsion_accessible_color' ) ) {

	/**
	 * Calculate text color from background color
	 * @param type $hex
	 * @param type $alpha
	 * @return type
	 */
	function emulsion_accessible_color( $hex_background_color = '' ) {

		$hex = str_replace( '#', '', $hex_background_color );
		$d	 = '[a-fA-F0-9]';

		if ( preg_match( "/^($d$d)($d$d)($d$d)\$/", $hex, $rgb ) ) {

			$r	 = hexdec( $rgb[1] );
			$g	 = hexdec( $rgb[2] );
			$b	 = hexdec( $rgb[3] );
		} elseif ( preg_match( "/^($d)($d)($d)$/", $hex, $rgb ) ) {

			$r	 = hexdec( $rgb[1] . $rgb[1] );
			$g	 = hexdec( $rgb[2] . $rgb[2] );
			$b	 = hexdec( $rgb[3] . $rgb[3] );
		} else {

			return false;
		}

		$brightness	 = round( $r * 299 + $g * 587 + $b * 114 ) / 1000;
		$light		 = round( 255 * 299 + 244 * 587 + 255 * 114 ) / 1000;

		if ( $brightness < $light / 2 ) {

			$color = '#ffffff';
		} else {

			$color = '#333333';
		}

		return $color;
	}

}

if ( ! function_exists( 'emulsion_remove_spaces_from_css' ) ) {

	/**
	 * Remove spaces from stylesheet
	 * When user logged in, output readable CSS, usually minified CSS
	 */
	function emulsion_remove_spaces_from_css( $css = '' ) {

		if ( ! is_user_logged_in() ) {

			$css = str_replace( array( "\n", "\r", "\t", '&quot;', '\"' ), array( "", "", "", '"', '"' ), $css );
		} else {

			$css = str_replace( array( '&quot;', '\"' ), array( '"', '"' ), $css );
		}

		return $css;
	}

}

if ( ! function_exists( 'emulsion_add_class' ) ) {

	function emulsion_add_class( $html, $target_class, $class ) {

		if ( 'wp-block-navigation' == $target_class ) {

			$regex = '/<[^>]*(class=("|\')[^("|\')]*' . $target_class . '(\s|[^(-|_|"|\')]*))"[^>]*>/';
		} else {
			$regex = '/<[^>]*(class=("|\')[^("|\')]*' . $target_class . '(\s*[^("|\')]*))"[^>]*>/';
		}

		return preg_replace_callback(
				$regex,
				function ( $matches ) use ( $target_class, $class ) {

					$class = emulsion_class_name_sanitize( $class );

					$trans = array(
						' ' . $target_class . ' '	 => ' ' . $target_class . ' ' . $class . ' ',
						' ' . $target_class			 => ' ' . $target_class . ' ' . $class,
						$target_class . ' '			 => $target_class . ' ' . $class . ' ',
						'\'' . $target_class . '\''	 => '\'' . $target_class . ' ' . $class . '\'',
						'"' . $target_class . '"'	 => '"' . $target_class . ' ' . $class . '"',
					);

					return strtr( $matches[0], $trans );
				},
				$html
		);
	}

}

if ( ! function_exists( 'emulsion_theme_google_tracking_code' ) ) {

	function emulsion_theme_google_tracking_code() {

		if ( emulsion_is_amp() ) {

			return;
		}

		$tag			 = sanitize_text_field( get_theme_mod( 'emulsion_google_analytics_tracking_code' ) );
		$flag			 = get_theme_mod( 'emulsion_instantclick', emulsion_the_theme_supports( 'instantclick' ) ) ? 'enable' : 'disable';
		$theme_mod_name	 = 'emulsion_google_analytics_' . $tag . $flag;

		if ( $result = get_theme_mod( $theme_mod_name, false ) ) {

			echo $result;
			return;
		}
	}

}
if ( ! function_exists( 'emulsion_oembed_object_wrapper' ) ) {

	/**
	 * Not Block editor embed media wrapper
	 */
	function emulsion_oembed_object_wrapper( $html, $url, $type = '' ) {
		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			return $html;
		}
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
if ( ! function_exists( 'emulsion_accesible_site_title_link_control' ) ) {

	function emulsion_accesible_site_title_link_control( $content, $block ) {

		if ( ( is_home() && ! is_front_page() && ! is_paged() )		 // default home
				|| ( ! is_home() && is_front_page() ) // Static Front Page
		) {

			return strip_tags( $content, '<h1><h2>' );
		}

		return $content;
	}

}
if ( ! function_exists( 'emulsion_accesible_post_title_link_control' ) ) {

	function emulsion_accesible_post_title_link_control( $content, $block ) {

		if ( is_singular() ) {
			return strip_tags( $content, '<h1><h2><h3>' );
		}

		return $content;
	}

}


if ( ! function_exists( 'emulsion_fallback_block_class' ) ) {

	function emulsion_fallback_block_class( $block_content, $block ) {

		$block_name		 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$target_block	 = array( 'wp-block-post-template', 'wp-block-audio', 'wp-block-buttons', 'wp-block-columns', 'wp-block-file', 'wp-block-group', 'wp-block-post-excerpt', 'wp-block-table', 'wp-block-navigation', 'wp-block-cover' );

		if ( in_array( $block_name, $target_block ) ) {

			$new_class		 = array( 'wp-block' );
			$block_content	 = emulsion_add_class( $block_content, $block_name, $new_class );
		}

		return $block_content;
	}

}


if ( ! function_exists( 'emulsion_relate_posts_when_addons_inactive' ) ) {

	function emulsion_relate_posts_when_addons_inactive( $content, $block ) {

		$block_name = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );

		if ( 'wp-block-shortcode' == $block_name && ! emulsion_theme_addons_exists() ) {

			$content = str_replace( '[emulsion_relate_posts]', '', $content );
		}

		return $content;
	}

}

function emulsion_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 'fse' !== emulsion_get_theme_operation_mode() ) {
		if ( $width > 1600 ) {
			return '(max-width: 720px) 768px, 1600px';
		} else {
			return $sizes;
		}
	} else {
		if ( $width > 768 && ! is_singular() ) {
			return '768px';
		} else {
			return $sizes;
		}
	}
}

add_filter( 'wp_calculate_image_sizes', 'emulsion_content_image_sizes_attr', 10, 2 );

function emulsion_is_custom_post_type() {
	global $post;

	$all_custom_post_types = get_post_types( array( '_builtin' => false ) );

	if ( empty( $all_custom_post_types ) ) {

		return false;
	}

	$custom_types = array_keys( $all_custom_post_types );

	if ( ! empty( $post ) ) {

		$current_post_type = $post->post_type;

		if ( in_array( $current_post_type, $custom_types ) ) {

			return true;
		} else {

			return false;
		}
	} else {

		return false;
	}
}

if ( ! function_exists( 'emulsion_block_template_part' ) ) {

	function emulsion_block_template_part( $part ) {

		if ( ! function_exists( 'gutenberg_get_block_template' ) && ! function_exists( 'get_block_template' ) ) {

			printf( '<div class="error" style="%2$s">%1$s</div>', esc_html__( 'Required gutenberg plugin', 'emulsion' ), 'padding:1.5rem; text-align:center;border:1px dashed red;' );

			return;
		} else {

			if ( function_exists( 'get_block_template' ) ) {

				$template_part = get_block_template( get_stylesheet() . '//' . $part, 'wp_template_part' );
			} else {

				$template_part = gutenberg_get_block_template( get_stylesheet() . '//' . $part, 'wp_template_part' );
			}

			if ( ! $template_part || empty( $template_part->content ) ) {

				$class	 = 'not-found-wp-block-template-part-' . sanitize_html_class( $part );
				$class	 .= is_user_logged_in() ? '' : ' screen-reader-text';

				printf( '<div class="%3$s" style="%2$s">%1$s</div>',
						esc_html__( 'Can not find template', 'emulsion' ),
						'padding:1.5rem; text-align:center;border:1px dashed red;',
						$class );
				return;
			}

			$theme_classes = array(
				'wp-block-template-part-' . $template_part->slug,
				'wp-block-template-part',
				'included-block-template-part',
				'alignfull',
			);

			$additional_classes	 = array();
			$tag_name			 = 'div';

			if ( 'header' == $template_part->area ) {

				$additional_classes	 = array( 'fse-header', 'header-layer', 'html-header' );
				"#eeeeee" !== get_theme_mod('emulsion_header_background_color') ? $additional_classes[] = 'has-customizer-bg': '';
				$tag_name			 = 'header';
				if ( 'transitional' == emulsion_get_theme_operation_mode() && 'default' == get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {
					return;
				}

			}


			if ( 'footer' == $template_part->area ) {

				$additional_classes	 = array( 'fse-footer', 'footer-layer', 'html-footer' );
				"#eeeeee" !== get_theme_mod('emulsion_header_background_color') ? $additional_classes[] = 'has-customizer-bg': '';
				$tag_mame			 = 'footer';

				if ( 'transitional' == emulsion_get_theme_operation_mode() && 'default' == get_theme_mod( 'emulsion_footer_template', emulsion_theme_default_val( 'emulsion_footer_template', 'default') ) ) {
					return;
				}

				$policy_page_link	 = '';
				$policy_page_title	 = '';
				$policy_page_url	 = '';
				$policy_page_id		 = (int) get_option( 'wp_page_for_privacy_policy' );

				if ( $policy_page_id && get_post_status( $policy_page_id ) === 'publish' ) {

					$policy_page_title	 = wp_kses_post( get_the_title( $policy_page_id ) );
					$policy_page_url	 = esc_url( get_permalink( $policy_page_id ) );
					$policy_page_link	 = sprintf( '<a href="%1$s" class="emulsion-privacy-policy">%2$s</a>', esc_url( $policy_page_url ), $policy_page_title );
				}

				$template_part->content = str_replace( array( '%current_year%', '%privacy_policy%' ), array( date( 'Y' ), $policy_page_link ), $template_part->content );
			}

			$theme_classes	 = array_merge( $theme_classes, $additional_classes );
			$theme_classes	 = apply_filters( 'wp-block-template-part-' . $template_part->slug, $theme_classes );
			$theme_classes	 = emulsion_class_name_sanitize( $theme_classes );

			printf( '<%1$s class="%3$s">%2$s</%1$s>', $tag_name, do_blocks( $template_part->content ), $theme_classes );

			return;
		}
	}

}

function emulsion_get_template() {

	global $template;

	if ( 'fse' == emulsion_get_theme_operation_mode() ) {
		//return;
	}

	$current_template_class = str_replace( '.', '-', basename( $template ) );

	$template = sanitize_html_class( $current_template_class );

	if ( 'template-canvas-php' == $template ) {
		/*
		  $filter_list = array( 'embed_template', '404_template', 'search_template',
		  'frontpage_template', 'home_template', 'privacypolicy_template',
		  'taxonomy_template', 'attachment_template', 'single_template',
		  'page_template', 'singular_template', 'category_template',
		  'tag_template', 'author_template', 'date_template',
		  'archive_template', 'index_template', ); */

		/**
		 * if set Custom Template
		 */
		$post_id		 = get_the_ID();
		$custom_template = get_post_meta( $post_id, '_wp_page_template', true );

		if ( ! empty( $custom_template ) && 'default' !== $custom_template ) {

			return sanitize_html_class( $custom_template . '_template' );
		}

		if ( is_404() && is_readable( get_template_directory() . '/block-templates/404.html' ) ) {
			return '404_template';
		}
		if ( is_search() && is_readable( get_template_directory() . '/block-templates/search.html' ) ) {
			return 'search_template';
		}
		if ( ! is_home() && is_front_page() && is_readable( get_template_directory() . '/block-templates/front-page.html' ) ) {
			return 'front-page_template';
		}
		if ( is_home() && is_readable( get_template_directory() . '/block-templates/home.html' ) ) {
			return 'home_template';
		}
		if ( is_privacy_policy() && is_readable( get_template_directory() . '/block-templates/privacy-policy.html' ) ) {
			return 'privacy-policy_template';
		}
		if ( is_tax() && is_readable( get_template_directory() . '/block-templates/taxsonomy.html' ) ) {
			return 'taxonomy_template';
		}
		if ( is_attachment() && is_readable( get_template_directory() . '/block-templates/attachment.html' ) ) {
			return 'attachment_template';
		}
		if ( is_single() && is_readable( get_template_directory() . '/block-templates/single.html' ) ) {
			return 'single_template';
		}
		if ( is_page() && is_readable( get_template_directory() . '/block-templates/page.html' ) ) {
			return 'page_template';
		}
		if ( is_singular() && is_readable( get_template_directory() . '/block-templates/singular.html' ) ) {
			return 'singular_template';
		}
		if ( is_category() && is_readable( get_template_directory() . '/block-templates/category.html' ) ) {
			return 'category_template';
		}
		if ( is_tag() && is_readable( get_template_directory() . '/block-templates/tag.html' ) ) {
			return 'tag_template';
		}
		if ( is_author() && is_readable( get_template_directory() . '/block-templates/author.html' ) ) {
			return 'author_template';
		}
		if ( is_date() && is_readable( get_template_directory() . '/block-templates/date.html' ) ) {
			return 'date_template';
		}
		if ( is_archive() && is_readable( get_template_directory() . '/block-templates/archive.html' ) ) {
			return 'archive_template';
		}

		return 'index_template';
	}

	if ( is_attachment() ) {
		return 'atachment-php';
	}
	return $template;
}

if ( ! function_exists( 'emulsion_custom_field_css' ) ) {

	function emulsion_custom_field_css() {

		$post_id			 = absint( get_the_ID() );
		$meta_style			 = '';
		$post_type			 = get_post_type();
		$custom_css_class	 = 'has-custom-style';
		$meta_field			 = 'css';

		if( ! is_singular() ) {
			return;
		}

		if ( metadata_exists( $post_type, $post_id, $meta_field ) ) {

			$meta_style = get_metadata( $post_type, $post_id, $meta_field, true );

			add_filter(
					'body_class', function ( $class ) use ( $custom_css_class ) {
						$class[] = $custom_css_class;
						return $class;
					} );

			$meta_style_css = preg_replace_callback( '![^}]+{[^}]+}!siu', function ( $matches ) use ( $post_id ) {

				$result = '';
				foreach ( $matches as $match ) {

					if ( is_singular() ) {

						if ( false === strstr( $match, 'has-custom-style' ) ) {

							$result .= sprintf( ' .has-custom-style.postid-%1$d %2$s', $post_id, $match );
						} else {

							$result .= $match;
						}
					}
				}

				return $result;
			}, $meta_style );

			return emulsion_sanitize_css( $meta_style_css );
		}
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
