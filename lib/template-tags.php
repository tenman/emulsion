<?php
/**
 *
 *
 */
if ( ! function_exists( 'emulsion_get_site_title' ) ) {

	function emulsion_get_site_title( ) {

		$logo = '';

		$site_title_text_class = 'site-title-text';
		$site_title_text_class .= get_theme_mod('header_textcolor') == 'blank' ? ' screen-reader-text': '';

		if ( has_custom_logo() ) {
			$custom_logo_id = get_theme_mod( 'custom_logo' );

			$logo = sprintf( '<span class="custom-logo-wrap"><img width="%1$d" height="%2$d" src="%3$s" class="custom-logo" alt="%4$s"></span>',
						absint( emulsion_get_supports( 'custom-logo' )[0]['default']['width'] ),
						absint( emulsion_get_supports( 'custom-logo' )[0]['default']['height'] ),
						esc_url( wp_get_attachment_image_src( $custom_logo_id , 'full' )[0] ),
						esc_attr( get_bloginfo( 'name', 'display' ) )
					);
		}
		$title_format	 = '<%1$s class="%5$s" id="site-title">
								<a href="%2$s" rel="%3$s" class="site-title-link">%6$s
									<span class="%7$s">%4$s</span>
								</a>
							</%1$s>';

		$html			 = sprintf( $title_format, 'h1', esc_url( home_url( '/' ) ), "home", get_bloginfo( 'name', 'display' ), apply_filters( 'emulsion_get_site_title_class', 'site-title' ), $logo
		, $site_title_text_class );
		return $html;
	}

}
if ( ! function_exists( 'emulsion_the_site_title' ) ) {

	function emulsion_the_site_title() {

		$title = apply_filters( "emulsion_the_site_title", emulsion_get_site_title() );

		// check lost element
		$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
		true === WP_DEBUG ? emulsion_elements_assert_equal( $title, wp_kses_post( $title ), $emulsion_place ) : '';

		echo wp_kses_post( $title );
	}
}
if ( ! function_exists( 'emulsion_site_text_markup' ) ) {

	function emulsion_site_text_markup() {

		$site_description_class	 = 'site-description';
		$site_description_class	 .= get_theme_mod( 'header_textcolor' ) == 'blank' ? ' screen-reader-text' : '';
		$site_title				 = emulsion_get_site_title();
		$site_description		 = get_bloginfo( 'description', 'display' );
		$html					 = '<div class="header-text">%1$s<p class="%3$s">%2$s</p></div>';
		$markup					 = sprintf( $html, $site_title, $site_description, $site_description_class );
		$header_text			 = get_theme_mod( 'emulsion_header_html', '' );

		if ( 'self' == get_theme_mod( 'emulsion_header_layout' ) ) {
			/* user html header-self.php */
			$header_text = apply_filters( 'emulsion_site_text_markup_self', $header_text, $markup, $site_title, $site_description );

			// check lost element
			$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
			true === WP_DEBUG ? emulsion_elements_assert_equal( $header_text, wp_kses_post( $header_text ), $emulsion_place ) : '';

			echo  wp_kses_post( $header_text );
		} else {
			/* template part file header-custom.php or header.php */
			$markup = apply_filters( 'emulsion_site_text_markup', $markup, $site_title, $site_description );

			// check lost element
			$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
			true === WP_DEBUG ? emulsion_elements_assert_equal( $markup, wp_kses_post( $markup ), $emulsion_place ) : '';

			echo  wp_kses_post( $markup );
		}
	}
}
/**
 * Article Title
 * @return string
 */
if ( ! function_exists( 'emulsion_get_post_title' ) ) {

	function emulsion_get_post_title( $with_thumbnail = true,	$size = 'large' ) {

		global $post;
		$html				 = '';
		$post_id			 = absint( get_the_ID() );
		$entry_title_status	 = get_theme_mod( 'emulsion_title_in_header', emulsion_get_var( 'emulsion_title_in_header' ) );

		if ( 'yes' == $entry_title_status ) {

			/**
			 * When the title is displayed in the site header,
			 * the display area is limited. For exceptionally long titles,
			 * limit the font size and the number of lines to display the full title as much as possible.
			 */

			$insert_start_tag	 = '<span class="trancate-heading" data-rows="8">';
			$insert_end_tag		 = '</span>';
		} else {

			$insert_start_tag	 = '';
			$insert_end_tag		 = '';
		}

		if ( is_singular() ) {

			return the_title( '<h2 class="entry-title">'.$insert_start_tag, $insert_end_tag.'</h2>', false );
		} else {

			if ( has_post_thumbnail() && true == $with_thumbnail && ! post_password_required( $post_id ) ) {

				$html = '<h2 class="entry-title"><a href="%1$s">'. $insert_start_tag.'%2$s'. $insert_end_tag.'</a></h2>';
			} else {

				$html = '<h2 class="entry-title"><a href="%1$s">'. $insert_start_tag.'%2$s'. $insert_end_tag.'</a></h2>';
			}

			return sprintf( $html, esc_url( get_permalink() ), the_title( '', '', false ) );
		}
	}

}
if ( ! function_exists( 'emulsion_the_post_title' ) ) {

	function emulsion_the_post_title( $with_thumbnail = true,	$size = 'large' ) {

		$title = apply_filters( 'emulsion_the_post_title', emulsion_get_post_title( $with_thumbnail, $size ) );

		echo wp_kses_post( $title );
	}

}

