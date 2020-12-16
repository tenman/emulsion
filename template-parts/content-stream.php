<?php
$emulsion_post_id			 = get_the_ID();
$emulsion_show_post_image	 = emulsion_is_display_featured_image_in_the_loop();
?>
<div class="article-wrapper <?php emulsion_template_part_names_class( __FILE__ ) ?>">
	<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>
		<?php if ( ! is_singular() ) { ?>
			<div  class="stream-wrapper">
				<div class="post-thumb-col"><?php
					if ( has_post_thumbnail() && ! post_password_required( absint( $emulsion_post_id ) ) && $emulsion_show_post_image ) {
						echo get_the_post_thumbnail( null, 'medium', array( 'class' => 'post-thumbnail-in-the-loop' ) );
					}
					?></div>
				<div class="content-col" >

					<?php emulsion_the_post_title( false ); ?>
					<?php emulsion_the_post_meta_on(); ?>
					<?php echo ! post_password_required( absint( $emulsion_post_id ) ) ? '<span class="show-content" data-type="post" data-id="' . absint( $emulsion_post_id ) . '" >'
							. '</span>' : '';
					?>

					<?php } // ! is_singular()  ?>
				<div class="content">
					<?php
					if ( emulsion_theme_addons_exists() ) {

						emulsion_post_content();
					} elseif ( 'full_text' == emulsion_get_layout_setting() || 'post' == emulsion_get_layout_setting() || 'page' == emulsion_get_layout_setting() ) {

						the_content();
					} else {
						
						$number_of_lines = get_theme_mod( 'emulsion_excerpt_length_stream', emulsion_theme_default_val( 'emulsion_excerpt_length_stream' ) );

						echo '<p class="trancate" data-rows="'. $number_of_lines.'">';

						the_excerpt();

						echo '</p>';
					}
					?>
					<?php wp_link_pages( 'before=<div class="wp-link-pages page-break-links clearfix">&after=</div>&next_or_number=number&pagelink=<span>%</span>' ); ?>
				</div>

				<footer><?php emulsion_the_post_meta_in(); ?></footer>

		<?php if ( ! is_singular() ) { ?>
				</div></div>
<?php } ?>
	</article>
</div>
