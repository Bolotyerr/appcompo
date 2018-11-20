jQuery(document).ready(function($) {

	// Code editor
	var gn_custom_editor = CodeMirror.fromTextArea(document.getElementById("mig-scroll-menu-custom-css"), {});

	// Tables
	$('.mig-scroll-menu-table-shortcodes tr:even, .mig-scroll-menu-table-demos tr:even').addClass('even');

	// Tabs
	$('#mig-scroll-menu-wrapper .mig-scroll-menu-pane:first').show();
	$('#mig-scroll-menu-tabs a').click(function() {
		$('.mig-scroll-menu-message').hide();
		$('#mig-scroll-menu-tabs a').removeClass('mig-scroll-menu-current');
		$(this).addClass('mig-scroll-menu-current');
		$('#mig-scroll-menu-wrapper .mig-scroll-menu-pane').hide();
		$('#mig-scroll-menu-wrapper .mig-scroll-menu-pane').eq($(this).index()).show();
		gn_custom_editor.refresh();
	});

	// Ajaxify settings form
	$('#mig-scroll-menu-form-save-settings').ajaxForm({
		beforeSubmit: function() {
			$('#mig-scroll-menu-form-save-settings .mig-scroll-menu-spin').show();
			$('#mig-scroll-menu-form-save-settings .mig-scroll-menu-submit').attr('disabled', true);
		},
		success: function() {
			$('#mig-scroll-menu-form-save-settings .mig-scroll-menu-spin').hide();
			$('#mig-scroll-menu-form-save-settings .mig-scroll-menu-submit').attr('disabled', false);
		}
	});

	// Ajaxify custom CSS form
	$('#mig-scroll-menu-form-save-custom-css').ajaxForm({
		beforeSubmit: function() {
			$('#mig-scroll-menu-form-save-custom-css .mig-scroll-menu-spin').show();
			$('#mig-scroll-menu-form-save-custom-css .mig-scroll-menu-submit').attr('disabled', true);
		},
		success: function() {
			$('#mig-scroll-menu-form-save-custom-css .mig-scroll-menu-spin').hide();
			$('#mig-scroll-menu-form-save-custom-css .mig-scroll-menu-submit').attr('disabled', false);
		}
	});

	// Auto-open tab by link with hash
	if ( strpos( document.location.hash, '#tab-' ) !== false )
		$('#mig-scroll-menu-tabs a:eq(' + document.location.hash.replace('#tab-','') + ')').trigger('click');

});

// ########## Strpos tool ##########

function strpos( haystack, needle, offset) {
	var i = haystack.indexOf( needle, offset );
	return i >= 0 ? i : false;
}