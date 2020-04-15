<div class="article-wrapper <?php emulsion_template_part_names_class( __FILE__ ) ?>">
	<?php
	if ( 'list' == emulsion_current_layout_type() && has_action( 'emulsion_article_before' ) ) {
		?><div class="placeholder-article-before fit"><?php do_action( 'emulsion_article_before' ); ?></div><?php
	}
	?> 	
	<article id="post-<?php the_ID() ?>" <?php post_class(); ?>>
		<?php emulsion_article_header(); ?>
		<div class="entry-content"><?php 
		
		if( emulsion_theme_addons_exists() ) {
			
			emulsion_post_content();
		} else {
			
			'full_text' == emulsion_get_layout_setting() || 'post' == emulsion_get_layout_setting() || 'page' == emulsion_get_layout_setting()
			? the_content() 
			: the_excerpt();		
		}
		
		wp_link_pages( 'before=<div class="wp-link-pages page-break-links clearfix">&after=</div>&next_or_number=number&pagelink=<span>%</span>' ); ?></div>
		
		<footer><?php emulsion_theme_addons_exists() ? emulsion_post_excerpt_more(): ''; ?>
			<?php 
			
			if ( has_nav_menu( 'social' ) 
					&& is_singular() 
					&& emulsion_the_theme_supports( 'social-link-menu' ) 
					&& emulsion_the_theme_supports( 'enqueue' ) 
					&& emulsion_metabox_display_control( 'page_style' ) 
					&& emulsion_metabox_display_control( 'style' ) ) {
				?>
					<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'emulsion' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'social',
									'menu_class'     => 'social-links-menu',
									'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>' . emulsion_get_svg( array( 'icon' => 'chain' ) ),
									'items_wrap'	 => '<h2 class="screen-reader-text">'.esc_html__('Social navigation','emulsion').'</h2><ul id="%1$s" class="%2$s">%3$s</ul>',
									'item_spacing'   => 'discard',
								)
							);
						?>
					</nav><!-- .social-navigation -->
				<?php
			}
				?>	
			<?php edit_post_link( esc_html__( 'Edit', 'emulsion' ), '<span class="editor">', '</span>', '', 'skin-button' ); ?></footer>
	</article>
	<?php
	if ( 'list' == emulsion_current_layout_type() && has_action( 'emulsion_article_after' ) ) {
		?><div class="placeholder-article-before fit"><?php do_action( 'emulsion_article_after' ); ?></div><?php
	}
	?> 
</div>
<?php if ( is_singular() ) { ?>
	<div class="comment-wrapper"><?php emulsion_have_comments(); ?></div>
<?php } ?>
<?php if ( is_single() 
			&& ! is_attachment() 
			&& emulsion_the_theme_supports( 'relate_posts' ) 
			&& emulsion_the_theme_supports( 'enqueue' ) 
			&& emulsion_metabox_display_control( 'page_style' ) 
			&& emulsion_metabox_display_control( 'style' )) { ?>
	<div class="relate-content-wrapper"><?php emulsion_related_posts(); ?></div>
<?php } ?>