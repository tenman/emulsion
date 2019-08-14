<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$emulsion_title_in_page_header	 = emulsion_get_supports( 'title_in_page_header' );
$emulsion_post_id				 = get_the_ID();
$post_info						 = get_post( $emulsion_post_id );
$mime_type						 = get_post_mime_type( $emulsion_post_id ); // if you needs attachment mime type
$excerpt						 = get_the_excerpt();
$image_content					 = '';
$image_content_html				 = '<h3 class="section-title">%1$s</h3><div class="image-description" id="image-description">%2$s</div>';

//var_dump( $post_info ); post_excerpt - caption post_content - description
?>
<div class="article-wrapper <?php emulsion_template_identification_class( __FILE__ ) ?>">
	<?php
	if ( has_action( 'emulsion_article_before' ) ) {
		?><div class="placeholder-article-before fit"><?php do_action( 'emulsion_article_before' ); ?></div><?php
	}
	?>
		
		
	<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>

		<?php wp_attachment_is_image( $emulsion_post_id ) ? emulsion_attachment_image( $emulsion_post_id, 'full', $excerpt ) : ''; ?>

		<?php emulsion_article_header(); ?>

		<div class="entry-content">

			<?php
			if ( $post_info->post_content ) {

				$image_content = sprintf( $image_content_html, esc_html__( "Description", 'emulsion' ), $post_info->post_content );
			}
			// check lost element
			if( wp_attachment_is_image( $emulsion_post_id ) ) {
				$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
				true === WP_DEBUG ? emulsion_elements_assert_equal(  $image_content, wp_kses_post( $image_content ), $emulsion_place ) : '';
			}
			
			wp_attachment_is_image( $emulsion_post_id ) ? wp_kses_post( $image_content ) : emulsion_post_content();

			if ( $post_info->post_parent > 0 ) {
				
				// check lost element
				$emulsion_place = basename(__FILE__). ' line:'. __LINE__. ' '.  __FUNCTION__ .'()';
				true === WP_DEBUG ? emulsion_elements_assert_equal(  get_the_title( $post_info->post_parent ), wp_kses_post( get_the_title( $post_info->post_parent ) ), $emulsion_place ) : '';
				
				?>
				<div class="image-caption parent-entry">
					<h3 class="section-title"><?php esc_html_e( "Article", 'emulsion' ); ?></h3>								
					<p class="parent-entry-title h4">
						<a href="<?php echo esc_url( get_permalink( $post_info->post_parent ) ); ?>" rev="attachment"><?php echo wp_kses_post( get_the_title( $post_info->post_parent ) ); ?></a>
					</p>
					<?php 
						empty($post_info->post_excerpt) ? '': printf('<p class="caption-text">%1$s : %2$s</p>', esc_html__('Image caption', 'emulsion'), $post_info->post_excerpt ) ;
						empty($post_info->post_content) ? '': printf('<p class="caption-text">%1$s : %2$s</p>', esc_html__('Image content', 'emulsion'), $post_info->post_content ) ;
				?></div><?php
		}

		wp_link_pages( 'before=<div class="wp-link-pages page-break-links clearfix">&after=</div>&next_or_number=number&pagelink=<span>%</span>' );
			?>

		</div>
			<?php //example<span><a href="" class="skin-button">test</a></span>   ?>
		<footer><?php edit_post_link( esc_html__( 'Edit', 'emulsion' ), '<span class="editor">', '</span>', '', 'skin-button' ); ?></footer>
	</article>
		<?php
		if ( has_action( 'emulsion_article_after' ) ) {
			?><div class="placeholder-article-before fit"><?php do_action( 'emulsion_article_after' ); ?></div><?php
	}
	?>
	<?php //do_action('emulsion_article_after');?>
</div>