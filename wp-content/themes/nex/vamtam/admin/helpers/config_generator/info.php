<?php
/*
 * info box
 */

$is_open = isset( $visible ) && $visible;

$close = esc_html__( 'Close', 'nex' );
$open  = esc_html__( 'Open', 'nex' );

$other  = $is_open ? $open : $close;
$normal = $is_open ? $close : $open;

?>

<div class="vamtam-config-row config-info <?php echo esc_attr( $class ) ?>">
	<div class="info-wrapper">
		<div class="title"><?php echo esc_html( $name ) ?></div>
		<a href="#" data-other="<?php echo esc_attr( $other ) ?>"><?php echo esc_html( $normal ) ?></a>
		<div class="desc <?php if ( $is_open ) echo 'visible' ?>"><?php echo esc_html( $desc ) ?></div>
	</div>
</div>
