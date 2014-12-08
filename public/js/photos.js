var photos = {}


photos.setPhotoModalMaxHeight = function ()
{
	var h = parseInt($(window).height());
	
	h -= 60; // removes 60 pixels to compensate for padding/margins
	
	photos.photoModalHeight = h;
	
	$('#photo-modal .modal-content').css('max-height', h + 'px');
	$('#photo-modal #photo-img').css('max-height', h + 'px');
	
	$('#photo-modal .info-col').css('max-height', (h + 30) + 'px');

	//$('#photo-modal .slimScrollDiv').html('');	
	//$('#photo-modal .slimScrollDiv').removeAttr('style');

}

photos.resetMaxHeights = function ()
{
	photos.photoModalMaxHeight = 0;
	photos.photoModalHeight = 0;

	$('#photo-modal #photo-img').attr('src', '');

	$('#photo-modal .modal-content').css('max-height', '');
	$('#photo-modal #photo-img').css('max-height', '');
	
	$('#photo-modal .img-bg').css('min-height', '');
	$('#photo-modal .info-col').css('max-height', '');
	
	$('#photo-modal #photo-info-display').html('');

	$('#photo-modal #photo-info-display').css('height', '');
}

photos.setPhotoBgHeight = function ()
{
	var h = $('#photo-modal').find('.modal-dialog').height();
	
	photos.photoModalHeight = h;
	//console.log("H: " + h);
	
	//$('#photo-modal .img-bg').height(h);
	$('#photo-modal .img-bg').css('min-height', h + 'px');
	$('#photo-modal #photo-info-display').css('height', h + 'px');
	
	
}

photos.photoCommentEnter = function ()
{
	$(window).unbind('keypress');

	$(window).bind('keypress', function(e){
		var code = e.keyCode || e.which;
		
		if (code == 13)
		{
			photos.savePhotoComment();
		}
	});
}


