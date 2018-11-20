<?php
	/*
			range input
	*/

	$min   = isset( $min ) ? "min='$min' " : '';
	$max   = isset( $max ) ? "max='$max' " : '';
	$step  = isset( $step ) ? "step='$step' " : '';
	$unit  = isset( $unit ) ? $unit : '';
	$class = isset( $class ) ? $class : '';
 ?>

 <div class="vamtam-config-row <?php echo esc_attr( $class ) ?> clearfix">
	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<div class="range-input-wrap clearfix">
			<span>
				<input name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" type="number" value="<?php echo esc_attr( vamtam_get_option( $id, $default ) ) ?>" <?php echo $min . $max . $step // xss ok ?> class="vamtam-range-input <?php vamtam_static( $value )?>" />
				<span><?php echo esc_html( $unit ) ?></span>
			</span>
		</div>
	</div>
 </div>
