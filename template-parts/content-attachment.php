<?php
$emulsion_post_id	 = get_the_ID();
$emulsion_post_info	 = get_post( $emulsion_post_id );
$emulsion_mime_type	 = get_post_mime_type( $emulsion_post_id ); // if you needs attachment mime type
$emulsion_excerpt	 = get_the_excerpt();
$emulsion_image_alt	 = get_post_meta( $emulsion_post_id, '_wp_attachment_image_alt', true );
?>
<?php
if ( is_page() ) {

	$has_column = is_active_sidebar( 'sidebar-3' ) ? 'has-sidebar' : 'no-sidebar';
} else {

	$has_column = is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : 'no-sidebar';
}

printf( '<div class="fse-columns is-layout-flex wp-block-columns classic %1$s">', esc_attr( $has_column ) );
?>
<div class="wp-block-column main">

	<div class="article-wrapper <?php emulsion_template_part_names_class( __FILE__ ) ?>">

<?php emulsion_action( 'emulsion_article_before' ); ?>

		<article id="post-<?php the_ID() ?>" <?php //post_class();  ?>>
		<?php
		echo do_blocks( '<!-- wp:pattern {"slug":"emulsion/attachment-media", "align":"full"} /-->' );
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
					?></div><?php
			}
					the_content();

					?></div>

		</article>
				<?php emulsion_action( 'emulsion_article_after' ); ?>
	</div>
</div>

<div class="wp-block-column" style="flex-basis:400px">
		<?php get_template_part( 'template-parts/widget', 'sidebar' ); ?>
</div>
</div>