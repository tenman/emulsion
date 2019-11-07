<?php
$emulsion_title_in_page_header	 = emulsion_get_supports( 'title_in_page_header' );
$emulsion_post_id				 = get_the_ID();
$post_info						 = get_post( $emulsion_post_id );
$mime_type						 = get_post_mime_type( $emulsion_post_id ); // if you needs attachment mime type
$excerpt						 = get_the_excerpt();
?>
<div class="article-wrapper <?php emulsion_template_identification_class( __FILE__ ) ?>">
	<?php
	if ( has_action( 'emulsion_article_before' ) ) {
		?><div class="placeholder-article-before fit"><?php do_action( 'emulsion_article_before' ); ?></div><?php
	}
	?>
	<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>		
		<?php
	
		wp_attachment_is_image( $emulsion_post_id ) ? emulsion_attachment_image( $emulsion_post_id, 'full', $excerpt ) : the_content();
		
		emulsion_article_header();
		?>
		<div class="entry-content attachment-content"><?php
			// check lost element
			if ( wp_attachment_is_image( $emulsion_post_id ) ) {
				$emulsion_place = basename( __FILE__ ) . ' line:' . __LINE__ . ' ' . __FUNCTION__ . '()';
				true === WP_DEBUG ? emulsion_elements_assert_equal( $post_info->post_content, wp_kses_post( $post_info->post_content ), $emulsion_place ) : '';
			}

			if ( $post_info->post_parent > 0 ) {

				// check lost element
				$emulsion_place = basename( __FILE__ ) . ' line:' . __LINE__ . ' ' . __FUNCTION__ . '()';
				true === WP_DEBUG ? emulsion_elements_assert_equal( get_the_title( $post_info->post_parent ), wp_kses_post( get_the_title( $post_info->post_parent ) ), $emulsion_place ) : '';
				?>
				<div class="attachment-metadata"><?php
			printf( '<div class="relate-post-title"><span class="label">%1$s : </span><a class="parent-entry-title" href="%3$s" rev="attachment">%2$s</a></div>', esc_html__( "Relate Post", 'emulsion' ), wp_kses_post( get_the_title( $post_info->post_parent ) ), esc_url( get_permalink( $post_info->post_parent ) )
			);

			empty( $post_info->post_content ) ? '' : printf( '<div class="description-text"><span class="label">%1$s : </span>%2$s</div>', esc_html__( 'Description', 'emulsion' ), wp_kses_post( $post_info->post_content ) );
				?></div>
					<?php
				}
				wp_link_pages( 'before=<div class="wp-link-pages page-break-links clearfix">&after=</div>&next_or_number=number&pagelink=<span>%</span>' );
				?></div>
		<footer><?php edit_post_link( esc_html__( 'Edit', 'emulsion' ), '<span class="editor">', '</span>', '', 'skin-button' ); ?></footer>
	</article>
			<?php
			if ( has_action( 'emulsion_article_after' ) ) {
				?><div class="placeholder-article-before fit"><?php do_action( 'emulsion_article_after' ); ?></div><?php
			}
			?>
</div>