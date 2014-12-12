$(document).ready(function(){
	$('.edit_button').click(function(e){
		e.preventDefault();
		var product_id = $(this).attr('id');
		
	    $.ajax( "/administrator/products/productsform/"+product_id)
	    .done(function( data ) { //console.log(data)
	      $('#productsModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});
	$('.add_new_butt').click(function(e){
		e.preventDefault();
		
	    $.ajax( "/administrator/products/productsform")
	    .done(function( data ) { //console.log(data)
	      $('#productsModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});
	$('.admin_edit_button').click(function(e){console.log(this)
		e.preventDefault(); 
		var product_id = $(this).attr('id');
		
	    $.ajax( "/admin/products/productsform/"+product_id)
	    .done(function( data ) { console.log(data)
	      $('#productsModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});
	$('.admin_add_new_butt').click(function(e){
		e.preventDefault();
		
	    $.ajax( "/admin/products/productsform")
	    .done(function( data ) { //console.log(data)
	      $('#productsModal .modal-content').html(data);
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
			.done(function(data) { console.log(data)
				location.href="/admin/products";
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