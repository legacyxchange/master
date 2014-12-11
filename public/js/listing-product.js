$(document).ready(function(){ 
	$('#listing-buynow-button').click(function(e){
		e.preventDefault();
		
		var listing_id = $(this).attr('value');
		
	    $.ajax( "/listings/buynow/"+listing_id)
	    .done(function( data ) { 
	      $('#cart-items').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});
});