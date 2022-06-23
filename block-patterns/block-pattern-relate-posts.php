<?php

$post_counts = 5;

$algo = emulsion_related_posts_finder();

$html		 = sprintf( '<li>%1$s</li>', esc_html__( 'Not Found', 'emulsion' ) );
$result_pre	 = sprintf( '<!-- wp:group {"className":"emulsion-block-pattern-relate-posts wrap-emulsion_relate_posts", "layout":{"inherit":true}} -->'
		. '<div class="emulsion-block-pattern-relate-posts wp-block-group wrap-emulsion_relate_posts">'
		. '<!-- wp:heading --><h2 class="relate-posts-title fit">%1$s</h2><!-- /wp:heading -->'
		. '<!-- wp:list --><ul class="relate-posts fit">', esc_html__( 'Relate Posts', 'emulsion' ) );

$result_after = '</ul><!-- /wp:list --></div><!-- /wp:group -->';

if ( ! empty( $algo ) ) {

	$type			 = key( $algo );
	$id				 = $algo[$type];
	$args			 = "recent_post" == $type ? array( 'posts_per_page' => $post_counts, 'post_status' => 'publish' ) : array( 'posts_per_page' => $post_counts, $type => $id, 'post_status' => 'publish' );
	$relate_posts	 = get_posts( $args );
	$result = '';

	if ( ! empty( $relate_posts ) ) {


		foreach ( $relate_posts as $relate_post ) {

			$post_id			 = absint( $relate_post->ID );
			$relate_post_title	 = $relate_post->post_title;
			$link_url			 = get_permalink( $post_id );

			if ( has_post_thumbnail( $post_id ) ) {

				$result .= sprintf( '<li>%1$s', get_the_post_thumbnail( $post_id, array( 48, 48 ) ) );
			} else {

				/* translators: title icon question mark */
				//$icon_text = empty( $relate_post_title ) ? esc_html_x( '?', 'title icon question mark', 'emulsion' ) : mb_substr( sanitize_text_field( $relate_post_title ), 0, 1 );

				$result .= '<li><span class="relate-post-no-icon"></span>';
			}
			$result .= sprintf( '<a href="%1$s">%2$s</a></li>', esc_url( $link_url ), wp_kses( $relate_post_title, array() ) );
		}
		wp_reset_postdata();
	}
}
$result	 = ! empty( $result ) ? $result : $html;
$html	 = $result_pre . $result . $result_after;
$html	 = str_replace( array( PHP_EOL, "\t" ), array( '', '' ), $html );

return $html;

