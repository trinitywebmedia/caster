/**
 * This script adds the custom jquery to the Samadhi Theme.
 *
 * @package Samadhi\JS
 * @author ZigzagPress
 * @license GPL-2.0+
 */

jQuery.noConflict();

// Portfolio item.
function zp_portfolio_item_width(){
	var container_width = jQuery('#zp_masonry_container').width();
	var window_width = jQuery(window).width();
	
	jQuery( '.zp_masonry_item' ).each( function(){
		if( window_width <= 600 ){
			if( jQuery(this).hasClass('col2') ){
				var item_width = Math.floor( (container_width - 30 ) / 1 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}
			if( jQuery(this).hasClass('col3') ){
				var item_width = Math.floor( (container_width - 20 ) / 1 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}
			if( jQuery(this).hasClass('col4') ){
				var item_width = Math.floor( ( container_width - 20 ) / 1 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}
			// Video/Audio height.
			var vid_aud_height = jQuery(this).find( '.jp-audio img, .jp-video img' ).height();
			jQuery(this).find( '.jp-audio, .jp-video' ).css({"height": vid_aud_height+"px" });
		}else if( window_width <= 768 ){
			if( jQuery(this).hasClass('col2') ){
				var item_width = Math.floor( (container_width - 40 ) / 2 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}
			if( jQuery(this).hasClass('col3') ){
				var item_width = Math.floor( (container_width - 40 ) / 2 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}
			if( jQuery(this).hasClass('col4') ){
				var item_width = Math.floor( ( container_width - 40 ) / 2 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}
			// Video/Audio height.
			var vid_aud_height = jQuery(this).find( '.jp-audio img, .jp-video img' ).height();
			jQuery(this).find( '.jp-audio, .jp-video' ).css({"height": vid_aud_height+"px" });
		}else if( window_width <= 1024 ){
			if( jQuery(this).hasClass('col2') ){
				var item_width = Math.floor( (container_width - 40 ) / 2 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}		
			if( jQuery(this).hasClass('col3') ){
				var item_width = Math.floor( (container_width - 60 ) / 3 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}
			if( jQuery(this).hasClass('col4') ){
				var item_width = Math.floor( ( container_width - 80 ) / 4 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}
			// Video/Audio height.
			var vid_aud_height = jQuery(this).find( '.jp-audio img, .jp-video img' ).height();
			jQuery(this).find( '.jp-audio, .jp-video' ).css({"height": vid_aud_height+"px" });
		}else{
			if( jQuery(this).hasClass('col2') ){			
				var item_width = Math.floor( (container_width - 40 ) / 2 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}		
			if( jQuery(this).hasClass('col3') ){
				var item_width = Math.floor( (container_width - 60 ) / 3 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}
			if( jQuery(this).hasClass('col4') ){
				var item_width = Math.floor( ( container_width - 80 ) / 4 );
				jQuery(this).css({"width":item_width+"px", "max-width":item_width+"px"});
			}
			// Video/Audio height.
			var vid_aud_height = jQuery(this).find( '.jp-audio img, .jp-video img' ).height();
			jQuery(this).find( '.jp-audio, .jp-video' ).css({"height": vid_aud_height+"px" });
		}
	});
}

// Initiates isotope.
function initiate_isotope(){

	// Sets portfolio item width.
	zp_portfolio_item_width();

	var jQuerycontainer = jQuery('#zp_masonry_container');
	// Checks pre-selected category.
	filter_item = jQuery('.zp_masonry_filter .option-set a.selected').attr('data-option-value');

	jQuerycontainer.isotope({
		 itemSelector : '.zp_masonry_item ',
		 filter: filter_item
	});

	var jQueryoptionSets = jQuery('.zp_masonry_filter .option-set'),
	jQueryoptionLinks = jQueryoptionSets.find('a');	
	jQueryoptionLinks.click(function(){
			var jQuerythis = jQuery(this);
			// Doesn't proceed if already selected.
			if ( jQuerythis.hasClass('active') ) {
			  return false;
			}
			var jQueryoptionSet = jQuerythis.parents('.option-set');
			jQueryoptionSet.find('.active').removeClass('active');
			jQuerythis.addClass('active');

			// Makes option object dynamically, i.e. { filter: '.my-filter-class' }.
			var options = {},
				key = jQueryoptionSet.attr('data-option-key'),
				value = jQuerythis.attr('data-option-value');
			// Parses 'false' as false boolean.
			value = value === 'false' ? false : value;
			options[ key ] = value;
			if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
			  // Changes in layout modes need extra logic.
			  changeLayoutMode( jQuerythis, options )
			} else {
			  // Otherwise, applies new options.
			  jQuerycontainer.isotope( options );
			}
			return false;
	});

}

// Adds Scroll Function.
jQuery.fn.topLink = function(settings) {
	settings = jQuery.extend({
		min: 1,
		fadeSpeed: 200
	},
	settings );

	return this.each(function() {
		// Listens for scroll.
		
		var el = jQuery(this);
		el.hide(); // In case the user forgets.
		jQuery(window).scroll(function() {
			if(jQuery(window).scrollTop() >= settings.min) {
				el.fadeIn(settings.fadeSpeed);
			} else {
				el.fadeOut(settings.fadeSpeed);
			}
		});
	});
};

jQuery(document).ready(function() {

	// Enable search Icon
	jQuery( '.zp_search_icon, .zp_search_close' ).click( function(){
		jQuery( '.search_form_dropdown' ).toggle();
	});

	// To Top Link.	
	jQuery('#top-link').topLink({
		min: 400,
		fadeSpeed: 500
	});

	// Smoothscroll.
	jQuery('#top-link').click(function(e) {
		e.preventDefault();
		jQuery('html,body').animate({
             scrollTop: jQuery('body').offset().top-72
        }, 700, 'swing');
	});

	// Fitvids Plugin.
	jQuery('.fitvids, .video_container').fitVids();

	// Accordian.
	jQuery('.zp_open').collapse('show');
	
	// Tabs.
	jQuery('.tab_container').find('.nav.nav-tabs > li:first-child').children('a[data-toggle="tab"]').tab('show');
	jQuery('.tab_container').find('.nav.nav-tabs > li:first-child').children('a[data-toggle="tab"]').parent().addClass('active');	
	jQuery('.tab_container').find('.tab-content > div:first-child').addClass('active');

	// Mobile Menu.
	var windowWidth = jQuery(window).width();

	if( windowWidth <= 1024 ){
	    jQuery( '.mobile_menu' ).on( 'click', function(){
	        jQuery('.sliding_nav').addClass( 'sliding_open' );
	        jQuery(this).addClass('mobile_menu_close');      
	    });

	    jQuery( '.sliding_close' ).click(function(){
	        jQuery('.sliding_nav').removeClass( 'sliding_open' );
	        jQuery('.mobile_menu').removeClass('mobile_menu_close');
	    });
	}else{
		jQuery( '.mobile_menu' ).on( 'click', function(){			
			if(jQuery(this).hasClass( 'zp_close' ) ){
				jQuery(this).removeClass('zp_close');
				//jQuery( '.zp_before_header_nav nav.nav-primary' ).removeClass( 'menu_slideIn' ).css({"overflow":"hidden"});
				jQuery('.zp_before_header_nav nav.nav-primary').removeClass('menu_slideIn');
				jQuery( '.zp_before_header_nav nav.nav-primary ul.menu.genesis-nav-menu' ).animate({
					    'left': '-100%'
					}, 500 );
			}else{
				jQuery(this).addClass('zp_close');
				//jQuery( '.zp_before_header_nav nav.nav-primary' ).addClass( 'menu_slideIn' ).delay(5000).css({"overflow":"visible"});

				jQuery( '.zp_before_header_nav nav.nav-primary ul.menu.genesis-nav-menu' ).animate({
					    'left': '0'
					}, 500, function() {
					   jQuery('.zp_before_header_nav nav.nav-primary').addClass('menu_slideIn');
				});
			}		
		});
	}

	// Pop-up for portfolio images.
		jQuery('.gallery-popup').magnificPopup({
			delegate: 'a',
			type: 'image',
			closeOnContentClick: 'true',
			mainClass: 'mfp-with-zoom',
			zoom: {
				enabled: true, 
				duration: 300, 
				easing: 'ease-in-out',
				opener: function(openerElement) {
				  return openerElement.is('img') ? openerElement : openerElement.find('img');
				}
			}
		});

		// Pop up Image.
		jQuery('.gallery-image a').magnificPopup({ type: 'image' });
		// Pop up image slider.
		jQuery(".gallery-slide").magnificPopup({
			delegate: "a",
			type: "image",
			tLoading: "Loading image...",
			mainClass: "mfp-img-mobile",
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1]
			},
			callbacks: {
				buildControls: function() {
					this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
			}
			
		  }
		});
	
		// Pop-up for portfolio videos.
		jQuery('.gallery-video, .split_video').magnificPopup({
			delegate: 'a',
			type: 'iframe',
			closeOnContentClick: 'true',
			zoom: {
				enabled: true, 
				duration: 300, 
				easing: 'ease-in-out'
			},
			disableOn: 700,
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});

		// Enables swiper carousels.
		jQuery('.zp-widget-swiper').each( function() {
			var swiper = null,
				uniqId = jQuery(this).data('uniq-id'),
				slidesPerView = parseFloat( jQuery(this).data('slides-per-view') ),
				slidesPerGroup = parseFloat( jQuery(this).data('slides-per-group') ),
				slidesPerColumn = parseFloat( jQuery(this).data('slides-per-column') ),
				spaceBetweenSlides = parseFloat( jQuery(this).data('space-between-slides') ),
				durationSpeed = parseFloat( jQuery(this).data('duration-speed') ),
				swiperLoop = jQuery(this).data('swiper-loop'),
				freeMode = jQuery(this).data('free-mode'),
				grabCursor = jQuery(this).data('grab-cursor'),
				mouseWheel = jQuery(this).data('mouse-wheel'),
				breakpointsSettings = {
					1200: {
						slidesPerView: Math.floor( slidesPerView * 0.75 ),
						spaceBetween: Math.floor( spaceBetweenSlides * 0.75 )
					},
					992: {
						slidesPerView: Math.floor( slidesPerView * 0.5 ),
						spaceBetween: Math.floor( spaceBetweenSlides * 0.5 )
					},
					769: {
						slidesPerView: ( 0 !== Math.floor( slidesPerView * 0.25 ) ) ? Math.floor( slidesPerView * 0.25 ) : 2
					},
					600: {
						slidesPerView: 1
					}
				};

			if ( 1 == slidesPerView ) {
				breakpointsSettings = {}
			}

			var swiper = new Swiper( '#' + uniqId, {
					slidesPerView: slidesPerView,
					slidesPerGroup: slidesPerGroup,
					slidesPerColumn: slidesPerColumn,
					spaceBetween: spaceBetweenSlides,
					speed: durationSpeed,
					loop: swiperLoop,
					freeMode: freeMode,
					grabCursor: grabCursor,
					mousewheelControl: mouseWheel,
					paginationClickable: true,
					nextButton: '#' + uniqId + '-next',
					prevButton: '#' + uniqId + '-prev',
					pagination: '#' + uniqId + '-pagination',
					onInit: function(){
						jQuery( '#' + uniqId + '-next' ).css({ 'display': 'block' });
						jQuery( '#' + uniqId + '-prev' ).css({ 'display': 'block' });
					},
					breakpoints: breakpointsSettings
				}
			);
		});	

		// Enables swiper slider.
		/*jQuery('.zpps-post-slider-swiper').each( function() {
			var swiper = null,
				uniqId = jQuery(this).data('uniq-id'),
				durationSpeed = parseFloat( jQuery(this).data('duration-speed') ),
				//swiperLoop = jQuery(this).data('swiper-loop'),
				//freeMode = jQuery(this).data('free-mode'),
				//grabCursor = jQuery(this).data('grab-cursor'),
				//mouseWheel = jQuery(this).data('mouse-wheel');

				slidesperview = jQuery(this).data('slidesperview'),
				centeredslides = jQuery(this).data('centeredslides'),
				spacebetween = parseFloat(jQuery(this).data('spacebetween'));

				console.log(uniqId);


			var swiper = new Swiper( '#' + uniqId, {
					//speed: durationSpeed,
					loop: 'true',
					slidesPerView: slidesperview,
					centeredSlides: centeredslides,
					spaceBetween: spacebetween,
					/*pagination: {
				        el: '.swiper-pagination',
				        clickable: true,
				      },

					navigation: {
				        nextEl: '.swiper-button-next',
				        prevEl: '.swiper-button-prev',
				      },
					/*onInit: function(){
						jQuery( '#' + uniqId + '-next' ).css({ 'display': 'block' });
						jQuery( '#' + uniqId + '-prev' ).css({ 'display': 'block' });
					}
					
				}
			);
		});*/

	// Enables swiper slider.
		jQuery('.zpps-post-slider-swiper').each( function() {
			var swiper = null,
				uniqId = jQuery(this).data('uniq-id'),
				durationSpeed = parseFloat( jQuery(this).data('duration-speed') ),
				swiperLoop = jQuery(this).data('swiper-loop'),
				freeMode = jQuery(this).data('free-mode'),
				grabCursor = jQuery(this).data('grab-cursor'),
				mouseWheel = jQuery(this).data('mouse-wheel');


			var swiper = new Swiper( '#' + uniqId, {
					speed: durationSpeed,
					loop: swiperLoop,
					freeMode: freeMode,
					grabCursor: grabCursor,
					mousewheelControl: mouseWheel,
					paginationClickable: true,
					navigation: {
				        nextEl: '.swiper-button-next',
				        prevEl: '.swiper-button-prev',
				    },
					
				}
			);
		});

});

jQuery(window).load(function(){
	// Initiate Portfolio.
	initiate_isotope();

	var jQuerycontainer = jQuery('#zp_masonry_container');
	// Check pre-selected category.
	filter_item = jQuery('.zp_masonry_filter .option-set a.selected').attr('data-option-value');

	jQuerycontainer.isotope({
		 itemSelector : '.zp_masonry_item',
		 filter: filter_item
	});

});

// Refresh isotope on window resize.
jQuery( window ).resize(function() {
	initiate_isotope();
	
	var jQuerycontainer = jQuery('#zp_masonry_container');
	// Checks pre-selected category.
	filter_item = jQuery('.zp_masonry_filter .option-set a.selected').attr('data-option-value');

	jQuerycontainer.isotope({
		 itemSelector : '.zp_masonry_item',
		 filter: filter_item
	});

	// Mobile Menu.
	var windowWidth = jQuery(window).width();

	if( windowWidth <= 1024 ){
	    jQuery( '.mobile_menu' ).on( 'click', function(){
	        jQuery('.sliding_nav').addClass( 'sliding_open' );
	        jQuery(this).addClass('mobile_menu_close');      
	    });

	    jQuery( '.sliding_close' ).click(function(){
	        jQuery('.sliding_nav').removeClass( 'sliding_open' );
	        jQuery('.mobile_menu').removeClass('mobile_menu_close');
	    });
	}else{
		jQuery( '.mobile_menu' ).on( 'click', function(){			
			if(jQuery(this).hasClass( 'zp_close' ) ){
				jQuery(this).removeClass('zp_close');
				//jQuery( '.zp_before_header_nav nav.nav-primary' ).removeClass( 'menu_slideIn' ).css({"overflow":"hidden"});
				jQuery('.zp_before_header_nav nav.nav-primary').removeClass('menu_slideIn');
				jQuery( '.zp_before_header_nav nav.nav-primary ul.menu.genesis-nav-menu' ).animate({
					    'left': '-100%'
					}, 500 );
			}else{
				jQuery(this).addClass('zp_close');
				//jQuery( '.zp_before_header_nav nav.nav-primary' ).addClass( 'menu_slideIn' ).delay(5000).css({"overflow":"visible"});

				jQuery( '.zp_before_header_nav nav.nav-primary ul.menu.genesis-nav-menu' ).animate({
					    'left': '0'
					}, 500, function() {
					   jQuery('.zp_before_header_nav nav.nav-primary').addClass('menu_slideIn');
				});
			}		
		});
	}
	
});
