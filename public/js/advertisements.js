var advertisements = {}

$(document).ready(function(){
	
	$('.admin_add_advertisement_button').click(function(e){
		e.preventDefault(); 		
		$.ajax({
			  type: "post",
			  url: "/admin/products/advertisementsform",
			  dataType: 'html',
			  data: { listing_id: $(this).attr('id'),karateToken: $('input[name=karateToken]').val() }
			})	
	    
	    .done(function( data ) { 
	      $('#advertisementsModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});
	
	$('.admin_payments_button').click(function(e){ 
		e.preventDefault();
		
		$.ajax({
			  type: "post",
			  url: "/admin/products/paymentsform",
			  dataType: 'html',
			  data: { advertisement_id: $(this).attr('id'),karateToken: $('input[name=karateToken]').val() }
			})	
	    
	    .done(function( data ) { 
	      $('#advertisementsModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});
	
	
	
	$('.delete_button').click(function(e){
		e.preventDefault();
		var uri = $(this).attr('href');
		
		$('#confirm_yes').click(function(e){
			//console.log(uri)
			$.ajax({
				  type: "get",
				  url: uri,
				  dataType: 'html',
				  //data: { product_id: $('#product_id').val(), username: $('#username').val(), message: $('#chat_send').val(), karateToken: $('input[name=karateToken]').val() }
				})		
			.done(function(data) { //console.log(data)
				location.href="/administrator/listings";
			})
			.fail(function() {
				console.log( "error" );
			});
		});
		$('#confirm_no').click(function(e){
			$('modalConfirm').hide();
		});		
	});
});