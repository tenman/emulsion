<?php
/**
 * Article Title
 * @return string
 */
if ( ! function_exists( 'emulsion_get_post_title' ) ) {

	/**
	 *
	 * HTML
	  <h2 class="entry-title">
	  <a href="">
	  <span class="trancate-heading" data-rows="[2,4,8]">Post Title</span>
	  </a>
	  </h2>
	 * data-rows: Maximum number of display lines
	 * If the post title exceeds the maximum number of display lines,
	 * change the font size to the same size as the post content by CSS,
	 */
	function emulsion_get_post_title( $with_thumbnail = false, $size = 'large' ) {

		global $post;

		$html		 = '';
		$post_id	 = get_the_ID();
		//$entry_title_status	 = get_theme_mod( 'emulsion_title_in_header', emulsion_theme_default_val( 'emulsion_title_in_header' ) );
		$layout_type = emulsion_current_layout_type();
		$attr		 = '';
		$class		 = 'entry-title wp-block-post-title';

		switch ( $layout_type ) {
			case 'grid':
				$data_rows	 = absint( emulsion_get_css_variables_value( '--wp--custom--max-height--excerpt-lines' ) );
				break;
			default:
				$data_rows	 = 8;
		}

		if ( 'grid' == $layout_type || 'stream' == $layout_type ) {

			$insert_start_tag	 = '<span class="trancate-heading" data-rows="' . $data_rows . '">';
			$insert_end_tag		 = '</span>';
		} else {

			$insert_start_tag	 = '';
			$insert_end_tag		 = '';
		}

		if ( is_singular() ) {

			return the_title( '<h1 class="entry-title child-of-post-header wp-block-post-title">' . $insert_start_tag, $insert_end_tag . '</h1>', false );
		} else {

			if ( has_post_thumbnail() && true === $with_thumbnail && false !== $post_id && ! post_password_required( $post_id ) ) {

				$html	 .= get_the_post_thumbnail( $post_id, $size );
				$html	 .= '<h2 class="%4$s"><a href="%1$s" %3$s>' . $insert_start_tag . '%2$s' . $insert_end_tag . '</a></h2>';
			} else {

				$html = '<h2 class="%4$s"><a href="%1$s" %3$s>' . $insert_start_tag . '%2$s' . $insert_end_tag . '</a></h2>';
			}

			return sprintf( $html, esc_url( get_permalink() ), the_title( '', '', false ), $attr, $class );
		}
	}

}
if ( ! function_exists( 'emulsion_the_post_title' ) ) {

	/**
	 * Print post title
	 * @see emulsion_get_post_title()
	 * filter: emulsion_the_post_title
	 */
	function emulsion_the_post_title( $with_thumbnail = false, $size = 'large' ) {

		$title = apply_filters( 'emulsion_the_post_title', emulsion_get_post_title( $with_thumbnail, $size ) );

		echo $title;
	}

}

