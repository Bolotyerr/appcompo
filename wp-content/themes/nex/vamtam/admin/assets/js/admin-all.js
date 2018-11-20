(function($, undefined) {
	"use strict";

	var picker, selected, fbt;

	var init = function() {

		picker = $('<div id="vamtam-colorpicker"></div>').hide();

		$('body').append(picker);
		fbt = $.farbtastic('#vamtam-colorpicker');

		picker.append(function() {
			return $('<a class="transparent">transparent</a>').on( 'click', function() {
				if (selected) {
					$(selected).val('transparent').css({
						background: 'white'
					});
					picker.fadeOut();
				}
			});
		});
	};

	$.fn.vamtamColorPicker = function() {
		var self = this;

		if(!picker)
			init();

		$('[type=color], .vamtam-color-input', self).not('.vamtam-colorpicker').each(function() {
			$(this).prop('type', 'text').addClass('vamtam-colorpicker');
			fbt.linkTo(this);
		}).on('focus', null, function() {
			if (selected) $(selected).removeClass('colorwell-selected');

			var self = this;
			fbt.linkTo(function(color) {
				$(self).val(color).change();
			});

			picker.css({
				position: 'absolute',
				left: $(this).offset().left + $(this).outerWidth(),
				top: $(this).offset().top
			}).fadeIn();
			$(selected = this).addClass('colorwell-selected');
		}).on('blur', null, function() {
			picker.fadeOut();
		}).on('change keyup', null, function() {
			$(this).css({
				'background-color': $(this).val()
			});
		});

		return this;
	};
})(jQuery);
(function($, undefined) {
	"use strict";

	$.fn.vamtamBackgroundOption = function() {
		$(this).find('.vamtam-config-row.background:not(.vamtambg-loaded)').each(function() {
			var row = $(this).addClass('vamtambg-loaded'),
				size = row.find('.bg-block.bg-size'),
				repeat = row.find('.bg-block.bg-repeat'),
				position = row.find('.bg-block.bg-position');

			size.find('input').bind('change', function() {
				repeat.add(position).show();

				if($(':checked', size).val() === 'cover')
					repeat.add(position).hide();
			}).change();

		});
		return this;
	};
})(jQuery);
(function($, undefined) {
	'use strict';

	window.VAMTAM = window.VAMTAM || {};

	window.VAMTAM.upload = {
		init: function() {
			var file_frame;

			$(document).on('click', '.vamtam-upload-button', function(e) {
				var field_id = $(this).attr('data-target');

				file_frame = wp.media.frames.file_frame = wp.media({
					multiple: false,
					library: {
						type: $(this).hasClass('vamtam-video-upload') ? 'video' : 'image'
					}
				});

				file_frame.on( 'select', function() {
					var attachment = file_frame.state().get('selection').first();
					window.VAMTAM.upload.fill(field_id, attachment.attributes.url);
				});

				file_frame.open();
				e.preventDefault();
			});

			$(document).on('click', '.vamtam-upload-clear', function(e) {
				window.VAMTAM.upload.remove($(this).attr('data-target'));
				e.preventDefault();
			});

			$(document).on('click', '.vamtam-upload-undo', function(e) {
				window.VAMTAM.upload.undo($(this).attr('data-target'));
				e.preventDefault();
			});
		},

		fill: function(id, str) {
			if (/^\s*$/.test(str)) {
				window.VAMTAM.upload.remove(id);
				return;
			}

			var target = $('#' + id);
			target.data('undo', target.val());
			target.val(str);
			target.siblings('.vamtam-upload-clear, .vamtam-upload-undo').css({
				display: 'inline-block'
			});
			window.VAMTAM.upload.preview(id, str);
		},

		preview: function(id, str) {
			$('#' + id + '_preview').parents('.upload-basic-wrapper').addClass('active');
			$('#' + id + '_preview').find('img').attr('src', str).css({
				display: 'inline-block'
			});
		},

		remove: function(id) {
			var inp = $('#' + id);
			$('#' + id + '_preview').find('img').attr('src', '').hide();
			$('#' + id + '_preview').parents('.upload-basic-wrapper').removeClass('active');
			inp.data('undo', inp.val()).val('')
				.siblings('.vamtam-upload-undo').css({
				display: 'inline-block'
			})
				.siblings('.vamtam-upload-clear').hide();
		},
		undo: function(id) {
			var inp = $('#' + id);
			this.preview(id, inp.data('undo'));
			inp.val(inp.data('undo'));
			inp.data('undo', '').siblings('.vamtam-upload-undo').hide();
			var remove = inp.siblings('.vamtam-upload-clear');
			if (inp.val().length === 0 && remove.is(':visible')) {
				remove.hide();
			} else if (inp.val().length > 0 && remove.is(':hidden')) {
				remove.css({
					display: 'inline-block'
				});
			}
		}
	};
})(jQuery);
(function($, undefined) {
	"use strict";

	window.VAMTAM = window.VAMTAM || {};

	$(function() {
		$('body').vamtamColorPicker().vamtamBackgroundOption();

		window.VAMTAM.upload.init();

		$(document).on('change select', '[data-field-filter]', function() {
			var prefix = $(this).attr('data-field-filter');
			var selected = $(':checked', this).val();

			var others = $(this).closest('.vamtam-config-group').find('.' + prefix).filter(':not(.hidden)');
			others.show().filter(':not(.' + prefix + '-' + selected + ')').hide();
		});

		$('[data-field-filter]').change();

		$(document).on('change', '.social_icon_select_sites', function() {
			var wrap = $(this).closest('p').siblings('.social_icon_wrap');
			wrap.children('p').hide();
			$('option:selected', this).each(function() {
				wrap.find('.social_icon_' + $(this).val()).show();
			});
		});

		$(document).on('change', '.num_shown', function() {
			var wrap = $(this).closest('p').siblings('.hidden_wrap');
			wrap.children('div').hide();
			$('.hidden_el:lt(' + $(this).val() + ')', wrap).show();
		});

		$('.metabox').each(function() {
			var meta_tabs = $('<ul>').addClass('vamtam-meta-tabs');

			$('.config-separator:first', this).before(meta_tabs);
			$('.config-separator', this).each(function() {
				var id = $(this).text().replace(/[\s\n]+/g, '').toLowerCase();
				$(this).nextUntil('.config-separator').wrapAll('<div class="vamtam-meta-part" id="tab-' + id + '"></div>');
				$(this).css('cursor', 'pointer');
				if ($(this).next().is('.vamtam-meta-part')) {
					meta_tabs.append('<li class="vamtam-meta-tab '+$(this).attr('data-tab-class')+'"><a href="#tab-' + id + '" title="">' + $(this).text() + '</a></li>');
				}
				$(this).remove();
			});

			if(meta_tabs.children().length > 1) {
				meta_tabs.closest('.metabox').tabs();
			} else {
				meta_tabs.hide();
			}
		});

		$('#vamtam-config').tabs({
			activate: function(event, ui) {
				var hash = ui.newTab.context.hash;
				var element = $(hash);
				element.attr('id', '');
				window.location.hash = hash;
				element.attr('id', hash.replace('#', ''));

				$('.save-vamtam-config').show();
				if (ui.newTab.hasClass('nosave')) $('.save-vamtam-config').hide();
			},
			create: function(event, ui) {
				if (ui.tab.hasClass('nosave')) $('.save-vamtam-config').hide();
			}
		});

		$('body').on('click', '.info-wrapper > a', function(e) {
			var other = $(this).attr('data-other');
			$(this).attr('data-other', $(this).text()).text(other);
			$(this).siblings('.desc').slideToggle(200);
			e.preventDefault();
		});
	});
})(jQuery);
(function($, undefined) {
	"use strict";

	$(function() {
		var groups = [{
			options: '#vamtam-post-format-options',
			select: '#post-formats-select'
		}, {
			options: '#vamtam-portfolio-format-options',
			select: '#vamtam-portfolio-formats-select'
		}];

		_.each(groups, function(group) {
			var post_formats = $(group.options);
			if(post_formats.length) {
				var pf_tabs = post_formats.find('.vamtam-meta-tabs').hide(),
					pf_select = $(group.select);

				pf_select.find(':radio').change(function() {
					var checked = pf_select.find(':checked'),
						format_name = checked.prop('id') || 'post-format-'+checked.val(),
						tab = pf_tabs.find('li.vamtam-'+ format_name + ' a');

					tab.click();

					pf_tabs.parent().find('.vamtam-config-row.vamtam-all-formats').appendTo($(tab.attr('href')));
				}).change();

				post_formats.insertBefore($('#postdivrich')).addClass( 'vamtam-repositioned' );
			}
		});
	});
})(jQuery);