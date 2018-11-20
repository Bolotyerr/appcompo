(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

exports.default = function () {
	var $ = jQuery;

	var body = $(document.body);

	var settings = {};

	var mediaElement = function mediaElement(context) {
		if (typeof window._wpmejsSettings !== 'undefined') {
			settings = $.extend(true, {}, window._wpmejsSettings);
		}

		settings.classPrefix = 'mejs-';
		settings.success = settings.success || function (mejs) {
			var autoplay, loop;

			if (mejs.rendererName && -1 !== mejs.rendererName.indexOf('flash')) {
				autoplay = mejs.attributes.autoplay && 'false' !== mejs.attributes.autoplay;
				loop = mejs.attributes.loop && 'false' !== mejs.attributes.loop;

				if (autoplay) {
					mejs.addEventListener('canplay', function () {
						mejs.play();
					}, false);
				}

				if (loop) {
					mejs.addEventListener('ended', function () {
						mejs.play();
					}, false);
				}
			}
		};

		if ('mediaelementplayer' in $.fn) {
			// Only initialize new media elements.
			$('.wp-audio-shortcode, .wp-video-shortcode', context).not('.mejs-container').filter(function () {
				return !$(this).parent().hasClass('mejs-mediaelement');
			}).mediaelementplayer(settings);
		}
	};

	// infinite scrolling
	if (document.body.classList.contains('pagination-infinite-scrolling')) {
		var last_auto_load = 0;
		$(window).bind('resize scroll', function (e) {
			var button = $('.lm-btn'),
			    now_time = e.timeStamp || new Date().getTime();

			if (now_time - last_auto_load > 500 && parseFloat(button.css('opacity'), 10) === 1 && $(window).scrollTop() + $(window).height() >= button.offset().top) {
				last_auto_load = now_time;
				button.click();
			}
		});
	}

	if (!document.body.classList.contains('fl-builder-active')) {
		document.body.addEventListener('click', function (e) {
			var button = e.target.closest('.load-more');

			if (button) {
				e.preventDefault();
				e.stopPropagation(); // customizer support

				var self = $(button);
				var list = self.prev();
				var link = button.querySelector('a');

				if (button.classList.contains('loading')) {
					return false;
				}

				self.addClass('loading').find('> *').animate({ opacity: 0 });

				$.post(VAMTAM_FRONT.ajaxurl, {
					action: 'vamtam-load-more',
					query: JSON.parse(link.dataset.query),
					other_vars: JSON.parse(link.dataset.otherVars)
				}, function (result) {
					var content = $(result.content);

					mediaElement(content);

					var visible = list.find('.cbp-item:not( .cbp-item-off )').length;

					list.cubeportfolio('append', content, function () {
						if (visible === list.find('.cbp-item:not( .cbp-item-off )').length) {
							var warning = document.createElement('p');
							warning.classList.add('vamtam-load-more-warning');
							warning.innerText = list.data('hidden-by-filters');

							button.after(warning);

							body.one('click', function () {
								warning.remove();
							});
						}

						button.outerHTML = result.button;

						self.removeClass('loading').find('> *').animate({ opacity: 1 });

						window.VAMTAM.resizeElements();
					});
				});
			}
		});
	}
};

},{}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

