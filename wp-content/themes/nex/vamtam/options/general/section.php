<?php

global $vamtam_theme_customizer;

$thispath = VAMTAM_OPTIONS . 'general/';

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'General', 'nex' ),
	'description' => '',
	'id'          => 'general',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'General', 'nex' ),
	'description' => '',
	'id'          => 'general-general',
	'subsection'  => true,
	'fields'      => include $thispath . 'general.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Posts', 'nex' ),
	'description' => '',
	'id'          => 'general-posts',
	'subsection'  => true,
	'fields'      => include $thispath . 'posts.php',
) );

$vamtam_theme_customizer->add_section( array(
	'title'       => esc_html__( 'Projects', 'nex' ),
	'description' => '',
	'id'          => 'general-projects',
	'subsection'  => true,
	'fields'      => include $thispath . 'projects.php',
) );
