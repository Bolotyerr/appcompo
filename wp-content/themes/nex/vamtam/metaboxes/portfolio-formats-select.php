<?php
/**
 * Vamtam Project Format Selector
 *
 * @package vamtam/nex
 */

return array(

array(
	'name' => esc_html__( 'Project Format', 'nex' ),
	'type' => 'separator',
),

array(
	'name' => esc_html__( 'Project Data Type', 'nex' ),
	'desc' => wp_kses_post( __('Image - uses the featured image (default)<br />
				  Gallery - use the featured image as a title image but show additional images too<br />
				  Video/Link - uses the "portfolio data url" setting<br />
				  Document - acts like a normal post<br />
				  HTML - overrides the image with arbitrary HTML when displaying a single project.
				', 'nex') ),
	'id'      => 'portfolio_type',
	'type'    => 'radio',
	'options' => array(
		'image'    => esc_html__( 'Image', 'nex' ),
		'gallery'  => esc_html__( 'Gallery', 'nex' ),
		'video'    => esc_html__( 'Video', 'nex' ),
		'link'     => esc_html__( 'Link', 'nex' ),
		'document' => esc_html__( 'Document', 'nex' ),
		'html'     => esc_html__( 'HTML', 'nex' ),
	),
	'default' => 'image',
),

array(
	'name'    => esc_html__( 'Featured Project', 'nex' ),
	'id'      => 'featured-project',
	'type'    => 'checkbox',
	'default' => false,
),

);
