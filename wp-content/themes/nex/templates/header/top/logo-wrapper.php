<div class="logo-wrapper">
	<?php
		$megamenu_settings = get_option( 'megamenu_settings' );

		$mobile_search = isset( $megamenu_settings['vamtam-mobile-search'] ) ? $megamenu_settings['vamtam-mobile-search'] : '';
		$mobile_cart   = isset( $megamenu_settings['vamtam-mobile-cart'] ) ? $megamenu_settings['vamtam-mobile-cart'] : '';

		$logo_type = rd_vamtam_get_option( 'header-logo-type' );

		$logo       = rd_vamtam_get_option( 'custom-header-logo' );
		$logo_trans = rd_vamtam_get_option( 'custom-header-logo-transparent' );

		$logo_size = array(
			'width'  => 0,
			'height' => 0,
		);

		$logo_style = '';

		$attachment = attachment_url_to_postid( $logo );

		if ( $logo_type == 'image' && $attachment ) {
			$logo_meta = get_post_meta( $attachment, '_wp_attachment_metadata', true );

			$logo_size = array(
				'width'  => isset( $logo_meta['width'] ) ? intval( $logo_meta['width'] ) : 0,
				'height' => isset( $logo_meta['height'] ) ? intval( $logo_meta['height'] ) : 0,
			);

			$max_height = 0;
			if ( ! empty( $logo_size['height'] ) ) {
				$max_height = $logo_size['height'] / 2;
				$logo_style = "max-height: {$max_height}px;";
			}
		}

		$logo_hw_string = empty( $logo_size['width'] ) ? '' : image_hwstring( $logo_size['width'] / 2, $logo_size['height'] / 2 );
	?>
	<div class="logo-tagline">
		<a href="<?php echo esc_url( home_url( '/' ) ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ) ?>" class="logo <?php if ( empty( $logo ) || $logo_type === 'site-title' ) echo 'text-logo' ?>" style="min-width:<?php echo (int) $logo_size['width'] / 2 ?>px"><?php
			if ( isset( $logo ) && $logo_type === 'image' ) :
			?>
				<img src="<?php echo esc_url( $logo ) ?>" alt="<?php bloginfo( 'name' )?>" class="normal-logo" <?php echo $logo_hw_string; // xss ok ?> style="<?php echo esc_attr( $logo_style ) ?>"/>
				<?php if ( ! empty( $logo_trans ) ) : ?>
					<img src="<?php echo esc_url( $logo_trans ) ?>" alt="<?php esc_attr( bloginfo( 'name' ) ) ?>" class="alternative-logo" <?php echo $logo_hw_string; // xss ok ?> style="<?php echo esc_attr( $logo_style ) ?>"/>
				<?php endif ?>
			<?php
			else :
				bloginfo( 'name' );
			endif;
			?>
		</a>
		<?php
			$description = get_bloginfo( 'description' );
			if ( ! empty( $description ) ) :
		?>
				<span class="site-tagline"><?php echo wp_kses_post( $description ) ?></span>
		<?php endif ?>
	</div>

	<?php if ( class_exists( 'Mega_Menu' ) ) : ?>
		<div class="mobile-logo-additions">
			<?php if ( 'on' === $mobile_cart && vamtam_has_woocommerce() ) : ?>
				<?php global $woocommerce; ?>
				<a class="vamtam-cart-dropdown-link icon theme no-dropdown" href="<?php echo esc_url( wc_get_cart_url() ) ?>">
					<span class="icon theme"><?php vamtam_icon( 'vamtam-theme-bag-clean' ) ?></span>
					<span class="products cart-empty">...</span>
				</a>
			<?php endif ?>
			<?php if ( 'on' === $mobile_search ) : ?>
				<button class="header-search icon vamtam-overlay-search-trigger"><?php vamtam_icon( 'search-clean' ) ?></button>
			<?php endif ?>
			<?php if ( has_nav_menu( 'menu-header' ) && rd_vamtam_get_option( 'header-layout' ) !== 'overlay-menu' ) : ?>
				<div id="vamtam-megamenu-main-menu-toggle"></div>
			<?php endif ?>
		</div>
	<?php endif ?>
</div>
