<?php

$emulsion_image_uri				 = get_template_directory_uri() . '/images/demo.jpg';

$emulsion_column_title_1 = esc_html__( 'WordPress', 'emulsion' );
$emulsion_column_p_1	 = esc_html__( 'This theme supports both block editor and classic editor', 'emulsion' );
$emulsion_column_title_2 = esc_html__( 'Customize Support', 'emulsion' );
$emulsion_column_p_2	 = esc_html__( 'This theme supports both block editor and classic editor', 'emulsion' );
$emulsion_column_title_3 = esc_html__( 'Accessible', 'emulsion' );
$emulsion_column_p_3	 = esc_html__( 'Infinite color scheme and contrast function ensure readability', 'emulsion' );

$emulsion_link_text = esc_html__( 'link', 'emulsion' );

$emulsion_lorem_text = esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'emulsion' );

$html = <<<HTML

<!-- wp:columns {"align":"wide","style":{"spacing":{"margin":{"top":"1.5rem","bottom":"1.5rem"}}},"className":"emulsion-cta-block"} -->
<div class="wp-block-columns alignwide emulsion-cta-block" style="margin-top:1.5rem;margin-bottom:1.5rem"><!-- wp:column {"style":{"spacing":{"padding":{"top":"6px","right":"6px","bottom":"6px","left":"6px"}}}} -->
<div class="wp-block-column" style="padding-top:6px;padding-right:6px;padding-bottom:6px;padding-left:6px"><!-- wp:image {"id":90942,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="{$emulsion_image_uri}" alt="" class="wp-image-90942"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3>{$emulsion_column_title_1}</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>{$emulsion_column_p_1}</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"is-style-has-shadow"} -->
<div class="wp-block-buttons is-style-has-shadow"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link">Link to</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"6px","right":"6px","bottom":"6px","left":"6px"}}}} -->
<div class="wp-block-column" style="padding-top:6px;padding-right:6px;padding-bottom:6px;padding-left:6px"><!-- wp:image {"id":90942,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="{$emulsion_image_uri}" alt="" class="wp-image-90942"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3} -->
<h3>{$emulsion_column_title_2}</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>{$emulsion_column_p_2} </p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"is-style-has-shadow"} -->
<div class="wp-block-buttons is-style-has-shadow"><!-- wp:button {"backgroundColor":"light-green-cyan"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-light-green-cyan-background-color has-background">Link to</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"6px","right":"6px","bottom":"6px","left":"6px"}}}} -->
<div class="wp-block-column" style="padding-top:6px;padding-right:6px;padding-bottom:6px;padding-left:6px"><!-- wp:image {"id":90942,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="{$emulsion_image_uri}" alt="" class="wp-image-90942"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"align":"","className":""} -->
<h3>{$emulsion_column_title_3}</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>{$emulsion_column_p_3}</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"is-style-has-shadow"} -->
<div class="wp-block-buttons is-style-has-shadow"><!-- wp:button {"backgroundColor":"vivid-purple"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-vivid-purple-background-color has-background">Link to</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:heading {"align":"wide"} -->
<h2 class="alignwide">Sticky Posts</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":15,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"only","inherit":false},"displayLayout":{"type":"flex","columns":3},"align":"full","className":"pattern-sticky-posts"} -->
<div class="wp-block-query alignfull pattern-sticky-posts"><!-- wp:post-template {"className":"alignwide"} -->
<!-- wp:group {"tagName":"article","className":"post loop-item","layout":{"inherit":true}} -->
<article class="wp-block-group post loop-item"><!-- wp:group {"tagName":"header","className":"post-header","layout":{"inherit":true}} -->
<header class="wp-block-group post-header"><!-- wp:group {"className":"post-header-content","layout":{"inherit":true}} -->
<div class="wp-block-group post-header-content"><!-- wp:post-title {"isLink":true} /--></div>
<!-- /wp:group --></header>
<!-- /wp:group -->

<!-- wp:post-featured-image /-->

<!-- wp:post-excerpt /--></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query -->

<!-- wp:group {"layout":{"inherit":true,"type":"constrained"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60"}},"color":{"background":"#eee8e8"}},"textColor":"black","className":"is-style-call-to-action"} -->
<div class="wp-block-group alignfull is-style-call-to-action has-black-color has-text-color has-background" style="background-color:#eee8e8;padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60)"><!-- wp:heading {"textAlign":"center","textColor":"black"} -->
<h2 class="has-text-align-center has-black-color has-text-color">call to Action</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"emulsion-black"} -->
<p class="has-emulsion-black-color has-text-color">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.&nbsp;</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"vivid-red","textColor":"white","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-vivid-red-background-color has-text-color has-background wp-element-button" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">CTA Button</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->


<!-- wp:media-text {"align":"full","mediaLink":"https://www.tenman.info/wp-37/wp-content/themes/emulsion/images/demo.jpg","mediaType":"image","backgroundColor":"luminous-vivid-amber"} -->
<div class="wp-block-media-text alignfull is-stacked-on-mobile has-luminous-vivid-amber-background-color has-background"><figure class="wp-block-media-text__media"><img src="https://www.tenman.info/wp-37/wp-content/themes/emulsion/images/demo.jpg" alt="alt"/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"level":3,"placeholder":"Title","align":"center"} -->
<h3>Block pattern support</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:media-text -->


<!-- wp:media-text {"align":"full","mediaPosition":"right","mediaLink":"https://www.tenman.info/wp-37/wp-content/themes/emulsion/images/demo.jpg","mediaType":"image","backgroundColor":"light-green-cyan"} -->
<div class="wp-block-media-text alignfull has-media-on-the-right is-stacked-on-mobile has-light-green-cyan-background-color has-background"><figure class="wp-block-media-text__media"><img src="https://www.tenman.info/wp-37/wp-content/themes/emulsion/images/demo.jpg" alt="alt"/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"level":3,"placeholder":"Title","align":"center"} -->
<h3>Block pattern support</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:media-text -->

