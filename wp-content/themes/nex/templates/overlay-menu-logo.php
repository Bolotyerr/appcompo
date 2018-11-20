<?php
	$logo_url = rd_vamtam_get_option( 'custom-header-logo-transparent' );

	$attachment = attachment_url_to_postid( $logo_url );

	if ( ! empty( $logo_url ) ) :
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

		$logo_hw_string = empty( $logo_size['width'] ) ? '' : image_hwstring( $logo_size['width'] / 2, $logo_size['height'] / 2 );
?>
	<div class="vamtam-overlay-menu-logo">
		<img src="<?php echo esc_url( $logo_url ) ?>" alt="<?php bloginfo( 'name' )?>" class="menu-logo" <?php echo $logo_hw_string; // xss ok ?> />
	</div>
<?php endif ?>
