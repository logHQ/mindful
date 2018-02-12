<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package mindful
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function mindful_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'type'      => 'click',
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'mindful_jetpack_setup' );
