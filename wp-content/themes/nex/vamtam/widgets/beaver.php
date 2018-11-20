<?php

/**
 * Beaver template widget
 *
 * @package  vamtam/nex
 */

class Vamtam_Beaver_Widget extends WP_Widget {

	public function __construct() {
		$widget_options = array(
			'classname'   => 'vamtam_beaver',
			'description' => esc_html__( 'Display a saved layout from the VamTam Builder', 'nex' ),
		);

		parent::__construct( 'Vamtam_Beaver_Widget', esc_html__( 'VamTam Builder Layout', 'nex' ) , $widget_options );
	}

	public function widget( $args, $instance ) {
		if ( class_exists( 'FLBuilderShortcodes' ) ) {
			echo $args['before_widget']; // xss ok

			if ( $instance['title'] ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title']; // xss ok
			}

			echo FLBuilderShortcodes::insert_layout( array( // xss ok
				'type' => 'fl-builder-template',
				'slug' => $instance['slug'],
			) );

			echo $args['after_widget']; // xss ok
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['slug']  = preg_replace( '/^beaver-/', '', $new_instance['slug'] );
		$instance['title'] = $new_instance['title'];

		return $instance;
	}

	public function form( $instance ) {
		$options = vamtam_get_beaver_layouts( array(
			'' => esc_html__( '-- Select Layout--', 'nex' ),
		) );

		$slug  = isset( $instance['slug'] ) ? esc_attr( $instance['slug'] ) : '';
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'nex' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'slug' ) ); ?>"><?php esc_html_e( 'Template:', 'nex' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'slug' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slug' ) ); ?>">
				<?php foreach ( $options as $opt_value => $opt_text ) : ?>
					<option value="<?php echo esc_attr( $opt_value )?>" <?php selected( $opt_value, $slug ) ?>><?php echo esc_html( $opt_text ) ?></option>
				<?php endforeach; ?>
			</select>
		</p>
<?php
	}
}

register_widget( 'Vamtam_Beaver_Widget' );
