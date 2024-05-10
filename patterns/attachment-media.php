<?php
/**
 * Title: attachment media
 * Slug: emulsion/attachment-media
 * Categories: contents, emulsion
 * Viewport Width: 1280
 * Inserter: no
 * Description: attachment image
 */

$post_id			 = absint( get_the_ID() );
$src				 = wp_get_attachment_image_src( $post_id, 'full' );
$width				 = ! empty( $src[1] ) ? esc_attr( $src[1] ) : '';
$caption			 = ! empty( get_the_excerpt() ) ? wp_kses_post( get_the_excerpt() ) : '';
$attachment_image	 = wp_kses_post( wp_get_attachment_image( $post_id, 'full', false ) );
$attachment_image	 = img_caption_shortcode( array( 'align' => 'alignfull', 'width' => $width, 'caption' => $caption ), $attachment_image );
$mime_type			 = esc_attr( get_post_mime_type() );
$emulsion_post_info	 = get_post( $post_id );
$url				 = esc_url( wp_get_attachment_url( $post_id ) );

if ( wp_attachment_is_image( $post_id ) ) {

	printf( '<figure class="wp-block-image alignwide emulsion-pattern-attachment-image">%1$s</figure>', $attachment_image );

	$sizes	 = get_intermediate_image_sizes();
	$sizes[] = 'full';
	$links	 = '<!-- wp:post-title /--><p class="file-type">' . $mime_type . '</p><ul class="is-style-list-style-inline" style="padding-left:0.75rem;">';

	foreach ( $sizes as $size ) {

		$image = wp_get_attachment_image_src( $post_id, $size );

		if ( ! empty( $image ) && ( true === $image[3] || 'full' == $size ) ) {

			$label	 = sprintf( esc_html__( '%1$s &#215; %2$s', 'emulsion' ), number_format_i18n( absint( $image[1] ) ), number_format_i18n( absint( $image[2] ) ) );
			$links	 .= sprintf(
					'<li><a href="%1$s" class="image-size">%2$s</a></li>',
					esc_url( $image[0] ),
					$label
			);
		}
	}
	echo $links . '</ul>';
	return;
}

if ( wp_attachment_is( 'video' ) ) {
	printf( '<div class="alignfull is-layout-constrained"><iframe  src="%1$s" class="alignwide"></iframe></div>', $url );
	printf( '<h2 class="attachment-title">%1$s</h2>', esc_html( $emulsion_post_info->post_title ) );
	printf( '<p class="file-type">%1$s</p>', $mime_type );
	return;
} elseif ( wp_attachment_is( 'pdf' ) ) {

	printf( '<div class="alignfull is-layout-constrained"><iframe  src="%1$s" class="alignwide"></iframe></div>', $url );
	printf( '<h2 class="attachment-title"><a href="%2$s" target="_blank">%1$s</a></h2>', esc_html( $emulsion_post_info->post_title ), $url );
	printf( '<p class="file-type">%1$s</p>', $mime_type );
	return;
} elseif ( wp_attachment_is( 'html' ) ) {

	printf( '<div class="alignfull is-layout-constrained"><iframe  src="%1$s" class="alignwide"></iframe></div>', $url );
	printf( '<h2 class="attachment-title"><a href="%2$s" target="_blank">%1$s</a></h2>', esc_html( $emulsion_post_info->post_title ), $url );
	printf( '<p class="file-type">%1$s</p>', $mime_type );
	return;
} elseif ( wp_attachment_is( 'txt' ) ) {
	printf( '<div class="alignfull is-layout-constrained"><iframe  src="%1$s" class="alignwide"></iframe></div>', $url );
	printf( '<h2 class="attachment-title"><a href="%2$s" target="_blank">%1$s</a></h2>', esc_html( $emulsion_post_info->post_title ), $url );
	printf( '<p class="file-type">%1$s</p>', $mime_type );
	return;
} elseif ( wp_attachment_is( 'audio' ) ) {

	printf( '<div class="is-layout-constrained" style="margin:1.5rem auto;"><audio controls src="%1$s"></audio></div>', $url );
	printf( '<h2 class="attachment-title"><a href="%2$s" target="_blank">%1$s</a></h2>', esc_html( $emulsion_post_info->post_title ), $url );
	printf( '<p class="file-type">%1$s</p>', $mime_type );
	return;
} elseif ( ! empty( $url ) ) {

	printf( '<div class="is-layout-constrained" style="margin:1.5rem auto;padding:.75rem"><h2 class="attachment-title"><a href="%1$s">%2$s</a></h2></div>', $url, esc_html( $emulsion_post_info->post_title ) );
	printf( '<p class="file-type" style="margin-bottom:1.5rem;">%1$s</p>', $mime_type );
	return;
}
?>
