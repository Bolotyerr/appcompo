(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

/* jshint esnext:true */

(function ($, undefined) {
	'use strict';

	var api = wp.customize;

	// toggle visibility of some controls based on a setting's value
	// @see wp-admin/js/customize-controls.js
	$.each({
		'vamtam_theme[header-logo-type]': [{
			controls: ['vamtam_theme[custom-header-logo]'],
			callback: function callback(to) {
				return 'image' === to;
			}
		}],

		'vamtam_theme[site-layout-type]': [{
			controls: ['vamtam_theme[full-width-header]'],
			callback: function callback(to) {
				return 'boxed' !== to;
			}
		}, {
			controls: ['vamtam_theme[boxed-layout-padding]'],
			callback: function callback(to) {
				return 'boxed' === to;
			}
		}],

		'vamtam_theme[header-layout]': [{
			controls: ['vamtam_theme[full-width-header]'],
			callback: function callback(to) {
				return 'logo-menu' === to;
			} // show if header is 'logo-menu'
		}, {
			controls: ['vamtam_theme[sub-header-background]'],
			callback: function callback(to) {
				return 'logo-menu' !== to;
			} // show if header is not 'logo-menu'
		}],

		'vamtam_theme[top-bar-layout]': [{
			controls: ['vamtam_theme[top-bar-social-lead]', 'vamtam_theme[top-bar-social-fb]', 'vamtam_theme[top-bar-social-twitter]', 'vamtam_theme[top-bar-social-linkedin]', 'vamtam_theme[top-bar-social-gplus]', 'vamtam_theme[top-bar-social-flickr]', 'vamtam_theme[top-bar-social-pinterest]', 'vamtam_theme[top-bar-social-dribbble]', 'vamtam_theme[top-bar-social-instagram]', 'vamtam_theme[top-bar-social-youtube]', 'vamtam_theme[top-bar-social-vimeo]'],
			callback: function callback(to) {
				return ['menu-social', 'social-menu', 'social-text', 'text-social'].indexOf(to) > -1;
			}
		}, {
			controls: ['vamtam_theme[top-bar-text]'],
			callback: function callback(to) {
				return ['menu-text', 'text-menu', 'social-text', 'text-social', 'fulltext'].indexOf(to) > -1;
			}
		}]
	}, function (settingId, conditions) {
		api(settingId, function (setting) {
			$.each(conditions, function (cndi, o) {
				$.each(o.controls, function (i, controlId) {
					api.control(controlId, function (control) {
						var visibility = function visibility(to) {
							control.container.toggle(o.callback(to));
						};

						visibility(setting.get());
						setting.bind(visibility);
					});
				});
			});
		});
	});
})(jQuery);

},{}]},{},[1]);
