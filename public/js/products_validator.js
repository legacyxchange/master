var products = {}

$(document).ready(function(){
	$('.edit_button').click(function(e){ 
		e.preventDefault();
		var product_id = $(this).attr('id');
		
	    $.ajax("/administrator/products/productsform/"+product_id)
	    .done(function( data ) { console.log(data)
	      $('#productsModal .modal-content').html(data);
	    })
	    .fail(function() {
	        alert( "error" );
	    })
	});		
	$('.add_new_butt').click(function(e){
		e.preventDefault();
		
	    $.ajax("/administrator/products/productsform")
	    .done(function( data ) { console.log(data)
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
		//$('#modalConfirm .modal-content').html('testing 123');
		var uri = $(this).attr('href');
		
		$('#confirm_yes').click(function(e){
			console.log(uri)
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

function toggleAddon(target){
	if($(target).val() == 'on'){
		$( ".listing-addon" ).show( "slow");
	}else{
		$( ".listing-addon" ).hide( "slow");
	}
}

function doOriginal(obj){
    if(obj.value == '1'){
        $('#originalOption').show();
    }else{
    	$('#originalOption').hide();
    }
} 
function doOriginalPasscode(obj){                        
    if(obj.value == 'First Sale'){
    	$('#resellOption').hide();
        $('#firstSaleOption').show();
    }else if(obj.value == 'Re-Sell'){
    	$('#firstSaleOption').hide();
        $('#resellOption').show();
    }else{
    	$('#firstSaleOption').hide(); 
    	$('#resellOption').hide();
    } 
}
function updateHiddenFields(order_index, product_image_id){                       
	$('#order_index').val(order_index);
	$('#product_image_id').val(product_image_id);						                       
    $('#productform').submit();
}
function onetimefeetoggle(){
	
    if($('#onetimefee').is('hidden')){
        $('#onetimefee').show();
    }else{
        
		$('#onetimefee').hide();
    } 
}
$(document).ready(function(){
	//$('#videoupload_button').click(function(e){               			
		$.ajax({
			  type: 'get',
			  url: '/admin/products/checkFunds',
			  dataType: 'json',
			 //data: { product_id: $('#product_id').val(), username: $('#username').val(), message: $('#chat_send').val(), karateToken: $('input[name=karateToken]').val() }
			})		
		.done(function(data) { 
			console.log(data)
			if(data.status == 'FAILURE'){
				$('#onetimefee').show();
				
				$('#videoupload_button').hide();
				return false;
			}else if(data.status == 'FAILURE' && $('#video_showing').is('visible')){
				$('#onetimefee').hide();
				
				$('#videoupload_button').hide();
				return;
    		}else{
				$('#onetimefee').hide();
				$('#videoupload_button').show();
				
				return;
			}
		})
		.fail(function() {
			console.log( "error" );
		});
	});
//});

function testAjax(obj){
	
	$(obj).after('<div class="alert alert-danger">Error HERE!!!</div>');
}