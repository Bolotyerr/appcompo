/*
 VamTam Check License
 */

/*global jQuery*/

(function( $ ) {
	'use strict';

	$('body').on('click', '#vamtam-check-license', function(e) {
		e.preventDefault();

		var self = $(this);

		if ( self.hasClass('disabled' ) ) return false;

		var result = $('#vamtam-check-license-result').html('');

		self.css('display', 'inline-block').addClass('disabled');

		self.after('<span class="spinner" style="display:inline-block;float:none" />');

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'vamtam-check-license',
				'license-key': $('#vamtam-envato-license-key').val(),
				nonce: self.attr('data-nonce')
			},
			success: function(data) {
				self.removeClass('disabled');

				result.append( $('<p />').addClass('vamtam-check-license-help').append('<hr />').append( self.data('full-info') ) );
				result.append( $('<p />').addClass('vamtam-check-license-response').append('<hr />').append(data) );
			}
		});
	});
})( jQuery );