<?php $hide_lowres_bg = rd_vamtam_get_optionb( 'page-title-background-hide-lowres' ) ? 'vamtam-hide-bg-lowres' : ''; ?>
<header class="page-header layout-<?php echo esc_attr( $layout ) ?> <?php echo esc_attr( $hide_lowres_bg ) ?> <?php echo esc_attr( $uses_local_title_layout ) ?>" data-progressive-animation="page-title">
	<h1 style="<?php echo esc_attr( $title_color ) ?>" itemprop="headline">
		<?php echo wp_kses_post( $title ) ?>

		<?php if ( $layout === 'one-row-left' || $layout === 'one-row-right' ) : ?>
			<div class="page-header-line"></div>
		<?php endif ?>
	</h1>

	<?php if ( ! empty( $description ) ) : ?>
		<?php if ( $layout != 'one-row-left' && $layout != 'one-row-right' ) : ?>
			<div class="page-header-line"></div>
		<?php endif ?>

		<div class="desc" style="<?php echo esc_attr( $title_color ) ?>"><?php echo wp_kses_post( $description ) ?></div>
	<?php endif ?>
</header>
