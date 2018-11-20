<?php
/**
 * color input
 */
?>
<div class="vamtam-config-row clearfix <?php echo esc_attr( $class ) ?>">
	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<div class="color-input-wrap">
			<input name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" type="text" value="<?php echo esc_attr( vamtam_get_option( $id, $default ) ) ?>" class="vamtam-color-input <?php vamtam_static( $value )?>" />
		</div>
	</div>
</div>
