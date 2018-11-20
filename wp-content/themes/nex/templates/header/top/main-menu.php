<nav id="main-menu">
	<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
	<a href="#main" title="<?php esc_attr_e( 'Skip to content', 'nex' ); ?>" class="visuallyhidden"><?php esc_html_e( 'Skip to content', 'nex' ); ?></a>
	<?php
		$location = apply_filters( 'vamtam_header_menu_location', 'menu-header' );

		if ( has_nav_menu( $location ) ) {
			wp_nav_menu(array(
				'theme_location' => $location,
				'walker'         => new VamtamMenuWalker(),
				'link_before'    => '<span>',
				'link_after'     => '</span>',
			));
		}
	?>
</nav>
