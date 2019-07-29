<table class="form-table">
<tr>
	<th style="border:1px solid #ccc;text-align:center;"><?php esc_html_e('Theme', 'emulsion') ?></th>
	<td style="border:1px solid #ccc"><?php emulsion_theme_info( 'Name' ); ?></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:center;"><?php esc_html_e('Version', 'emulsion'); ?></th>
	<td style="border:1px solid #ccc"><?php emulsion_theme_info( 'Version' ); ?></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:center;"><?php esc_html_e('Theme Home Page', 'emulsion'); ?></th>
	<td style="border:1px solid #ccc"><a href="<?php echo esc_url(emulsion_theme_info( 'AuthorURI',false )); ?>"><?php echo esc_url( emulsion_theme_info( 'AuthorURI',false )); ?></a></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:center;">Reports bug, any questions</th>
	<td style="border:1px solid #ccc"><a href="https://wordpress.org/support/theme/emulsion/">https://wordpress.org/support/theme/emulsion/</a></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:center;"><?php esc_html_e('Minimum PHP version', 'emulsion'); ?></th>
	<td style="border:1px solid #ccc">PHP5.6</td>
</tr>
</table>

