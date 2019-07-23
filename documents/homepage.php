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
<tr>
	<th style="border:1px solid #ccc;text-align:center;"><?php esc_html_e('Changes', 'emulsion'); ?></th>
	<td style="border:1px solid #ccc">
		<ul>
			<li><a href="<?php echo esc_url( get_theme_file_uri( '/changelog.txt' ) );?>">change log</a></li>
			<li><a href="https://themes.trac.wordpress.org/search?q=emulsion">Theme Trac</a></li>
		</ul>
	</td>
</tr>
</table>

