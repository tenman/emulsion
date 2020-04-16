<?php
if ( ! function_exists( 'emulsion_related_posts_finder' ) ) {

	/**
	 * 
	 * @global type $post
	 * @param type $type
	 * @return type
	 * @since 1.459
	 */
	
	function emulsion_related_posts_finder( $type = 'automatic' ) {

		global $post;
		if ( ! isset( $post ) && empty( $post ) ) {
			return;
		}

		$categories			 = get_the_category( $post->ID );
		$default_category	 = sanitize_option( 'default_category', get_option( 'default_category' ) );
		$tags				 = wp_get_post_terms( $post->ID, 'post_tag', array( "fields" => 'ids' ) );
		$recent_post_flag	 = false;
		$cat_id_biggest		 = 0;
		$cat_count_biggest	 = 0;
		$tag_id_biggest		 = 0;
		$tag_count_biggest	 = 0;

		If ( 1 < count( $categories ) ) {

			foreach ( $categories as $category ) {

				if ( $category->cat_ID == $default_category ) {

					continue;
				}
				if ( isset( $prev_count ) && $category->count > $prev_count ) {

					$cat_id_biggest		 = $category->cat_ID;
					$cat_count_biggest	 = $category->count;
				}
				$prev_count = $category->count;
			}
		}
		If ( 1 == count( $categories ) ) {

			$cat_id_biggest		 = $categories[0]->cat_ID;
			$cat_count_biggest	 = $categories[0]->count;
		}

		$count_tags = wp_get_post_terms( $post->ID, 'post_tag', array( "fields" => 'all' ) );

		if ( 1 == count( $count_tags ) ) {

			$tag_id_biggest		 = $count_tags[0]->term_id;
			$tag_count_biggest	 = $count_tags[0]->count;
		} elseif ( ! empty( $count_tags ) ) {

			foreach ( $count_tags as $tag ) {

				if ( isset( $prev_count ) && $tag->count > $prev_count ) {

					$tag_id_biggest		 = $tag->term_id;
					$tag_count_biggest	 = $tag->count;
				}

				$prev_count = $tag->count;
			}

			if ( empty( $tag_id_biggest ) ) {

				$tag_id_biggest		 = $count_tags[0]->term_id;
				$tag_count_biggest	 = $count_tags[0]->count;
			}
		}
		If ( 1 == count( $categories ) && empty( $count_tags ) && intval( $default_category ) == intval( $cat_id_biggest ) ) {

			$recent_post_flag = true;
		}

		if ( 'automatic' == $type ) {

			if ( true == $recent_post_flag ) {

				return array( 'recent_post' => 0 );
			} else {

				if ( $tag_count_biggest > $cat_count_biggest && intval( $default_category ) !== intval( $cat_id_biggest ) ) {

					return array( 'post_tag' => $tag_id_biggest );
				} elseif ( $tag_count_biggest < $cat_count_biggest && intval( $default_category ) !== intval( $cat_id_biggest ) ) {

					return array( 'category' => $cat_id_biggest );
				} else {

					$tag = count( get_terms( 'post_tag', array( 'hide_empty' => false, ) ) );
					$cat = count( get_terms( 'category', array( 'hide_empty' => false, ) ) );

					if ( $tag > $cat ) {
						return array( 'post_tag' => $tag_id_biggest );
					} else {
						return array( 'category' => $cat_id_biggest );
					}
				}
			}
		}

		if ( 'category' == $type ) {
			return array( 'category' => $cat_id_biggest );
		}
		if ( 'post_tag' == $type ) {
			return array( 'post_tag' => $tag_id_biggest );
		}
		if ( 'recent_posts' == $type ) {
			return array( 'recent_post' => 0 );
		}
	}

}

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