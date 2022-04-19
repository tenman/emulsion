<?php


if ( ! function_exists( 'emulsion_related_posts' ) ) {

	/**
	 *
	 * @since 1.1.3 removed global $post
	 */

	function emulsion_related_posts() {

		$relate_posts_enable = emulsion_the_theme_supports( 'relate_posts' );

		if( empty( $relate_posts_enable ) ) {

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
						$relate_post_title	 =  $relate_post->post_title ;
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
								$icon_text	 = empty( $relate_post_title ) ? esc_html_x( '?','title icon question mark', 'emulsion' ) : mb_substr( sanitize_text_field( $relate_post_title ), 0, 1 );

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

