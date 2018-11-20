jQuery(document).ready(function($) {

	// Apply chosen
	$('#mig-scroll-menu-generator-select').chosen({
		no_results_text: $('#mig-scroll-menu-generator-select').attr('data-no-results-text'),
		allow_single_deselect: true
	});

	// Select shortcode
	$('#mig-scroll-menu-generator-select').live( "change", function() {
		var queried_shortcode = $('#mig-scroll-menu-generator-select').find(':selected').val();
		$('#mig-scroll-menu-generator-settings').addClass('mig-scroll-menu-loading-animation');
		$('#mig-scroll-menu-generator-settings').load($('#mig-scroll-menu-generator-url').val() + '/lib/generator.php?shortcode=' + queried_shortcode, function() {
			$('#mig-scroll-menu-generator-settings').removeClass('mig-scroll-menu-loading-animation');

			// Init color pickers
			$('.mig-scroll-menu-generator-select-color').each(function(index) {
				$(this).find('.mig-scroll-menu-generator-select-color-wheel').filter(':first').farbtastic('.mig-scroll-menu-generator-select-color-value:eq(' + index + ')');
				$(this).find('.mig-scroll-menu-generator-select-color-value').focus(function() {
					$('.mig-scroll-menu-generator-select-color-wheel:eq(' + index + ')').show();
				});
				$(this).find('.mig-scroll-menu-generator-select-color-value').blur(function() {
					$('.mig-scroll-menu-generator-select-color-wheel:eq(' + index + ')').hide();
				});
			});
		});
	});

	// Insert shortcode
	$('#mig-scroll-menu-generator-insert').live('click', function(event) {
		var queried_shortcode = $('#mig-scroll-menu-generator-select').find(':selected').val();
		var mig_scroll_menu_compatibility_mode_prefix = $('#mig-scroll-menu-compatibility-mode-prefix').val();
		$('#mig-scroll-menu-generator-result').val('[' + mig_scroll_menu_compatibility_mode_prefix + queried_shortcode);
		$('#mig-scroll-menu-generator-settings .mig-scroll-menu-generator-attr').each(function() {
			if ( $(this).val() !== '' ) {
				$('#mig-scroll-menu-generator-result').val( $('#mig-scroll-menu-generator-result').val() + ' ' + $(this).attr('name') + '="' + $(this).val() + '"' );
			}
		});
		$('#mig-scroll-menu-generator-result').val($('#mig-scroll-menu-generator-result').val() + ']');

		// wrap shortcode
		if ( $('#mig-scroll-menu-generator-content').val() != 'false' ) {
			$('#mig-scroll-menu-generator-result').val($('#mig-scroll-menu-generator-result').val() + $('#mig-scroll-menu-generator-content').val() + '[/' + mig_scroll_menu_compatibility_mode_prefix + queried_shortcode + ']');
		}

		var shortcode = jQuery('#mig-scroll-menu-generator-result').val();

		// Insert into widget
		if ( typeof window.mig_scroll_menu_generator_target !== 'undefined' ) {
			jQuery('textarea#' + window.mig_scroll_menu_generator_target).val( jQuery('textarea#' + window.mig_scroll_menu_generator_target).val() + shortcode);
			tb_remove();
		}

		// Insert into editor
		else {
			window.send_to_editor(shortcode);
		}

		// Prevent default action
		event.preventDefault();
		return false;
	});

	// Widget insertion button click
	jQuery('a[data-page="widget"]').live('click',function(event) {
		window.mig_scroll_menu_generator_target = jQuery(this).attr('data-target');
	});

});