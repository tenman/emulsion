<?php
		$relate_posts_enable = emulsion_the_theme_supports( 'relate_posts' );

		if( empty( $relate_posts_enable ) ) {

			return;
		}
		
		$algo = emulsion_related_posts_finder();

		$html = '';

		if ( ! empty( $algo ) ) {

			$type			 = key( $algo );
			$id				 = $algo[$type];
			$args			 = "recent_post" == $type ? array( 'posts_per_page' => 5, 'post_status' => 'publish' ) : array( 'posts_per_page' => 5, $type => $id, 'post_status' => 'publish' );
			$relate_posts	 = get_posts( $args );

			if ( ! empty( $relate_posts )  ) {

				$result = sprintf( '<!-- wp:group {"className":"emulsion-block-pattern-relate-posts wrap-emulsion_relate_posts", "layout":{"inherit":true}} --><div class="emulsion-block-pattern-relate-posts wp-block-group wrap-emulsion_relate_posts"><!-- wp:heading --><h2 class="relate-posts-title fit">%1$s</h2><!-- /wp:heading --><!-- wp:list --><ul class="relate-posts fit">', esc_html__( 'Relate Posts', 'emulsion' ) );

					foreach ( $relate_posts as $relate_post ) {

						$post_id			 = absint( $relate_post->ID );
						$relate_post_title	 =  $relate_post->post_title ;
						$link_url			 = get_permalink( $post_id );

							if ( has_post_thumbnail( $post_id ) ) {

								$result .= sprintf( '<li>%1$s', get_the_post_thumbnail( $post_id, 'thumbnail' ) );

							} else {

								/* translators: title icon question mark */
								$icon_text	 = empty( $relate_post_title ) ? esc_html_x( '?','title icon question mark', 'emulsion' ) : mb_substr( sanitize_text_field( $relate_post_title ), 0, 1 );

								$result .= '<li><span class="relate-post-no-icon">' . esc_html( $icon_text ) . '</span>';

							}
							$result .= sprintf('<a href="%1$s">%2$s</a></li>', esc_url( $link_url ), wp_kses( $relate_post_title, array() ) );

					}
					wp_reset_postdata();
				}
				$html = $result.'</ul><!-- /wp:list --></div><!-- /wp:group -->';
		}


$html = str_replace( array( PHP_EOL, "\t" ), array( '', '' ), $html );

return $html;

