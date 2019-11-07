<?php

function emulsion_customizer_add_supports_excerpt() {
	// use action hook: emulsion_template_pre_index
	if ( is_home() && 'full_text' == get_theme_mod( 'emulsion_layout_homepage', emulsion_get_var( 'emulsion_layout_homepage', 'default' ) ) ) {

		emulsion_remove_supports( 'excerpt' );
	}

	if ( is_date() && 'full_text' == get_theme_mod( 'emulsion_layout_date_archives', emulsion_get_var( 'emulsion_layout_date_archives', 'default' ) ) ) {

		emulsion_remove_supports( 'excerpt' );
	}

	if ( is_category() && 'full_text' == get_theme_mod( 'emulsion_layout_category_archives', emulsion_get_var( 'emulsion_layout_category_archives', 'default' ) ) ) {

		emulsion_remove_supports( 'excerpt' );
	}
	if ( is_tag() && 'full_text' == get_theme_mod( 'emulsion_layout_tag_archives', emulsion_get_var( 'emulsion_layout_tag_archives', 'default' ) ) ) {

		emulsion_remove_supports( 'excerpt' );
	}
	if ( is_author() && 'full_text' == get_theme_mod( 'emulsion_layout_author_archives', emulsion_get_var( 'emulsion_layout_author_archives', 'default' ) ) ) {

		emulsion_remove_supports( 'excerpt' );
	}
	if ( emulsion_is_posts_page() && 'full_text' == get_theme_mod( 'emulsion_layout_posts_page', emulsion_get_var( 'emulsion_layout_posts_page', 'default' ) ) ) {

		emulsion_remove_supports( 'excerpt' );
	}
}

function emulsion_customizer_add_supports_footer() {

	if ( ! current_user_can( 'edit_theme_options' ) ) {

		$cols_count = (int) get_theme_mod( 'emulsion_footer_columns', emulsion_get_var( 'emulsion_footer_columns', 'default' ) );
		if ( ! empty( $cols_count ) ) {
			emulsion_add_supports( 'footer', array( 'cols' => $cols_count ) );
		} else {
			emulsion_add_supports( 'footer', array( 'cols' => 3 ) );
		}

		return false;
	}

	$cols_count	 = (int) get_theme_mod( 'emulsion_footer_columns', emulsion_get_var( 'emulsion_footer_columns', 'default' ) );
	$new_setting = (int) $cols_count;
	$old_setting = (int) get_theme_mod( 'customizer_add_supports_footer_val' );
	$is_changed	 = false;

	if ( ! empty( $cols_count ) ) {
		emulsion_add_supports( 'footer', array( 'cols' => $cols_count ) );
	} else {
		emulsion_add_supports( 'footer', array( 'cols' => 3 ) );
	}

	if ( $old_setting !== $new_setting ) {
		$is_changed = true;
		set_theme_mod( 'customizer_add_supports_footer_val', $cols_count );
	}

	return $is_changed;
}



