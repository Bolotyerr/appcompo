<?php
/**
 * Theme options / Styles / General Typography
 *
 * @package vamtam/nex
 */

return array(

array(
	'label'  => esc_html__( 'Headlines', 'nex' ),
	'type'   => 'heading',
	'id'     => 'styles-typography-headlines',
),

array(
	'label'      => esc_html__( 'H1', 'nex' ),
	'id'         => 'h1',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
),

array(
	'label'      => esc_html__( 'H2', 'nex' ),
	'id'         => 'h2',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
),

array(
	'label'      => esc_html__( 'H3', 'nex' ),
	'id'         => 'h3',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
),

array(
	'label'      => esc_html__( 'H4', 'nex' ),
	'id'         => 'h4',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
),

array(
	'label'      => esc_html__( 'H5', 'nex' ),
	'id'         => 'h5',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
),

array(
	'label'      => esc_html__( 'H6', 'nex' ),
	'id'         => 'h6',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
),

array(
	'label'  => esc_html__( 'Additional Fonts', 'nex' ),
	'type'   => 'heading',
	'id'     => 'styles-typography-additional',
),

array(
	'label'      => esc_html__( 'Emphasis Font', 'nex' ),
	'id'         => 'em',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
),

array(
	'label'      => esc_html__( 'Style 1', 'nex' ),
	'id'         => 'additional-font-1',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
),

array(
	'label'      => esc_html__( 'Style 2', 'nex' ),
	'id'         => 'additional-font-2',
	'type'       => 'typography',
	'compiler'   => true,
	'transport'  => 'postMessage',
),

array(
	'label'  => esc_html__( 'Google Fonts Options', 'nex' ),
	'type'   => 'heading',
	'id'     => 'styles-typography-gfonts',
),

array(
	'label'      => esc_html__( 'Subsets', 'nex' ),
	'id'         => 'gfont-subsets',
	'type'       => 'multicheck',
	'transport'  => 'postMessage',
	'choices'    => vamtam_get_google_fonts_subsets(),
),

);