if ( ! function_exists( 'emulsion_entry_text_markup' ) ) {
	/**
	 * Print title block in header
	 *
	 * Entry title, Archive title, Search results
	 * @global type $post
	 */
	function emulsion_entry_text_markup() {
		global $post;

		$enable = emulsion_get_supports( 'title_in_page_header' );

		if ( $enable ) {

			if ( is_singular() && ! is_front_page() ) {

				$id = get_the_ID();
				echo '<div class="entry-text"><div>';
				echo '<a class="emulsion-scroll" href="#post-' . absint( $id ) . '">';
				emulsion_the_post_title();
				echo '</a>';
				emulsion_the_post_meta_on();
				emulsion_the_post_meta_in();
				echo '</div></div>';
			} elseif( ! is_home() && ! is_front_page() ) {

				emulsion_archive_title();
			}
		}
	}
}
if ( ! function_exists( 'emulsion_meta_description' ) ) {
	/**
	 * fallback head meta element description
	 *
	 * This summary statement is added after javascript is loaded,
	 * so if the SEO plug-in has already added a meta description, it will not add it.
	 *
	 * @return type
	 */
	function emulsion_meta_description() {

		if( false == emulsion_add_supports( 'meta_description' ) ) {

			__return_empty_string();
		}

		if ( is_singular() ) {

			$excerpt = get_the_excerpt();
			$excerpt = str_replace( '[...]', '' , $excerpt );
			$excerpt = wp_html_excerpt( $excerpt, 160, '' );

			if ( ! empty( $excerpt ) ) {

				return $excerpt;
			}
		} else {

			$excerpt =  term_description();
			$excerpt = wp_html_excerpt( $excerpt, 160, '' );

			if ( ! empty( $excerpt ) ) {

				return $excerpt;
			}

		}

		__return_empty_string();
	}

}