<!-- wp:heading {"align":"wide"} -->
<h2 class="alignwide">latest posts</h2>
<!-- /wp:heading -->

<!-- wp:latest-posts {"displayPostContent":true,"displayAuthor":true,"displayPostDate":true,"postLayout":"grid","displayFeaturedImage":true,"featuredImageSizeSlug":"medium","align":"wide"} /-->

<!-- wp:group {"layout":{"contentSize":"1170px","type":"constrained"},"align":"full","className":"our-team-team-member-our-client-section-desing-with-image-social-media", "style":{"spacing":{"padding":{"top":"70px","right":"30px","bottom":"40px","left":"30px"}},"color":{"background":"#09005c"}}} -->
<div class="wp-block-group alignfull has-background our-team-team-member-our-client-section-desing-with-image-social-media" style="background-color:#09005c;padding-top:70px;padding-right:30px;padding-bottom:40px;padding-left:30px"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","style":{"typography":{"textTransform":"uppercase","fontStyle":"normal","fontWeight":"700","lineHeight":"1"}},"textColor":"white"} -->
<h2 class="has-text-align-center has-white-color has-text-color" style="font-style:normal;font-weight:700;line-height:1;text-transform:uppercase">Meet Our Team</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"16px"}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-size:16px">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor <br>exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide","style":{"spacing":{"padding":{"top":"15px"}}}} -->
<div class="wp-block-columns alignwide" style="padding-top:15px"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"border":{"radius":"15px"},"spacing":{"padding":{"top":"30px","right":"30px","bottom":"35px","left":"30px"}}},"backgroundColor":"white"} -->
<div class="wp-block-group has-white-background-color has-background" style="border-radius:15px;padding-top:30px;padding-right:30px;padding-bottom:35px;padding-left:30px"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"30px"}}} -->
<figure class="wp-block-image size-full has-custom-border"><img src="https://pd.w.org/2021/12/67761b1e1e369a0c5.15366783.jpeg" alt="" style="border-radius:30px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":4,"style":{"typography":{"textTransform":"capitalize","fontSize":"26px","fontStyle":"normal","fontWeight":"600"}}} -->
<h4 class="has-text-align-center" style="font-size:26px;font-style:normal;font-weight:600;text-transform:capitalize">Devid Warner</h4>
<!-- /wp:heading -->

