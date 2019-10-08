<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $template;

$emulsion_post_id			 = get_the_ID();
$emulsion_show_post_image	 = emulsion_is_display_featured_image_in_the_loop();
?>
<div class="article-wrapper <?php emulsion_template_identification_class( __FILE__ ) ?>">

	<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>
		<?php if ( ! is_singular() ) { ?>
			<div  class="stream-wrapper">
				<div class="post-thumb-col"><?php
					if ( has_post_thumbnail() && ! post_password_required( absint($emulsion_post_id) ) && $emulsion_show_post_image ) {
						echo get_the_post_thumbnail( null, 'medium', array( 'class' => 'post-thumbnail-in-the-loop' ) );
					}
					?></div>
				<div class="content-col" >

					<?php emulsion_the_post_title( false ); ?>										
					<?php emulsion_the_post_meta_on(); ?>
					<?php echo ! post_password_required( absint($emulsion_post_id) ) ? '<p class="fit"><span class="show-content" data-type="post" data-id="' . absint($emulsion_post_id)  . '">'
							//. '<svg class="icon enlarge"><use xlink:href="'. get_theme_file_uri( 'images/svg/enlarge.svg' ).'#enlarge" /></svg>'
							. '</span></p>': '';  ?>
					<?php /*echo ! post_password_required( $emulsion_post_id ) ? '<p class="fit"><span class="show-content" data-type="post" data-id="' . $emulsion_post_id  . '">'
							. '<img class="icon enlarge" src="'. wp_make_link_relative(get_theme_file_uri( 'images/svg/enlarge.svg' )).'#white" /></span></p>': '';*/ ?>
				<?php } ?>
				<div class="content">
					<?php emulsion_post_content(); ?>
					<?php wp_link_pages( 'before=<div class="wp-link-pages page-break-links clearfix">&after=</div>&next_or_number=number&pagelink=<span>%</span>' ); ?>
				</div>

				<footer>
					<?php emulsion_the_post_meta_in(); ?>
					<?php //edit_post_link( esc_html__('Edit', 'emulsion'), '<span class="editor">', '</span>' );  ?>
				</footer>

				<?php if ( ! is_singular() ) { ?>
				</div></div>
		<?php } ?>
	</article>
</div>