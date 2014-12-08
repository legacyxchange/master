var lightbox = {}

lightbox.html = "<div id='lightbox' class='modal fade'>" +
"<div class='modal-dialog'>" +
"<div class='modal-content'>" +
"<div class='modal-body'></div>" +
"</div> <!-- .modal-content -->" +
"</div> <!-- .modal-dialog -->" +
"</div> <!-- .modal -->";

$(function() {
	if (!$('#lightbox').exists())
	{
		$('body').append(lightbox.html);
		//console.log('load lightbox');
	}
});


lightbox.showLightbox = function(location, file)
{
	$('#lightbox .modal-body').html("<img src='/public/uploads/locationImages/" + location + "/" + file + "'>");

	// gets image width
	var imgWidth = $('#lightbox img').width();
	
	console.log(imgWidth);

	$('#lightbox').modal('show');
}