var listing_product = {}

$(document).ready(function(){ 
	var original_img = $('.parent_thumb').attr('src');
	$('.child_thumb').hover(
        function(){ 
        	var newParent = $(this).attr('src');
        	newParent = newParent.replace('/100/', '/300/');
        	$('.parent_thumb').attr('src', newParent);
			$('.parent_thumb').show(250); //.fadeIn(250)
        },
        function(){
        	if(original_img != undefined) {
        		var original_img = original_img.replace('/100/', '/300/');
            	$('.parent_thumb').attr('src', original_img);
            	$('.parent_thumb').hide(250); //.fadeOut(205)
        	}
        	
        }
    ); 
	$('#listing-buynow-button').click(function(e){ 
		e.preventDefault();
		
		var listing_id = $(this).attr('value');
		var csrfTokenName = $(this).attr('token_name');
		var csrfTokenValue = $(this).attr('token_value');
		//alert(csrfTokenValue);
		listing_product.buynow(listing_id, csrfTokenName, csrfTokenValue);
	});
});

listing_product.buynow = function(listing_id, csrfTokenName, csrfTokenValue){
	
	var request = $.ajax({
	    url: "/listings/buynow/"+listing_id,
	    type: "POST",
		data: { listing_id:listing_id, karateToken:csrfTokenValue },
		dataType: "json"
	});
			 
	request.done(function( msg ) { 
		if(msg.status == 'FAILURE'){
			//console.log('test');
			
			$('#myLegacy').modal('show')
		}else{ 
			$('#cart-items').html(msg.message);
			$('#buy_now_message').html(msg.message+' <a href="/shoppingcart/index/'+listing_id+'" class="btn btn-primary btn-sm">Check Out</a>');
		}		
	});
			 
	request.fail(function( jqXHR, textStatus ) {
		console.log( "Request failed: " + textStatus );
	});
}