<?php

/**
 *
 * @desc registers a theme activation hook
 * @param string $code : Code of the theme. This can be the base folder of your theme. Eg if your theme is in folder 'mytheme' then code will be 'mytheme'
 * @param callback $function : Function to call when theme gets activated.
 */
function vamtam_register_theme_activation_hook( $code, $function ) {
	$optionKey = 'theme_is_activated_' . $code;
	if ( ! get_option( $optionKey ) ) {
		call_user_func( $function );
		update_option( $optionKey , 1 );
	}
}

// theme activation hook
function vamtam_theme_activated() {
	if ( vamtam_validate_install() ) {
		vamtam_register_theme_activation_hook( 'vamtam_' . VAMTAM_THEME_NAME, 'vamtam_theme_activated' );

		// disable jetpack likes & comments modules on activation
		$jetpack_opt_name = 'jetpack_active_modules';
		update_option( $jetpack_opt_name, array_diff( get_option( $jetpack_opt_name, array() ), array( 'likes', 'comments' ) ) );

		require_once VAMTAM_DIR . 'classes/plugin-activation.php';
		require_once VAMTAM_SAMPLES_DIR . 'dependencies.php';

		if ( class_exists( 'TGM_Plugin_Activation' ) ) {
			if ( did_action( 'tgmpa_register' ) ) {
				vamtam_maybe_redirect_to_tgmpa();
			} else {
				add_action( 'tgmpa_register', 'vamtam_maybe_redirect_to_tgmpa', 1000, 1 );
			}
		}
	}
}

function vamtam_maybe_redirect_to_tgmpa() {
	if ( ! TGM_Plugin_Activation::get_instance()->is_tgmpa_complete() && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
		wp_redirect( TGM_Plugin_Activation::get_instance()->get_tgmpa_url() );
	}
}

vamtam_register_theme_activation_hook( 'vamtam_' . VAMTAM_THEME_NAME, 'vamtam_theme_activated' );

add_action( 'admin_init', 'vamtam_validate_install' );
function vamtam_validate_install() {
	global $vamtam_errors, $vamtam_validated;
	if ( $vamtam_validated )
		return;

	$vamtam_validated = true;
	$vamtam_errors    = array();

	if ( strpos( str_replace( WP_CONTENT_DIR . '/themes/', '', get_template_directory() ), '/' ) !== false ) {
		$vamtam_errors[] = esc_html__( 'The theme must be installed in a directory which is a direct child of wp-content/themes/', 'nex' );
	}

	if ( ! extension_loaded( 'gd' ) || ! function_exists( 'gd_info' ) ) {
		$vamtam_errors[] = esc_html__( "It seems that your server doesn't have the GD graphic library installed. Please contact your hosting provider, they should be able to assist you with this issue", 'nex' );
	}

	if ( count( $vamtam_errors ) ) {
		if ( ! function_exists( 'vamtam_invalid_install' ) ) {
			function vamtam_invalid_install() {
				global $vamtam_errors;
				?>
					<div class="updated fade error" style="background: #FEF2F2; border: 1px solid #DFB8BB; color: #666;"><p>
						<?php esc_html_e( 'There were some some errors with your Vamtam theme setup:', 'nex' )?>
						<ul>
							<?php foreach ( $vamtam_errors as $error ) : ?>
								<li><?php echo wp_kses_post( $error ) ?></li>
							<?php endforeach ?>
						</ul>
					</p></div>
				<?php
			}
			add_action( 'admin_notices', 'vamtam_invalid_install' );
		}
		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
		return false;
	}

	return true;
}

function vamtam_static( $option ) {
	if ( isset( $option['static'] ) && $option['static'] ) {
		echo 'static'; }
}

function vamtam_description( $id, $desc ) {
	if ( ! empty( $desc ) ) : ?>
		<div class="row-desc">
			<a href="#" class="va-icon va-icon-info desc-handle"></a>
			<div>
				<section class="content"><?php echo wp_kses_post( $desc ) ?></section>
				<footer><a href="<?php echo esc_url( 'http://support.vamtam.com' ) ?>" title="<?php esc_attr_e( 'Read more on our Help Desk', 'nex' ) ?>" target="_blank"><?php esc_html_e( 'Read more on our Help Desk', 'nex' ) ?></a></footer>
			</div>
		</div>
	<?php endif;
}

function vamtam_compile_less_ajax() {
	if ( ! wp_verify_nonce( $_POST['_nonce'], 'vamtam-compile-less' ) ) {
		exit;
	}

	$error = VamtamLessBridge::basic_compile( $_POST['input'], $_POST['output'] );

	if ( $error ) {
		echo json_encode( array(
			'status' => 'error',
			'message' => $error,
			'memory' => memory_get_peak_usage() / 1024 / 1024,
		) );
	} else {
		echo json_encode( array(
			'status' => 'ok',
			'memory' => memory_get_peak_usage() / 1024 / 1024,
		) );
	}

	exit;
}
add_action( 'wp_ajax_vamtam-compile-less', 'vamtam_compile_less_ajax' );
