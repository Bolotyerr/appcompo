<?php
/**
 * Vamtam Post Format Options
 *
 * @package vamtam/nex
 */

return array(

array(
	'name' => esc_html__( 'Standard', 'nex' ),
	'type' => 'separator',
	'tab_class' => 'vamtam-post-format-0',
),

array(
	'name' => esc_html__( 'How do I use standard post format?', 'nex' ),
	'desc' => esc_html__( 'Just use the editor below.', 'nex' ),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => esc_html__( 'Aside', 'nex' ),
	'type' => 'separator',
	'tab_class' => 'vamtam-post-format-aside',
),

array(
	'name' => esc_html__( 'How do I use aside post format?', 'nex' ),
	'desc' => esc_html__( 'Just use the editor below. The post title will not be shown publicly.', 'nex' ),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => esc_html__( 'Link', 'nex' ),
	'type' => 'separator',
	'tab_class' => 'vamtam-post-format-link',
),

array(
	'name' => esc_html__( 'How do I use link post format?', 'nex' ),
	'desc' => esc_html__( 'Use the editor below for the post body, put the link in the option below.', 'nex' ),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => esc_html__( 'Link', 'nex' ),
	'id' => 'vamtam-post-format-link',
	'type' => 'text',
),

// --

array(
	'name' => esc_html__( 'Image', 'nex' ),
	'type' => 'separator',
	'tab_class' => 'vamtam-post-format-image',
),

array(
	'name' => esc_html__( 'How do I use image post format?', 'nex' ),
	'desc' => esc_html__( 'Use the standard Featured Image option.', 'nex' ),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => esc_html__( 'Video', 'nex' ),
	'type' => 'separator',
	'tab_class' => 'vamtam-post-format-video',
),

array(
	'name' => esc_html__( 'How do I use video post format?', 'nex' ),
	'desc' => esc_html__( 'Put the url of the video below. You must use an oEmbed provider supported by WordPress or a file supported by the [video] shortcode which comes with WordPress.', 'nex' ),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => esc_html__( 'Link', 'nex' ),
	'id' => 'vamtam-post-format-video-link',
	'type' => 'text',
),

// --

array(
	'name' => esc_html__( 'Audio', 'nex' ),
	'type' => 'separator',
	'tab_class' => 'vamtam-post-format-audio',
),

array(
	'name' => esc_html__( 'How do I use auido post format?', 'nex' ),
	'desc' => esc_html__( 'Put the url of the audio below. You must use an oEmbed provider supported by WordPress or a file supported by the [audio] shortcode which comes with WordPress.', 'nex' ),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => esc_html__( 'Link', 'nex' ),
	'id' => 'vamtam-post-format-audio-link',
	'type' => 'text',
),

// --

array(
	'name' => esc_html__( 'Quote', 'nex' ),
	'type' => 'separator',
	'tab_class' => 'vamtam-post-format-quote',
),

array(
	'name' => esc_html__( 'How do I use quote post format?', 'nex' ),
	'desc' => esc_html__( 'Simply fill in author and link fields', 'nex' ),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => esc_html__( 'Author', 'nex' ),
	'id' => 'vamtam-post-format-quote-author',
	'type' => 'text',
),

array(
	'name' => esc_html__( 'Link', 'nex' ),
	'id' => 'vamtam-post-format-quote-link',
	'type' => 'text',
),

// --

array(
	'name' => esc_html__( 'Gallery', 'nex' ),
	'type' => 'separator',
	'tab_class' => 'vamtam-post-format-gallery',
),

array(
	'name' => esc_html__( 'How do I use gallery post format?', 'nex' ),
	'desc' => esc_html__( 'Use the "Add Media" in a text/image block element to create a gallery.This button is also found in the top left side of the visual and text editors.', 'nex' ),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => esc_html__( 'Status', 'nex' ),
	'type' => 'separator',
	'tab_class' => 'vamtam-post-format-status',
),

array(
	'name' => esc_html__( 'How do I use this post format?', 'nex' ),
	'desc' => esc_html__( '...', 'nex' ),
	'type' => 'info',
	'visible' => true,
),

);
