<?php

function emulsion_search_from_terms( $target_terms = array( 'category', 'post_tag' ), $echo = true ) {

	$theme_support = emulsion_get_supports( 'search_keyword_highlight' );

	if ( true !== $theme_support ) {
		return;
	}

	$search_query	 = mb_strtolower( get_search_query() );
	$results		 = '';

	foreach ( $target_terms as $target_term ) {

		$result	 = '';
		$args	 = apply_filters( 'emulsion_search_from_terms_args', array(), $target_term );
		$terms	 = get_terms( $target_term, $args );

		foreach ( $terms as $term ) {

			$id			 = $term->term_id;
			$term_link	 = get_category_link( $id );
			$term_name	 = mb_strtolower( $term->name );

			if ( preg_match( '!' . $search_query . '!', $term_name ) ) {

				$result .= sprintf( '<li><a href="%2$s" class="%3$s"><mark>%1$s</mark></a></li>', esc_html( $term->name ), esc_url( $term_link ), $target_term );
			}
			if ( preg_match( '!' . $term_name . '!', $search_query ) ) {

				$result .= sprintf( '<li><a href="%2$s" class="%3$s"><mark>%1$s</mark></a></li>', esc_html( $term->name ), esc_url( $term_link ), $target_term );
			}
		}

		$results .= $result;
	}
	// check lost element			
	$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
	true === WP_DEBUG ? emulsion_elements_assert_equal( $results, wp_kses_post( $results ), $emulsion_place ) : '';
	
	if ( true == $echo && ! empty( $results ) ) {
		printf( '<ul class="search-relate-terms horizontal-list-group">%1$s</ul>', wp_kses_post( $results ) );
	}
	if ( false == $echo && ! empty( $results ) ) {
		return sprintf( '<ul class="search-relate-terms horizontal-list-group">%1$s</ul>', wp_kses_post( $results ) );
	}
}

function emulsion_keyword_with_mark_elements( $text ) {

	$theme_support = emulsion_get_supports( 'search_keyword_highlight' );

	if ( true !== $theme_support ) {
		return $text;
	}
	/**
	 * The word search core search function will hit even if html class name,
	 * part of short code name etc. are searched in the contribution body.
	 * In such a case, they will not be highlighted with the mark element.
	 */
	if ( ! is_search() || ! is_main_query() ) {
		return $text;
	}

	$search_query					 = get_search_query();
	$text							 = strip_tags( $text );
	$style_rules_for_searched_text	 = 'color:#000;padding:0 .2rem;';

	$hilight_rules = array(
		array( mb_strtolower( $search_query ) => $style_rules_for_searched_text ),
		array( mb_strtoupper( $search_query ) => $style_rules_for_searched_text ),
		array( mb_convert_case( $search_query, MB_CASE_TITLE, "UTF-8" ) => $style_rules_for_searched_text ),
		array( ucfirst( $search_query ) => $style_rules_for_searched_text ),
		array( ucwords( $search_query ) => $style_rules_for_searched_text ),
		array( $search_query => $style_rules_for_searched_text ),
	);

	$checksum		 = crc32( $text );
	$class_name		 = trim( sprintf( "search-result-%u\n", $checksum ) );
	$wrapper		 = '<mark style="%1$s">%2$s</mark>';
	$block_wrapper	 = '<span class="%1$s">%2$s</span>';

	foreach ( $hilight_rules as $value ) {

		$name			 = key( $value );
		$replace_value	 = sprintf( $wrapper, esc_attr( $value[$name] ), $name );
		$text			 = str_replace( $name, $replace_value, $text, $count );

		if ( $count > 0 ) {
			break;
		}
	}
	$result = '';
	preg_match_all( '!(.*)(<[^>]+>[^<]*</mark>)(.*)!', $text, $matches, PREG_SET_ORDER );

	if ( isset( $matches ) && ! empty( $matches ) ) {
		foreach ( $matches as $m ) {
			$result .= sprintf( $block_wrapper, $class_name, '<p>...' . $m[0] . '...</p>' );
		}
		$text = $result;
	} else {
		$text = '';
	}

	return apply_filters( 'emulsion_keyword_with_mark_elements_title', $text );
}

function emulsion_keyword_with_mark_elements_title( $text ) {

	$theme_support = emulsion_get_supports( 'search_keyword_highlight' );

	if ( true !== $theme_support ) {
		return $text;
	}

	if ( ! is_search() || ! is_main_query() ) {
		return $text;
	}

	$search_query					 = get_search_query();
	$text							 = strip_tags( $text );
	$style_rules_for_searched_text	 = 'color:#000;padding:0 .2rem;';

	$hilight_rules = array(
		array( mb_strtolower( $search_query ) => $style_rules_for_searched_text ),
		array( mb_strtoupper( $search_query ) => $style_rules_for_searched_text ),
		array( mb_convert_case( $search_query, MB_CASE_TITLE, "UTF-8" ) => $style_rules_for_searched_text ),
		array( ucfirst( $search_query ) => $style_rules_for_searched_text ),
		array( ucwords( $search_query ) => $style_rules_for_searched_text ),
		array( $search_query => $style_rules_for_searched_text ),
	);

	$checksum	 = crc32( $text );
	$class_name	 = trim( sprintf( "search-result-%u\n", $checksum ) );
	$wrapper	 = '<mark style="%1$s">%2$s</mark>';

	foreach ( $hilight_rules as $value ) {

		$name			 = key( $value );
		$replace_value	 = sprintf( $wrapper, esc_attr( $value[$name] ), $name );
		$text			 = str_replace( $name, $replace_value, $text, $count );

		if ( $count > 0 ) {
			break;
		}
	}
	return apply_filters( 'emulsion_keyword_with_mark_elements_title', $text );
}
