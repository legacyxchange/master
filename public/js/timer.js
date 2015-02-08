$(document).ready(function(){	
	setInterval(function() {
		$('.timer').each(function() {
			var timer_id = $(this).attr('id');
			var t = $(this);
			$.ajax('/timer/ajax_timer/'+timer_id)
			.done(function(data) {
				$(t).html(data);
        		if(data.indexOf('Expired') > 0){
        			setTimeout(function(){
        				location.href = '/';
        				console.log(data);
        			}, 20000);
        		}
			})
			.fail(function() {
				console.log( "error" );
			});
		});
	}, 1000);
});