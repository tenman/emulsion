<?php
if ( ! function_exists( 'emulsion_get_site_title' ) ) {

	/**
	 * Get site title with html structure
	 * @return html
	 */
	/**
	 * HTML
			<h1 class="site-title" id="site-title">
				<a href="" rel="home" class="site-title-link">
					<span class="site-title-text">Site Title</span>
				</a>
			</h1>
	 * Has Logo
			<h1 class="site-title has-custom-logo" id="site-title">
				<a href="https://www.tenman.info/wp-37/" rel="home" class="site-title-link">
					<span class="custom-logo-wrap"><img width="600" height="60" src="[logo-uri]" class="custom-logo" alt="Site Title" aria-hidden="true"></span>
					<span class="site-title-text">Site Title</span>
				</a>
			</h1>
	 * Has Logo Front Page ( empty alt, add class link-disabled ) WordPress 5.5 relate change
			<h1 class="site-title has-custom-logo" id="site-title">
				<a href="https://www.tenman.info/wp-37/" rel="home" class="site-title-link link-disabled">
					<span class="custom-logo-wrap"><img width="600" height="60" src="[logo-uri]" class="custom-logo" alt="" aria-hidden="true"></span>
					<span class="site-title-text">Site Title</span>
				</a>
			</h1>
	 */

	function emulsion_get_site_title( $blog_id = 0 ) {

		$switched_blog = false;

		if ( is_multisite() && ! empty( $blog_id ) && get_current_blog_id() !== (int) $blog_id ) {
			switch_to_blog( $blog_id );
			$switched_blog = true;
		}

		$logo					 = '';

		$site_title_text_class	 = 'site-title-text';
		$site_title_text_class	 .= ! display_header_text() ? ' screen-reader-text' : '';

		$site_title_link_class	 = 'site-title-link';
		$site_title_link_class	 .= is_front_page() && ! is_paged() ? ' link-disabled' : '';

		$custom_logo_id = absint( get_theme_mod( 'custom_logo' ) );

		$custom_logo_attr = array(
			'class' => 'custom-logo',
			'aria-hidden' => 'true',
			'alt' => '',
		);

		if( ! is_front_page() ){

			$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );

			$custom_logo_attr['alt'] =  empty( $image_alt ) ? get_bloginfo( 'name', 'display' ) : $image_alt;
		}

		$custom_logo_attr	 = apply_filters( 'get_custom_logo_image_attributes', $custom_logo_attr , $custom_logo_id, $blog_id );
		$has_custom_logo = '';
		if ( has_custom_logo() ) {

			$logo = sprintf( '<span class="custom-logo-wrap"><img width="%1$d" height="%2$d" src="%3$s" class="%4$s" alt="%5$s" aria-hidden="%6$s"></span>',
					absint( get_theme_support( 'custom-logo', 'width' ) ),
					absint( get_theme_support( 'custom-logo', 'height' ) ),
					esc_url( wp_get_attachment_image_src( $custom_logo_id, 'full' )[0] ),
					esc_attr( $custom_logo_attr['class'] ),
					esc_attr( $custom_logo_attr['alt'] ),
					esc_attr( $custom_logo_attr['aria-hidden'] )
			);

			$has_custom_logo = 'has-custom-logo';
		// removed @since 2.4.6
		//	$site_title_text_class	 .= false === strstr( $site_title_text_class, 'screen-reader-text' ) ? ' screen-reader-text' : '';
		}

		$title_format = '<%1$s class="%5$s" id="site-title">
							<a href="%2$s" rel="%3$s" class="%8$s">%6$s
								<span class="%7$s">%4$s</span>
							</a>
						</%1$s>';

		$html = sprintf( $title_format,
				'h1',
				esc_url( home_url( '/' ) ),
				"home",
				get_bloginfo( 'name', 'display' ),
				apply_filters( 'emulsion_get_site_title_class', 'site-title '. $has_custom_logo ),
				$logo,
				$site_title_text_class,
				$site_title_link_class
		);

		if ( $switched_blog ) {

			restore_current_blog();
		}

		return $html;
	}

}
if ( ! function_exists( 'emulsion_the_site_title' ) ) {

	/**
	 * Print site title
	 * @see emulsion_get_site_title()
	 * filter: emulsion_the_site_title
	 */

	function emulsion_the_site_title( $blog_id = 0 ) {

		$title = apply_filters( "emulsion_the_site_title", emulsion_get_site_title( $blog_id ) );

		echo $title;
	}
}