<!-- wp:heading {"textAlign":"center","level":6,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":".1"},"color":{"text":"#bbbbbb"}}} -->
<h6 class="has-text-align-center has-text-color" style="color:#bbbbbb;font-size:16px;font-style:normal;font-weight:400;line-height:.1">Founder of Company</h6>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"16px"},"color":{"text":"#666666"}}} -->
<p class="has-text-align-center has-text-color" style="color:#666666;font-size:16px">Lorem ipsum dolor sit amet, <br>consectetur adipiscing elit, <br>sed do eiusmod </p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"style":{"spacing":{"blockGap":{"top":"10px","left":"10px"}}},"className":"is-style-logos-only","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
<ul class="wp-block-social-links is-style-logos-only"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"border":{"radius":"15px"},"spacing":{"padding":{"top":"30px","right":"30px","bottom":"35px","left":"30px"}}},"backgroundColor":"white"} -->
<div class="wp-block-group has-white-background-color has-background" style="border-radius:15px;padding-top:30px;padding-right:30px;padding-bottom:35px;padding-left:30px"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"30px"}},"className":"is-style-default"} -->
<figure class="wp-block-image size-full has-custom-border is-style-default"><img src="https://img.rawpixel.com/s3fs-private/rawpixel_images/website_content/a005-scottw-610.jpg?w=1200&amp;h=1200&amp;fit=clip&amp;crop=default&amp;dpr=1&amp;q=75&amp;vib=3&amp;con=3&amp;usm=15&amp;cs=srgb&amp;bg=F4F4F3&amp;ixlib=js-2.2.1&amp;s=30cfcba5e1e5e25a1cd2852b5c446ea1" alt="" style="border-radius:30px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":4,"style":{"typography":{"textTransform":"capitalize","fontSize":"26px","fontStyle":"normal","fontWeight":"600"}}} -->
<h4 class="has-text-align-center" style="font-size:26px;font-style:normal;font-weight:600;text-transform:capitalize">Nike Sily</h4>
<!-- /wp:heading -->

<!-- wp:heading {"textAlign":"center","level":6,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":".1"},"color":{"text":"#bbbbbb"}}} -->
<h6 class="has-text-align-center has-text-color" style="color:#bbbbbb;font-size:16px;font-style:normal;font-weight:400;line-height:.1">Manager of Company</h6>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"16px"},"color":{"text":"#666666"}}} -->
<p class="has-text-align-center has-text-color" style="color:#666666;font-size:16px">Lorem ipsum dolor sit amet, <br>consectetur adipiscing elit, <br>sed do eiusmod </p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"style":{"spacing":{"blockGap":{"top":"10px","left":"10px"}}},"className":"is-style-logos-only","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
<ul class="wp-block-social-links is-style-logos-only"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"border":{"radius":"15px"},"spacing":{"padding":{"top":"30px","right":"30px","bottom":"35px","left":"30px"}}},"backgroundColor":"white"} -->
<div class="wp-block-group has-white-background-color has-background" style="border-radius:15px;padding-top:30px;padding-right:30px;padding-bottom:35px;padding-left:30px"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"30px"}},"className":"is-style-default"} -->
<figure class="wp-block-image size-full has-custom-border is-style-default"><img src="https://img.rawpixel.com/s3fs-private/rawpixel_images/website_content/a010-markusspiske-oct18-069.jpg?w=1200&amp;h=1200&amp;fit=clip&amp;crop=default&amp;dpr=1&amp;q=75&amp;vib=3&amp;con=3&amp;usm=15&amp;cs=srgb&amp;bg=F4F4F3&amp;ixlib=js-2.2.1&amp;s=9985cccf4148ba19d4707142ac5798e2" alt="" style="border-radius:30px"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":4,"style":{"typography":{"textTransform":"capitalize","fontSize":"26px","fontStyle":"normal","fontWeight":"600"}}} -->
<h4 class="has-text-align-center" style="font-size:26px;font-style:normal;font-weight:600;text-transform:capitalize">John Duo</h4>
<!-- /wp:heading -->

