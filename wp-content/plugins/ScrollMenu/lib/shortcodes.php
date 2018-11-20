<?php	

			/*===================
			SCROLL TAG
			=====================
			*/
	 	
			
			function mig_scroll_menu_scrolltag_shortcode($atts, $content){
	
			extract( shortcode_atts( array(
						'id' => '',
						'buttonbackground' => '',
						'textcolor' => '',
						'buttontext' => '',
						'scrolltime' => '',
						'tagposition' => '',
						'titlesize' => '',
						
						
					), $atts ) );
					
					$output .= '<span class="mig-scroll-tag-wrapper" id="'.$id.'" data-scroll-buttonbackground="'.$buttonbackground.'" data-scroll-textcolor="'.$textcolor.'" data-scroll-buttontext="'.$buttontext.'" data-scroll-time="'.$scrolltime.'" data-scroll-tagposition="'.$tagposition.'" data-scroll-titlesize="'.$titlesize.'"></span>';
					
					return $output;
			}
			
			