if ( ! function_exists( 'emulsion_site_text_markup' ) ) {

	/**
	 *
	 * HTML
			<div class="header-text">
				<h1 class="site-title" id="site-title">
					<a href="https://www.tenman.info/wp-37/" rel="home" class="site-title-link">
						<span class="custom-logo-wrap">
							<img width="600" height="60" src="custom_logo.png" class="custom-logo" alt="Site Title">
						</span>
						<span class="site-title-text">Site Title</span>
					</a>
				</h1>
				<p class="site-description">Site description</p>
			</div>
	 */

	function emulsion_site_text_markup() {

		$site_description_class		 = 'site-description';
	//	$site_description_class		 .= ! display_header_text() ? ' screen-reader-text' : '';
		$site_title					 = emulsion_get_site_title();
		$site_description			 = get_bloginfo( 'description', 'display' );
		$html						 = '<div class="header-text">%1$s<p class="%3$s">%2$s</p></div>';
		$markup						 = sprintf( $html, $site_title, $site_description, $site_description_class );
		$header_text				 = get_theme_mod( 'emulsion_header_html', emulsion_theme_default_val( 'emulsion_header_html' ) );
		$header_layout_default_val	 = emulsion_theme_default_val( 'emulsion_header_layout' );

		if ( 'self' == get_theme_mod( 'emulsion_header_layout', $header_layout_default_val ) && ! empty( $header_text ) ) {
			/* user html header-self.php */
			$header_text = apply_filters( 'emulsion_site_text_markup_self', $header_text, $markup, $site_title, $site_description );

			echo $header_text;
		} elseif ( 'custom' == get_theme_mod( 'emulsion_header_layout', $header_layout_default_val ) || 'simple' == get_theme_mod( 'emulsion_header_layout', $header_layout_default_val ) ) {
			/* template part file header-custom.php or header.php */

			$markup = apply_filters( 'emulsion_site_text_markup', $markup, $site_title, $site_description );

			echo $markup;
		}
	}

}
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

	function emulsion_get_post_title( $with_thumbnail = true,	$size = 'large' ) {

		global $post;


		$html				 = '';
		$post_id			 = get_the_ID();
		$entry_title_status	 = get_theme_mod( 'emulsion_title_in_header', emulsion_theme_default_val( 'emulsion_title_in_header' ) );
		$layout_type		 = emulsion_current_layout_type();
		$attr = '';

		switch ( $layout_type ) {
			case 'grid':
				$data_rows	 = 2;
				break;
			case 'list':
				$data_rows	 = 8;
				break;
			case 'stream':
				$data_rows	 = 2;
				break;
			default:
				$data_rows	 = 4;
		}

		if ( 'yes' == $entry_title_status ) {

			/**
			 * When the title is displayed in the site header,
			 * the display area is limited. For exceptionally long titles,
			 * limit the font size and the number of lines to display the full title as much as possible.
			 */

			$insert_start_tag	 = '<span class="trancate-heading" data-rows="'. $data_rows. '">';
			$insert_end_tag		 = '</span>';

		} elseif ('grid' == $layout_type || 'stream'  == $layout_type ) {

			$insert_start_tag	 = '<span class="trancate-heading" data-rows="'. $data_rows. '">';
			$insert_end_tag		 = '</span>';
		} else {

			$insert_start_tag	 = '';
			$insert_end_tag		 = '';
		}

		if ( is_singular() ) {

			return the_title( '<h2 class="entry-title">'.$insert_start_tag, $insert_end_tag.'</h2>', false );

		} else {

			if ( metadata_exists( 'post', $post_id, 'emulsion_post_theme_style_script' ) ) {

				$attr = 'no_style' == get_post_meta( $post_id , 'emulsion_post_theme_style_script', true ) ? 'data-no-instant': '';
			}

			if ( has_post_thumbnail() && true == $with_thumbnail && false !== $post_id && ! post_password_required( $post_id ) ) {

				$html .= '<h2 class="entry-title"><a href="%1$s" %3$s>'. $insert_start_tag.'%2$s'. $insert_end_tag.'</a></h2>';
			} else {

				$html = '<h2 class="entry-title"><a href="%1$s" %3$s>'. $insert_start_tag.'%2$s'. $insert_end_tag.'</a></h2>';
			}

			return sprintf( $html, esc_url( get_permalink() ), the_title( '', '', false ), $attr );
		}
	}

}
if ( ! function_exists( 'emulsion_the_post_title' ) ) {

	/**
	 * Print post title
	 * @see emulsion_get_post_title()
	 * filter: emulsion_the_post_title
	 */

	function emulsion_the_post_title( $with_thumbnail = true,	$size = 'large' ) {

		$title = apply_filters( 'emulsion_the_post_title', emulsion_get_post_title( $with_thumbnail, $size ) );

		echo $title;
	}

}

