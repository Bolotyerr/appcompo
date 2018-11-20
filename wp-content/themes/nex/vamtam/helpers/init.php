<?php

/**
 * Basic wrappers around WP core functions
 *
 * This file is loaded early by the theme
 *
 * @package vamtam/nex
 */

/**
 * get_option wrapper
 *
 * @uses   get_option()
 *
 * @param  string $name option   name
 * @param  mixed  $default       default value
 * @param  bool   $stripslashes  whether to filter the result with stripslashes()
 *
 * @return mixed                 option value
 */

function vamtam_get_option( $name, $default = null, $stripslashes = true ) {
	global $vamtam_defaults;

	$default_arg = $default;
	if ( $default === null ) {
		$default = isset( $vamtam_defaults[ $name ] ) ? $vamtam_defaults[ $name ] : false;
	}

	$option = get_option( 'vamtam_' . $name, $default );

	if ( is_string( $option ) ) {
		if ( $option === 'true' ) {
			return true;
		}

		if ( $option === 'false' ) {
			return false;
		}

		if ( $stripslashes && $option !== $default_arg ) {
			return stripslashes( $option );
		}
	}

	return $option;
}

function rd_vamtam_get_option( $name, $sub = null ) {
	global $vamtam_theme, $vamtam_defaults;

	$option = isset( $vamtam_theme[ $name ] ) ? $vamtam_theme[ $name ] : $vamtam_defaults[ $name ];

	if ( ! is_null( $sub ) && is_array( $option ) ) {
		$option = $option[ $sub ];
	}

	if ( is_string( $option ) ) {
		if ( $option === 'true' ) {
			$option = true;
		} elseif ( $option === 'false' ) {
			$option = false;
		}
	}

	return apply_filters( 'vamtam_get_option', $option, $name, $sub );
}

/**
 * Same as vamtam_get_option, but converts '1' and '0' to booleans
 *
 * @uses   vamtam_get_option()
 *
 * @param  string $name option   name
 * @param  mixed  $default       default value
 * @param  bool   $stripslashes  whether to filter the result with stripslashes()
 *
 * @return mixed                 option value
 */
function vamtam_get_optionb( $name, $default = null, $stripslashes = true ) {
	$value = vamtam_get_option( $name, $default, $stripslashes );

	if ( $value === '1' || $value === 'true' ) {
		return true;
	}

	if ( $value === '0' || $value === 'false' ) {
		return false;
	}

	return $value;
}

function rd_vamtam_get_optionb( $name, $sub = null ) {
	$value = rd_vamtam_get_option( $name, $sub );

	if ( $value === '1' || $value === 'true' ) {
		return true;
	}

	if ( $value === '0' || $value === 'false' ) {
		return false;
	}

	return is_bool( $value ) ? $value : false;
}

/**
 * update_option() wrapper
 *
 * @uses   update_option()
 *
 * @param  string $name      option name
 * @param  mixed  $new_value option value
 */
function vamtam_update_option( $name, $new_value ) {
	update_option( 'vamtam_' . $name, $new_value );
}

/**
 * delete_option wrapper
 *
 * @uses   delete_option()
 *
 * @param  string $name option name
 */
function vamtam_delete_option( $name ) {
	delete_option( 'vamtam_' . $name );
}

/**
 * Converts '1', '0', 'true' and 'false' to booleans, otherwise returns $value
 * @param  mixed $value original value
 * @return mixed        sanitized value
 */
function vamtam_sanitize_bool( $value ) {
	if ( $value === '1' || $value === 'true' ) {
		return true;
	}

	if ( $value === '0' || $value === 'false' ) {
		return false;
	}

	return $value;
}
