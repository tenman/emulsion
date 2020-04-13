<?php
/**
 * Template Name: Blank Template
 * Template Post Type: post, page
 *
 */


function_exists( 'emulsion_remove_supports' ) ? emulsion_remove_supports( 'header' ):'';
function_exists( 'emulsion_remove_supports' ) ? emulsion_remove_supports( 'title_in_page_header' ):'';
function_exists( 'emulsion_remove_supports' ) ? emulsion_remove_supports( 'primary_menu' ):'';
function_exists( 'emulsion_remove_supports' ) ? emulsion_remove_supports( 'sidebar' ):'';
function_exists( 'emulsion_remove_supports' ) ? emulsion_remove_supports( 'sidebar_page' ):'';
function_exists( 'emulsion_remove_supports' ) ? emulsion_remove_supports( 'relate_posts' ):'';
function_exists( 'emulsion_remove_supports' ) ? emulsion_remove_supports( 'search_drawer' ):'';

get_header();

emulsion_have_posts();

if ( is_single() ) {
	emulsion_pagination();
}

get_footer();