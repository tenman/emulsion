
<h2> Template Tags </h2>
<a href="https://developer.wordpress.org/themes/basics/template-hierarchy/">Template Hierarchy</a>
<p>Once you understand Template Hierarchy, this theme is more flexible and configurable.</p>
<table class="form-table">
<tr>
	<th style="border:1px solid #ccc;text-align:center;"><?php esc_html_e('Template Tag Name', 'emulsion'); ?></th>
	<td style="border:1px solid #ccc"><?php esc_html_e('Description', 'emulsion'); ?></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:left;"><pre><code>&lt;?php emulsion_remove_supports( 'enqueue' ); ?&gt;</code></pre></th>
	<td style="border:1px solid #ccc"><?php esc_html_e('Remove All theme styles and scripts', 'emulsion'); ?></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:left;"><pre><code>&lt;?php emulsion_remove_supports( 'primary_menu' ) ?&gt;</code></pre></th>
	<td style="border:1px solid #ccc"><?php esc_html_e('Remove Primary Menu', 'emulsion'); ?></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:left;"><pre><code>&lt;?php emulsion_remove_supports( 'sidebar' ) ?&gt;</code></pre></th>
	<td style="border:1px solid #ccc"><?php esc_html_e('Remove Post Sidebar', 'emulsion'); ?></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:left;"><pre><code>&lt;?php emulsion_remove_supports( 'sidebar_page' ) ?&gt;</code></pre></th>
	<td style="border:1px solid #ccc"><?php esc_html_e('Remove Page Sidebar', 'emulsion'); ?></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:left;"><pre><code>&lt;?php emulsion_remove_supports( 'relate_posts' ) ?&gt;</code></pre></th>
	<td style="border:1px solid #ccc"><?php esc_html_e('Remove Relate Posts Block', 'emulsion'); ?></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:left;"><pre><code>&lt;?php emulsion_remove_supports( 'search_drawer' ) ?&gt;</code></pre></th>
	<td style="border:1px solid #ccc"><?php esc_html_e('Remove Search Drawer', 'emulsion'); ?></td>
</tr>
<tr>
	<th style="border:1px solid #ccc;text-align:left;"><pre><code>&lt;?php emulsion_remove_supports( 'header' ) ?&gt;</code></pre></th>
	<td style="border:1px solid #ccc"><?php esc_html_e('Remove Site Header', 'emulsion'); ?></td>
</tr>
<tr>
	
	<td style="border:1px solid #ccc" colspan="2">
		<?php esc_html_e( 'Please check lib / theme-supports.php and template-page / blank.php for details.', 'emulsion' ); ?>
	</td>
</tr>
</table>
