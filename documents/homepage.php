<table class="form-table">
	<tr>
		<th style="border:1px solid #ccc;text-align:center;"><?php esc_html_e( 'Theme', 'emulsion' ); ?></th>
		<td style="border:1px solid #ccc"><?php emulsion_theme_info( 'Name' ); ?></td>
	</tr>
	<tr>
		<th style="border:1px solid #ccc;text-align:center;"><?php esc_html_e( 'Version', 'emulsion' ); ?></th>
		<td style="border:1px solid #ccc"><?php emulsion_theme_info( 'Version' ); ?></td>
	</tr>
	<tr>
		<th style="border:1px solid #ccc;text-align:center;"><?php esc_html_e( 'Theme Home Page', 'emulsion' ); ?></th>
		<td style="border:1px solid #ccc"><a href="<?php echo esc_url( emulsion_theme_info( 'ThemeURI', false ) ); ?>"><?php echo esc_url( emulsion_theme_info( 'ThemeURI', false ) ); ?></a></td>
	</tr>
	<tr>
		<th style="border:1px solid #ccc;text-align:center;">Reports bug, any questions</th>
		<td style="border:1px solid #ccc"><?php printf('<a href="%1$s">%1$s</a>', 'https://wordpress.org/support/theme/emulsion/' );?></td>
	</tr>
	<tr>
		<th style="border:1px solid #ccc;text-align:center;"><?php esc_html_e( 'Minimum PHP version', 'emulsion' ); ?></th>
		<td style="border:1px solid #ccc">PHP<?php echo esc_html( EMULSION_MIN_PHP_VERSION ); ?></td>
	</tr>
</table>

<h2><?php esc_html_e( 'Theme-specific features', 'emulsion' ); ?></h2>
<h3><?php esc_html_e( 'Social menu', 'emulsion' ); ?></h3>
<p><?php esc_html_e( 'Social menu supports phone links and email links', 'emulsion' ); ?></p>
<p><?php esc_html_e( 'These features are closely related to your privacy protection. Please use it after careful consideration', 'emulsion' ); ?></p>
<p><?php esc_html_e( 'The telephone number is displayed on the PC browser, but the link does not work. The link works only when access from a mobile browser is detected.', 'emulsion' ); ?></p>

<h3><?php esc_html_e( 'Auto Contrast', 'emulsion' ); ?></h3>
<p><?php esc_html_e( 'This theme will automatically set the text color suitable for the background color setting you made', 'emulsion' ); ?></p>
<p><?php esc_html_e( 'For example, if a shortcode or plug-in has a background color, try to keep it as readable as possible, but it is not perfect', 'emulsion' ); ?></p>
<p><?php esc_html_e( 'If you have any problems, please contact the above support', 'emulsion' ); ?></p>

<h3><?php esc_html_e( 'Dark Mode', 'emulsion' ); ?></h3>
<p><?php esc_html_e('It is not enabled by default, but can be enabled by changing the EMULSION_DARK_MODE_SUPPORT constant in lib / config.php to true.', 'emulsion'); ?></p>

<h3><?php printf('<a href="%1$s">%2$s</a>', esc_url('https://www.tenman.info/wp3/emulsion/en/2019/12/27/accsessibility-ui-2/'), esc_html__('Accessibility', 'emulsion' ) ); ?></h3>
<p><?php esc_html_e( 'Themes have a tab navigation feature for accessibility', 'emulsion'); ?></p>
