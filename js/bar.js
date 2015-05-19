// JavaScript Document
// Cache selectors outside callback for performance. 
function sticky_relocate() {
	var window_top = $(window).scrollTop();
	var div_top = $('#bar-anchor').offset().top;
	if (window_top > div_top)
		$('#bar').addClass('sticky');
	else
		$('#bar').removeClass('sticky');
}
$(function() {
	$(window).scroll(sticky_relocate);
	sticky_relocate();
});