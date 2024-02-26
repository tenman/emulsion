<?php
/**
 * Title: Copyright Notice
 * Slug: emulsion/copyright-notice
 * Categories: footer,emulsion
 * Viewport Width: 1280
 * Block Types: core/template-part/footer
 * Inserter: yes
 * Keywords: emulsion
 * Description: emulsion
 */
$current_year		 = date( 'Y' );
$privacy_policy_url	 = esc_url( get_privacy_policy_url() );
$privacy_policy_text = esc_html__( 'Privacy policy', 'emulsion' );
?>
<!-- wp:paragraph {"align":"center","className":"copyright-notice"} -->
<p class="has-text-align-center copyright-notice">Copyright © <?php echo $current_year; ?> Site proudly powered by WordPress <a href="<?php echo $privacy_policy_url; ?>"><?php echo $privacy_policy_text; ?></a></p>
<!-- /wp:paragraph -->