exports.default = function () {
	// button with lightbox

	{
		window.addEventListener('click', function (e) {
			var button = e.target.closest('[data-vamtam-lightbox]');

			if (button) {
				e.preventDefault();

				var contents = document.getElementById('vamtam-lightbox-template');

				var lightboxWrapper = document.createElement('div');
				lightboxWrapper.classList.add('vamtam-button-lightbox-wrapper');
				lightboxWrapper.innerHTML = contents.innerHTML.replace('{{ lightbox_content }}', button.dataset.vamtamLightbox);

				var closeLightbox = function closeLightbox(e) {
					e.preventDefault();

					requestAnimationFrame(function () {
						lightboxWrapper.addEventListener('transitionend', function () {
							lightboxWrapper.remove();

							document.documentElement.style.marginRight = '';
							document.documentElement.style.overflow = '';
						}, false);

						lightboxWrapper.style.transitionDuration = '0.2s';
						lightboxWrapper.style.opacity = 0;
					});
				};

				lightboxWrapper.querySelector('.vamtam-button-lightbox-close').addEventListener('click', closeLightbox);
				lightboxWrapper.addEventListener('click', closeLightbox);

				requestAnimationFrame(function () {
					document.body.appendChild(lightboxWrapper);

					document.documentElement.style.marginRight = window.innerWidth - document.documentElement.offsetWidth + 'px';
					document.documentElement.style.overflow = 'hidden';

					window.VAMTAM.resizeElements();
					lightboxWrapper.style.opacity = 1;
				});
			}
		});
	}

	// search

	var lightbox = document.getElementById('vamtam-overlay-search');
	var inside = lightbox.children;

	// initialize styles before any animations
	lightbox.style.display = 'none';

	for (var i = 0; i < inside.length; i++) {
		inside[i].style.animationDuration = '300ms';
		inside[i].style.display = 'none';
	}

	// opening animation
	document.body.addEventListener('click', function (e) {
		if (e.target.closest('.vamtam-overlay-search-trigger')) {
			e.preventDefault();

			requestAnimationFrame(function () {
				lightbox.classList.add('vamtam-animated', 'vamtam-fadein');
				lightbox.style.display = 'block';

				setTimeout(function () {
					requestAnimationFrame(function () {
						for (var i = 0; i < inside.length; i++) {
							inside[i].style.display = 'block';
							inside[i].classList.add('vamtam-animated', 'vamtam-zoomin');
						}

						requestAnimationFrame(function () {
							lightbox.querySelector('input[type=search]').focus();
						});
					});
				}, 200);
			});
		}
	});

	var $lightbox = jQuery(lightbox);

	// closing animation
	document.getElementById('vamtam-overlay-search-close').addEventListener('click', function (e) {
		e.preventDefault();

		requestAnimationFrame(function () {
			lightbox.classList.remove('vamtam-animated', 'vamtam-fadein');
			lightbox.classList.add('vamtam-animated', 'vamtam-fadeout');

			for (var i = 0; i < inside.length; i++) {
				inside[i].classList.remove('vamtam-animated', 'vamtam-zoomin');
				inside[i].classList.add('vamtam-animated', 'vamtam-zoomout');
			}

			$lightbox.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
				requestAnimationFrame(function () {
					lightbox.style.display = 'none';
					lightbox.classList.remove('vamtam-animated', 'vamtam-fadeout');

					for (var i = 0; i < inside.length; i++) {
						inside[i].style.display = 'none';
						inside[i].classList.remove('vamtam-animated', 'vamtam-zoomout');
					}
				});
			});
		});
	});
};

},{}],3:[function(require,module,exports){
'use strict';

var _portfolio = require('./portfolio');

var _portfolio2 = _interopRequireDefault(_portfolio);

var _ajaxNavigation = require('./ajax-navigation');

var _ajaxNavigation2 = _interopRequireDefault(_ajaxNavigation);

var _lightbox = require('./lightbox');

var _lightbox2 = _interopRequireDefault(_lightbox);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

(function (v, undefined) {
	'use strict';

	// portfolio

	v.portfolio = new _portfolio2.default();

	// infinite scrolling
	(0, _ajaxNavigation2.default)();

	// lightbox
	(0, _lightbox2.default)();

	// scroll to top button
	{
		var st_buttons = document.querySelectorAll('.vamtam-scroll-to-top');

		if (st_buttons.length) {
			vamtam_greensock_wait(function () {
				var side_st_button = document.getElementById('scroll-to-top');

				if (side_st_button) {
					v.addScrollHandler({
						init: function init() {},
						measure: function measure() {},
						mutate: function mutate(cpos) {
							if (cpos > 0) {
								side_st_button.style.opacity = 1;
								side_st_button.style.transform = 'scale3d( 1, 1, 1 )';
							} else {
								side_st_button.style.opacity = '';
								side_st_button.style.transform = '';
							}
						}
					});
				}

				document.addEventListener('click', function (e) {
					if (e.target.classList.contains('vamtam-scroll-to-top')) {
						e.preventDefault();

						vamtam_greensock_wait(function () {
							// iOS Safari uses a simple animation, normal browsers use scroll-behavior:smooth
							if (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream) {
								window.scrollTo(0, 0);
							} else {
								window.scroll({ left: 0, top: 0, behavior: 'smooth' });
							}
						});
					}
				}, true);
			});
		}
	}
})(window.VAMTAM); /* jshint esversion: 6 */

},{"./ajax-navigation":1,"./lightbox":2,"./portfolio":4}],4:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/* jshint esversion: 6, module: true */

var $ = jQuery;

var Portfolio = function Portfolio() {
	$(function () {
		this.init();
	}.bind(this));
};

Portfolio.prototype.init = function () {
	this.wrappers = $('.portfolios');

	this.wrappers.on('mouseenter', '.vamtam-project', this.mouseenter.bind(this));
	this.wrappers.on('mouseleave', '.vamtam-project', this.mouseleave.bind(this));
	this.wrappers.on('touchstart', '.vamtam-project', this.touchstart.bind(this));
	this.wrappers.on('touchmove', '.vamtam-project', this.touchmove.bind(this));
	this.wrappers.on('touchend', '.vamtam-project', this.touchend.bind(this));

	// close all open projects on touchstart anywhere outside a project
	document.body.addEventListener('touchstart', function (e) {
		var closest = e.target.closest('.vamtam-project');
		var open = document.querySelectorAll('.vamtam-project.state-open');

		for (var i = 0; i < open.length; i++) {
			if (open[i] !== closest) {
				this.doClose(open[i]);
			}
		}
	}.bind(this));
};

Portfolio.prototype.mouseenter = function (e) {
	this.doOpen(e.target.closest('.vamtam-project'));
};

Portfolio.prototype.mouseleave = function (e) {
	this.doClose(e.target.closest('.vamtam-project'));
};

Portfolio.prototype.touchstart = function (e) {
	var item = e.target.closest('.vamtam-project');

	if (item.classList.contains('state-closed') && !window.VAMTAM.MEDIA.layout['layout-below-max']) {
		item.vamtamMaybeOpen = true;
	}
};

Portfolio.prototype.touchend = function (e) {
	var item = e.target.closest('.vamtam-project');

	if (item.vamtamMaybeOpen) {
		item.vamtamMaybeOpen = false;

		this.doOpen(item);
		e.preventDefault();
	}
};

Portfolio.prototype.touchmove = function (e) {
	e.target.closest('.vamtam-project').vamtamMaybeOpen = false;
};

Portfolio.prototype.doOpen = function (el) {
	if (!el.classList.contains('state-open')) {
		requestAnimationFrame(function () {
			el.classList.add('state-open');
			el.classList.remove('state-closed');
		});
	}
};

Portfolio.prototype.doClose = function (el) {
	if (!el.classList.contains('state-closed')) {
		requestAnimationFrame(function () {
			el.classList.add('state-closed');
			el.classList.remove('state-open');
		});
	}
};

exports.default = Portfolio;

},{}]},{},[3]);
