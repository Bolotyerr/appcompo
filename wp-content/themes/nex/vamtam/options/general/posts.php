<?php

/**
 * Theme options / General / Posts
 *
 * @package vamtam/nex
 */

return array(

	array(
		'label'       => esc_html__( 'Pagination Type', 'nex' ),
		'description' => esc_html__( 'Also used for portfolio', 'nex' ),
		'id'          => 'pagination-type',
		'type'        => 'select',
		'choices'     => array(
			'paged'              => esc_html__( 'Paged', 'nex' ),
			'load-more'          => esc_html__( 'Load more button', 'nex' ),
			'infinite-scrolling' => esc_html__( 'Infinite scrolling', 'nex' ),
		),
	),

	array(
		'label'       => esc_html__( 'Show "Related Posts" in Single Post View', 'nex' ),
		'description' => esc_html__( 'Enabling this option will show more posts from the same category when viewing a single post.', 'nex' ),
		'id'          => 'show-related-posts',
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'     => esc_html__( '"Related Posts" title', 'nex' ),
		'id'        => 'related-posts-title',
		'type'      => 'text',
		'transport' => 'postMessage',
	),

	array(
		'label'     => esc_html__( 'Meta Information', 'nex' ),
		'id'        => 'post-meta',
		'type'      => 'multicheck',
		'transport' => 'postMessage',
		'choices'   => array(
			'author'   => esc_html__( 'Post Author', 'nex' ),
			'tax'      => esc_html__( 'Categories and Tags', 'nex' ),
			'date'     => esc_html__( 'Timestamp', 'nex' ),
			'comments' => esc_html__( 'Comment Count', 'nex' ),
		),
	),

	array(
		'label'       => esc_html__( 'Show Featured Image on Single Posts', 'nex' ),
		'id'          => 'show-single-post-image',
		'description' => esc_html__( 'Please note, that this option works only for Blog Post Format Image.', 'nex' ),
		'type'        => 'switch',
		'transport'   => 'postMessage',
	),

	array(
		'label'       => esc_html__( 'Post Archive Layout', 'nex' ),
		'description' => '',
		'id'          => 'archive-layout',
		'type'        => 'radio',
		'choices'     => array(
			'normal' => esc_html__( 'Large', 'nex' ),
			'mosaic' => esc_html__( 'Small', 'nex' ),
		),
	),

);
