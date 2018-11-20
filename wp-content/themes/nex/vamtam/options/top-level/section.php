<?php

/**
 * Top level sections without panels
 *
 * @package vamtam/nex
 */

global $vamtam_theme_customizer;

$thispath = VAMTAM_OPTIONS . 'top-level/';

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Global Layout', 'nex' ),
	'id'          => 'global-layout',
	'description' => '',
	'fields'      => include $thispath . 'global-layout.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Global Styles', 'nex' ),
	'id'          => 'global-styles',
	'description' => '',
	'fields'      => include $thispath . 'global-styles.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Global Typography', 'nex' ),
	'id'          => 'global-typography',
	'description' => wp_kses_post( __( 'The options bellow are used for headings, titles and emphasizing text in different parts of the website.<br> Please note that some of the options for styling text are present in header, body and footer tabs as they are specific only to each area - for example, main menu, body general text, footer widget titles, etc.', 'nex' ) ),
	'fields'      => include $thispath . 'global-typography.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Top Bar', 'nex' ),
	'id'          => 'top-bar',
	'description' => '',
	'fields'      => include $thispath . 'top-bar.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Header', 'nex' ),
	'id'          => 'header',
	'description' => '',
	'fields'      => include $thispath . 'header.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Body', 'nex' ),
	'id'          => 'body',
	'description' => '',
	'fields'      => include $thispath . 'body.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Footer', 'nex' ),
	'id'          => 'footer',
	'description' => '',
	'fields'      => include $thispath . 'footer.php',
) );
