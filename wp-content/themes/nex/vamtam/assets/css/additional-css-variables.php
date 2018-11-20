<?php

return array(
	// The current CSS Variables polyfill for IE 11 does not support nested variables
	// However, these are necessary for the live preview,
	// so we use a static color for the live site and a CSS var for the customizer
	'default-bg-color' => is_customize_preview() ? 'var( --vamtam-main-background-background-color )' : rd_vamtam_get_option( 'main-background', 'background-color' ),
	'default-line-color' => is_customize_preview() ? 'var( --vamtam-accent-color-7 )' : rd_vamtam_get_option( 'accent-color', 7 ),

	'small-padding' => '20px',

	'horizontal-padding' => '50px',
	'vertical-padding' => '30px',

	'horizontal-padding-large' => '60px',
	'vertical-padding-large' => '60px',

	'no-border-link' => 'none',

	'border-radius' => '0px',
	'border-radius-oval' => '0px',
	'overlay-color' => is_customize_preview() ? 'var( --vamtam-accent-color-5 )' : rd_vamtam_get_option( 'accent-color', 5 ),

	/** DO NOT CHANGE BELOW */
	 'box-outer-padding' => '60px',
	/** DO NOT CHANGE ABOVE  */
);