if ( ! function_exists( 'emulsion_post_content' ) ) {
	/**
	 * The summary sentence displays the text that removes the table element,
	 * the figure element excluded from the HTML5 outline, etc.,
	 * which significantly impairs readability when the text is extracted.
	 */
	function emulsion_post_content() {

		$use_excerpt = emulsion_get_supports( 'excerpt' );

		$supports_stream		 = emulsion_get_supports( 'stream' );
		$supports_grid			 = emulsion_get_supports( 'grid' );
		$message_protected_post	 = esc_html__( 'Password is required to view this post', 'emulsion' );
		$post_id				 = absint( get_the_ID() );
		$stream					 = emulsion_has_archive_format( $supports_stream );
		$grid					 = emulsion_has_archive_format( $supports_grid );
		$get_post				 = get_post( $post_id, 'OBJECT', 'display' );
		$excerpt_length			 = apply_filters( 'excerpt_length', 256 );
		$read_more_text			 = esc_html__( '...', 'emulsion' );
		$excerpt_from_content	 = '';
		$excerpt_html_wrapper	 = '<blockquote cite="%2$s" class="content-excerpt">%1$s</blockquote>';

		// Create excerpt from entry content
		$post_text = strip_shortcodes( $get_post->post_content );
		$has_more	 = stristr( $post_text, '<!--more-->' );

		if ( ! empty( $post_text ) ) {

			/**
			 * Delete deactivated short code
			 * it is not certain,but
			 */

			$post_text = preg_replace( '!\[[^\]]+\]!', '', $post_text );

			/**
			 * add space end tag before element text
			 * Even if tags are removed, keep space and increase readability
			 */

			$word_separate_count = 0;

			$post_text	 = str_replace( '</', ' </', $post_text, $word_separate_count );

			/**
			 * remove element and their contents
			 */

			$post_text	 = emulsion_strip_tags_content( $post_text, '<table><del><figure><blockquote>', true );

			/**
			 * Remove Comments
			 */

			$post_text	 = strip_tags( $post_text );

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

			$post_text	 = emulsion_remove_url_from_text( $post_text );

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
			 * Deletion of html element and setting character length
			 * not word count , string length
			 */

			/* translators: ... is read more */
			$post_text	 = wp_html_excerpt( $post_text, $excerpt_length, $read_more_text );

			/**
			 * Return an alternate character to a line feed to hold line breaks
			 */

			$post_text	 = str_replace( array( "[lb2]", "[lb1]" ), array( "\r\n\r\n", "\r\n" ), $post_text );

			$post_text = preg_replace( array( '/\[[lb12]*(' . $read_more_text . ')?\s*$/' ), $read_more_text, $post_text );

			/**
			 * the blockquote element to indicate that it is not the posted content itself
			 */

			$post_text = trim( $post_text );

			if ( $read_more_text !== $post_text ) {

				$excerpt_from_content = sprintf( $excerpt_html_wrapper, wpautop( $post_text ), get_permalink( $post_id ) );
			} else {

				$excerpt_from_content = '';
			}
		}

		// has excerpt allow all elements

		$has_excerpt = $get_post->post_excerpt;

		if ( ! $has_excerpt ) {

			$excerpt_plain_text = trim( wp_strip_all_tags( $excerpt_from_content ) );
		} else {

			$excerpt_plain_text = trim( wp_strip_all_tags( $has_excerpt ) );
		}

		if ( ! post_password_required( $post_id ) ) {

			if ( 'excerpt' == $grid ) {

				$lines = absint( get_theme_mod('emulsion_excerpt_length_grid', 4 ) );

				$result = sprintf( '<p class="%2$s" data-rows="%3$d">%1$s</p>', wp_kses_post( $excerpt_plain_text ), 'trancate', $lines );

				$result = apply_filters('emulsion_post_excerpt', $result );

				// check lost element
				$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
				true === WP_DEBUG ? emulsion_elements_assert_equal( $result, wp_kses( $result, EMULSION_EXCERPT_ALLOWED_ELEMENTS ), $emulsion_place ) : '';

				echo wp_kses( $result, EMULSION_EXCERPT_ALLOWED_ELEMENTS );
			} elseif ( 'excerpt' == $stream ) {

				$lines = absint( get_theme_mod('emulsion_excerpt_length_stream', 2 ) );


				$result = sprintf( '<p class="%2$s" data-rows="%3$d">%1$s</p>', wp_kses_post( $excerpt_plain_text ), 'trancate', $lines );
				$result = apply_filters('emulsion_post_excerpt', $result );

				// check lost element
				$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
				true === WP_DEBUG ? emulsion_elements_assert_equal( $result, wp_kses( $result, EMULSION_EXCERPT_ALLOWED_ELEMENTS ), $emulsion_place ) : '';

				echo wp_kses( $result, EMULSION_EXCERPT_ALLOWED_ELEMENTS );
			} else {

				if ( ! $use_excerpt || is_search() ) {

						the_content();

				} else {

					if ( ! is_singular() ) {

						if ( ! $has_excerpt && $excerpt_from_content ) {

							if ( false === $has_more ) {
								
								$excerpt_from_content  = apply_filters('emulsion_post_excerpt', $excerpt_from_content );
								// check lost element
								$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
								true === WP_DEBUG ? emulsion_elements_assert_equal( $excerpt_from_content, wp_kses_post( $excerpt_from_content ), $emulsion_place ) : '';

								echo wp_kses_post( $excerpt_from_content );
							} else {

								the_content();
							}
						} elseif ( $has_excerpt ) {
							/**
							 * Since the specially-written summary sentence may not necessarily quote the content, we do not use blockquote
							 */
							if( 0 == strcmp( trim( $has_excerpt ), $excerpt_plain_text ) ) {
								// if not contain html tags
								//
								// check lost element
								$has_excerpt  = apply_filters('emulsion_post_excerpt', $has_excerpt );
								$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
								true === WP_DEBUG ? emulsion_elements_assert_equal(  wpautop( $has_excerpt ), wp_kses( wpautop( $has_excerpt ), EMULSION_EXCERPT_ALLOWED_ELEMENTS ), $emulsion_place ) : '';

								echo wp_kses( wpautop( $has_excerpt ), EMULSION_EXCERPT_ALLOWED_ELEMENTS );
							} else {
							    //Wrap with fit class to match content_width
								$has_excerpt = sprintf('<div class="post-excerpt-html fit">%1$s</div>', $has_excerpt );
								$has_excerpt  = apply_filters('emulsion_post_excerpt', $has_excerpt );
								// check lost element
								$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
								true === WP_DEBUG ? emulsion_elements_assert_equal(  $has_excerpt, wp_kses_post( $has_excerpt ), $emulsion_place ) : '';

								echo wp_kses_post( $has_excerpt );
							}
						}
					} else {

						the_content();
					}
				}
			}
		} else {

			// check lost element
			$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
			true === WP_DEBUG ? emulsion_elements_assert_equal(  get_the_password_form( $post_id ), wp_kses( get_the_password_form( $post_id ), EMULSION_FORM_ALLOWED_ELEMENTS ), $emulsion_place ) : '';

			echo wp_kses( get_the_password_form( $post_id ), EMULSION_FORM_ALLOWED_ELEMENTS );
		}
	}

}
if ( ! function_exists( 'emulsion_post_excerpt_more' ) ) {

	function emulsion_post_excerpt_more() {
		$supports_grid	 = emulsion_get_supports( 'grid' );
		$grid			 = emulsion_has_archive_format( $supports_grid );
		$post_id		 = get_the_ID();
		$permalink		 = get_permalink( $post_id );
		$article		 = get_post( $post_id );
		if ( $article ) {
			if ( preg_match( '$<!--more-->$', $article->post_content ) && 'excerpt' == $grid ) {
				printf( '<span><a href="%1$s#top" class="skin-button">Read More</a></span>', esc_url( $permalink ) );
			}
		}
	}

}
if ( ! function_exists( 'emulsion_has_archive_format' ) ) {
	/**
	 * Determine whether the archive page is full text or summary
	 *
	 * @param type $supports_stream
	 * @return string
	 */
	function emulsion_has_archive_format( $supports_stream = array() ) {
		$post_id = absint( get_the_ID() );

		$post_body_type = emulsion_get_supports( 'excerpt' );


		if ( false !== $post_id ) {

			foreach ( $supports_stream[0] as $stream ) {

				if ( is_string( $stream ) ) {

					$conditiona_func_name = 'is_' . $stream;

					if ( 'blog' == $stream ) {
						$conditiona_func_name = 'emulsion_is_posts_page';
					}
					if ( 'post_tag' == $stream ) {
						$conditiona_func_name = 'is_tag';
					}

					if ( function_exists( $conditiona_func_name ) && $conditiona_func_name() ) {

						if( $post_body_type ) {
							return 'excerpt';
						} else {
							return 'full-text';
						}

					}
				} elseif ( is_array( $stream ) && 'post_type' == key( $stream ) ) {

					foreach ( $stream as $custom_post ) {

						if ( is_post_type_archive( $custom_post ) ) {

							if( $post_body_type ) {
								return 'excerpt';
							} else {
								return 'full-text';
							}
						}
					}
				}
			}
		}
	}

}
if ( ! function_exists( 'emulsion_get_post_meta_in' ) ) {

	/**
	 * get posted in block
	 * @return stringCategory and Tags in Article
	 */
	function emulsion_get_post_meta_in() {

		$tag_list		 = '';
		$category_list	 = '';
		$result			 = '';

		if ( has_tag() || has_category() ) {
			$result = '<div class="entry-meta taxonomy">';
		}

		if ( has_tag() ) {

			$class	 = 'inline' == get_theme_mod( 'emulsion_post_display_tag', emulsion_get_var( 'emulsion_post_display_tag' ) ) ? ' has-tag' : '';

			$tag_list	 = get_the_tag_list( '<ul class="post-tag horizontal-list-group '. $class. '"><li>', '</li><li>', '</li></ul>' );
			$result		 .= $tag_list;
		}
		if ( has_category() ) {

			$post_terms = wp_get_object_terms( get_the_ID(), 'category', array( 'fields' => 'ids' ) );

			if ( ! empty( $post_terms ) ) {

				$args = array(
					'include'		 => $post_terms,
					'taxonomy'		 => 'category',
					'echo'			 => false,
					'title_li'		 => '',
					'hierarchical'	 => false,
				);

				$category_list	 = wp_list_categories( $args );

				$class	 = 'inline' == get_theme_mod( 'emulsion_post_display_category', emulsion_get_var( 'emulsion_post_display_category' ) ) ? ' has-category' : '';

				$result			 .= sprintf( '<ul class="post-category horizontal-list-group %2$s">%1$s</ul>', $category_list, $class );
			}
		}

		if ( has_tag() || has_category() ) {
			$result .= '</div>';
		}
		return $result;
	}

}
if ( ! function_exists( 'emulsion_the_post_meta_in' ) ) {
	/**
	 * Santize Posted in block and filter
	 * @return type
	 */
	function emulsion_the_post_meta_in() {

		if ( post_password_required() ) {
			return;
		}

		$result = apply_filters( 'emulsion_the_post_meta_in', emulsion_get_post_meta_in() );

		// check lost element
		$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
		true === WP_DEBUG ? emulsion_elements_assert_equal(  $result, wp_kses_post( $result ), $emulsion_place ) : '';

		echo wp_kses_post( $result );
	}

}
if ( ! function_exists( 'emulsion_get_post_meta_on' ) ) {

	/**
	 * get posted in block
	 * @return typePost Date and Author in Article
	 */
	function emulsion_get_post_meta_on() {
		global $authordata, $post;

		if ( post_password_required() ) {
			return;
		}


		$html = '<div class="%6$s">
		<span class="meta-prep meta-prep-author">
			<span class="posted-on-string screen-reader-text">%1$s</span>
		</span>
		%2$s
		<span class="meta-sep">
			<span class="posted-by-string screen-reader-text">%3$s</span>
		</span>
		<span class="author vcard">%4$s</span>
		%5$s
	</div>';

		$class = 'posted-on';
		$class	 .= 'inline' == get_theme_mod( 'emulsion_post_display_date', emulsion_get_var( 'emulsion_post_display_date' ) ) ? ' has-date' : '';
		$class	 .= 'inline' == get_theme_mod( 'emulsion_post_display_author', emulsion_get_var( 'emulsion_post_display_author' ) ) ? ' has-author' : '';


		$text_1		 = esc_html__( 'Posted on', 'emulsion' );
		$text_2		 = esc_html__( 'by', 'emulsion' );
		$author_url	 = get_author_posts_url( $post->post_author );
		$author_name = get_the_author_meta( 'display_name', $post->post_author );

		if ( 'text' == get_theme_mod( 'emulsion_post_display_author_format' , emulsion_get_var( 'emulsion_post_display_author_format' ) ) ) {
			if ( is_author() ) {
				$author = get_the_author();
			} else {
				// filter: the_author_posts_link
				$author = get_the_author_posts_link();
			}
			if ( empty( $author ) ) {
				//single
				$author		 = sprintf( '<a href="%1$s" rel="author" class="url fn nickname">%2$s</a>', esc_url( $author_url ), esc_html( $author_name ) );
			}
		}
		if ( 'inline' == get_theme_mod( 'emulsion_post_display_author_format', emulsion_get_var( 'emulsion_post_display_author_format' ) ) ) {

			$author_id	 = get_the_author_meta( 'ID' );
			$font_size	 = get_theme_mod( 'emulsion_widget_meta_font_size', emulsion_get_var( 'emulsion_widget_meta_font_size' ) );
			$avator_size = (int) $font_size * 1.5;
			$author		 = get_avatar( $author_id, $avator_size );
			$author		 = sprintf( '<a href="%1$s" rel="author" class="url fn nickname">%2$s<span class="screen-reader-text">%3$s</span></a>', esc_url( $author_url ), $author, $author_name  );
			$class		 .= ' avatar-inline';
		}
		if ( 'block' == get_theme_mod( 'emulsion_post_display_author_format', emulsion_get_var( 'emulsion_post_display_author_format' ) ) ) {

			$author_id	 = get_the_author_meta( 'ID' );
			$author		 = get_avatar( $author_id );
			$author		 = sprintf( '<a href="%1$s" rel="author" class="url fn nickname">%2$s<span class="screen-reader-text">%3$s</span></a>', esc_url( $author_url ), $author, $author_name );
			$class		 .= ' avatar-block';
		}


		$emulsion_post_id = absint( get_the_ID() );
		$comment_link	   = '';

		if ( 0 < $emulsion_post_id && comments_open( $emulsion_post_id ) ) {
			;
			$comment_link = wp_kses( emulsion_comment_link() , EMULSION_POST_META_DATA_ALLOWED_ELEMENTS );
		}

			$entry_month_html =  wp_kses( emulsion_get_month_link(), EMULSION_POST_META_DATA_ALLOWED_ELEMENTS );

		$result = sprintf( $html, $text_1, $entry_month_html, $text_2, $author, $comment_link, $class );

		return $result;
	}

}
if ( ! function_exists( 'emulsion_the_post_meta_on' ) ) {
	/**
	 * Santize Posted on block and filter
	 * @return type
	 */
	function emulsion_the_post_meta_on() {

		if ( post_password_required() ) {

			return;
		}

		$posted_on = apply_filters( 'emulsion_the_post_meta_on', emulsion_get_post_meta_on() );

		// check lost element
		$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
		true === WP_DEBUG ? emulsion_elements_assert_equal(  $posted_on, wp_kses( $posted_on, EMULSION_POST_META_DATA_ALLOWED_ELEMENTS ), $emulsion_place ) : '';

		echo wp_kses( $posted_on, EMULSION_POST_META_DATA_ALLOWED_ELEMENTS );
	}

}
if ( ! function_exists( 'emulsion_comment_link' ) ) {
	/**
	 * Get comment link elements
	 * @return type
	 */
	function emulsion_comment_link() {

		$html	 = '<a href="%1$s" class="comment-link">%2$s</a>';
		$text	 = esc_html__( 'Comment', 'emulsion' );

		$comment_link	 = sprintf( $html, get_comments_link(), $text );
		$comment_link	 = apply_filters( 'emulsion_comment_link', $comment_link );

		return $comment_link;
	}

}
if ( ! function_exists( 'emulsion_get_month_link' ) ) {
	/**
	 * Posted on date link
	 * datelink text date format value. link href url to month archive
	 * Todo: Paged link not support yet, a fragment identifier not work when paged..
	 * @return type
	 */

	function emulsion_get_month_link() {

		$type = get_theme_mod( 'emulsion_post_display_date_format', emulsion_get_var( 'emulsion_post_display_date_format' ) );

			$entry_date_html = '<a href="%1$s" rel="%2$s"><%4$s class="entry-date %6$s" %5$s>%3$s</%4$s></a>';

			$emulsion_post_id	 = get_the_ID();
			$published_class	 = 'updated';
			$archive_year		 = get_the_time( 'Y' );
			$archive_month		 = get_the_time( 'm' );
			//$archive_day		 = get_the_time( 'd' );
			$month_link			 = esc_url( get_month_link( $archive_year, $archive_month ) . '#post-' . $emulsion_post_id );

		if ( 'ago' == $type ) {

			$publish_date =  get_the_time('U');
			/* translators: %1$s human_time_diff() */
			$date_text = sprintf( esc_html__( '%1$s ago', 'emulsion' ), human_time_diff( $publish_date, current_time( 'timestamp' ) ) );
		}
		if ( 'default' == $type ) {

			$date_format		 = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
			$date_text			 = get_the_date( $date_format );
		}

		$entry_date_html	 = sprintf( $entry_date_html, $month_link, 'date', $date_text, 'time', 'datetime="' . esc_attr( get_the_date( 'c' ) ) . '"', $published_class );


		return apply_filters( 'emulsion_get_month_link', $entry_date_html, $type );
	}
}
if ( ! function_exists( 'emulsion_get_day_link' ) ) {
	/**
	 * Link post date link to date archive.
	 *
	 * This function is not currently used in the theme,
	 * but is prepared for use as a fallback link if the title is blank.
	 * Posted on date link
	 * datelink text date format value. link href url to date archive
	 * @return type
	 */
	function emulsion_get_day_link() {

		$type = get_theme_mod( 'emulsion_post_display_date_format', emulsion_get_var( 'emulsion_post_display_date_format' ) );

			$entry_date_html = '<a href="%1$s" rel="%2$s"><%4$s class="entry-date %6$s" %5$s>%3$s</%4$s></a>';

			$emulsion_post_id	 = get_the_ID();
			$published_class	 = 'updated';
			$archive_year		 = get_the_time( 'Y' );
			$archive_month		 = get_the_time( 'm' );
			$archive_day		 = get_the_time( 'd' );
			$day_link			 = esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) . '#post-' . $emulsion_post_id );

		if ( 'ago' == $type ) {

			$publish_date =  get_the_time('U');
			/* translators: %1$s human_time_diff() */
			$date_text = sprintf( esc_html__( '%1$s ago', 'emulsion' ), human_time_diff( $publish_date, current_time( 'timestamp' ) ) );
		}
		if ( 'default' == $type ) {

			$date_format		 = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
			$date_text			 = get_the_date( $date_format );
		}

		$entry_date_html	 = sprintf( $entry_date_html, $day_link, 'date', $date_text, 'time', 'datetime="' . esc_attr( get_the_date( 'c' ) ) . '"', $published_class );


		return apply_filters( 'emulsion_get_day_link', $entry_date_html, $type );
	}
}

