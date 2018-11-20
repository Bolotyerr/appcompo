<?php

	
	/**
	 * Open group of Shortcodes
	 */
	function mig_scroll_menu_shortcodes( $shortcode = false ) {

		$shortcodes = array(
			# basic shortcodes - start
			'basic-shortcodes-open' => array(
				'name' => __( 'Basic shortcodes', 'mig-fx' ),
				'type' => 'opengroup'
			),

			
			/*===================
			Scroll Tag
			=====================
			*/
			
			'scrolltag' => array(
				'name' => 'Scroll tag and Button',
				'desc' => 'Scroll tag and Button',
				'type' => 'single',
				'atts' => array(
					'id' => array(
						'values' => array(),
						
						'desc' => 'Set a unique name for this button',
						'help' => 'Ex: Tag1'
					),
					
					'tagposition' => array(
						'values' => array(
							'Default',
							'Closest title',
						),
						'desc' => 'Select the tag position',
					),
					
					'titlesize' => array(
						'values' => array(
							'h1',
							'h2',
							'h3',
							'h4',
							'h5',
							'h6',
						),
						'desc' => 'Type of title to find',
					),
					
					
					'buttonbackground' => array(
						'values' => array(),
						'desc' => __( 'Select the background color of this button', 'mig-fx' ),
						'type' => 'color',
						'default' => '#e84809',
					),
					
					'textcolor' => array(
						'values' => array(),
						'desc' => __( 'Select the color of text', 'mig-fx' ),
						'type' => 'color',
						'default' => '#ffffff',
					),
					
					'buttontext' => array(
						'values' => array(),
						'desc' => 'Text to show inside the button',
					),
					
					'scrolltime' => array(
						'values' => array(
							'200',
							'400',
							'600',
							'800',
							'1000',
							'1200',
							'1400',
							'1600',
							'1800',
							'2000',
							'2200',
							'2400',
							'2600',
							'2800',
							'3000',
						),
						'desc' => 'Speed of the scroll in miliseconds (1000 ms = 1s)',
						'default' => '600',
					),
					
					
				),
			),
			
			
		
		# basic shortcodes - end
		'basic-shortcodes-close' => array(
			'type' => 'closegroup'
		),
	);

		if ( $shortcode )
			return $shortcodes[$shortcode];
		else
			return $shortcodes;
	}

?>