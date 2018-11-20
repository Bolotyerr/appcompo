<?php

/**
 * Controls attached to core sections
 *
 * @package vamtam/nex
 */


return array(
	array(
		'label'     => esc_html__( 'Header Logo Type', 'nex' ),
		'id'        => 'header-logo-type',
		'type'      => 'switch',
		'transport' => 'postMessage',
		'section'   => 'title_tagline',
		'choices'   => array(
			'image'      => esc_html__( 'Image', 'nex' ),
			'site-title' => esc_html__( 'Site Title', 'nex' ),
		),
	),

	array(
		'label'       => esc_html__( 'Custom Logo Picture', 'nex' ),
		'description' => esc_html__( 'Please Put a logo which exactly twice the width and height of the space that you want the logo to occupy. The real image size is used for retina displays.', 'nex' ),
		'id'          => 'custom-header-logo',
		'type'        => 'image',
		'transport'   => 'postMessage',
		'section'     => 'title_tagline',
	),

	array(
		'label'       => esc_html__( 'Alternative Logo', 'nex' ),
		'description' => esc_html__( 'This logo is used when you are using the transparent sticky header. It must be the same size as the main logo.', 'nex' ),
		'id'          => 'custom-header-logo-transparent',
		'type'        => 'image',
		'transport'   => 'postMessage',
		'section'     => 'title_tagline',
	),

	array(
		'label'       => esc_html__( 'Show Splash Screen', 'nex' ),
		'description' => esc_html__( 'This option is useful if you have video backgrounds, featured slider, galleries or other elements that may load slowly. You may override this setting for a specific page using the local options.', 'nex' ),
		'id'          => 'show-splash-screen',
		'type'        => 'switch',
		'transport'   => 'postMessage',
		'section'     => 'title_tagline',
	),

	array(
		'label'     => esc_html__( 'Splash Screen Logo', 'nex' ),
		'id'        => 'splash-screen-logo',
		'type'      => 'image',
		'transport' => 'postMessage',
		'section'   => 'title_tagline',
	),

	array(
		'label'    => esc_html__( 'Sitemap page', 'nex' ),
		'id'       => 'sitemap-page',
		'type'     => 'dropdown-pages',
		'section'  => 'static_front_page',
		'priority' => 11,
	),

	array(
		'label'    => esc_html__( 'Maintenance mode page', 'nex' ),
		'id'       => 'maintenance-page',
		'type'     => 'dropdown-pages',
		'section'  => 'static_front_page',
		'priority' => 12,
	),
);
