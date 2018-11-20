<?php

/**
 * Displays social sharing buttons
 *
 * @package vamtam/nex
 */

if ( function_exists( 'sharing_display' ) ) {
	sharing_display( '', true );
}

if ( class_exists( 'Jetpack_Likes' ) ) {
	$custom_likes = new Jetpack_Likes;
	echo $custom_likes->post_likes( '' ); // xss ok
}
