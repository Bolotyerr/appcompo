<?php

/**
 * Theme options / Footer
 *
 * @package vamtam/nex
 */

return array(
	array(
		'label'   => esc_html__( 'Show Footer on One Page Template', 'nex' ),
		'id'      => 'one-page-footer',
		'type'    => 'switch',
	),

	array(
		'label'     => esc_html__( 'Footer Template', 'nex' ),
		'id'        => 'footer-beaver-template',
		'type'      => 'select',
		'choices'   => vamtam_get_beaver_layouts( array(
			'' => esc_html__( '-- Select Template --', 'nex' ),
		) ),
	),

	array(
		'id'    => 'footer-typography-title',
		'label' => esc_html__( 'Typography', 'nex' ),
		'type'  => 'heading',
	),

	array(
		'label'       => esc_html__( 'Widget Areas Titles', 'nex' ),
		'description' => esc_html__( 'Please note that this option will override the general headings style set in the General Typography" tab.', 'nex' ),
		'id'          => 'footer-sidebars-titles',
		'type'        => 'typography',
		'compiler'    => true,
		'transport'   => 'postMessage',
	),
);
