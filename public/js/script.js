// JavaScript Document
$(document).ready(function(e) {
    $('.nav > li').hover(function(e) {
        $(this).children('a').next('ul').css('display', 'block').css('z-index',100);
		$(this).children('a').css('background-color', '#FFF');
    },function(){
		$(this).children('a').next('ul').css('display', 'none');
		$(this).children('a').css('background-color', 'initial');
	});
});

