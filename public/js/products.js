var products = {}

products.submitForm = function(){
	var product_id = $('.admin_edit_button').attr('id');
	//var formData = $('#product_edit_form').serialize();
	//formData.append('&userfile='+$('#userfile').val());
	console.log(product_id)
	/*$.ajax({
		  type: "POST",
		  url: "/admin/products/edit/"+product_id,
		  data:  formData 
	})
    .done(function( data ) { console.log(data)
    	
      //$('#productsModal .modal-content').html(data);
    })
    .fail(function() { 
        alert( "error" );
    })*/
	//return false;
}

$(document).ready(function(){
	$('.administrator_edit_button').click(function(e){
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
	$('.administrator_add_new_butt').click(function(e){
		e.preventDefault();
		
	    $.ajax( "/administrator/products/productsform")
	    .done(function( data ) { //console.log(data)
	      $('#productsModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});
	$('.admin_edit_button').click(function(e){//console.log(this)
		e.preventDefault(); 
		var product_id = $(this).attr('id');
		
	    $.ajax( "/admin/products/productsform/"+product_id)
	    .done(function( data ) { //console.log(data)
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
	$('#product_edit_form').hover(function(e){
		e.preventDefault();
		alert('ajax');
	    /*$.ajax( "/admin/products/productsform")
	    .done(function( data ) { //console.log(data)
	      $('#productsModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })*/
	});
	$('.delete_button').click(function(e){ 
		e.preventDefault();
		$('#modalConfirm .modal-content').html('testing 123');
		var uri = $(this).attr('href');
		
		$('#confirm_yes').click(function(e){
			console.log(uri)
			$.ajax({
				  type: "get",
				  url: uri,
				  dataType: 'html',
				  //data: { product_id: $('#product_id').val(), username: $('#username').val(), message: $('#chat_send').val(), karateToken: $('input[name=karateToken]').val() }
				})		
			.done(function(data) { //console.log(data)
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