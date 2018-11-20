<?php

$fields = array(
	'color'      => esc_html__( 'Color:', 'nex' ),
	'image'      => esc_html__( 'Image / pattern:', 'nex' ),
	'repeat'     => esc_html__( 'Repeat:', 'nex' ),
	'attachment' => esc_html__( 'Attachment:', 'nex' ),
	'position'   => esc_html__( 'Position:', 'nex' ),
	'size'       => esc_html__( 'Size:', 'nex' ),
);

$sep = isset( $sep ) ? $sep : '-';

$current = array();

if ( ! isset( $only ) ) {
	if ( isset( $show ) ) {
		$only = explode( ',', $show );
	} else {
		$only = array();
	}
} else {
	$only = explode( ',', $only );
}

$show = array();

global $post;
foreach ( $fields as $field => $fname ) {
	if ( isset( $GLOBALS['vamtam_in_metabox'] ) ) {
		$current[ $field ] = get_post_meta( $post->ID, "$id-$field", true );
	} else {
		$current[ $field ] = vamtam_get_option( "$id-$field" );
	}
	$show[ $field ] = ( in_array( $field, $only ) || count( $only ) === 0 );
}

$selects = array(
	'repeat' => array(
		'no-repeat' => esc_html__( 'No repeat', 'nex' ),
		'repeat-x'  => esc_html__( 'Repeat horizontally', 'nex' ),
		'repeat-y'  => esc_html__( 'Repeat vertically', 'nex' ),
		'repeat'    => esc_html__( 'Repeat both', 'nex' ),
	),
	'attachment' => array(
		'scroll' => esc_html__( 'scroll', 'nex' ),
		'fixed'  => esc_html__( 'fixed', 'nex' ),
	),
	'position' => array(
		'left center'   => esc_html__( 'left center', 'nex' ),
		'left top'      => esc_html__( 'left top', 'nex' ),
		'left bottom'   => esc_html__( 'left bottom', 'nex' ),
		'center center' => esc_html__( 'center center', 'nex' ),
		'center top'    => esc_html__( 'center top', 'nex' ),
		'center bottom' => esc_html__( 'center bottom', 'nex' ),
		'right center'  => esc_html__( 'right center', 'nex' ),
		'right top'     => esc_html__( 'right top', 'nex' ),
		'right bottom'  => esc_html__( 'right bottom', 'nex' ),
	),
);

?>

<div class="vamtam-config-row background clearfix <?php echo esc_attr( $class ) ?>">

	<div class="rtitle">
		<h4><?php echo esc_html( $name ) ?></h4>

		<?php vamtam_description( $id, $desc ) ?>
	</div>

	<div class="rcontent">
		<div class="bg-inner-row">
			<?php if ( $show['color'] ) : ?>
				<div class="bg-block color">
					<div class="single-desc"><?php esc_html_e( 'Color:', 'nex' ) ?></div>
					<input name="<?php echo esc_attr( $id . $sep . 'color' ) ?>" id="<?php echo esc_attr( $id ) ?>-color" type="text" data-hex="true" value="<?php echo esc_attr( $current['color'] ) ?>" class="vamtam-color-input" />
				</div>
			<?php endif ?>
		</div>

		<div class="bg-inner-row">
			<?php if ( $show['image'] ) : ?>
				<div class="bg-block bg-image">
					<div class="single-desc"><?php esc_html_e( 'Image / pattern:', 'nex' ) ?></div>
					<?php $_id = $id;
$id                           .= $sep . 'image'; // temporary change the id so that we can reuse the upload field ?>
					<div class="image <?php vamtam_static( $value ) ?>">
						<?php include VAMTAM_ADMIN_CGEN . 'upload-basic.php'; ?>
					</div>
					<?php $id = $_id;
unset( $_id ); ?>
				</div>
			<?php endif ?>

			<?php if ( $show['size'] ) : ?>
				<div class="bg-block bg-size">
					<div class="single-desc"><?php esc_html_e( 'Cover:', 'nex' ) ?></div>
					<label class="toggle-radio">
						<input type="radio" name="<?php echo esc_attr( $id . $sep ) ?>size" value="cover" <?php checked( $current['size'], 'cover' ) ?>/>
						<span><?php esc_html_e( 'On', 'nex' ) ?></span>
					</label>
					<label class="toggle-radio">
						<input type="radio" name="<?php echo esc_attr( $id . $sep ) ?>size" value="auto" <?php checked( $current['size'], 'auto' ) ?>/>
						<span><?php esc_html_e( 'Off', 'nex' ) ?></span>
					</label>
				</div>
			<?php endif ?>

			<?php foreach ( $selects as $s => $options ) : ?>
				<?php if ( $show[ $s ] ) : ?>
					<div class="bg-block bg-<?php echo esc_attr( $s )?>">
						<div class="single-desc"><?php echo wp_kses_post( $fields[ $s ] ) ?></div>
						<select name="<?php echo esc_attr( $id . $sep . $s ) ?>" class="bg-<?php echo esc_attr( $s ) ?>">
							<?php foreach ( $options as $val => $opt ) : ?>
								<option value="<?php echo esc_attr( $val ) ?>" <?php selected( $val, $current[ $s ] ) ?>><?php echo esc_html( $opt ) ?></option>
							<?php endforeach ?>
						</select>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</div>
