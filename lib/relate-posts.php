<?php
if ( ! function_exists( 'emulsion_relate_posts_algo' ) ) {

	/**
	 * 
	 * @global type $post
	 * @param type $type
	 * @return type
	 * @since 1.459
	 */
	
	function emulsion_relate_posts_algo( $type = 'automatic' ) {

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

if ( ! function_exists( 'emulsion_post_relate_contents' ) ) {

	/**
	 * 
	 */
	
	function emulsion_post_relate_contents() {
		
		global $post;

		$relate_posts_enable = emulsion_get_supports( 'relate_posts' );
		
		if( empty( $relate_posts_enable ) ) {
			
			return;
		}

		$algo = emulsion_relate_posts_algo();
		if ( ! empty( $algo ) && is_single() && ! is_attachment() ) {

			$type			 = key( $algo );
			$id				 = $algo[$type];
			$args			 = array( 'posts_per_page' => 5, $type => $id );
			$relate_posts	 = get_posts( $args );

			if ( ! empty( $relate_posts ) && is_single() && ! is_attachment() ) {
				?>	
				<h2 class="relate-posts-title fit"><?php esc_html_e( 'Relate Posts', 'emulsion' ); ?></h2>
				<ul class="relate-posts fit"><?php
					/**
					 * @see https://codex.wordpress.org/Function_Reference/setup_postdata
					 * You must pass a reference to the global $post variable, otherwise functions like the_title() don't work properly.
					 */
					foreach ( $relate_posts as $post ) {

						setup_postdata( $post );
						?>
						<li><?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'thumbnail' );
							} else {
								$string	 = mb_substr( get_the_title(), 0, 1 );
								/* translators: title icon question mark */
								$string	 = empty( $string ) ? esc_html__( '?', 'emulsion' ) : $string;
								echo '<div class="relate-post-no-icon">' . esc_html( $string ) . '</div>';
							}
							?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
						<?php
					}
					wp_reset_postdata();
				}
				?></ul>	
			<?php
		}
	}
}