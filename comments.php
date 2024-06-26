<?php
/**
 * Theme emulsion
 * comments template part file
 */

?><div class="comments" id="comments">
	<?php if ( post_password_required() ) { ?>
		<p class="nopassword">
			<?php esc_html_e( 'This post is password protected.', 'emulsion' ); ?>
			<?php esc_html_e( 'Enter the password to view any comments.', 'emulsion' ); ?>
		</p>
	</div>
	<?php return; ?>
<?php } ?>
<?php
if ( is_singular() ) {
	$emulsion_post_id = absint( get_the_ID() );
	if ( have_comments() && comments_open( $emulsion_post_id ) ) {
		?>
		<div id="comments" class="clear social">
			<ol class="wp-list-comments"><?php
				wp_list_comments(
					array(
						'avatar_size' => 64,
					)
				)
				?></ol>
			<div class="paginate-comment-links"><?php	paginate_comments_links(); ?></div>
		</div>
	<?php }
}
	comment_form();
 ?>
</div>