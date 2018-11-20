<?php

/**
	Typograohy control

	@see Kirki/typography
 */

class Vamtam_Customize_Typography_Control extends Vamtam_Customize_Control {
	public $type = 'vamtam-typography';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script(
			'customizer-control-vamtam-typography-js',
			VAMTAM_CUSTOMIZER_LIB_URL . 'assets/js/typography' . ( WP_DEBUG ? '' : '.min' ) . '.js',
			array( 'jquery-core', 'customize-base', 'wp-color-picker' ),
			Vamtam_Customizer::$version,
			true
		);

		wp_enqueue_style(
			'customizer-control-vamtam-typography',
			VAMTAM_CUSTOMIZER_LIB_URL . 'assets/css/typography.css',
			array( 'wp-color-picker' ),
			Vamtam_Customizer::$version
		);

		wp_localize_script( 'customize-base', 'VAMTAM_ALL_FONTS', $GLOBALS['vamtam_fonts'] );
	}
	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();
		$this->add_values_backwards_compatibility();

		$defaults = array(
			'font-family'    => false,
			'font-size'      => 0,
			'variant'        => false,
			'line-height'    => 0,
			'color'          => '#000000',
		);

		$this->json['default'] = wp_parse_args( $this->json['default'], $defaults );

		$this->json['show_variants'] = true;

		$this->json['l10n'] = array(
			'font-family'        => esc_html__( 'Font Family', 'nex' ),
			'select-font-family' => esc_html__( 'Select Font Family', 'nex' ),
			'variant'            => esc_html__( 'Variant', 'nex' ),
			'font-size'          => esc_html__( 'Font Size', 'nex' ),
			'line-height'        => esc_html__( 'Line Height', 'nex' ),
			'color'              => esc_html__( 'Color', 'nex' ),
		);

		$this->json['unit'] = 'px';
	}
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
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<div class="wrapper">
			<# if ( '' == data.value['font-family'] ) { data.value['font-family'] = data.default['font-family']; } #>

			<div class="font-family">
				<h5>{{ data.l10n['font-family'] }}</h5>
				<select id="vamtam-typography-font-family-{{{ data.id }}}" placeholder="{{ data.l10n['select-font-family'] }}">
					<# for ( var font in VAMTAM_ALL_FONTS ) { #>
						<option value="{{ VAMTAM_ALL_FONTS[font].family }}">{{ font }}</option>
					<# } #>
				</select>
			</div>

			<div class="sizes">
				<div class="font-size">
					<h5>{{ data.l10n['font-size'] }}</h5>
					<input type="number" value="{{ parseInt( data.value['font-size'], 10 ) }}" min="0" />{{data.unit}}
				</div>

				<div class="line-height">
					<h5>{{ data.l10n['line-height'] }}</h5>
					<input type="number" value="{{ parseInt( data.value['line-height'], 10 ) }}" min="0" />{{data.unit}}
				</div>
			</div>

			<div class="variant-color">
				<div class="color">
					<h5>{{ data.l10n['color'] }}</h5>
					<input type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default['color'] }}" value="{{ data.value['color'] }}" class="vamtam-color-picker" />
				</div>

				<# if ( true === data.show_variants || false !== data.default.variant ) { #>
					<div class="variant vamtam-variant-wrapper">
						<h5>{{ data.l10n['variant'] }}</h5>
						<select class="variant" id="vamtam-typography-variant-{{{ data.id }}}"></select>
					</div>
				<# } #>
			</div>
		</div>
		<?php
	}
	/**
	 * Adds backwards-compatibility for values.
	 * Converts font-weight to variant
	 * Adds units to letter-spacing
	 *
	 * @access protected
	 */
	protected function add_values_backwards_compatibility() {
		$value      = $this->value();
		$old_values = array(
			'font-family'    => '',
			'font-size'      => '',
			'variant'        => ( isset( $value['font-weight'] ) ) ? $value['font-weight'] : 'regular',
			'line-height'    => '',
			'letter-spacing' => '',
			'color'          => '',
		);
		// Font-weight is now variant.
		// All values are the same with the exception of 400 (becomes regular).
		if ( '400' == $old_values['variant'] ) {
			$old_values['variant'] = 'regular';
		}
		// Letter spacing was in px, now it requires units.
		if ( isset( $value['letter-spacing'] ) && is_numeric( $value['letter-spacing'] ) && $value['letter-spacing'] ) {
			$value['letter-spacing'] .= 'px';
		}
		$this->json['value'] = wp_parse_args( $value, $old_values );
		// Cleanup.
		if ( isset( $this->json['value']['font-weight'] ) ) {
			unset( $this->json['value']['font-weight'] );
		}
	}

	/**
	 * Don't render any content for this control from PHP.
	 */
	public function render_content() {}
}
