<?php

/**
 * Theme options / General / Projects
 *
 * @package vamtam/nex
 */

return array(
	array(
		'label'       => esc_html__( 'Show "Related Projects" in Single Project View', 'nex' ),
		'description' => esc_html__( 'Enabling this option will show more projects from the same type in the single project.', 'nex' ),
		'id'          => 'show-related-portfolios',
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'     => esc_html__( '"Related Projects" title', 'nex' ),
		'id'        => 'related-portfolios-title',
		'type'      => 'text',
		'transport' => 'postMessage',
	),
);
