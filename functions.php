<?php
/**
 * House Shows Direct Child Theme Functions
 *
 * @package House_Shows_Direct_Child
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue parent and child theme styles.
 */
function house_shows_direct_child_enqueue_styles() {
	// Enqueue parent theme stylesheet
	wp_enqueue_style(
		'buddyboss-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme()->parent()->get( 'Version' )
	);

	// Enqueue child theme stylesheet
	wp_enqueue_style(
		'house-shows-direct-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'buddyboss-parent-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'house_shows_direct_child_enqueue_styles' );

/**
 * Add your custom functions below this line
 */

