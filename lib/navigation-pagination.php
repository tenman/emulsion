<?php

if ( ! function_exists( 'emulsion_year_link_element' ) ) {

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


if ( ! function_exists( 'emulsion_pagination' ) ) {
	/**
	 * Print pagination
	 */
	function emulsion_pagination() {

		$post_id  = get_the_ID();
		$supports = emulsion_theme_default_val('emulsion_single_post_navigation');

		if( false === $post_id ) {
			__return_empty_string();
		}

		$post_navigation_args = array(
			'prev_text' => '<span class="prev text">'.esc_html__('Previous', 'emulsion'). '</span> <span class="title">%title</span>',
			'next_text' => '<span class="next text">'.esc_html__('next', 'emulsion'). '</span> <span class="title">%title</span>',
		);

		if ( is_singular() && 'enable' == $supports ) {

			! is_page() && ! is_attachment() ? the_post_navigation( $post_navigation_args ) : '';

			wp_attachment_is_image( $post_id ) ? emulsion_attachment_pagination() : '';
		} else {

			the_posts_pagination();
		}
	}
}