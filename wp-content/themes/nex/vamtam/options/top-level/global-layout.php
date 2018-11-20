<?php

/**
 * Theme options / Layout / General
 *
 * @package vamtam/nex
 */

return array(

	array(
		'label'       => esc_html__( 'Layout Type', 'nex' ),
		'description' => esc_html__( 'Please note that in full width layout mode, the body background option found in Styles - Body, acts as page background.', 'nex' ),
		'id'          => 'site-layout-type',
		'type'        => 'radio',
		'choices'     => array(
			'boxed' => esc_html__( 'Boxed', 'nex' ),
			'full'  => esc_html__( 'Full width', 'nex' ),
		),
	),

	array(
		'label'       => esc_html__( 'Boxed Layout Padding', 'nex' ),
		'description' => esc_html__( 'Add padding between the edge of the box and the page content. Only used on VamTam Builder pages.', 'nex' ),
		'id'          => 'boxed-layout-padding',
		'type'        => 'switch',
	),

	array(
		'label'       => esc_html__( 'Maximum Page Width', 'nex' ),
		'description' => wp_kses_post( sprintf( __( 'If you have changed this option, please use the <a href="%s" title="Regenerate thumbnails" target="_blank">Regenerate thumbnails</a> plugin in order to update your images.', 'nex' ), 'http://wordpress.org/extend/plugins/regenerate-thumbnails/' ) ),
		'id'          => 'site-max-width',
		'type'        => 'radio',
		'choices'     => array(
			1140 => '1140px',
			1260 => '1260px',
			1400 => '1400px',
		),
		'compiler'  => true,
		'transport' => 'postMessage',
	),

);
