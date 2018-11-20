jQuery(window).load(function(){
	
/*==================================Scroll Menu======================================*/
		 var scrollable = jQuery('.mig-scroll-menu-container').attr('data-scroll-scrollable');
/*=============================== Scroll To function ================================*/
	jQuery('.mig-scroll-tag-wrapper').each(function(){ // begin of script
		 var scrollid = jQuery(this).attr('id');
		 var scrollbackground = jQuery(this).attr('data-scroll-buttonbackground');
		 var scrolltextcolor = jQuery(this).attr('data-scroll-textcolor');
		 var scrolltext = jQuery(this).attr('data-scroll-buttontext');
		 var scrolltime = parseInt(jQuery(this).attr('data-scroll-time'));
		 var scrolltagposition = jQuery(this).attr('data-scroll-tagposition');
		 var buttonposition = jQuery(this).offset();
		 var buttonappended = false;
		 var titlesize = jQuery(this).attr('data-scroll-titlesize');
		 var scrollclosesttagged = jQuery('#'+scrollid).prevAll(titlesize+':first').offset();
		 if(scrollclosesttagged == undefined){
		 var scrollclosesttagged = buttonposition; 
		 }
		 
	
if(scrollable == 'yes'){	 //begin of first if
	jQuery(document).scroll(function() {
		if(jQuery(this).scrollTop() > buttonposition.top) {
			
			if(!buttonappended){
				jQuery('.mig-scroll-menu-container').append('<div id="mig-scroll-'+scrollid+'" class="mig-scroll-button-class" style="opacity:0; right:-100%; background-color:'+scrollbackground+'; color:'+scrolltextcolor+'; position:relative;">'+scrolltext+'</a></div>');
				jQuery('#mig-scroll-'+scrollid).animate({opacity: 1, right: 0},200)
				buttonappended = true;
				
				if(scrolltagposition == 'Default'){
					jQuery('#mig-scroll-'+scrollid).click(function() {
						jQuery('body,html').animate({scrollTop: (buttonposition.top - 90)}, scrolltime);
					});	
				}
				
				if(scrolltagposition == 'Closest title'){
					jQuery('#mig-scroll-'+scrollid).click(function() {
						jQuery
						jQuery('body,html').animate({scrollTop: (scrollclosesttagged.top -40)}, scrolltime);
					});	
				}
			}
			
		} 
		
		else {
			jQuery('#mig-scroll-'+scrollid).animate({opacity: 0, right: '-100%'},200, function(){
				jQuery('#mig-scroll-'+scrollid).remove();	
			})
			
			buttonappended = false;
		}
	
	});
 
} //enf of first if
	
if(scrollable == 'no'){
	if(!buttonappended){
				jQuery('.mig-scroll-menu-container').append('<div id="mig-scroll-'+scrollid+'" class="mig-scroll-button-class" style="opacity:0; right:-100%; background-color:'+scrollbackground+'; color:'+scrolltextcolor+'; position:relative;">'+scrolltext+'</a></div>');
				jQuery('#mig-scroll-'+scrollid).animate({opacity: 1, right: 0},200)
				buttonappended = true;
				
				if(scrolltagposition == 'Default'){
					jQuery('#mig-scroll-'+scrollid).click(function() {
						jQuery('body,html').animate({scrollTop: (buttonposition.top - 90)}, scrolltime);
					});	
				}
				
				if(scrolltagposition == 'Closest title'){
					jQuery('#mig-scroll-'+scrollid).click(function() {
						jQuery
						jQuery('body,html').animate({scrollTop: (scrollclosesttagged.top -40)}, scrolltime);
					});	
				}
			}
}
}) //end of script
	

	
}); /*============End of window load ================*/