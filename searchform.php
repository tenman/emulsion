<?php
/**
 * Search form for sidebar, footer widget
 * The block editor search form is separate.
 * rewriting　in order to be consistent with the block editor search form, 
 */
$emulsion_attributes = array('label' => esc_html__( 'Search', 'emulsion' ), 'placeholder' => esc_html__( 'Search', 'emulsion' ),	'buttonText'  => esc_html__( 'Search', 'emulsion' ),);

echo wp_kses( render_block_core_search( $emulsion_attributes ), EMULSION_FORM_ALLOWED_ELEMENTS );