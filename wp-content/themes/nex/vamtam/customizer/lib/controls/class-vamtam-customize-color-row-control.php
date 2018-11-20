<?php

/**

Multiple color fields displayed horizontally

@see Kirki/multicolor

**/

require_once plugin_dir_path( __FILE__ ) . 'class-vamtam-customize-control.php';

class Vamtam_Customize_Color_Row_Control extends Vamtam_Customize_Control {
	public $type = 'vamtam-color-row';

	/**
	 * Constructor.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->statuses = array(
			'' => esc_html__( 'Default', 'nex' ),
		);
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Color Palette.
	 *
	 * @access public
	 * @var bool
	 */
	public $palette = true;
	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();
		$this->json['palette']  = $this->palette;
		$this->json['statuses'] = $this->statuses;
	}
	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script(
			'customizer-control-vamtam-color-row-js',
			VAMTAM_CUSTOMIZER_LIB_URL . 'assets/js/color-row' . ( WP_DEBUG ? '' : '.min' ) . '.js',
			array( 'jquery-core', 'customize-base', 'wp-color-picker' ),
			Vamtam_Customizer::$version,
			true
		);

		wp_enqueue_style(
			'customizer-control-vamtam-color-row',
			VAMTAM_CUSTOMIZER_LIB_URL . 'assets/css/color-row.css',
			array( 'wp-color-picker' ),
			Vamtam_Customizer::$version
		);
	}

	/**
	 * Don't render the control content from PHP, as it's rendered via JS on load.
	 */
	public function render_content() {}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see Kirki_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<span class="customize-control-title">
			{{{ data.label }}}
		</span>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="vamtam-color-row-group-wrapper">
			<# for ( key in data.choices ) { #>
				<div class="vamtam-color-row-single-color-wrapper">
					<# if ( data.choices[ key ] ) { #>
						<label for="{{ data.id }}-{{ key }}">{{ data.choices[ key ] }}</label>
					<# } #>
					<input id="{{ data.id }}-{{ key }}" type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default[ key ] }}" data-alpha="true" value="{{ data.value[ key ] }}" class="kirki-color-control color-picker vamtam-color-row-index-{{ key }}" />
				</div>
			<# } #>
		</div>
		<input type="hidden" value="" {{{ data.link }}} />
		<?php
	}
}
