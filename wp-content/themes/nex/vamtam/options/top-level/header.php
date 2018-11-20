<?php

/**
 * Theme options /Header
 *
 * @package vamtam/nex
 */

return array(

	array(
		'label'     => esc_html__( 'Header Layout', 'nex' ),
		'type'      => 'image-select',
		'id'        => 'header-layout',
		'transport' => 'postMessage',
		'choices'   => array(
			'logo-menu' => array(
				'alt'  => esc_html__( 'One row, left logo, menu on the right', 'nex' ),
				'img'  => VAMTAM_ADMIN_ASSETS_URI . 'images/header-layout-1.png',
			),
			'logo-text-menu' => array(
				'alt' => esc_html__( 'Two rows; left-aligned logo on top, right-aligned text and search', 'nex' ),
				'img' => VAMTAM_ADMIN_ASSETS_URI . 'images/header-layout-2.png',
			),
			'standard' => array(
				'alt' => esc_html__( 'Two rows; centered logo on top', 'nex' ),
				'img' => VAMTAM_ADMIN_ASSETS_URI . 'images/header-layout-3.png',
			),
			'overlay-menu' => array(
				'alt' => esc_html__( 'One row with overlay menu', 'nex' ),
				'img' => VAMTAM_ADMIN_ASSETS_URI . 'images/header-layout-overlay.png',
			),
		),
	),

	array(
		'label'       => esc_html__( 'Header Height', 'nex' ),
		'description' => esc_html__( 'This is the area above the slider. Includes the height of the menu for two line header layouts.', 'nex' ),
		'id'          => 'header-height',
		'type'        => 'number',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'input_attrs' => array(
			'min' => 30,
			'max' => 300,
		),
	),
	array(
		'label'       => esc_html__( 'Sticky Header', 'nex' ),
		'description' => esc_html__( 'This option is switched off automatically for mobile devices because the animation is not well supported by the majority of the mobile devices.', 'nex' ),
		'id'          => 'sticky-header',
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Enable Header Search', 'nex' ),
		'id'        => 'enable-header-search',
		'type'      => 'switch',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Show Empty WooCommerce Cart in Header', 'nex' ),
		'id'        => 'show-empty-header-cart',
		'type'      => 'switch',
		'transport' => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Full Width Header', 'nex' ),
		'description' => esc_html__( 'One row header only', 'nex' ),
		'id'          => 'full-width-header',
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Header Text Area', 'nex' ),
		'description' => esc_html__( 'You can place text/HTML or any shortcode in this field. The text will appear in the header on the left hand side.', 'nex' ),
		'id'          => 'header-text-main',
		'type'        => 'textarea',
		'transport'   => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Header Background', 'nex' ),
		'description' => wp_kses_post( __( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'nex' ) ),
		'id'          => 'header-background',
		'type'        => 'background',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'show'        => array(
			'background-position' => false,
		),
	),

	array(
		'label'       => esc_html__( 'Sub-Header Background', 'nex' ),
		'id'          => 'sub-header-background',
		'type'        => 'background',
		'compiler'    => true,
		'transport'   => 'postMessage',
		'show'        => array(
			'background-attachment' => false,
			'background-position'   => false,
		),
	),

	array(
		'label'       => esc_html__( 'Page Title Layout', 'nex' ),
		'id'          => 'page-title-layout',
		'description' => esc_html__( 'The first row is the Title, the second row is the Description. The description can be added in the local option panel just below the editor.', 'nex' ),
		'type'        => 'select',
		'transport'   => 'postMessage',
		'choices'     => array(
			'centered'      => esc_html__( 'Two rows, Centered', 'nex' ),
			'one-row-left'  => esc_html__( 'One row, title on the left', 'nex' ),
			'one-row-right' => esc_html__( 'One row, title on the right', 'nex' ),
			'left-align'    => esc_html__( 'Two rows, left-aligned', 'nex' ),
			'right-align'   => esc_html__( 'Two rows, right-aligned', 'nex' ),
		),
	),

	array(
		'label'     => esc_html__( 'Page Title Background', 'nex' ),
		'id'        => 'page-title-background',
		'type'      => 'background',
		'compiler'  => true,
		'transport' => 'postMessage',
		'show'      => array(
			'background-attachment' => false,
			'background-position'   => false,
		),
	),

	array(
		'label'     => esc_html__( 'Hide Page Title Background Image on Lower Resolutions', 'nex' ),
		'id'        => 'page-title-background-hide-lowres',
		'type'      => 'switch',
		'transport' => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Site Title', 'nex' ),
		'id'          => 'logo',
		'type'        => 'typography',
		'compiler'    => true,
		'transport'   => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Text Color for Transparent Header', 'nex' ),
		'type'      => 'color',
		'id'        => 'main-menu-text-sticky-color',
		'compiler'  => true,
		'transport' => 'postMessage',
	),

	array(
		'id'          => 'info-menu-styles',
		'type'        => 'info',
		'label'       => esc_html__( 'Menu Styles', 'nex' ),
		'description' => wp_kses_post( sprintf( __( 'Menu styling options are available <a href="%s" title="Max Mega Menu" target="_blank">here</a> if you have the Max Mega Menu plugin installed.', 'nex' ), admin_url( 'admin.php?page=maxmegamenu_theme_editor' ) ) ),
	),

	array(
		'id'   => 'info-mobile-header-layout',
		'type' => 'info',
		'description' => wp_kses_post( sprintf( __( 'Mobile header layout options are available <a href="%s" title="Max Mega Menu" target="_blank">here</a> if you have Max Mega Menu installed.', 'nex' ), admin_url( 'admin.php?page=maxmegamenu' ) ) ),
	),

);
