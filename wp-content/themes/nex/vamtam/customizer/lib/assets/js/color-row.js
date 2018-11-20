wp.customize.controlConstructor['vamtam-color-row'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control = this,
		    colors  = control.params.choices,
		    keys    = Object.keys( colors ),
		    value   = this.params.value;

		// Proxy function that handles changing the individual colors
		function vamtamColorRowChangeHandler( control, value, subSetting ) {

			var picker = control.container.find( '.vamtam-color-row-index-' + subSetting );

			picker.wpColorPicker({
				change: function() {
					// Color controls require a small delay
					setTimeout( function() {
						value[ subSetting ] = picker.val();

						// Set the value
						control.setValue( value, false );

						// Trigger the change
						control.container.find( '.vamtam-color-row-index-' + subSetting ).trigger( 'change' );
					}, 100 );
				},
				palettes: false,
			});

		}

		// The hidden field that keeps the data saved (though we never update it)
		this.settingField = this.container.find( '[data-customize-setting-link]' ).first();

		// Colors loop
		for ( var i = 0; i < Object.keys( colors ).length; i++ ) {

			vamtamColorRowChangeHandler( this, value, keys[ i ] );
		}

	},

	/**
	 * Set a new value for the setting
	 *
	 * @param newValue Object
	 * @param refresh If we want to refresh the previewer or not
	 */
	setValue: function( value, refresh ) {

		'use strict';

		var control  = this,
		    newValue = {};

		_.each( value, function( newSubValue, i ) {
			newValue[ i ] = newSubValue;
		});

		control.setting.set( newValue );

		if ( refresh ) {

			// Trigger the change event on the hidden field so
			// previewer refresh the website on Customizer
			control.settingField.trigger( 'change' );

		}

	}

});