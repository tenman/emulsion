<?php
/**
 * Register the required plugins for emulsion theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
add_action( 'tgmpa_register', 'emulsion_theme_register_required_plugins' );

function emulsion_theme_register_required_plugins() {

    $plugins = array(
		array(
			'name'		 => 'Breadcrumb NavXT',
			'slug'		 => 'breadcrumb-navxt',
			'required'	 => false,
		),
		array(
			'name'		 => 'emulsion addons',
			'slug'		 => 'emulsion-addons',
			'required'	 => false,
		),
		array(
			'name'		 => 'AMP',
			'slug'		 => 'amp',
			'required'	 => false,
		),
		array(
			'name'		 => 'PWA',
			'slug'		 => 'pwa',
			'required'	 => false,
		),
		array(
			'name'		 => 'Gutenberg',
			'slug'		 => 'gutenberg',
			'required'	 => false,
		),

	);

	$config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',						// Message to output right before the plugins table.
    );

    tgmpa( $plugins, $config );
}
