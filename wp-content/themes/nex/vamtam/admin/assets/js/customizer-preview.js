(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _helpers = require('./helpers');

var general = function general(api, $) {
	'use strict';

	api('vamtam_theme[show-splash-screen]', function (value) {
		value.bind(function (to) {
			if (+to) {
				$('body').triggerHandler('vamtam-preview-splash-screen');
			}
		});
	});

	api('vamtam_theme[splash-screen-logo]', function (value) {
		value.bind(function (to) {
			var wrapper = $('.vamtam-splash-screen-progress-wrapper');
			var current_image = wrapper.find('> img');

			if (current_image.length === 0) {
				current_image = $('<img />');
				wrapper.prepend(current_image);
			}

			current_image.attr('src', to);

			$('body').triggerHandler('vamtam-preview-splash-screen');
		});
	});

	api('vamtam_theme[show-scroll-to-top]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('#scroll-to-top'), to);
		});
	});

	api('vamtam_theme[show-related-posts]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('.vamtam-related-content.related-posts'), to);
		});
	});

	api('vamtam_theme[related-posts-title]', function (value) {
		value.bind(function (to) {
			$('.related-posts .related-content-title').html(to);
		});
	});

	api('vamtam_theme[show-single-post-image]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('.single-post > .post-media-image'), to);
		});
	});

	api('vamtam_theme[post-meta]', function (value) {
		value.bind(function (to) {
			for (var type in to) {
				(0, _helpers.toggle)($('.vamtam-meta-' + type), +to[type]);
			}
		});
	});

	api('vamtam_theme[show-related-portfolios]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('.vamtam-related-content.related-portfolios'), to);
		});
	});

	api('vamtam_theme[related-portfolios-title]', function (value) {
		value.bind(function (to) {
			$('.related-portfolios .related-content-title').html(to);
		});
	});
}; /* jshint esnext:true */

exports.default = general;

},{"./helpers":2}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

/* jshint esnext:true */

var toggle = function toggle(el, visibility) {
	'use strict';

	if (+visibility) {
		el.show();
	} else {
		el.hide();
	}
};

function isNumeric(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}

/**
 * Converts an RGB color value to HSL. Conversion formula
 * adapted from http://en.wikipedia.org/wiki/HSL_color_space.
 * Assumes r, g, and b are contained in the set [0, 255] and
 * returns h, s, and l for use with the hsl() notation in CSS
 *
 * @param   Number  r       The red color value
 * @param   Number  g       The green color value
 * @param   Number  b       The blue color value
 * @return  Array           The HSL representation
 */
function rgbToHsl(r, g, b) {
	r /= 255, g /= 255, b /= 255;

	var max = Math.max(r, g, b),
	    min = Math.min(r, g, b);
	var h = void 0,
	    s = void 0,
	    l = (max + min) / 2;

	if (max == min) {
		h = s = 0; // achromatic
	} else {
		var d = max - min;
		s = l > 0.5 ? d / (2 - max - min) : d / (max + min);

		switch (max) {
			case r:
				h = (g - b) / d + (g < b ? 6 : 0);break;
			case g:
				h = (b - r) / d + 2;break;
			case b:
				h = (r - g) / d + 4;break;
		}

		h /= 6;
	}

	return [h * 360, s * 100, l * 100];
}

function hexToRgb(hex) {
	// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
	var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
	hex = hex.replace(shorthandRegex, function (m, r, g, b) {
		return r + r + g + g + b + b;
	});

	var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	return result ? [parseInt(result[1], 16), parseInt(result[2], 16), parseInt(result[3], 16)] : null;
}

function hexToHsl(hex) {
	return rgbToHsl.apply(undefined, _toConsumableArray(hexToRgb(hex)));
}

exports.toggle = toggle;
exports.isNumeric = isNumeric;
exports.rgbToHsl = rgbToHsl;
exports.hexToRgb = hexToRgb;
exports.hexToHsl = hexToHsl;

},{}],3:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _helpers = require('./helpers');

