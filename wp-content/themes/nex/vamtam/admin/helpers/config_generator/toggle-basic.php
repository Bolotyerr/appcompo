<?php if ( isset( $image ) ) : ?>
	<img src="<?php echo esc_url( $image ) ?>" alt="<?php echo esc_attr( $name ) ?>" class="alignleft" />
<?php endif ?>
<label class="toggle-radio">
	<input type="radio" name="<?php echo esc_attr( $id ) ?>" value="true" <?php checked( $checked, true ) ?>/>
	<span><?php esc_html_e( 'On', 'nex' ) ?></span>
</label>
<label class="toggle-radio">
	<input type="radio" name="<?php echo esc_attr( $id ) ?>" value="false" <?php checked( $checked, false ) ?>/>
	<span><?php esc_html_e( 'Off', 'nex' ) ?></span>
</label>
<?php if ( isset( $has_default ) && $has_default ) : ?>
	<label class="toggle-radio">
		<input type="radio" name="<?php echo esc_attr( $id ) ?>" value="default" <?php checked( $checked, 'default' ) ?>/>
		<span><?php esc_html_e( 'Default', 'nex' ) ?></span>
	</label>
<?php endif ?>
