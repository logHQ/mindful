<?php
/**
 * Changelog
 */

$mindful = wp_get_theme( 'mindful' );

?>
<div class="featured-section changelog">
	

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$mindful_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/changelog.txt' );
	$mindful_changelog_lines = explode( PHP_EOL, $mindful_changelog );
	foreach ( $mindful_changelog_lines as $mindful_changelog_line ) {
		if ( substr( $mindful_changelog_line, 0, 3 ) === '###' ) {
			echo '<h4>' . substr( $mindful_changelog_line, 3 ) . '</h4>';
		} else {
			echo $mindful_changelog_line, '<br/>';
		}
	}

	echo '<hr />';


	?>

</div>
