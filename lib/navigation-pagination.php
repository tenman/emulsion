<?php

if ( !function_exists( 'emulsion_year_link_element' ) ) {

	function emulsion_year_link_element( $year, $class = "", $screen_reader_text = "" ) {


		$html				 = '<div class="%2$s"><a href="%1$s"><span class="screen-reader-text">%3$s</span>%4$s</a></div>';
		$year				 = absint( $year );
		$class				 = sanitize_html_class( 'year-' . $year );
		$link				 = esc_url( get_year_link( $year ) );
		$screen_reader_text	 = esc_html__( 'Link to Year Archives ', 'emulsion' );

		$class	 = 'oldest-year nav-previous';
		$link	 = esc_url( get_year_link( $first ) );
		$oldest	 = sprintf( $html, $link, $class, $screen_reader_text, $first );
	}

}
if ( !function_exists( 'emulsion_archive_year_navigation' ) ) {

	/**
	 *
	 * @param type $echo
	 * @return string
	 * @since 1.335
	 */
	function emulsion_archive_year_navigation( $echo = true ) {

		if ( !is_date() ) {
			return;
		}

		$html			 = '<div class="%2$s"><a href="%1$s"><span class="screen-reader-text">%3$s</span>%4$s</a></div>';
		$separator		 = '<div class="%1$s">%2$s</div>';
		$result			 = '<div class="archive-year-links nav-links">';
		$year_current	 = absint( get_query_var( 'year' ) );	
		$count_posts	 = intval( wp_count_posts()->publish );	

		$published_posts_count = $count_posts;
		$year_list		 = get_posts( array( 'post_status' => 'publish', 'posts_per_page' => $published_posts_count, 'order' => 'ASC' ) );

		foreach ( $year_list as $list ) {

			$years[] = substr( $list->post_date, 0, 4 );
		}
		$years = array_values( array_unique( $years, SORT_NUMERIC ) );

		$before	 = '';
		$after	 = '';

		$last	 = end( $years );
		$first	 = reset( $years );

		$year				 = absint( $first );
		$class				 = sanitize_html_class( 'year-' . $first );
		$link				 = esc_url( get_year_link( $first ) );
		/* translators: 1: year name 4 digit number */
		$screen_reader_text	 = sprintf( esc_html__( 'Link to Year Archives %1$s', 'emulsion' ), $first );

		$class	 .= ' oldest-year nav-previous';
		$link	 = esc_url( get_year_link( $first ) );
		$oldest	 = sprintf( $html, $link, $class, $screen_reader_text, $first );

		$year				 = absint( $last );
		$class				 = sanitize_html_class( 'year-' . $last );
		$link				 = esc_url( get_year_link( $last ) );
		/* translators: 1: year name 4 digit number */
		$screen_reader_text	 = sprintf( esc_html__( 'Link to Year Archives %1$s', 'emulsion' ), $last );

		$class	 .= ' newest-year nav-previous';
		$link	 = esc_url( get_year_link( $last ) );
		$newest	 = sprintf( $html, $link, $class, $screen_reader_text, $last );

		$class		 = 'separator dots';
		$separator	 = sprintf( $separator, $class, esc_html__( '...', 'emulsion' ) );


		$not_set_before = false;

		foreach ( $years as $key => $year ) {

			$year				 = absint( $year );
			$class				 = sanitize_html_class( 'year-' . $year );
			$link				 = esc_url( get_year_link( $year ) );
			$screen_reader_text	 = esc_html__( 'Link to Year Archives ', 'emulsion' );

			if ( function_exists( 'emulsion_year_name_filter' ) ) {

				$year_text = emulsion_year_name_filter( $year );
			} else {

				$year_text = $year;
			}

			if ( $year_current == $year ) {
				if ( $first !== $year ) {
					$not_set_before = true;
				}
				if ( $last !== $year ) {

					$break_point = $key + 1;
				}

				$class = ' current-year current';

				$html_current = '<div class="%1$s"><span class="screen-reader-text">%2$s</span>%3$s</div>';

				$current = sprintf( $html_current, $class, $screen_reader_text, $year_text );
			}


			if ( isset( $break_point ) && $key == $break_point ) {
				$class	 = ' next-year nav-next';
				$after	 = sprintf( $html, $link, $class, $screen_reader_text, $year_text );

				if ( intval( $last ) > intval( $year ) ) {

					$after .= $separator . $newest;
				}
				break;
			}

			if ( true !== $not_set_before ) {
				$class	 = ' prev-year nav-previous';
				$before	 = $oldest . $separator . sprintf( $html, $link, $class, $screen_reader_text, $year_text );
			}
		}
		$result	 .= $before . $current . $after;
		$result	 .= '</div>';

		wp_reset_postdata();
		
		// check lost element			
		$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
		true === WP_DEBUG ? emulsion_elements_assert_equal( $result, wp_kses_post( $result ), $emulsion_place ) : '';

		if ( true !== $echo ) {

			return wp_kses_post( $result );
		} else {

			echo wp_kses_post( $result );
		}
	}
}
if ( !function_exists( 'emulsion_monthly_archive_prev_next_navigation' ) ) {

	/**
	 * Note:Theme sniffer1.2.4 plugin output SQL error
	 * I can't find a suitable function for this purpose, so I'm writing a code based on the core implementation.
	 * 
	 * This function is a pluggable function. You can modify the behavior by creating a function with the same name at the beginning of functions.php.
	 */
	
	function emulsion_monthly_archive_prev_next_navigation( $echo = true, $show_year = false ) {

		global $wpdb, $wp_query, $wp_locale;

		if ( !is_singular() && !is_404() ) {

			if ( !isset( $wp_query->posts[ 0 ]->post_date ) || !isset( $wp_query->posts[ 0 ]->post_date ) ) {
				return;
			}

			$post_type	 = get_post_type( get_the_ID() );
			$post_query	 = 'post';
			if ( is_post_type_archive( $post_type ) ) {

				$post_type_object			 = get_post_type_object( $post_type );
				$post_type_title			 = esc_html( apply_filters( 'emulsion_post_type_day_archive_title', $post_type_object->label ) );
				$post_type_title_separator	 = esc_html( apply_filters( 'emulsion_post_type_day_archive_title_separator', ' : ' ) );
				$post_query					 = $post_type;
			}


			$thisyear		 = mysql2date( 'Y', $wp_query->posts[ 0 ]->post_date );
			$thismonth		 = mysql2date( 'm', $wp_query->posts[ 0 ]->post_date );
			$unixmonth		 = mktime( 0, 0, 0, $thismonth, 1, $thisyear );
			$last_day		 = date( 't', $unixmonth );
			$calendar_output = '';
			/**
			 * This code is the get_calendar () function and is based on the code that detects the previous month and the next month.
			 */
			$previous	 = $wpdb->get_row( "SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
FROM $wpdb->posts
WHERE post_date < '$thisyear-$thismonth-01'
AND post_type = '$post_query' AND post_status = 'publish'
ORDER BY post_date DESC
LIMIT 1" );
			$next		 = $wpdb->get_row( "SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
FROM $wpdb->posts
WHERE post_date > '$thisyear-$thismonth-{$last_day} 23:59:59'
AND post_type = '$post_query' AND post_status = 'publish'
ORDER BY post_date ASC
LIMIT 1" );

			$html = '<div class="%4$s"><a href="%1$s" class="%3$s">%2$s</a></div>';

			if ( $previous ) {

				$previous_label = $wp_locale->get_month( $previous->month );

				$calendar_output = sprintf( $html, get_month_link( $previous->year, $previous->month ),
				/* translators: 1: previous month name */ 
				sprintf( esc_html__( '&#171; %1$s ', 'emulsion' ), $previous_label ), '', "nav-previous" );
			}
			$calendar_output .= "\t";

			if ( true == $show_year ) {

				$year_label		 = apply_filters( 'emulsion_archive_year_label', esc_html( $thisyear ), mktime( 0, 0, 0, $thismonth, 1, $thisyear ) );
				$calendar_output .= '<span class="year">' . $year_label . '</span>';
			}

			if ( $next ) {
				
				$next_label = $wp_locale->get_month( $next->month );

				$calendar_output .= sprintf( $html, get_month_link( $next->year, $next->month ),
				/* translators: 1: next month name */ 
				sprintf( esc_html__( ' %1$s &#187;', 'emulsion' ), $next_label ), '', "nav-next" );
			}
			$html			 = '<div class="%1$s">%2$s<br class="clear" /></div>';
			$calendar_output = sprintf( $html, 'emulsion-monthly-archive-prev-next-navigation nav-links', $calendar_output );
			
			// check lost element			
			$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
			true === WP_DEBUG ? emulsion_elements_assert_equal( $calendar_output, wp_kses_post( $calendar_output ), $emulsion_place ) : '';

			if ( true == $echo ) {

				echo wp_kses_post( apply_filters( 'emulsion_monthly_archive_prev_next_navigation', $calendar_output ) );
			}
			if ( false == $echo ) {

				return wp_kses_post( apply_filters( 'emulsion_monthly_archive_prev_next_navigation', $calendar_output ) );
			}
		}
	}
}