if ( ! function_exists( 'emulsion_page_header_title' ) ) {
	/**
	 * Print title block in header
	 *
	 * Entry title, Archive title, Search results
	 * @global type $post
	 *
	 * HTML
	 *
			<div class="entry-text emulsion_page_header_title">
				<div>
					<a class="emulsion-scroll" href="#post-1">
						<h2 class="entry-title">
							<span class="trancate-heading" data-rows="8">gallery</span>
						</h2>
					</a>
					<div class="posted-on">
						<span class="meta-prep meta-prep-author">
							<span class="posted-on-string screen-reader-text">Posted on</span> </span>
							<a href="" rel="date">
								<time class="entry-date updated" datetime="2019-10-31T18:33:14+09:00">formatted date</time>
							</a> <span class="meta-sep">
							<span class="posted-by-string screen-reader-text">by</span>
						</span>
						<span class="author vcard">
							<a href="" rel="author" class="url fn nickname">tenman</a>
						</span>
					</div>
					<div class="entry-meta taxonomy">
						<ul class="post-category horizontal-list-group ">
							<li class="cat-item cat-item-1">
								<a href="" title="Post Title">uncategorized</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
	 *
	 */
	function emulsion_page_header_title() {
		global $post;

		$enable	 = emulsion_the_theme_supports( 'title_in_page_header' );
		$post_id = get_the_ID();

		if( false === $post_id ){

			__return_empty_string();
		}

		$custom_header = apply_filters( 'emulsion_page_header_title', 'default' );

		if ( 'default' !== $custom_header ) {

			echo $custom_header;

			return;
		}

		if ( $enable ) {

			if ( is_singular() && ! is_front_page() ) {

				echo '<div class="entry-text"><div>';
				echo '<a class="emulsion-scroll" href="#post-' . absint( $post_id ) . '">';
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

		$header_element	 = '<header ';
		$header_element	 .= ! empty( emulsion_element_classes( 'article-header' ) ) ? 'class="' . sanitize_html_class( emulsion_element_classes( 'article-header' ) ) . '" ' : '';
		$header_element	 .= ! empty( emulsion_element_classes( 'article-header' ) ) && ! empty( $thumbnail_url ) ? ' style="' . 'background-image:linear-gradient(var(--thm_header_image_dim),transparent), url(' . esc_url( $thumbnail_url ) . ' );"' : '';
		$header_element	 .= '>';
		$header_element	 = apply_filters( 'emulsion_article_header', $header_element, esc_url( $thumbnail_url ) );

		print( $header_element );

		emulsion_the_post_title();
		emulsion_the_post_meta_on();
		emulsion_the_post_meta_in();

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
	function emulsion_meta_description() {

		if( function_exists('emulsion_get_supports') && false == emulsion_get_supports( 'meta_description' ) ) {

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

		if ( has_tag() && 'inherit' == get_theme_mod( 'emulsion_post_display_tag',  emulsion_theme_default_val( 'emulsion_post_display_tag' ) ) ) {

			$class		 = 'inherit' == get_theme_mod( 'emulsion_post_display_tag',  emulsion_theme_default_val( 'emulsion_post_display_tag' ) ) ? ' has-tag' : '';
			$tag_list	 = get_the_tag_list( '<ul class="post-tag horizontal-list-group' . $class . '"><li>', '</li><li>', '</li></ul>' );
			$result		 .= $tag_list;


		}
		if ( has_category() && 'inherit' == get_theme_mod( 'emulsion_post_display_category', emulsion_theme_default_val( 'emulsion_post_display_category' ) ) ) {

			$post_id = get_the_ID();

			if( false === $post_id ) {

				__return_empty_string();
			}

			$post_terms = wp_get_object_terms( get_the_ID(), 'category', array( 'fields' => 'ids' ) );

			if ( ! empty( $post_terms ) ) {

				$args = array(
					'include'		 => $post_terms,
					'taxonomy'		 => 'category',
					'echo'			 => false,
					'title_li'		 => '',
					'hierarchical'	 => false,
					'hide_title_if_empty' => true,
				);

				$category_list	 = wp_list_categories( $args );

				$class = 'inherit' == get_theme_mod( 'emulsion_post_display_category', emulsion_theme_default_val( 'emulsion_post_display_category' ) ) ? ' has-category' : '';

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

		/**
		 * Author format
		 */
		if( 'text' == emulsion_theme_default_val( 'emulsion_post_display_author_format' ) ) {

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
		if( 'inline' == $format_type ) {

			$author_id	 = get_the_author_meta( 'ID' );
			$font_size	 = get_theme_mod( 'emulsion_widget_meta_font_size', emulsion_theme_default_val( 'emulsion_widget_meta_font_size' ) );
			$avator_size = (int) $font_size * 1.5;
			$author		 = get_avatar( $author_id, $avator_size );
			$author		 = sprintf( '<a href="%1$s" rel="author" class="url fn nickname">%2$s<span class="screen-reader-text">%3$s</span></a>', esc_url( $author_url ), $author, $author_name  );
			$class		 .= ' avatar-inline';
		}
		if( 'block' == $format_type ) {

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

		$entry_month_html =  emulsion_get_month_link();

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
	function emulsion_the_post_meta_on( ) {

		if ( post_password_required() ) {

			return;
		}

		$posted_on = apply_filters('emulsion_the_post_meta_on', emulsion_get_post_meta_on() );
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

		return $comment_link;
	}

}

if ( ! function_exists( 'emulsion_date_format' ) ) {

	/**
	 * return date format
	 * @return string
	 */
	function emulsion_date_format() {

		//return sanitize_option( 'date_format', get_option( 'date_format' ) ) . ' ' . sanitize_option( 'time_format', get_option( 'time_format' ) );
		return sprintf('%1$s %2$s', get_option( 'date_format' ) , get_option( 'time_format' ) );
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

		return apply_filters( 'emulsion_get_month_link', $entry_date_html );
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

			print '<div class="page-title-block">';
		}

		if( is_search() ){

			$class =  0 == $wp_query->found_posts ? 'search-result-0': 'search-result';

			printf('<div class="page-title-block %1$s">', $class);

			printf( '<h2 class="%1$s">%2$s</h2>','search-title', get_search_query( true ) );

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

		global  $_wp_current_template_content;

		if( emulsion_do_fse() && 'theme' !== get_theme_mod('emulsion_editor_support') && ! is_null( $_wp_current_template_content ) ) {

			if( function_exists('get_the_block_template_html') ) {

				echo get_the_block_template_html();
			} else {

				function_exists('gutenberg_render_the_template') ? gutenberg_render_the_template() : '' ;
			}
			return;
		}

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

					if(  false !== $format) {

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

		if( is_singular() ) {

			$emulsion_post_id = get_the_ID();

			if ( false !== $emulsion_post_id && comments_open( $emulsion_post_id ) ) {

				comments_template();
			}
		}
	}
}

if ( ! function_exists( 'emulsion_get_layout_setting' ) ) {

	function emulsion_get_layout_setting() {

		$extend_template_part	 = emulsion_is_custom_content( 'stream' );
		$support_excerpt		 = emulsion_the_theme_supports( 'excerpt' );

		if ( empty( $extend_template_part ) ) {

			$extend_template_part = emulsion_is_custom_content( 'grid' );
		}

		if ( is_customize_preview() ) {

			$extend_template_part = emulsion_customizer_have_posts_class_helper();
		}

		if ( empty( $extend_template_part ) || ! is_string( $extend_template_part ) ) {

			$template_part = get_post_type();

			if ( 'post' == $template_part ) {

				if ( $support_excerpt && ! is_singular() ) {

					//$template_part = 'excerpt';

					if( emulsion_home_type() ) {

						$template_part = get_theme_mod( 'emulsion_layout_homepage', emulsion_theme_default_val('emulsion_layout_homepage') );
					} elseif( is_date() ) {

						$template_part = get_theme_mod( 'emulsion_layout_date_archives', emulsion_theme_default_val('emulsion_layout_date_archives') );
					} elseif( is_category() ) {

						$template_part = get_theme_mod( 'emulsion_layout_category_archives', emulsion_theme_default_val('emulsion_layout_category_archives') );
					} elseif( is_tag() ) {

						$template_part = get_theme_mod( 'emulsion_layout_tag_archives', emulsion_theme_default_val('emulsion_layout_tag_archives') );
					} elseif( is_author() ) {

						$template_part = get_theme_mod( 'emulsion_layout_author_archives', emulsion_theme_default_val('emulsion_layout_author_archives') );
					} elseif( is_search() ) {

						$template_part = get_theme_mod( 'emulsion_layout_search_results', emulsion_theme_default_val('emulsion_layout_search_results') );


					} else {
						$template_part = 'excerpt';
					}

				} else {

					$template_part = 'post';
				}

				// Add exception handling
				if ( emulsion_is_posts_page() ) {

					$template_part = get_theme_mod( 'emulsion_layout_posts_page', emulsion_theme_default_val( 'emulsion_layout_posts_page' ) );
				}
			}
		} else {

			$template_part = $extend_template_part;
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
	function emulsion_is_custom_content( $name = null, $template_slug = 'template-parts/content.php' ) {

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
			$attachment_image_html	 = '<a href="%1$s"><img src="%1$s" width="%2$s" height="%3$s" alt="%4$s" /></a>';

			if( empty($image[1] || $image[2])){
				//@since 1.7.0
				$attachment_image_html	 = '<a href="%1$s"><img src="%1$s" data-width="%2$s" data-height="%3$s" alt="%4$s" /></a>';
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

		if ( is_singular() && metadata_exists( 'post', $post_id, 'emulsion_post_sidebar' ) ) {

			if( 'no_sidebar' == get_post_meta( $post_id, 'emulsion_post_sidebar', true ) ) {

				return;
			}
		}

		$background = get_theme_mod( 'emulsion_sidebar_background', emulsion_theme_default_val( 'emulsion_sidebar_background' ) );



		if ( emulsion_theme_addons_exists() ) {

			$background = false === $background || 'ffffff' === $background ? emulsion_sidebar_background() : $background;
		} else {

			//$background = get_theme_mod( 'emulsion_sidebar_background', emulsion_theme_default_val( 'emulsion_sidebar_background' ) );

			$background = false === $background || 'ffffff' === $background ? emulsion_theme_default_val( 'emulsion_sidebar_background') : $background;
		}

		$sidebar_text_color		 = emulsion_accessible_color( $background );

		$sidebar_color_class	 = '#333333' == $sidebar_text_color ? 'has-light-sidebar' : 'has-dark-sidebar';

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

				printf( '<div class="layout layout-block has-column%2$s side-%1$s %3$s">', esc_html( $position ), esc_html( $suffix ), $sidebar_color_class );
			}

			if ( $post_sidebar && ! is_page() ) {

				printf( '<div class="layout layout-block has-column%2$s side-%1$s %3$s">', esc_html( $position ), esc_html( $suffix ), $sidebar_color_class );
			}
		}
	}

}
if ( ! function_exists( 'emulsion_footer_text' ) ) {

	/**
	 * Print footer text
	 * filter:
	 * emulsion_prepend_footer_address add something footer text before
	 * emulsion_append_footer_address add something footer text after
	 * emulsion_footer_text costomize all footer text
	 *
	 */
	function emulsion_footer_text() {

		$emulsion_current_data = wp_get_theme();

		$theme_name			 = $emulsion_current_data->get( 'Name' );
		$theme_uri			 = esc_url( apply_filters( 'emulsion_theme_url', $emulsion_current_data->get( 'ThemeURI' ) ) );
		$site_title			 = get_bloginfo( 'name', 'display' );
		$home_url			 = home_url();
		$current_year		 = date( 'Y' );
		$privacy_policy_link = '';
		$parent_name		 = '';

		if ( is_child_theme() ) {

			$emulsion_parent_data	 = wp_get_theme( get_template() );
			$parent_name			 = $emulsion_parent_data->get( 'Name' );
			/* translators: 1: parent theme name */
			$parent_name			 = sprintf( esc_html_x('Theme %1$s', 'parent theme name', 'emulsion'),  $parent_name );
			$theme_name				 = esc_html__( 'Child theme ', 'emulsion' ) .
										' '.
										esc_html( ucwords( $theme_name ) ) .
										' ' .
										esc_html__( 'of', 'emulsion' );
		} else {
			/* translators: 1: Theme name */
			$theme_name = sprintf( esc_html_x('Theme %1$s', 'Theme name', 'emulsion'),  $theme_name );
		}

		/**
		 * Privacy Policy
		 */
		$emulsion_wp_page_for_privacy_policy = get_option( 'wp_page_for_privacy_policy' );

		if ( ! empty( $emulsion_wp_page_for_privacy_policy ) && function_exists( 'get_the_privacy_policy_link' ) ) {

			$privacy_policy_link = get_the_privacy_policy_link( '&nbsp;<span class="privacy-policy">', '</span>' );
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

		$customizer_footer_credit = get_theme_mod( 'emulsion_footer_credit', emulsion_theme_default_val( 'emulsion_footer_credit' ) );

		if ( ! empty( $customizer_footer_credit ) ) {

			$footer_text = str_replace( '%current_year%', $current_year, $customizer_footer_credit );
		}

		$address_html	 = apply_filters( 'emulsion_prepend_footer_address', '' );
		$address_html	 .= $footer_text;
		$address_html	 .= apply_filters( 'emulsion_append_footer_address', '' );

		$address_html = apply_filters( 'emulsion_footer_text', $address_html );

		echo $address_html;
	}

}

if ( ! function_exists( 'emulsion_header_text_color_fallback' ) ) {

	/**
	 * get_header_text_color is return empty string if not set.
	 * Returns the appropriate fallback color
	 *
	 * hex rgb hsl allow
	 *
	 * @param type $fallback_color
	 * @param type $has_image_fallback
	 * @return type text color value
	 */

	function emulsion_header_text_color_fallback( $fallback_color = '#333333', $has_image_fallback = '#ffffff' ) {

		// global header text color fallback

		$header_text_color = ! empty( get_header_textcolor() )  ? sprintf( '#%1$s', get_header_textcolor() ) : $fallback_color;

		// home header text color fallback
		if ( emulsion_home_type() && has_header_image() && ( empty( get_header_textcolor() ) || ! display_header_text() ) )  {

			$header_text_color = $has_image_fallback;
		}
		// singular header text color fallback
		if ( is_singular() && has_post_thumbnail() && ( empty( get_header_textcolor() ) || ! display_header_text() ) ) {

			$header_text_color = $has_image_fallback;
		}

		return  $header_text_color;
	}

}

function emulsion_action( $hook_name ) {

	if( ! has_action( $hook_name ) ) {

		return;
	}
	printf('<div class="%1$s">', esc_attr( str_replace('_','-', $hook_name) ) );

	do_action( $hook_name );

	printf('</div>');
}


function emulsion_header_manager() {

	if ( 'html' !== get_theme_mod( 'emulsion_header_template',  emulsion_theme_default_val( 'emulsion_header_template','default' ) ) ) {

		$emulsion_header_type = is_page() ? 'page_header' : 'header';
		emulsion_metabox_display_control( $emulsion_header_type ) ? get_template_part( 'template-parts/header', emulsion_header_layout() ) : '';

	} else {

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
