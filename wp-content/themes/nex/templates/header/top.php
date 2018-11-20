<?php
	/**
	 * Actual, visible header. Includes the logo, menu, etc.
	 * @package vamtam/nex
	 */

	$layout     = rd_vamtam_get_option( 'header-layout' );
	$single_row = in_array( $layout, array( 'logo-menu', 'overlay-menu' ), true );

	if ( is_page_template( 'page-blank.php' ) ) return;

	$style_attr = '';

	if (
		rd_vamtam_get_optionb( 'sticky-header' ) &&
		vamtam_post_meta( null, 'sticky-header-type', true ) === 'over'
	) {
		$style_attr .= 'height:0;';
	}

	wp_enqueue_script( 'vamtam-sticky-header' );
?>
<div class="fixed-header-box sticky-header-state-reset" style="<?php echo esc_attr( $style_attr ) ?>">
	<header class="main-header layout-<?php echo esc_attr( $layout ) ?> <?php if ( $single_row ) echo 'layout-single-row header-content-wrapper' ?> <?php if ( $layout !== 'logo-text-menu' ) echo 'header-background' ?>">
		<?php get_template_part( 'templates/header/top/nav' ) ?>
		<?php get_template_part( 'templates/header/top/main', $layout ) ?>
	</header>

	<?php do_action( 'vamtam_header_box' ); ?>
</div>
