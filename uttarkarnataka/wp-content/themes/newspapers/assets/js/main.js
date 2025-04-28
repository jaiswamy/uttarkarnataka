var $ = jQuery.noConflict();
$(document).ready(function() {
	
	"use strict";
	
	/*-----------------------------------------------------------------------------------*/
	/*  Match Height
	/*-----------------------------------------------------------------------------------*/
    $('.column').matchHeight(); 

	// Responsive video
	$(".hentry, .widget").fitVids();

	/*-----------------------------------------------------------------------------------*/
	/*  Superfish Menu
	/*-----------------------------------------------------------------------------------*/
	var example = $('ul.sf-menu').superfish({
		delay:       100,
		speed:       'fast',
		autoArrows:  false     
	});
	
	/*= News Ticker
	---------------------------------------------------------------------*/
	var newsTicker = jQuery('li.news-item');
	var tickerTimeId = 0;
	var currentNews = 0;
	var olderNews = 0;
	var sumNews = jQuery(newsTicker).size();

	function newsTickerInit(){
		jQuery(newsTicker).eq(0).fadeIn();
		newsTickerClick();
		tickerTimeId = setInterval(autoTicherScroll,6000);
	}
	newsTickerInit();

	function newsTickerClick(){
		jQuery(newsTicker).each(function(index){
			if(!jQuery(this).children('a').is(':hidden')){
				currentNews = index;
			}
		});
		jQuery('a.headline-prev').click(function(e){
			e.preventDefault();
			clearInterval(tickerTimeId);
			olderNews = currentNews;
			if(currentNews == 0){
				currentNews = sumNews-1;
			}else{
				currentNews = currentNews-1;
			}
			jQuery(newsTicker).eq(olderNews).stop(true,true).fadeOut().queue(function(){
				jQuery(newsTicker).eq(currentNews).stop(true,true).fadeIn();
			});

			tickerTimeId = setInterval(autoTicherScroll,6000);
		});
		jQuery('a.headline-next').click(function(e){
			e.preventDefault();
			clearInterval(tickerTimeId);
			olderNews = currentNews;
			if(currentNews == sumNews-1){
				currentNews = 0;
			}else{
				currentNews = currentNews+1;
			}
			jQuery(newsTicker).eq(olderNews).stop(true,true).fadeOut().queue(function(){
				jQuery(newsTicker).eq(currentNews).stop(true,true).fadeIn();
			});
			tickerTimeId = setInterval(autoTicherScroll,6000);
		});
	}

	function autoTicherScroll(){
		olderNews = currentNews;
		if(currentNews == sumNews-1){
			currentNews = 0;
		}else{
			currentNews = currentNews+1;
		}
		jQuery(newsTicker).eq(olderNews).stop(true,true).fadeOut().queue(function(){
			jQuery(newsTicker).eq(currentNews).stop(true,true).fadeIn();
		});
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Tabs
	/*-----------------------------------------------------------------------------------*/
	var $tabsNav    = $('.tabs-nav'),
		$tabsNavLis = $tabsNav.children('li'),
		$tabContent = $('.tab-content');

	$tabsNav.each(function() {
		var $this = $(this);

		$this.next().children('.tab-content').stop(true,true).hide().first().show();

		$this.children('li').first().addClass('active').stop(true,true).show();
	});

	$tabsNavLis.on('click', function(e) {
		var $this = $(this);

		$this.siblings().removeClass('active').end().addClass('active');

		$this.parent().next().children('.tab-content').stop(true,true).hide().siblings( $this.find('a').attr('href') ).fadeIn();

		e.preventDefault();
	});               

});

/*-----------------------------------------------------------------------------------*/
/*  Flexslider
/*-----------------------------------------------------------------------------------*/

$(window).load(function(){
	$('.flexslider').flexslider({
		animation: "slide",
		prevText: "",
		nextText: "",
		start: function(slider){
			$('body').removeClass('loading');
		}
	});
});