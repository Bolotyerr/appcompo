<?php
/**
 * Vamtam Project Format Options
 *
 * @package vamtam/nex
 */

return array(

array(
	'name'      => esc_html__( 'Document', 'nex' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-document',
),

array(
	'name'    => esc_html__( 'How do I use document project format?', 'nex' ),
	'desc'    => esc_html__( 'Use the standard Featured Image option for the project image. Use the editor below for your content. The image will only be shown in the portfolio.You will need "Link" post format if you need the featured image to appear in the post itself.', 'nex' ),
	'type'    => 'info',
	'visible' => true,
),

// --

array(
	'name'      => esc_html__( 'Image', 'nex' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-image',
),

array(
	'name'    => esc_html__( 'How do I use image project format?', 'nex' ),
	'desc'    => esc_html__( 'Use the standard Featured Image option for the project image. Use the editor below for your content. Clicking on the image in the portfolio page will open up the image in a lightbox. You will need "Link" post format if you want clicking on the image to lead to the project post.', 'nex' ),
	'type'    => 'info',
	'visible' => true,
),

// --

array(
	'name'      => esc_html__( 'Gallery', 'nex' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-gallery',
),

array(
	'name'    => esc_html__( 'How do I use gallery project format?', 'nex' ),
	'desc'    => esc_html__( 'Use the "Add Media" button in a text/image block element to create a gallery.This button is also found in the top left side of the visual and text editors.Please note that when the media manager opens up in the lightbox, you have to click on "Create Gallery" on the left and then select the images for your gallery.', 'nex' ),
	'type'    => 'info',
	'visible' => true,
),

// --

array(
	'name'      => esc_html__( 'Video', 'nex' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-video',
),

array(
	'name'    => esc_html__( 'How do I use video project format?', 'nex' ),
	'desc'    => esc_html__( 'Put the url of the video below. You must use an oEmbed provider supported by WordPress or a file supported by the [video] shortcode which comes with WordPress. Vimeo and Youtube are supported.', 'nex' ),
	'type'    => 'info',
	'visible' => true,
),

array(
	'name'    => esc_html__( 'Link', 'nex' ),
	'id'      => 'vamtam-portfolio-format-video',
	'type'    => 'text',
	'only'    => 'jetpack-portfolio',
	'default' => '',
),

// --

array(
	'name'      => esc_html__( 'Link', 'nex' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-link',
),

array(
	'name'    => esc_html__( 'How do I use link project format?', 'nex' ),
	'desc'    => esc_html__( 'Use the standard Featured Image option for the project image. Use the editor below for your content. Put the link in the option below if you want the image in the portfolio to lead to a particular link. If you leave the link field blank, clicking on the image in the portfolio page will open up the project.', 'nex' ),
	'type'    => 'info',
	'visible' => true,
),

array(
	'name'    => esc_html__( 'Link', 'nex' ),
	'id'      => 'vamtam-portfolio-format-link',
	'type'    => 'text',
	'only'    => 'jetpack-portfolio',
	'default' => '',
),

// --

array(
	'name'      => esc_html__( 'HTML', 'nex' ),
	'type'      => 'separator',
	'tab_class' => 'vamtam-post-format-html',
),

array(
	'name'    => esc_html__( 'How do I use HTML project format?', 'nex' ),
	'desc'    => esc_html__( 'Use the standard Featured Image option for the project image. Use the editor below for your content.', 'nex' ),
	'type'    => 'info',
	'visible' => true,
),

array(
	'name'    => esc_html__( 'HTML Content Used for the "HTML" project Type', 'nex' ),
	'id'      => 'portfolio-top-html',
	'type'    => 'textarea',
	'only'    => 'jetpack-portfolio',
	'default' => '',
),

// --

array(
	'name'    => esc_html__( 'Logo', 'nex' ),
	'id'      => 'portfolio-logo',
	'type'    => 'upload',
	'only'    => 'jetpack-portfolio',
	'default' => '',
	'class'   => 'vamtam-all-formats',
),

array(
	'name'    => esc_html__( 'Client', 'nex' ),
	'id'      => 'portfolio-client',
	'type'    => 'text',
	'only'    => 'jetpack-portfolio',
	'default' => '',
	'class'   => 'vamtam-all-formats',
),

);
