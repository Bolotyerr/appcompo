<?php
/**
 * Vamtam Post Options
 *
 * @package vamtam/nex
 */

return array(

array(
	'name' => esc_html__( 'Layout and Styles', 'nex' ),
	'type' => 'separator',
),

array(
	'name'    => esc_html__( 'Page Slider', 'nex' ),
	'desc'    => esc_html__( 'In the drop down you will see the sliders that you have created. Please note that the theme uses Revolution Slider and its option panel is found in the WordPress navigation menu on the left.', 'nex' ),
	'id'      => 'slider-category',
	'type'    => 'select',
	'default' => '',
	'prompt'  => esc_html__( 'Disabled', 'nex' ),
	'options' => VamtamTemplates::get_all_sliders(),
),

array(
	'name'        => esc_html__( 'Show Splash Screen', 'nex' ),
	'desc'        => esc_html__( 'This option is useful if you have video backgrounds, featured slider, galleries or other elements that may load slowly.', 'nex' ),
	'id'          => 'show-splash-screen-local',
	'type'        => 'toggle',
	'default'     => 'default',
	'has_default' => true,
),

array(
	'name'    => esc_html__( 'Header Featured Area', 'nex' ),
	'desc'    => esc_html__( 'The contents of this option are placed below the header slider, even if the slider is disabled. You can place plain text or HTML into it.', 'nex' ),
	'id'      => 'page-middle-header-type',
	'type'    => 'select',
	'options' => vamtam_get_beaver_layouts( array(
		'text' => esc_html__( 'Text', 'nex' ),
		''     => esc_html__( '-- Select Layout--', 'nex' ),
	) ),
	'default'      => 'text',
	'field_filter' => 'headerfeaturedarea',
),

array(
	'name'    => esc_html__( 'Header Featured Area (Text Contents)', 'nex' ),
	'id'      => 'page-middle-header-content',
	'type'    => 'textarea',
	'default' => '',
	'class'   => 'headerfeaturedarea headerfeaturedarea-text',
),

array(
	'name'    => esc_html__( 'Full Width Header Featured Area', 'nex' ),
	'desc'    => esc_html__( 'Extend the featured area to the end of the screen. This is basicly a full screen mode.', 'nex' ),
	'id'      => 'page-middle-header-content-fullwidth',
	'type'    => 'toggle',
	'default' => 'false',
),

array(
	'name'    => esc_html__( 'Header Featured Area Minimum Height', 'nex' ),
	'desc'    => esc_html__( 'Please note that this option does not affect the slider height. The slider height is controled from the LayerSlider option panel.', 'nex' ),
	'id'      => 'page-middle-header-min-height',
	'type'    => 'range',
	'default' => 0,
	'min'     => 0,
	'max'     => 1000,
	'unit'    => 'px',
),

array(
	'name'  => esc_html__( 'Featured Area / Slider Background', 'nex' ),
	'desc'  => esc_html__( 'This option is used for the featured area and header slider.<br>If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'nex' ),
	'id'    => 'local-title-background',
	'type'  => 'background',
	'show'  => 'color,image,repeat,size',
),

array(
	'name'    => esc_html__( 'Header Behaviour', 'nex' ),
	'id'      => 'sticky-header-type',
	'type'    => 'select',
	'default' => 'normal',
	'desc'    => esc_html__( 'Please make sure you have the sticky header enabled in theme options - layout - header.', 'nex' ),
	'options' => array(
		'normal' => esc_html__( 'Normal', 'nex' ),
		'over'   => esc_html__( 'Over the page content', 'nex' ),
		'below'  => esc_html__( 'Below the slider', 'nex' ),
	),
),

array(
	'name'    => esc_html__( 'Show Page Title Area', 'nex' ),
	'desc'    => esc_html__( 'Enables the area used by the page title.', 'nex' ),
	'id'      => 'show-page-header',
	'type'    => 'toggle',
	'default' => true,
),

array(
	'name'    => esc_html__( 'Page Title Layout', 'nex' ),
	'id'      => 'local-page-title-layout',
	'type'    => 'select',
	'desc'    => esc_html__( 'The first row is the Title, the second row is the Description. The description can be added in the local option panel just below the editor.', 'nex' ),
	'default' => '',
	'prompt'  => esc_html__( 'Default', 'nex' ),
	'options' => array(
		'centered'      => esc_html__( 'Two rows, centered', 'nex' ),
		'one-row-left'  => esc_html__( 'One row, title on the left', 'nex' ),
		'one-row-right' => esc_html__( 'One row, title on the right', 'nex' ),
		'left-align'    => esc_html__( 'Two rows, left-aligned', 'nex' ),
		'right-align'   => esc_html__( 'Two rows, right-aligned', 'nex' ),
	),
),

array(
	'name'  => esc_html__( 'Page Title Background', 'nex' ),
	'id'    => 'local-page-title-background',
	'type'  => 'background',
	'show'  => 'color,image,repeat,size,attachment',
),

array(
	'name'    => esc_html__( 'Page Title Shadow', 'nex' ),
	'id'      => 'has-page-title-shadow',
	'type'    => 'toggle',
	'default' => false,
),

array(
	'name'  => esc_html__( 'Page Title Color Override', 'nex' ),
	'id'    => 'local-page-title-color',
	'type'  => 'color',
),

array(
	'name'    => esc_html__( 'Description', 'nex' ),
	'desc'    => esc_html__( 'The text will appear next or bellow the title of the page, only if the option above is enabled.', 'nex' ),
	'id'      => 'description',
	'type'    => 'textarea',
	'default' => '',
),

array(
	'name' => esc_html__( 'Page Background', 'nex' ),
	'desc' => wp_kses_post( __('Please note that this option is used only in boxed layout mode.<br>
In full width layout mode the page background is covered by the header, slider, body and footer backgrounds respectively.<br>
If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.<br>
You can override this option on a page by page basis.', 'nex') ),
	'id'   => 'background',
	'type' => 'background',
	'show' => 'color,image,repeat,size,attachment',
),

array(
	'name' => esc_html__( 'Body Background', 'nex' ),
	'desc' => esc_html__( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'nex' ),
	'id'   => 'local-main-background',
	'type' => 'background',
	'show' => 'color,image,repeat,size,attachment',
),

);
