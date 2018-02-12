<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 *
 * @package mindful
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses mindful_admin_header_image()
 *
 */

function mindful_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'mindful_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '3d3d3d',
		'width'                  => 1400,
		'height'                 => 400,
		'flex-height'                        => true,
		'flex-width'                         => true,
		'wp-head-callback'       => '',
		'video'						=> true,
		'admin-head-callback'    => '',
		'admin-preview-callback' => 'mindful_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'mindful_custom_header_setup' );


if ( ! function_exists( 'mindful_admin_header_image' ) ) :
	/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see mindful_custom_header_setup().
 */
	function mindful_admin_header_image() {
		$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
		?>
		<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
		</div>
		<?php
	}
endif; // mindful_admin_header_image
