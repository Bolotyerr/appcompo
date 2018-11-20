<?php

if ( ! VamtamTemplates::has_header_slider() ) {
	return;
}

$post_id = vamtam_get_the_ID();

$slider_slug   = vamtam_post_meta( $post_id, 'slider-category', true );
$slider_engine = strpos( $slider_slug, 'layerslider' ) === 0 ? 'layerslider' : 'revslider';

if ( $slider_engine !== 'revslider' || ! class_exists( 'RevSlider' ) ) {
	return;
}

$slider = new RevSlider();
$slider->initByMixed( str_replace( 'revslider-', '', $slider_slug ) );

$id     = $slider->getID();
$params = $slider->getParams();

if ( 'fullwidth' === $params['slider_type'] ) :
?>
	@media (max-width: <?php echo (int) $params['width_mobile'] ?>px) {
		#rev_slider_<?php echo (int) $id ?>_1_wrapper {
			height: <?php echo (int) $params['height_mobile'] ?>px;
		}
	}

	<?php if ( 'on' === $params['enable_custom_size_tablet'] ) : ?>
		@media (max-width: <?php echo (int) $params['width_tablet'] ?>px) {
			#rev_slider_<?php echo (int) $id ?>_1_wrapper {
				height: <?php echo (int) $params['height_tablet'] ?>px;
			}
		}
	<?php endif  ?>

	<?php if ( 'on' === $params['enable_custom_size_notebook'] ) : ?>
		@media (max-width: <?php echo (int) $params['width_notebook'] ?>px) {
			#rev_slider_<?php echo (int) $id ?>_1_wrapper {
				height: <?php echo (int) $params['height_notebook'] ?>px;
			}
		}
	<?php endif ?>

	@media (min-width: <?php echo (int) $params['width_notebook'] + 1 ?>px) {
		#rev_slider_<?php echo (int) $id ?>_1_wrapper {
			height: <?php echo (int) $params['height'] ?>px;
		}
	}
<?php elseif ( 'fullscreen' === $params['slider_type'] ) : ?>
	@media ( max-width: <?php echo (int) vamtam_get_mobile_header_breakpoint() ?> ) {
		#rev_slider_<?php echo (int) $id ?>_1_wrapper {
			height: calc( 100vh - 65px );
		}
	}

	<?php
		$top_bar       = rd_vamtam_get_option( 'top-bar-layout' ) !== '';
		$header_height = vamtam_post_meta( null, 'sticky-header-type', true ) !== 'over' ? rd_vamtam_get_option( 'header-height' ) : 0;

		// the height of the top bar is unknown and must be specified by the filter below
		// we can only reasonably estimate the initial height of the slider if either:
		// - the top bar is not shown
		// - the top bar height is set manually
		if ( ! $top_bar || has_filter( 'vamtam_top_bar_height' ) ) :
	?>
		@media ( min-width: <?php echo (int) vamtam_get_mobile_header_breakpoint() + 1 ?>px ) {
			#rev_slider_<?php echo (int) $id ?>_1_wrapper {
				height: calc( 100vh - <?php echo (int) $header_height ?>px - <?php echo (int) apply_filters( 'vamtam_top_bar_height', 0, $post_id ) ?>px );
			}
		}
	<?php endif ?>
<?php
endif;
