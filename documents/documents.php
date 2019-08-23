<?php
add_action( 'admin_menu', 'emulsion_settings_page_init' );

locate_template( 'lib/validate.php', true, true );

/**
 * Create Page
 */
function emulsion_settings_page_init() {

	$theme_name		 = emulsion_theme_info( 'Name', false );
	$settings_page	 = add_theme_page( $theme_name . ' Documents', $theme_name . ' Documents', 'edit_theme_options', 'theme-settings', 'emulsion_settings_page' );

	if ( $settings_page ) {
		add_action( 'admin_print_styles-' . $settings_page, 'emulsion_document_style', 99 );
	}


}

/**
 * Page CSS
 */
function emulsion_document_style() {

	$css = <<<CSS
		.admin-color-fresh,
		.admin-color-default{
			--thm_emulsion-accent-bg:#222;
			--thm_emulsion-accent-fg:#fff;
		}
		.admin-color-light{
			--thm_emulsion-accent-bg:#e5e5e5;
			--thm_emulsion-accent-fg:#333;
		}
		.admin-color-blue{
			--thm_emulsion-accent-bg:#52accc;
			--thm_emulsion-accent-fg:#fff;
		}
		.admin-color-coffee{
			--thm_emulsion-accent-bg:#59524c;
			--thm_emulsion-accent-fg:#fff;
		}
		.admin-color-ectoplasm{
			--thm_emulsion-accent-bg:#523f6d;
			--thm_emulsion-accent-fg:#fff;
		}
		.admin-color-midnight{
			--thm_emulsion-accent-bg:#363b3f;
			--thm_emulsion-accent-fg:#fff;
		}
		.admin-color-ocean{
			--thm_emulsion-accent-bg:#738e96;
			--thm_emulsion-accent-fg:#fff;
		}
		.admin-color-sunrise{
			--thm_emulsion-accent-bg:#cf4944;
			--thm_emulsion-accent-fg:#fff;
		}

		div#wpcontent{
			padding-left:0;
		}
		#wpbody-content .emulsion-document{
			width:auto;
			max-width:100%;
			margin-left:auto;
			margin-right:auto;
			font-size:13px;
			
		}
		.emulsion-document header{
			
		}
		.emulsion-document footer{
			text-align:center;
			padding:1.5rem 1.5rem .75rem;
			
		}
		.emulsion-document .nav-tab-wrapper{
			margin-left:1rem;
			margin-right:1rem;
		}
		.nav-tab-wrapper .nav-tab {
			float: left;
			border: 1px solid #ccc;
			border-bottom: none;
			margin-left: 0.5em; 
			padding: 5px 10px;
			font-size: 14px;
			line-height: 1.71428571;
			font-weight: 600;
			background: #fff;
			color: #555;
			text-decoration: none;
			white-space: nowrap;
		}

		.nav-tab-wrapper .nav-tab:hover,
		.nav-tab-wrapper .nav-tab:focus {
			background-color: #eee;
			color: #444;
		}
		.nav-tab-wrapper .nav-tab-active{
			background:var(--thm_emulsion-accent-bg);
			color:var(--thm_emulsion-accent-fg);
		}
		#poststuff{
			padding-left:1.5rem;
			padding-right:1.5rem;
			box-sizing:border-box;
		}
		.emulsion-document-header{
			padding:1.5rem 1.5rem .75rem;
			background:#efefef;
		}
		.emulsion-document-header h2{
			font-size:1.5rem;
		}
		.emulsion-document-table{
			margin-left:auto;
			margin-right:auto;
			width:calc(100% - 2rem);
		}
		.emulsion-document-table a{
			text-decoration:none;
		}
		.emulsion-document-table.form-table tr:nth-child(odd){
			background:#ecf0f1;
		}
		.emulsion-document-table.form-table td{
			padding:.5rem 10px;
		}
		
		.emulsion-document-table.form-table tr.item-title{	
			background:var(--thm_emulsion-accent-bg);
			
		}
		.emulsion-document-table.form-table tr.item-title th{
			text-align:center;
			color:var(--thm_emulsion-accent-fg);
			padding:.5rem;
			
		}
		.emulsion-document-table.form-table tr.sub-title,
		.emulsion-document-table.form-table tr.title{
			margin:0;
			padding:1rem 10px;
			background:transparent;
			vertical-align:top;
			
		}
		.emulsion-document-table .sub-title td[colspan]{
			border:none;
			padding:1rem 10px;
			background:transparent;
		}
		.emulsion-document-table pre code{
			display:block;
		}
		.form-table.emulsion-document-table td{
			vertical-align:top;
		}
		.dashicons-layout:before {
			content: "\f538";
			margin-right:6px;
		}
		.additional-class{
			margin-left:2rem;

		}
		.additional-class li{
			
		}
		.additional-class li ul{
			margin-left:2rem;			
		}
		.additional-class .label{
			font-weight:700;
		}
		.emulsion-notice{
			display:inline-block;
		}
		.block-name{
			margin-left:2rem;
		}
		.additional-class{
			margin-left:4rem;
		}

