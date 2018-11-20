<?php
/**
 * text input
 */
?>

<div class="vamtam-config-row text clearfix <?php echo esc_attr( $class ) ?>">

	<div class="rtitle">
		<h4>
			<label for="<?php echo esc_attr( $id ) ?>"><?php echo esc_html( $name ) ?></label>
		</h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<input name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" type="text" class="large-text <?php vamtam_static( $value )?>" size="<?php echo intval( isset( $size ) ? $size : 10 ) ?>" value="<?php echo esc_attr( vamtam_get_option( $id, $default ) ) ?>" />
	</div>
</div>