<!-- wp:heading {"textAlign":"center","level":6,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","lineHeight":".1"},"color":{"text":"#bbbbbb"}}} -->
<h6 class="has-text-align-center has-text-color" style="color:#bbbbbb;font-size:16px;font-style:normal;font-weight:400;line-height:.1">Designer of Company</h6>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"16px"},"color":{"text":"#666666"}}} -->
<p class="has-text-align-center has-text-color" style="color:#666666;font-size:16px">Lorem ipsum dolor sit amet, <br>consectetur adipiscing elit, <br>sed do eiusmod </p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"style":{"spacing":{"blockGap":{"top":"10px","left":"10px"}}},"className":"is-style-logos-only","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
<ul class="wp-block-social-links is-style-logos-only"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3>Various layout functions</h3>
<!-- /wp:heading -->


<!-- wp:image {"align":"left","sizeSlug":"large","linkDestination":"none","className":"is-style-shrink"} -->
<figure class="wp-block-image alignleft size-large is-style-shrink"><img src="{$emulsion_image_uri}" alt="alt" class="wp-image-76879"/><figcaption class="wp-element-caption">align offset zero image</figcaption></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>{$emulsion_lorem_text}</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>{$emulsion_lorem_text}</p>
<!-- /wp:paragraph -->

<!-- wp:table {"backgroundColor":"pale-cyan-blue","textColor":"black","className":"is-style-stripes"} -->
<figure class="wp-block-table is-style-stripes"><table class="has-black-color has-pale-cyan-blue-background-color has-text-color has-background"><thead><tr><th>Coffee</th><th>Taste</th></tr></thead><tbody><tr><td>Kilimanjaro</td><td>strong acidity</td></tr><tr><td>Guatemalan</td><td>acidity</td></tr><tr><td>mocha</td><td>unique strong acidity</td></tr></tbody><tfoot><tr><td>---</td><td>---</td></tr></tfoot></table><figcaption class="wp-element-caption">table</figcaption></figure>
<!-- /wp:table -->

<!-- wp:paragraph -->
<p>{$emulsion_lorem_text}</p>
<!-- /wp:paragraph -->



<!-- wp:paragraph -->
<p>{$emulsion_lorem_text}</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"0.75rem","right":"0.75rem","bottom":"0.75rem","left":"0.75rem"}}},"className":"alignfull has-black-background-color has-background gallery-light-box"} -->
<div class="wp-block-group alignfull has-black-background-color has-background gallery-light-box" style="padding-top:0.75rem;padding-right:0.75rem;padding-bottom:0.75rem;padding-left:0.75rem">
	<!-- wp:gallery {"linkTo":"none","align":"wide"} -->
<figure class="wp-block-gallery alignwide has-nested-images columns-default is-cropped"><!-- wp:image {"id":90939,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="{$emulsion_image_uri}" alt="" class="wp-image-90939"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":99999,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="{$emulsion_image_uri}" alt="" class="wp-image-99999"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":99999,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="{$emulsion_image_uri}" alt="" class="wp-image-99999"/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery -->

<!-- wp:gallery {"columns":5,"linkTo":"none","align":"wide"} -->
<figure class="wp-block-gallery alignwide has-nested-images columns-5 is-cropped">
<!-- wp:image {"id":99999,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="{$emulsion_image_uri}" alt="" class="wp-image-99999"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":99999,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="{$emulsion_image_uri}" alt="" class="wp-image-99999"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":99999,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="{$emulsion_image_uri}" alt="" class="wp-image-99999"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":99999,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="{$emulsion_image_uri}" alt="" class="wp-image-99999"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":99999,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="{$emulsion_image_uri}" alt="" class="wp-image-99999"/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery --></div>
<!-- /wp:group -->


<!-- wp:paragraph -->
<p>{$emulsion_lorem_text}</p>
<!-- /wp:paragraph -->

<!-- wp:social-links -->
<ul class="wp-block-social-links"><!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"wordpress"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:post-comments {"className":"comment-wrapper"} /-->
HTML;

$html = str_replace( array( PHP_EOL, "\t" ), array( '', '' ), $html );

return $html;
