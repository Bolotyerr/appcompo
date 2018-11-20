<?php
	global $post;

	$video   = isset( $value['video'] ) ? ! ! $value['video'] : false;
	$button  = isset( $value['button'] ) ? $value['button'] : esc_html__( 'Insert', 'nex' );
	$remove  = isset( $value['remove'] ) ? $value['remove'] : esc_html__( 'Remove', 'nex' );
	$default = isset( $GLOBALS['vamtam_in_metabox'] ) ? get_post_meta( $post->ID, $id, true ) : vamtam_get_option( $id, $default );

	$name = $id;
	$id   = preg_replace( '/[^\w]+/', '', $id );
?>

<div class="upload-basic-wrapper <?php echo esc_attr( ! empty( $default ) ? 'active' : '' ) ?>">
	<div class="image-upload-controls <?php if ( $video ) echo 'vamtam-video-upload-controls' ?>">
		<input type="text" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $name ) ?>" value="<?php echo esc_attr( $default ) ?>" class="image-upload <?php vamtam_static( $value )?> <?php if ( ! $video ) echo 'hidden' ?>" />

		<a class="button vamtam-upload-button <?php if ( $video ) echo 'vamtam-video-upload' ?>" href="#" data-target="<?php echo esc_attr( $id ) ?>">
			<?php echo esc_html( $button ) ?>
		</a>

		<a class="button vamtam-upload-clear <?php if ( empty( $default ) ) echo 'hidden' ?>" href="#" data-target="<?php echo esc_attr( $id ) ?>"><?php echo esc_html( $remove ) ?></a>
		<a class="vamtam-upload-undo hidden" href="#" data-target="<?php echo esc_attr( $id ) ?>"><?php echo esc_html__( 'Undo', 'nex' ) ?></a>
	</div>
	<div id="<?php echo esc_attr( $id ) ?>_preview" class="image-upload-preview <?php if ( $video ) echo 'hidden' ?>">
		<img src="<?php echo esc_url( $default ) ?>" />
	</div>
</div>