var layout = function layout(api, $) {
	'use strict';

	api('vamtam_theme[full-width-header]', function (value) {
		value.bind(function (to) {
			$('.header-maybe-limit-wrapper').toggleClass('limit-wrapper', to);
		});
	});

	api('vamtam_theme[sticky-header]', function (value) {
		value.bind(function (to) {
			requestAnimationFrame(function () {
				document.body.classList.toggle('sticky-header', +to);
				document.body.classList.remove('had-sticky-header');

				window.VAMTAM.stickyHeader.rebuild();
			});
		});
	});

	api('vamtam_theme[enable-header-search]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('header.main-header .search-wrapper'), +to);
		});
	});

	api('vamtam_theme[show-empty-header-cart]', function (value) {
		value.bind(function (to) {
			document.querySelector('.cart-dropdown').classList.toggle('show-if-empty', +to);
			$('body').trigger('wc_fragments_refreshed');
		});
	});

	api('vamtam_theme[one-page-footer]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('.footer-wrapper'), to);

			setTimeout(function () {
				window.VAMTAM.resizeElements();
			}, 50);
		});
	});

	api('vamtam_theme[page-title-layout]', function (value) {
		value.bind(function (to) {
			var header = $('header.page-header');
			var line = header.find('.page-header-line');

			header.removeClass('layout-centered layout-one-row-left layout-one-row-right layout-left-align layout-right-align').addClass('layout-' + to);

			if (to.match(/one-row-/)) {
				line.appendTo(header.find('h1'));
			} else {
				line.appendTo(header);
			}
		});
	});
}; /* jshint esnext:true */

exports.default = layout;

},{"./helpers":2}],4:[function(require,module,exports){
'use strict';

var _general = require('./general');

var _general2 = _interopRequireDefault(_general);

var _layout = require('./layout');

var _layout2 = _interopRequireDefault(_layout);

var _styles = require('./styles');

var _styles2 = _interopRequireDefault(_styles);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

(function ($, undefined) {
	'use strict';

	(0, _general2.default)(wp.customize, $);
	(0, _layout2.default)(wp.customize, $);
	(0, _styles2.default)(wp.customize, $);
})(jQuery); /* jshint esnext:true */

},{"./general":1,"./layout":3,"./styles":5}],5:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _helpers = require('./helpers');

