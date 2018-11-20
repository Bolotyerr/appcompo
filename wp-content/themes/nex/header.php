<?php
/**
 * Header template
 *
 * @package vamtam/nex
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="<?php echo sanitize_hex_color( rd_vamtam_get_option( 'accent-color', 1 ) ) ?>">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<span id="top"></span>
	<?php
		do_action( 'vamtam_body' );

		$slider_above_header = is_singular( VamtamFramework::$complex_layout ) && vamtam_post_meta( null, 'sticky-header-type', true ) === 'below';

		if ( $slider_above_header ) {
			include locate_template( 'templates/header/middle.php' );
		}

		get_template_part( 'templates/header' );
	?>
	<div id="page" class="main-container">
		<div class="boxed-layout">
			<div class="pane-wrapper clearfix">
				<?php
					if ( ! $slider_above_header ) {
						include locate_template( 'templates/header/middle.php' );
					}
				?>

				<div id="main-content">
					<?php include locate_template( 'templates/header/sub-header.php' );?>

					<?php $hide_lowres_bg = rd_vamtam_get_optionb( 'main-background-hide-lowres' ) ? 'vamtam-hide-bg-lowres' : ''; ?>
					<div id="main" role="main" class="vamtam-main layout-<?php echo esc_attr( VamtamTemplates::get_layout() ) ?>  <?php echo esc_attr( $hide_lowres_bg ) ?>">
						<?php do_action( 'vamtam_inside_main' ) ?>

						<?php if ( ! class_exists( 'Vamtam_Elements_B' ) || Vamtam_Elements_B::had_limit_wrapper() ) :  ?>
							<div class="limit-wrapper vamtam-box-outer-padding">
						<?php endif ?>
