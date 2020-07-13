<?php
/**
 * default header template
 */
?>
<header class="header-layer clearfix <?php emulsion_the_header_layer_class() . emulsion_template_part_names_class( __FILE__ ) ?>">
	<?php
	$current_post_type = trim( get_post_type() );

	if ( has_post_thumbnail() &&
			'yes' == get_theme_mod( 'emulsion_title_in_header', emulsion_theme_default_val( 'emulsion_title_in_header' ) ) &&
			is_singular( array( $current_post_type ) ) &&
			! post_password_required( $post ) ) {
		?><div class="post-featured-image"><?php the_post_thumbnail(); //get_the_post_thumbnail ?></div><?php
	} else {

		false !== emulsion_home_type() && ! is_paged() ? the_custom_header_markup() : '';
	}

	emulsion_site_text_markup();

	emulsion_the_theme_supports( 'title_in_page_header' ) ? emulsion_entry_text_markup() : '';

	do_action( 'emulsion_append_header_layer' );

	emulsion_search_drawer();
	?>
</header>
	<?php
	if ( emulsion_the_theme_supports( 'primary_menu' ) 
			&& ( ! is_singular() 
			|| is_page() && true == emulsion_metabox_display_control( 'page_menu' ) 
			|| is_single() && true == emulsion_metabox_display_control( 'menu' ) ) ) {
		?>
	<div class="<?php echo esc_attr( emulsion_element_classes( 'primary' ) ); ?>"> 
		<input type="checkbox" id="primary-menu-controll" name="primary-menu-controll" data-skin="hamburger" data-mod="button" /><label for="primary-menu-controll"><span tabindex="0"></span></label><?php
	$emulsion_menu_args = array(
		'menu_class'	 => 'menu wp-nav-menu primary',
		'container'		 => 'nav',
		'fallback_cb'	 => '',
		'link_before'	 => '',
		'link_after'	 => '',
		'echo'			 => true,
		'depth'			 => 0,
		'theme_location' => 'primary',
		'items_wrap'	 => '<h2 class="screen-reader-text">' . esc_html__( 'Primary navigation', 'emulsion' ) . '</h2><ul id="%1$s" class="%2$s" data-direction="horizontal" >%3$s</ul>',
		'walker'		 => '',
		'item_spacing'	 => 'discard',
	);//data-type="accordion"
	wp_nav_menu( $emulsion_menu_args );
	?>
		<div class="menu-placeholder"><?php
		do_action( 'emulsion_header_menu_placeholder' );
		if ( emulsion_the_theme_supports( 'toc' ) ) {
			print '<div class="toc"></div>';
		}
		?></div>
	</div>
	<?php
		}
		?>