var styles = function styles(api, $) {
	'use strict';

	var prepare_background = function prepare_background(to) {
		if (to['background-image'] !== '') {
			to['background-image'] = 'url(' + to['background-image'] + ')';
		}

		return to;
	};

	{
		(function () {
			var compiler_options = VAMTAM_CUSTOMIZE_PREVIEW.compiler_options;

			var real_id = function real_id(id) {
				return id.replace(/vamtam_theme\[([^\]]+)]/, '$1');
			};

			var change_handler_by_type = {
				number: function number(to) {
					var id = real_id(this.id);

					if (VAMTAM_CUSTOMIZE_PREVIEW.percentages.indexOf(id) !== -1) {
						to += '%';
					} else if (VAMTAM_CUSTOMIZE_PREVIEW.numbers.indexOf(id) !== -1) {
						// as is
					} else {
						to += 'px';
					}

					document.documentElement.style.setProperty('--vamtam-' + id, to);

					// trigger a resize event if we change any dimension
					$(window).resize();
				},
				background: function background(to) {
					var id = real_id(this.id);

					to = prepare_background(to);

					for (var prop in to) {
						document.documentElement.style.setProperty('--vamtam-' + id + '-' + prop, to[prop]);
					}
				},
				radio: function radio(to) {
					var id = real_id(this.id);

					if ((0, _helpers.isNumeric)(to)) {
						change_handler_by_type.number.call(this, to);
					} else {
						document.documentElement.style.setProperty('--vamtam-' + id, to);
					}
				},
				select: function select(to) {
					var id = real_id(this.id);

					change_handler_by_type.radio.call(this, to);
				},
				typography: function typography(to, from) {
					var id = real_id(this.id);

					var variant = to.variant;

					to['font-weight'] = 'normal';
					to['font-style'] = 'normal';

					to.variant = to.variant.split(' ');

					if (to.variant.length === 2) {
						to['font-weight'] = to.variant[0];
						to['font-style'] = to.variant[1];
					} else if (to.variant[0] === 'italic') {
						to['font-style'] = 'italic';
					} else {
						to['font-weight'] = to.variant[0];
					}

					delete to.variant;

					for (var prop in to) {
						document.documentElement.style.setProperty('--vamtam-' + id + '-' + prop, to[prop]);
					}

					// if the font-family is changed - we need to load the new font stylesheet
					if (to['font-family'] !== from['font-family']) {
						var new_font = window.top.VAMTAM_ALL_FONTS[to['font-family']];

						if (new_font.gf) {
							var family = encodeURIComponent(to['font-family']) + ':bold,' + variant.replace(' ', '');
							var subset = ''; // no subset support here, only newer browser can preview Google Fonts

							var link = document.createElement("link");
							link.href = 'https://fonts.googleapis.com/css?family=' + family + '&subset=' + subset;
							link.type = 'text/css';
							link.rel = 'stylesheet';
							document.getElementsByTagName('head')[0].appendChild(link);
						}
					}
				},
				'color-row': function colorRow(to) {
					var id = real_id(this.id);

					for (var prop in to) {
						document.documentElement.style.setProperty('--vamtam-' + id + '-' + prop, to[prop]);
					}

					if (id === 'accent-color') {
						// accents need readable colors
						for (var i = 1; i <= 8; i++) {
							var hex = to[i];
							var hsl = (0, _helpers.hexToHsl)(hex);

							var readable = '';
							var hc = '';

							if (hsl[2] > 80) {
								readable = 'hsl(' + hsl[0] + ', ' + hsl[1] + '%, ' + Math.max(0, hsl[2] - 50) + '%)'; //  $color->darken( 50 );
								hc = '#000000';
							} else {
								readable = 'hsl(' + hsl[0] + ', ' + hsl[1] + '%, ' + Math.min(0, hsl[2] + 50) + '%)'; //  $color->lighten( 50 );
								hc = '#ffffff';
							}

							document.documentElement.style.setProperty('--vamtam-accent-color-' + i + '-readable', readable);
							document.documentElement.style.setProperty('--vamtam-accent-color-' + i + '-hc', hc);
							document.documentElement.style.setProperty('--vamtam-accent-color-' + i + '-transparent', 'hsl(' + hsl[0] + ', ' + hsl[1] + '%, ' + hsl[2] + '%, 0)');
						}
					}
				},
				color: function color(to) {
					var id = real_id(this.id);

					document.documentElement.style.setProperty('--vamtam-' + id, to);
				}
			};

			// const compiler_option_handler = ;

			var _loop = function _loop(opt_name) {
				api(opt_name, function (setting) {
					var type = compiler_options[opt_name];

					if (type in change_handler_by_type) {
						setting.bind(change_handler_by_type[type]);
					} else {
						console.error('VamTam Customzier: Missing handler for option type ' + type + ' - option ' + opt_name);
						window.wpvval = setting;
					}
				});
			};

			for (var opt_name in compiler_options) {
				_loop(opt_name);
			}
		})();
	}

	api('vamtam_theme[page-title-background-hide-lowres]', function (value) {
		value.bind(function (to) {
			$('header.page-header').toggleClass('vamtam-hide-bg-lowres', to);
		});
	});

	api('vamtam_theme[main-background-hide-lowres]', function (value) {
		value.bind(function (to) {
			$('.vamtam-main').toggleClass('vamtam-hide-bg-lowres', to);
		});
	});
}; /* jshint esnext:true */

exports.default = styles;

},{"./helpers":2}]},{},[4]);
