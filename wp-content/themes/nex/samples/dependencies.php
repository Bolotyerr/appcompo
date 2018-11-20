<?php

/**
 * Declare plugin dependencies
 *
 * @package vamtam/nex
 */

/**
 * Declare plugin dependencies
 */
function vamtam_register_required_plugins() {
	$plugins = array(
		// this is a feature plugin,
		// will be removed when it's merged in WP Core
		array(
			'name'     => esc_html__( 'Safe SVG', 'nex' ),
			'slug'     => 'safe-svg',
			'required' => true,
		),

		array(
			'name'     => esc_html__( 'Jetpack', 'nex' ),
			'slug'     => 'jetpack',
			'required' => true,
		),

		array(
			'name'     => esc_html__( 'Unplug Jetpack', 'nex' ),
			'slug'     => 'unplug-jetpack',
			'required' => true,
		),

		array(
			'name'     => esc_html__( 'Beaver Builder - WordPress Page Builder', 'nex' ),
			'slug'     => 'beaver-builder-lite-version',
			'required' => true,
		),

		array(
			'name'     => esc_html__( 'WP Retina 2x', 'nex' ),
			'slug'     => 'wp-retina-2x',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Max Mega Menu', 'nex' ),
			'slug'     => 'megamenu',
			'required' => true,
		),

		array(
			'name'     => esc_html__( 'Ninja Forms', 'nex' ),
			'slug'     => 'ninja-forms',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'WooCommerce', 'nex' ),
			'slug'     => 'woocommerce',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'The Events Calendar', 'nex' ),
			'slug'     => 'the-events-calendar',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Event Tickets', 'nex' ),
			'slug'     => 'event-tickets',
			'required' => false,
		),


		array(
			'name'     => esc_html__( 'Vamtam Elements (B)', 'nex' ),
			'slug'     => 'vamtam-elements-b',
			'source'   => VAMTAM_PLUGINS . 'vamtam-elements-b.zip',
			'required' => true,
		),

		array(
			'name'     => esc_html__( 'Vamtam Importers', 'nex' ),
			'slug'     => 'vamtam-importers',
			'source'   => VAMTAM_PLUGINS . 'vamtam-importers.zip',
			'required' => false,
		),

		array(
			'name'     => esc_html__( 'Revolution Slider', 'nex' ),
			'slug'     => 'revslider',
			'source'   => VAMTAM_PLUGINS . 'revslider.zip',
			'required' => false,
		),

		array(
			'name'         => 'Booked',
			'slug'         => 'booked',
			'required'     => false,
			'source'       => 'https://boxyupdates.com/get/?action=download&slug=booked',
			'external_url' => 'https://boxyupdates.com/get/?action=download&slug=booked',
		),

		array(
			'name'         => 'Booked Add On- Payments with WooCommerce',
			'slug'         => 'booked-woocommerce-payments',
			'source'       => 'https://boxyupdates.com/get/?action=download&slug=booked-woocommerce-payments',
			'external_url' => 'https://boxyupdates.com/get/?action=download&slug=booked-woocommerce-payments',
			'required'     => false,
		),
		array(
			'name'         => 'Booked Add On- Calendar Feeds',
			'slug'         => 'booked-calendar-feeds',
			'source'       => 'https://boxyupdates.com/get/?action=download&slug=booked-calendar-feeds',
			'external_url' => 'https://boxyupdates.com/get/?action=download&slug=booked-calendar-feeds',
			'required'     => false,
		),
		array(
			'name'         => 'Booked Add On- Front-End Agents',
			'slug'         => 'booked-frontend-agents',
			'source'       => 'https://boxyupdates.com/get/?action=download&slug=booked-frontend-agents',
			'external_url' => 'https://boxyupdates.com/get/?action=download&slug=booked-frontend-agents',
			'required'     => false,
		),

		array(
			'name'     => esc_html__( 'Easy Charts', 'nex' ),
			'slug'     => 'easy-charts',
			'required' => false,
		),
	);

	$config = array(
		'default_path' => '',    // Default absolute path to pre-packaged plugins
		'is_automatic' => true,  // Automatically activate plugins after installation or not
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'vamtam_register_required_plugins' );
