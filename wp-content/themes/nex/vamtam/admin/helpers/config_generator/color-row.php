<?php
/**
 * multiple color inputs
 */
?>
<div class="vamtam-config-row color-row clearfix <?php echo esc_attr( $class )  ?>">
	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>

		<?php vamtam_description( '', $desc ) ?>
	</div>

	<div class="rcontent clearfix">
		<?php foreach ( $inputs as $id => $input ) : ?>
			<?php
				if ( ! isset( $input['default'] ) ) {
					$input['default'] = null;
				}

				$single_val = isset( $GLOBALS['vamtam_in_metabox'] ) ?
					get_post_meta( $post->ID, $id, true ) :
					vamtam_get_option( $id, $input['default'] );
			?>
			<div class="single-color">
				<div class="single-desc"><?php echo esc_html( $input['name'] ) ?></div>
				<div>
					<input name="<?php echo esc_attr( $id ) ?>" id="<?php echo esc_attr( $id ) ?>" type="text" data-hex="true" value="<?php echo esc_attr( $single_val ) ?>" class="vamtam-color-input <?php vamtam_static( $value )?>" />
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>
