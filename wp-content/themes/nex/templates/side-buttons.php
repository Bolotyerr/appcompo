<?php

/**
 * Displays the scroll to top button
 *
 * @package vamtam/nex
 */
?>

<?php if ( rd_vamtam_get_option( 'show-scroll-to-top' ) || is_customize_preview() ) : ?>
	<div id="scroll-to-top" class="vamtam-scroll-to-top icon" <?php VamtamTemplates::display_none( rd_vamtam_get_option( 'show-scroll-to-top' ) ) ?>><?php vamtam_icon( 'vamtam-theme-arrow-top-sample' ) ?></div>
<?php endif ?>
