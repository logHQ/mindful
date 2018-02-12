<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage Mindful
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-info">
	<a href="<?php echo esc_url( __( 'https://www.wp.login.plus/doc/mindful-doc/', 'mindful' ) ); ?>"><?php printf( __( '%s', 'mindful' ), 'Mindful' ); ?></a>
	<a href="<?php echo esc_url( __( 'https://www.wp.login.plus/', 'mindful' ) ); ?>"><?php printf( __( 'theme by %s', 'mindful' ), 'wp.login.plus' ); ?></a> |
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'mindful' ) ); ?>"><?php printf( __( 'Powered by %s', 'mindful' ), 'WordPress' ); ?></a>
</div><!-- .site-info -->
