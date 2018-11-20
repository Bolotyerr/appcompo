<?php

function vamtam_silent_fs() {
	add_filter( 'filesystem_method', 'vamtam_filesystem_method_direct' );
}

function vamtam_normal_fs() {
	remove_filter( 'filesystem_method', 'vamtam_filesystem_method_direct' );
}

function vamtam_filesystem_method_direct( $method ) {
	return 'direct';
}

function vamtam_silent_get_contents( $path ) {
	global $wp_filesystem;

	vamtam_silent_fs();

	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$contents = $wp_filesystem->get_contents( $path );

	vamtam_normal_fs();

	return $contents;
}

function vamtam_silent_put_contents( $path, $contents ) {
	global $wp_filesystem;

	vamtam_silent_fs();

	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$ret = $wp_filesystem->put_contents( $path, $contents );

	vamtam_normal_fs();

	return $ret;
}
