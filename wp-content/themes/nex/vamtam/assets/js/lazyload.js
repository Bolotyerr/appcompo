(function(v, undefined) {
	'use strict';

	// lazy loading
	var observer;

	if ( 'IntersectionObserver' in window ) {
		observer = new IntersectionObserver( function( changes ) {
			changes.forEach( function( change ) {
				if ( change.intersectionRatio > 0 || change.isIntersecting ) {
					showImage( change.target );
					observer.unobserve(change.target);
				}
			});
		}, {
			rootMargin: '200px',
		});
	}

	function onImageLoad() {
		/* jshint validthis: true */
		this.removeEventListener( 'load', onImageLoad );

		// this.dispatchEvent( new Event( 'vamtamlazyloaded', { bubbles: true } ) );

		requestAnimationFrame( function() {
			if ( ! ( this.classList.contains( 'vamtam-lazyload-noparent' ) ) && this.parentElement ) {
				this.parentElement.classList.add( 'image-loaded' );
			} else {
				this.classList.add( 'image-loaded' );
			}
		}.bind( this ) );
	}

	function showImage( image ) {
		var srcset = image.dataset.srcset;

		if ( srcset ) {
			requestAnimationFrame( function() {
				image.addEventListener( 'load', onImageLoad );
				image.srcset = srcset;
			} );

			delete image.dataset.srcset;
		} else {
			onImageLoad.call( image );
		}
	}

	// Either observe the images, or load immediately if IntersectionObserver doesn't exist
	function addElements() {
		var images = document.querySelectorAll('img[data-srcset]');
		var i;

		if ( observer ) {
			for ( i = 0; i < images.length; i++ ) {
				if ( ! ( 'vamtamLazyLoaded' in images[i] ) ) {
					images[i].vamtamLazyLoaded = true;
					observer.observe( images[i] );
				}
			}
		} else {
			for ( i = 0; i < images.length; i++ ) {
				if ( ! ( 'vamtamLazyLoaded' in images[i] ) ) {
					images[i].vamtamLazyLoaded = true;
					showImage( images[i] );
				}
			}
		}

		var otherImages = document.querySelectorAll('.vamtam-responsive-wrapper:not(.image-loaded) img:not([srcset])');

		for ( i = 0; i< otherImages.length; i++ ) {
			if ( ! ( 'vamtamLazyLoaded' in otherImages[i] ) ) {
				otherImages[i].vamtamLazyLoaded = true;
				showImage( otherImages[i] );
			}
		}
	}

	document.addEventListener('DOMContentLoaded', function() {
		var mutationObserver = new MutationObserver( addElements );

		mutationObserver.observe( document.body, {
			childList: true,
			subtree: true
		} );

		addElements();
	});
})( window.VAMTAM );