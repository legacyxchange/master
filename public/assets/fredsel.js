jQuery(document).ready(function($) {
	'use strict';
/* ==================================================
				carouFredSel
================================================== */
function caroufredsels(){
	'use strict';
	jQuery('#home-slide ul').carouFredSel({
        auto: true,
        pagination: "#home-slide .pager",
        responsive: true,
        swipe: {
            onMouse: true,
            onTouch: true
        },
        scroll : {
            height: 'variable',
            fx: 'crossfade',
            easing: 'easeInSine'
        },
		items: {
			width: 100,
            height: 'variable',
            start: 0
        }
    });
	
	jQuery('#qt ul').carouFredSel({
        auto: false,
        pagination: "#qt .pager",
        responsive: true,
        swipe: {
            onMouse: true,
            onTouch: true
        },
        scroll : {
            height: 'variable',
            fx: 'uncover-fade',
            easing: 'easeInSine'
        },
		items: {
			width: 100,
            height: 'variable',
            start: 0
        }
    });
}
	
	caroufredsels();
});