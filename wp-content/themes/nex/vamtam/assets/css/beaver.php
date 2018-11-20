/* Make Beaver options play nice with the theme */

.vamtam-box-outer-padding,
.limit-wrapper,
.header-padding {
	padding-left: calc( var( --vamtam-box-outer-padding ) + var( --vamtam-beaver-global-module_margins ) );
	padding-right: calc( var( --vamtam-box-outer-padding ) + var( --vamtam-beaver-global-module_margins ) );
}

body:not(.single-tribe_events):not(.post-type-archive).fl-builder #main > .limit-wrapper,
body .fl-row-content-wrap {
	padding-left: var( --vamtam-box-outer-padding );
	padding-right: var( --vamtam-box-outer-padding );
}

body:not(.single-tribe_events):not(.post-type-archive).fl-builder #main > .limit-wrapper {
	max-width: calc( var( --vamtam-site-max-width ) + 2 * var( --vamtam-beaver-global-module_margins ) );
}

body.boxed .fixed-header-box,
body.boxed .fl-row-fixed-width {
	max-width: calc( var( --vamtam-site-max-width ) + 2 * ( var( --vamtam-box-outer-padding ) + var( --vamtam-beaver-global-module_margins ) ) );
}

.vamtam-box-outer-padding .vamtam-box-outer-padding,
body .vamtam-box-outer-padding .fl-row-content-wrap,
.limit-wrapper .limit-wrapper {
	padding-left: 0;
	padding-right: 0;
}

body .post-content .fl-row-full-width .fl-row-fixed-width {
	padding-left: var( --vamtam-box-outer-padding );
	padding-right: var( --vamtam-box-outer-padding );
}



@media ( min-width: <?php echo intval( $medium_breakpoint + 1 ) ?>px ) and ( max-width: <?php echo intval( $content_width ) ?>px ) {
	.vamtam-box-outer-padding,
	.limit-wrapper,
	.header-padding {
		padding-left: calc( 30px + var( --vamtam-beaver-global-module_margins ) );
		padding-right: calc( 30px + var( --vamtam-beaver-global-module_margins ) );
	}

	body:not(.single-tribe_events):not(.post-type-archive).fl-builder #main > .limit-wrapper,
	body .fl-row-content-wrap {
		padding-left: 30px;
		padding-right: 30px;
	}

	body .post-content .fl-row-full-width .fl-row-fixed-width {
		padding-left: calc( 20px + var( --vamtam-beaver-global-module_margins ) );
		padding-right: calc( 20px + var( --vamtam-beaver-global-module_margins ) );
	}

}

@media ( max-width: <?php echo intval( $medium_breakpoint ) ?>px ) {
	.vamtam-box-outer-padding,
	.limit-wrapper,
	.header-padding {
		padding-left: calc( 20px + var( --vamtam-beaver-global-module_margins ) );
		padding-right: calc( 20px + var( --vamtam-beaver-global-module_margins ) );
	}

	body:not(.single-tribe_events):not(.post-type-archive).fl-builder #main > .limit-wrapper,
	body .fl-row-content-wrap {
		padding-left: 20px;
		padding-right: 20px;
	}

	body .post-content .fl-row-full-width .fl-row-fixed-width {
		padding-left: calc( 10px + var( --vamtam-beaver-global-module_margins ) );
		padding-right: calc( 10px + var( --vamtam-beaver-global-module_margins ) );
	}

	body:not(.single-tribe_events):not(.post-type-archive).fl-builder #main.layout-left-only .limit-wrapper,
	body:not(.single-tribe_events):not(.post-type-archive).fl-builder #main.layout-right-only .limit-wrapper,
	body:not(.single-tribe_events):not(.post-type-archive).fl-builder #main.layout-left-right .limit-wrapper {
		padding-left: 0;
		padding-right: 0;
	}

	body #main:not(.layout-full) .fl-builder-content > .fl-row-full-width .fl-row-fixed-width,
	body #main:not(.layout-full) .fl-builder-content > .fl-row-full-width .fl-row-full-width,
	body #main:not(.layout-full) .fl-builder-content > .fl-row-fixed-width {
		padding-left: calc( 10px + var( --vamtam-beaver-global-module_margins ) );
		padding-right: calc( 10px + var( --vamtam-beaver-global-module_margins ) );
	}
}

@media ( max-width: <?php echo intval( $small_breakpoint ) ?>px ) {
	.vamtam-box-outer-padding,
	.limit-wrapper,
	.header-padding {
		padding-left: calc( 10px + var( --vamtam-beaver-global-module_margins ) );
		padding-right: calc( 10px + var( --vamtam-beaver-global-module_margins ) );
	}

	body #main:not(.layout-full) .fl-builder-content > .fl-row-full-width .fl-row-fixed-width,
	body #main:not(.layout-full) .fl-builder-content > .fl-row-full-width .fl-row-full-width,
	body #main:not(.layout-full) .fl-builder-content > .fl-row-fixed-width {
		padding-left: 0;
		padding-right: 0;
	}
}

<?php if ( ! class_exists( 'FLBuilderModel' ) || ! FLBuilderModel::is_builder_active() ) : ?>
	:root { scroll-behavior: smooth; }
<?php endif ?>