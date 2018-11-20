jQuery(document).ready(function($) {

	// Frame
	$('.mig-scroll-menu-frame-align-center, .mig-scroll-menu-frame-align-none').each(function() {
		var frame_width = $(this).find('img').width();
		$(this).css('width', frame_width + 12);
	});

	// Spoiler
	$('.mig-scroll-menu-spoiler .mig-scroll-menu-spoiler-title').click(function() {

		var // Spoiler news
		spoiler = $(this).parent('.mig-scroll-menu-spoiler').filter(':first'),
		title = spoiler.children('.mig-scroll-menu-spoiler-title'),
		content = spoiler.children('.mig-scroll-menu-spoiler-content'),
		isAccordion = ( spoiler.parent('.mig-scroll-menu-accordion').length > 0 ) ? true : false;

		if ( spoiler.hasClass('mig-scroll-menu-spoiler-open') ) {
			if ( !isAccordion ) {
				content.hide(200);
				spoiler.removeClass('mig-scroll-menu-spoiler-open');
			}
		}
		else {
			spoiler.parent('.mig-scroll-menu-accordion').children('.mig-scroll-menu-spoiler').removeClass('mig-scroll-menu-spoiler-open');
			spoiler.parent('.mig-scroll-menu-accordion').find('.mig-scroll-menu-spoiler-content').hide(200);
			content.show(100);
			spoiler.addClass('mig-scroll-menu-spoiler-open');
		}
	});

	// Tabs
	$('.mig-scroll-menu-tabs-nav').delegate('span:not(.mig-scroll-menu-tabs-current)', 'click', function() {
		$(this).addClass('mig-scroll-menu-tabs-current').siblings().removeClass('mig-scroll-menu-tabs-current')
		.parents('.mig-scroll-menu-tabs').find('.mig-scroll-menu-tabs-pane').hide().eq($(this).index()).show();
	});
	$('.mig-scroll-menu-tabs-pane').hide();
	$('.mig-scroll-menu-tabs-nav span:first-child').addClass('mig-scroll-menu-tabs-current');
	$('.mig-scroll-menu-tabs-panes .mig-scroll-menu-tabs-pane:first-child').show();

	// Tables
	$('.mig-scroll-menu-table tr:even').addClass('mig-scroll-menu-even');

});

function mycarousel_initCallback(carousel) {

	// Disable autoscrolling if the user clicks the prev or next button.
	carousel.buttonNext.bind('click', function() {
		carousel.startAuto(0);
	});

	carousel.buttonPrev.bind('click', function() {
		carousel.startAuto(0);
	});

	// Pause autoscrolling if the user moves with the cursor over the clip.
	carousel.clip.hover(function() {
		carousel.stopAuto();
	}, function() {
		carousel.startAuto();
	});
}