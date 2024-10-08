<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( ! function_exists( 'emulsion_get_theme_operation_mode' ) ) {

	function emulsion_get_theme_operation_mode() {

		return sanitize_text_field( get_theme_mod( 'emulsion_editor_support', 'fse' ) );
	}

}

if ( ! function_exists( 'emulsion_the_theme_supports' ) ) {

	function emulsion_the_theme_supports( $name ) {

		if ( 'fse' == emulsion_get_theme_operation_mode() ) {
			// To Do
			//return false;
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
			'grid'						 => array( 'default' => array( array() ) ),
			'stream'					 => array( 'default' => array( array() ) ),
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

			//return emulsion_get_supports( $name );
		}

		return apply_filters( 'emulsion_the_theme_supports', $emulsion_default_supports[$name]['default'], $name );
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

			return '';
		}
		$html		 = sprintf( '<li>%1$s</li>', esc_html__( 'Not Found', 'emulsion' ) );
		$result_pre	 = sprintf( '<!-- wp:group {"className":"emulsion-block-pattern-relate-posts wrap-emulsion_relate_posts", "layout":{"type":"constrained"}} -->'
				. '<div class="emulsion-block-pattern-relate-posts wp-block-group wrap-emulsion_relate_posts" id="relate-posts">'
				. '<!-- wp:heading --><h2 class="relate-posts-title alignnone">%1$s</h2><!-- /wp:heading -->'
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

		$amp_options = get_option( 'amp-options', false );

		if ( false === $amp_options ) {

			return false;
		}

		if ( ! empty( $amp_options["theme_support"] ) && 'standard' == $amp_options["theme_support"] && defined( 'AMP__FILE__' ) ) {

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

			if ( ! empty( $post_id ) && metadata_exists( 'post', $post_id, 'emulsion_post_header' ) && 'header' == $location ) {
				$result = 'no_header' == get_post_meta( $post_id, 'emulsion_post_header', true ) ? false : true;
			}
			if ( ! empty( $post_id ) && metadata_exists( 'post', $post_id, 'emulsion_post_primary_menu' ) && 'menu' == $location ) {
				$result = 'no_header' == get_post_meta( $post_id, 'emulsion_post_header', true ) ? false : true;
			}
			if ( ! empty( $post_id ) && metadata_exists( 'post', $post_id, 'emulsion_post_sidebar' ) && 'sidebar' == $location ) {
				$result = 'no_sidebar' == get_post_meta( $post_id, 'emulsion_post_sidebar', true ) ? false : true;
			}
			if ( ! empty( $post_id ) && metadata_exists( 'post', $post_id, 'emulsion_post_theme_style_script' ) && 'style' == $location ) {
				$result = 'no_style' == get_post_meta( $post_id, 'emulsion_post_theme_style_script', true ) ? false : true;
			}
		}
		if ( is_page() ) {

			if ( ! empty( $post_id ) && metadata_exists( 'page', $post_id, 'emulsion_page_header' ) && 'page_header' == $location ) {
				$result = 'no_header' == get_page_meta( $post_id, 'emulsion_page_header', true ) ? false : true;
			}
			if ( ! empty( $post_id ) && metadata_exists( 'page', $post_id, 'emulsion_page_primary_menu' ) && 'page_menu' == $location ) {
				$result = 'no_header' == get_page_meta( $post_id, 'emulsion_page_header', true ) ? false : true;
			}
			if ( ! empty( $post_id ) && metadata_exists( 'page', $post_id, 'emulsion_page_sidebar' ) && 'page_sidebar' == $location ) {
				$result = 'no_sidebar' == get_page_meta( $post_id, 'emulsion_page_sidebar', true ) ? false : true;
			}
			if ( ! empty( $post_id ) && metadata_exists( 'page', $post_id, 'emulsion_page_theme_style_script' ) && 'page_style' == $location ) {
				$result = 'no_style' == get_page_meta( $post_id, 'emulsion_page_theme_style_script', true ) ? false : true;
			}
		}

		return apply_filters( 'emulsion_metabox_display_control', $result, $location, $post_id, is_single(), is_page() );
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

if ( ! function_exists( 'emulsion_block_group_variation_classes' ) ) {

	function emulsion_block_group_variation_classes( $block_content, $block ) {

		$block_name		 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$transient_name	 = md5( serialize( $block ) );

		if ( 'wp-block-group' == $block_name ) {

			$transient = get_transient( $transient_name );

			if ( ! is_user_logged_in() && false !== $transient && ! empty( $tramsoemt ) ) {

				return $transient;
			}

			if ( ! empty( $block['attrs']['layout']["orientation"] ) && 'vertical' == $block['attrs']['layout']["orientation"] ) {

				$new_class		 = array(
					'is-layout-flex',
					'is-vertical',
					! empty( $block['attrs']['layout']['justifyContent'] ) ? sanitize_html_class( 'items-justified-' . $block['attrs']['layout']['justifyContent'] ) : '',
					! empty( $block['attrs']['layout']['orientation'] ) ? sanitize_html_class( 'is-' . $block['attrs']['layout']['orientation'] ) : ''
				);
				$block_content	 = emulsion_add_class( $block_content, $block_name, $new_class );
			} else {

				$new_class		 = array(
					! empty( $block['attrs']['layout']["type"] ) ? sanitize_html_class( 'is-layout-' . $block['attrs']['layout']["type"] ) : '',
					! empty( $block['attrs']['layout']["flexWrap"] ) ? sanitize_html_class( 'is-' . $block['attrs']['layout']["flexWrap"] ) : '',
					! empty( $block['attrs']['layout']['justifyContent'] ) ? sanitize_html_class( 'items-justified-' . $block['attrs']['layout']['justifyContent'] ) : '',
					! empty( $block['attrs']['layout']['orientation'] ) ? sanitize_html_class( 'is-' . $block['attrs']['layout']['orientation'] ) : ''
				);
				$block_content	 = emulsion_add_class( $block_content, $block_name, $new_class );
			}

			if ( ! empty( $block["attrs"]["style"]["layout"] ) ) {
				$p			 = new WP_HTML_Tag_Processor( $block_content );
				$p->next_tag( array( 'class_name' => $block_name ) );
				$rule_set	 = '';

				if ( ! empty( $block['attrs']['style']['layout']['columnSpan'] ) ) {

					$rule_set .= 'grid-column: span ' . absint( $block['attrs']['style']['layout']['columnSpan'] ) . ';margin:0;';
				}

				if ( ! empty( $block['attrs']['style']['layout']['rowSpan'] ) ) {

					$rule_set .= 'grid-row: span ' . absint( $block['attrs']['style']['layout']['rowSpan'] ) . ';';
				}
				$p->set_attribute( 'style', $rule_set );
				$block_content = $p->get_updated_html();
			}

			if ( ! empty( $block['attrs']['layout']['minimumColumnWidth'] ) ) {

				$p				 = new WP_HTML_Tag_Processor( $block_content );
				$p->next_tag( array( 'class_name' => $block_name ) );
				$p->add_class( 'is-layout-grid' );
				$style_value	 = esc_attr( $block['attrs']['layout']['minimumColumnWidth'] );
				$p->set_attribute( 'style', 'grid-template-columns: repeat(auto-fill, minmax(min(' . $style_value . ' , 100%), 1fr));' );
				$block_content	 = $p->get_updated_html();
			}

			set_transient( $transient_name, trim( $block_content ), DAY_IN_SECONDS );
		}


		return $block_content;
	}

}


if ( ! function_exists( 'emulsion_add_flex_container_classes' ) ) {

	function emulsion_add_flex_container_classes( $block_content, $block ) {

		$transient_name	 = md5( serialize( $block ) );
		$transient		 = get_transient( $transient_name );

		if ( ! is_user_logged_in() && false !== $transient && ! empty( $tramsoemt ) ) {

			return $transient;
		}
		$block_name		 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		// pending: , 'wp-block-query'
		$target_blocks	 = array( 'wp-block-gallery', 'wp-block-columns', 'wp-block-group', 'wp-block-post-content', 'wp-block-query-pagination', 'wp-block-buttons', 'wp-block-social-links', 'wp-block-post-template' );

		$default_layout = wp_get_global_settings( array( 'layout' ) );

		if ( ! in_array( $block_name, $target_blocks, true ) ) {

			return $block_content;
		}


		if ( 'wp-block-gallery' == $block_name ) {

			$block['attrs']['layout']['type'] = 'flex';
		}


		$used_layout = isset( $block['attrs']['layout'] ) ? $block['attrs']['layout'] : '';

		if ( ! empty( $used_layout['type'] ) && 'grid' == $used_layout['type'] ) {
			//wp-block-post-template

			$layout_type = $used_layout['type'];

			$column_count = isset( $used_layout['columnCount'] ) ? absint( $used_layout['columnCount'] ) : '';

			$new_class		 = array(
				! empty( $layout_type ) ? sanitize_html_class( 'is-layout-' . $layout_type ) : '',
				! empty( $column_count ) ? sanitize_html_class( 'columns-' . $column_count ) : ''
			);
			$block_content	 = emulsion_add_class( $block_content, $block_name, $new_class );
		}

		$used_layout = isset( $block['attrs']['layout'] ) ? $block['attrs']['layout'] : '';

		if ( ! empty( $used_layout['type'] ) && ! empty( $default_layout["definitions"][$used_layout['type']]["className"] ) ) {

			$new_class = sanitize_html_class( $default_layout["definitions"][$used_layout['type']]["className"] );

			if ( 'flex' !== $used_layout['type'] && false === strstr( $block_content, $new_class ) ) {

				$block_content = emulsion_add_class( $block_content, $block_name, $new_class );
			}

			if ( 'flex' == $used_layout['type'] && false === strstr( $block_content, $new_class ) ) {

				$new_class = array(
					//'is-flex-container',
					$new_class,
					! empty( $used_layout['justifyContent'] ) ? sanitize_html_class( 'items-justified-' . $used_layout['justifyContent'] ) : '',
					! empty( $used_layout['orientation'] ) ? sanitize_html_class( 'is-' . $used_layout['orientation'] ) : ''
				);

				$block_content = emulsion_add_class( $block_content, $block_name, $new_class );
			}
		}
		if ( ! empty( $used_layout['verticalAlignment'] ) ) {

			preg_match( '$(<[^>]+>)$', $block_content, $target );

			$property_value = array( "top" => "flex-start", "bottom" => "end" );

			$css_style = 'align-items:' . sanitize_text_field( strtr( $used_layout['verticalAlignment'], $property_value ) );

			if ( false !== strpos( $target[0], 'style="' ) ) {

				$new_element = str_replace( ' style="', ' style="' . $css_style . '; ', $target[0] );
			} else {

				$new_element = str_replace( '>', ' style="' . $css_style . ';">', $target[0] );
			}
			$block_content = str_replace( $target[0], $new_element, $block_content );
		}
		if ( ! empty( $block['attrs']['layout'] ) ) {

			$layout_type = ! empty( $block['attrs']['layout']['type'] ) ? sanitize_html_class( 'is-layout-' . $block['attrs']['layout']['type'] ) : 'is-layout-undefined';

			$new_class = array(
				$layout_type,
				! empty( $block['attrs']['layout']['justifyContent'] ) ? sanitize_html_class( 'is-content-justification-' . $block['attrs']['layout']['justifyContent'] ) : '',
				! empty( $used_layout['orientation'] ) ? sanitize_html_class( 'is-' . $used_layout['orientation'] ) : '',
			);

			$block_content = emulsion_add_class( $block_content, $block_name, $new_class );
		}

		set_transient( $transient_name, trim( $block_content ), DAY_IN_SECONDS );
		return $block_content;
	}

}


if ( ! function_exists( 'emulsion_add_layout_classes' ) ) {

	function emulsion_add_layout_classes( $block_content, $block ) {

		if ( ! is_singular() ) {
			//return $block_content;
		}
		$transient_name	 = __FUNCTION__;
		$transient		 = get_transient( $transient_name );

		if ( ! is_user_logged_in() && false !== $transient && ! empty( $tramsoemt ) ) {

			return $transient;
		}

		$block_name	 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$used_layout = isset( $block['attrs']['layout'] ) ? $block['attrs']['layout'] : '';

		$default_layout		 = wp_get_global_settings( array( 'layout' ) );
		$default_contentSize = ! empty( $default_layout['contentSize'] ) ? sanitize_text_field( $default_layout['contentSize'] ) : '';
		$default_wideSize	 = ! empty( $default_layout['wideSize'] ) ? sanitize_text_field( $default_layout['wideSize'] ) : '';

		if ( ! empty( $used_layout["contentSize"] ) && '100%' == $used_layout["contentSize"] ) {

			$new_class = array( 'is-layout-flow' );

			if ( ! empty( $used_layout["wideSize"] ) ) {
				preg_match( '$(<[^>]+>)$', $block_content, $target );
				$css_variables	 = ' --thm_wide_width:' . sanitize_text_field( $used_layout["wideSize"] ) . ';';
				$css_variables	 .= ' --wp--style--global--wide-size:' . sanitize_text_field( $used_layout["wideSize"] );

				if ( false !== strpos( $target[0], 'style="' ) ) {

					$new_element = str_replace( ' style="', ' style="' . $css_variables . '; ', $target[0] );
				} else {

					$new_element = str_replace( '>', ' style="' . $css_variables . ';">', $target[0] );
				}
				$block_content = str_replace( $target[0], $new_element, $block_content );

				$new_class = array( 'is-layout-flow', 'has-custom-wide-width' );
			}

			$block_content = emulsion_add_class( $block_content, $block_name, $new_class );

			//return $block_content;
		}

		if ( isset( $used_layout ) && ( ! empty( $used_layout["contentSize"] ) || ! empty( $used_layout["wideSize"] ) ) ) {

			$used_layout["wideSize"]	 = empty( $used_layout["wideSize"] ) ? $default_wideSize : $used_layout["wideSize"];
			$used_layout["contentSize"]	 = empty( $used_layout["contentSize"] ) ? $default_contentSize : $used_layout["contentSize"];

			preg_match( '$(<[^>]+>)$', $block_content, $target );

			$css_variables	 = '--thm_content_width:' . sanitize_text_field( $used_layout["contentSize"] ) . '; --thm_wide_width:' . sanitize_text_field( $used_layout["wideSize"] ) . ';';
			$css_variables	 .= '--wp--style--global--content-size:' . sanitize_text_field( $used_layout["contentSize"] ) . '; --wp--style--global--wide-size:' . sanitize_text_field( $used_layout["wideSize"] );

			if ( false !== strpos( $target[0], 'style="' ) ) {

				$new_element = str_replace( ' style="', ' style="' . $css_variables . '; ', $target[0] );
			} else {

				$new_element = str_replace( '>', ' style="' . $css_variables . ';">', $target[0] );
			}


			if ( false == strpos( $target[0], 'article' ) ) {
				$block_content = str_replace( $target[0], $new_element, $block_content );
			}

			$new_class = array(
				! empty( $used_layout["contentSize"] ) ? 'has-custom-content-width' : '',
				! empty( $used_layout["wideSize"] ) ? 'has-custom-wide-width' : '',
			);

			$block_content = emulsion_add_class( $block_content, $block_name, $new_class );
		}
		set_transient( $transient_name, trim( $block_content ), DAY_IN_SECONDS );

		return $block_content;
	}

}
if ( ! function_exists( 'emulsion_style_attribute_variables_fix' ) ) {

	function emulsion_style_attribute_variables_fix( $attrbute_value ) {

		if ( is_array( $attrbute_value ) || ( ! empty( $attrbute_value ) && false === strstr( $attrbute_value, 'var:' ) ) ) {

			return $attrbute_value;
		}

		$changes = array(
			'var:'	 => 'var(--wp--',
			'|'		 => '--'
		);
		return strtr( $attrbute_value, $changes ) . ')';
	}

}
if ( ! function_exists( 'emulsion_add_spacing' ) ) {

	function emulsion_add_spacing( $block_content, $block ) {

		//wp-block-group.is-layout-grid

		$target_blocks	 = array( 'wp-block-group' );
		$tatget_type	 = array( 'grid' );

		$block_name		 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$margin_top		 = isset( $block['attrs']['style']['spacing']['margin']['top'] ) ? emulsion_style_attribute_variables_fix( $block['attrs']['style']['spacing']['margin']['top'] ) : '';
		$margin_property = ! empty( $margin_top ) ? 'margin-top:' . $margin_top . ';' : '';
		$margin_right	 = isset( $block['attrs']['style']['spacing']['margin']['right'] ) ? emulsion_style_attribute_variables_fix( $block['attrs']['style']['spacing']['margin']['right'] ) : '';
		$margin_property .= ! empty( $margin_right ) ? 'margin-top:' . $margin_right . ';' : '';
		$margin_bottom	 = isset( $block['attrs']['style']['spacing']['margin']['bottom'] ) ? emulsion_style_attribute_variables_fix( $block['attrs']['style']['spacing']['margin']['bottom'] ) : '';
		$margin_property .= ! empty( $margin_bottom ) ? 'margin-bottom:' . $margin_bottom . ';' : '';
		$margin_left	 = isset( $block['attrs']['style']['spacing']['margin']['left'] ) ? emulsion_style_attribute_variables_fix( $block['attrs']['style']['spacing']['margin']['left'] ) : '';
		$margin_property .= ! empty( $margin_left ) ? 'margin-left:' . $margin_left . ';' : '';

		$padding_top		 = isset( $block['attrs']['style']['spacing']['padding']['top'] ) ? emulsion_style_attribute_variables_fix( $block['attrs']['style']['spacing']['padding']['top'] ) : '';
		$padding_property	 = ! empty( $padding_top ) ? 'padding-top:' . $padding_top . ';' : '';
		$padding_right		 = isset( $block['attrs']['style']['spacing']['padding']['right'] ) ? emulsion_style_attribute_variables_fix( $block['attrs']['style']['spacing']['padding']['right'] ) : '';
		$padding_property	 .= ! empty( $padding_right ) ? 'padding-right:' . $padding_right . ';' : '';
		$padding_bottom		 = isset( $block['attrs']['style']['spacing']['padding']['bottom'] ) ? emulsion_style_attribute_variables_fix( $block['attrs']['style']['spacing']['padding']['bottom'] ) : '';
		$padding_property	 .= ! empty( $padding_bottom ) ? 'padding-bottom:' . $padding_bottom . ';' : '';
		$padding_left		 = isset( $block['attrs']['style']['spacing']['padding']['left'] ) ? emulsion_style_attribute_variables_fix( $block['attrs']['style']['spacing']['padding']['left'] ) : '';
		$padding_property	 .= ! empty( $padding_left ) ? 'padding-left:' . $padding_left . ';' : '';

		$spacing_property = $margin_property . $padding_property;

		if ( in_array( $block_name, $target_blocks ) && ! empty( $spacing_property ) && ! empty( $block['attrs']['layout']['type'] ) && in_array( $block['attrs']['layout']['type'], $tatget_type ) ) {

			preg_match( '$(<[^>]+>)$', $block_content, $target );

			if ( false !== strpos( $target[0], 'style="' ) ) {

				$new_element = str_replace( ' style="',
						' style="' . $spacing_property,
						$target[0] );
			} else {
				$new_element = str_replace( '>', 'style="' . $spacing_property . '">', $target[0] );
			}

			$block_content = str_replace( $target[0], $new_element, $block_content );
		}

		return $block_content;
	}

}
if ( ! function_exists( 'emulsion_add_custom_gap' ) ) {

	function emulsion_add_custom_gap( $block_content, $block ) {
		if ( ! is_singular() ) {
			return $block_content;
		}
		$transient_name	 = __FUNCTION__;
		$transient		 = get_transient( $transient_name );

		if ( ! is_user_logged_in() && false !== $transient && ! empty( $tramsoemt ) ) {

			return $transient;
		}

		$block_name			 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$block_gap			 = isset( $block['attrs']['style']['spacing']['blockGap'] ) ? $block['attrs']['style']['spacing']['blockGap'] : null;
		$css_propaty_name	 = 'gap';
		$new_class			 = array( 'has-custom-gap' );
		$exception_block	 = array( 'wp-block-column' );
		$row_gap			 = '';
		$column_gap			 = '';
		$css_variable_name	 = '--wp--style--block-gap';

		$flag = 'string';

		if ( is_array( $block_gap ) ) {

			$flag = 'array';

			$column_gap	 = ! empty( $block_gap['left'] ) ? $block_gap['left'] : '';
			$row_gap	 = ! empty( $block_gap['top'] ) ? $block_gap['top'] : '';

			$row_gap	 = emulsion_style_attribute_variables_fix( $row_gap );
			$column_gap	 = emulsion_style_attribute_variables_fix( $column_gap );
		} elseif( ! is_null( $block_gap ) ) {
			$block_gap = emulsion_style_attribute_variables_fix( $block_gap );
		}


		if ( ! is_null( $block_gap ) && ! in_array( $block_name, $exception_block ) ) {

			preg_match( '$(<[^>]+>)$', $block_content, $target );

			if ( ! empty($target[0] ) && false !== strpos( $target[0], 'style="' ) ) {

				if ( 'string' == $flag ) {

					$new_element = str_replace( ' style="',
							' style="' . $css_variable_name . ':' . $block_gap . ';' . $css_propaty_name . ':' . esc_attr( $block_gap ) . ';',
							$target[0] );
				}
				if ( 'array' == $flag ) {

					$new_element = str_replace( ' style="',
							' style="' . $css_variable_name . ':' . $row_gap . ';' . $css_propaty_name . ':' . $row_gap . ' ' . $column_gap . ';',
							$target[0] );
				}
			} elseif( ! empty($target[0] ) ) {

				if ( 'string' == $flag ) {

					$new_element = str_replace( '>',
							' style="' . $css_variable_name . ':' . $block_gap . ';' . $css_propaty_name . ':' . $block_gap . ';">',
							$target[0] );
				}
				if ( 'array' == $flag ) {

					$new_element = str_replace( '>',
							' style="' . $css_variable_name . ':' . $row_gap . ';' . $css_propaty_name . ':' . $row_gap . ' ' . $column_gap . ';">',
							$target[0] );
				}
			}

			$block_content = ! empty($target[0] ) ? str_replace( $target[0], $new_element, $block_content ): $block_content;

			$block_content = emulsion_add_class( $block_content, $block_name, $new_class );
		}

		set_transient( $transient_name, trim( $block_content ), DAY_IN_SECONDS );

		return $block_content;
	}

}

if ( ! function_exists( 'emulsion_add_link_hover_class' ) ) {

	function emulsion_add_link_hover_class( $block_content, $block ) {


		$block_name = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );

		$hover_color = null;

		if ( ! empty( $block['attrs'] ) ) {

			$hover_color = ! empty( $block['attrs']["style"]["elements"]["link"][":hover"]["color"]["text"] ) ? $block['attrs']["style"]["elements"]["link"][":hover"]["color"]["text"] : null;
		}

		if ( null === $hover_color ) {
			return $block_content;
		}

		if ( false !== strpos( $hover_color, 'var:preset|color|' ) ) {

			$index_to_splice	 = strrpos( $hover_color, '|' ) + 1;
			$hover_color_name	 = substr( $hover_color, $index_to_splice );

			$target_class	 = 'has-link-color';
			$new_class		 = sanitize_html_class( 'has-' . $hover_color_name . '-hover-color' );

			if ( false !== strpos( $block_content, '-link-color' ) ) {

				$block_content = preg_replace( '!has-link-color!', 'has-link-color has-hover-color ' . $new_class, $block_content, 1 );
			} else {

				$block_content = emulsion_add_class( $block_content, $block_name, $new_class );
			}
		}

		return $block_content;
	}

}

if ( ! function_exists( 'emulsion_add_link_color_class' ) ) {

	function emulsion_add_link_color_class( $block_content, $block ) {
		$transient_name	 = __FUNCTION__;
		$transient		 = get_transient( $transient_name );

		if ( ! is_user_logged_in() && false !== $transient && ! empty( $tramsoemt ) ) {

			return $transient;
		}

		$block_name = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );

		$link_color = null;

		if ( ! empty( $block['attrs'] ) ) {
			$link_color = _wp_array_get( $block['attrs'], array( 'style', 'elements', 'link', 'color', 'text' ), null );

			$hover_color = ! empty( $block['attrs']["style"]["elements"]["link"][":hover"]["color"]["text"] ) ? '--wp--custom--color--palette-secondary:' . $block['attrs']["style"]["elements"]["link"][":hover"]["color"]["text"] . ';' : '';
		}

		if ( null === $link_color ) {
			return $block_content;
		}

		if ( false !== strpos( $link_color, 'var:preset|color|' ) ) {

			$index_to_splice = strrpos( $link_color, '|' ) + 1;
			$link_color_name = substr( $link_color, $index_to_splice );

			$target_class	 = 'has-link-color';
			$new_class		 = sanitize_html_class( 'has-' . $link_color_name . '-link-color' );

			if ( false !== strpos( $block_content, '-link-color' ) ) {

				$block_content = preg_replace( '!has-link-color!', 'has-link-color ' . $new_class, $block_content, 1 );
			} else {

				$block_content = emulsion_add_class( $block_content, $block_name, $new_class );
			}
		}

		if ( maybe_hash_hex_color( $link_color ) && false === strpos( $link_color, 'var:preset|color|' ) ) {

			$target_block = $block['innerHTML'];

			if ( false === strpos( $block_content, "style=" ) ) {
				$new_block		 = str_replace( '<a ', '<a style="color:' . $link_color . ';' . $hover_color . '" ', $target_block );
				$block_content	 = str_replace( $target_block, $new_block, $block_content );
			} else {
				$new_block		 = str_replace( 'style="', 'style="color:' . $link_color . ';' . $hover_color . ' " ', $target_block );
				$block_content	 = str_replace( $target_block, $new_block, $block_content );
			}
		}


		set_transient( $transient_name, trim( $block_content ), DAY_IN_SECONDS );
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

		$emulsion_current_data_version = is_user_logged_in() ? emulsion_version() : null;
//add 'wp-element','wp-rich-text','wp-editor',removed 'wp-editor',
		wp_enqueue_script( 'emulsion-block', esc_url( get_template_directory_uri() . '/js/block.js' ), array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-rich-text', 'jquery' ), $emulsion_current_data_version );

		wp_register_style( 'emulsion-patterns', get_template_directory_uri() . '/css/patterns.css', array(), $emulsion_current_data_version, 'all' );
		wp_enqueue_style( 'emulsion-patterns' );

		if ( 'fse' == emulsion_get_theme_operation_mode() && current_user_can( 'edit_posts' ) ) {

			wp_register_style( 'emulsion-fse', get_template_directory_uri() . '/css/fse.css', array(), time(), 'all' );
			wp_enqueue_style( 'emulsion-fse' );

			if ( function_exists( 'emulsion_fse_editor_inline_style' ) ) {
				$inline_style = emulsion_fse_editor_inline_style();
				wp_add_inline_style( 'emulsion-fse', $inline_style );
			}

			wp_enqueue_script( 'emulsion-block-fse', esc_url( get_template_directory_uri() . '/js/block-fse.js' ), array( 'wp-blocks' ) );
		}
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
if ( ! function_exists( 'emulsion_get_css_variables_value' ) ) {

	function emulsion_get_css_variables_value( $variable ) {

		$preset_values	 = wp_get_global_stylesheet( array( 'variables' ) );
		$preset_val		 = preg_match( '$' . trim( $variable ) . '\:([^\;]*)\;$', $preset_values, $preset_regs );

		if ( ! empty( $preset_regs[1] ) && false !== strpos( $preset_regs[1], 'var(' ) ) {
			$css_variable_name = trim( str_replace( array( 'var', '(', ')' ), array( '', '', '' ), $preset_regs[1] ) );
			return emulsion_get_css_variables_value( $css_variable_name );
		}
		if ( $preset_val ) {

			return trim( $preset_regs[1] );
		} else {

			return false;
		}
	}

}

function emulsion_get_fse_background_color_from_stylesheet() {

	$style = wp_get_global_stylesheet( array( 'styles' ) );

	if ( false !== preg_match( '$body(\s*)?\{([^\}]*)?(background-color:)([^\;]*)\;$', $style, $regs ) && ! empty( $regs[4] ) ) {

		$color = trim( $regs[4] );
		return $color;
	}


	return false;
}

if ( ! function_exists( 'emulsion_fse_background_color_class' ) ) {

	function emulsion_fse_background_color_class() {

		global $template;

		if ( 'theme' == emulsion_get_theme_operation_mode() ) {
			//return;
		}

		$transient_name = 'emulsion_fse_background_color_class';

		if ( current_user_can( 'edit_theme_options' ) ) {

			/**
			 * fse color scheme test
			 */
			$global_settings = wp_get_global_settings( array( 'custom' ) );
			$fse_class		 = '';
			$replace_class	 = '';
			$style			 = wp_get_global_stylesheet( array( 'styles' ) );

			$is_global_style = ! empty( $global_settings['color']['scheme'] ) && 'default' == $global_settings['color']['scheme'] ? '-global' : '';

			if ( false !== preg_match( '$body(\s*)?\{([^\}]*)?(background-color:)([^\;]*)\;$', $style, $regs ) && ! empty( $regs[4] ) ) {

				$regs[4] = trim( $regs[4] );

				if ( ! empty( sanitize_hex_color( $regs[4] ) ) ) {

					//use solid background
					$type_background = sanitize_html_class( 'is-fse-bg-' . $regs[4] );
					$color			 = emulsion_accessible_color( $regs[4] );
				} else {

					//use style variation
					$css_variable_name	 = trim( str_replace( array( 'var', '(', ')' ), array( '', '', '' ), $regs[4] ) );
					$valiable_value		 = emulsion_get_css_variables_value( $css_variable_name );
					// defined color custom

					if ( false !== strpos( $valiable_value, 'var(' ) ) {
						$css_variable_name	 = trim( str_replace( array( 'var', '(', ')' ), array( '', '', '' ), $valiable_value ) );
						$valiable_value		 = emulsion_get_css_variables_value( $css_variable_name );
					}

					$type_background = sanitize_html_class( 'is-fse-bg-' . $valiable_value );
					$color			 = emulsion_accessible_color( $valiable_value );
				}


				if ( '#ffffff' == $color ) {

					$replace_class .= ' is-fse-dark' . $is_global_style . ' ' . $type_background;
				} elseif ( '#333333' == $color ) {

					$replace_class .= ' is-fse-light' . $is_global_style . ' ' . $type_background;
				}
			}

			if ( false !== preg_match( '$body(\s*)?\{([^\}]*)?(background:)([^\;]*)\;$', $style, $regs ) && ! empty( $regs[4] ) ) {
				//gradient
				$type_background = sanitize_html_class( $regs[4] );
				$fse_class		 = 'is-fse-gradient-' . $type_background;
			}

			if ( empty( $fse_class ) ) {
				$fse_class = $replace_class . ' ';

				if ( is_array( $global_settings ) ) {

					$color_scheme = ! empty( $global_settings['color']['scheme'] ) ? $global_settings['color']['scheme'] : 'unknown';

					$fse_class .= sanitize_html_class( 'fse-scheme-' . $color_scheme );
				}
			}

			set_transient( $transient_name, $fse_class, 0 );

			return $fse_class;
		} else {

			if ( false !== get_transient( $transient_name ) ) {

				return get_transient( $transient_name );
			} else {

				return 'fse-scheme-default';
			}
		}
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

	function emulsion_add_class( $html, $target_class = '', $class = '' ) {

		if ( empty( $html ) ) {
			return;
		}

		$target_class = sanitize_html_class( $target_class );

		$p = new WP_HTML_Tag_Processor( $html );

		$p->next_tag( array( 'class_name' => $target_class ) );

		if ( is_array( $class ) ) {
			foreach ( $class as $c ) {

				$p->add_class( sanitize_html_class( $c ) );
			}
		} else {
			$p->add_class( sanitize_html_class( $class ) );
		}

		return $p->get_updated_html();
	}

}

if ( ! function_exists( 'emulsion_theme_google_tracking_code' ) ) {

	function emulsion_theme_google_tracking_code() {

		if ( emulsion_is_amp() ) {

			return;
		}
		$tag			 = sanitize_text_field( get_theme_mod( 'emulsion_google_analytics_tracking_code' ) );
		$theme_mod_name	 = 'emulsion_google_analytics_' . $tag;

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

if ( ! function_exists( 'emulsion_fallback_block_class' ) ) {

	function emulsion_fallback_block_class( $block_content, $block ) {

		$block_name		 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
		$target_block	 = array( 'wp-block-post-template', 'wp-block-audio', 'wp-block-buttons', 'wp-block-columns', 'wp-block-file', 'wp-block-group', 'wp-block-post-excerpt', 'wp-block-table', 'wp-block-navigation', 'wp-block-cover', 'wp-block-paragraph' );

		if ( in_array( $block_name, $target_block ) ) {

			$new_class		 = array( 'wp-block' );
			$block_content	 = str_replace( array( 'wp-block ' ), array( '' ), $block_content );
			$block_content	 = emulsion_add_class( $block_content, $block_name, $new_class );
		}

		return $block_content;
	}

}

add_filter( 'wp_calculate_image_sizes', 'emulsion_content_image_sizes_attr', 10, 2 );

if ( ! function_exists( 'emulsion_content_image_sizes_attr' ) ) {

	function emulsion_content_image_sizes_attr( $sizes, $size ) {
		$width = $size[0];

		if ( 'fse' !== emulsion_get_theme_operation_mode() ) {
			if ( $width > 1600 ) {
				return '(max-width: 720px) 768px, 1600px';
			} else {
				return $sizes;
			}
		} else {

			if ( ! is_singular() ) {
				return '768px';
			} else {
				return $sizes;
			}
		}
	}

}

if ( ! function_exists( 'emulsion_is_custom_post_type' ) ) {

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

}

if ( ! function_exists( 'emulsion_block_template_part' ) ) {

	function emulsion_block_template_part( $part, $args = array() ) {

		$template_part = get_block_template( get_stylesheet() . '//' . $part, 'wp_template_part' );

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
			! empty( $args['align'] ) ? 'align' . minified_class_name_sanitize( $args['align'] ) : 'alignfull',
			! empty( $args['className'] ) ? minified_class_name_sanitize( $args['className'] ) : '',
		);

		$additional_classes	 = array();
		$tag_name			 = 'div';

		if ( 'header' == $template_part->area ) {

			$additional_classes		 = array( 'fse-header', 'header-layer', 'html-header' );
			$additional_classes[]	 = 'header-rich' !== $part ? 'banner' : '';
			$tag_name				 = 'header';
		}

		if ( 'footer' == $template_part->area ) {

			$additional_classes	 = array( 'fse-footer', 'footer-layer', 'html-footer', 'banner' );
			$tag_name			 = 'footer';

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

if ( ! function_exists( 'emulsion_get_template' ) ) {

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
			wp_reset_query();
			$post_id		 = get_the_ID();
			$custom_template = get_post_meta( $post_id, '_wp_page_template', true );

			if ( ! empty( $custom_template ) && false === strstr( $custom_template, '.php' ) && ( is_single() || is_page() ) ) {

				return sanitize_html_class( $custom_template . '_template' );
			}

			if ( is_404() && is_readable( get_template_directory() . '/templates/404.html' ) ) {
				return '404_template';
			}
			if ( is_search() && is_readable( get_template_directory() . '/templates/search.html' ) ) {
				return 'search_template';
			}
			if ( ! is_home() && is_front_page() && is_readable( get_template_directory() . '/templates/front-page.html' ) ) {
				return 'front-page_template';
			}
			if ( is_home() && is_readable( get_template_directory() . '/templates/home.html' ) ) {
				//if ( 'posts' == get_option( 'show_on_front' ) && !is_singular() && !is_archive() && !is_search() && !is_attachment() && is_readable( get_template_directory() . '/templates/home.html' ) ) {
				return 'home_template';
			}
			if ( is_privacy_policy() && is_readable( get_template_directory() . '/templates/privacy-policy.html' ) ) {
				return 'privacy-policy_template';
			}

			if ( is_tax() && is_readable( get_template_directory() . '/templates/taxonomy.html' ) ) {

				return 'taxonomy_template';
			}
			if ( is_attachment() && is_readable( get_template_directory() . '/templates/attachment.html' ) ) {
				return 'attachment_template';
			}
			if ( is_single() && is_readable( get_template_directory() . '/templates/single.html' ) ) {
				return 'single_template';
			}
			if ( is_page() && is_readable( get_template_directory() . '/templates/page.html' ) ) {
				return 'page_template';
			}
			if ( is_singular() && is_readable( get_template_directory() . '/templates/singular.html' ) ) {
				return 'singular_template';
			}
			if ( is_category() && is_readable( get_template_directory() . '/templates/category.html' ) ) {
				return 'category_template';
			}
			if ( is_tag() && is_readable( get_template_directory() . '/templates/tag.html' ) ) {
				return 'tag_template';
			}
			if ( is_author() && is_readable( get_template_directory() . '/templates/author.html' ) ) {
				return 'author_template';
			}
			if ( is_date() && is_readable( get_template_directory() . '/templates/date.html' ) ) {
				return 'date_template';
			}
			if ( is_archive() && is_readable( get_template_directory() . '/templates/archive.html' ) ) {
				return 'archive_template';
			}

			return 'index_template';
		}

		if ( is_attachment() ) {
			return 'attachment-php';
		}
		return $template;
	}

}
if ( ! function_exists( 'emulsion_custom_field_css' ) ) {

	function emulsion_custom_field_css() {

		$post_id			 = absint( get_the_ID() );
		$meta_style			 = '';
		$post_type			 = get_post_type();
		$custom_css_class	 = 'has-custom-style';
		$meta_field			 = 'css';

		if ( ! is_singular() ) {
			//return;
		}

		if ( ! empty( $post_id ) && metadata_exists( $post_type, $post_id, $meta_field ) ) {

			$meta_style = get_metadata( $post_type, $post_id, $meta_field, true );

			add_filter(
					'body_class', function ( $class ) use ( $custom_css_class ) {
						$class[] = $custom_css_class;
						return $class;
					} );

			$meta_style_css = preg_replace_callback( '![^}]+{[^}]+}!siu', function ( $matches ) use ( $post_id ) {
				$class_prefix	 = is_page() ? 'page-id' : 'postid';
				$result			 = '';
				foreach ( $matches as $match ) {

					if ( strstr( $match, '@' ) && is_singular() ) {

						if ( preg_match( '|(@[^\{]+{)([^\}]*\})|', $match, $args ) ) {
							$result .= $args[1];

							$result .= sprintf( ' .has-custom-style.%3$s-%1$d %2$s', $post_id, $args[2], $class_prefix );
						}
					} elseif ( is_singular() ) {

						if ( false === strstr( $match, 'has-custom-style' ) ) {

							$result .= sprintf( ' .has-custom-style.%3$s-%1$d %2$s', $post_id, $match, $class_prefix );
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
		if ( ! is_singular() ) {
			return sprintf( '<p class="password-protected-notice">%1$s</p>', esc_html__( 'There is no excerpt because this is a protected post', 'emulsion' ) );
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

		$form = apply_filters( 'emulsion_get_the_password_form', $form );

		return wp_kses( $form, EMULSION_FORM_ALLOWED_ELEMENTS );
	}

}

if ( ! function_exists( 'emulsion_slug' ) ) {

	function emulsion_slug( $echo = false ) {

		$emulsion_current_data		 = wp_get_theme();
		$emulsion_current_theme_name = $emulsion_current_data->get( 'Name' );
		$emulsion_current_theme_slug = sanitize_title_with_dashes( $emulsion_current_theme_name );

		if ( $echo == true ) {

			echo $emulsion_current_theme_slug;
		} else {

			return $emulsion_current_theme_slug;
		}
	}

}

if ( ! function_exists( 'emulsion_meta_elements' ) ) {

	function emulsion_meta_elements() {
		?><meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1" id="emulsion-viewport" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" /><?php
	}

}

if ( ! function_exists( 'emulsion_pingback_header' ) ) {

	function emulsion_pingback_header() {
		if ( is_singular() && pings_open( get_queried_object() ) ) {
			printf( '<link rel="pingback" href="%1$s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

}

add_filter( 'render_block', 'emulsion_style_variation_grid_filter', 10, 2 );

if ( ! function_exists( 'emulsion_style_variation_grid_filter' ) ) {

	function emulsion_style_variation_grid_filter( $block_content, $block ) {

		if( is_feed() ){
			return $block_content;
		}

		$block_name = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );

		if ( isset( $block['attrs']['className'] ) && ! empty( $block['attrs']['className'] ) && 'grid' == emulsion_get_css_variables_value( '--wp--custom--color--scheme' ) && false !== strstr( $block['attrs']['className'], 'main-query' ) ) {

			$columns = ! empty( $block["innerBlocks"][0]['attrs']["displayLayout"]["columns"] ) ? absint( $block["innerBlocks"][0]['attrs']["displayLayout"]["columns"] ) : '';
			$align	 = ! empty( $block["innerBlocks"][0]["innerBlocks"][0]["attrs"]["align"] ) ? esc_attr( $block["innerBlocks"][0]["innerBlocks"][0]["attrs"]["align"] ) : '';

			$p = new WP_HTML_Tag_Processor( $block_content );
			$p->next_tag( 'ul' );
			$p->add_class( 'is-layout-grid' );
			empty( $columns ) ? $p->add_class( 'columns-3' ) : $p->add_class( 'columns-' . $columns );
			empty( $align ) ? $p->add_class( 'alignwide' ) : $p->add_class( 'align' . $align );

			return $p->get_updated_html();
		}

		if ( ! empty( $block['attrs']['className'] ) && 'grid-midnight' == emulsion_get_css_variables_value( '--wp--custom--color--scheme' ) && false !== strstr( $block['attrs']['className'], 'main-query' ) ) {

			$columns = ! empty( $block["innerBlocks"][0]['attrs']["displayLayout"]["columns"] ) ? absint( $block["innerBlocks"][0]['attrs']["displayLayout"]["columns"] ) : '';
			$align	 = ! empty( $block["innerBlocks"][0]["innerBlocks"][0]["attrs"]["align"] ) ? esc_attr( $block["innerBlocks"][0]["innerBlocks"][0]["attrs"]["align"] ) : '';

			$p = new WP_HTML_Tag_Processor( $block_content );
			$p->next_tag( 'ul' );
			$p->add_class( 'is-layout-grid' );
			empty( $columns ) ? $p->add_class( 'columns-3' ) : $p->add_class( 'columns-' . $columns );
			empty( $align ) ? $p->add_class( 'alignwide' ) : $p->add_class( 'align' . $align );
			// if is-layout-flex
			//$p->set_attribute( 'style', "flex-wrap:wrap;align-items: stretch;" );

			return $p->get_updated_html();
		}

		return $block_content;
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

/**
 * empty excerpt filter
 */
add_filter( 'render_block_core/post-excerpt', function ( $excerpt ) {

	if ( empty( trim( strip_tags( $excerpt ) ) ) ) {
		return '';
	}

	return $excerpt;
} );
//
add_filter( 'render_block_core/query-pagination-numbers', function ( $block_content, $block ) {

	$block_name	 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );

		$p = new WP_HTML_Tag_Processor( $block_content );
		$p->next_tag( array( 'class_name' => $block_name ) );
		$p->add_class( 'no-instant' );
		return $p->get_updated_html();

}, 10, 2);
/**
 * experimental custom template part area
 * The header area appears twice in home.html and archive.html. Use filters to make it clear that they are not the same thing.
 */
add_filter( 'default_wp_template_part_areas', 'emulsion_custom_template_part_areas' );

if ( ! function_exists( 'emulsion_custom_template_part_areas' ) ) {

	function emulsion_custom_template_part_areas( array $areas ) {

		$areas[] = array(
			'area'			 => 'post-header',
			'area_tag'		 => 'header',
			'label'			 => __( 'Post Header', 'emulsion' ),
			'description'	 => __( 'Individual post header', 'emulsion' ),
			'icon'			 => 'header'
		);
		$areas[] = array(
			'area'			 => 'post-footer',
			'area_tag'		 => 'footer',
			'label'			 => __( 'Post Footer', 'emulsion' ),
			'description'	 => __( 'Individual post footer', 'emulsion' ),
			'icon'			 => 'footer'
		);
		$areas[] = array(
			'area'			 => 'article-wrapper',
			'area_tag'		 => 'div',
			'label'			 => __( 'Article Wrapper', 'emulsion' ),
			'description'	 => __( 'Whole article', 'emulsion' ),
			'icon'			 => ''
		);

		return $areas;
	}

}

function emulsion_get_current_post_id() {

	$url	 = (empty( $_SERVER['HTTPS'] ) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$url	 = esc_url( $url );
	$post_id = url_to_postid( $url );
	return absint( $post_id );
}

if ( ! function_exists( 'emulsion_hide_redundant_category' ) ) {

	function emulsion_hide_redundant_category() {

		$permalink_structure = get_option( 'permalink_structure' );

		$css_rule_set = '.taxsonomy [rel="tag"][href$="%1$s/"],
						.taxsonomy [rel="tag"][href$="%1$s"]{
							display:none;
						}';
		if ( is_category() ) {

			$category		 = single_term_title( "", false );
			$catid			 = get_cat_ID( $category );
			$category_link	 = get_category_link( $catid );

			return sprintf( $css_rule_set, $category_link );
		}
		if ( ! empty( $permalink_structure ) ) {

			$default_category_id	 = get_option( 'default_category' );
			$default_category_info	 = get_category( $default_category_id );
			$default_category_slug	 = $default_category_info->slug;
			return sprintf( $css_rule_set, $default_category_slug );
		}
	}

}
//navigation pagination
add_filter( 'navigation_markup_template', 'custom_the_posts_pagination' );

if ( ! function_exists( 'custom_the_posts_pagination' ) ) {

	function custom_the_posts_pagination( $template ) {

		$template = '<nav class="navigation %1$s wp-block-query-pagination" aria-label="%4$s"> <h2 class="screen-reader-text">%2$s</h2> <div class="nav-links wp-block-query-pagination-numbers">%3$s</div> </nav>';

		return $template;
	}

}

if ( ! function_exists( 'emulsion_pagination' ) ) {

	/**
	 * Print pagination
	 */
	function emulsion_pagination() {

		$post_id = get_the_ID();

		if ( false === $post_id ) {
			__return_empty_string();
		}

		if ( is_singular() ) {

 ! is_page() && ! is_attachment() ? the_post_navigation() : '';

			wp_attachment_is_image( $post_id ) ? emulsion_attachment_pagination() : '';
		} else {
			the_posts_pagination();
		}
	}

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

if ( ! function_exists( 'emulsion_post_content' ) ) {

	/**
	 * The summary sentence displays the text that removes the table element,
	 * the figure element excluded from the HTML5 outline, etc.,
	 * which significantly impairs readability when the text is extracted.
	 */
	function emulsion_post_content() {


		$use_excerpt			 = emulsion_the_theme_supports( 'excerpt' );
		$supports_grid			 = emulsion_the_theme_supports( 'grid' );
		$message_protected_post	 = esc_html__( 'Password is required to view this post', 'emulsion' );
		$post_id				 = get_the_ID();
		$grid					 = emulsion_get_layout_setting();
		$get_post				 = get_post( $post_id, 'OBJECT', 'display' );
		$excerpt_length			 = apply_filters( 'excerpt_length', 256 );
		$read_more_text			 = esc_html__( '...', 'emulsion' );
		$excerpt_from_content	 = '';
		$excerpt_html_wrapper	 = '<blockquote cite="%2$s" class="content-excerpt"><p class="%3$s" data-rows="%4$d">%1$s</p></blockquote>';
		$excerpt_plain_text		 = '';

		// Create excerpt from entry content
		$post_text	 = strip_shortcodes( $get_post->post_content );
		$has_more	 = stristr( $post_text, '<!--more' );

		if ( empty( $post_id ) && ! empty( $post_text ) ) {
			//case bbpress forums, woocommerce product-category

			echo wp_kses_post( $get_post->post_content );
			return;
		}

		if ( ! empty( $post_text ) ) {

			/**
			 * Delete deactivated short code
			 * it is not certain,but
			 */
			$post_text = preg_replace( '!\[[^\]]+\]!', '', $post_text );

			/**
			 * remove blocks not support core
			 */
			//	$post_text = excerpt_remove_blocks( $post_text );

			/**
			 * add space end tag before element text
			 * Even if tags are removed, keep space and increase readability
			 */
			$word_separate_count = 0;

			$post_text = str_replace( '</', ' </', $post_text, $word_separate_count );

			/**
			 * remove element and their contents
			 */
			$post_text = emulsion_strip_elements( $post_text, '<table><del><figure><blockquote><code><script><style><iframe><canvas><noscript><audio><video><noembed>', true );

			/**
			 * Remove Comments
			 */
			$post_text = strip_tags( $post_text );

			/**
			 * remove white space More than 3 consecutive times to 2 (paragraph)
			 */
			$post_text	 = preg_replace( '/(\s\s)\s+/', '$1', $post_text );
			/**
			 * remove &nbsp;
			 */
			$post_text	 = preg_replace( '!\s*&nbsp;\s*!', '', $post_text );

			/**
			 * remove text URL oEmbed etc. Delete text URL
			 *
			 */
			$post_text = emulsion_remove_url_from_text( $post_text );

			/**
			 * To keeping line breaks, substitute with alternative characters
			 */
			$post_text	 = str_replace( array( "\r\n\r\n" ), array( "[lb2]" ), $post_text, $count_paragraph );
			$post_text	 = str_replace( array( "\n\n", "\n" ), array( "[lb2]", "[lb1]" ), $post_text, $count_break );

			/**
			 * Adjust the increased number of characters by substitution character
			 * Not correct but
			 */
			if ( ! empty( $count ) ) {

				$excerpt_length = $excerpt_length + $count_paragraph * 2 + $count_break;
			}

			/**
			 * Return an alternate character to a line feed to hold line breaks
			 */
			$post_text = str_replace( array( "[lb2]", "[lb1]" ), array( "\r\n", "\r\n" ), $post_text );

			$post_text = preg_replace( array( '/\[[lb12]*(' . $read_more_text . ')?\s*$/' ), $read_more_text, $post_text );

			/**
			 * the blockquote element to indicate that it is not the posted content itself
			 */
			$post_text = trim( $post_text );

			if ( $read_more_text !== $post_text && ! empty( $post_id ) ) {

				$excerpt_from_content = sprintf( $excerpt_html_wrapper, $post_text, get_permalink( $post_id ), 'trancate', 4 );
			} else {

				$excerpt_from_content = '';
			}
		}

		// has excerpt allow all elements

		$has_excerpt = $get_post->post_excerpt;

		if ( ! $has_excerpt ) {

			$excerpt_plain_text = trim( wp_strip_all_tags( $excerpt_from_content ) );
		}

		if ( ! post_password_required( $post_id ) ) {

			if ( 'grid' == $grid ) {

				$lines	 = absint( get_theme_mod( 'emulsion_excerpt_length_grid', 4 ) );
				$result	 = sprintf( '<p class="%2$s" data-rows="%3$d">%1$s</p>', $excerpt_plain_text, 'trancate', $lines );

				echo wp_kses( $result, EMULSION_EXCERPT_ALLOWED_ELEMENTS );
			} else {

				if ( ! $use_excerpt || is_search() ) {

					the_content();
				} else {

					if ( ! is_singular() ) {

						if ( ! $has_excerpt && $excerpt_from_content ) {

							if ( false === $has_more ) {

								echo ! empty( $post_text ) ? wp_kses_post( $excerpt_from_content ) : '';
							} else {
								/**
								 * The HTML element from the beginning of the post to the read-more tag is displayed without being deleted.
								 */
								the_content();
							}
						} elseif ( $has_excerpt ) {

							if ( 0 == strcmp( trim( $has_excerpt ), $excerpt_plain_text ) ) {

								if ( preg_match( '/<.*>/', $has_excerpt ) ) {

									echo wp_kses_post( $has_excerpt );
								} else {

									$has_excerpt = sprintf( '<div class="wp-block-post-excerpt"><p class="wp-block-post-excerpt__excerpt">%1$s</p></div>', wp_kses_post( $has_excerpt ) );
									echo $has_excerpt;
								}

								emulsion_post_excerpt_more();
							} else {

								$has_excerpt = sprintf( '<div class="post-excerpt-html alignnone">%1$s</div>', wp_kses_post( $has_excerpt ) );
								echo $has_excerpt;
							}
						}
					} else {

						the_content();
					}
				}
			}
		} else {

			echo get_the_password_form( $post_id );
		}
	}

}

if ( ! function_exists( 'emulsion_strip_elements' ) ) {

	function emulsion_strip_elements( $text, $tags = '', $invert = false ) {

		preg_match_all( '/<(.+?)[\s]*\/?[\s]*>/si', trim( $tags ), $tags );
		$tags = array_unique( $tags[1] );

		if ( is_array( $tags ) && count( $tags ) > 0 ) {
			if ( $invert == false ) {
				return preg_replace( '@<(?!(?:' . implode( '|', $tags ) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text );
			} else {
				return preg_replace( '@<(' . implode( '|', $tags ) . ')\b.*?>.*?</\1>@si', '', $text );
			}
		} elseif ( $invert == false ) {
			return preg_replace( '@<(\w+)\b.*?>.*?</\1>@si', '', $text );
		}
		return $text;
	}

}

if ( ! function_exists( 'emulsion_remove_url_from_text' ) ) {

	function emulsion_remove_url_from_text( $plain_text = '' ) {

		return preg_replace( "/(https?:\/\/)([-_.!*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/iu", '', $plain_text );
	}

}


if ( ! function_exists( 'emulsion_post_excerpt_more' ) ) {

	function emulsion_post_excerpt_more() {

		$supports_grid	 = emulsion_the_theme_supports( 'grid' );
		$grid			 = emulsion_get_layout_setting();
		$post_id		 = get_the_ID();

		if ( false === $post_id ) {
			__return_empty_string();
		}

		$permalink	 = get_permalink( $post_id );
		$article	 = get_post( $post_id );

		if ( $article ) {

			if ( preg_match( '$<!--more-->$', $article->post_content ) && 'excerpt' == $grid ) {

				printf( '<p class="wp-block-post-excerpt__more-text"><a href="%1$s#top" class="wp-block-post-excerpt__more-link">%2$s<span class="screen-reader-text read-more-context">%3$s</span></a></div>',
						esc_url( $permalink ),
						esc_html__( 'Read More', 'emulsion' ),
						/* translators: %1$s entry title */
						sprintf( esc_html__( 'link to post %1$s', 'emulsion' ), wp_kses_post( $article->post_title ) ) );
			}
		}
	}
}

/**
 * body_class
 * wp_template
 */
add_filter( 'template_include', function ( $template ) {
	global $_wp_current_template_id;

	$template_object = get_block_template( $_wp_current_template_id, 'wp_template' );

	add_filter( 'body_class', function ( $classes ) use ( $template_object ) {

		/**
		 * Mainly on the archive page, check for excerpt or the full text, and if it is the full text, add the class.
		 * @since 3.1.6
		 */

		if( false !== strpos($template_object->content,'wp:post-content') ) {
			$classes = array_diff($classes, array('summary'));
			$classes[] = 'full-text';
		}

		if ( ! empty( $template_object->type ) && 'wp_template' == $template_object->type ) {

			$classes[] = emulsion_class_name_sanitize( 'is-' . $template_object->type . "-" . $template_object->slug );
		}
		return $classes;
	} );

	return $template;
}
);

/**
 * wp-block-heading add border style
 */
add_filter( 'block_type_metadata', 'emulsion_block_default_values' );

if ( ! function_exists( 'emulsion_block_default_values' ) ) {

	function emulsion_block_default_values( $metadata ) {

		if ( 'core/heading' === $metadata['name'] ) {

			$metadata['supports']['__experimentalBorder']['color']									 = true;
			$metadata['supports']['__experimentalBorder']['radius']									 = true;
			$metadata['supports']['__experimentalBorder']['style']									 = true;
			$metadata['supports']['__experimentalBorder']['width']									 = true;
			$metadata['supports']['__experimentalBorder']['__experimentalDefaultControls']['color']	 = true;
			$metadata['supports']['__experimentalBorder']['__experimentalDefaultControls']['radius'] = true;
			$metadata['supports']['__experimentalBorder']['__experimentalDefaultControls']['style']	 = true;
			$metadata['supports']['__experimentalBorder']['__experimentalDefaultControls']['width']	 = true;
		}

		if ( 'core/spacer' === $metadata['name'] ) {

			$metadata['attributes']['height']['default'] = '6vw';
		}
		if ( 'core/paragraph' !== $metadata['name'] ) {

			$metadata['supports']['align'] = [ "left", "right", "center", "none", "wide", "full" ];
		}


		return $metadata;
	}

}
if ( ! function_exists( 'emulsion_layout_control' ) ) {

	/**
	 * Add html element for grid display and stream display.
	 * Using the filter, you can return the page displayed in grid format to normal display.
	 * @param type $position
	 * @param type $type
	 * @return type
	 */
	function emulsion_layout_control( $position = 'before', $type = '',
			$element = 'div' ) {

		if ( is_single() ) {

			return false;
		}
		if ( empty( $type ) ) {
			$type = get_post_type();
		}
		$custom_border_class = '';
		$type				 = apply_filters( 'emulsion_layout_control', $type );
		$type				 = emulsion_sanitize_css( $type );

		if ( post_type_exists( $type ) && 'post' !== $type && 'page' !== $type ) {

			$type .= ' custom-post-type';
		}

		$position = $position == ('before' || 'after') ? $position : '';

		if ( ! empty( $type ) && ! empty( $position ) ) {

			echo 'before' === $position ? '<' . $element . ' class="' . $type . ' ' . $custom_border_class . '">' : '</' . $element . '>';
			return true;
		}


		return false;
	}

}

if ( ! function_exists( 'emulsion_template_part_names_class' ) ) {

	/**
	 * the class name associated with the included template
	 *
	 * @global type $template
	 * @param type $file
	 * @param type $echo
	 * @return boolean
	 */
	function emulsion_template_part_names_class( $file = '', $echo = true ) {
		global $template;

		if ( empty( $file ) ) {

			return false;
		}

		if ( $template == $file ) {

			$current_template	 = basename( $template, '.php' );
			$current_template	 = sprintf( 'template-%1$s', $current_template );
		} else {

			$current_template	 = basename( $file, '.php' );
			$current_template	 = sprintf( 'template-part-%1$s', $current_template );
		}

		$post_class = ' ' . implode( ' ', get_post_class() );

		if ( $echo ) {

			echo ' ' . emulsion_class_name_sanitize( $current_template . $post_class );
		} else {

			return ' ' . emulsion_class_name_sanitize( $current_template . $post_class );
		}
	}

}

if ( ! function_exists( 'emulsion_element_classes' ) ) {

	/**
	 * Adds a class according to the primary menu background color,sidebar background color specified in the customizer.
	 * Return the class specified by location
	 * @param type $location
	 * @return string
	 *
	 * @since 0.99 class name change from menu-has-column to menu-active
	 */
	function emulsion_element_classes( $location = '' ) {
		// todo pending
		return;
	}

}



if ( ! function_exists( 'emulsion_related_posts' ) ) {

	/**
	 *
	 * @since 1.1.3 removed global $post
	 */
	function emulsion_related_posts() {

		$relate_posts_enable = emulsion_the_theme_supports( 'relate_posts' );

		if ( empty( $relate_posts_enable ) ) {

			return;
		}

		$algo = emulsion_related_posts_finder();

		if ( ! empty( $algo ) && is_single() && ! is_attachment() ) {

			$type			 = key( $algo );
			$id				 = $algo[$type];
			$args			 = "recent_post" == $type ? array( 'posts_per_page' => 5, 'post_status' => 'publish' ) : array( 'posts_per_page' => 5, $type => $id, 'post_status' => 'publish' );
			$relate_posts	 = get_posts( $args );

			if ( ! empty( $relate_posts ) && is_single() && ! is_attachment() ) {
				?>
				<h2 class="relate-posts-title fit"><?php esc_html_e( 'Relate Posts', 'emulsion' ); ?></h2>
				<ul class="relate-posts fit"><?php
					foreach ( $relate_posts as $relate_post ) {

						$post_id			 = absint( $relate_post->ID );
						$relate_post_title	 = $relate_post->post_title;
						$link_url			 = get_permalink( $post_id );
						?>
						<li><?php
							if ( has_post_thumbnail( $post_id ) ) {

								/**
								 * @since ver1.1.6 function change the_post_thumbnail to get_the_post_thumbnail
								 */
								echo get_the_post_thumbnail( $post_id, 'thumbnail' );
							} else {

								/* translators: title icon question mark */
								$icon_text = empty( $relate_post_title ) ? esc_html_x( '?', 'title icon question mark', 'emulsion' ) : mb_substr( sanitize_text_field( $relate_post_title ), 0, 1 );

								/**
								 * The character string is the first character extracted from the post title.
								 * This will only be displayed as an alternative if the featured image does not exist in the post.
								 * Just used as a design, no meaning for strings
								 */
								echo '<div class="relate-post-no-icon">' . esc_html( $icon_text ) . '</div>';
							}
							?><a href="<?php echo esc_url( $link_url ); ?>"><?php echo wp_kses( $relate_post_title, array() ); ?></a></li>
						<?php
					}
					wp_reset_postdata();
				}
				?></ul>
			<?php
		}
	}

}

add_filter( 'render_block_core/group', 'emulsion_block_group_vertical_classes', 10, 2 );

function emulsion_block_group_vertical_classes( $block_content, $block ) {

	$block_name	 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
	$v_align	 = ! empty( $block['attrs']['layout']['verticalAlignment'] ) ? sanitize_html_class( 'items-justified-' . $block['attrs']['layout']['verticalAlignment'] ) : '';

	if ( ! empty( $v_align ) ) {
		$p = new WP_HTML_Tag_Processor( $block_content );
		$p->next_tag( array( 'class_name' => $block_name ) );
		! empty( $v_align ) ? $p->add_class( $v_align ) : '';
		return $p->get_updated_html();
	}
	return $block_content;
}

add_filter( 'render_block', 'emulsion_block_group_self_stretch_classes', 10, 2 );

function emulsion_block_group_self_stretch_classes( $block_content, $block ) {

	$block_name		 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
	$self_stretch	 = ! empty( $block["attrs"]["style"]["layout"]["selfStretch"] ) ? sanitize_html_class( $block["attrs"]["style"]["layout"]["selfStretch"] ) : '';

	if ( ! empty( $self_stretch ) ) {

		$p = new WP_HTML_Tag_Processor( $block_content );

		if ( 'wp-block-paragraph' == $block_name ) {

			$p->next_tag( array( 'tag_name' => 'p', ) );
		} elseif ( 'wp-block-list' == $block_name ) {

			if ( strstr( $block_content, '<ul' ) ) {

				$p->next_tag( array( 'tag_name' => 'ul', ) );
			} else {

				$p->next_tag( array( 'tag_name' => 'ol', ) );
			}
		} else {

			$p->next_tag( array( 'class_name' => $block_name ) );
		}

		$p->add_class( $self_stretch );

		if ( 'fixed' == $self_stretch ) {

			$style_value = ! empty( $block['attrs']['style']['layout']['flexSize'] ) ? $block['attrs']['style']['layout']['flexSize'] : 'auto';

			$p->set_attribute( 'style', 'width:' . $style_value );
		}

		return $p->get_updated_html();
	}


	return $block_content;
}

add_filter( 'render_block', 'emulsion_shdow_classes', 10, 2 );

function emulsion_shdow_classes( $block_content, $block ) {

	$block_name	 = 'wp-block-' . substr( strrchr( $block['blockName'], "/" ), 1 );
	$shadow		 = ! empty( $block['attrs']['style']['shadow'] ) ? sanitize_html_class( $block['attrs']['style']['shadow'] ) : '';
	$classes	 = ! empty( $block['attrs']['className'] ) ? sanitize_html_class( $block['attrs']['className'] ) : '';
	if ( ! empty( $shadow ) || false !== strstr( $classes, 'is-style-shadow' ) ) {

		$p = new WP_HTML_Tag_Processor( $block_content );

		if ( 'wp-block-paragraph' == $block_name ) {

			$p->next_tag( array( 'tag_name' => 'p', ) );
		} elseif ( 'wp-block-list' == $block_name ) {

			if ( strstr( $block_content, '<ul' ) ) {

				$p->next_tag( array( 'tag_name' => 'ul', ) );
			} else {

				$p->next_tag( array( 'tag_name' => 'ol', ) );
			}
		} else {

			$p->next_tag( array( 'class_name' => $block_name ) );
		}

		$p->add_class( 'has-shadow' );

		return $p->get_updated_html();
	}


	return $block_content;
}

/**
 * Using PHP template fse mode
 *
 * @param type $template
 * @return type
 */
if ( ! function_exists( 'emulsion_custom_template_include' ) ) {

	function emulsion_custom_template_include( $template ) {
		/**
		 * front-page.php and home.php cannot be created.
		 * If necessary, set the page from the customizer's front page settings and apply the template to that page.
		 *
		 */
		$new_template		 = '';
		$has_page_template	 = ! empty( get_post_meta( get_the_ID(), '_wp_page_template', true ) ) ? true : false;

		if ( 'template-canvas.php' === basename( $template ) && false === $has_page_template ) {

			if ( is_single() ) {

				$new_template = emulsion_get_single_template();
			}
			if ( is_page() ) {

				$new_template = emulsion_get_page_template();
			}

			if ( is_singular() && empty( $new_template ) ) {

				$new_template = locate_template( array( 'classic-templates/singular.php' ) );
			}

			if ( is_home() && is_readable( get_theme_file_path( 'classic-templates/home.php' ) ) ) {

				$new_template = emulsion_get_home_template();
			}
			if ( is_front_page() && is_readable( get_theme_file_path( 'classic-templates/front-page.php' ) ) ) {

				$new_template = emulsion_get_front_page_template();
			}

			if ( is_privacy_policy() && is_readable( get_theme_file_path( 'classic-templates/privacy-policy.php' ) ) ) {

				$new_template = locate_template( array( 'classic-templates/privacy-policy.php' ) );
			}
			if ( is_search() ) {

				$new_template = emulsion_get_search_template();
			}

			if ( is_post_type_archive() ) {

				$new_template = emulsion_get_post_type_archive_template();

				if ( empty( $new_template ) ) {
					$new_template = emulsion_get_archive_template();
				}
			}
			if ( is_tax() ) {

				$new_template = emulsion_get_taxonomy_template();
				if ( empty( $new_template ) ) {

					$new_template = emulsion_get_archive_template();
				}
			}
			if ( is_embed() ) {

				$new_template = locate_template( array( emulsion_get_embed_template() ) );
			}

			if ( is_attachment() ) {

				$new_template = locate_template( array( emulsion_get_attachment_template() ) );

			}
			if ( is_category() ) {

				$new_template = emulsion_get_category_template();

				if ( empty( $new_template ) ) {

					$new_template = emulsion_get_archive_template();
				}
			}

			if ( is_tag() ) {

				$new_template = emulsion_get_tag_template();

				if ( empty( $new_template ) ) {

					$new_template = emulsion_get_archive_template();
				}
			}
			if ( is_author() ) {

				$new_template = emulsion_get_author_template();
				if ( empty( $new_template ) ) {

					$new_template = emulsion_get_archive_template();
				}
			}
			if ( is_404() ) {

				$new_template = locate_template( array( 'classic-templates/404.php' ) );
			}
			if ( is_date() ) {
				$new_template = locate_template( array( 'classic-templates/date.php' ) );
				if ( empty( $new_template ) ) {
					$new_template = emulsion_get_archive_template();
				}
			}

			if ( '' !== $new_template ) {
				return $new_template;
			}
		}
		return $template;
	}

}

if ( ! function_exists( 'emulsion_get_category_template' ) ) {

	function emulsion_get_category_template() {
		$category = get_queried_object();

		$templates = array();

		if ( ! empty( $category->slug ) ) {

			$slug_decoded = urldecode( $category->slug );
			if ( $slug_decoded !== $category->slug ) {
				$templates[] = "classic-templates/category-{$slug_decoded}.php";
			}

			$templates[] = "classic-templates/category-{$category->slug}.php";
			$templates[] = "classic-templates/category-{$category->term_id}.php";
		}
		$templates[] = 'classic-templates/category.php';

		return get_query_template( 'category', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_tag_template' ) ) {

	function emulsion_get_tag_template() {
		$tag = get_queried_object();

		$templates = array();

		if ( ! empty( $tag->slug ) ) {

			$slug_decoded = urldecode( $tag->slug );
			if ( $slug_decoded !== $tag->slug ) {
				$templates[] = "classic-templates/tag-{$slug_decoded}.php";
			}

			$templates[] = "classic-templates/tag-{$tag->slug}.php";
			$templates[] = "classic-templates/tag-{$tag->term_id}.php";
		}
		$templates[] = 'classic-templates/tag.php';

		return get_query_template( 'tag', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_author_template' ) ) {

	function emulsion_get_author_template() {

		$author = get_queried_object();

		$templates = array();

		if ( $author instanceof WP_User ) {
			$templates[] = "classic-templates/author-{$author->user_nicename}.php";
			$templates[] = "classic-templates/author-{$author->ID}.php";
		}
		$templates[] = 'classic-templates/author.php';

		return get_query_template( 'author', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_search_template' ) ) {

	function emulsion_get_search_template() {
		$templates = array( 'classic-templates/search.php' );
		return get_query_template( 'search', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_single_template' ) ) {

	function emulsion_get_single_template() {

		$object = get_queried_object();

		$templates = array();

		if ( ! empty( $object->post_type ) ) {
			$template = get_page_template_slug( $object );
			if ( $template && 0 === validate_file( $template ) ) {
				$templates[] = "classic-templates/{$template}";
			}

			$name_decoded = urldecode( $object->post_name );
			if ( $name_decoded !== $object->post_name ) {
				$templates[] = "classic-templates/single-{$object->post_type}-{$name_decoded}.php";
			}

			$templates[] = "classic-templates/single-{$object->post_type}-{$object->post_name}.php";
			$templates[] = "classic-templates/single-{$object->post_type}.php";
		}

		$templates[] = 'classic-templates/single.php';

		return get_query_template( 'single', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_page_template' ) ) {

	function emulsion_get_page_template() {
		$id			 = get_queried_object_id();
		$template	 = get_page_template_slug();
		$pagename	 = get_query_var( 'pagename' );

		if ( ! $pagename && $id ) {
			// If a static page is set as the front page, $pagename will not be set.
			// Retrieve it from the queried object.
			$post = get_queried_object();
			if ( $post ) {
				$pagename = $post->post_name;
			}
		}

		$templates = array();
		if ( $template && 0 === validate_file( $template ) ) {
			$templates[] = $template;
		}
		if ( $pagename ) {
			$pagename_decoded = urldecode( $pagename );
			if ( $pagename_decoded !== $pagename ) {
				$templates[] = "classic-templates/page-{$pagename_decoded}.php";
			}
			$templates[] = "classic-templates/page-{$pagename}.php";
		}
		if ( $id ) {
			$templates[] = "classic-templates/page-{$id}.php";
		}
		$templates[] = 'classic-templates/page.php';

		return get_query_template( 'page', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_home_template' ) ) {

	function emulsion_get_home_template() {
		$templates = array( 'classic-templates/home.php' );

		return get_query_template( 'home', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_front_page_template' ) ) {

	function emulsion_get_front_page_template() {

		$templates = array( 'classic-templates/front-page.php' );

		return get_query_template( 'frontpage', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_privacy_policy_template' ) ) {

	function emulsion_get_privacy_policy_template() {

		$templates = array( 'classic-templates/privacy-policy.php' );

		return get_query_template( 'privacypolicy', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_404_template' ) ) {

	function emulsion_get_404_template() {
		$templates = array( 'classic-templates/404.php' );
		return get_query_template( '404', $template );
	}

}
if ( ! function_exists( 'emulsion_get_archive_template' ) ) {

	function emulsion_get_archive_template() {
		$post_types = array_filter( (array) get_query_var( 'post_type' ) );

		$templates = array();

		if ( count( $post_types ) == 1 ) {
			$post_type	 = reset( $post_types );
			$templates[] = "classic-templates/archive-{$post_type}.php";
		}
		$templates[] = 'classic-templates/archive.php';

		return get_query_template( 'archive', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_post_type_archive_template' ) ) {

	function emulsion_get_post_type_archive_template() {
		$post_type = get_query_var( 'post_type' );
		if ( is_array( $post_type ) ) {
			$post_type = reset( $post_type );
		}

		$obj = get_post_type_object( $post_type );
		if ( ! ( $obj instanceof WP_Post_Type ) || ! $obj->has_archive ) {
			return '';
		}

		return emulsion_get_archive_template();
	}

}
if ( ! function_exists( 'emulsion_get_taxonomy_template' ) ) {

	function emulsion_get_taxonomy_template() {
		$term = get_queried_object();

		$templates = array();

		if ( ! empty( $term->slug ) ) {
			$taxonomy = $term->taxonomy;

			$slug_decoded = urldecode( $term->slug );
			if ( $slug_decoded !== $term->slug ) {
				$templates[] = "classic-templates/taxonomy-$taxonomy-{$slug_decoded}.php";
			}

			$templates[] = "classic-templates/taxonomy-$taxonomy-{$term->slug}.php";
			$templates[] = "classic-templates/taxonomy-$taxonomy.php";
		}
		$templates[] = 'classic-templates/taxonomy.php';

		return get_query_template( 'taxonomy', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_embed_template' ) ) {

	function emulsion_get_embed_template() {
		$object = get_queried_object();

		$templates = array();

		if ( ! empty( $object->post_type ) ) {
			$post_format = get_post_format( $object );
			if ( $post_format ) {
				$templates[] = "classic-templates/embed-{$object->post_type}-{$post_format}.php";
			}
			$templates[] = "classic-templates/embed-{$object->post_type}.php";
		}

		$templates[] = 'classic-templates/embed.php';

		return get_query_template( 'embed', $templates );
	}

}
if ( ! function_exists( 'emulsion_get_attachment_template' ) ) {

	function emulsion_get_attachment_template() {
		$attachment = get_queried_object();

		$templates = array();

		if ( $attachment ) {
			if ( false !== strpos( $attachment->post_mime_type, '/' ) ) {
				list( $type, $subtype ) = explode( '/', $attachment->post_mime_type );
			} else {
				list( $type, $subtype ) = array( $attachment->post_mime_type, '' );
			}

			if ( ! empty( $subtype ) ) {
				$templates[] = "classic-templates/{$type}-{$subtype}.php";
				$templates[] = "classic-templates/{$subtype}.php";
			}
			$templates[] = "classic-templates/{$type}.php";
		}
		$templates[] = 'classic-templates/attachment.php';

		return get_query_template( 'attachment', $templates );
	}

}
/**
 * Custom CSS
 */
'disable' == get_theme_mod( 'emulsion_custom_css_support' ) ? emulsion_custom_css_support() : '';

function emulsion_custom_css_support() {
	global $wp_customize;

	if ( 'theme' !== emulsion_get_theme_operation_mode() ) {
		remove_action( 'wp_head', 'wp_custom_css_cb', 101 );

		add_action( 'customize_register', function ( $wp_customize ) {
			$wp_customize->remove_section( 'custom_css' );
		} );
	}
}

/**
 * Block Patterns
 */
add_action( 'init', function () {
	'enable' !== get_theme_mod( 'emulsion_core_block_patterns_support' ) ? remove_theme_support( 'core-block-patterns' ) : add_theme_support( 'core-block-patterns' );
}, 9 );

/**
 * admin bar
 */
function emulsion_admin_bar_items( $wp_admin_bar ) {

	if( is_attachment()){
		$wp_admin_bar->remove_node( 'site-editor' );
		$admin_url = esc_url( admin_url( 'site-editor.php?postId=emulsion%2F%2Fattachment&postType=wp_template&canvas=edit&notice=isAttachment' ) );

		$wp_admin_bar->add_node( array(
			'id'	 => 'site-editor-styles',
			'title'	 => esc_html__( 'Site Editor', 'emulsion' ),
			'href'	 => $admin_url,
		) );
	}

	if ( 'theme' == emulsion_get_theme_operation_mode() ) {

		$wp_admin_bar->remove_node( 'site-editor' );
		$admin_url = esc_url( admin_url( 'site-editor.php?postId=emulsion%2F%2Findex&postType=wp_template&canvas=edit&notice=isClassic' ) );

		$wp_admin_bar->add_node( array(
			'id'	 => 'site-editor-styles',
			'title'	 => esc_html__( 'Site Editor Styles', 'emulsion' ),
			'href'	 => $admin_url,
		) );
	}
}

add_action( 'admin_bar_menu', 'emulsion_admin_bar_items', 999 );

if ( ! function_exists( 'emulsion_get_template_type' ) ) {

	function emulsion_get_template_type( $template_name = '' ) {
		global $template;

		$current_template = empty( $template_name ) ? $template : $template_name;

		if ( false !== strstr( $current_template, '.php' ) && false === strstr( $current_template, 'template-canvas' ) ) {

			return 'php';
		}

		return 'html';
	}

}