if ( ! function_exists( 'emulsion_article_header' ) ) {

	/**
	 * Print Article header block
	 * Article header is displayed when title_in_page_header is set to false.
	 */
	function emulsion_article_header() {

		if ( 'list' == emulsion_current_layout_type() ) {

			$thumbnail_url = get_the_post_thumbnail_url();
		} else {

			$thumbnail_url = get_the_post_thumbnail_url( null, 'medium_large' );
		}

		$custom_header = apply_filters( 'emulsion_article_header', 'default' );

		if ( 'default' !== $custom_header ) {

			echo $custom_header;

			return;
		}

		$header_element	 = '<header class="post-header is-layout-constrained classic"';
		$header_element	 .= ! empty( emulsion_element_classes( 'article-header' ) ) ? 'class="' . sanitize_html_class( emulsion_element_classes( 'article-header' ) ) . '" ' : '';
		$header_element	 .= ! empty( emulsion_element_classes( 'article-header' ) ) && ! empty( $thumbnail_url ) ? ' style="' . 'background-image:linear-gradient(var(--thm_header_image_dim),transparent), url(' . esc_url( $thumbnail_url ) . ' );"' : '';
		$header_element	 .= '>';
		$header_element	 = apply_filters( 'emulsion_article_header', $header_element, esc_url( $thumbnail_url ) );

		print( $header_element );
		print( do_blocks( '<!-- wp:post-featured-image /-->' ) );
		print('<div class="post-header-content is-layout-flex">' );
		emulsion_the_post_title();
		emulsion_the_post_meta_on();
		emulsion_the_post_meta_in();
		emulsion_action( 'emulsion_append_post_header' );
		print('</div>' );

		print('</header>' );
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
	function emulsion_meta_description( $length = 160 ) {

		if ( function_exists( 'emulsion_get_supports' ) && false == emulsion_get_supports( 'meta_description' ) ) {

			__return_empty_string();
		}

		if ( is_singular() ) {

			$excerpt = get_the_excerpt();
			$excerpt = str_replace( '[...]', '', $excerpt );
			$excerpt = wp_html_excerpt( $excerpt, $length, '' );

			if ( ! empty( $excerpt ) ) {

				return $excerpt;
			}
		} else {

			$excerpt = term_description();
			$excerpt = wp_html_excerpt( $excerpt, $length, '' );

			if ( ! empty( $excerpt ) ) {

				return $excerpt;
			}
		}

		__return_empty_string();
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

			$result = '<div class="classic-taxsonomy"><div class="taxsonomy">';
		}

		if ( has_tag() && 'inherit' == get_theme_mod( 'emulsion_post_display_tag', emulsion_theme_default_val( 'emulsion_post_display_tag' ) ) ) {

			$tag_list	 = get_the_tag_list( '', '', '' );
			$result		 .= '<div class="taxonomy-post_tag">' . $tag_list . '</div>';
		}
		if ( has_category() && 'inherit' == get_theme_mod( 'emulsion_post_display_category', emulsion_theme_default_val( 'emulsion_post_display_category' ) ) ) {

			$post_id = get_the_ID();

			if ( false === $post_id ) {

				__return_empty_string();
			}

			$post_terms			 = wp_list_pluck( get_the_category(), 'term_id' );
			$default_category	 = (array) sanitize_option( 'default_category', get_option( 'default_category' ) );
			$default_category[]	 = (array) ! empty( get_queried_object_id() ) ? get_queried_object_id() : array();
			$post_terms			 = array_diff( $post_terms, $default_category );

			if ( ! empty( $post_terms ) ) {

				$args = array(
					'include'				 => $post_terms,
					'taxonomy'				 => 'category',
					'echo'					 => false,
					'title_li'				 => '',
					'hierarchical'			 => false,
					'hide_title_if_empty'	 => true,
					'style'					 => 'none',
				);

				$category_list = wp_list_categories( $args );

				$category_list = str_replace( '<br />', '', $category_list );

				$class = 'inherit' == get_theme_mod( 'emulsion_post_display_category', emulsion_theme_default_val( 'emulsion_post_display_category' ) ) ? ' has-category' : '';

				$result .= sprintf( '<div class="taxonomy-category wp-block-post-terms">%1$s</div>', $category_list );
			}
		}

		if ( has_tag() || has_category() ) {

			$result .= '</div></div>';
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

		echo $result;
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

		$class	 = 'posted-on';
		$class	 .= 'inherit' == emulsion_theme_default_val( 'emulsion_post_display_date' ) ? ' has-date' : '';
		$class	 .= 'inherit' == emulsion_theme_default_val( 'emulsion_post_display_author' ) ? ' has-author' : '';

		$text_posted_on	 = esc_html__( 'Posted on', 'emulsion' );
		$text_by		 = esc_html__( 'by', 'emulsion' );
		$author_url		 = get_author_posts_url( $post->post_author );
		$author_name	 = get_the_author_meta( 'display_name', $post->post_author );
		$format_type	 = emulsion_theme_default_val( 'emulsion_post_display_author_format' );
		$author			 = '';

		/**
		 * Author format
		 */
		if ( 'text' == emulsion_theme_default_val( 'emulsion_post_display_author_format' ) ) {

			if ( is_author() ) {

				$author = get_the_author();
			} else {
				// filter: the_author_posts_link
				$author = get_the_author_posts_link();
			}
			if ( empty( $author ) ) {
				//single
				$author = sprintf( '<a href="%1$s" rel="author" class="url fn nickname">%2$s</a>', esc_url( $author_url ), esc_html( $author_name ) );
			}
		}
		if ( 'inline' == $format_type ) {

			$author_id	 = get_the_author_meta( 'ID' );
			$font_size	 = get_theme_mod( 'emulsion_widget_meta_font_size', emulsion_theme_default_val( 'emulsion_widget_meta_font_size' ) );
			$avator_size = (int) $font_size * 1.5;
			$author		 = get_avatar( $author_id, $avator_size );
			$author		 = sprintf( '<a href="%1$s" rel="author" class="url fn nickname">%2$s<span class="screen-reader-text">%3$s</span></a>', esc_url( $author_url ), $author, $author_name );
			$class		 .= ' avatar-inline';
		}
		if ( 'block' == $format_type ) {

			$author_id	 = get_the_author_meta( 'ID' );
			$author		 = get_avatar( $author_id );
			$author		 = sprintf( '<a href="%1$s" rel="author" class="url fn nickname">%2$s<span class="screen-reader-text">%3$s</span></a>', esc_url( $author_url ), $author, $author_name );
			$class		 .= ' avatar-block';
		}

		$emulsion_post_id	 = get_the_ID();
		$comment_link		 = '';

		/**
		 * Comment link
		 */
		if ( false !== $emulsion_post_id && comments_open( $emulsion_post_id ) ) {

			$comment_link = emulsion_comment_link();
		}

		$entry_month_html = emulsion_get_month_link();

		$result = sprintf( $html, $text_posted_on, $entry_month_html, $text_by, $author, $comment_link, $class );

		$result = apply_filters( 'emulsion_get_post_meta_on', $result );

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
		echo $posted_on;
	}

}

if ( ! function_exists( 'emulsion_comment_link' ) ) {

	/**
	 * Get comment link elements
	 * @return type
	 */
	function emulsion_comment_link() {

		$comment_count	 = absint( get_comments_number() );
		$html			 = '<a href="%1$s" class="comment-link">%2$s</a>';
		$text			 = _n( 'Comment', 'Comments', $comment_count, 'emulsion' );

		if ( $comment_count > 0 ) {

			$comment		 = sprintf( '<span class="emulsion-comment-count counter badge circle">%1$s</span>', $comment_count );
			$comment_link	 = sprintf( $html, get_comments_link(), $text ) . $comment;
		} else {

			$comment_link = sprintf( $html, get_comments_link(), $text );
		}

		$comment_link = apply_filters( 'emulsion_comment_link', $comment_link );

		return wp_kses( $comment_link, EMULSION_POST_META_DATA_ALLOWED_ELEMENTS );
	}

}

if ( ! function_exists( 'emulsion_date_format' ) ) {

	/**
	 * return date format
	 * @return string
	 */
	function emulsion_date_format() {

		return sprintf( '%1$s %2$s', get_option( 'date_format' ), get_option( 'time_format' ) );
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

		$entry_date_html	 = '<a href="%1$s" rel="%2$s"><%4$s class="entry-date %6$s" %5$s>%3$s</%4$s></a>';
		$emulsion_post_id	 = get_the_ID();
		$published_class	 = 'updated';
		$archive_year		 = get_the_time( 'Y' );
		$archive_month		 = get_the_time( 'm' );
		$month_link			 = esc_url( get_month_link( $archive_year, $archive_month ) . '#post-' . absint( $emulsion_post_id ) );
		$date_format		 = emulsion_date_format();
		$date_text			 = get_the_date( $date_format );
		$entry_date_html	 = sprintf( $entry_date_html, $month_link, 'date', $date_text, 'time', 'datetime="' . esc_attr( get_the_date( 'c' ) ) . '"', $published_class );
		$entry_date_html	 = apply_filters( 'emulsion_get_month_link', $entry_date_html );

		return wp_kses( $entry_date_html, EMULSION_POST_META_DATA_ALLOWED_ELEMENTS );
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

		if ( is_archive() ) {

			print '<div class="page-title-block is-layout-constrained">';
		}

		if ( is_search() ) {

			$class = 0 == $wp_query->found_posts ? 'search-result-0' : 'search-result';

			printf( '<div class="page-title-block is-layout-constrained %1$s">', $class );

			printf( '<h2 class="%1$s">%2$s</h2>', 'search-title', get_search_query( true ) );
		}

		if ( is_archive() ) {

			if ( is_year() ) {

				the_archive_title( '<h2 class="archive-title year">', '</h2>' );
			} elseif ( is_month() ) {

				the_archive_title( '<h2 class="archive-title month">', '</h2>' );
			} else {

				the_archive_title( '<h2 class="archive-title">', '</h2>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			}
		}

		if ( is_archive() || is_search() ) {

			print '</div>';
		}
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

	function emulsion_have_posts() {

		global $_wp_current_template_content;

		if ( 'fse' == emulsion_get_theme_operation_mode() && false === strstr( emulsion_get_template(), '-php' ) && ! is_null( $_wp_current_template_content ) ) {

			if ( function_exists( 'get_the_block_template_html' ) ) {

				echo get_the_block_template_html();
			}
			return;
		}

		if ( 'fse' == emulsion_get_theme_operation_mode() && false !== strstr( emulsion_get_template(), '-php' ) ) {
			if( is_page() ){

				$has_column =  is_active_sidebar( 'sidebar-3' ) ? 'has-sidebar' : 'no-sidebar';
			} else {

				$has_column =  is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : 'no-sidebar';
			}

			echo '<div class="fse-columns is-layout-flex wp-block-columns classic '. $has_column . '">';
			echo '<div class="page-wrapper layout">';
			echo '<main id="main">';

			if( ! is_singular() ) {

				emulsion_block_template_part( 'query-post' );
			} else {

				is_single() ? emulsion_block_template_part( 'post-content' ): '';

				is_page() ?  emulsion_block_template_part( 'page-content' ): '';
			}

			echo '</main>';
			echo '</div>';

			get_template_part( 'template-parts/widget', 'sidebar' );

			echo '</div>';

			return;

		}
		//var_dump( have_posts(), is_archive(), get_queried_object()->name );
		//Returns the layout settings.
		//		grid, stream, excerpt, full_text, in archives,
		//		post, page in singular

		$template_part = emulsion_get_layout_setting();

		if ( have_posts() ) {

			// Wrap the post with a div element, The class of this element determines the presentation of the theme

			emulsion_layout_control( 'before', $template_part );

			while ( have_posts() ) {

				the_post();

				if ( is_post_type_archive() ) {

					$current_queried_object	 = get_queried_object();
					$custom_post			 = sanitize_file_name( $current_queried_object->name );
					get_template_part( 'template-parts/content', $custom_post );
				} else {

					$post_id = get_the_ID();
					$format	 = get_post_format( $post_id );

					if ( false !== $format ) {

						get_template_part( 'template-parts/content', $format );
					} else {

						get_template_part( 'template-parts/content', $template_part );
					}
				}
			}

			emulsion_layout_control( 'after', $template_part );
		}
	}

}
if ( ! function_exists( 'emulsion_have_comments' ) ) {

	/**
	 * Rendering comments
	 */
	function emulsion_have_comments() {

		if ( is_singular() ) {

			$emulsion_post_id = get_the_ID();

			if ( false !== $emulsion_post_id && comments_open( $emulsion_post_id ) ) {

				comments_template();
			}
		}
	}

}

if ( ! function_exists( 'emulsion_get_layout_setting' ) ) {

	function emulsion_get_layout_setting() {

		//$extend_template_part	 = '';
		$extend_template_part	 = strpos( emulsion_get_css_variables_value( '--wp--custom--color--scheme' ), 'grid' );
		$support_excerpt		 = emulsion_the_theme_supports( 'excerpt' );

		if ( $support_excerpt ) {

			$template_part = 'excerpt';
		} else {
			$template_part = 'full_text';
		}



		if ( false === $extend_template_part ) {

			$template_part = get_post_type();

			if ( 'post' == $template_part ) {

				if ( $support_excerpt && ! is_singular() ) {

					//$template_part = 'excerpt';

					if ( emulsion_home_type() ) {

						$template_part = get_theme_mod( 'emulsion_layout_homepage', emulsion_theme_default_val( 'emulsion_layout_homepage' ) );
					} elseif ( is_date() ) {

						$template_part = get_theme_mod( 'emulsion_layout_date_archives', emulsion_theme_default_val( 'emulsion_layout_date_archives' ) );
					} elseif ( is_category() ) {

						$template_part = get_theme_mod( 'emulsion_layout_category_archives', emulsion_theme_default_val( 'emulsion_layout_category_archives' ) );
					} elseif ( is_tag() ) {

						$template_part = get_theme_mod( 'emulsion_layout_tag_archives', emulsion_theme_default_val( 'emulsion_layout_tag_archives' ) );
					} elseif ( is_author() ) {

						$template_part = get_theme_mod( 'emulsion_layout_author_archives', emulsion_theme_default_val( 'emulsion_layout_author_archives' ) );
					} elseif ( is_search() ) {

						$template_part = get_theme_mod( 'emulsion_layout_search_results', emulsion_theme_default_val( 'emulsion_layout_search_results' ) );

					} else {
						$template_part = 'excerpt';
					}
				} else {
					//$template_part = 'post';
					$template_part = 'full_text';
				}

				// Add exception handling
				if ( emulsion_is_posts_page() ) {

					$template_part = get_theme_mod( 'emulsion_layout_posts_page', emulsion_theme_default_val( 'emulsion_layout_posts_page' ) );
				}
			}
		} else {

			if ( is_singular() ) {

				$template_part = 'full_text';
			} else {

				$template_part = 'grid';
			}
		}

		return $template_part;
	}

}

if ( ! function_exists( 'emulsion_is_custom_content' ) ) {

	/**
	 * Get the required template file
	 *
	 * @param type $name
	 * @param type $template_slug
	 * @return string
	 */
	function emulsion_is_custom_content( $name = null,
			$template_slug = 'template-parts/content.php' ) {

		$name				 = (string) $name;
		$template_path		 = get_theme_file_path( $template_slug );
		$template_part		 = '';
		$conditional_branch	 = emulsion_the_theme_supports( $name );
		$flag				 = false;

		if ( ! file_exists( $template_path ) || empty( $name ) ) {
			return '';
		}
		if ( isset( $conditional_branch[0] ) && is_array( $conditional_branch[0] ) ) {

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
		}
		return $template_part;
	}

}


if ( ! function_exists( 'emulsion_attachment_pagination' ) ) {

	/**
	 * Print attachment image pagination
	 */
	function emulsion_attachment_pagination() {
		?>
		<nav class="navigation attachment-navigation" aria-labelledby="Pagination">
			<div class="nav-links">
				<h2 class="screen-reader-text" tabindex="0" style="top:0"><?php esc_html_e( 'Image Navigation', 'emulsion' ); ?></h2>
				<div class="nav-previous"><?php previous_image_link( 0 ); ?></div>
				<div class="nav-next"><?php next_image_link( 0 ); ?></div>
			</div>
		</nav>
		<?php
	}

}
if ( ! function_exists( 'emulsion_attachment_image' ) ) {

	/**
	 * Print Attachment Image in content-attachment.php template.
	 *
	 *
	 * @param type $post_id
	 * @param type $size
	 * @param type $excerpt
	 * @param string $aria_describedby
	 * @return type
	 */
	function emulsion_attachment_image( $post_id = '', $size = 'full',
			$excerpt = '', $aria_describedby = 'image-description' ) {

		if ( empty( $post_id ) ) {

			return;
		}

		$image	 = get_post_meta( $post_id, 'image', true );
		$image	 = wp_get_attachment_image_src( $image, $size );

		$alt					 = get_post_meta( $post_id, '_wp_attachment_image_alt', true );
		$alt_text				 = '';
		$aria_describedby		 = '';
		$alt_text				 = empty( $alt ) ? '' : esc_attr( $alt );
		$attachment_image_html	 = '<a href="%1$s"><img src="%1$s" width="%2$s" height="%3$s" alt="%4$s" /></a>';

		if ( empty( $image[1] || $image[2] ) ) {
			//@since 1.7.0
			$attachment_image_html = '<a href="%1$s"><img src="%1$s" data-width="%2$s" data-height="%3$s" alt="%4$s" /></a>';
		}
		?>
		<figure class="attachment-image">
			<?php
			printf( $attachment_image_html,
					esc_url( $image[0] ),
					esc_attr( $image[1] ),
					esc_attr( $image[2] ),
					esc_attr( $alt_text )
			);
			?>
			<figcaption><?php echo empty( $excerpt ) ? '' : wp_kses_post( $excerpt ); ?></figcaption>
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

		if ( ! has_nav_menu( $location ) ) {

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
if ( ! function_exists( 'emulsion_header_manager' ) ) {

	function emulsion_header_manager() {

		if ( is_home() ) {
			$template_part = 'header-rich';
		} elseif ( is_single() || is_page() ) {
			$template_part = 'header-singular';
		} else {
			$template_part = 'header';
		}

		emulsion_block_template_part( $template_part );
	}

}
if ( ! function_exists( 'emulsion_sidebar_manager' ) ) {

	/**
	 * Sidebar left or right control
	 * Print the classified div element to inform the position of the sidebar
	 *
	 * @param type $position
	 * @param string $suffix
	 */
	function emulsion_sidebar_manager( $position = '', $suffix = '' ) {
		global $post;

		$post_id = absint( get_the_ID() );

		if ( ! empty( $post_id ) && is_singular() && metadata_exists( 'post', $post_id, 'emulsion_post_sidebar' ) ) {

			if ( 'no_sidebar' == get_post_meta( $post_id, 'emulsion_post_sidebar', true ) ) {

				return;
			}
		}

		$background = get_theme_mod( 'emulsion_sidebar_background', emulsion_theme_default_val( 'emulsion_sidebar_background' ) );

		if ( emulsion_theme_addons_exists() ) {

			$background = false === $background || 'ffffff' === $background ? emulsion_sidebar_background() : $background;
		} else {

			$background = false === $background || 'ffffff' === $background ? emulsion_theme_default_val( 'emulsion_sidebar_background' ) : $background;
		}

		$sidebar_text_color = emulsion_accessible_color( $background );

		$sidebar_color_class = '#333333' == $sidebar_text_color ? 'has-light-sidebar' : 'has-dark-sidebar';

		if ( ( is_page() && is_active_sidebar( 'sidebar-3' ) && emulsion_the_theme_supports( 'sidebar' )) ||
				( is_active_sidebar( 'sidebar-1' ) && emulsion_the_theme_supports( 'sidebar' ) ) ) {

			if ( 'left' !== $position && 'right' !== $position ) {

				$position = get_theme_mod( 'emulsion_sidebar_position', emulsion_theme_default_val( 'emulsion_sidebar_position' ) );
			}

			$position		 = apply_filters( 'emulsion_sidebar_manager', $position );
			$post_sidebar	 = emulsion_the_theme_supports( 'sidebar' );
			$page_sidebar	 = emulsion_the_theme_supports( 'sidebar_page' );

			if ( ! empty( $suffix ) ) {
				$suffix = '-' . sanitize_title( $suffix );
			}

			if ( is_page() && $page_sidebar ) {

				printf( '<div class="is-layout-flex wp-block-columns classic has-column%2$s side-%1$s %3$s">', esc_html( $position ), esc_html( $suffix ), $sidebar_color_class );
			}

			if ( $post_sidebar && ! is_page() ) {

				printf( '<div class="is-layout-flex wp-block-columns classic has-column%2$s side-%1$s %3$s">', esc_html( $position ), esc_html( $suffix ), $sidebar_color_class );
			}
		}
	}

}



function emulsion_action( $hook_name ) {

	if ( true === SHOW_CLASSIC_TEMPLATE_ACTION_HOOKS ) {

		printf( '<p class="is-action emulsion-hook-name">%1$s</p>', $hook_name );
	}

	if ( ! has_action( $hook_name ) ) {

		return;
	}
	printf( '<div class="%1$s %2$s">', esc_attr( str_replace( '_', '-', $hook_name ) ), 'is-action' );

	do_action( $hook_name );

	printf( '</div>' );
}