function emulsion_customizer_add_supports_layout() {

	/**
	 * stream , grid setting example
	 * emulsion_add_supports( 'stream', array( 'post_tag', 'blog','category', 'author', 'post_type' => array( 'news', 'product' ) ) );
	 */
	if ( ! current_user_can( 'edit_theme_options' ) ) {

		$setting_stream = get_theme_mod( 'customizer_add_supports_layout_stream_val', false );
		if ( false !== $setting_stream ) {

			emulsion_add_supports( 'stream', $setting_stream );
		}


		$setting_grid = get_theme_mod( 'customizer_add_supports_layout_grid_val', false );
		if ( false !== $setting_grid ) {

			emulsion_add_supports( 'grid', $setting_grid );
		}

		return;
	}

	$grid	 = array();
	$name	 = 'grid';

	$customizer_setting_home = get_theme_mod( 'emulsion_layout_homepage', emulsion_get_var( 'emulsion_layout_homepage', 'default' ) );

	if ( $name == $customizer_setting_home ) {

		$grid[] = 'home';
	}

	$emulsion_layout_posts_page = get_theme_mod( 'emulsion_layout_posts_page', emulsion_get_var( 'emulsion_layout_posts_page', 'default' ) );

	if ( $name == $emulsion_layout_posts_page ) {

		$grid[] = 'blog';
	}

	$emulsion_layout_date_archives = get_theme_mod( 'emulsion_layout_date_archives', emulsion_get_var( 'emulsion_layout_date_archives', 'default' ) );

	if ( $name == $emulsion_layout_date_archives ) {

		$grid[] = 'date';
	}

	$emulsion_layout_category_archives = get_theme_mod( 'emulsion_layout_category_archives', emulsion_get_var( 'emulsion_layout_category_archives', 'default' ) );

	if ( $name == $emulsion_layout_category_archives ) {

		$grid[] = 'category';
	}

	$emulsion_layout_tag_archives = get_theme_mod( 'emulsion_layout_tag_archives', emulsion_get_var( 'emulsion_layout_tag_archives', 'default' ) );

	if ( $name == $emulsion_layout_tag_archives ) {

		$grid[] = 'post_tag';
	}

	$emulsion_layout_author_archives = get_theme_mod( 'emulsion_layout_author_archives', emulsion_get_var( 'emulsion_layout_author_archives', 'default' ) );

	if ( $name == $emulsion_layout_author_archives ) {

		$grid[] = 'author';
	}
	/**
	 * Future tasks
	 */
	/* $post_type_grid = apply_filters( 'emulsion_post_type_grid', array() );

	  if ( ! empty( $post_type_grid) && is_array( $post_type_grid )) {

	  $grid['post_type'] = $post_type_grid;
	  } */

	$grid = array_unique( $grid );

	emulsion_add_supports( $name, $grid );

	$stream	 = array();
	$name	 = 'stream';

	$emulsion_layout_homepage = get_theme_mod( 'emulsion_layout_homepage', emulsion_get_var( 'emulsion_layout_homepage', 'default' ) );

	if ( $name == $emulsion_layout_homepage ) {

		$stream[] = 'home';
	}

	$emulsion_layout_posts_page = get_theme_mod( 'emulsion_layout_posts_page', emulsion_get_var( 'emulsion_layout_posts_page', 'default' ) );

	if ( $name == $emulsion_layout_posts_page ) {

		$stream[] = 'blog';
	}

	$emulsion_layout_date_archives = get_theme_mod( 'emulsion_layout_date_archives', emulsion_get_var( 'emulsion_layout_date_archives', 'default' ) );
	if ( $name == $emulsion_layout_date_archives ) {

		$stream[] = 'date';
	}

	$emulsion_layout_category_archives = get_theme_mod( 'emulsion_layout_category_archives', emulsion_get_var( 'emulsion_layout_category_archives', 'default' ) );

	if ( $name == $emulsion_layout_category_archives ) {

		$stream[] = 'category';
	}

	$emulsion_layout_tag_archives = get_theme_mod( 'emulsion_layout_tag_archives', emulsion_get_var( 'emulsion_layout_tag_archives', 'default' ) );

	if ( $name == $emulsion_layout_tag_archives ) {

		$stream[] = 'post_tag';
	}

	$emulsion_layout_author_archives = get_theme_mod( 'emulsion_layout_author_archives', emulsion_get_var( 'emulsion_layout_author_archives', 'default' ) );

	if ( $name == $emulsion_layout_author_archives ) {

		$stream[] = 'author';
	}
	/**
	 * Future tasks
	 */
	/* $post_type_stream = apply_filters( 'emulsion_post_type_stream', array() );

	  if ( ! empty( $post_type_stream ) && is_array( $post_type_stream )) {

	  $stream['post_type'] = $post_type_stream;
	  }*/


	$stream = array_unique( $stream );
	emulsion_add_supports( $name, $stream );

	$old_setting_grid	 = (array) get_theme_mod( 'customizer_add_supports_layout_grid_val' );
	$is_changed			 = false;

	$diff = array_diff( $old_setting_grid, $grid );

	if ( isset( $diff ) && ! empty( $diff ) ) {

		$is_changed = true;
	}
	if ( current_user_can( 'edit_theme_options' ) ) {

		set_theme_mod( 'customizer_add_supports_layout_grid_val', $grid );
	}

	$old_setting_stream = (array) get_theme_mod( 'customizer_add_supports_layout_stream_val' );

	$diff = array_diff( $old_setting_stream, $stream );

	if ( isset( $diff ) && ! empty( $diff ) ) {

		$is_changed = true;
	}
	if ( current_user_can( 'edit_theme_options' ) ) {

		set_theme_mod( 'customizer_add_supports_layout_stream_val', $stream );
	}

	return $is_changed;
}

/**
 * Functions
 */
function emulsion_add_supports( $feature ) {

	global $emulsion_supports;

	if ( func_num_args() == 1 ) {
		$args = true;
	} else {
		$args = array_slice( func_get_args(), 1 );
	}

	$emulsion_supports[$feature] = $args;
}

function emulsion_get_supports( $feature ) {

	global $emulsion_supports;

	if ( ! isset( $emulsion_supports[$feature] ) ) {
		return false;
	}

	if ( func_num_args() <= 1 ) {
		return $emulsion_supports[$feature];
	}

	return $emulsion_supports[$feature];
}

function emulsion_remove_supports( $feature ) {

	global $emulsion_supports;

	if ( ! isset( $emulsion_supports[$feature] ) ) {
		return false;
	}

	unset( $emulsion_supports[$feature] );

	return true;
}