CSS;

	printf( '<style type="text/css">%1$s</style>',esc_html( $css ) );
}

/**
 * Create Tab Menu
 */
function emulsion_admin_tabs( $current = 'homepage' ) {

	$tabs	 = array( 
		'homepage'		 => esc_html__( 'Home', 'emulsion' ),
		'customizer'	 => esc_html__( 'Customizer', 'emulsion' ),
		'embed'			 => esc_html__( 'Embed Media', 'emulsion' ),
		'advanced'		 => esc_html__( 'Advanced Class', 'emulsion' ),
		'templatetag'	 => esc_html__( 'Template Tag', 'emulsion' ),
	);
	$links	 = array();

	echo '<h2 class="nav-tab-wrapper">';

	foreach ( $tabs as $tab => $name ) {
		$class = ( $tab == $current ) ? ' nav-tab-active' : '';
		//echo "<a class='nav-tab $class' href='?page=theme-settings&tab=$tab'>$name</a>";

		printf( '<a class="nav-tab %1$s" href="?page=theme-settings&tab=%2$s">%3$s</a>', esc_attr( $class ), esc_attr( $tab ), esc_html( $name ) );
	}
	echo '</h2>';
}

/**
 *  Make Customizer link
 */
function emulsion_get_customizer_link_element( $place, $name ) {

	$label = emulsion_get_var( $name, 'label' );

		// Exception setting
		switch ( $name ) {

			case('header_image'):
				$label	 = esc_html__( 'Header Media', 'emulsion' );
				break;
			case('header_textcolor'):
				$label	 = esc_html__( 'Header Text Color', 'emulsion' );
				break;
			case('widgets'):
				$label	 = esc_html__( 'Widgets', 'emulsion' );
				break;
			case('emulsion_section_fonts_widget_meta'):
				$label	 = esc_html__( 'Widget, Meta data,', 'emulsion' );
				break;

			case('background_color'):
				$label = esc_html__( 'Background Color', 'emulsion' );
				break;
			case('emulsion_layout_homepage'):
				$label = esc_html__( 'Home Page', 'emulsion' );
				break;
			case('emulsion_layout_posts_page'):
				$label = esc_html__( 'Posts Page', 'emulsion' );
				break;
			case('emulsion_layout_date_archives'):
				$label = esc_html__( 'Date Archives', 'emulsion' );
				break;
			case('emulsion_layout_category_archives'):
				$label = esc_html__( 'Category Archives', 'emulsion' );
				break;
			case('emulsion_layout_tag_archives'):
				$label = esc_html__( 'Category Archives', 'emulsion' );
				break;
			case('emulsion_layout_author_archives'):
				$label = esc_html__( 'Author Page', 'emulsion' );
				break;
		}


	$query["autofocus[{$place}]"] = $name;

	$link = add_query_arg( $query, admin_url( 'customize.php' ) );

	printf( '<a href="%1$s">%2$s</a>', esc_url( $link ), wp_kses($label, array()) );
}

/**
 * Display Pages
 */
function emulsion_settings_page() {
	global $pagenow;

	$theme_name				 = emulsion_theme_info( 'Name', false );
	?>

	<div class="emulsion-document">
		<header class="emulsion-document-header">
		<h2><span class="dashicons dashicons-welcome-learn-more"></span> <?php echo esc_html( $theme_name ); ?></h2>
		</header>

	<?php //isset( $_GET['tab'] ) ? emulsion_admin_tabs( $_GET['tab'] ) : emulsion_admin_tabs( 'homepage' );  ?>
	<?php
	$emulsion_tab_value	 = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS );
	$emulsion_page_value	 = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS );
	isset( $emulsion_tab_value ) ? emulsion_admin_tabs( $emulsion_tab_value ) : emulsion_admin_tabs( 'homepage' );
	?>
		<div id="poststuff">

		<?php
		if ( $pagenow == 'themes.php' && $emulsion_page_value == 'theme-settings' ) {

			$tab = isset( $emulsion_tab_value ) ? $emulsion_tab_value : 'homepage';

			switch ( $tab ) {
				case 'general' :
					?>
						<tr>
							<th>Tags with CSS classes:</th>
							<td>
								<span class="description">Output each post tag with a specific CSS class using its slug.</span>
							</td>
						</tr>
				<?php
				break;
			case 'templatetag' :
				get_template_part( 'documents/' . $tab );
				break;
			case 'customizer' :
				get_template_part( 'documents/' . $tab );
				break;
			case 'embed' :
				get_template_part( 'documents/' . $tab );
				break;
			case 'homepage' :
				get_template_part( 'documents/' . $tab );
				break;
			case 'advanced':
				get_template_part( 'documents/' . $tab );	
				break;
		}
	}
	?>
		</div>
		<footer class="emulsion-document-footer">
		<p><?php echo esc_html( $theme_name ); ?></p>
		</footer>
	</div>
			<?php
		}
		?>