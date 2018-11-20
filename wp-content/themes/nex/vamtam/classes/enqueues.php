<?php

/**
 * Enqueue styles and scripts used by the theme
 *
 * @package vamtam/nex
 */

/**
 * class VamtamEnqueues
 */
class VamtamEnqueues {
	private static $use_min;

	private static $widget_styles = array(
		'WP_Nav_Menu_Widget'       => 'nav-menu',
		'WP_Widget_Tag_Cloud'      => 'tagcloud',
		'WP_Widget_RSS'            => 'rss',
		'WP_Widget_Search'         => 'search',
		'WC_Widget_Product_Search' => 'search',
		'WP_Widget_Calendar'       => 'calendar',
	);

	/**
	 * Hook the relevant actions
	 */
	public static function actions() {
		self::$use_min = ! ( WP_DEBUG || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'VAMTAM_SCRIPT_DEBUG' ) && VAMTAM_SCRIPT_DEBUG ) );

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'scripts' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'styles' ), 999 );
		add_action( 'wp', array( __CLASS__, 'preload_styles' ) );

		if ( ! is_admin() ) {
			add_action( 'the_widget', array( __CLASS__, 'widget_styles' ) );
			add_action( 'dynamic_sidebar', array( __CLASS__, 'widget_styles_dynamic_sidebar' ) );
		}

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_styles' ), 999 );
		add_action( 'customize_controls_enqueue_scripts', array( __CLASS__, 'customize_controls_enqueue_scripts' ) );
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_init' ) );
	}

	private static function is_our_admin_page() {
		if ( ! is_admin() ) return false;

		$screen = get_current_screen();

		return
			in_array( $screen->base, array( 'post', 'widgets', 'themes', 'upload' ) ) ||
			strpos( $screen->base, 'vamtam_' ) !== false ||
			strpos( $screen->base, 'toplevel_page_vamtam' ) === 0 ||
			strpos( $screen->base, 'toplevel_page_vamtam' ) === 0 ||
			$screen->base === 'media_page_vamtam_icons';
	}

	private static function inject_dependency( $handle, $dep ) {
		global $wp_scripts;

		$script = $wp_scripts->query( $handle, 'registered' );

		if ( ! $script )
			return false;

		if ( ! in_array( $dep, $script->deps ) ) {
			$script->deps[] = $dep;
		}

		return true;
	}

	/**
	 * Front-end scripts
	 */
	public static function scripts() {
		global $content_width;

		if ( is_admin() || VamtamTemplates::is_login() ) return;

		$cache_timestamp = get_option( 'vamtam-css-cache-timestamp' );

		if ( is_singular() && comments_open() ) {
			wp_enqueue_script( 'comment-reply', false, false, false, true );
		}

		wp_register_script( 'vamtam-ls-height-fix', VAMTAM_JS . 'layerslider-height.js', array( 'jquery-core' ), $cache_timestamp, true );

		wp_register_script( 'vamtam-splash-screen', VAMTAM_JS . 'splash-screen.js', array( 'jquery-core', 'imagesloaded' ), $cache_timestamp, true );

		$cube_path = VAMTAM_ASSETS_URI . 'cubeportfolio/js/jquery.cubeportfolio' . ( self::$use_min ? '.min' : '' ) . '.js';
		wp_register_script( 'cubeportfolio', $cube_path, array( 'jquery-core' ), '4.1.1', true );

		wp_register_script( 'vamtam-hide-widgets', VAMTAM_JS . 'hide-widgets.js', array(), $cache_timestamp, true );

		$all_js_path = self::$use_min ? 'all.min.js' : 'all.js';
		$all_js_deps = array(
			'jquery-core',
		);

		if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_enabled() ) {
			$all_js_deps[] = 'fl-builder-layout-' . get_the_ID();
		}

		wp_enqueue_script( 'vamtam-all', VAMTAM_JS . $all_js_path, $all_js_deps, $cache_timestamp, true );

		self::inject_dependency( 'wc-cart-fragments', 'vamtam-all' );

		$script_vars = array(
			'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
			'jspath'                   => VAMTAM_JS,
			'mobile_header_breakpoint' => vamtam_get_mobile_header_breakpoint(),
			'cube_path'                => $cube_path,
			'beaver_responsive'        => class_exists( 'FLBuilderModel' ) ? (int) FLBuilderModel::get_global_settings()->medium_breakpoint : 768,
			'beaver_small'             => class_exists( 'FLBuilderModel' ) ? (int) FLBuilderModel::get_global_settings()->responsive_breakpoint : 768,
			'content_width'            => (int) $content_width,
		);

		wp_localize_script( 'vamtam-all', 'VAMTAM_FRONT', $script_vars );

		$sticky_header_js_path = self::$use_min ? 'sticky-header.min.js' : 'sticky-header.js';

		wp_register_script( 'vamtam-sticky-header', VAMTAM_JS . 'build/' . $sticky_header_js_path, array( 'vamtam-all' ), $cache_timestamp, true );
	}

	/**
	 * Admin scripts
	 */
	public static function admin_scripts() {
		if ( ! self::is_our_admin_page() ) return;

		$cache_timestamp = VamtamFramework::get_version();

		wp_enqueue_script( 'jquery-magnific-popup', VAMTAM_JS . 'plugins/thirdparty/jquery.magnific.js', array( 'jquery-core' ), $cache_timestamp, true );

		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'editor' );
		wp_enqueue_script( 'jquery-ui-tabs' );

		wp_enqueue_script( 'farbtastic' );

		wp_enqueue_media();

		wp_enqueue_script( 'vamtam_admin', VAMTAM_ADMIN_ASSETS_URI . 'js/admin-all.js', array( 'jquery-core', 'underscore', 'backbone' ), $cache_timestamp, true );

		wp_localize_script(
			'vamtam_admin', 'VAMTAM_ADMIN', array(
				'addNewIcon' => esc_html__( 'Add New Icon', 'nex' ),
				'iconName'   => esc_html__( 'Icon', 'nex' ),
				'iconText'   => esc_html__( 'Text', 'nex' ),
				'iconLink'   => esc_html__( 'Link', 'nex' ),
				'iconChange' => esc_html__( 'Change', 'nex' ),
				'fonts'      => $GLOBALS['vamtam_fonts'],
			)
		);
	}

	/**
	 * Front-end styles
	 */
	public static function styles() {
		global $content_width;

		if ( is_admin() || VamtamTemplates::is_login() ) return;

		$cache_timestamp = get_option( 'vamtam-css-cache-timestamp' );

		$preview = is_customize_preview() || ( isset( $_POST['wp_customize'] ) && $_POST['wp_customize'] == 'on' && isset( $_POST['customized'] ) && ! empty( $_POST['customized'] ) && ! isset( $_POST['action'] ) ? '-preview' : '' );

		$fonts_url = empty( $preview ) ? rd_vamtam_get_option( 'google_fonts' ) : vamtam_customizer_preview_fonts_url();

		wp_enqueue_style( 'vamtam-gfonts', $fonts_url, array(), $cache_timestamp );

		wp_register_style( 'cubeportfolio', VAMTAM_ASSETS_URI . 'cubeportfolio/css/cubeportfolio' . ( self::$use_min ? '.min' : '' ) . '.css', array( 'front-all' ), '4.1.1' );

		$generated_deps = array();

		if ( vamtam_has_woocommerce() ) {
			$generated_deps[] = 'woocommerce-layout';
			$generated_deps[] = 'woocommerce-smallscreen';
			$generated_deps[] = 'woocommerce-general';
		}

		wp_enqueue_style( 'front-all', VAMTAM_ASSETS_URI . 'css/dist/all.css', $generated_deps, $cache_timestamp );

		$theme_url       = VAMTAM_THEME_URI;
		$theme_icons_css = "
			@font-face {
				font-family: 'icomoon';
				src: url({$theme_url}vamtam/assets/fonts/icons/icomoon.woff2) format('woff2'),
				     url( {$theme_url}vamtam/assets/fonts/icons/icomoon.woff) format('woff'),
				     url({$theme_url}vamtam/assets/fonts/icons/icomoon.ttf) format('ttf');
				font-weight: normal;
				font-style: normal;
			}

			@font-face {
				font-family: 'theme';
				src: url({$theme_url}vamtam/assets/fonts/theme-icons/theme-icons.woff2) format('woff2'),
					url({$theme_url}vamtam/assets/fonts/theme-icons/theme-icons.woff) format('woff'),
					url({$theme_url}vamtam/assets/fonts/theme-icons/theme-icons.ttf) format('truetype');
				font-weight: normal;
				font-style: normal;
			}
		";

		wp_add_inline_style( 'front-all', $theme_icons_css );

		// content paddings
		ob_start();

		$small_breakpoint  = class_exists( 'FLBuilderModel' ) ? (int) FLBuilderModel::get_global_settings()->responsive_breakpoint : 768;
		$medium_breakpoint = class_exists( 'FLBuilderModel' ) ? (int) FLBuilderModel::get_global_settings()->medium_breakpoint : 992;

		include VAMTAM_CSS_DIR . 'beaver.php';
		include VAMTAM_CSS_DIR . 'header-slider.php';

		wp_add_inline_style( 'front-all', ob_get_clean() );

		wp_enqueue_style( 'vamtam-theme-print', VAMTAM_ASSETS_URI . 'css/print.css', array( 'front-all' ), $cache_timestamp, 'print' );

		$responsive_stylesheets = array(
			'mobile-header'    => '(max-width: ' . vamtam_get_mobile_header_breakpoint() . ')',
			'layout-max-low'   => '(min-width: ' . ( $medium_breakpoint + 1 ) . "px) and (max-width: {$content_width}px)",
			'layout-max'       => '(min-width: ' . ( $medium_breakpoint + 1 ) . 'px)',
			'layout-below-max' => "(max-width: {$medium_breakpoint}px)",
			'layout-small'     => '(max-width: {$small_breakpoint}px)',
			'wc-small-screen'  => 'only screen and (max-width: ' . apply_filters( 'woocommerce_style_smallscreen_breakpoint', $breakpoint = '768px' ) . ')',
		);

		$url_prefix = VAMTAM_ASSETS_URI . 'css/dist/responsive/';
		foreach ( $responsive_stylesheets as $file => $media ) {
			wp_enqueue_style( 'vamtam-theme-'. $file, $url_prefix . $file . '.css', array( 'front-all' ), $cache_timestamp, $media );
		}

		wp_register_style( 'vamtam-widgets-general', VAMTAM_ASSETS_URI . 'css/dist/widgets/general.css' , array( 'front-all' ), $cache_timestamp );

		foreach ( array_unique( self::$widget_styles ) as $class => $file ) {
			wp_register_style( 'vamtam-widget-' . $file, VAMTAM_ASSETS_URI . 'css/dist/widgets/' . $file . '.css' , array( 'front-all', 'vamtam-widgets-general' ), $cache_timestamp );
		}

		self::print_theme_options();
	}

	/**
	 * Output Link rel=preload headers for critical styles
	 */
	public static function preload_styles() {
		$cache_timestamp = get_option( 'vamtam-css-cache-timestamp' );
		$url_prefix      = VAMTAM_ASSETS_URI . 'css/dist/responsive/';

		if ( wp_is_mobile() ) {
			header( "Link: <{$url_prefix}layout-below-max.css?ver={$cache_timestamp}>; rel=preload; as=style", false );
			header( "Link: <{$url_prefix}mobile-header.css?ver={$cache_timestamp}>; rel=preload; as=style", false );
		} else {
			header( "Link: <{$url_prefix}layout-max.css?ver={$cache_timestamp}>; rel=preload; as=style", false );
		}
	}

	/**
	 * Enqueue widget styles, hooked to the_widget
	 */
	public static function widget_styles( $widget ) {
		// this one is for all widgets, anywhere
		wp_enqueue_style( 'vamtam-widgets-general' );

		// some widgets have their own style sheets
		if ( isset( self::$widget_styles[ $widget ] ) ) {
			wp_enqueue_style( 'vamtam-widget-' . self::$widget_styles[ $widget ] );
		}
	}

	/**
	 * Enqueue widget styles, hooked to dynamic_sidebar
	 */
	public static function widget_styles_dynamic_sidebar( $widget ) {
		self::widget_styles( get_class( $widget['callback'][0] ) );
	}

	/**
	 * Admin styles
	 */
	public static function admin_styles() {
		if ( ! self::is_our_admin_page() ) return;

		wp_enqueue_style( 'magnific', VAMTAM_ADMIN_ASSETS_URI . 'css/magnific.css' );
		wp_enqueue_style( 'vamtam_admin', VAMTAM_ADMIN_ASSETS_URI . 'css/vamtam_admin.css' );
		wp_enqueue_style( 'farbtastic' );
	}

	/**
	 * Customizer styles
	 */
	public static function customize_controls_enqueue_scripts() {
		$cache_timestamp = VamtamFramework::get_version();

		wp_enqueue_style( 'vamtam-customizer', VAMTAM_ADMIN_ASSETS_URI . 'css/customizer.css', array(), $cache_timestamp );

		wp_enqueue_script( 'vamtam-customize-controls-conditionals', VAMTAM_ADMIN_ASSETS_URI . 'js/customize-controls-conditionals.js', array( 'jquery-core', 'customize-controls' ), $cache_timestamp, true );
	}

	public static function customize_preview_init() {
		$cache_timestamp = VamtamFramework::get_version();

		wp_enqueue_script( 'vamtam-customizer-preview', VAMTAM_ADMIN_ASSETS_URI . 'js/customizer-preview.js', array( 'jquery-core', 'customize-preview' ), $cache_timestamp, true );

		wp_localize_script(
			'vamtam-customizer-preview', 'VAMTAM_CUSTOMIZE_PREVIEW', array(
				'compiler_options' => vamtam_custom_css_options(),
				'ajaxurl'          => admin_url( 'admin-ajax.php' ),
				'percentages'      => VamtamLessBridge::$percentages,
				'numbers'          => VamtamLessBridge::$numbers,
			)
		);
	}

	public static function print_theme_options() {
		$vars_raw    = $GLOBALS['vamtam_theme_customizer']->get_options();
		$option_defs = $GLOBALS['vamtam_theme_customizer']->get_fields_by_id();

		$options_to_export = array();

		foreach ( $option_defs as $option ) {
			if ( isset( $option['compiler'] ) && $option['compiler'] ) {
				$options_to_export[ $option['id'] ] = apply_filters( 'vamtam_get_option', $vars_raw[ $option['id'] ], $option['id'] );
			}
		}

		$options = VamtamLessBridge::prepare_vars_for_export( $options_to_export );

		echo '<style id="vamtam-theme-options">';
		echo ':root {';

		foreach ( $options as $name => $value ) {
			echo '--vamtam-' . esc_html( $name ) . ':' . wp_kses_data( $value ) . ";\n";
		}

		echo "--vamtam-loading-animation:url('" . esc_attr( VAMTAM_IMAGES . 'loader-ring.gif') . "');\n";

		for ( $i = 1; $i <= 8; $i++ ) {
			$name  = "accent-color-$i";
			$color = new VamtamColor( $options[ $name ] );

			$readable = '';
			$hc       = '';

			if ( $color->L > .8 ) {
				$readable = '#' . $color->darken( 50 );
				$hc       = '#000000';
			} else {
				$readable = '#' . $color->lighten( 50 );
				$hc       = '#ffffff';
			}

			echo '--vamtam-' . esc_html( $name ) . '-readable:' . wp_kses_data( $readable ) . ";\n";
			echo '--vamtam-' . esc_html( $name ) . '-hc:' . wp_kses_data( $hc ) . ";\n";
			echo '--vamtam-' . esc_html( $name ) . '-transparent:rgba(' . wp_kses_data( implode( ',', $color->getRgb() ) ) . ",0);\n";
		}

		echo '}';
		echo '</style>';
	}
}
