<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php
		wp_body_open();
		emulsion_block_template_part( 'header' );
		is_user_logged_in() ? printf( '<p style="background:#000;color:#fff">%1$s</p>', 'load PHP template:emulsion/template-parts/template-fse.php' ) : '';
		emulsion_block_template_part( 'query-post' );
		emulsion_block_template_part( 'footer' );
		?>
	</body>
</html>

