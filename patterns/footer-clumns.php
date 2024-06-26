<?php
/**
 * Title: Columns footer
 * Slug: emulsion/footer-columns
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
<!-- wp:group {"tagName":"div","layout":{"type":"default"},"align":"full","className":"emulsion-columns-footer"} -->
<div class="wp-block-group alignfull emulsion-columns-footer"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"0","bottom":"var:preset|spacing|50","left":"0"}}},"className":"alignwide"} -->
<div class="wp-block-columns alignwide" style="padding-top:var(--wp--preset--spacing--50);padding-right:0;padding-bottom:var(--wp--preset--spacing--50);padding-left:0"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:site-title {"level":4,"style":{"typography":{"fontSize":"30px"}}} /-->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"}}} -->
<p style="font-size:16px">Lorem ipsum dolor sit amet, consectetur ut labore et dolore magna aliqua ipsum dolor sit</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"iconColor":"vivid-cyan-blue","iconColorValue":"#0693e3","openInNewTab":true,"style":{"spacing":{"blockGap":{"top":"15px","left":"15px"}}},"className":"is-style-logos-only","layout":{"type":"flex","justifyContent":"center"}} -->
<ul class="wp-block-social-links has-icon-color is-style-logos-only"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":4,"style":{"typography":{"textTransform":"capitalize","fontStyle":"normal","fontWeight":"700","fontSize":"30px"}}} -->
<h4 style="font-size:30px;font-style:normal;font-weight:700;text-transform:capitalize">Contact Us</h4>
<!-- /wp:heading -->

<!-- wp:list {"style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}},"className":"is-style-list-style-none"} -->
<ul class="is-style-list-style-none" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0"><!-- wp:list-item -->
<li>123 BD Lorem, Ipsum</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>+123-456-7890</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>sample@gmail.com</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Opening Hours: 10:00 - 18:00</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"30px","fontStyle":"normal","fontWeight":"700","textTransform":"capitalize"}}} -->
<h4 style="font-size:30px;font-style:normal;font-weight:700;text-transform:capitalize">Newsletter</h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"}}} -->
<p style="font-size:16px">Lorem ipsum dolor sit amet, consectetur ut labore et dolore magna aliqua ipsum dolor sit</p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"","showLabel":false,"placeholder":"Enter Your Email...","width":100,"widthUnit":"%","buttonText":"Subscribe"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- wp:pattern {"slug":"emulsion/copyright-notice"} /--></div>
<!-- /wp:group -->