if ( ! function_exists( 'emulsion_archive_title' ) ) {

	/**
	 * print archive title block
	 * @global type $wp_query
	 * @return type
	 */
	function emulsion_archive_title() {
		global $wp_query;

		if ( false == is_home() && true == is_front_page() ) {

			return;
		}


		if ( is_archive() || is_search() || is_404() ) {

			print '<div class="page-title-block">';
		}

		if ( is_404() ) {

			get_template_part( 'template-parts/content', 'none' );
		}

		if ( is_archive() ) {

			if ( is_year() ) {

				the_archive_title( '<h2 class="archive-title year">', '</h2>' );
				emulsion_archive_year_navigation();
			} elseif ( is_month() ) {

				the_archive_title( '<h2 class="archive-title month">', '</h2>' );
				emulsion_monthly_archive_prev_next_navigation( true,  false );
			} else {

				the_archive_title( '<h2 class="archive-title">', '</h2>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			}
		}
		if ( is_search() ) {

			if ( 0 == $wp_query->found_posts ) {

				printf( '<h2 class="%4$s">%3$s</h2><p class="search-query"><span class="keyword">%1$s</span><span class="separator">:</span><span class="count">%2$s</span></p>', get_search_query( true ), absint( $wp_query->found_posts ), esc_html__( 'Sorry, no posts matched your search. Please try again', 'emulsion' ), 'fail-search' );

				print get_search_form();
			} else {

				printf( '<h2 class="%4$s">%3$s</h2><p class="search-query"><span class="keyword">%1$s</span><span class="separator">:</span><span class="count">%2$s</span></p>', get_search_query( true ), absint( $wp_query->found_posts ), esc_html__( 'Search Results', 'emulsion' ), 'search-title' );
			}
		}
		if ( is_archive() || is_search() || is_404() ) {

			print '</div>';
		}
	}
}
if ( ! function_exists( 'emulsion_customizer_have_posts_class_helper' ) ) {

	function emulsion_customizer_have_posts_class_helper() {

		//Note is_front_page()) is false on customize preview

		if ( emulsion_is_posts_page() ) {

			return get_theme_mod( 'emulsion_layout_posts_page', emulsion_get_var( 'emulsion_layout_posts_page' ) );
		} elseif ( is_home() ) {

			return get_theme_mod( 'emulsion_layout_homepage', emulsion_get_var( 'emulsion_layout_homepage' ) );
		}
		if ( is_date() ) {

			return get_theme_mod( 'emulsion_layout_date_archives', emulsion_get_var( 'emulsion_layout_date_archives' ) );
		}
		if ( is_category() ) {

			return get_theme_mod( 'emulsion_layout_category_archives', emulsion_get_var( 'emulsion_layout_category_archives' ) );
		}
		if ( is_tag() ) {

			return get_theme_mod( 'emulsion_layout_tag_archives', emulsion_get_var( 'emulsion_layout_tag_archives' ) );
		}
		if ( is_author() ) {

			return get_theme_mod( 'emulsion_layout_author_archives', emulsion_get_var( 'emulsion_layout_author_archives' ) );
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
if ( ! function_exists( 'emulsion_home_type' ) ) {
	/**
	 * Check if homepage is static page or default
	 *
	 * @return boolean|string
	 */
	function emulsion_home_type() {

		if ( false == is_home() && true == is_front_page() ) {
			return 'static';
		}
		if ( true == is_home() && true == is_front_page() ) {

			return 'default';
		}
		if ( true == is_home() && false == is_front_page() ) {
			// static page select,but page is not selected
			return false;
		}
		return false;
	}

}

if ( ! function_exists( 'emulsion_have_posts' ) ) {

	/**
	 * Rendering posts
	 *
	 */

	function emulsion_have_posts() {

		$extend_template_part = emulsion_get_template_part_file_detector( 'stream' );

		$support_excerpt = emulsion_get_supports( 'excerpt' );

		if ( empty( $extend_template_part ) ) {

			$extend_template_part = emulsion_get_template_part_file_detector( 'grid' );
		}

		if( is_customize_preview() ){

			$extend_template_part = emulsion_customizer_have_posts_class_helper();
		}


		if ( empty( $extend_template_part ) || ! is_string( $extend_template_part ) ) {

			$template_part = get_post_type();

			if( 'post' == $template_part ) {

				if( $support_excerpt && ! is_singular() ) {

					$template_part = 'excerpt';
				} else {

					$template_part = 'post';
				}

				// Add exception handling
				if( emulsion_is_posts_page() ) {

					$template_part = get_theme_mod( 'emulsion_layout_posts_page', emulsion_get_var('emulsion_layout_posts_page') );
				}
			}

		} else {
			$template_part = $extend_template_part;
		}

		if ( have_posts() ) {

			emulsion_layout_controller( 'before', $template_part );

			while ( have_posts() ) {

				the_post();

				if ( is_post_type_archive() ) {

					$current_queried_object = get_queried_object();
					$custom_post = sanitize_file_name( $current_queried_object->name );
					get_template_part( 'template-parts/content', $custom_post );

				} else {

					$post_id = get_the_ID();
					$format = get_post_format($post_id);

					if(  false !== $format) {

						get_template_part( 'template-parts/content', $format );
					} else {

						get_template_part( 'template-parts/content', $template_part );
					}
				}

			}
			emulsion_layout_controller( 'after', $template_part );
		}
	}

}
if ( ! function_exists( 'emulsion_have_comments' ) ) {
	/**
	 * Rendering comments
	 */
	function emulsion_have_comments() {

		if( is_singular() ) {
			$emulsion_post_id = absint( get_the_ID() );
			if ( comments_open( $emulsion_post_id ) ) {

				comments_template();
			}
		}
	}
}
if ( ! function_exists( 'emulsion_pagination' ) ) {
	/**
	 * Print pagination
	 */
	function emulsion_pagination() {
		$post_id = get_the_ID();
		// test
		$post_navigation_args = array(
			'prev_text' => '<span class="prev text">'.esc_html__('Previous', 'emulsion'). '</span> <span class="title">%title</span>',
			'next_text' => '<span class="next text">'.esc_html__('next', 'emulsion'). '</span> <span class="title">%title</span>',
		);

		if ( is_singular() ) {

			! is_page() && ! is_attachment() ? the_post_navigation( $post_navigation_args ) : '';
			wp_attachment_is_image( $post_id ) ? emulsion_attachment_pagination() : '';
		} else {

			the_posts_pagination();
		}
	}
}

if ( ! function_exists( 'emulsion_get_template_part_file_detector' ) ) {
	/**
	 * Get the required template file
	 *
	 * @param type $name
	 * @param type $template_slug
	 * @return string
	 */

	function emulsion_get_template_part_file_detector( $name = null,	$template_slug = 'template-parts/content.php' ) {

		$name				 = (string) $name;
		$template_path		 = get_theme_file_path( $template_slug );
		$template_part		 = '';
		$conditional_branch	 = emulsion_get_supports( $name );
		$flag				 = false;

		if ( ! file_exists( $template_path ) || empty( $name ) ) {
			return '';
		}

		foreach ( $conditional_branch[0] as $key => $apply ) {

			$current_queried_object = get_queried_object();

			if ( is_post_type_archive() ) {

				$custom_post = $current_queried_object->name;

				if ( isset( $conditional_branch[0]['post_type'] ) && is_array( $conditional_branch[0]['post_type'] ) ) {

					$flag = in_array( $custom_post, $conditional_branch[0]['post_type'] );
				} elseif ( isset( $conditional_branch[0]['post_type'] ) && $custom_post == $conditional_branch[0]['post_type'] ) {

					$flag = true;
				}

				if ( is_post_type_archive( $custom_post ) && $flag ) {

					$template_part = $name;
					break;
				}
			} else {

				if ( ! empty( $current_queried_object ) ) {

					$taxonomy = $current_queried_object->taxonomy;

					if ( isset( $taxonomy ) && ! empty( $taxonomy ) ) {

						if ( $taxonomy == $apply ) {

							$template_part = $name;
							break;
						}
					}
					//author archives
					$email = $current_queried_object->user_email;

					if ( isset( $email ) && ! empty( $email ) ) {

						if ( 'author' == $apply ) {

							$template_part = $name;
							break;
						}
					}
					$post_name = $current_queried_object->post_name;

					if ( isset( $post_name ) && ! empty( $post_name ) ) {

						if ( $post_name == $apply ) {

							$template_part = $name;
							break;
						}
					}


				} elseif ( ! empty( $apply ) && $key !== 'post_type' ) {

					$apply					 = str_replace( 'post_tag', 'tag', $apply );
					$conditional_function	 = 'is_' . $apply;

					if ( function_exists( $conditional_function ) && $conditional_function() ) {
						$template_part = $name;
						break;
					}
				}
			}
		}

		return $template_part;
	}
}
if ( ! function_exists( 'emulsion_article_header' ) ) {

	/**
	 * Print Article header block
	 */

	function emulsion_article_header() {

		$emulsion_title_in_page_header = emulsion_get_supports( 'title_in_page_header' );



		if ( ! is_singular() || ! $emulsion_title_in_page_header ) {

			if( 'list' == emulsion_current_layout_type() ) {
				$thumbnail_url     = get_the_post_thumbnail_url();
			} else {
				$thumbnail_url     = get_the_post_thumbnail_url(null, 'large');
			}


			$required_password = post_password_required( );

			if ( ! empty( $thumbnail_url ) && ! $required_password) {
				
				$header_element = sprintf( '<header class="%1$s" style="%2$s">', 'has-post-image', 'background-image:url(' . esc_url( $thumbnail_url ) . ' );' );
				
				$header_element = apply_filters('emulsion_article_header', $header_element, 'has-post-image', esc_url( $thumbnail_url ) );
				
				echo wp_kses_post( $header_element );
			} else {

				print('<header>' );
			}
		} else {
			printf( '<header class="%1$s">', 'screen-reader-text' );
		}

		emulsion_the_post_title();
		emulsion_the_post_meta_on();
		emulsion_the_post_meta_in();

		print('</header>' );
	}

}
if ( ! function_exists( 'emulsion_attachment_pagination' ) ) {
	/**
	 * Print attachment image pagination
	 */
	function emulsion_attachment_pagination() {
		?>
		<nav class="navigation attachment-navigation">
				<div class="nav-links">
					<h2 class="screen-reader-text"><?php esc_html_e( 'Image Navigation', 'emulsion' ); ?></h2>
					<div class="nav-previous"><?php previous_image_link( 0 ); ?></div>
					<div class="nav-next"><?php next_image_link( 0 ); ?></div>
				</div>
		</nav>
		<?php
	}

}
if ( ! function_exists( 'emulsion_attachment_image' ) ) {

	/**
	 * Print Attachment Image
	 *
	 * @param type $post_id
	 * @param type $size
	 * @param type $excerpt
	 * @param string $aria_describedby
	 * @return type
	 */

	function emulsion_attachment_image( $post_id = '', $size = 'full', $excerpt = '', $aria_describedby = 'image-description') {

			if(empty( $post_id ) ){
				return;
			}

			$image					 = get_post_meta( $post_id, 'image', true );
			$image					 = wp_get_attachment_image_src( $image, $size );
			$alt					 = get_post_meta( $post_id, '_wp_attachment_image_alt', true );
			$alt_text				 = '';
			$aria_describedby		 = '';
			$alt_text				 = empty( $alt ) ? '' : esc_attr( $alt );
			$attachment_image_html	 = '<a href="%1$s"><img src="%1$s" width="%2$s" height="%3$s" alt="%4$s" describedby="%5$s" /></a>';
			?>
			<figure class="attachment-image">
				<?php
				// check lost element
				$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
				true === WP_DEBUG ? emulsion_elements_assert_equal(  $attachment_image_html, wp_kses_post( $attachment_image_html ), $emulsion_place ) : '';
				printf( wp_kses_post( $attachment_image_html ), esc_url( $image[0] ), esc_attr( $image[1] ), esc_attr( $image[2] ), esc_attr( $alt_text ), esc_attr( $aria_describedby )
				);
				// check lost element
				$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
				true === WP_DEBUG ? emulsion_elements_assert_equal(  $excerpt, wp_kses_post( $excerpt ), $emulsion_place ) : '';
				?>
				<figcaption><?php echo empty( $excerpt ) ? '': wp_kses_post( $excerpt ); ?></figcaption>
			</figure><?php
	}
}
if ( ! function_exists( 'emulsion_is_active_nav_menu' ) ) {
	/**
	 * Conditional function menu is active
	 * @param type $location
	 * @return boolean
	 */
	function emulsion_is_active_nav_menu( $location ) {

		if( ! has_nav_menu( $location ) ) {

			return false;
		} else {

			$locations	 = get_nav_menu_locations();
			$menu		 = wp_get_nav_menu_items( $locations[$location] );

			if ( ! empty( $menu ) ) {
				return true;
			}
		}
		return false;
	}
}
if ( ! function_exists( 'emulsion_the_header_layer_class' ) ) {

	/**
	 * The CSS class is added by judging whether the image or video is set in the header.
	 * @param type $class
	 */

	function emulsion_the_header_layer_class( $class = '' ) {

		/**
		 * Whether the header has images or video, its state is represented by class.
		 * classes : header-video-active, header-image-active, no-header-media password-required
		 */
		$add_class			 = post_password_required() ? ' password-required' : '';
		$post_id			 = absint( get_the_ID() );
		$current_post_type	 = trim( get_post_type( $post_id ) );

		if ( is_header_video_active() &&
				has_header_video() &&
				false !== emulsion_home_type() &&
				'custom' == get_theme_mod( 'emulsion_header_layout', emulsion_get_var( 'emulsion_header_layout' ) )
		) {

			$add_class .= ' header-video-active';
		} elseif ( has_header_image() &&
				( ! is_singular( $current_post_type ) || is_page() ) &&
				! is_paged() &&
				false !== emulsion_home_type() &&
				'custom' == get_theme_mod( 'emulsion_header_layout', emulsion_get_var( 'emulsion_header_layout' ) )
		) {

			//static page or loop
			$add_class .= ' header-image-active';
		} elseif ( is_singular( $current_post_type ) ) {

			if ( ! post_password_required( $post_id ) ) {
				// Post using featured image
				if ( has_post_thumbnail( $post_id ) &&
						'yes' == get_theme_mod( 'emulsion_title_in_header', emulsion_get_var( 'emulsion_title_in_header' ) ) &&
						'custom' == get_theme_mod( 'emulsion_header_layout', emulsion_get_var( 'emulsion_header_layout' ) ) ) {

					$add_class .= ' header-image-active';
				} else {

					$add_class .= ' no-header-media';
				}
			}
		} else {

			$add_class .= ' no-header-media';
		}

		/**
		 * CTA layer
		 */
		if ( has_nav_menu( 'header' ) ) {
			$add_class .= ' cta-layer-active';
		} else {
			$add_class .= ' cta-layer-deactive';
		}

		$header_background_color		 = emulsion_get_css_variables_values( 'header_background_color' );
		$default_header_background_color = emulsion_get_var( 'emulsion_header_background_color', 'default' );

		if ( $default_header_background_color == $header_background_color ) {

			$add_class .= ' header-is-default-color';
		} else {

			$text_color = emulsion_contrast_color( $header_background_color );

			if ( '#333333' == $text_color ) {

				$add_class .= ' header-is-light';
			}
			if ( '#ffffff' == $text_color ) {

				$add_class .= ' header-is-dark';
			}
		}

		echo esc_html( emulsion_class_name_sanitize( $add_class . $class ) );
	}

}
if ( ! function_exists( 'emulsion_sidebar_manager' ) ) {

	/**
	 * Print the classified div element to inform the position of the sidebar
	 *
	 * @param type $position
	 * @param string $suffix
	 */
	function emulsion_sidebar_manager( $position = '', $suffix = '' ) {

		if ( ( is_page() && is_active_sidebar( 'sidebar-3' ) && emulsion_get_supports( 'sidebar' )) ||
				( is_active_sidebar( 'sidebar-1' ) && emulsion_get_supports( 'sidebar' ) ) ) {

			if ( 'left' !== $position && 'right' !== $position ) {

				$position = get_theme_mod( 'emulsion_sidebar_position', emulsion_get_var( 'emulsion_sidebar_position' ) );
			}
			$position		 = apply_filters( 'emulsion_sidebar_manager', $position );
			$post_sidebar	 = emulsion_get_supports( 'sidebar' );
			$page_sidebar	 = emulsion_get_supports( 'sidebar_page' );

			if ( ! empty( $suffix ) ) {
				$suffix = '-' . sanitize_title( $suffix );
			}

			if ( is_page() && $page_sidebar ) {

				printf( '<div class="layout layout-block has-column%2$s side-%1$s">', esc_html( $position ), esc_html( $suffix ) );
			}

			if ( $post_sidebar && ! is_page() ) {

				printf( '<div class="layout layout-block has-column%2$s side-%1$s">', esc_html( $position ), esc_html( $suffix ) );
			}
		}
	}

}
if ( ! function_exists( 'emulsion_footer_text' ) ) {

	/**
	 * Print footer text
	 *
	 * @global type $raindrops_current_theme_name
	 * @global type $raindrops_current_data_theme_uri
	 * @global type $template
	 * @global type $raindrops_accessibility_link
	 * @return type
	 */
	function emulsion_footer_text() {

		$theme_name			 = emulsion_theme_info( 'Name', false );
		$theme_uri			 = emulsion_theme_info( 'ThemeURI', false );
		$site_title			 = get_bloginfo( 'name' );
		$home_url			 = home_url();
		$current_year		 = date( 'Y' );
		$privacy_policy_link = '';
		$parent_name		 = '';

		if ( is_child_theme() ) {

			$parent_name = emulsion_theme_info( 'parentName', false );

			$theme_name = esc_html__( 'Child theme ', 'emulsion' ) .
					esc_html( ucwords( $theme_name ) ) .
					' ' .
					esc_html__( 'of', 'emulsion' ) .
					' ' . esc_html( $parent_name );
		} else {
			/* translators: 1: Theme name */
			$theme_name = esc_html( $theme_name );
		}

		/**
		 * Privacy Policy
		 */
		$raindrops_wp_page_for_privacy_policy = get_option( 'wp_page_for_privacy_policy' );

		if ( ! empty( $raindrops_wp_page_for_privacy_policy ) && function_exists( 'get_the_privacy_policy_link' ) ) {

			$privacy_policy_link = get_the_privacy_policy_link( '&nbsp;<small>', '</small>' );
		}

		/**
		 * Footer Text
		 */
		$html = '<span class="copyright">%1$s</span> <span class="copy">&#169;</span> <span class="year">%2$s</span> <a href="%3$s" rel="home">%4$s</a>';

		$copyright_text = sprintf(
				apply_filters( 'emulsion_copyright_text', $html ), esc_html__( 'Copyright', 'emulsion' ), date( "Y" ), $home_url, $site_title
		);

		$html = ' <span class="sep">|</span> <span class="powered-by">%1$s</span> <a href="%2$s" class="theme-site">%3$s</a>';

		$powered_by = sprintf(
				apply_filters( 'emulsion_powered_by', $html ), esc_html__( 'Designed with the ', 'emulsion' ), $theme_uri, $theme_name );

		$footer_text = '<address>' . $copyright_text . $powered_by . $privacy_policy_link . '</address>';

		$customizer_footer_credit = get_theme_mod( 'emulsion_footer_credit', emulsion_get_var( 'emulsion_footer_credit' ) );

		if ( ! empty( $customizer_footer_credit ) ) {

			$footer_text = str_replace( '%current_year%', $current_year, $customizer_footer_credit );
		}

		$address_html	 = apply_filters( 'emulsion_prepend_footer_address', '' );
		$address_html	 .= $footer_text;
		$address_html	 .= apply_filters( 'emulsion_append_footer_address', '' );

		$address_html = apply_filters( 'emulsion_footer_text', $address_html );

		// check lost element
		$emulsion_place = basename( __FILE__ ) . ' line:' . __LINE__ . ' ' . __FUNCTION__ . '()';
		true === WP_DEBUG ? emulsion_elements_assert_equal( $address_html, wp_kses_post( $address_html ), $emulsion_place ) : '';

		echo wp_kses_post( $address_html );
	}

}
