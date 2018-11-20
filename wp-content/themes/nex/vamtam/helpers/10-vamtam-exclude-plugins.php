<?php

function vamtam_exclude_plugins( $plugins ) {
	if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX || ! isset( $_POST['action'] ) || 'vamtam-compile-less' !== $_POST['action'] ) {
		return $plugins;
	}

	return array();
}

add_filter( 'option_active_plugins', 'vamtam_exclude_plugins' );
