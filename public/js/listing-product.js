var listing_product = {}

$(document).ready(function(){ 
	$('#listing-buynow-button').click(function(e){
		e.preventDefault();
		
		var listing_id = $(this).attr('value');
		var csrfTokenName = $(this).attr('token_name');
		var csrfTokenValue = $(this).attr('token_value');
		
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
			 
	request.done(function( msg ) { console.log(msg)
		if(msg.status == 'FAILURE'){
			console.log(msg);
			$('#loginModal').modal('show')
		}else{
			$('#cart-items').html(msg);
		}		
	});
			 
	request.fail(function( jqXHR, textStatus ) {
		console.log( "Request failed: " + textStatus );
	});
}