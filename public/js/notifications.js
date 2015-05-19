var notifications = {}

$(document).ready(function(){
	setInterval(function(){
		
	
	$.get("/notifications", function (data) { 
    	$('.notifications_container').html(data);
    }, 'html'); 
	
	}, 1000);
});

notifications.archive = function(_notification_id){
	
	$.get("/notifications/archive", {notification_id:_notification_id}, function (data) { 
		$('#alert-s').show();
		$('#alert-s').html('You successfully archived the item.');
		setInterval(function(){
			$('#alert-s').hide();
			$('#alert-s').html('');
		}, 5000);
    }, 'json'); 
}

notifications.display = function(){
	$.get("/notifications/last", function (data) { 
    	$('.notifications_container').html(data);
    	
    	
    }, 'html'); 
}