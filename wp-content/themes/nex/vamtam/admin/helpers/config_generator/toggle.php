<?php
/**
 * on/off toggle
 */

$option  = $value;
$checked = vamtam_get_option( $id, $default );

$ff = empty( $field_filter ) ? '' : 'data-field-filter="' . esc_attr( $field_filter ) . '"';
?>

<div class="vamtam-config-row toggle <?php echo esc_attr( $class ) ?> clearfix" <?php echo $ff // xss ok ?>>
	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent clearfix">
		<?php include VAMTAM_ADMIN_CGEN . 'toggle-basic.php' ?>
	</div>
</div>
