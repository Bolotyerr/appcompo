/*
 VamTam Import Buttons
 */

/*global jQuery*/

(function( $ ) {
	'use strict';

	$( function() {
		$( 'body' ).on( 'click', '.vamtam-import-button', function( e ) {
			e.preventDefault();

			var button = $( this );

			if ( ! button.hasClass( 'disabled' ) ) {
				button.addClass( 'disabled' );

				var spinner = $( '<span></span>' ).addClass( 'spinner' ).css( {
					visibility: 'visible',
					float: 'none',
					'vertical-align': 'top'
				} );

				button.after( spinner );

				$.get( button.attr( 'href' ), function( result ) {
					spinner.remove();

					var result_wrap = $( '<span />' );

					if ( result.match( /all done\./i ) ) {
						result_wrap.html( button.data( 'success-msg' ) ).addClass( 'import-success' );

						if ( button.attr( 'id' ) === 'content-import-button' ) {
							button.closest( '.form-table' ).find( '.disabled.content-disabled' ).removeClass( 'disabled content-disabled' );
						}
					} else {
						result_wrap.html( button.data( 'error-msg' ).replace( '{fullimport}', button.attr( 'href' ) ) ).addClass( 'import-fail' );
					}

					button.after( result_wrap );
				} );
			}
		} );
	} );
})( jQuery );