<?php
$emulsion_image_uri = get_template_directory_uri().'/images/demo.jpg';
$emulsion_welcome_message = esc_html__( 'Welcome to the theme emulsion', 'emulsion' );
$emulsion_welcome_message_p_1 = esc_html__( 'The emulsion theme is a block editor support theme. Of course, it also supports the classic editor', 'emulsion' );
$emulsion_welcome_message_p_2 = esc_html__( 'From light background colors to dark themes, you can customize the best', 'emulsion' );

$emulsion_column_title_1 = esc_html__( 'WordPress', 'emulsion' );
$emulsion_column_p_1 = esc_html__( 'This theme supports both block editor and classic editor', 'emulsion' );
$emulsion_column_title_2 = esc_html__( 'Customize Support', 'emulsion' );
$emulsion_column_p_2 = esc_html__( 'This theme supports both block editor and classic editor', 'emulsion' );
$emulsion_column_title_3 = esc_html__( 'Accessible', 'emulsion' );
$emulsion_column_p_3 = esc_html__( 'Infinite color scheme and contrast function ensure readability', 'emulsion' );

$emulsion_link_text = esc_html__( 'link', 'emulsion' );

$emulsion_lorem_text = esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'emulsion');

$html = <<<HTML
<!-- wp:group {"align":"full","style":{"color":{"gradient":"linear-gradient(115deg,rgb(7,7,7) 0%,rgb(0,0,0) 44%,rgb(0,0,0) 53%,rgb(238,238,238) 53%,rgb(238,238,238) 100%)"}}} -->
<div class="wp-block-group alignfull has-background" style="background:linear-gradient(115deg,rgb(7,7,7) 0%,rgb(0,0,0) 44%,rgb(0,0,0) 53%,rgb(238,238,238) 53%,rgb(238,238,238) 100%)">
	<div class="wp-block-group__inner-container">

		<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":45,"lineHeight":"1.15"}},"className":"alignwide"} -->
		<p class="has-text-align-center alignwide" style="font-size:45px;line-height:1.15">$emulsion_welcome_message</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph -->
		<p>{$emulsion_welcome_message_p_1}</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph -->
		<p>{$emulsion_welcome_message_p_2}</p>
		<!-- /wp:paragraph -->

	</div>
</div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","className":"emulsion-cta-block"} -->
<div class="wp-block-columns alignwide emulsion-cta-block"><!-- wp:column {"className":"mark-info"} -->

	<div class="wp-block-column mark-info">

		<!-- wp:image {"id":76367,"sizeSlug":"large","linkDestination":"none"} -->

		<figure class="wp-block-image size-large">
			<img src="{$emulsion_image_uri}" alt="alt" class="wp-image-76367"/>
		</figure>

		<!-- /wp:image -->

		<!-- wp:heading {"textAlign":"center","level":3,"placeholder":"Title"} -->

		<h3 class="has-text-align-center">{$emulsion_column_title_1}</h3>

		<!-- /wp:heading -->

		<!-- wp:paragraph {"placeholder":"description"} -->

		<p>{$emulsion_column_p_1}</p>

		<!-- /wp:paragraph -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button -->
			<div class="wp-block-button">
				<a class="wp-block-button__link">{$emulsion_link_text}</a>
			</div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"className":"mark-notice"} -->
	<div class="wp-block-column mark-notice">

		<!-- wp:image {"id":76367,"sizeSlug":"large","linkDestination":"none"} -->

		<figure class="wp-block-image size-large">
			<img src="{$emulsion_image_uri}" alt="alt" class="wp-image-76367"/>
		</figure>

		<!-- /wp:image -->

		<!-- wp:heading {"textAlign":"center","level":3,"placeholder":"Title"} -->

		<h3 class="has-text-align-center">{$emulsion_column_title_2}</h3>

		<!-- /wp:heading -->

		<!-- wp:paragraph {"placeholder":"description"} -->

		<p>Detailed function settings by emulsion-addons plug-in</p>

		<!-- /wp:paragraph -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">

			<!-- wp:button -->

			<div class="wp-block-button">
				<a class="wp-block-button__link">{$emulsion_link_text}</a>
			</div>

			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>

	<!-- /wp:column -->

	<!-- wp:column {"className":"mark-cool"} -->
	<div class="wp-block-column mark-cool">

		<!-- wp:image {"id":76367,"sizeSlug":"large","linkDestination":"none"} -->
		<figure class="wp-block-image size-large">
			<img src="{$emulsion_image_uri}" alt="alt" class="wp-image-76367"/>
		</figure>
		<!-- /wp:image -->

		<!-- wp:heading {"textAlign":"center","level":3,"placeholder":"Title"} -->
		<h3 class="has-text-align-center">{$emulsion_column_title_3}</h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"placeholder":"description"} -->
		<p>{$emulsion_column_p_3}</p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons"><!-- wp:button -->
		<div class="wp-block-button"><a class="wp-block-button__link">{$emulsion_link_text}</a></div>
		<!-- /wp:button --></div>
		<!-- /wp:buttons --></div>
	<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"align":"full","className":"grid"} -->
<div class="wp-block-group alignfull grid">
	<div class="wp-block-group__inner-container">
		<!-- wp:group {"className":"size1of2"} -->
		<div class="wp-block-group size1of2">
			<div class="wp-block-group__inner-container">
				<!-- wp:image {"align":"full","id":76879,"sizeSlug":"large","linkDestination":"none"} -->
				<figure class="wp-block-image alignfull size-large">
					<img src="{$emulsion_image_uri}" alt="alt" class="wp-image-76879"/>
				</figure>
				<!-- /wp:image -->
			</div>
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"size1of2 centered"} -->
		<div class="wp-block-group size1of2 centered">
			<div class="wp-block-group__inner-container">
				<!-- wp:heading {"level":3,"placeholder":"Title","align":"center"} -->
				<h3>Block pattern support</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"align":"left","placeholder":"description"} -->
				<p class="has-text-align-left">{$emulsion_lorem_text}</p>
				<!-- /wp:paragraph -->
			</div>
		</div>
		<!-- /wp:group -->
	</div>
</div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3>Various layout functions</h3>
<!-- /wp:heading -->

<!-- wp:image {"align":"left","id":76879,"sizeSlug":"large","linkDestination":"none","className":"is-style-circle-mask"} -->
<div class="wp-block-image is-style-circle-mask">
	<figure class="alignleft size-large">
		<img src="{$emulsion_image_uri}" alt="alt" class="wp-image-76879"/>
		<figcaption>Circle mask image</figcaption>
	</figure></div>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>{$emulsion_lorem_text}</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>{$emulsion_lorem_text}</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>{$emulsion_lorem_text}</p>
<!-- /wp:paragraph -->

<!-- wp:image {"align":"right","id":76879,"sizeSlug":"large","linkDestination":"none","className":"is-style-shrink"} -->
<div class="wp-block-image is-style-shrink">
	<figure class="alignright size-large">
		<img src="{$emulsion_image_uri}" alt="alt" class="wp-image-76879"/>
		<figcaption>align offset zero image</figcaption>
	</figure>
</div>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>{$emulsion_lorem_text}</p>
<!-- /wp:paragraph -->
HTML;

$html = str_replace( array( PHP_EOL, "\t" ), array( '', '' ), $html );

return $html;
