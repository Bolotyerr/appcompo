<?php

/**
 * Theme options / Layout / Body
 *
 * @package vamtam/nex
 */

return array(

	array(
		'label'  => esc_html__( 'Side Widget Areas', 'nex' ),
		'type'   => 'heading',
		'id'     => 'layout-body-regular-sidebars',
	),

	array(
		'label'   => esc_html__( 'Left', 'nex' ),
		'id'      => 'left-sidebar-width',
		'type'    => 'select',
		'choices' => array(
			'33.333333' => '1/3',
			'20' => '1/5',
			'25' => '1/4',
		),
		'compiler'  => true,
		'transport' => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Right', 'nex' ),
		'description' => wp_kses_post( sprintf( __( 'The width of the sidebars is a percentage of the website width. If you have changed this option, please use the <a href="%s" title="Regenerate thumbnails" target="_blank">Regenerate thumbnails</a> plugin in order to update your images.', 'nex' ), 'http://wordpress.org/extend/plugins/regenerate-thumbnails/' ) ),
		'id'          => 'right-sidebar-width',
		'type'        => 'select',
		'choices'     => array(
			'33.333333' => '1/3',
			'20'        => '1/5',
			'25'        => '1/4',
		),
		'compiler'  => true,
		'transport' => 'postMessage',
	),

	array(
		'label'  => esc_html__( 'Styles', 'nex' ),
		'type'   => 'heading',
		'id'     => 'body-styles',
	),

	array(
		'label'       => esc_html__( 'Body Background', 'nex' ),
		'description' => esc_html__( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution. If the color opacity  is less than 1 the page background underneath will be visible.', 'nex' ),
		'id'          => 'main-background',
		'type'        => 'background',
		'compiler'    => true,
		'transport'   => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Hide the Background Image on Lower Resolutions', 'nex' ),
		'id'        => 'main-background-hide-lowres',
		'type'      => 'switch',
		'transport' => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Body Font', 'nex' ),
		'description' => esc_html__( 'This is the general font used in the body and the sidebars. Please note that the styles of the heading fonts are located in the general typography tab.', 'nex' ),
		'id'          => 'primary-font',
		'type'        => 'typography',
		'compiler'    => true,
		'transport'   => 'postMessage',
	),

	array(
		'label'   => esc_html__( 'Links', 'nex' ),
		'type'    => 'color-row',
		'id'      => 'body-link',
		'choices' => array(
			'regular' => esc_html__( 'Regular:', 'nex' ),
			'hover'   => esc_html__( 'Hover:', 'nex' ),
			'visited' => esc_html__( 'Visited:', 'nex' ),
			'active'  => esc_html__( 'Active:', 'nex' ),
		),
		'compiler'  => true,
		'transport' => 'postMessage',
	),

);
