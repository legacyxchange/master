jQuery(document).ready(function($) {
	'use strict';
	
	function picker(){
    'use strict';
	
			// Style Switcher	
			
			jQuery('#color-picker').animate({
				left: '-80px'
			});
			
			jQuery('#color-picker h3 a').click(function(e){
				e.preventDefault();
				var div = jQuery('#color-picker');
				if (div.css('left') === '-80px') {
					jQuery('#color-picker').animate({
						left: '0px'
					}); 
				} else {
					jQuery('#color-picker').animate({
						left: '-80px'
					});
				}
			});
			
			jQuery('.colors li a').click(function(e){
				e.preventDefault();
				jQuery(this).parent().parent().find('a').removeClass('active');
				jQuery(this).addClass('active');
			});
	}		
		picker();
});