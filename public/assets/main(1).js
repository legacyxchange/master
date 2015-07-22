jQuery(document).ready(function($) {
	'use strict';
/* ==================================================
				Preload
================================================== */
function preload(){
    'use strict';
    jQuery('.loader').delay(500).fadeOut("slow");
}
/* ==================================================
				Back To top
================================================== */
function tops(){
    'use strict';
	jQuery(window).scroll(function(){
	if (jQuery(this).scrollTop() > 1) {
			jQuery('.top').css({bottom:"25px"});
		} else {
			jQuery('.top').css({bottom:"-100px"});
		}
	});
	jQuery('.top').click(function(){
		jQuery('html, body').animate({scrollTop: '0px'}, 800);
		return false;
	});
}
/* ==================================================
				Dropdown
================================================== */
function dropdown(){
	'use strict';
	jQuery('.navbar .dropdown').hover(function() {
		jQuery(this).addClass('didropdown').find('.dropdown-menu').first().stop(true, true).delay(100).slideDown();
	}, function() {
		var na = jQuery(this)
		na.find('.dropdown-menu').first().stop(true, true).delay(100).slideUp('fast', function(){ na.removeClass('extra-nav-class') })
	});

	jQuery('.dropdown-submenu').hover(function() {
		jQuery(this).addClass('extra-nav-class').find('.dropdown-menu').first().stop(true, true).delay(100).slideDown();
	}, function() {
		var na = jQuery(this)
		na.find('.dropdown-menu').first().stop(true, true).delay(100).slideUp('fast', function(){ na.removeClass('extra-nav-class') })
	});
}
/* ==================================================
				Parallax
================================================== */
function parallaxs(){
	'use strict';
	jQuery('#pall-home').parallax("50%", 0.6);
	jQuery('#pall-contact').parallax("50%", 0.6);
}
/* ==================================================
				Counter
================================================== */	
function appears(){
	'use strict';
	jQuery("#skill").appear(function(t){
	jQuery(".percentage").easyPieChart({
		animate:4e3,
		trackColor:"#fff",
		barColor:"#e64c66",
		scaleColor:false,
		lineCap:"butt",
		lineWidth:15,
		size:200,
		onStep:function(t,n,r){
			jQuery(this.el).find("span").text(Math.round(r))}
		})
		},
		{
		offset:"100%",
		triggerOnce:true
		});


	//circle progress bar
		var count = 0 ;
		var colors = ['#3399fe', '#e64c66', '#27ae60', '#8e44ad'];
		jQuery("#skill").appear(function(){
		jQuery('.percentage2').each(function(){
		jQuery(this).easyPieChart({
			barColor: colors[count],
			trackColor: '#343434',
			scaleColor: false,
			scaleLength: false,
			lineCap: 'butt',
			lineWidth: 15,
			size: 200,
			rotate: 0,
			animate: 4e3,
			onStep: function(from, to, percent) {
				jQuery(this.el).find('span').text(Math.round(percent))}
			});
			count++;
			if (count >= colors.length) { count = 0};
		})
		},
		{
		offset:"100%",
		triggerOnce:true
		});

/* ==================================================
				animate
================================================== */
	jQuery(".anim").appear(function(t){
		var n=jQuery(this).data("anim");
		jQuery(this).removeClass("transparent").addClass(n+" animated opaque")
	},
	{
		offset:"95%",
		triggerOnce:true
	});
}
/* ==================================================
				Hover Animate
================================================== */
function hovers(){
	'use strict';
	jQuery(".price-box-holder").hover(
		function () {
			jQuery(this).addClass("exclusive");
		}
		);
	jQuery(".price-box-holder").hover(
		function () {
			jQuery('.price-box-holder').removeClass("exclusive");
			jQuery(this).addClass("exclusive");
		}
	   );
	
	jQuery(".posting").hover(
		function () {
			jQuery(this).addClass("hover-active");
		}
	   );
	jQuery(".posting").hover(
		function () {
			jQuery('.posting').removeClass("hover-active");
			jQuery(this).addClass("hover-active");
		}
	   );
}
/* ==================================================
				Flexslider
================================================== */
function flexsliders(){
	'use strict';
	jQuery('#feature-flex').flexslider({			
            animation: "fade",
            directionNav: false,
            controlNav: false,
            pauseOnHover: true,
			slideshowSpeed:5000,
			animationSpeed:800,
            direction: "horizontal", //Direction of slides
            after: function (slider) {
                jQuery('.feature-list li').removeClass('active');
                jQuery('.feature-list li:eq(' + slider.currentSlide + ')').addClass("active");
            }
        });
		
	jQuery('.feature-list li').click(function () {
            jQuery('.feature-list li').removeClass('active');
            jQuery(this).addClass('active');
            jQuery('#feature-flex').flexslider(jQuery(this).index());
        });

        var $testiflex = jQuery('#feature-flex');
        jQuery('#flex-feature-next').click(function () {
            $testiflex.flexslider("next");
        });
        jQuery('#flex-feature-prev').click(function () {
            $testiflex.flexslider("prev");
        });	
/* ==================================================
				Blog
================================================== */
	jQuery('#flex-blog').flexslider({
            animation: "slide",
            directionNav: false,
            controlNav: false,
            pauseOnHover: true,
            slideshowSpeed: 4000,
            direction: "horizontal"
        });
/* ==================================================
				page-Blog
================================================== */
	jQuery('#flex-blog-page').flexslider({
            animation: "slide",
            directionNav: false,
            controlNav: false,
            pauseOnHover: true,
            slideshowSpeed: 4000,
            direction: "horizontal"
        });
		var $control = jQuery('#flex-blog-page');
			jQuery('#slidecontrol-next').click(function () {
				$control.flexslider("next");
			});
			jQuery('#slidecontrol-prev').click(function () {
				$control.flexslider("prev");
        });	
}
/* ==================================================
					Team
================================================== */
function team(){
	'use strict';
	jQuery(".button-slide1").click(function() {
		jQuery("#panel-detail1").slideToggle("slow");
		jQuery(this).toggleClass("active");
		return false;
	});
	jQuery(".button-slide2").click(function() {
		jQuery("#panel-detail2").slideToggle("slow");
		jQuery(this).toggleClass("active");
		return false;
	});
	jQuery(".button-slide3").click(function() {
		jQuery("#panel-detail3").slideToggle("slow");
		jQuery(this).toggleClass("active");
		return false;
	});
	jQuery(".button-slide4").click(function() {
		jQuery("#panel-detail4").slideToggle("slow");
		jQuery(this).toggleClass("active");
		return false;
	});
}
/* ==================================================
				accordion contact
================================================== */	
function toogles(){
	'use strict';	
	jQuery('#toggle-view li').click(function () {
		var text = jQuery(this).children('div.panel');
			jQuery('div.panel').slideUp('normal');	
		if (text.is(':hidden')) {
			text.slideDown('normal');
			jQuery(this).children('.ui-accordion-header').addClass('ui-accordion-header-active');		
		} else {
			text.slideUp('normal');
			jQuery(this).children('.ui-accordion-header').removeClass('ui-accordion-header-active');		
		}
			jQuery(this).next().slideDown('normal');
	});
}
/* ==================================================
				Portfolio
================================================== */
function mixitups(){
	'use strict';
	jQuery("#portfolio-grid").mixitup({
		targetSelector:".portfolio-block",
		filterSelector:".filter",
		effects:["fade"],
		easing:"snap"
	});
}
/* ==================================================
			Magnific
================================================== */
function magnificPopups(){
	'use strict';
        jQuery('.post-image').magnificPopup({type:'image'});
		jQuery('.post-video').magnificPopup({type:'iframe'});
}

	preload();
	tops();
	dropdown();
	parallaxs();
	hovers();
	appears();
	hovers();
	flexsliders();
	team();
	toogles();
	mixitups();
	magnificPopups();
});
/* ==================================================
				Counter
================================================== */
jQuery(document).ready(function($) {
	jQuery('.milestone-counter').appear(function() {
		jQuery('.milestone-counter').each(function(){
			dataperc = jQuery(this).attr('data-perc'),
			jQuery(this).find('.milestone-count').delay(6000).countTo({
            from: 0,
            to: dataperc,
            speed: 5000,
            refreshInterval: 100
        });
		});
	});
});