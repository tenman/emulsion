<?php

$emulsion_title_in_page_header	 = emulsion_the_theme_supports( 'title_in_page_header' );
$emulsion_post_id				 = get_the_ID();
$emulsion_post_info				 = get_post( $emulsion_post_id );
$emulsion_mime_type				 = get_post_mime_type( $emulsion_post_id ); // if you needs attachment mime type
$emulsion_excerpt				 = get_the_excerpt();
$emulsion_image_alt				 = get_post_meta( $emulsion_post_id, '_wp_attachment_image_alt', true );
?>
<div class="article-wrapper <?php emulsion_template_part_names_class( __FILE__ ) ?>">

	<?php emulsion_action('emulsion_article_before'); ?>

	<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>
		<?php

		wp_attachment_is_image( $emulsion_post_id ) ? emulsion_attachment_image( $emulsion_post_id, 'full', $emulsion_excerpt ) : the_content();

		emulsion_article_header();
		?>
		<div class="entry-content attachment-content"><?php

			if ( $emulsion_post_info->post_parent > 0 ) {
				?>
				<div class="attachment-metadata"><?php

				printf( '<div class="relate-post-title"><span class="label">%1$s : </span><a class="parent-entry-title" href="%3$s" rev="attachment">%2$s</a></div>',
						esc_html__( "Relate Post", 'emulsion' ),
						wp_kses_post( get_the_title( $emulsion_post_info->post_parent ) ),
						esc_url( get_permalink( $emulsion_post_info->post_parent ) )
				);
				empty( $emulsion_post_info->post_content )
						? ''
						: printf( '<div class="alt-text"><span class="label">%1$s : </span>%2$s</div>',
									esc_html__( 'ALT text', 'emulsion' ),
									wp_kses_post( $emulsion_image_alt )
								);
				empty( $emulsion_post_info->post_content )
						? ''
						: printf( '<div class="description-text"><span class="label">%1$s : </span>%2$s</div>',
									esc_html__( 'Description', 'emulsion' ),
									wp_kses_post( $emulsion_post_info->post_content )
								);

					?></div>
			<?php

			}

			wp_link_pages( 'before=<div class="wp-link-pages page-break-links clearfix">&after=</div>&next_or_number=number&pagelink=<span>%</span>' );

			?></div>
		<footer><?php

			edit_post_link( esc_html__( 'Edit', 'emulsion' ), '<span class="editor">', '</span>', '', 'skin-button' );

	  ?></footer>
	</article>
			<?php emulsion_action('emulsion_article_after'); ?>
</div>