(function(undefined) {
	'use strict';

	// Namespace
	window.VAMTAM = window.VAMTAM || {};

	window.VAMTAM.MEDIA = window.VAMTAM.MEDIA || {
		layout: {}
	};

	var LAYOUT_SIZES = [{
			min: 0,
			max: window.VAMTAM_FRONT.beaver_small,
			className: 'layout-small'
		}, {
			min: window.VAMTAM_FRONT.beaver_responsive + 1,
			max: Infinity,
			className: 'layout-max'
		}, {
			min: window.VAMTAM_FRONT.beaver_responsive + 1,
			max: window.VAMTAM_FRONT.content_width,
			className: 'layout-max-low'
		}, {
			min: 0,
			max: window.VAMTAM_FRONT.beaver_responsive,
			className: 'layout-below-max'
		} ];

	document.addEventListener('DOMContentLoaded', function () {
		if ( document.body.classList.contains( 'responsive-layout' ) && 'matchMedia' in window ) {
			var sizesLength = LAYOUT_SIZES.length;

			var remap = window.VAMTAM.debounce( function() {
				var map   = {};

				for ( var i = 0; i < sizesLength; i++ ) {
					var mq = '(min-width: '+LAYOUT_SIZES[i].min+'px)';
					if ( LAYOUT_SIZES[i].max !== Infinity )
						mq += ' and (max-width: '+LAYOUT_SIZES[i].max+'px)';

					if ( window.matchMedia(mq).matches ) {
						map[LAYOUT_SIZES[i].className] = true;
					}
					else {
						map[LAYOUT_SIZES[i].className] = false;
					}
				}

				window.VAMTAM.MEDIA.layout = map;
			}, 100 );

			window.addEventListener( 'resize', remap, false );
			window.addEventListener( 'load', remap, false );

			remap();
		} else {
			window.VAMTAM.MEDIA.layout = { 'layout-max': true, 'layout-below-max': false };
		}
	} );
})();