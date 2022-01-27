<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php
		wp_body_open();
		is_user_logged_in() ? printf( '<p>%1$s</p>','load PHP template:template-fse.php' ):'';
		emulsion_block_template_part( 'header' );
		emulsion_block_template_part( 'query-post' );
		emulsion_block_template_part( 'footer' );
		?>
	</body>
</html>

