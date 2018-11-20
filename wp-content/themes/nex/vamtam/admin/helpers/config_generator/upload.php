<?php
/**
 * upload field
 */
?>

<div class="vamtam-config-row clearfix <?php echo esc_attr( $class ) ?>">
	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<?php include VAMTAM_ADMIN_CGEN . 'upload-basic.php' ?>
	</div>
</div>
