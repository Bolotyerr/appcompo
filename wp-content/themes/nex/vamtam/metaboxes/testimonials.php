<?php
/**
 * Vamtam Post Options
 *
 * @package vamtam/nex
 */

return array(

array(
	'name' => esc_html__( 'General', 'nex' ),
	'type' => 'separator',
),

array(
	'name'    => esc_html__( 'Cite', 'nex' ),
	'id'      => 'testimonial-author',
	'default' => '',
	'type'    => 'text',
) ,

array(
	'name'    => esc_html__( 'Link', 'nex' ),
	'id'      => 'testimonial-link',
	'default' => '',
	'type'    => 'text',
) ,

array(
	'name'    => esc_html__( 'Rating', 'nex' ),
	'id'      => 'testimonial-rating',
	'default' => 5,
	'type'    => 'range',
	'min'     => 0,
	'max'     => 5,
) ,

array(
	'name'    => esc_html__( 'Summary', 'nex' ),
	'id'      => 'testimonial-summary',
	'default' => '',
	'type'    => 'text',
) ,

);
