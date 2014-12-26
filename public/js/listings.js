$(document).ready(function(){
	$('.edit_button').click(function(e){
		e.preventDefault();
		var listing_id = $(this).attr('listing_id');
		
	    $.ajax( "/administrator/listings/listingsform/"+listing_id)
	    .done(function( data ) { console.log(data)
	      $('#listingsModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});
	
	$('.admin_edit_button').click(function(e){
		e.preventDefault();
		var listing_id = $(this).attr('listing_id');
		
	    var request = $.ajax({
		  url: "/admin/listings/listingsform/"+listing_id,
		  type: "GET",
		  dataType: "html"
		});
		 
		request.done(function( msg ) {
		  //console.log( msg );
		  $('#listingsModal .modal-content').html(msg);
		});
		 
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
	$('.admin_add_new_butt').click(function(e){
		e.preventDefault();
		
	    $.ajax("/admin/listings/listingsform")
	    .done(function( data ) { 
	      $('#listingsModal .modal-content').html(data);
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
				location.href="/admin/listings";
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