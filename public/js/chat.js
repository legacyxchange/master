/*$(document).ready(function(){ 
	$.ajax({
		  type: "GET",
		  url: '/chat/index/',
		  dataType: 'html' 
		})		
	.done(function(data) { //console.log(data)
		$('#chat').html(data);
	})
	.fail(function() {
		//console.log( "error" );
	});
	
	var prevHash = '';
	setInterval(function(){
		$.ajax({
			  type: "GET",
			  url: '/chat/ajax_chat/',
			  dataType: 'json' 
			})		
		.done(function(data) { //console.log(data)
			if(data.hash != prevHash && data.message != '' && data.username != '')
			    $('#inner_chat table').prepend('<tr><td><strong style="color:'+data.color+';">'+data.username+':</strong> '+data.message+'</td></tr>');
		
			prevHash = data.hash; 
		})
		.fail(function() {
			console.log( "error" );
		});
	}, 1000);
});

var chat = {}

chat.doAjax = function(){
	$.ajax({
		  type: "post",
		  url: '/chat/ajax_insert/',
		  dataType: 'html',
		  data: { user_id: $('#user_id').val(), username: $('#username').val(), message: $('#chat_send').val(), karateToken: $('input[name=karateToken]').val() }
		})		
	.done(function(data) { //console.log(data)
		$('#chat_send').val('');
	})
	.fail(function() {
		//console.log( "error" );
	});
}

chat.hideShow = function(){	
	if ( $( "#chat" ).is( ":hidden" ) ) {
	    $( "#chat" ).slideDown( "slow" );
	    $( "#chat_hide_show_button" ).html('HIDE CHAT');
	 } else {
	    $( "#chat" ).slideUp('slow');
	    $( "#chat_hide_show_button" ).html('SHOW CHAT');
	 }
}*/