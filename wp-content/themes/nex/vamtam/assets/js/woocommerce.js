( function( $, undefined ) {
	'use strict';

	$( function() {
		var dropdown  = $( '.fixed-header-box .cart-dropdown' ),
			link      = $( '.vamtam-cart-dropdown-link' ),
			count     = $( '.products', link ),
			widget    = $( '.widget', dropdown ),
			isVisible = false;

		$( document.body ).on( 'added_to_cart removed_from_cart wc_fragments_refreshed wc_fragments_loaded', function() {
			var count_val = parseInt( Cookies.get( 'woocommerce_items_in_cart' ) || 0, 10 );

			if ( count_val > 0 ) {
				var count_real = 0;

				var spans = document.querySelector( '.widget_shopping_cart' ).querySelectorAll( 'li .quantity' );

				for ( var i = 0; i < spans.length; i++ ) {
					count_real += parseInt( spans[i].innerHTML.split( '<span' )[0].replace( /[^\d]/g, '' ), 10 );
				}

				// sanitize count_real - if it's not a number, then don't show the counter at all
				count_real = count_real >= 0 ? count_real : '';

				count.text( count_real );
				count.removeClass( 'cart-empty' );
				dropdown.removeClass( 'hidden' );
			} else {
				var show_if_empty = dropdown.hasClass( 'show-if-empty' );

				count.addClass( 'cart-empty' );
				count.text( '0' );

				dropdown.toggleClass( 'hidden', ! show_if_empty );
			}
		} );

		var open = 0;

		var showCart = function() {
			open = +new Date();
			dropdown.addClass( 'state-hover' );
			widget.stop( true, true ).fadeIn( 300, function() {
				isVisible = true;
			} );
		};

		var hideCart = function() {
			var elapsed = new Date() - open;

			if( elapsed > 1000 ) {
				dropdown.removeClass( 'state-hover' );
				widget.stop( true, true ).fadeOut( 300, function() {
					isVisible = false;
				} );
			} else {
				setTimeout( function() {
					if( !dropdown.is( ':hover' ) ) {
						hideCart();
					}
				}, 1000 - elapsed );
			}
		};

		dropdown.on( 'mouseenter', function() {
			showCart();
		} ).on( 'mouseleave', function() {
			hideCart();
		} );

		link.not( '.no-dropdown' ).bind( 'click', function( e ) {
			if( isVisible ) {
				hideCart();
			} else {
				showCart();
			}

			e.preventDefault();
		} );
	} );
} )( jQuery );