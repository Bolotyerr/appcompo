<?php
	/**
	 * Top bar ( above the logo )
	 * @package vamtam/nex
	 */

	$layout = str_replace( 'beaver-', '', rd_vamtam_get_option( 'top-bar-layout' ) );

	if ( empty( $layout ) || ! class_exists( 'Vamtam_Elements_B' ) || ! class_exists( 'FLBuilderShortcodes' ) ) {
		return;
	}
?>
<div id="top-nav-wrapper">
	<?php do_action( 'vamtam_top_nav_before' ) ?>
	<nav class="top-nav">
		<?php
			echo FLBuilderShortcodes::insert_layout( array( // xss ok
				'slug' => $layout,
			) );
		?>
	</nav>
	<?php do_action( 'vamtam_top_nav_after' ) ?>
</div>
